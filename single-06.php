<?php
/*
 * Template Name: 06
 * Template Post Type: post
 */

 get_header();  ?>

	<main role="main">

    <section class="visualization">
      <div id="canvas"></div>
    </section>

	</main>

	<script>

    var theta;

    function setup() {
      init();
    }

    function init() {
      dom = document.getElementById("canvas");
      canvas = createCanvas(dom.offsetWidth, dom.offsetHeight);
      canvas.parent("canvas");
      smooth();
      theta = 0;
    }

    function draw() {
      theta+=.20;
      background(230);
      stroke("#2234C9");
      translate(width/2, height/2);
      noFill();
      var r=250;
      for (var i=-0.5*PI;i<PI+0.5*PI;i+=0.01*PI) {
        beginShape();
        for (var j=-sin(i)*r;j<sin(i)*r+sin(i);j+=sin(i)*20) {
          curveVertex(j, cos(i)*r+sin(theta-(j/40))*abs(i*10));
        }
        endShape();
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
