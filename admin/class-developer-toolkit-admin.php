<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/tegonsalves/
 * @since      1.0.0
 *
 * @package    Developer_Toolkit
 * @subpackage Developer_Toolkit/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Developer_Toolkit
 * @subpackage Developer_Toolkit/admin
 * @author     Terrence Gonsalves <terrence.gonsalves@gmail.com>
 */
class Developer_Toolkit_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The database options to search for.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $site_options    The database options in query.
	 */
	private $site_options = [];

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Developer_Toolkit_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Developer_Toolkit_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/developer-toolkit-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Developer_Toolkit_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Developer_Toolkit_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/developer-toolkit-admin.js', array( 'jquery' ), $this->version, false );
	}

	private function get_options_table() {
		global $wpdb;

		$table_name = $wpdb->prefix . 'options';

		$sql = "select * from $table_name";
		$results = $wpdb->get_results( $sql, OBJECT );

		if ( $wpdb->last_error ) {
			echo 'Error: ' . $wpdb->last_error;
		} else {
			foreach ( $results as $result ) {
				echo '<pre>';
				print_r( $result );
				echo '</pre>';
			}
		}
	}

	/**
	 * Add Top Level Menu
	 * 
	 * @since 0.1.0
	 */
	public function admin_menu_page() {
		add_menu_page(
			'Developer Toolkit for WordPress',
			'Dev Toolkit',
			'manage_options',
			'developer-toolkit',
			array( $this, 'admin_page' ),
			'dashicons-schedule',
			20
		);
	}

	/**
	 * HTML Top Level Page
	 * 
	 * @since 0.1.0
	 */
	public function admin_page() {
?>
		<div class="dtk-wrapper">		
			<div class="dtk-header">				
				<h1><?php _e( 'Developer Toolkit for WordPress', 'developer-toolkit' ); ?></h1>
				<h2 class="nav-tab-wrapper">
					<a href="javascript:void(0);" id="tab_1" class="nav-tab nav-tab-active">
						<?php _e( "Site Info", 'developer-toolkit' ); ?>
					</a>
					<a href="javascript:void(0);" id="tab_2" class="nav-tab">
						<?php _e( 'Changelog', 'developer-toolkit' ); ?>
					</a>
				</h2>
			</div>

			<div class="dtk-content">
				<div id="what_new">
					
					<?php
					$this->site_options = array(
						'permalink_structure'    => get_option( 'permalink_structure' ),
						'blog_public'            => get_option( 'blog_public' ),
						'user_count'             => count_users(),
						'version'                => get_bloginfo( 'version' ),
						'language'               => get_bloginfo( 'language' ),
						'url'                    => get_bloginfo( 'url' ),
						'charset'                => get_bloginfo( 'charset' ),
					);
					
					$display = '';

					$display .= '<h3>' . __( 'Site Information', 'developer-toolkit' ) . '</h3>';
					$display .= '<p>' . __( 'WordPress Version: ', 'developer-toolkit' ) . $this->site_options['version'] . '</p>';
					$display .= '<p>' . __( 'Language: ', 'developer-toolkit' ) . $this->site_options['language'] . '</p>';
					$display .= '<p>' . __( 'URL: ', 'developer-toolkit' ) . $this->site_options['url'] . '</p>';
					$display .= '<p>' . __( 'HTTPS Enable: ', 'developer-toolkit' ) . ( is_ssl() ? 'Yes' : 'No' ) . '</p>';
					$display .= '<p>' . __( 'Multisite Enable: ', 'developer-toolkit' ) . ( is_multisite() ? 'Yes' : 'No' ) . '</p>';
					$display .= '<p>' . __( 'Search Engine Enable: ', 'developer-toolkit' ) . ( ( $this->site_options['user_count'] == 1 ) ? 'Yes' : 'No' ) . '</p>';
					$display .= '<p>' . __( 'Environment: ', 'developer-toolkit' ) . wp_get_environment_type() . '</p>';
					$display .= '<p>' . __( 'User Count: ', 'developer-toolkit' ) . $this->site_options['user_count'] . '</p>';

					echo $display;
					?>

				</div>

				<div id="changelog" style="display: none;">
					<h3><?php _e( 'Changelog', 'developer-toolkit' ); ?></h3>
					<p><?php _e( 'This is where you will find the changelog for the plugin.', 'developer-toolkit' ); ?></p>
					<ul>
						<li><?php _e( 'Version 1.0.0 - Initial Release', 'developer-toolkit' ); ?></li>
						<li><?php _e( 'Version 1.0.1 - Bug Fixes', 'developer-toolkit' ); ?></li>
					</ul>
				</div>
			</div>
		</div>
<?php
	}

	/**
	 * Add Submenu Page
	 * 
	 * @since 0.1.0
	 */
	public function admin_submenu_page() {
		add_submenu_page(
			'developer-toolkit',
			'Settings',
			'Settings',
			'manage_options',
			'developer-toolkit-settings',
			array( $this, 'settings_page' )
		);
	}

	/**
	 * Submenu HTML Page
	 * 
	 * @since 0.1.0
	 */
	public function settings_page() {
		echo '<div class="wrap">';
		echo '<h1>Developer Toolkit Settings</h1>';
		echo '<p>Configure your settings here.</p>';
		echo '</div>';
	}
}