<?php
/*
 * Template Name: 15
 * Template Post Type: post
 */

 get_header();  ?>

	<main role="main">

    <section class="visualization">
      <div id="canvas"></div>
    </section>

	</main>

	<script>

    let data, position, dom, loop;

    function preload() {

    }

    function setup() {
      init();
    }

    function init() {
      dom = document.getElementById("canvas");
      canvas = createCanvas(dom.offsetWidth, dom.offsetHeight);
      canvas.parent("canvas");
      colorMode(RGB, 255, 255, 255, 1);
      data = new Array();
      position = 0;
      loop = true;
      frameRate(10);
      background(230);
      // Temperature, DO, DOS
      data.push([56.5, 9.28, 88.9]);  //0
      data.push([56.23, 9.06, 86.8]); //10
      data.push([56.23, 9.17, 87.1]); //16
      data.push([56.19, 8.67, 83.1]); //23
      data.push([56.16, 9.06, 86.8]); //30
      data.push([56.23, 8.83, 84.7]); //36
      data.push([56.17, 9.06, 86.8]); //43
      data.push([56.17, 8.95, 85.7]); //49
      data.push([56.21, 9.02, 86.5]); //56
      data.push([56.08, 8.84, 84.6]); //62
      data.push([56.15, 8.73, 85.6]); //69
      data.push([56.21, 9.02, 86.5]); //75
      data.push([55.85, 8.73, 86.5]); //82
    }

    function draw() {
      if(loop) {
        noStroke(0);
        fill(20, 20, 20, 0.3);
          push();
          translate(200, 200);
          beginShape();
          if(data[position]) {
            var x = map(data[position][0], 55.85, 56.5, 0, 600);
            var y = map(data[position][1], 8.67, 9.28, 0, 200);
            var z = map(data[position][2], 83.1, 88.9, 0, 80);
            ellipse(x, y, z)
            position++;
          } else {
            // clear();
            // position = 0;
            noLoop();
          }
          endShape();
        pop();
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
