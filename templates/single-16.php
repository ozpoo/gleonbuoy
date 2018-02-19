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

	<script>

    var points, c, dc;

    function setup() {
      canvas = createCanvas(window.innerWidth, window.innerHeight);
      canvas.parent("canvas");
      c = random(360);
      background(230);

      points = new Array();
      for(var i = 0; i < 3; i++) {
        points[i] = new Points(random(width), random(height));
      }
    }

    function draw() {
      if(frameCount % 1700 == 0) clear();

      for(var i = 0; i < points.length; i++) {
        if(random(1) > 0.96) points[i].setDir(random(-PI, PI));
        points[i].update();
        points[i].checkEdges();
      }

      dc = map(millis(), 0, 150000, 0, 360);
      stroke((c + dc) % 360, 50, 100, 5);
      stroke("#2234C9");
      noFill();

      var Det = (points[0].p.x * points[1].p.y)  + (points[1].p.x * points[2].p.y) + (points[2].p.x * points[0].p.y);
      Det -= (points[0].p.y * points[1].p.x)  + (points[1].p.y * points[2].p.x) + (points[2].p.y * points[0].p.x);
      if(abs(Det) > 50.)  circle(points);
    }

    function windowResized() {
      resizeCanvas(window.innerWidth, window.innerHeight);
    }

    function circle(pts) {
      //find the midpoints of 2 sides
      var mp = new Array();
      for(var k = 0; k < 2; k++)  mp[k] = midpoint(pts[k].p, pts[k+1].p);

      var o = center(mp);   //find the center of the circle
      var r = dist(o.x, o.y, pts[2].p.x, pts[2].p.y);  //calculate the radius

      ellipse(o.x, o.y, 2*r, 2*r); //if not collinear display circle
    }

    function midpoint(A, B){
      var d = dist(A.x, A.y, B.x, B.y); //distance AB
      var theta = atan2(B.y - A.y, B.x - A.x); //inclination of AB

      var p = createVector(A.x + d/2*cos(theta),   A.y + d/2*sin(theta), //midpoint
                      theta - HALF_PI);  //inclination of the bissecteur

      return p;
    }

    function center(P) {
      var eq = new Array();

      for(var i = 0; i < 2; i++) {
        var a = tan(P[i].z);
        eq[i] = createVector(a, -1, -1*(P[i].y - P[i].x*a)); //equation of the first bissector (ax - y =  -b)
      }

      //calculate x and y coordinates of the center of the circle
      var ox = (eq[1].y * eq[0].z - eq[0].y * eq[1].z) / (eq[0].x * eq[1].y - eq[1].x * eq[0].y);
      var oy =  (eq[0].x * eq[1].z - eq[1].x * eq[0].z) / (eq[0].x * eq[1].y - eq[1].x * eq[0].y);
      return createVector(ox,oy);
    }

    function Points(x_, y_){

      this.p = createVector(x_, y_, 1);
      this.velocity = createVector(0, 0, 0);
      this.acceleration = createVector(random(1), random(1), 0);

      this.setDir = function(angle) {
        //direction of the acceleration is defined by the new angle
        this.acceleration.set(cos(angle), sin(angle), 0);

        //magnitude of the acceleration is proportional to the angle between acceleration and velocity
        this.acceleration.normalize();
        var dif = this.acceleration.angleBetween(this.velocity);
        dif = map(dif, 0, PI, 0.1, 0.001);
        this.acceleration.mult(dif);

      }

      this.update = function(){
        this.velocity.add(this.acceleration);
        this.velocity.limit(1.5);
        this.p.add(this.velocity);
      }

      this.checkEdges = function() {
        this.p.x = constrain(this.p.x, 0, width);
        this.p.y = constrain(this.p.y, 0, height);
      }
    }

	</script>

<?php get_footer(); ?>
