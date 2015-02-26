<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
  * This class is the main class of the plugin
  *
  * When loaded, it loads the included plugin files and add functions to hooks or filters. The class also handles the admin menu
  *
  * @since 0.1.0
  */
class WPDTShortcodes
{
    /**
  	  * Main Construct Function
  	  *
  	  * Call functions within class
  	  *
  	  * @since 0.1.0
  	  * @uses WPDTShortcodes::load_dependencies() Loads required filed
  	  * @uses WPDTShortcodes::add_hooks() Adds actions to hooks and filters
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
      add_shortcode('plugin_desc', array($this, 'display_description'));
      add_shortcode('plugin_link', array($this, 'display_download_link'));
    }

    /**
     * Shortcode To Display Plugin Description
     *
     * @since 0.1.0
     */
    public function display_description($atts)
    {
      extract(shortcode_atts(array(
  			'id' => 0
  		), $atts));

      $shortcode = '';
      $id = intval($id);

      $my_query = new WP_Query(array('post_type' => 'plugin', 'p' => $id));
			if( $my_query->have_posts() )
			{
			  while( $my_query->have_posts() )
				{
			    $my_query->the_post();
          $shortcode .= get_post_meta( get_the_ID(), 'description', true );
			  }
			}
			wp_reset_postdata();
      return $shortcode;
    }

    /**
     * Shortcode To Display Plugin Download Link
     *
     * @since 0.1.0
     */
    public function display_download_link($atts)
    {
      extract(shortcode_atts(array(
  			'id' => 0
  		), $atts));

      $shortcode = '';
      $id = intval($id);

      $my_query = new WP_Query(array('post_type' => 'plugin', 'p' => $id));
			if( $my_query->have_posts() )
			{
			  while( $my_query->have_posts() )
				{
			    $my_query->the_post();
          $link = get_post_meta( get_the_ID(), 'download_link', true );
          $shortcode .= "<a href='$link'>Download</a>";
			  }
			}
			wp_reset_postdata();
      return $shortcode;
    }
}
$wpdtShortcodes = new WPDTShortcodes();
?>
