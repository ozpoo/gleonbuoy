<?php
/*
 * Template Name: 12
 * Template Post Type: post
 */

 get_header();  ?>

	<main role="main">

    <section class="visualization">
      <div id="canvas"></div>
    </section>

	</main>

	<script>

  let dom, loop;

    function setup() {
      init();
    }

    function init() {
      dom = document.getElementById("canvas");
      canvas = createCanvas(dom.offsetWidth, dom.offsetHeight);
      canvas.parent("canvas");
      noStroke();
      noFill();
      strokeWeight(2);
      loop = true;
    }

    function draw() {
      if(loop) {
        clear();
        var radius = 200;
        var step = 10;
        for(var y = -radius + step / 2; y <= radius - step / 2; y += step){
          var wave = abs(pow(sin(y * 0.003 + frameCount * 0.1), 10));
          var wy = y - map(wave, 0, 1, -step, step);
          var X = sqrt(sq(radius) - sq(y)) * map(wave, 0, 1, 1, 1.1);
          var cRate = map(y, -radius + step / 2, radius + step / 2, 0, 1);
          // stroke(lerpColor(color(69, 189, 207), color(234, 84, 93), cRate));
          stroke("#2234C9");
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
