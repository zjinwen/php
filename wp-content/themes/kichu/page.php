<?php get_header(); ?>

<div id="main">

    <div id="content">
		
		<?php if ( have_posts() ) : ?> 
		
			<?php while ( have_posts() ) : the_post(); ?>
			
				<?php get_template_part( 'content', 'page' ); ?>
			
			<?php endwhile; ?>
			
				<?php comments_template(); ?>
			
		<?php else : ?>
				
				<?php get_template_part( 'content', 'none' ); ?>
			
		<?php endif; ?>

    </div>

</div><!-- #main -->

<?php get_footer(); ?>