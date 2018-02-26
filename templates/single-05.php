<?php
/*
 * Template Name: 05
 * Template Post Type: post
 */

 get_header();  ?>

	<main role="main">

    <section class="visualization">
      <div id="canvas"></div>
    </section>

	</main>

	<script>

    let xstep, ystep, y, frame_count, dx, dy, MARGIN;
    let nx, ny, nz, body, dom, data, position, wind;
    let sWeight;

    function setup() {
      init();
    }

    function init() {
      dom = document.getElementById("canvas");
      canvas = createCanvas(dom.offsetWidth, dom.offsetHeight);
      canvas.parent("canvas");
      colorMode(RGB, 255, 255, 255, 1);
      noFill();
      stroke(255);
      strokeWeight(1);
      smooth();
      wind = createVector(0, 0);
			rootn = createVector(random(123456), random(123456));
      xstep = 20;
      ystep = 40;
      frame_count = 0;
      position = 0;
      y = 0;
      nx = random(100);
      ny = random(100);
      nz = random(1000);
      data = [];

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
      for (let j = 0; height+ystep > j; j+=ystep) {
        beginShape();
        vertex(0, j);
        for (let i = 0; i < width+xstep; i+=xstep) {
          nx = i/234;
          ny = j/165;
          y = map(noise(nx, ny, nz), 0, 1, -100, 100)+j;
          curveVertex(i, y);
        }
        vertex(width, j);
        endShape();
      }
      nz+=.02;
      
      if(frame_count++ % 100 == 0) {
        incrementData();
      }
    }

    function windowResized() {
      resizeCanvas(dom.innerWidth, dom.innerHeight);
      init();
    }

    function incrementData() {
      if(!data[position]) {
        position = 0;
      }
      dx = Math.floor(map(data[position][0], 55.85, 56.5, 1, 10));
      dy = Math.floor(map(data[position][1], 8.67, 9.28, 1, 10));
      MARGIN = Math.floor(map(data[position][2], 83.1, 88.9, 10, 100));
      position++;
    }

	</script>

<?php get_footer(); ?>
