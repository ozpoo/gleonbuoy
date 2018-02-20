<?php
/*
 * Template Name: 29
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

      var scene, camera, renderer, container;

      $(document).ready(function(){
        init();
      });

      function init() {
        container = $("#canvas");
        scene = new THREE.Scene();
        scene.background = new THREE.Color( 'rgba(25, 25, 25, 1)' );
        camera = new THREE.PerspectiveCamera(45,
        $(container).width() / $(container).height(), 0.1, 1000);

        renderer = new THREE.WebGLRenderer();
        renderer.setClearColor(0x000000, 1.0);
        renderer.setSize($(container).width(), $(container).height());

        var dirLight = new THREE.DirectionalLight();
        dirLight.position.set(30, 10, 20);
        scene.add(dirLight);

        scene.add( makeGradientCube(0xff0000, 0xffff66, 2,3,6, 0.8) );

        camera.position.set(10,10,10);
        camera.lookAt(scene.position);

        $(container).append(renderer.domElement);
        renderer.render(scene, camera);

        window.addEventListener( 'resize', onWindowResize, false );
      }

      function onWindowResize() {
        camera.aspect = $(container).width() / $(container).height() ;
        camera.updateProjectionMatrix();
        renderer.setSize( $(container).width(), $(container).height() );
      }

      function makeGradientCube(c1, c2, w, d, h, opacity) {
        if(typeof opacity === 'undefined')opacity = 1.0;
        if(typeof c1 === 'number')c1 = new THREE.Color( c1 );
        if(typeof c2 === 'number')c2 = new THREE.Color( c2 );

        var cubeGeometry = new THREE.BoxGeometry(w, h, d);

        var cubeMaterial = new THREE.MeshPhongMaterial({
            vertexColors:THREE.VertexColors
            });

        if(opacity < 1.0){
            cubeMaterial.opacity = opacity;
            cubeMaterial.transparent = true;
            }

        for(var ix=0;ix<12;++ix){
            if(ix==4 || ix==5){ //Top edge, all c2
                cubeGeometry.faces[ix].vertexColors = [c2,c2,c2];
                }
            else if(ix==6 || ix==7){ //Bottom edge, all c1
                cubeGeometry.faces[ix].vertexColors = [c1,c1,c1];
                }
            else if(ix%2 ==0){ //First triangle on each side edge
                cubeGeometry.faces[ix].vertexColors = [c2,c1,c2];
                }
            else{ //Second triangle on each side edge
                cubeGeometry.faces[ix].vertexColors = [c1,c1,c2];
                }
            }

        return new THREE.Mesh(cubeGeometry, cubeMaterial);
        }

    });

  })(jQuery, this);

</script>

<?php get_footer(); ?>
