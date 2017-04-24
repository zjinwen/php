<?php
/*
 * Hey
 * Only edit this file if you know what you're doing or make a backup before editing it
 * Happy Blogging
*/

require get_template_directory() . "/inc/customizer.php";
require get_template_directory() . "/inc/post-formats.php";
if ( is_admin() ) {
	require get_template_directory() . '/inc/admin/welcome-screen/welcome-screen.php';
}

function kichu_setup() {

	global $content_width;
	if (!isset($content_width)) {
		$content_width = 1020;
	}

	// Takes care of the <title> tag. https://codex.wordpress.org/Title_Tag
	add_theme_support('title-tag');
	
	// Loads texdomain. https://codex.wordpress.org/Function_Reference/load_theme_textdomain
	load_theme_textdomain('kichu', get_template_directory() . '/languages');

	// Add automatic feed links support. https://codex.wordpress.org/Automatic_Feed_Links
	add_theme_support('automatic-feed-links');

	// Add post thumbnails support. https://codex.wordpress.org/Post_Thumbnails
	add_theme_support('post-thumbnails');

	// Add post formats support. https://codex.wordpress.org/Post_Formats#Adding_Theme_Support
	add_theme_support('post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ));

	// Add Jetpack Infinite Scroll support. http://jetpack.me/support/infinite-scroll/ 
	add_theme_support( 'infinite-scroll', array( 
		'container' => 'content', 
	) ); 

	// This theme uses wp_nav_menu(). https://codex.wordpress.org/Function_Reference/register_nav_menu
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'kichu' ),
	));
}

add_action( 'after_setup_theme', 'kichu_setup' );

// To add backwards compatibility for titles
if ( ! function_exists( '_wp_render_title_tag' ) ) {
	function kichu_render_title() {
?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php
	}
	add_action( 'wp_head', 'kichu_render_title' );
}

// Registering and enqueuing scripts/stylesheets to header/footer.
function kichu_scripts() {
	wp_enqueue_style( 'kichu_style', get_stylesheet_uri());
	wp_enqueue_style( 'kichu_ubuntu', '//fonts.googleapis.com/css?family=Ubuntu:300,400,700,400italic');
	wp_enqueue_style( 'kichu_oswald', '//fonts.googleapis.com/css?family=Oswald:400,300,700');
	wp_enqueue_style( 'kichu_font_awesome', get_template_directory_uri() . '/assets/font-awesome/css/font-awesome.min.css');

	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	wp_enqueue_script( 'kichu_classie', get_template_directory_uri() . '/assets/classie.js', array( 'jquery' ),'',true);
	wp_enqueue_script( 'kichu_custom', get_template_directory_uri() . '/assets/custom.js','','',true);
}

add_action( 'wp_enqueue_scripts', 'kichu_scripts' );

class Kichu_Walker_Menu extends Walker {

    // Tell Walker where to inherit it's parent and id values
	var $db_fields = array(
		'parent' => 'menu_item_parent', 
		'id'	 => 'db_id' 
	);

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="'. esc_attr( $class_names ) . '"';
		$output .= sprintf( "\n<li><a href='%s'%s><i $class_names></i> %s</a></li>\n",
			$item->url,
			( $item->object_id === get_the_ID() ) ? ' class="current"' : '',
			$item->title
		);
	}

}

function kichu_footer_credits() {
	echo __('<span><a rel="nofollow" href="http://www.hardeepasrani.com/portfolio/wordpress-themes/kichu/"> Kichu </a> - Proudly powered by WordPress</span>', 'kichu');
}
add_action( 'kichu_credits', 'kichu_footer_credits' );

function kichu_new_setup() {

	echo '<div class="menu-short-container">';
    echo '<ul id="menu-short" class="menu">';
		echo '<li>';
            echo '<a href="' . esc_url( home_url( '/' ) ) . '"><i class="fa fa-home menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home"></i>' . __( 'Home', 'kichu' ) . '</a>';
        echo '</li>';
    echo '</ul>';
    echo '</div>';

}

function kichu_customizer_head() {
	$kichu_title = get_theme_mod('kichu_title');
	$kichu_title_background = get_theme_mod('kichu_title_background');
	$kichu_menu_title = get_theme_mod('kichu_menu_title');
	$kichu_menu_title_background = get_theme_mod('kichu_menu_title_background');
	$kichu_menu_background = get_theme_mod('kichu_menu_background');
	$kichu_menu_links = get_theme_mod('kichu_menu_links');
	$kichu_menu_links_hover = get_theme_mod('kichu_menu_links_hover');
	$kichu_primary_background = get_theme_mod('kichu_primary_background');
	$kichu_primary_title = get_theme_mod('kichu_primary_title');
	$kichu_primary_text = get_theme_mod('kichu_primary_text');
	$kichu_primary_link = get_theme_mod('kichu_primary_link');
	$kichu_primary_link_hover = get_theme_mod('kichu_primary_link_hover');
	$kichu_secondary_background = get_theme_mod('kichu_secondary_background');
	$kichu_secondary_title = get_theme_mod('kichu_secondary_title');
	$kichu_secondary_text = get_theme_mod('kichu_secondary_text');
	$kichu_secondary_link = get_theme_mod('kichu_secondary_link');
	$kichu_secondary_link_hover = get_theme_mod('kichu_secondary_link_hover');
	$kichu_pagination_background = get_theme_mod('kichu_pagination_background');
	$kichu_pagination_links = get_theme_mod('kichu_pagination_links');
	$kichu_pagination_links_hover = get_theme_mod('kichu_pagination_links_hover');
	$kichu_footer_background = get_theme_mod('kichu_footer_background');
	$kichu_footer_text = get_theme_mod('kichu_footer_text');
	$kichu_footer_link_hover = get_theme_mod('kichu_footer_link_hover');

?>
<style>
<?php if(!empty($kichu_title)) : ?>
	header h1#logo,
	button#showRightPush {
		color: <?php echo esc_html($kichu_title); ?>;
	}
