<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<nav class="nav-menu nav-menu-vertical nav-menu-right" id="nav-menu-s2">
    <h3 id="hideRightPush"><i class="fa fa-bars"></i> <?php _e( 'Menu', 'kichu' ); ?></h3>
		<?php
			wp_nav_menu(array(
				'theme_location' => 'primary',
				'menu' => __( 'Primary Menu', 'kichu' ),
                'fallback_cb' => 'kichu_new_setup',
				'walker'  => new Kichu_Walker_Menu()
			));
		?>
</nav>
<div id="wrapper">
<header>
    <div class="container clearfix">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>">
			<h1 id="logo"><?php bloginfo( 'name' ); ?></h1>
		</a>

		<button id="showRightPush"><i class="fa fa-bars"></i></button>
    </div>
</header><!-- /header -->