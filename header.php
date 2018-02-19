<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

		<link href="//www.google-analytics.com" rel="dns-prefetch">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php bloginfo('description'); ?>">

		<?php wp_head(); ?>

		<script>
				document.createElement( "picture" );
		</script>

	</head>
	<body <?php body_class(); ?>>

		<header>

			<section class="title">
				<p><a href="<?php echo site_url( '/', 'http' ); ?>">GLEON Viz</a></p>
			</section>

			<section class="menu-toggle">
				<p>
					<button class="menu-button">M</button>
				</p>
			</section>

			<section class="list">
				<?php
				$wpb_all_query = new WP_Query(array('post_type'=>'post', 'post_status'=>'publish', 'posts_per_page'=>-1, 'order'=>'DESC')); ?>
				<?php if ( $wpb_all_query->have_posts() ) : ?>
				<ul>
					<?php while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post(); ?>
						<li>
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><br>
							<small>Lorem ipsum dolor sit amet, consectetur adipiscing</small>
						</li>
					<?php endwhile; ?>
				</ul>
				<?php wp_reset_postdata(); ?>
				<?php endif; ?>
			</section>

			<?php

				if(is_home()){
					$nextPost = new WP_Query('posts_per_page=1&order=DESC&post_type=post&orderby=menu_order');
					$nextPost->the_post();
					$nextPost = get_the_permalink( $nextPost->ID );
					wp_reset_query();

					$prevPost = new WP_Query('posts_per_page=1&order=ASC&post_type=post&orderby=menu_order');
					$prevPost->the_post();
					$prevPost = get_the_permalink( $prevPost->ID );
					wp_reset_query();
				} else {
					if(get_adjacent_post(false, '', true )){
						$prevPost = get_adjacent_post(false, '', true );
						$prevPost = get_the_permalink( $prevPost->ID );
					} else {
						$prevPost = site_url( '/', 'http' );
					}
					if(get_adjacent_post(false, '', false )){
						$nextPost = get_adjacent_post(false, '', false );
						$nextPost = get_the_permalink( $nextPost->ID );
					} else {
						$nextPost = site_url( '/', 'http' );
					}
				}

			?>

			<section class="previous">
				<p><a href="<?php echo $prevPost; ?>">P</a></p>
			</section>

			<section class="next">
				<p><a href="<?php echo $nextPost; ?>">N</a></p>
			</section>

		</header>
