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

    let n, minRad, maxRad, nfAng, nfTime, dom;

    function setup() {
      init();
    }

    function init() {
      dom = document.getElementById("canvas");
      canvas = createCanvas(dom.offsetWidth, dom.offsetHeight);
      canvas.parent("canvas");
      background(25);
      noFill();
      stroke(255, 15);
      n = 256;
      minRad = 50;
      maxRad = 600;
      nfAng = 0.01;
      nfTime = 0.005;
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
      resizeCanvas(dom.offsetWidth, dom.offsetHeight);
      init();
    }

    function mousePressed() {
      // loop = !loop;
    }

	</script>

<?php get_footer(); ?>