<?php endif; ?>
<?php if(!empty($kichu_title_background)) : ?>
	header {
		background-color: <?php echo esc_html($kichu_title_background); ?>;
	}
<?php endif; ?>
<?php if(!empty($kichu_menu_title)) : ?>
	.nav-menu h3 {
		color: <?php echo esc_html($kichu_menu_title); ?>;
	}
<?php endif; ?>
<?php if(!empty($kichu_menu_title_background)) : ?>
	.nav-menu h3 {
		background: <?php echo esc_html($kichu_menu_title_background); ?>;
	}
	.nav-menu-vertical a {
		border-bottom: <?php echo esc_html($kichu_menu_title_background); ?>;
	}
<?php endif; ?>
<?php if(!empty($kichu_menu_background)) : ?>
	.nav-menu {
		background: <?php echo esc_html($kichu_menu_background); ?>;
	}
<?php endif; ?>
<?php if(!empty($kichu_menu_links)) : ?>
	.nav-menu a,
	.nav-menu a:hover,
	.nav-menu a:active {
		color: <?php echo esc_html($kichu_menu_links); ?>;
	}
<?php endif; ?>
<?php if(!empty($kichu_menu_links_hover)) : ?>
	.nav-menu a:hover,
	.nav-menu a:active {
		background: <?php echo esc_html($kichu_menu_links_hover); ?>;;
	}
<?php endif; ?>
<?php if(!empty($kichu_primary_background)) : ?>
	#main {
		background-color: <?php echo esc_html($kichu_primary_background); ?> ;
	}
<?php endif; ?>
<?php if(!empty($kichu_primary_title)) : ?>
	article a.title {
		color: <?php echo esc_html($kichu_primary_title); ?> ;
	}
<?php endif; ?>
<?php if(!empty($kichu_primary_text)) : ?>
	body {
		color: <?php echo esc_html($kichu_primary_text); ?> ;
	}
<?php endif; ?>
<?php if(!empty($kichu_primary_link)) : ?>
	a {
		color: <?php echo esc_html($kichu_primary_link); ?> ;
	}
<?php endif; ?>
<?php if(!empty($kichu_primary_link_hover)) : ?>
	a:hover {
		color: <?php echo esc_html($kichu_primary_link_hover); ?> ;
	}
<?php endif; ?>
<?php if(!empty($kichu_secondary_background)) : ?>
	body,
	article:nth-child(2n),
	.comment-area {
		background-color: <?php echo esc_html($kichu_secondary_background); ?> ;
	}

	input[type="submit"],
	button {
		background-color: <?php echo esc_html($kichu_secondary_background); ?> ;
		border: <?php echo esc_html($kichu_secondary_background); ?> ;
	}
<?php endif; ?>
<?php if(!empty($kichu_secondary_title)) : ?>
	article:nth-child(2n) a.title,
	article:nth-child(2n) a.title:hover,
	.comments-title,
	.comment-navigation .screen-reader-text,
	.comment-navigation .nav-previous a,
	.comment-navigation .nav-next a {
		color: <?php echo esc_html($kichu_secondary_title); ?> ;
	}
<?php endif; ?>
<?php if(!empty($kichu_secondary_text)) : ?>
	article:nth-child(2n) {
		color: <?php echo esc_html($kichu_secondary_text); ?> ;
	}
<?php endif; ?>
<?php if(!empty($kichu_secondary_link)) : ?>
	article:nth-child(2n) a {
		color: <?php echo esc_html($kichu_secondary_link); ?> ;
	}
<?php endif; ?>
<?php if(!empty($kichu_secondary_link_hover)) : ?>
	article:nth-child(2n) a:hover {
		color: <?php echo esc_html($kichu_secondary_link_hover); ?> ;
	}
<?php endif; ?>
<?php if(!empty($kichu_pagination_background)) : ?>
	.pagination {
		background-color: <?php echo esc_html($kichu_pagination_background); ?> ;
	}
<?php endif; ?>
<?php if(!empty($kichu_pagination_links)) : ?>
	.pagination a,
	.pagination a:hover {
		color: <?php echo esc_html($kichu_pagination_links); ?> ;
	}
<?php endif; ?>
<?php if(!empty($kichu_pagination_links_hover)) : ?>
	.pagination a:hover {
		background-color: <?php echo esc_html($kichu_pagination_links_hover); ?> ;
	}
<?php endif; ?>
<?php if(!empty($kichu_footer_background)) : ?>
	.credits {
		background-color: <?php echo esc_html($kichu_footer_background); ?> ;
	}
<?php endif; ?>
<?php if(!empty($kichu_footer_text)) : ?>
	.credits,
	.credits a {
		color: <?php echo esc_html($kichu_footer_text); ?> ;
	}
<?php endif; ?>
<?php if(!empty($kichu_footer_link_hover)) : ?>
	.credits a:hover {
		color: <?php echo esc_html($kichu_footer_link_hover); ?> ;
	}
<?php endif; ?>
</style>
<?php
}

add_action('wp_head', 'kichu_customizer_head');