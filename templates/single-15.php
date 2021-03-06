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

    // console.log(GLEON_DATA['post'][0]);

    let data, position, dom, loop;
    let tempLower, tempUpper, doLower, doUpper, dosLower, dosUpper;

    function preload() {

    }

    function setup() {
      init();
    }

    function init() {
      dom = document.getElementById("canvas");
      canvas = createCanvas(dom.offsetWidth, dom.offsetHeight);
      canvas.parent("canvas");
      data = new Array();
      loop = true;
      frameRate(10);
      colorMode(RGB, 255, 255, 255, 1);
      noFill();
      stroke(255);
      strokeWeight(1);
      background(25, 25, 25, 1);
      // Temperature, DO, DOS
      // data.push([56.5, 9.28, 88.9]);  //0
      // data.push([56.23, 9.06, 86.8]); //10
      // data.push([56.23, 9.17, 87.1]); //16
      // data.push([56.19, 8.67, 83.1]); //23
      // data.push([56.16, 9.06, 86.8]); //30
      // data.push([56.23, 8.83, 84.7]); //36
      // data.push([56.17, 9.06, 86.8]); //43
      // data.push([56.17, 8.95, 85.7]); //49
      // data.push([56.21, 9.02, 86.5]); //56
      // data.push([56.08, 8.84, 84.6]); //62
      // data.push([56.15, 8.73, 85.6]); //69
      // data.push([56.21, 9.02, 86.5]); //75
      // data.push([55.85, 8.73, 86.5]); //82
      setBounds();
    }

    function draw() {
      push();
      translate(200, 200);
      beginShape();
      var dat = GLEON_DATA['post'][position];
      // SurfaceTemperature
      // DOatSurface
      // DOSatSurface
      // console.log(dat);
      if(dat) {
        var x = map(dat['SurfaceTemperature'], tempLower, tempUpper, 0, 600);
        var y = map(dat['DOatSurface'], doLower, doUpper, 0, 600);
        var z = map(dat['DOSatSurface'], dosLower, dosUpper, 20, 80);
        ellipse(x, y, z)
        position++;
      } else {
        position=0;
        background(25, 25, 25, 1);
      }
      endShape();
      pop();
    }

    function windowResized() {
      resizeCanvas(dom.offsetWidth, dom.offsetHeight);
      init();
    }

    function setBounds() {
      position = 0;
      tempLower = doLower = dosLower = 1000000000;
      tempUpper = doUpper = dosUpper = -1000000000;
      let dat = GLEON_DATA['post'][position];
      while(dat) {
        if(tempLower > dat['SurfaceTemperature'] && dat['SurfaceTemperature'].length != 0) {
          tempLower = dat['SurfaceTemperature'];
          console.log(dat['SurfaceTemperature']);
        }
        if(tempUpper < dat['SurfaceTemperature'] && dat['SurfaceTemperature'].length != 0) {
          tempUpper = dat['SurfaceTemperature'];
        }
        if(doLower > dat['DOatSurface'] && dat['DOatSurface'].length != 0) {
          doLower = dat['DOatSurface'];
        }
        if(doUpper < dat['DOatSurface'] && dat['DOatSurface'].length != 0) {
          doUpper = dat['DOatSurface'];
        }
        if(dosLower > dat['DOSatSurface'] && dat['DOSatSurface'].length != 0) {
          dosLower = dat['DOSatSurface'];
        }
        if(dosUpper < dat['DOSatSurface'] && dat['DOSatSurface'].length != 0) {
          dosUpper = dat['DOSatSurface'];
        }
        position++;
        dat = GLEON_DATA['post'][position];
      }
      position = 0;
      // console.log(tempLower);
      // console.log(tempUpper);
      // console.log(doLower);
      // console.log(doUpper);
      // console.log(dosLower);
      // console.log(dosUpper);
    }

	</script>

<?php get_footer(); ?>
