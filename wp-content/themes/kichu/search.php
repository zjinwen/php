<?php get_header(); ?>

<div id="main">

    <div id="content">

		<article>
			<div class="container">
				<h2><?php _e( 'Search results for:', 'kichu' ); ?> <?php echo get_search_query(); ?></h2>
			</div>
		</article>

		<?php if ( have_posts() ) : ?> 
		
			<?php while ( have_posts() ) : the_post(); ?>
			
				<?php get_template_part( 'content', ( post_type_supports( get_post_type(), 'post-formats' ) ? get_post_format() : get_post_type() ) ); ?>
			
			<?php endwhile; ?>

				<div class="pagination">

					<div class="container clearfix">

						<span class="left"><?php previous_posts_link(); ?></span>

						<span class="right"><?php next_posts_link(); ?></span>

					</div>

				</div>
			
		<?php else : ?>
				
				<?php get_template_part( 'content', 'none' ); ?>
			
		<?php endif; ?>

    </div>

</div><!-- #main -->

<?php get_footer(); ?>