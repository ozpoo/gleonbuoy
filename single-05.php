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
    let nx, ny, nz, body, dom;

    function setup() {
      init();
    }

    function init() {
      dom = document.getElementById("canvas");
      canvas = createCanvas(dom.offsetWidth, dom.offsetHeight);
      canvas.parent("canvas");
      stroke(255);
      noFill();
      xstep = 5;
      ystep = 20;
      y = 0;
      nx = random(100);
      ny = random(100);
      nz = random(1000);
    }

    function draw() {
      if(loop) {
        background(25);
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
      resizeCanvas(dom.innerWidth, dom.innerHeight);
      init();
    }

    function mousePressed() {
      // loop = !loop;
    }
	</script>

<?php get_footer(); ?>
