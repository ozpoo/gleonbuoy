<?php
/*
 * Template Name: 07
 * Template Post Type: post
 */

 get_header();  ?>

	<main role="main">

    <section class="visualization">
      <div id="canvas"></div>
    </section>

	</main>

	<script>

    var w1;

    function setup() {
      canvas = createCanvas(window.innerWidth, window.innerHeight);
      canvas.parent("canvas");
      background(0);
      noStroke();
      noFill();
      w1 = new Wave(width/2, height/2, 1, 200, width);
    }

    function draw() {
      clear();
      background("rgba(255, 255, 255, 0)");
      w1.barwid = map(mouseX, 0, width, 5, 1);
      w1.maxhei = map(mouseY, 0, height, height, 1);
      w1.display();
      }
      //Wave Object
    function Wave(x, y, barwid, maxhei, amount) {
      //Initial Variables
      //Coords
      this.x = x;
      this.y = y;
      //Bar Properties
      this.maxhei = maxhei;
      this.amount = amount;
      this.barwid = barwid;
      //noStroke();
      rectMode(CENTER);
      //Display
      this.display = function() {
      for(this.i=0; this.i<this.amount; this.i++) {
          //Time in milliseconds/600 for smoothe transitions
          this.time = millis()/600;
          //Cycling colors depending on time
          this.r = map(sin(this.time+this.i/90), -1, 1, 0, 255);
          this.g = map(sin(this.time+22.5+this.i/90), -1, 1, 0, 255);
          this.b = map(sin(this.time+45+this.i/90), -1, 1, 0, 255);
          fill(this.r, this.g, this.b);
          //Hight depending on time and i
          this.hei = map(sin(this.i/90 + this.time), -1, 1, 0, this.maxhei);
          //Actual Draw
          strokeWeight(1);
          stroke(this.g, this.b, this.r);
          rect(this.x + this.i*this.barwid-this.amount*this.barwid/2, this.y, this.barwid+2, this.hei);
        }
      }
    }

    function windowResized() {
      resizeCanvas(window.innerWidth, window.innerHeight);
    }

	</script>

<?php get_footer(); ?>
