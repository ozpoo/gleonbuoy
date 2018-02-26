<?php
/*
 * Template Name: 11
 * Template Post Type: post
 */

 get_header();  ?>

	<main role="main">

    <section class="visualization">
      <div id="canvas"></div>
    </section>

	</main>

	<script>

    var resolution, rad, x, y;
    var t, tChange, nVal, nInt, nAmp, dom, loop;
    let frame_count, position, data, d1, d2;

    function setup() {
      dom = document.getElementById("canvas");
      canvas = createCanvas(dom.offsetWidth, dom.offsetHeight, WEBGL);
      canvas.parent("canvas");
      colorMode(RGB, 255, 255, 255, 1);
      noFill();
      stroke(255);
      strokeWeight(1);
      noiseDetail(8);
      resolution = 260; // how many points in the circle
      rad = 150;
      x = 1;
      y = 1;
      d1 = 0;
      d2 = 0;
      data = [];
      frame_count = 0;
      position = 0;
      t = 0; // time passed
      tChange = 0.02; // how quick time flies
      delta = 0.02;
      nVal; // noise value
      nInt = 1; // noise intensity
      nAmp = 1; // noise amplitude

      // Temperature, DO, DOS
      data.push([56.5, 9.28, 88.9]);  //0
      data.push([56.23, 9.06, 86.8]); //10
      data.push([56.23, 9.17, 87.1]); //16
      data.push([56.19, 8.67, 83.1]); //23
      data.push([56.16, 9.06, 86.8]); //30
      data.push([56.23, 8.83, 84.7]); //36
      data.push([56.17, 9.06, 86.8]); //43
      data.push([56.17, 8.95, 85.7]); //49
      data.push([56.21, 9.02, 86.5]); //56
      data.push([56.08, 8.84, 84.6]); //62
      data.push([56.15, 8.73, 85.6]); //69
      data.push([56.21, 9.02, 86.5]); //75
      data.push([55.85, 8.73, 86.5]); //82

      incrementData();
    }

    function draw() {
      background(25, 25, 25, 1);
      // nInt = map(mouseX, 0, width, 0.1, 30); // map mouseX to noise intensity
      // nAmp = map(mouseY, 0, height, 0.0, 1.0); // map mouseY to noise amplitude
      incVars();

      beginShape();
      for(var a = 0; a <= TWO_PI; a += TWO_PI / resolution) {
        nVal = map(noise( cos(a)*nInt+1, sin(a)*nInt+1, t ), 0.0, 1.0, nAmp, 1.0); // map noise value to match the amplitude
        x = cos(a)*rad *nVal;
        y = sin(a)*rad *nVal;
        vertex(x, y);
        }
      endShape(CLOSE);

      t += tChange;
      frame_count++;
      if(frame_count%100 == 0) {
        incrementData();
      }
    }

    function windowResized() {
      resizeCanvas(dom.offsetWidth, dom.offsetHeight);
    }

    function incrementData() {
      if(!data[position]) {
        position = 0;
      }
      d1 = Math.floor(map(data[position][0], 55.85, 56.5, 0.1, 120));
      d2 = Math.floor(map(data[position][1], 8.67, 9.28, -1.0, 1.0));
      d3 = Math.floor(map(data[position][2], 83.1, 88.9, 0, 400));
      position++;
    }

    function incVars() {
      if(nInt < d1) {
        nInt += delta;
      } else if(nInt > d1) {
        nInt -= delta;
      }

      if(nAmp < d2) {
        nAmp += delta;
      } else if(nInt > d2) {
        nAmp -= delta;
      }

      if(nInt == d1 && nAmp == d2) {
        incrementData();
      }
      console.log(nInt);
      console.log(nAmp);
    }

	</script>

<?php get_footer(); ?>
