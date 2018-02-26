<?php
/*
 * Template Name: 02
 * Template Post Type: post
 */

 get_header();  ?>

	<main role="main">

    <section class="visualization">
      <div id="canvas"></div>
    </section>

	</main>

	<script>
    let xOffset, yOffset, offsetInc;
    let inc, s, m, dom, data, dx, dy;
    let tempLower, tempUpper, doLower, doUpper, dosLower, dosUpper, position;

    function setup() {
      init();
    }

    function init() {
      dom = document.getElementById("canvas");
      canvas = createCanvas(dom.offsetWidth, dom.offsetHeight);
      canvas.parent("canvas");
      blendMode(ADD);
      noFill();
      stroke(255, 255, 255, 15);
      smooth();
      background(25);
      xOffset = 0;
      yOffset = 0;
      offsetInc = 0.006;
      inc = 1;
      data = [];
      s = 1;
      m = 1.005;

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

      setBounds();
      incrementData();
    }

    function draw() {
      translate(width * 0.5, height * 0.5);
      if (s < 2000) {
        for (let nTimes = 0; nTimes < 10; nTimes++) {
          nPoints = int(2 * PI * s);
          nPoints = min(nPoints, 500);
          beginShape();
          for (let i = 0; i < nPoints; i++) {
            let a = i / nPoints * TAU;
            let p = p5.Vector.fromAngle(i / nPoints * TAU);
            let n = noise(xOffset + p.x * inc, yOffset + p.y * inc) * s;
            p.mult(n);
            vertex(p.x, p.y);
          }
          endShape(CLOSE);
          xOffset += offsetInc;
          yOffset += offsetInc;
          s *= m;
          incrementData();
        }
      }
    }

    function setBounds() {
      position = 0;
      tempLower = doLower = dosLower = 1000000000;
      tempUpper = doUpper = dosUpper = -1000000000;
      let dat = GLEON_DATA['post'][position];
      while(dat) {
        if(tempLower > dat['SurfaceTemperature'] && dat['SurfaceTemperature'].length != 0) {
          tempLower = dat['SurfaceTemperature'];
          console.log(dat['SurfaceTemperature']);
        }
        if(tempUpper < dat['SurfaceTemperature'] && dat['SurfaceTemperature'].length != 0) {
          tempUpper = dat['SurfaceTemperature'];
        }
        if(doLower > dat['DOatSurface'] && dat['DOatSurface'].length != 0) {
          doLower = dat['DOatSurface'];
        }
        if(doUpper < dat['DOatSurface'] && dat['DOatSurface'].length != 0) {
          doUpper = dat['DOatSurface'];
        }
        if(dosLower > dat['DOSatSurface'] && dat['DOSatSurface'].length != 0) {
          dosLower = dat['DOSatSurface'];
        }
        if(dosUpper < dat['DOSatSurface'] && dat['DOSatSurface'].length != 0) {
          dosUpper = dat['DOSatSurface'];
        }
        position++;
        dat = GLEON_DATA['post'][position];
      }
      position = 0;
      // console.log(tempLower);
      // console.log(tempUpper);
      // console.log(doLower);
      // console.log(doUpper);
      // console.log(dosLower);
      // console.log(dosUpper);
    }

    function incrementData() {
      if(!data[position]) {
        position = 0;
      }
      inc = map(data[position][0], 55.85, 56.5, 1, 6);
      offsetInc = map(data[position][1], 8.67, 9.28, 0.006, 0.03);
      dz = map(data[position][2], 83.1, 88.9, 1.2, 1.5);
      position++;
    }

    function windowResized() {
      resizeCanvas(dom.offsetWidth, dom.offsetHeight);
      init();
    }
	</script>

<?php get_footer(); ?>
