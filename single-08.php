<?php
/*
 * Template Name: 08
 * Template Post Type: post
 */

 get_header();  ?>

	<main role="main">

    <section class="visualization">
      <div id="canvas"></div>
    </section>

	</main>

	<script>

    var city, num;

    function setup() {

      canvas = createCanvas(canvasWidth, canvasHeight, WEBGL);
      canvas.parent("canvas");
      noStroke();
      fill(250);

      city = new Array();
      num = 0;
      for (var x = -5; x <= 5; x++) {
        for (var z = -5; z <= 5; z++) {
          var r = random(0, 1);
          if (r > 0.3) {
            var d = abs(10-dist(x, 0, z, 0, 0, 0));
            city.push(new Building(createVector(x*35, 0, z*35), random(d-d/2, d+(d*d)/5)));
          }
        }
      }

    }

    function draw() {
      clear();
      background("rgba(255, 255, 255, 0)");
      rotateX(-radians(20));
      rotateY(radians(45+num));
      pointLight(255, 255, 255, -width, -height, -width);
      for (var i = 0; i < city.length; i++) {
        var b = city[i];
        b.draw();
      }
      num+=0.3;
    }

    function Building(loc, size) {
      this.loc  = loc;
      this.size = size*12;

      this.draw = function() {
        push();
        translate(loc.x, loc.y-num/2, loc.z);
        fill(constrain(size, 0, 255));
        box(20, num, 20);
        pop();
        // Animate growth
        if (num < size) {
          num+=map(size, 0, 200, 0.3, 4);
        }
      }
    }

	</script>

<?php get_footer(); ?>
