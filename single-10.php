<?php
/*
 * Template Name: 10
 * Template Post Type: post
 */

 get_header();  ?>

	<main role="main">

    <section class="visualization">
      <div id="canvas"></div>
    </section>

	</main>

	<script>

    var w, FRONT, SIDE, TOPP;
    var nRoot, nSpeed;

    function setup() {
      canvas = createCanvas(canvasWidth, canvasHeight, WEBGL);
      canvas.parent("canvas");
      stroke(0, 150);
      strokeWeight(1);
      w = 140;
      h = 65;
      d = 90;
      border = 10;
      nHeight = 30;
      def = 20;
      FRONT = 0;
      SIDE = 1;
      TOPP = 2;
      nRoot = createVector(random(123), random(123), random(123));
      nSpeed = createVector(random(-.1, .1), random(-.1, .1), random(-.1, .1));
    }

    function draw() {
      background(220);
      scale(2);
      rotateX(map(mouseY, 0, height, PI, -PI));
      rotateY(map(mouseX, 0, width, -PI, PI));
      nRoot.add(nSpeed);
      display(FRONT);
      display(SIDE);
      display(TOPP);
    }

    function display(p_face) {
      var n, a = 0, b = 0, c = 0, i, j;
      push();
      switch(p_face) {
      case FRONT:
        a = w;
        b = h;
        c = d;
        break;
      case SIDE:
        a = d;
        b = h;
        c = w;
        rotateY(HALF_PI);
        break;
      case TOPP:
        a = w;
        b = d;
        c = h;
        rotateX(HALF_PI);
        break;
      }
      for(var i = -a/2; i < a/2; i+=def) {
        for(var j = -b/2; j < b/2; j+=def) {
          n = noise(nRoot.x+i/100, nRoot.y+j/100, nRoot.z-c/2) - .5;

          if(abs(i) > a/2 - border) {
            n *= map(abs(i), a/2 - border, a/2, 1, 0);
          }
          if(abs(j) < b/2 - border) {
            n *= map(abs(j), b/2 - border, b/2, 1, 0);
          }
          beginShape(POINTS);
            vertex(i, j, c/2 + n*nHeight);
            vertex(i, j, -c/2 - n*nHeight);
          endShape();
        }
      }
      pop();
    }

	</script>

<?php get_footer(); ?>
