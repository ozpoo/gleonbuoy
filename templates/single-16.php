<?php
/*
 * Template Name: 16
 * Template Post Type: post
 */

 get_header();  ?>

	<main role="main">

    <section class="visualization">
      <div id="canvas"></div>
    </section>

	</main>

  <script type="x-shader/x-vertex" id="vertexshader">
		uniform float amplitude;
		attribute float displacement;
		varying vec3 vNormal;
		varying vec2 vUv;
		void main() {
			vNormal = normal;
			vUv = ( 0.5 + amplitude ) * uv + vec2( amplitude );
			vec3 newPosition = position + amplitude * normal * vec3( displacement );
			gl_Position = projectionMatrix * modelViewMatrix * vec4( newPosition, 1.0 );
		}
	</script>

	<script type="x-shader/x-fragment" id="fragmentshader">
		varying vec3 vNormal;
		varying vec2 vUv;
		uniform vec3 color;
		uniform sampler2D texture;
		void main() {
			vec3 light = vec3( 0.5, 0.2, 1.0 );
			light = normalize( light );
			float dProd = dot( vNormal, light ) * 0.5 + 0.5;
			vec4 tcolor = texture2D( texture, vUv );
			vec4 gray = vec4( vec3( tcolor.r * 0.3 + tcolor.g * 0.59 + tcolor.b * 0.11 ), 1.0 );
			gl_FragColor = gray * vec4( vec3( dProd ) * vec3( color ), 1.0 );
		}
	</script>


	<script>

  (function ($, root, undefined) {

    $(function () {

      if ( ! Detector.webgl ) Detector.addGetWebGLMessage();
      var renderer, scene, camera;
      var sphere, uniforms;
      var displacement, noise, container;

      $(window).load(function(){
        init();
        animate();
      });

      function init() {
        container = $("#canvas");
        camera = new THREE.PerspectiveCamera( 30, $("#canvas").width() / $("#canvas").height(), 1, 10000 );
        camera.position.z = 300;
        scene = new THREE.Scene();
        scene.background = new THREE.Color( 0x050505 );
        uniforms = {
          amplitude: { value: 1.0 },
          color:     { value: new THREE.Color( 0xff2200 ) },
          texture:   { value: new THREE.TextureLoader().load( "<?php echo get_template_directory_uri(); ?>/assets/js/_lib/three/examples/textures/water.jpg" ) }
        };
        uniforms.texture.value.wrapS = uniforms.texture.value.wrapT = THREE.RepeatWrapping;

        var shaderMaterial = new THREE.ShaderMaterial( {
          uniforms: uniforms,
          vertexShader:document.getElementById( 'vertexshader' ).textContent,
          fragmentShader: document.getElementById( 'fragmentshader' ).textContent
        });

        var radius = 50, segments = 128, rings = 64;
        var geometry = new THREE.SphereBufferGeometry( radius, segments, rings );

        displacement = new Float32Array( geometry.attributes.position.count );
        noise = new Float32Array( geometry.attributes.position.count );
        for ( var i = 0; i < displacement.length; i ++ ) {
          noise[ i ] = Math.random() * 5;
        }
        geometry.addAttribute( 'displacement', new THREE.BufferAttribute( displacement, 1 ) );
        sphere = new THREE.Mesh( geometry, shaderMaterial );
        scene.add( sphere );
        renderer = new THREE.WebGLRenderer();
        renderer.setPixelRatio( window.devicePixelRatio );
        renderer.setSize( $("#canvas").width(), $("#canvas").height() );
        $(container).append( renderer.domElement );
        //
        window.addEventListener( 'resize', onWindowResize, false );
      }

      function onWindowResize() {
        camera.aspect = $("#canvas").width() / $("#canvas").height();
        camera.updateProjectionMatrix();
        renderer.setSize( $("#canvas").width(), $("#canvas").height() );
      }

      function animate() {
        requestAnimationFrame( animate );
        render();
      }

      function render() {
        var time = Date.now() * 0.01;
        sphere.rotation.y = sphere.rotation.z = 0.01 * time;
        uniforms.amplitude.value = 2.5 * Math.sin( sphere.rotation.y * 0.125 );
        uniforms.color.value.offsetHSL( 0.0005, 0, 0 );
        for ( var i = 0; i < displacement.length; i ++ ) {
          displacement[ i ] = Math.sin( 0.1 * i + time );
          noise[ i ] += 0.5 * ( 0.5 - Math.random() );
          noise[ i ] = THREE.Math.clamp( noise[ i ], -5, 5 );
          displacement[ i ] += noise[ i ];
        }
        sphere.geometry.attributes.displacement.needsUpdate = true;
        renderer.render( scene, camera );
      }

    });

  })(jQuery, this);
	</script>

<?php get_footer(); ?>
