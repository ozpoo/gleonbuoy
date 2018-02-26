<?php
/*
 * Template Name: 27
 * Template Post Type: post
 */

 get_header();  ?>

	<main role="main">

    <section class="visualization">
    </section>

	</main>

	<script>

  (function ($, root, undefined) {

    $(function () {

      'use strict';

        if ( ! Detector.webgl ) Detector.addGetWebGLMessage();

        let container;
        let views, glScene, glRenderer, camera, cssrenderer;
        let cssScene, cssRenderer;
        let light;
        let mouseX = 0, mouseY = 0;
        let windowWidth = $(".visualization").innerWidth();
        let windowHeight = $(".visualization").innerHeight();
        let realData;
        let startPosition;
        let vFOVRadians, controls, line, fov, graphLine;

        $.getJSON( "<?php echo get_template_directory_uri(); ?>/assets/data/27/2005-2015.json", function( data ) {
          realData = data;
          init();
          render();
        });

        let graphDimensions = {
        w:1000,
        d:2405,
        h:800
        };

        function init() {

        container = $('.visualization');
        fov = 40;
        startPosition = new THREE.Vector3( 0, 0, 3000 );
        camera = new THREE.PerspectiveCamera( fov, windowWidth / windowHeight, 1, 30000 );
        camera.position.set( startPosition.x, startPosition.y, startPosition.z );

        controls = new THREE.OrbitControls( camera );
        controls.autoRotate = true;
        controls.damping = 0.2;
        controls.addEventListener( 'change', render );

        glScene = new THREE.Scene();

        light = new THREE.DirectionalLight( 0xffffff );
        light.position.set( 0, 0, 1 );
        glScene.add( light );

        // create canvas
        let canvas = document.createElement( 'canvas' );
            canvas.width = 128;
            canvas.height = 128;

        let context = canvas.getContext( '2d' );

        let wireframeMaterial = new THREE.MeshBasicMaterial( {
                                  side:THREE.DoubleSide,
                                  vertexColors: THREE.VertexColors
                                });

        let floorGeometry = new THREE.PlaneGeometry(graphDimensions.w,graphDimensions.d,10,2405);
        let colors = ["#eef4f8","#ddecf4","#cce5f0","#bcddec","#aed5e7","#a0cde2","#94c5dc","#89bcd6","#7eb4d0","#74abc9","#6aa2c2","#619abb","#5892b4","#4f8aad","#4781a6","#3f799f","#3a7195","#35688c","#326082","#2f5877","#2c506c","#243d52"];
        let faceColors = [];
        let lines={};

        // on plane Geometry, change the z value to create the 3D area surface
        // just like when creating a terrain
        for (let i =0; i< floorGeometry.vertices.length; i++){

          //push colors to the faceColors array
          faceColors.push(colors[Math.round(realData[i][2]*4)]);

          if (realData[i][2] == null){
            //hack hack hack
            floorGeometry.vertices[i].z="null";
          }else{
            floorGeometry.vertices[i].z=realData[i][2]*100;
            if (!lines[floorGeometry.vertices[i].x]) {
              lines[floorGeometry.vertices[i].x] = new THREE.Geometry();
            }
            //arrays for the grid lines
            lines[floorGeometry.vertices[i].x].vertices.push(new THREE.Vector3(floorGeometry.vertices[i].x, floorGeometry.vertices[i].y, realData[i][2]*100));
          }
        }

        //vertexColors
        for (let x= 0; x <floorGeometry.faces.length; x++){
          floorGeometry.faces[x].vertexColors[0] = new THREE.Color(faceColors[floorGeometry.faces[x].a]);
          floorGeometry.faces[x].vertexColors[1] = new THREE.Color(faceColors[floorGeometry.faces[x].b]);
          floorGeometry.faces[x].vertexColors[2] = new THREE.Color(faceColors[floorGeometry.faces[x].c]);
        }

        let floor = new THREE.Mesh(floorGeometry, wireframeMaterial);
        floor.rotation.x = -Math.PI/2;
        floor.position.y = -graphDimensions.h/2;

        floor.rotation.z = Math.PI/2;
        glScene.add(floor);

        glRenderer = new THREE.WebGLRenderer( { alpha: true } );
        glRenderer.setClearColor( 0x000000, 0 );
        glRenderer.setSize( windowWidth, windowHeight);
        container.append( glRenderer.domElement );

        window.addEventListener( 'resize', onWindowResize, false );
        animate();
        }

        function animate() {
          requestAnimationFrame(animate);
          controls.update();
        }

        function render() {
          camera.lookAt( glScene.position );
          glRenderer.render( glScene, camera );
        }

        function onWindowResize() {
          windowWidth = $(".visualization").innerWidth(),
          windowHeight = $(".visualization").innerHeight();
          camera.aspect = windowWidth / windowHeight;
          camera.updateProjectionMatrix();

          glRenderer.setSize( windowWidth, windowHeight );
          render();
        }

        $(".buttons").bind('click',function(){
          if ($(this).attr('id')=="camera-1"){
            console.log("camera one");
            controls.reset();
            let vFOVRadians = 2 * Math.atan( windowHeight / ( 2 * 35000 ) ),
                fov = vFOVRadians * 180 / Math.PI;
            camera.fov = fov;
            controls.rotateUp(90*Math.PI/180);
            camera.position.z = startPosition.z* 23;
            camera.position.y = (startPosition.z)*55;
            camera.far = 1000000;
            camera.updateProjectionMatrix();
            console.log( camera.position.y);
            render();
          }

          if ($(this).attr('id')=="camera-2"){
            console.log("camera two");
            controls.reset();

            let vFOVRadians = 2 * Math.atan( windowHeight / ( 2 * 35000 ) ),
                fov = vFOVRadians * 180 / Math.PI;
            camera.fov = fov;
            camera.position.z = startPosition.z* 58;
            camera.far = 1000000;
            camera.updateProjectionMatrix();
            render();
          }

          if ($(this).attr('id')=="camera-3"){
            console.log("camera three");
            controls.reset();
            camera.fov = 30;
            camera.updateProjectionMatrix();
            render();
          }

        });

      });

    })(jQuery, this);

	</script>

<?php get_footer(); ?>
