<?php
/*
 * Template Name: 20
 * Template Post Type: post
 */

 get_header();  ?>

	<main role="main">

    <section class="visualization">
      <div id="canvas"></div>
    </section>

	</main>

	<script>

  var num, radious, locs, vels, threshold, goo;

    function setup() {
      canvas = createCanvas(canvasWidth, canvasHeight);
      canvas.parent("canvas");
      locs = new Array();
      vels = new Array();
      for(var i = 0; i < num; i++){
        locs.push(createVector(random(radious, width - radious), random(radious, height - radious)));
        vels.push(createVector(random(-10, 10), random(-10, 10)));
      }

      num = 5;
      radious = 50;
      threshold = 2.0;
      goo = 1.0;
    }

    function draw() {
      background(255);
      stroke(30);
      for(var h = 0; h < height; h++){
        for(var w = 0; w < width; w++){
          var p = createVector(w, h);
          var sum = 0.0;
          for(var i = 0; i < locs.length; i++){
            sum += radious / pow(locs[i].sub(p).mag(), goo);
          }
          if(sum > threshold){
            point(w, h);
          }
        }
      }
      for(var i = 0; i < num; i++){
        var loc = locs[i];
        var vel = vels[i];
        loc.add(vel);
        if(loc.x < radious){
          vel.x *= -1;
          locs.x += vel.x;
        }
        if(loc.x >= width - radious){
          vel.x *= -1;
          loc.x += vel.x;
        }
        if(loc.y < radious){
          vel.y *= -1;
          loc.y += vel.y;
        }
        if(loc.y >= height - radious){
          vel.y *= -1;
          loc.y += vel.y;
        }
      }
    }

	</script>

<?php get_footer(); ?>
