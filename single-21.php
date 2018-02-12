<?php
/*
 * Template Name: 21
 * Template Post Type: post
 */

 get_header();  ?>

	<main role="main">

    <section class="visualization">
      <div id="canvas"></div>
    </section>

	</main>

	<script>

    function setup() {
      canvas = createCanvas(canvasWidth, canvasHeight);
      canvas.parent("canvas");
      noStroke();

      colorMode(RGB, 255, 255, 255, 1);

      noFill();
      strokeWeight(2);
    }

    function draw() {
      clear();
      var radius = 200;
      var step = 10;
      for(var y = -radius + step / 2; y <= radius - step / 2; y += step){
        var wave = abs(pow(sin(y * 0.003 + frameCount * 0.1), 10));
        var wy = y - map(wave, 0, 1, -step, step);
        var X = sqrt(sq(radius) - sq(y)) * map(wave, 0, 1, 1, 1.1);
        var cRate = map(y, -radius + step / 2, radius + step / 2, 0, 1);
        // stroke(lerpColor(color(69, 189, 207), color(234, 84, 93), cRate));
        stroke(20, 20, 20, 1);
        push();
        translate(width / 2, height / 2);
        beginShape();
        for(var x = -X; x <= X; x += 1){
          vertex(x, wy);
        }
        endShape();
        pop();
      }
    }

	</script>

<?php get_footer(); ?>
