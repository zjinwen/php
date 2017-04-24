<?php
/**
 * Evento functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Evento
 */

if ( ! function_exists( 'evento_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function evento_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Evento, use a find and replace
	 * to change 'evento' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'evento', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );


	
	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	
	/*
	 * Enable support for site logo.
	 */
	add_image_size( 'logo', 270, 60 );
	add_theme_support( 'custom-logo', array( 'size' => 'logo', 'flex-height' => true, 'flex-width'  => true, 'header-text' => array( 'site-title', 'site-description' ) ) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'evento' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'evento_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'evento_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function evento_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'evento_content_width', 640 );
}
add_action( 'after_setup_theme', 'evento_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function evento_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'evento' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'evento_widgets_init' );



if ( ! function_exists( 'evento_fonts_url' ) ) :
/**
 * Register Google fonts for Evento.
 *
 * Create your own evento_fonts_url() function to override in a child theme.
 *
 * @since Evento 1.0.2
 *
 * @return string Google fonts URL for the theme.
 */
function evento_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'cyrillic,latin,latin-ext';
	

	/* translators: If there are characters in your language that are not supported by Open Sans, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'evento' ) ) {
		$fonts[] = 'Lato:400,400italic,700,700italic';
	}
	/* translators: If there are characters in your language that are not supported by Open Sans, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'evento' ) ) {
		$fonts[] = 'Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i';
	}
	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}
	return $fonts_url;
}
endif;


/**
 * Enqueue scripts and styles.
 */
function evento_scripts() {
	wp_enqueue_style( 'evento-style', get_stylesheet_uri() );

	wp_enqueue_style( 'gumby-style', get_template_directory_uri() . '/css/gumby.css', array(), '20151215', false );
	
	wp_enqueue_style( 'evento-fonts', evento_fonts_url(), array(), null);  
	
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
		
	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/libs/modernizr.js', array('jquery' ), '20151215', false );

	wp_enqueue_script( 'gumby', get_template_directory_uri() . '/js/libs/gumby.js', array(), '20151215', true );
	
	wp_enqueue_script( 'gumby-fixed', get_template_directory_uri() . '/js/libs/ui/gumby.fixed.js', array(), '20151215', true );
	wp_enqueue_script( 'gumby-toggleswitch', get_template_directory_uri() . '/js/libs/ui/gumby.toggleswitch.js', array(), '20151215', true );
	wp_enqueue_script( 'gumby-navbar', get_template_directory_uri() . '/js/libs/ui/gumby.navbar.js', array(), '20151215', true );
	wp_enqueue_script( 'gumby-init', get_template_directory_uri() . '/js/libs/gumby.init.js', array('jquery'), '20151215', true );

	wp_enqueue_script( 'gumby-main', get_template_directory_uri() . '/js/main.js', array('jquery'), '20151215', true );

}
add_action( 'wp_enqueue_scripts', 'evento_scripts' );

/**
 * Implement the Custom Walker.
 */
require get_template_directory() . '/inc/custom-menu-walker.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
