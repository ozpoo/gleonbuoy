<?php
/*
 * Template Name: 14
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
      if (abs(dx) < .3) dx = 0;
      if (abs(dy) < .3) dy = 0;
      wind.sub(createVector(dx, dy));
      rootn.add(createVector(.019*dx, .02*dy))
      push();
        for (let j = -MARGIN; j < height+MARGIN; j += ystep){
          beginShape(); //QUAD LINES
          for (let i = 0; i < (width+xstep); i += xstep) {
            let n = noise(rootn.x + .019*i, rootn.y + .02*j)///ystep);
            let tmpy = MARGIN * (n - 1) + j;
            vertex(i, height - tmpy);
          }
          endShape();
        }
      pop();

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
      dx = Math.floor(map(data[position][0], 55.85, 56.5, -10, 10));
      dy = Math.floor(map(data[position][1], 8.67, 9.28, -10, 10));
      MARGIN = Math.floor(map(data[position][2], 83.1, 88.9, 10, 100));
      position++;
    }

	</script>

<?php get_footer(); ?>
