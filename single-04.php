<?php
/*
 * Template Name: 04
 * Template Post Type: post
 */

 get_header();  ?>

	<main role="main">

    <section class="visualization">
      <div id="canvas"></div>
    </section>

	</main>

	<script>

    let n, minRad, maxRad, nfAng, nfTime, body;

    function setup() {
      init();
    }

    function draw() {
      if(loop) {
        translate(width/2, height/2);
        beginShape();
        for (let i=0; i<n; i++) {
          let ang = map(i, 0, n, 0, TWO_PI);
          let rad = map(noise(i*nfAng, frameCount*nfTime), 0, 1, minRad, maxRad);
          let x = rad * cos(ang);
          let y = rad * sin(ang);
          curveVertex(x, y);
        }
        endShape(CLOSE);
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
      noFill();
      stroke(255, 15);
      n = 256;
      minRad = 50;
      maxRad = 600;
      nfAng = 0.01;
      nfTime = 0.005;
    }

	</script>

<?php get_footer(); ?>
