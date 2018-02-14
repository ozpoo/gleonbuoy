<?php
/*
 * Template Name: 26
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

        const width = window.innerWidth;
        const height = window.innerHeight;

        // Add canvas
        let renderer = new THREE.WebGLRenderer( { alpha: true } );
        renderer.setClearColor( 0x000000, 0 );
        renderer.setSize(width, height);
        $(".visualization").append(renderer.domElement);

        // Set up camera and scene
        let camera = new THREE.PerspectiveCamera(
        45,
        width / height,
        1,
        10000
        );
        camera.position.set(0, 0, 10000);
        camera.lookAt(new THREE.Vector3(0,0,0));
        const scene = new THREE.Scene();

        // Generate points and add them to scene
        const generated_points = d3.range(100000).map(phyllotaxis(10));
        const pointsGeometry = new THREE.Geometry();
        const colors = [];
        for (const point of generated_points) {
          const vertex = new THREE.Vector3(point[0], point[1], 0);
          pointsGeometry.vertices.push(vertex);
          const color = new THREE.Color();
          color.setHSL(Math.random(), 1, 0.5);
          colors.push(color);
        }
        pointsGeometry.colors = colors;
        const pointsMaterial = new THREE.PointsMaterial({ vertexColors: THREE.VertexColors, size: 6,
        sizeAttenuation: false  });
        const points = new THREE.Points(pointsGeometry, pointsMaterial);
        const pointsContainer = new THREE.Object3D();
        pointsContainer.add(points);
        scene.add(pointsContainer);

        // Set up zoom behavior
        const zoom = d3.zoom()
        .scaleExtent([100, 10000])
        .on('zoom', () => {
          const event = d3.event;
          if (event.sourceEvent) {
            // Get z from D3
            const new_z = event.transform.k;
            if (new_z !== camera.position.z) {
              // Handle a zoom event
              const { clientX, clientY } = event.sourceEvent;
              // Project a vector from current mouse position and zoom level
              // Find the x and y coordinates for where that vector intersects the new
              // zoom level.
              // Code from WestLangley https://stackoverflow.com/questions/13055214/mouse-canvas-x-y-to-three-js-world-x-y-z/13091694#13091694
              const vector = new THREE.Vector3(
                clientX / width * 2 - 1,
                - (clientY / height) * 2 + 1,
                1
              );
              vector.unproject(camera);
              const dir = vector.sub(camera.position).normalize();
              const distance = (new_z - camera.position.z)/dir.z;
              const pos = camera.position.clone().add(dir.multiplyScalar(distance));
              // Set the camera to new coordinates
              camera.position.set(pos.x, pos.y, new_z);
            } else {
              // Handle panning
              const { movementX, movementY } = event.sourceEvent;
              // Adjust mouse movement by current scale and set camera
              const current_scale = getCurrentScale();
              camera.position.set(camera.position.x - movementX/current_scale, camera.position.y +
                movementY/current_scale, camera.position.z);
            }
          }
        });

        // Add zoom listener
        const view = d3.select(renderer.domElement);
        view.call(zoom);
        // Disable double click to zoom because I'm not handling it in Three.js
        view.on('dblclick.zoom', null);
        // Sync d3 zoom with camera z position
        zoom.scaleTo(view, 10000);
        // Three.js render loop
        function animate() {
        requestAnimationFrame(animate);
        renderer.render(scene, camera);
        }

        animate();

        // From https://github.com/anvaka/three.map.control, used for panning
        function getCurrentScale() {
          let vFOV = camera.fov * Math.PI / 180
          let scale_height = 2 * Math.tan( vFOV / 2 ) * camera.position.z
          let currentScale = height / scale_height
          return currentScale
        }

        // Point generator function
        function phyllotaxis(radius) {
          const theta = Math.PI * (3 - Math.sqrt(5));
          return function(i) {
            const r = radius * Math.sqrt(i), a = theta * i;
            return [
              width / 2 + r * Math.cos(a) - width / 2,
              height / 2 + r * Math.sin(a) - height / 2
            ];
          };
        }

      });

    })(jQuery, this);

	</script>

<?php get_footer(); ?>
