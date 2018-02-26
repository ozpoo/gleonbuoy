<?php
/*
 * Template Name: 14
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

    let xstep, ystep, y, frame_count, dx, dy, MARGIN;
    let nx, ny, nz, body, data, wind;
    let sWeight;
    let dom, domGrad, position, gposition, temp, tempLower, tempUpper;

    function setup() {
      init();
    }

    function init() {
      dom = document.getElementById("canvas");
      domGrad = document.getElementById("gradient-container");
      canvas = createCanvas(dom.offsetWidth, dom.offsetHeight);
      canvas.parent("canvas");
      colorMode(RGB, 255, 255, 255, 1);
      noFill();
      stroke(255);
      strokeWeight(1);
      smooth();
      wind = createVector(0, 0);
			rootn = createVector(random(123456), random(123456));
      xstep = 20;
      ystep = 40;
      frame_count = 0;
      position = 0;
      gposition = 0;
      temp = [];
      y = 0;
      nx = random(100);
      ny = random(100);
      nz = random(1000);
      data = [];

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

      setBounds();
      incrementData();
      incrementGradient();
      setSize();
    }

    function draw() {
      // background(25, 25, 25, 1);
      clear();
      if (abs(dx) < .3) dx = 0;
      if (abs(dy) < .3) dy = 0;
      wind.sub(createVector(dx, dy));
      rootn.add(createVector(.019*dx, .02*dy))
      push();
        for (let j = -MARGIN; j < height+MARGIN; j += ystep){
          beginShape(); //QUAD LINES
          for (let i = 0; i < (width+xstep); i += xstep) {
            let n = noise(rootn.x + .019*i, rootn.y + .02*j)///ystep);
            let tmpy = MARGIN * (n - 1) + j;
            vertex(i, height - tmpy);
          }
          endShape();
        }
      pop();

      if(frame_count++ % 100 == 0) {
        incrementData();
        incrementGradient();
      }
    }

    function windowResized() {
      resizeCanvas(dom.innerWidth, dom.innerHeight);
      init();
    }

    function incrementData() {
      if(!data[position]) {
        position = 0;
      }
      dx = Math.floor(map(data[position][0], 55.85, 56.5, -10, 10));
      dy = Math.floor(map(data[position][1], 8.67, 9.28, -10, 10));
      MARGIN = Math.floor(map(data[position][2], 83.1, 88.9, 10, 100));
      position++;
    }

    function incrementGradient() {
      let dat = GLEON_DATA['post'][gposition];
      if(!dat) {
        gposition = 0;
        dat = GLEON_DATA['post'][gposition];
      }
      temp[0] = Math.floor(map(dat['SurfaceTemperature'], tempLower, tempUpper, 0, 40));
      temp[1] = Math.floor(map(dat['Temperatureat40ft'], tempLower, tempUpper, 0, 40));
      temp[2] = Math.floor(map(dat['Temperatureat16ft'], tempLower, tempUpper, 0, 40));
      temp[3] = Math.floor(map(dat['Temperatureat23ft'], tempLower, tempUpper, 0, 40));
      temp[4] = Math.floor(map(dat['Temperatureat30ft'], tempLower, tempUpper, 0, 40));
      temp[5] = Math.floor(map(dat['Temperatureat36ft'], tempLower, tempUpper, 0, 40));
      temp[6] = Math.floor(map(dat['Temperatureat43ft'], tempLower, tempUpper, 0, 40));
      temp[7] = Math.floor(map(dat['Temperatureat49ft'], tempLower, tempUpper, 0, 40));
      temp[8] = Math.floor(map(dat['Temperatureat56ft'], tempLower, tempUpper, 0, 40));
      temp[9] = Math.floor(map(dat['Temperatureat62ft'], tempLower, tempUpper, 0, 40));
      temp[10] = Math.floor(map(dat['Temperatureat69ft'], tempLower, tempUpper, 0, 40));
      temp[11] = Math.floor(map(dat['Temperatureat75ft'], tempLower, tempUpper, 0, 40));
      temp[12] = Math.floor(map(dat['Temperatureat82ft'], tempLower, tempUpper, 0, 40));
      gposition++;
      addGradient();
    }

    function setSize() {
      resizeCanvas(dom.offsetWidth, dom.offsetHeight);
      domGrad.style.height = dom.offsetHeight + "px";
      domGrad.style.width = dom.offsetWidth + "px";
    }

    function addGradient() {
      let grad = [];
      for(let i = 0; i < temp.length; i+=3) {
        if(temp[i]) {
          let color = tinycolor("rgba (255, 40, 120, 1)").lighten(10);
          grad[i] = color.spin(temp[i]);
          console.log(temp[i]);
        }
      }
      let gradient = getCssValuePrefix() + "linear-gradient(";
      for(let i = 0; i < grad.length; i+=3) {
        // console.log(g);
        gradient += grad[i].toString() + ", ";
      }
      gradient = gradient.slice(0, -2);
      gradient += ")";
      let newGrad = document.createElement("div");
      domGrad.appendChild(newGrad);
      newGrad.style.background = gradient;
      newGrad.classList.add("gradient");
      setTimeout(function(el){
        el.classList.add("show");
        setTimeout(function(){
          domGrad.removeChild(domGrad.children[0]);
        }, 1220);
      }, 20, newGrad);
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

    function setBounds() {
      gposition = 0;
      tempLower = doLower = dosLower = 1000000000;
      tempUpper = doUpper = dosUpper = -1000000000;
      let dat = GLEON_DATA['post'][gposition];
      while(dat) {
        if(tempLower > dat['SurfaceTemperature'] && dat['SurfaceTemperature'].length != 0) {
          tempLower = dat['SurfaceTemperature'];
        } else if(tempLower > dat['Temperatureat10ft'] && dat['Temperatureat10ft'].length != 0) {
          tempLower = dat['Temperatureat10ft'];
        } else if(tempLower > dat['Temperatureat16ft'] && dat['Temperatureat16ft'].length != 0) {
          tempLower = dat['Temperatureat16ft'];
        } else if(tempLower > dat['Temperatureat23ft'] && dat['Temperatureat23ft'].length != 0) {
          tempLower = dat['Temperatureat23ft'];
        } else if(tempLower > dat['Temperatureat30ft'] && dat['Temperatureat30ft'].length != 0) {
          tempLower = dat['Temperatureat30ft'];
        } else if(tempLower > dat['Temperatureat36ft'] && dat['Temperatureat36ft'].length != 0) {
          tempLower = dat['Temperatureat36ft'];
        } else if(tempLower > dat['Temperatureat43ft'] && dat['Temperatureat43ft'].length != 0) {
          tempLower = dat['Temperatureat43ft'];
        } else if(tempLower > dat['Temperatureat49ft'] && dat['Temperatureat49ft'].length != 0) {
          tempLower = dat['Temperatureat49ft'];
        } else if(tempLower > dat['Temperatureat56ft'] && dat['Temperatureat56ft'].length != 0) {
          tempLower = dat['Temperatureat56ft'];
        } else if(tempLower > dat['Temperatureat62ft'] && dat['Temperatureat62ft'].length != 0) {
          tempLower = dat['Temperatureat62ft'];
        } else if(tempLower > dat['Temperatureat69ft'] && dat['Temperatureat69ft'].length != 0) {
          tempLower = dat['Temperatureat69ft'];
        } else if(tempLower > dat['Temperatureat75ft'] && dat['Temperatureat75ft'].length != 0) {
          tempLower = dat['Temperatureat75ft'];
        } else if(tempLower > dat['Temperatureat82ft'] && dat['Temperatureat82ft'].length != 0) {
          tempLower = dat['Temperatureat82ft'];
        }

        if(tempUpper < dat['SurfaceTemperature'] && dat['SurfaceTemperature'].length != 0) {
          tempUpper = dat['SurfaceTemperature'];
        } else if(tempUpper < dat['Temperatureat10ft'] && dat['Temperatureat10ft'].length != 0) {
          tempUpper = dat['Temperatureat10ft'];
        } else if(tempUpper < dat['Temperatureat16ft'] && dat['Temperatureat16ft'].length != 0) {
          tempUpper = dat['Temperatureat16ft'];
        } else if(tempUpper < dat['Temperatureat23ft'] && dat['Temperatureat23ft'].length != 0) {
          tempUpper = dat['Temperatureat23ft'];
        } else if(tempUpper < dat['Temperatureat30ft'] && dat['Temperatureat30ft'].length != 0) {
          tempUpper = dat['Temperatureat30ft'];
        } else if(tempUpper < dat['Temperatureat36ft'] && dat['Temperatureat36ft'].length != 0) {
          tempUpper = dat['Temperatureat36ft'];
        } else if(tempUpper < dat['Temperatureat43ft'] && dat['Temperatureat43ft'].length != 0) {
          tempUpper = dat['Temperatureat43ft'];
        } else if(tempUpper < dat['Temperatureat49ft'] && dat['Temperatureat49ft'].length != 0) {
          tempUpper = dat['Temperatureat49ft'];
        } else if(tempUpper < dat['Temperatureat56ft'] && dat['Temperatureat56ft'].length != 0) {
          tempUpper = dat['Temperatureat56ft'];
        } else if(tempUpper < dat['Temperatureat62ft'] && dat['Temperatureat62ft'].length != 0) {
          tempUpper = dat['Temperatureat62ft'];
        } else if(tempUpper < dat['Temperatureat69ft'] && dat['Temperatureat69ft'].length != 0) {
          tempUpper = dat['Temperatureat69ft'];
        } else if(tempUpper < dat['Temperatureat75ft'] && dat['Temperatureat75ft'].length != 0) {
          tempUpper = dat['Temperatureat75ft'];
        } else if(tempUpper < dat['Temperatureat82ft'] && dat['Temperatureat82ft'].length != 0) {
          tempUpper = dat['Temperatureat82ft'];
        }
        gposition++;
        dat = GLEON_DATA['post'][gposition];
      }
      gposition = 0;
    }

	</script>

<?php get_footer(); ?>
