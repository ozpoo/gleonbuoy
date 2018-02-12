<?php
/*
 * Template Name: 17
 * Template Post Type: post
 */

 get_header();  ?>

 <style>
  body {
    background: #222;
    color: #fcfaf7;
  }
  a {
    color: #fcfaf7;
  }
 </style>

	<main role="main">

    <section class="visualization">
      <div id="canvas"></div>
    </section>

	</main>

	<script>

  var nb, d1, d2;

    function setup() {
      canvas = createCanvas(canvasWidth, canvasHeight, WEBGL);
      canvas.parent("canvas");
      noFill();
      strokeWeight(1);
      nb = 20;
      d1 = 220;
      d2 = 100;
    }

    function draw() {
      background("rgba(255, 255, 255, 0)");
      rotateX(map(mouseY, 0, height, PI, -PI));
      rotateY(map(mouseX, 0, width, -PI, PI));
      colorMode(HSB, nb);
      var r, x, y, t, fc = float(frameCount) / 40;
      for(var i = 0; i < nb; i++) {
        t = i * TWO_PI / nb;
        x = d2 * cos(t + fc);
        y = d2 * sin(t + fc);
        r = abs(d1 + x);
        stroke((sin(i*TWO_PI/nb)+1)*nb/5, nb*((sin(i*TWO_PI/nb)+2)/4 + .3), nb*((cos(i*TWO_PI/nb)+2)/4 + .1));
        push();
        translate(0, 0, y / 2);
        ellipse(0, 0, r, r);
        pop();
      }
    }

    function keyPressed(){
      if(keyCode == LEFT)
        d1 = max(10, d1-10);
      else if(keyCode == RIGHT)
        d1 = min(800, d1+10);
      else if(keyCode == DOWN)
        d2 = max(10, d2-10);
      else if(keyCode == UP)
        d2 = min(400, d2+10);
      else if(keyCode == 81)
        nb = max(10, nb-10);
      else if(keyCode == 87)
        nb = min(250, nb+10);
    }

	</script>

<?php get_footer(); ?>
