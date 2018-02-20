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
      colorMode(RGB, 255, 255, 255, 1);
      noFill();
      stroke(255);
      strokeWeight(1);
      smooth();
      xstep = 20;
      ystep = 20;
      y = 0;
      nx = random(100);
      ny = random(100);
      nz = random(1000);
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
    }

    function windowResized() {
      resizeCanvas(dom.innerWidth, dom.innerHeight);
      init();
    }

	</script>

<?php get_footer(); ?>
