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
				<p><a class="hover-text" href="<?php echo site_url( '/', 'http' ); ?>">I<span>ntro</span></a></p>
			</section>

			<section class="menu-toggle">
				<p>
					<button class="hover-text" class="menu-button">M<span>enu</span></button>
				</p>
			</section>

			<section class="menu-modal">
				<p>
					<a href="<?php echo site_url( '/', 'http' ); ?>">Intro</a>
					<!-- <a href="<?php echo site_url( '/grid', 'http' ); ?>">Grid</a> <a href="<?php echo site_url( '/list', 'http' ); ?>">List</a> -->
				</p>
				<?php
				$wpb_all_query = new WP_Query(array('post_type'=>'post', 'post_status'=>'publish', 'posts_per_page'=>-1, 'order'=>'ASC', 'orderby'=>'menu_order')); ?>
				<?php if ( $wpb_all_query->have_posts() ) : ?>
				<?php remove_filter( 'the_content', 'wpautop' ); ?>
				<ul>
					<?php while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post(); ?>
						<li>
							<!-- <a href="<?php the_permalink(); ?>"><?php the_title(); ?> &mdash; <?php the_content(); ?></a> -->
							<a href="<?php the_permalink(); ?>">&mdash; <?php the_content(); ?></a>
						</li>
					<?php endwhile; ?>
				</ul>
				<?php wp_reset_postdata(); ?>
				<?php endif; ?>
				<section class="description">
					<p>This website is a collection of data cognition experiements created by Eric Andren at the Lakeside Lab Artists in Residence program in 2017.</p>
					<p>The Global Lake Ecological Observatory Network (GLEON) shares and interprets high resolution sensor data to understand, predict, and communicate the role and response of lakes in a changing global environment. Eric Andren makes use of the public data available by GLEON and the Lakeside Lab to explore these same goals through using form, color, and time as an alternative media.</p>
				</section>
			</section>

			<?php

				if(is_page("intro")){
					$nextPost = new WP_Query('posts_per_page=1&order=ASC&post_type=post&orderby=menu_order');
					$nextPost->the_post();
					$nextPost = get_the_permalink( $nextPost->ID );
					wp_reset_query();

					$prevPost = new WP_Query('posts_per_page=1&order=DESC&post_type=post&orderby=menu_order');
					$prevPost->the_post();
					$prevPost = get_the_permalink( $prevPost->ID );
					wp_reset_query();
				} else {
					if(get_adjacent_post(false, '', true )) {
						$nextPost = get_adjacent_post(false, '', true );
						$nextPost = get_the_permalink( $nextPost->ID );
					} else {
						$nextPost = site_url( '/', 'http' );
					}
					if(get_adjacent_post(false, '', false )) {
						$prevPost = get_adjacent_post(false, '', false );
						$prevPost = get_the_permalink( $prevPost->ID );
					} else {
						$prevPost = site_url( '/', 'http' );
					}
				}

			?>

			<section class="previous">
				<p><a class="hover-text" href="<?php echo $prevPost; ?>">P<span>revious</span></a></p>
			</section>

			<section class="next">
				<p><a class="hover-text" href="<?php echo $nextPost; ?>">N<span>ext</span></a></p>
			</section>

		</header>
