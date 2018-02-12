<?php
/*
 * Template Name: 19
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
      canvas = createCanvas(window.innerWidth, window.innerHeight);
      canvas.parent("canvas");
    }

    function draw() {
      line(mouseX, mouseY, width*.5, height*.5);
    }

    function windowResized() {
      resizeCanvas(window.innerWidth, window.innerHeight);
    }

	</script>

<?php get_footer(); ?>
