<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

	<div class="container">
		
		<a class="title" href="<?php the_permalink(); ?>"> <?php the_title( '<h2>', '</h2>' ); ?> </a>

		<div class="content">
			<?php the_content(); ?>
		</div>

		<div class="article-meta-format">
			<?php wp_link_pages('before=<spam id="page-links">' . __( 'Pages:', 'kichu' ) . ' &after=</spam>'); ?>
		</div>

	</div>

</article>