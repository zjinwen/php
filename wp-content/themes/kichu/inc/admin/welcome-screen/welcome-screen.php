<?php
class Kichu_Welcome {

	public function __construct() {

		add_action( 'admin_menu', array( $this, 'kichu_welcome_register_menu' ) );
		add_action( 'load-themes.php', array( $this, 'kichu_activation_admin_notice' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'kichu_welcome_style' ) );

	} 

	public function kichu_activation_admin_notice() {
		global $pagenow;

		if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) { // input var okay
			add_action( 'admin_notices', array( $this, 'kichu_welcome_admin_notice' ), 99 );
		}
	}

	public function kichu_welcome_admin_notice() {
		?>
			<div class="updated notice is-dismissible">
				<p><?php echo sprintf( esc_html__( 'Thanks for choosing Kichu! You can read hints and tips on how get the most out of your new theme on the %swelcome screen%s.', 'kichu' ), '<a href="' . esc_url( admin_url( 'themes.php?page=kichu-welcome' ) ) . '">', '</a>' ); ?></p>
				<p><a href="<?php echo esc_url( admin_url( 'themes.php?page=kichu-welcome' ) ); ?>" class="button" style="text-decoration: none;"><?php _e( 'Get started with Kichu', 'kichu' ); ?></a></p>
			</div>
		<?php
	}

	public function kichu_welcome_style( $hook_suffix ) {
		global $kichu_version;

		if ( 'appearance_page_kichu-welcome' == $hook_suffix ) {
			wp_enqueue_style( 'kichu-welcome-screen', get_template_directory_uri() . '/inc/admin/welcome-screen/css/welcome.css', $kichu_version );
			wp_enqueue_style( 'thickbox' );
			wp_enqueue_script( 'thickbox' );
		}
	}

	public function kichu_welcome_register_menu() {
		add_theme_page( 'Kichu', 'Kichu', 'activate_plugins', 'kichu-welcome', array( $this, 'kichu_welcome_screen' ) );
	}

	public function kichu_welcome_screen() {
		require_once( ABSPATH . 'wp-load.php' );
		require_once( ABSPATH . 'wp-admin/admin.php' );
		require_once( ABSPATH . 'wp-admin/admin-header.php' );
		?>
		<div class="wrap about-wrap">

			<?php require_once( get_template_directory() . '/inc/admin/welcome-screen/content/content.php' ); ?>

		</div>
		<?php
	}
}

$GLOBALS['Kichu_Welcome'] = new Kichu_Welcome();
