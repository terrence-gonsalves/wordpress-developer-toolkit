<?php
/**
 * Plugin Name: Developer Toolkit
 * Plugin URI:  https://en-ca.wordpress.org/plugins/wp-developer-toolkit/
 * Description: The all-in-one toolkit for WordPress developers
 * Author:      Terrence Gonsalves
 * Author URI:  
 * Version:     0.3.0
 * Text Domain: developer-toolkit
 * Domain Path: /languages
 * License:     GPL2
 *
 * Developer Toolkit for Developers is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 * 
 * Developer Toolkit is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Developer Toolkit. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
 *
 * @author Terrence Gonsalves
 * @version 0.3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Developer_Toolkit' ) ) {

  /**
    * This class is the main class of the plugin
    *
    * When loaded, it loads the included plugin files and add functions to hooks or filters. The class also handles the admin menu
    *
    * @since 0.1.0
    */
  class Developer_Toolkit {

      /**
    	 * Cron Manager Object
    	 *
    	 * @var object
    	 * @since 0.1.0
    	 */
    	public $cron_manager;

      /**
        * DT Version Number
        *
        * @var string
        * @since 0.1.0
        */
      public $version = '0.3.0';

      /**
    	  * Main Construct Function
    	  *
    	  * Call functions within class
    	  *
    	  * @since 0.1.0
        * @access public
    	  * @return void
    	  */
      function __construct() {
          $this->load_dependencies();
          $this->add_hooks();
      }

      /**
        * Defines the constant paths for use within the the plugin
        *
        * @since  0.2.3
        * @access public
        * @return void
        */
      public function constants() {
          //TODO: define tha various constants require by the plugin
      }

      /**
        * Loads the framework files supported by themes.  Functionality in these files should
        * not be expected within the theme setup function.
        *
        * @since  2.0.0
        * @access public
        * @return void
        */
        public function includes() {
          //TODO: replace load_dependencies() with this function
        }    

        /**
          * Load admin files for the framework.
          *
          * @since  0.7.0
          * @access public
          * @return void
          */
        public function admin() {
            //TODO: add admin interface here
        }

      /**
    	  * Load File Dependencies
    	  *
    	  * @since 0.1.0
        * @access public
    	  * @return void
    	  */
      public function load_dependencies() {

          //TODO: move this to the includes() function
          include( "includes/wpdt_plugins_page.php" );
          include( "includes/wpdt_stats_page.php" );
          include( "includes/wpdt_about_page.php" );
          include( "includes/wpdt_shortcodes.php" );
          include( "includes/wpdt_update.php" );
          include( "includes/wpdt_cron.php" );
          include( "includes/wpdt_refresh.php" );

          $this->cron_manager = new WPDTCron();
      }

      /**
    	  * Add Hooks
    	  *
    	  * Adds functions to relavent hooks and filters
    	  *
    	  * @since 0.1.0
        * @access public
    	  * @return void
    	  */
      public function add_hooks() {
          add_action( 'admin_menu', array( $this, 'setup_admin_menu') );
          add_action( 'init', array( $this, 'register_post_types') );
          add_action( 'plugins_loaded',  array( $this, 'setup_translations') );
          add_action( 'admin_head', array( $this, 'admin_head'), 900 );
          add_action( 'admin_init','wpdt_update' );
      }

      /**
        * Creates Custom Post Types
        *
        * Creates custom post type for plugins
        *
        * @since 0.1.0
        * @access public
        */
      public function register_post_types() {

          //TODO: move this to seperate file
          $labels = array(
          	'name'               => 'Plugins',
          	'singular_name'      => 'Plugin',
          	'menu_name'          => 'Plugin',
          	'name_admin_bar'     => 'Plugin',
          	'add_new'            => 'Add New',
          	'add_new_item'       => 'Add New Plugin',
          	'new_item'           => 'New Plugin',
          	'edit_item'          => 'Edit Plugin',
          	'view_item'          => 'View Plugin',
          	'all_items'          => 'All Plugins',
          	'search_items'       => 'Search Plugins',
          	'parent_item_colon'  => 'Parent Plugin:',
          	'not_found'          => 'No Plugin Found',
          	'not_found_in_trash' => 'No Plugin Found In Trash'
          );

          $args = array(
          	'show_ui' => false,
          	'show_in_nav_menus' => false,
          	'labels' => $labels,
          	'publicly_queryable' => false,
          	'exclude_from_search' => true,
          	'label'  => 'Plugins',
          	'rewrite' => array('slug' => 'plugin'),
          	'has_archive'        => false,
          	'supports'           => array( 'title', 'editor', 'author' )
          );

          register_post_type( 'plugin', $args );
      }

      /**
    	  * Setup Admin Menu
    	  *
    	  * Creates the admin menu and pages for the plugin and attaches functions to them
    	  *
    	  * @since 0.1.0
        * @access public
    	  * @return void
    	  */
    	public function setup_admin_menu() {

        //TODO: move this to a seperate file and it will be loaded from admin() function
        if ( function_exists('add_menu_page') ) {
          add_menu_page('WP Dev Toolkit', 'WP Dev Toolkit', 'moderate_comments', __FILE__, array('WPDTPluginPage','generate_page'), 'dashicons-flag');
          add_submenu_page(__FILE__, __('Stats', 'developer-toolkit'), __('Stats', 'developer-toolkit'), 'moderate_comments', 'wpdt_stats', array('WPDTStatsPage','generate_page'));
        }

        add_dashboard_page(
        	__( 'WPDT About', 'developer-toolkit' ),
        	__( 'WPDT About', 'developer-toolkit' ),
        	'manage_options',
        	'wpdt_about',
        	array('WPDTAboutPage', 'generate_page')
        );
      }

      /**
        * Removes Unnecessary Admin Page
        *
        * Removes the update, quiz settings, and quiz results pages from the Quiz Menu
        *
        * @since 4.1.0
        * @access public
        * @return void
        */
    	public function admin_head() {
          remove_submenu_page( 'index.php', 'wpdt_about' );
    	}

      /**
    	  * Loads the plugin language files
    	  *
    	  * @since 0.1.0
        * @access public
    	  * @return void
    	  */
    	public function setup_translations() {
          load_plugin_textdomain( 'developer-toolkit', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    	}
  }

}

$wp_developer_toolkit = new Developer_Toolkit();