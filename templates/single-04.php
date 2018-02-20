<?php
/*
 * Template Name: 04
 * Template Post Type: post
 */

 get_header();  ?>

	<main role="main">

    <section class="visualization">
      <div id="canvas"></div>
    </section>

	</main>

	<script>

    let n, minRad, maxRad, nfAng, nfTime, dom;
    let newIris, noiseScale, noiseStrength, overlayAlpha, irisAlpha;
    let strokeWidth, radius, rTemp, limit, timer;

    function setup() {
      init();
    }

    function init() {
      dom = document.getElementById("canvas");
      canvas = createCanvas(dom.offsetWidth, dom.offsetHeight);
      canvas.parent("canvas");
      newIris = new Array();
      noiseScale = 500;
      noiseStrength = 50;
      overlayAlpha = 0;
      irisAlpha = 255;
      strokeWidth = .3;
      radius = 100;
      rTemp = radius;
      limit = 200;
      timer = 0;
      smooth();
      background(25);
      for (var i = 0; i < newIris.length; i++) {
        newIris[i] = new Iris();
      }
    }

    function draw() {
      translate(width * 0.5, height * 0.5);
      fill(30, overlayAlpha);
      rect(-5, -5, width+10, height+10);

      if ( (timer = (timer + .5)) > limit - 20) {
        // this is for that quick fade at the end of a cycle
        fill(30, overlayAlpha + 40);
        rect(-5, -5, width+10, height+10);
      }

      // Animate Iris
      for (var i = 0; i < newIris.length; i++) newIris[i].drawIris(c1);

      // reset parameters every time 'limit' is hit
      if ( (timer = (timer + .5) % limit) == 0 ) {
        for (var i = 0; i < newIris.length; i++) {
          newIris[i].reDrawIt();
        }
      }
    }

    function windowResized() {
      resizeCanvas(dom.offsetWidth, dom.offsetHeight);
      init();
    }

    function Iris() {
      // x,y    = the current position
      // ox,oy  = the position, but slightly back in time
      // sx,sy  = start positions
      var x, y, ox, oy, sx, sy;

      var angle = 0, step;
      var NDo;
      var isOutside = false;
      step = 5;
      NDo = int(random(360));
      sx = width/2  + radius * cos(NDo);
      sy = height/2 + radius * sin(NDo);
      x = sx;
      y = sy;

      this.drawIris = function(cF) {
        // calculate angle which is based on noise
        // and then use it for x and y positions
        angle = noise(x / noiseScale, y / noiseScale) * noiseStrength;

        // write in the last value of x,y into ox,oy >> old x, old y
        // i need these values to display the line();
        ox = x;
        oy = y;

        // radius change for every cycle
        radius = rGen();

        // calculate new x and y position
        x += cos(angle) * step;
        y += sin(angle) * step;

        // what happens when x and y hit the outside
        if (x < -2) isOutside = true;
        else if (x > width + 2) isOutside = true;
        else if (y < -2) isOutside = true;
        else if (y > height + 2) isOutside = true;

        if (isOutside) {
          x = ox;
          y = oy;
        }

        // display it
        noFill();
        stroke(cF, irisAlpha);
        strokeWeight(strokeWidth);
        line(ox, oy, x, y);

        // return boolean to false for next cycle
        isOutside = false;
      }

      this.reDrawIt = function() {
        // background reset
        fill(30);
        rect(-5, -5, width+10, height+10);

        // new noise
        noiseScale = int(random(400, 700));
        noiseStrength = int(random(25,75));
        noiseDetail(int(random(1, 10)), 0.5);

        // parameters reset
        x = sx;
        y = sy;
        NDo = int(random(360));
        sx = width/2  + radius * cos(NDo);
        sy = height/2 + radius * sin(NDo);
        ox = x;
        oy = y;
      }
    }

    this.rGen = function() {
      var r = random(0.65, 1.5) * rTemp;
      return r;
    }

	</script>

<?php get_footer(); ?>
