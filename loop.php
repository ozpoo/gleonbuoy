<?php if (have_posts()): ?>
<?php while (have_posts()) : the_post(); ?>

	<article class="post">
		<?php if ( has_post_thumbnail()) : ?>
			<?php $thumb = get_post_thumbnail_id(); ?>
			<figure>
				<p>
					<picture>
						<img src="<?php echo wp_get_attachment_image_src( $thumb, 'medium' )[0]; ?>">
					</picture>
				</p>
			</figure>
		<?php endif; ?>
		<p>
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</p>
	</article>

<?php endwhile; ?>
<?php endif; ?>
