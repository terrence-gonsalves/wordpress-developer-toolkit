<?php
/**
 * Plugin Name: WordPress Developer Toolkit
 * Plugin URI: http://mylocalwebstop.com
 * Description:
 * Author: Frank Corso
 * Author URI: http://mylocalwebstop.com
 * Version: 0.1.0
 *
 * Disclaimer of Warranties
 * The plugin is provided "as is". My Local Webstop and its suppliers and licensors hereby disclaim all warranties of any kind,
 * express or implied, including, without limitation, the warranties of merchantability, fitness for a particular purpose and non-infringement.
 * Neither My Local Webstop nor its suppliers and licensors, makes any warranty that the plugin will be error free or that access thereto will be continuous or uninterrupted.
 * You understand that you install, operate, and uninstall the plugin at your own discretion and risk.
 *
 * @author Frank Corso
 * @version 0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;


/**
  * This class is the main class of the plugin
  *
  * When loaded, it loads the included plugin files and add functions to hooks or filters. The class also handles the admin menu
  *
  * @since 0.1.0
  */
class MLWWPDeveloperToolkit
{
    /**
  	  * Main Construct Function
  	  *
  	  * Call functions within class
  	  *
  	  * @since 0.1.0
  	  * @uses MLWWPDeveloperToolkit::load_dependencies() Loads required filed
  	  * @uses MLWWPDeveloperToolkit::add_hooks() Adds actions to hooks and filters
  	  * @return void
  	  */
    function __construct()
    {
      $this->load_dependencies();
      $this->add_hooks();
    }

    /**
  	  * Load File Dependencies
  	  *
  	  * @since 0.1.0
  	  * @return void
  	  */
    public function load_dependencies()
    {
      include("php/wpdt_plugins.php");
    }

    /**
  	  * Add Hooks
  	  *
  	  * Adds functions to relavent hooks and filters
  	  *
  	  * @since 0.1.0
  	  * @return void
  	  */
    public function add_hooks()
    {
        add_action('admin_menu', array( $this, 'setup_admin_menu'));
        add_action('init', array( $this, 'register_post_types'));
    }

    /**
     * Creates Custom Post Types
     *
     * Creates custom post type for plugins
     *
     * @since 0.1.0
     */
    public function register_post_types()
    {
      $labels = array(
  			'name'               => 'Quizzes',
  			'singular_name'      => 'Quiz',
  			'menu_name'          => 'Quiz',
  			'name_admin_bar'     => 'Quiz',
  			'add_new'            => 'Add New',
  			'add_new_item'       => 'Add New Quiz',
  			'new_item'           => 'New Quiz',
  			'edit_item'          => 'Edit Quiz',
  			'view_item'          => 'View Quiz',
  			'all_items'          => 'All Quizzes',
  			'search_items'       => 'Search Quizzes',
  			'parent_item_colon'  => 'Parent Quiz:',
  			'not_found'          => 'No Quiz Found',
  			'not_found_in_trash' => 'No Quiz Found In Trash'
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
  	  * @return void
  	  */
  	public function setup_admin_menu()
  	{
  		if (function_exists('add_menu_page'))
  		{
        add_menu_page('WP Dev Toolkit', __('WP Dev Toolkit', 'quiz-master-next'), 'moderate_comments', __FILE__, array('WPDTPluginPage','generate_page'), 'dashicons-feedback');
      }
    }
}
$mlwWPDeveloperToolkit = new MLWWPDeveloperToolkit();
?>
