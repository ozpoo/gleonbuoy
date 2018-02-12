<?php
/*
 * Template Name: 15
 * Template Post Type: post
 */

 get_header();  ?>

	<main role="main">

    <section class="visualization">
      <div id="canvas"></div>
    </section>

	</main>

	<script>

    var black;

    function setup() {
      canvas = createCanvas(canvasWidth, canvasHeight);
      canvas.parent("canvas");
      black = color("#222222");
      frameRate(10);
      fill(black);
    }

    function draw() {
      clear();
      translate(width/2, height/2);
      drawRectWheel(80, 650, .2, 80, 55, 55);
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

	</script>

<?php get_footer(); ?>
