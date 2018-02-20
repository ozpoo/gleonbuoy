<?php
/*
 * Template Name: 01
 * Template Post Type: post
 */

 get_header();  ?>

	<main role="main">

		<section class="visualization">
      <div id="canvas"></div>
    </section>

	</main>

	<script>

		let NB_FRAMES, NB, frame_count;
    let Objects, curSeed, dom;
    let $data;

		function setup() {
      init();
		}

    function init() {
      dom = document.getElementById("canvas");
      canvas = createCanvas(dom.offsetWidth, dom.offsetHeight);
      canvas.parent("canvas");
      colorMode(RGB, 255, 255, 255, 1);
      noFill();
      stroke(255);
      strokeWeight(1);
			noiseSeed(curSeed);
			randomSeed(1);
      smooth();
      NB_FRAMES = 200;
      NB = 10;
      frame_count = 0;
      Objects = [];
      curSeed = 11;
			for(let i = 0; i < NB; i++) {
				Objects[i] = new object(i);
			}
      // parseData();
    }

		function draw() {
			background(25, 25, 25, 1);
			let t = ((frame_count)%NB_FRAMES)/NB_FRAMES;
			for(let i=1;i<NB;i++) {
				Objects[i].draw();
			}
			frame_count++;
		}

    function windowResized() {
      resizeCanvas(dom.offsetWidth, dom.offsetHeight);
      init();
    }

    function activation(t) {
			return ((1-cos(2*PI*t))/2)**1;
		}

		function object(id) {
			this.id = id;
			this.draw = function() {
				let t = ((frame_count)%NB_FRAMES)/NB_FRAMES;
				let x0 = lerp(0,width,this.id/NB);
				theta = PI/2;
				let xx = x0;
				let yy = 0;
				let Nt = 75;
				let step = height/Nt;
				let turn = lerp(0,0.4,activation((this.id/NB+0*t)%1));
        push();
				beginShape();
				vertex(xx,yy);
				for(let i=0;i<=Nt;i++){
					theta += turn*sin(100*noise(1000)+2*PI*(15*noise(0.2*this.id/NB,0.02*i)+t));
					xx += step*cos(theta);
					yy += step*sin(theta);
					let xx2 = lerp(xx,x0,(i/Nt)*(i/Nt)*(i/Nt));
					let yy2 = lerp(yy,lerp(0,height-0,i/Nt),max((i/Nt),1-sqrt(i/Nt)));
					vertex(xx2,yy2);
				}
				endShape();
        pop();
			}
		}

    function parseData() {
      $data = GLEON_DATA;
      xmlDoc = $.parseXML( $data );
      $xml = $( xmlDoc ),
      $title = $xml.find( "title" );
    }
    console.log(GLEON_DATA);
	</script>

<?php get_footer(); ?>
