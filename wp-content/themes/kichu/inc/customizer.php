<?php
/*
 * Register colors and layout for the Theme Customizer.
*/

function kichu_customizer_live_preview() {
	wp_enqueue_script( 'kichu_customizer', get_template_directory_uri().'/assets/customizer.js', array( 'jquery','customize-preview' ), '', true );
}
add_action( 'customize_preview_init', 'kichu_customizer_live_preview' );
 
function kichu_customize_register($wp_customize) {

	function kichu_sanitize_text( $input ) {
		return $input;
	}

	class Kichu_Support extends WP_Customize_Control {
		public function render_content() {
			echo __('If you like this theme and if it helped you with your business then please consider supporting the development <a target="_blank" href="http://www.hardeepasrani.com/donate/">by donating some money</a>. This theme is 100% free and will always be. <a target="_blank" href="http://www.hardeepasrani.com/donate/">Any amount, even $1.00, is appreciated :)</a>','kichu');
		}
	}

	class Kichu_Footer_Extension extends WP_Customize_Control {
		public function render_content() {
			echo __('To edit footer credits, you need to purchase the $5 <a href="http://bit.ly/buykichu" target="_blank">Footer Credits Extension</a>.','kichu');
		}
	}
	
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	
	$wp_customize->add_panel( 'colors_panel', array(
		'priority'       => 40,
		'capability'     => 'edit_theme_options',
		'title'          => __('Colors', 'kichu'),
		'description'    => __('This section allows you to customize colors and feel of the theme.', 'kichu'),
	));

    $wp_customize->add_section('donate_section', array(
        'priority' => 5,
        'title' => __('Do You Like This Theme?', 'kichu')
    ));	

	$wp_customize->add_section('header_colors_section', array(
		'priority' => 5,
		'title' => __('Header', 'kichu'),
		'panel'  => 'colors_panel'
	));

	$wp_customize->add_section('primary_colors_section', array(
		'priority' => 10,
		'title' => __('Primary Section', 'kichu'),
		'panel'  => 'colors_panel'
	));

	$wp_customize->add_section('secondary_colors_section', array(
		'priority' => 15,
		'title' => __('Secondary Section', 'kichu'),
		'panel'  => 'colors_panel'
	));

	$wp_customize->add_section('pagination_colors_section', array(
		'priority' => 20,
		'title' => __('Pagination', 'kichu'),
		'panel'  => 'colors_panel'
	));

	$wp_customize->add_section('footer_colors_section', array(
		'priority' => 25,
		'title' => __('Footer', 'kichu'),
		'panel'  => 'colors_panel'
	));

	$wp_customize->add_section('kichu_footer_credits', array(
		'priority' => 45,
		'title' => __('Footer Credits', 'kichu'),
	));

	$wp_customize->add_setting('kichu_title', array(
		'default' => '#FFF',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability' => 'edit_theme_options',
		'transport' => 'postMessage'
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kichu_title', array(
		'label' => __('Title', 'kichu'),
		'section' => 'header_colors_section',
		'priority' => 5,
		'settings' => 'kichu_title'
	)));

	$wp_customize->add_setting('kichu_title_background', array(
		'default' => '#0683C9',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability' => 'edit_theme_options',
		'transport' => 'postMessage'
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kichu_title_background', array(
		'label' => __('Header Background', 'kichu'),
		'section' => 'header_colors_section',
		'priority' => 5,
		'settings' => 'kichu_title_background'
	)));

	$wp_customize->add_setting('kichu_menu_title', array(
		'default' => '#AFDEFA',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability' => 'edit_theme_options',
		'transport' => 'postMessage'
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kichu_menu_title', array(
		'label' => __('Menu Title', 'kichu'),
		'section' => 'header_colors_section',
		'priority' => 15,
		'settings' => 'kichu_menu_title'
	)));

	$wp_customize->add_setting('kichu_menu_title_background', array(
		'default' => '#0D77B6',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability' => 'edit_theme_options',
		'transport' => 'postMessage'
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kichu_menu_title_background', array(
		'label' => __('Menu Title Background', 'kichu'),
		'section' => 'header_colors_section',
		'priority' => 20,
		'settings' => 'kichu_menu_title_background'
	)));

	$wp_customize->add_setting('kichu_menu_background', array(
		'default' => '#47A3DA',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability' => 'edit_theme_options',
		'transport' => 'postMessage'
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kichu_menu_background', array(
		'label' => __('Menu Background', 'kichu'),
		'section' => 'header_colors_section',
		'priority' => 25, 
		'settings' => 'kichu_menu_background'
	)));

	$wp_customize->add_setting('kichu_menu_links', array(
		'default' => '#FFF',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability' => 'edit_theme_options',
		'transport' => 'postMessage'
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kichu_menu_links', array(
		'label' => __('Menu Links', 'kichu'),
		'section' => 'header_colors_section',
		'priority' => 30,
		'settings' => 'kichu_menu_links'
	)));

	$wp_customize->add_setting('kichu_menu_links_hover', array(
		'default' => '#0683C9',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability' => 'edit_theme_options',
		'transport' => 'postMessage'
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kichu_menu_links_hover', array(
		'label' => __('Menu Links Hover', 'kichu'),
		'section' => 'header_colors_section',
		'priority' => 35,
		'settings' => 'kichu_menu_links_hover'
	)));

	$wp_customize->add_setting('kichu_primary_background', array(
		'default' => '#FFF',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability' => 'edit_theme_options',
		'transport' => 'postMessage'
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kichu_primary_background', array(
		'label' => __('Background', 'kichu'),
		'section' => 'primary_colors_section',
		'priority' => 5, 
		'settings' => 'kichu_primary_background'
	)));

	$wp_customize->add_setting('kichu_primary_title', array(
		'default' => '#000',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability' => 'edit_theme_options',
		'transport' => 'postMessage'
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kichu_primary_title', array(
		'label' => __('Title', 'kichu'),
		'section' => 'primary_colors_section',
		'priority' => 10,
		'settings' => 'kichu_primary_title'
	)));

	$wp_customize->add_setting('kichu_primary_text', array(
		'default' => '#505050',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability' => 'edit_theme_options',
		'transport' => 'postMessage'
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kichu_primary_text', array(
		'label' => __('Text', 'kichu'),
		'section' => 'primary_colors_section',
		'priority' => 15, 
		'settings' => 'kichu_primary_text'
	)));

	$wp_customize->add_setting('kichu_primary_link', array(
		'default' => '#3CB5F9',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability' => 'edit_theme_options',
		'transport' => 'postMessage'
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kichu_primary_link', array(
		'label' => __('Link', 'kichu'),
		'section' => 'primary_colors_section',
		'priority' => 20, 
		'settings' => 'kichu_primary_link'
	)));

	$wp_customize->add_setting('kichu_primary_link_hover', array(
		'default' => '#0793E2',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability' => 'edit_theme_options',
		'transport' => 'postMessage'
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kichu_primary_link_hover', array(
		'label' => __('Link Hover', 'kichu'),
		'section' => 'primary_colors_section',
		'priority' => 25, 
		'settings' => 'kichu_primary_link_hover'
	)));

	$wp_customize->add_setting('kichu_secondary_background', array(
		'default' => '#3CB5F9',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability' => 'edit_theme_options',
		'transport' => 'postMessage'
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kichu_secondary_background', array(
		'label' => __(' Background', 'kichu'),
		'section' => 'secondary_colors_section',
		'priority' => 5, 
		'settings' => 'kichu_secondary_background'
	)));

	$wp_customize->add_setting('kichu_secondary_title', array(
		'default' => '#FFF',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability' => 'edit_theme_options',
		'transport' => 'postMessage'
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kichu_secondary_title', array(
		'label' => __('Title', 'kichu'),
		'section' => 'secondary_colors_section',
		'priority' => 10,
		'settings' => 'kichu_secondary_title'
	)));

	$wp_customize->add_setting('kichu_secondary_text', array(
		'default' => '#FFF',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability' => 'edit_theme_options',
		'transport' => 'postMessage'
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kichu_secondary_text', array(
		'label' => __('Text', 'kichu'),
		'section' => 'secondary_colors_section',
		'priority' => 15, 
		'settings' => 'kichu_secondary_text'
	)));

	$wp_customize->add_setting('kichu_secondary_link', array(
		'default' => '#000',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability' => 'edit_theme_options',
		'transport' => 'postMessage'
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kichu_secondary_link', array(
		'label' => __('Link', 'kichu'),
		'section' => 'secondary_colors_section',
		'priority' => 20, 
		'settings' => 'kichu_secondary_link'
	)));

	$wp_customize->add_setting('kichu_secondary_link_hover', array(
		'default' => '#000',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability' => 'edit_theme_options',
		'transport' => 'postMessage'
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kichu_secondary_link_hover', array(
		'label' => __('Link Hover', 'kichu'),
		'section' => 'secondary_colors_section',
		'priority' => 25, 
		'settings' => 'kichu_secondary_link_hover'
	)));

	$wp_customize->add_setting('kichu_pagination_background', array(
		'default' => '#3CB5F9',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability' => 'edit_theme_options',
		'transport' => 'postMessage'
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kichu_pagination_background', array(
		'label' => __('Background', 'kichu'),
		'section' => 'pagination_colors_section',
		'priority' => 5, 
		'settings' => 'kichu_pagination_background'
	)));

	$wp_customize->add_setting('kichu_pagination_links', array(
		'default' => '#FFF',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability' => 'edit_theme_options',
		'transport' => 'postMessage'
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kichu_pagination_links', array(
		'label' => __('Links', 'kichu'),
		'section' => 'pagination_colors_section',
		'priority' => 10, 
		'settings' => 'kichu_pagination_links'
	)));

	$wp_customize->add_setting('kichu_pagination_links_hover', array(
		'default' => '#0683C9',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability' => 'edit_theme_options',
		'transport' => 'postMessage'
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kichu_pagination_links_hover', array(
		'label' => __('Links Hover', 'kichu'),
		'section' => 'pagination_colors_section',
		'priority' => 15, 
		'settings' => 'kichu_pagination_links_hover'
	)));

	$wp_customize->add_setting('kichu_footer_background', array(
		'default' => '#0683C9',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability' => 'edit_theme_options',
		'transport' => 'postMessage'
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kichu_footer_background', array(
		'label' => __('Background', 'kichu'),
		'section' => 'footer_colors_section',
		'priority' => 5, 
		'settings' => 'kichu_footer_background'
	)));

	$wp_customize->add_setting('kichu_footer_text', array(
		'default' => '#FFF',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability' => 'edit_theme_options',
		'transport' => 'postMessage'
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kichu_footer_text', array(
		'label' => __('Text/Link', 'kichu'),
		'section' => 'footer_colors_section',
		'priority' => 10, 
		'settings' => 'kichu_footer_text'
	)));

	$wp_customize->add_setting('kichu_footer_link_hover', array(
		'default' => '#FFF',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability' => 'edit_theme_options',
		'transport' => 'postMessage'
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kichu_footer_link_hover', array(
		'label' => __('Link Hover', 'kichu'),
		'section' => 'footer_colors_section',
		'priority' => 15, 
		'settings' => 'kichu_footer_link_hover'
	)));

	$wp_customize->add_setting( 'donate_section_main', array(
		'sanitize_callback' => 'kichu_sanitize_text'
	));

	$wp_customize->add_control( new Kichu_Support( $wp_customize, 'donate_section_main', array(
		'section' => 'donate_section',
	)));

	$wp_customize->add_setting( 'kichu_footer_credits_info', array(
		'sanitize_callback' => 'kichu_sanitize_text'
	));

	$wp_customize->add_control( new Kichu_Footer_Extension( $wp_customize, 'kichu_footer_credits_info', array(
		'section' => 'kichu_footer_credits',
	)));
}
add_action('customize_register', 'kichu_customize_register');

?>
