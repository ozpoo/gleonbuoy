<?php
/*
 * Template Name: 07
 * Template Post Type: post
 */

 get_header();  ?>

	<main role="main">

    <section class="visualization">
      <div id="canvas"></div>
    </section>

	</main>

	<script>

    var sX, sY, x, y;

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
      smooth();
      background(25, 25, 25, 1);
      sX = 1;
      sY = 1;
      x = 250;
      y = 250;
    }

    function draw() {
      if(frameCount % 500 == 0) {
        rect(-1, -1, width + 1, height + 1);
      }
      for(var a = 0; a < TWO_PI; a += 0.02) {
        push();
        translate(x, y);
        rotate(a);
        var r = 500 * pow(noise(cos(a), sin(a), frameCount * 0.01), 4);
        translate(r, r);
        line(0, 0, 0, 0);
        pop();
      }
      x += sX;
      y += sY;
      if(x < 0 || x > width || random(1) < 0.003) {
        sX = -sX;
      }
      if(y < 0 || y > height || random(1) < 0.003) {
        sY = -sY;
      }
    }

    function windowResized() {
      resizeCanvas(dom.offsetWidth, dom.offsetHeight);
      init();
    }

	</script>

<?php get_footer(); ?>
