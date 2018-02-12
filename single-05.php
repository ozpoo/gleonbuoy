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

    let xstep, ystep, y;
    let nx, ny, nz, body;

    function setup() {
      init();
    }

    function draw() {
      if(loop) {
        background(0);
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
        nz+=.01;
      }
    }

    function windowResized() {
      resizeCanvas(window.innerWidth, window.innerHeight);
      init();
    }

    function mousePressed() {
      loop = !loop;
    }

    function init() {
      body = document.getElementsByTagName('body')[0];
      canvas = createCanvas(window.innerWidth, window.innerHeight);
      canvas.parent("canvas");
      body.classList.add("dark");
      background(10);
      stroke(255);
      noFill();

      xstep = 5;
      ystep = 20;
      y = 0;

      nx = random(100);
      ny = random(100);
      nz = random(1000);
    }
	</script>

<?php get_footer(); ?>
