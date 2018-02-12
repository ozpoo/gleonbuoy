<?php
/*
 * Template Name: 18
 * Template Post Type: post
 */

 get_header();  ?>

	<main role="main">

    <section class="visualization">
      <div id="canvas"></div>
    </section>

	</main>

	<script>

    var resolution, rad, x, y = 1;
    var t, tChange, nVal, nInt, nAmp;

    function setup() {
      canvas = createCanvas(canvasWidth, canvasHeight, WEBGL);
      canvas.parent("canvas");
      noiseDetail(8);

      resolution = 260; // how many points in the circle
      rad = 150;
      x = 1;
      y = 1;
      t = 0; // time passed
      tChange = .02; // how quick time flies
      nVal; // noise value
      nInt = 1; // noise intensity
      nAmp = 1; // noise amplitude
    }

    function draw() {
      background("rgba(255, 255, 255, 0)");

      noFill();
      stroke(0);
      strokeWeight(1);
      nInt = map(mouseX, 0, width, 0.1, 30); // map mouseX to noise intensity
      nAmp = map(mouseY, 0, height, 0.0, 1.0); // map mouseY to noise amplitude

      beginShape();
      for(var a = 0; a <= TWO_PI; a += TWO_PI / resolution) {

        nVal = map(noise( cos(a)*nInt+1, sin(a)*nInt+1, t ), 0.0, 1.0, nAmp, 1.0); // map noise value to match the amplitude
        x = cos(a)*rad *nVal;
        y = sin(a)*rad *nVal;
        vertex(x, y);

        }
      endShape(CLOSE);

      t += tChange;
    }

	</script>

<?php get_footer(); ?>
