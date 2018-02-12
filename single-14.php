<?php
/*
 * Template Name: 14
 * Template Post Type: post
 */

 get_header();  ?>

	<main role="main">

    <section class="visualization">
      <div id="canvas"></div>
    </section>

	</main>

	<script>

  var maxCount, spacing, z, goldenAngle, positions, camRotx, camRoty;

    function setup() {
      canvas = createCanvas(canvasWidth, canvasHeight);
      canvas.parent("canvas");
      colorMode(HSB, 255);
      smooth(1);

      maxCount = 700;
      spacing = 10;
      z = 0;
      goldenAngle = 137.4;
      positions = new Array();
      camRotx = 0;
      camRoty = 0;

      // Create points.
      for(var num = 0; num < maxCount; num++) {
        var angle = num * goldenAngle;
        var r = spacing * sqrt(num);
        var x = r * cos(angle);
        var y = r * sin(angle);
        positions.push(createVector(x, y, z));
        z += 0.5;
        goldenAngle += 0.00002;
        spacing += 0.01;
      }
    }

    function draw() {
      background(15);

      var startColor = color(max(0, 200+sin(frameCount*0.05)*25), 235, 255);
      var endColor = color(max(0, 200+cos(frameCount*0.05)*25), 255, 255);

      translate(width/2, height/2, 50);

      for(var i = 0; i < positions.length; i++) {
        var perc = map(i, 0, positions.length, 0.0, 1.0);

        strokeWeight(lerp(0, 1, perc));
        var pointColor = lerpColor(startColor, endColor, perc);
        stroke(pointColor);

        push();

        var mult = lerp(0.1, 2, perc);
        rotate(radians(frameCount*mult));

        var pos = positions[i];
        var lastPos = pos;

        if(i > 0) {
          lastPos = positions[i-1];
        }

        line(pos.x, pos.y, lastPos.x, lastPos.y);

        if(i % 10 == 0) {
          strokeWeight(lerp(1, 10, perc));
          point(pos.x, pos.y, pos.z);
        }

        pop();
      }
    }

	</script>

<?php get_footer(); ?>
