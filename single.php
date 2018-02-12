<?php get_header(); ?>

	<main role="main">

		<section class="single-work">

		<?php while (have_posts()) : the_post(); ?><?php endwhile; ?>

		</section>

		<script></script>

	</main>

<?php get_footer(); ?>
