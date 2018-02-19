<?php get_header(); ?>

	<main role="main">

		<section class="text-container">
			<div class="text">
				<h1>GLEON Buoy &mdash; Understand, Predict, and Communicate the Role and Response of Lakes in a Changing Global Environment</h1>
			</div>
		</section>

		<section class="three"></section>

		<section class="grid">
			<!-- <section>
				<?php get_template_part('loop'); ?>
				<?php get_template_part('pagination'); ?>
			</section> -->
		</section>

	</main>

	<script>

		( function ( $, root, undefined ) {
			$( function () {
				'use strict';

				var lastTime = (new Date()).getTime();
				var renderer, camera, scene, controls, ocean;
				var lastX, lastY, offsetLeft, offsetTop;

				// console.log(GLEON_DATA);

				$(window).load(function(){
					init();
					animate();
				});

				$(window).resize(function () {
					camera.aspect = $(window).width() / $(window).height();
					camera.updateProjectionMatrix();
					renderer.setSize($(window).width(), $(window).height());
				});

				function init() {
					$("body").mousemove(onMouseMove);

					scene = new THREE.Scene();
					camera = new THREE.PerspectiveCamera(55.0, $(window).width() / $(window).height(), 0.5, 300000);
					renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });

					renderer.setPixelRatio( window.devicePixelRatio );
					renderer.setSize( window.innerWidth, window.innerHeight );
					renderer.context.getExtension('OES_texture_float');
					renderer.context.getExtension('OES_texture_float_linear');

					// camera.position.set(450, 350, 450);
         camera.position.set(0, 0, 0);
					camera.lookAt(new THREE.Vector3());

					controls = new THREE.OrbitControls(camera, renderer.domElement);
					controls.userPan = false;
					controls.userPanSpeed = 0.0;
					controls.minDistance = 0;
					controls.maxDistance = 2000.0;
					controls.minPolarAngle = 0;
					controls.maxPolarAngle = Math.PI * 0.495;

					var gsize = 512;
					var res = 1024;
					var gres = res / 2;
					var origx = -gsize / 2;
					var origz = -gsize / 2;

					ocean = new THREE.Ocean(renderer, camera, scene, {
						USE_HALF_FLOAT : true,
						INITIAL_SIZE : 256.0,
						INITIAL_WIND : [10.0, 10.0],
						INITIAL_CHOPPINESS : 1.5,
						CLEAR_COLOR : [1.0, 1.0, 1.0, 0.0],
						GEOMETRY_ORIGIN : [origx, origz],
						SUN_DIRECTION : [-1.0, 1.0, 1.0],
						OCEAN_COLOR: new THREE.Vector3(0.004, 0.016, 0.047),
						SKY_COLOR: new THREE.Vector3(3.2, 9.6, 12.8),
						EXPOSURE : 0.35,
						GEOMETRY_RESOLUTION: gres,
						GEOMETRY_SIZE : gsize,
						RESOLUTION : res
					});

					ocean.materialOcean.uniforms.u_projectionMatrix = { value: camera.projectionMatrix };
					ocean.materialOcean.uniforms.u_viewMatrix = { value: camera.matrixWorldInverse };
					ocean.materialOcean.uniforms.u_cameraPosition = { value: camera.position };

					scene.add(ocean.oceanMesh);

					$(".three").append(renderer.domElement);
				}

				function animate() {
					requestAnimationFrame( animate );
					update();
					var x = lastX - ($(window).width()/2);
					var y = lastY - ($(window).height()/2);

					x = -x*.2;
					y = -y*.8;
					$(".text-container").css("transform", "translate3d(" + x + "px, " + y + "px, 0)")
				}

				var getCursorPosition = function(e) {
					if(offsetLeft == undefined) {
						offsetLeft = 0;
						for(var node=$("body")[0]; node; node = node.offsetParent) {
							offsetLeft += node.offsetLeft;
						}
					}

					if(offsetTop == undefined) {
						offsetTop = 0;
						for(var node=$("body")[0]; node; node = node.offsetParent) {
							offsetTop += node.offsetTop;
						}
					}

					var x = e.pageX - offsetLeft;
					var y = e.pageY - offsetTop;

					return { x: x, y: y };
				}

				var onMouseMove = function(e) {
					var pos = getCursorPosition(e);
					lastX = pos.x;
					lastY = pos.y;
				}

				function update() {
					var currentTime = new Date().getTime();
					ocean.deltaTime = (currentTime - lastTime) / 1000 || 0.0;
					lastTime = currentTime;
					ocean.render(ocean.deltaTime);
					ocean.overrideMaterial = ocean.materialOcean;

					if (ocean.changed) {
						ocean.materialOcean.uniforms.u_size.value = ocean.size;
						ocean.materialOcean.uniforms.u_sunDirection.value.set( ocean.sunDirectionX, ocean.sunDirectionY, ocean.sunDirectionZ );
						ocean.materialOcean.uniforms.u_exposure.value = ocean.exposure;
						ocean.changed = false;
					}

					ocean.materialOcean.uniforms.u_normalMap.value = ocean.normalMapFramebuffer.texture;
					ocean.materialOcean.uniforms.u_displacementMap.value = ocean.displacementMapFramebuffer.texture;
					ocean.materialOcean.uniforms.u_projectionMatrix.value = camera.projectionMatrix;
					ocean.materialOcean.uniforms.u_viewMatrix.value = camera.matrixWorldInverse;
					ocean.materialOcean.uniforms.u_cameraPosition.value = camera.position;
					ocean.materialOcean.depthTest = true;
					renderer.render(scene, camera);
				}

				var requestAnimationFrame = (function() {
				 return  window.requestAnimationFrame       ||
								 window.webkitRequestAnimationFrame ||
								 window.mozRequestAnimationFrame    ||
								 window.oRequestAnimationFrame      ||
								 window.msRequestAnimationFrame     ||
								 function(callback, element){
										 window.setTimeout(callback, 1000 / 60);
								 };
				 })();

			});
		})(jQuery, this);

	</script>

<?php get_footer(); ?>
