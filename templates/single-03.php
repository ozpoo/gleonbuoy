<?php
/*
 * Template Name: 03
 * Template Post Type: post
 */

 get_header();  ?>

	<main role="main">

    <section class="visualization">
      <div id="canvas"></div>
      <div id="gradient-container">
        <div></div>
      </div>
    </section>

	</main>

	<script>
    let background, v, w, position;
    let sx, sy, sz, nx, ny, nz, time, dt, ct;
    let dom, grad;

    function setup() {
      init();
    }

    function init() {
      dom = document.getElementById("canvas");
      grad = document.getElementById("gradient-container");
      background = tinycolor("rgba (255, 0, 0, 1)");
      addGradient();
      canvas = createCanvas(dom.offsetWidth, dom.offsetHeight);
      canvas.parent("canvas");
      colorMode(RGB, 255, 255, 255, 1);
      stroke(255, 255, 255, 1);
      strokeWeight(1);
      smooth();
      noFill();
      v = w = time = 0;
      sx = sy = sz = 0;
      nx = ny = nz = 0;
      interval = 20;
      dt = .5;
      ct = .5;
      data = new Array();
      position = 0;

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

      setSize();
    }

    function draw() {
      clear();
      if(sx == nx && sy == ny && sz == nz) {
        incrementData();
        incrementCoordinates();
      } else {
        incrementCoordinates();
      }
      drawWave();
      v -= 0.02;
      w += 0.04;
      time += dt;
    }

    function windowResized() {
      setSize();
      init();
    }

    function incrementData() {
      if(!data[position]) {
        position = 0;
      }
      nx = Math.floor(map(data[position][0], 55.85, 56.5, 0, 600));
      ny = Math.floor(map(data[position][1], 8.67, 9.28, 0, 200));
      nz = Math.floor(map(data[position][2], 83.1, 88.9, 0, 400));
      position++;
      addGradient();
    }

    function setSize() {
      resizeCanvas(dom.offsetWidth, dom.offsetHeight);
      grad.style.height = dom.offsetHeight + "px";
      grad.style.width = dom.offsetWidth + "px";
    }

    function incrementCoordinates() {
      if(sx != nx) {
        if(sx < nx) {
          sx += ct;
        } else {
          sx -= ct;
        }
      }
      if(sy != ny) {
        if(sy < ny) {
          sy += ct;
        } else {
          sy -= ct;
        }
      }
      if(sz != nz) {
        if(sz < nz) {
          sz += ct;
        } else {
          sz -= ct;
        }
      }
    }

    function drawWave() {
      push();
      beginShape();
      for(let x = 0; x < width; x += 1) {
        vertex(x, height/2+sy
        *sin(v+(x/map(sx,0,width/2,1,100)))
        *tan(w+(x/map(sy,0,width/2,100,400)))
        *sin(v+(x/map(sz,0,height/2,1,100)))
        );
      }
      endShape();
      pop();
    }

    function getCssValuePrefix() {
      var rtrnVal = '';//default to standard syntax
      var prefixes = ['-o-', '-ms-', '-moz-', '-webkit-'];
      // Create a temporary DOM object for testing
      var dom = document.createElement('div');
      for (var i = 0; i < prefixes.length; i++) {
        // Attempt to set the style
        dom.style.background = prefixes[i] + 'linear-gradient(#000000, #ffffff)';
        // Detect if the style was successfully set
        if (dom.style.background) {
          rtrnVal = prefixes[i];
        }
      }
      dom = null;
      delete dom;
      return rtrnVal;
    }

    function addGradient() {
      background.spin(Math.floor(Math.random() * 360) + 1).lighten(10);
      let g1 = tinycolor(background.toString());
      let g2 = tinycolor(background.toString());
      g2.spin(30);
      let gradient = getCssValuePrefix() + "linear-gradient("+g1.toString()+", "+g2.toString()+")";
      let newGrad = document.createElement("div");
      grad.appendChild(newGrad);
      newGrad.style.background = gradient;
      newGrad.classList.add("gradient");
      setTimeout(function(el){
        el.classList.add("show");
        setTimeout(function(){
          grad.removeChild(grad.children[0]);
        }, 1220);
      }, 20, newGrad);
    }

	</script>

<?php get_footer(); ?>
