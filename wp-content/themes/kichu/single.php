<?php get_header(); ?>

<div id="main">

    <div id="content">
		
		<?php if ( have_posts() ) : ?> 
		
			<?php while ( have_posts() ) : the_post(); ?>
			
				<?php get_template_part( 'content', ( post_type_supports( get_post_type(), 'post-formats' ) ? get_post_format() : get_post_type() ) ); ?>
			
			<?php endwhile; ?>

				<div class="pagination">

					<div class="container clearfix">

						<span class="left"><?php previous_post_link('%link', '&larr; %title', TRUE); ?> </span>

						<span class="right"><?php next_post_link('%link', '%title &rarr;', TRUE); ?></span>

					</div>

				</div>

				<?php comments_template(); ?>
			
		<?php else : ?>
				
				<?php get_template_part( 'content', 'none' ); ?>
			
		<?php endif; ?>

    </div>

</div><!-- #main -->

<?php get_footer(); ?>