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

  (function ($, root, undefined) {

    $(function () {

    if ( ! Detector.webgl ) Detector.addGetWebGLMessage();

			let container;
			let camera, scene, renderer, particles, geometry, material, i, h, color, sprite, size;
			let mouseX = 0, mouseY = 0;
			let windowHalfX = $("#canvas").width() / 2;
			let windowHalfY = $("#canvas").height() / 2;

      $(window).load(function(){
        init();
  			animate();
      })

			function init() {
				container = $("#canvas");
				camera = new THREE.PerspectiveCamera( 55, $("#canvas").width() / $("#canvas").height(), 2, 2000 );
				camera.position.z = 1000;
				scene = new THREE.Scene();
				scene.fog = new THREE.FogExp2( 0x000000, 0.001 );
				geometry = new THREE.Geometry();
				sprite = new THREE.TextureLoader().load( "<?php echo get_template_directory_uri(); ?>/assets/js/_lib/three/examples/textures/sprites/disc.png" );
				for (let i = 0; i < 10000; i ++ ) {
					let vertex = new THREE.Vector3();
					vertex.x = 2000 * Math.random() - 1000;
					vertex.y = 2000 * Math.random() - 1000;
					vertex.z = 2000 * Math.random() - 1000;
					geometry.vertices.push( vertex );
				}
				material = new THREE.PointsMaterial( { size: 35, sizeAttenuation: false, map: sprite, alphaTest: 0.5, transparent: true } );
				material.color.setHSL( 1.0, 0.3, 0.7 );
				particles = new THREE.Points( geometry, material );
				scene.add( particles );
				//
				renderer = new THREE.WebGLRenderer();
				renderer.setPixelRatio( window.devicePixelRatio );
				renderer.setSize( $("#canvas").width(), $("#canvas").height() );
				$(container).append( renderer.domElement );
				//
				document.addEventListener( 'mousemove', onDocumentMouseMove, false );
				document.addEventListener( 'touchstart', onDocumentTouchStart, false );
				document.addEventListener( 'touchmove', onDocumentTouchMove, false );
				//
				window.addEventListener( 'resize', onWindowResize, false );
			}
			function onWindowResize() {
				windowHalfX = $("#canvas").width() / 2;
				windowHalfY = $("#canvas").height() / 2;
				camera.aspect = $("#canvas").width() / $("#canvas").height();
				camera.updateProjectionMatrix();
				renderer.setSize( $("#canvas").width(), $("#canvas").height() );
			}
			function onDocumentMouseMove( event ) {
				mouseX = event.clientX - windowHalfX;
				mouseY = event.clientY - windowHalfY;
			}
			function onDocumentTouchStart( event ) {
				if ( event.touches.length == 1 ) {
					event.preventDefault();
					mouseX = event.touches[ 0 ].pageX - windowHalfX;
					mouseY = event.touches[ 0 ].pageY - windowHalfY;
				}
			}
			function onDocumentTouchMove( event ) {
				if ( event.touches.length == 1 ) {
					event.preventDefault();
					mouseX = event.touches[ 0 ].pageX - windowHalfX;
					mouseY = event.touches[ 0 ].pageY - windowHalfY;
				}
			}
			//
			function animate() {
				requestAnimationFrame( animate );
				render();
			}
			function render() {
				let time = Date.now() * 0.00005;
				camera.position.x += ( mouseX - camera.position.x ) * 0.05;
				camera.position.y += ( - mouseY - camera.position.y ) * 0.05;
				camera.lookAt( scene.position );
				h = ( 360 * ( 1.0 + time ) % 360 ) / 360;
				material.color.setHSL( h, 0.5, 0.5 );
				renderer.render( scene, camera );
			}

    });

  })(jQuery, this);

	</script>

<?php get_footer(); ?>
