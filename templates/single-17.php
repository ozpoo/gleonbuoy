<?php
/*
 * Template Name: 17
 * Template Post Type: post
 */

 get_header();  ?>

 <style>
  body {
    background: #222;
    color: #fcfaf7;
  }
  a {
    color: #fcfaf7;
  }
 </style>

	<main role="main">

    <section class="visualization">
      <div id="canvas"></div>
    </section>

	</main>

	<script>

  (function ($, root, undefined) {

    $(function () {

      var container;
			var camera, scene, renderer;
			var group;
			var targetRotation = 0;
			var targetRotationOnMouseDown = 0;
			var mouseX = 0;
			var mouseXOnMouseDown = 0;
			var windowHalfX = $("#canvas").width() / 2;
			var windowHalfY = $("#canvas").height() / 2;

      $(window).load(function(){
        init();
        animate();
      });

      function init() {
        container = $("#canvas");
				camera = new THREE.PerspectiveCamera( 50, $("#canvas").width() / $("#canvas").height(), 1, 1000 );
				camera.position.set( 0, 150, 500 );
				scene = new THREE.Scene();
				scene.background = new THREE.Color( "rgba(25, 25, 25, 1)" );
				group = new THREE.Group();
				group.position.y = 50;
				scene.add( group );
				// NURBS curve
				var nurbsControlPoints = [];
				var nurbsKnots = [];
				var nurbsDegree = 3;
				for ( var i = 0; i <= nurbsDegree; i ++ ) {
					nurbsKnots.push( 0 );
				}
				for ( var i = 0, j = 20; i < j; i ++ ) {
					nurbsControlPoints.push(
						new THREE.Vector4(
							Math.random() * 400 - 200,
							Math.random() * 400,
							Math.random() * 400 - 200,
							1 // weight of control point: higher means stronger attraction
						)
					);
					var knot = ( i + 1 ) / ( j - nurbsDegree );
					nurbsKnots.push( THREE.Math.clamp( knot, 0, 1 ) );
				}
				var nurbsCurve = new THREE.NURBSCurve(nurbsDegree, nurbsKnots, nurbsControlPoints);
				var nurbsGeometry = new THREE.Geometry();
				nurbsGeometry.vertices = nurbsCurve.getPoints( 200 );
				var nurbsMaterial = new THREE.LineBasicMaterial( { linewidth: 10, color: "rgba(255, 255, 255, 1)" } );
				var nurbsLine = new THREE.Line( nurbsGeometry, nurbsMaterial );
				nurbsLine.position.set( 0, -100, 0 );
				var nurbsControlPointsGeometry = new THREE.Geometry();
				nurbsControlPointsGeometry.vertices = nurbsCurve.controlPoints;
				var nurbsControlPointsMaterial = new THREE.LineBasicMaterial( { linewidth: 2, color: "rgba(255, 255, 255, 1)", opacity: 0.25 } );
				var nurbsControlPointsLine = new THREE.Line( nurbsControlPointsGeometry, nurbsControlPointsMaterial );
				nurbsControlPointsLine.position.copy( nurbsLine.position );
				group.add( nurbsLine, nurbsControlPointsLine );
				// this also works:
				// group.add( nurbsLine ).add( nurbsControlPointsLine );
				//
				renderer = new THREE.CanvasRenderer();
				renderer.setPixelRatio( window.devicePixelRatio );
				renderer.setSize( $("#canvas").width(), $("#canvas").height() );
				$(container).append( renderer.domElement );
				document.addEventListener( 'mousedown', onDocumentMouseDown, false );
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
			//
			function onDocumentMouseDown( event ) {
				event.preventDefault();
				document.addEventListener( 'mousemove', onDocumentMouseMove, false );
				document.addEventListener( 'mouseup', onDocumentMouseUp, false );
				document.addEventListener( 'mouseout', onDocumentMouseOut, false );
				mouseXOnMouseDown = event.clientX - windowHalfX;
				targetRotationOnMouseDown = targetRotation;
			}
			function onDocumentMouseMove( event ) {
				mouseX = event.clientX - windowHalfX;
				targetRotation = targetRotationOnMouseDown + ( mouseX - mouseXOnMouseDown ) * 0.02;
			}
			function onDocumentMouseUp( event ) {
				document.removeEventListener( 'mousemove', onDocumentMouseMove, false );
				document.removeEventListener( 'mouseup', onDocumentMouseUp, false );
				document.removeEventListener( 'mouseout', onDocumentMouseOut, false );
			}
			function onDocumentMouseOut( event ) {
				document.removeEventListener( 'mousemove', onDocumentMouseMove, false );
				document.removeEventListener( 'mouseup', onDocumentMouseUp, false );
				document.removeEventListener( 'mouseout', onDocumentMouseOut, false );
			}
			function onDocumentTouchStart( event ) {
				if ( event.touches.length == 1 ) {
					event.preventDefault();
					mouseXOnMouseDown = event.touches[ 0 ].pageX - windowHalfX;
					targetRotationOnMouseDown = targetRotation;
				}
			}
			function onDocumentTouchMove( event ) {
				if ( event.touches.length == 1 ) {
					event.preventDefault();
					mouseX = event.touches[ 0 ].pageX - windowHalfX;
					targetRotation = targetRotationOnMouseDown + ( mouseX - mouseXOnMouseDown ) * 0.05;
				}
			}
			//
			function animate() {
				requestAnimationFrame( animate );
				render();
			}
			function render() {
				group.rotation.y += ( targetRotation - group.rotation.y ) * 0.05;
				renderer.render( scene, camera );
			}

    });

  })(jQuery, this);
	</script>

<?php get_footer(); ?>
