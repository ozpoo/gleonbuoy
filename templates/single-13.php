<?php
/*
 * Template Name: 13
 * Template Post Type: post
 */

 get_header();  ?>

	<main role="main">

    <section class="visualization">
      <div id="canvas"></div>
    </section>

	</main>

	<script>

  var circles, num, min, max, c;

    function setup() {
      canvas = createCanvas(canvasWidth, canvasHeight);
      canvas.parent("canvas");
      background(255);
      noStroke();
      circles = new Array();
      num = 250;
      min = 2;
      max = 100;
      c = new Circle(createVector(0, 0), random(min, max));
      circles.push(c);
    }

    function draw() {
      background(255);
      for(var i = 0; i < circles.length; i++){
        var c = circles[i];
        c.draw();
      }
      var newLoc = createVector(random(width/2-num, width/2+num), random(height/2-num, height/2+num));
      var newD = random(min, max);
      while(detectAnyCollision(circles, newLoc, newD)) {
        /* If the values do interect make new values. */
        newLoc = createVector(random(width/2-num, width/2+num), random(height/2-num, height/2+num));
        newD = random(min, max);
      }
      c = new Circle(newLoc, newD);
      if(circles.length < 10000){
        circles.push(c);
      }
    }

    function detectAnyCollision(circles, newLoc, newR) {
      for(var i = 0; i < circles.length; i++) {
        if (circles[i].detectCollision(newLoc, newR)) {
          return true;
        }
      }
      return false;
    }

    function Circle(loc, d) {
      this.loc = loc;
      this.d = d;

      this.draw = function() {
        var r = dist(loc.x, loc.y, width/2, height/2);
        var c = abs(cos(radians(r+frameCount)));
        var s = abs(sin(radians(r+frameCount)));
        fill((c-s)*255, c*255, s*255);
        if (r < num) {
          ellipse(loc.x, loc.y, d, d);
        }
      }

      this.detectCollision = function(newLoc, newD) {
        /*
         We must divide d + newD because they are both diameters. We want to find what both radius's values are added on.
         However without it gives the balls a cool forcefeild type gap.
         */
        return dist(loc.x, loc.y, newLoc.x, newLoc.y) < ((d + newD)/2);
      }
    }

	</script>

<?php get_footer(); ?>
