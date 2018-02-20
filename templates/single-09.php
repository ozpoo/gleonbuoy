<?php
/*
 * Template Name: 09
 * Template Post Type: post
 */

 get_header();  ?>

	<main role="main">

    <section class="visualization">
      <div id="canvas"></div>
    </section>

	</main>

	<script>

    let dom;

    function setup() {
      init();
    }

    function init() {
      dom = document.getElementById("canvas");
      canvas = createCanvas(dom.offsetWidth, dom.offsetHeight);
      canvas.parent("canvas");
      colorMode(RGB, 255, 255, 255, 1);
      fill(255);
      noStroke();
      frameRate(10);
    }

    function draw() {
      background(25, 25, 25, 1);
      translate(width/2, height/2);
      drawRectWheel(80, 650, 1, 80, 55, 55);
    }

    function drawRectWheel(inDiam, outDiam, rectWidth, countOfRect, inDiamRndmz, outDiamRndmz) {
      inDiam /= 2;
      outDiam /= 2;
      var angle = 0;
      var xx, yy;
      var wdthBuf = outDiam - inDiam;
      var step = radians(360/countOfRect);

      while(angle < TWO_PI) {
        xx = cos(angle) * inDiam;
        yy = sin(angle) * inDiam;
        push();
        translate(xx, yy);
        rotate(angle);
        angle += step;
        var inDiamRndm  = random(0, inDiamRndmz);
        var outDiamRndm = random(-outDiamRndmz, 0);

        if(outDiamRndmz == 0) {
          rect(inDiamRndm, -rectWidth/2, wdthBuf - inDiamRndm, rectWidth);
        } else {
          rect(inDiamRndm, -rectWidth/2, wdthBuf + outDiamRndm - inDiamRndm, rectWidth);
        }
        pop();
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
