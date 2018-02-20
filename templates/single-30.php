<?php
/*
 * Template Name: 30
 * Template Post Type: post
 */

 get_header();  ?>

	<main role="main">

    <section class="visualization">
      <div id="canvas"></div>
    </section>

	</main>

  <script type="x-shader/x-vertex" id="vertexshader">
    attribute float size;
    attribute vec3 customColor;
    varying vec3 vColor;
    void main() {
      vColor = customColor;
      vec4 mvPosition = modelViewMatrix * vec4( position, 1.0 );
      gl_PointSize = size * ( 300.0 / -mvPosition.z );
      gl_Position = projectionMatrix * mvPosition;
    }
  </script>

  <script type="x-shader/x-fragment" id="fragmentshader">
    uniform vec3 color;
    uniform sampler2D texture;
    varying vec3 vColor;
    void main() {
      gl_FragColor = vec4( color * vColor, 1.0 );
      gl_FragColor = gl_FragColor * texture2D( texture, gl_PointCoord );
      if ( gl_FragColor.a < ALPHATEST ) discard;
    }
  </script>

	<script>

  (function ($, root, undefined) {

    $(function () {

      if ( ! Detector.webgl ) Detector.addGetWebGLMessage();

      var renderer, scene, camera;
      var particles, uniforms;
      var PARTICLE_SIZE = 20;
      var raycaster, intersects;
      var mouse, INTERSECTED;
      var container;

      $(document).ready(function(){
        init();
        animate();
      });

      function init() {
        container = $("#canvas");
        scene = new THREE.Scene();
        scene.background = new THREE.Color( 'rgba(25, 25, 25, 1)' );
        camera = new THREE.PerspectiveCamera( 45, $(container).width() / $(container).height(), 1, 10000 );
        camera.position.z = 250;

        var geometry1 = new THREE.BoxGeometry( 200, 200, 200, 16, 16, 16 );
        var vertices = geometry1.vertices;
        var positions = new Float32Array( vertices.length * 3 );
        var colors = new Float32Array( vertices.length * 3 );
        var sizes = new Float32Array( vertices.length );
        var vertex;
        var color = new THREE.Color();

        for ( var i = 0, l = vertices.length; i < l; i ++ ) {
          vertex = vertices[ i ];
          vertex.toArray( positions, i * 3 );
          color.setHSL( 0.01 + 0.1 * ( i / l ), 1.0, 0.5 );
          color.toArray( colors, i * 3 );
          sizes[ i ] = PARTICLE_SIZE * 0.5;
        }

        var geometry = new THREE.BufferGeometry();
        geometry.addAttribute( 'position', new THREE.BufferAttribute( positions, 3 ) );
        geometry.addAttribute( 'customColor', new THREE.BufferAttribute( colors, 3 ) );
        geometry.addAttribute( 'size', new THREE.BufferAttribute( sizes, 1 ) );

        var material = new THREE.ShaderMaterial( {
          uniforms: {
          color:   { value: new THREE.Color( 0xffffff ) },
          texture: { value: new THREE.TextureLoader().load( "<?php echo get_template_directory_uri(); ?>/assets/js/_lib/three/examples/textures/sprites/disc.png" ) }
        },
          vertexShader: document.getElementById( 'vertexshader' ).textContent,
          fragmentShader: document.getElementById( 'fragmentshader' ).textContent,
          alphaTest: 0.9
        } );

        particles = new THREE.Points( geometry, material );
        scene.add( particles );

        renderer = new THREE.WebGLRenderer();
        renderer.setPixelRatio( window.devicePixelRatio );
        renderer.setSize( $(container).width(), $(container).height() );
        $(container).append( renderer.domElement );

        raycaster = new THREE.Raycaster();
        mouse = new THREE.Vector2();

        window.addEventListener( 'resize', onWindowResize, false );
        document.addEventListener( 'mousemove', onDocumentMouseMove, false );
      }

      function onDocumentMouseMove( event ) {
        event.preventDefault();
        mouse.x = ( event.clientX / $(container).width() ) * 2 - 1;
        mouse.y = - ( event.clientY / $(container).height() ) * 2 + 1;
      }

      function onWindowResize() {
        camera.aspect = $(container).width() / $(container).height();
        camera.updateProjectionMatrix();
        renderer.setSize( $(container).width(), $(container).height() );
      }

      function animate() {
        requestAnimationFrame( animate );
        render();
      }

      function render() {
        particles.rotation.x += 0.0005;
        particles.rotation.y += 0.001;
        var geometry = particles.geometry;
        var attributes = geometry.attributes;
        raycaster.setFromCamera( mouse, camera );
        intersects = raycaster.intersectObject( particles );
        if ( intersects.length > 0 ) {
          if ( INTERSECTED != intersects[ 0 ].index ) {
            attributes.size.array[ INTERSECTED ] = PARTICLE_SIZE;
            INTERSECTED = intersects[ 0 ].index;
            attributes.size.array[ INTERSECTED ] = PARTICLE_SIZE * 1.25;
            attributes.size.needsUpdate = true;
          }
        } else if ( INTERSECTED !== null ) {
          attributes.size.array[ INTERSECTED ] = PARTICLE_SIZE;
          attributes.size.needsUpdate = true;
          INTERSECTED = null;
        }
        renderer.render( scene, camera );
      }

    });

  })(jQuery, this);

</script>

<?php get_footer(); ?>
