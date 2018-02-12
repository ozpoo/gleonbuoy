<?php
/*
 * Template Name: 11
 * Template Post Type: post
 */

 get_header();  ?>

	<main role="main">

    <section class="visualization">
      <div id="canvas"></div>
    </section>

	</main>

	<script>

    var poop, palette, distance, flag;

    function setup() {
      canvas = createCanvas(canvasWidth, canvasHeight);
      canvas.parent("canvas");
      smooth();
      palette = [color("#42d1f4"), color("#a142f4"), color("#50217a"), color("#213e7a"), color("#f74a33"), color("#f2eccd")];
      distance = 10;
      flag = true;
      poop = new Array();
      for(var i = 0; i < 30; i++) {
        var D = new Dots(random(-150, 150), random(-150, 150));
        poop.push(D);
      }
    }

    function draw() {
      background(255);
      translate(width/2, height/2);
      for(var i  =0; i < poop.length; i++) {
        var dots1 = poop[i];
        dots1.display();
        dots1.update();
        for(var j = i+1; j < poop.length; j++) {
          var dots2 = poop[i];
          dots2.update();
          if(dist(dots1.location.x, dots1.location.y, dots2.location.x, dots2.location.y) < distance) {
            for(var k=j+1; k < poop.length; k++) {
              var dots3 = poop[i];
              dots3.update();
              if(flag) {
                fill(palette[dots3.c], 50);
                noStroke();
              } else {
                noFill();
                stroke(255,50);
              }
              if(dist(dots3.location.x, dots3.location.y, dots2.location.x, dots2.location.y) < distance) {
                  beginShape();
                    vertex(dots3.getX(), dots3.getY());
                    vertex(dots2.getX(), dots2.getY());
                    vertex(dots1.getX(), dots1.getY());
                    noLoop();
                  endShape(CLOSE);
              }
            }
          }
        }
      }
    }

    function keyPressed() {
      flag=!flag;
    }

    function Dots(x, y) {
      this.location = createVector(x, y);
      this.c = parseInt(random(palette.length));
      this.xt = random(-0.01, 0.01);
      this.yt = random(-0.01, 0.01);
      this.velocity = createVector(this.xt, this.yt);
      this.radius = 200;

      this.display = function() {
        fill(palette[this.c]);
        noStroke();
        ellipse(this.location.x, this.location.y, 2, 2);
      }

      this.update = function() {
        if(dist(this.location.x, this.location.y, 0, 0) > this.radius) {
          this.velocity.mult(-1);
          this.location.add(this.velocity);
        } else {
          this.location.add(this.velocity);
        }
      }

      this.getX = function() {
        return this.location.x
      }

      this.getY = function() {
        return this.location.y
      }
    }

	</script>

<?php get_footer(); ?>
