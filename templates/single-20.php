<?php
/*
 * Template Name: 20
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
			var camera, scene, renderer, video;


      $(window).load(function(){
        init();
        animate();
      });

      function init() {
        container = $("#canvas");
				camera = new THREE.PerspectiveCamera( 60, $("#canvas").width() / $("#canvas").height(), 0.1, 100 );
				camera.position.z = 0.01;
				scene = new THREE.Scene();
				video = document.getElementById( 'video' );
				var texture = new THREE.VideoTexture( video );
				texture.minFilter = THREE.LinearFilter;
				texture.magFilter = THREE.LinearFilter;
				texture.format = THREE.RGBFormat;
				var geometry = new THREE.PlaneBufferGeometry( 16, 9 );
				geometry.scale( 0.5, 0.5, 0.5 );
				var material = new THREE.MeshBasicMaterial( { map: texture } );
				var count = 128;
				var radius = 32;
				var spherical = new THREE.Spherical();
				for ( var i = 1, l = count; i <= l; i ++ ) {
					var phi = Math.acos( - 1 + ( 2 * i ) / l );
					var theta = Math.sqrt( l * Math.PI ) * phi;
					spherical.set( radius, phi, theta );
					var mesh = new THREE.Mesh( geometry, material );
					mesh.position.setFromSpherical( spherical );
					mesh.lookAt( camera.position );
					scene.add( mesh );
				}
				renderer = new THREE.WebGLRenderer( { antialias: true } );
				renderer.setPixelRatio( window.devicePixelRatio );
				renderer.setSize( $("#canvas").width(), $("#canvas").height() );
				$(container).append( renderer.domElement );
				var controls = new THREE.OrbitControls( camera, renderer.domElement );
				controls.enableZoom = false;
				controls.enablePan = false;
				window.addEventListener( 'resize', onWindowResize, false );
				//
				if ( navigator.mediaDevices && navigator.mediaDevices.getUserMedia ) {
					var constraints = { video: { width: 1280, height: 720, facingMode: 'user' } };
					navigator.mediaDevices.getUserMedia( constraints ).then( function( stream ) {
							// apply the stream to the video element used in the texture
							video.src = window.URL.createObjectURL( stream );
							video.play();
					} ).catch( function( error ) {
						console.error( 'Unable to access the camera/webcam.', error );
					} );
				} else {
					console.error( 'MediaDevices interface not available.' );
				}
			 }
			 function onWindowResize() {
				 camera.aspect = $("#canvas").width() / $("#canvas").height();
				 camera.updateProjectionMatrix();
				 renderer.setSize( $("#canvas").width(), $("#canvas").height() );
			 }
			 function animate() {
				 requestAnimationFrame( animate );
				 renderer.render( scene, camera );
			 }

     });

   })(jQuery, this);

	</script>

<?php get_footer(); ?>
