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
    let inc, s, m, body, loop;

    function setup() {
      init();
    }

    function draw() {
      if(loop) {
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
          }
        } else {
          loop = false;
        }
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
      canvas = createCanvas(window.innerWidth, window.innerHeight);
      canvas.parent("canvas");
      body = document.getElementsByTagName('body')[0];
      body.classList.add("dark");
      blendMode(ADD);
      noFill();
      stroke(255, 255, 255, 15);
      smooth();
      background(20);
      xOffset = 0;
      yOffset = 0;
      offsetInc = 0.006;
      inc = 1;
      s = 1;
      m = 1.005;
      body = document.getElementsByTagName('body')[0];
      loop = true;
    }
	</script>

<?php get_footer(); ?>
