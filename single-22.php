<?php
/*
 * Template Name: 22
 * Template Post Type: post
 */

 get_header();  ?>

	<main role="main">

    <section class="visualization">
      <div id="canvas"></div>
    </section>

	</main>

	<script>

    var x, y, x2, y2, rad, rad2, dist, dist2;
    var deg, incr, yIn, rotateBy, ang;

    function setup() {
      canvas = createCanvas(canvasWidth, canvasHeight, WEBGL);
      canvas.parent("canvas");
      incr = 1; // numVerts = 360/incr
      rad = -20;
      rad2 = -160;
      dist = 500;
      dist2 = 550;
    }

    function draw() {
      noStroke();
      fill(10, 10);
      rect(0, 0, width, height);
      fill(random(0, 255), 255, 255);

      rotateBy += .003;
      push();
      // translate(width/2, height/2);
      rotate(rotateBy);
      deg = 0;
      while (deg <= 360) {
        deg += incr;
        ang = radians(deg);
        x = cos(ang) * (rad + (dist * noise(y/100, yIn)));
        y = sin(ang) * (rad + (dist * noise(x/80, yIn)));
        ellipse(x, y, 1.5, 1.5);
        x2 = sin(ang) * (rad2 + (dist2 * noise(y2/20, yIn)));
        y2 = cos(ang) * (rad2 + (dist2 * noise(y2/20, yIn)));
        ellipse(x2, y2, 1, 1);
      }
      yIn += .005;
      pop();
    }

	</script>

<?php get_footer(); ?>
