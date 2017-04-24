<?php
$kichu = wp_get_theme( 'kichu' );

?>
<div class="col one-col" style="overflow: hidden;">
	<div class="col">
		<div class="boxed enrich">
			<h1 class="kichu-title"><?php echo '<strong>' . esc_attr( $kichu['Name'] ) . '</strong> <sup class="version">' . esc_attr( $kichu['Version'] ) . '</sup>'; ?></h1>
			<img src="<?php echo esc_url( get_template_directory_uri() ) . '/inc/admin/welcome-screen/img/Kichu.png'; ?>" alt="<?php esc_html_e( 'Kichu', 'kichu' ); ?>" class="image-kichu" />
			<p><?php printf( esc_html__( 'Kichu is one column theme, which supports all the post formats. This design focuses on your content & is perfect for an elegant blog site. This theme allows you to customize colors, and is translation-ready.', 'kichu' ) ); ?></p>
			<p>
				<a href="<?php echo esc_url( self_admin_url( 'customize.php' ) ); ?>" class="button button-primary"><?php printf( esc_html__( 'Visit Customizer', 'kichu' ) ); ?></a>
				<a href="http://www.hardeepasrani.com/portfolio/kichu/" class="button button-primary" target="_blank"><?php printf( esc_html__( 'More Info', 'kichu' ) ); ?></a>
			</p>
		</div>
	</div>
</div>

<div class="col two-col" style="overflow: hidden;">
	<div class="col">
		<div class="boxed whatsnew">
			<h2><?php printf( esc_html__( 'What\'s new in %s?', 'kichu' ), esc_attr( $kichu['Version'] ) ); ?></h2>
			<p><?php printf( esc_html__( 'Take a look at everything that\'s new in the latest version:', 'kichu' ) ); ?></p>
			<ul>
				<li><?php printf( __('<strong>Customizer Improvements:</strong> Customizer now uses postMessage method so you don\'t need to wait for the refresh to see your changes.', 'kichu') ); ?></li>
				<li><?php printf( __('<strong>Welcome Panel:</strong> This version adds a Welcome Panel to the theme which tells you everything that you need to know about the theme.', 'kichu') ); ?></li>
			</ul>
		</div>
	</div>
	<div class="col">
		<?php if (defined('KICHU_FOOTER_EXTENSION')) : ?>
			<div class="boxed downloaded">
				<h2><?php printf( esc_html__( 'Footer Credits Extension', 'kichu' ) ); ?> <sup class="activated"><?php printf( esc_html__( 'Activated', 'kichu' ) ); ?></sup></h2>
				<p><?php printf( esc_html__( 'Kichu Footer Extension allows you to edit the footer credits of your Kichu theme straight from the Customizer, without touching a line of code.', 'kichu' ) ); ?></p>
				<p><a href="<?php echo esc_url( self_admin_url( 'customize.php?autofocus[control]=kichu_footer_credits' ) ); ?>" class="button button-primary"><?php printf( esc_html__( 'Customize', 'kichu' ) ); ?></a></p>
			</div>
		<?php else: ?>
			<div class="boxed extension">
				<h2><?php printf( esc_html__( 'Get the Footer Credits Extension', 'kichu' ) ); ?></h2>
				<p><?php printf( esc_html__( 'Kichu Footer Extension allows you to edit the footer credits of your Kichu theme straight from the Customizer, without touching a line of code.', 'kichu' ) ); ?></p>
				<p><a href="http://bit.ly/buykichu" class="button button-primary" target="_blank"><?php printf( esc_html__( 'Purchase ($5)', 'kichu' ) ); ?></a></p>
			</div>
		<?php endif;?>
	</div>
</div>

<div class="col two-col" style="overflow: hidden;">
	<div class="col">
		<div class="boxed support">
			<h2><?php esc_html_e( 'Need support?', 'kichu' ); ?></h2>
			<p><?php printf( __('Found an issue with the theme? You can get support <a href="https://wordpress.org/support/theme/kichu" target="_blank">at this link</a>. Or would you like to translate Kichu into your language? <a href="https://translate.wordpress.org/projects/wp-themes/kichu" target="_blank">Get involved</a>! Also, don\'t forget to <a href="https://wordpress.org/support/view/theme-reviews/kichu" target="_blank">leave a review</a>.', 'kichu') ); ?></p>
		</div>
	</div>
	<div class="col">
		<div class="boxed donate">
			<h2><?php esc_html_e( 'Donate', 'kichu' ); ?></h2>
			<p><?php printf( __('If you like this theme and if it helped you with your business then please consider supporting the development <a target="_blank" href="http://www.hardeepasrani.com/donate/">by donating some money</a>. <a target="_blank" href="http://www.hardeepasrani.com/donate/">Any amount, even $1.00, is appreciated :)</a>', 'kichu') ); ?></p>
		</div>
	</div>
</div>
