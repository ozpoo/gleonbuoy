<?php
/*
 * Template Name: 25
 * Template Post Type: post
 */

 get_header();  ?>

	<main role="main">

    <section class="visualization">
      <div id="canvas"></div>
    </section>

	</main>

	<script>

    let data, time, dr, dt, dtheta, black, loop;
    let rCurrent, rTween, delta, radius, driftScale, driftScaleTween, driftDelta;

    function preload() {

    }

    function setup() {
      canvas = createCanvas(window.innerWidth, window.innerHeight);
      canvas.parent("canvas");
      noStroke();

      colorMode(RGB, 255, 255, 255, 1);

      black = color(250, 250, 250, 1);
      data = new Array();
      time = 0;
      dr = 0.5;
      dt = 0.005;
      dtheta = 1;
      position = 0;
      rCurrent = rTween = 0;
      delta = .5;
      radius = 60;
      driftScale = 6;
      driftScaleTween = 6;
      driftDelta = .02;
      loop = true;

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

    function draw(){
      if(loop) {
        clear();
        if(rCurrent == rTween) {
          incrementData();
        }
        incrementColor();
        drawShape(rCurrent, 0, 255, 0.02);
        // drawRectWheel(240, 800, .5, 60, 120, 120);
      }
    }

    function drawShape(r, g, b, a) {
      time += dt;
      fill(r, g, b, a);
      push();
      translate(width/2, height/2);
      for(var r = 1; r < radius; r += dr){
        beginShape();
        for(var theta = 0; theta < 360; theta += dtheta){
          var drift = noise(r/radius * cos(radians(theta))+4, r/radius * sin(radians(theta))+4, time) * r * driftScale;
          vertex((r+drift) * cos(radians(theta)), (r+drift) * sin(radians(theta)));
        }
        endShape();
      }
      pop();
    }

    function drawRectWheel(inDiam, outDiam, rectWidth, countOfRect, inDiamRndmz, outDiamRndmz) {
      inDiam /= 2;
      outDiam /= 2;
      var angle = 0;
      var xx, yy;
      var wdthBuf = outDiam - inDiam;
      var step = radians(360/countOfRect);

      fill(20, 20, 20, 1);

      while(angle < TWO_PI) {
        xx = cos(angle) * inDiam;
        yy = sin(angle) * inDiam;
        push();
        translate(width/2, height/2);
        translate(xx, yy);
        rotate(angle);
        angle += step;
        var inDiamRndm  = random(0, inDiamRndmz);
        var outDiamRndm = random(-outDiamRndmz, 0);

        if(outDiamRndmz == 0) {
          rect(inDiamRndm, -rectWidth/2, wdthBuf - inDiamRndm, rectWidth);
        } else {
          rect(inDiamRndm, -rectWidth/2, wdthBuf + outDiamRndm - inDiamRndm, rectWidth);
        }
        pop();
      }
    }

    function windowResized() {
      resizeCanvas(window.innerWidth, window.innerHeight);
    }

    function mousePressed() {
      loop = !loop;
      console.log(loop);
    }

    function incrementData() {
      if(data[position]) {
        rTween = Math.floor(map(data[position][0], 55.85, 56.5, 0, 160));
        position++;
      } else {
        position = 0;
      }
      driftScaleTween = Math.floor(Math.floor(Math.random() * 8) + 1);
      console.log(driftScaleTween);
    }

    function incrementColor() {
      if(rCurrent < rTween) {
        rCurrent += delta;
      } else {
        rCurrent -= delta;
      }
      if(driftScale != driftScaleTween) {
        if(driftScale < driftScaleTween) {
          driftScale += driftDelta;
        } else {
          driftScale -= driftDelta;
        }
      }
    }

	</script>

<?php get_footer(); ?>
