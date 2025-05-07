<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Developer Toolkit
 * Plugin URI:        https://en-ca.wordpress.org/plugins/wp-developer-toolkit/
 * Description:       The Developer Toolkit for WordPress provides a system of tools for your development needs.
 * Version:           1.0.0
 * Author:            Terrence Gonsalves
 * Author URI:        https://profiles.wordpress.org/tegonsalves/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-developer-toolkit
 * Domain Path:       /languages
 */

// if this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'DEVELOPER_TOOLKIT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-developer-toolkit-activator.php
 */
function activate_developer_toolkit() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-developer-toolkit-activator.php';
	Developer_Toolkit_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-developer-toolkit-deactivator.php
 */
function deactivate_developer_toolkit() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-developer-toolkit-deactivator.php';
	Developer_Toolkit_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_developer_toolkit' );
register_deactivation_hook( __FILE__, 'deactivate_developer_toolkit' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-developer-toolkit.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_developer_toolkit() {

	$plugin = new Developer_Toolkit();
	$plugin->run();

}

run_developer_toolkit();
