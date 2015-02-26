<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
  * This class is the main class of the plugin
  *
  * When loaded, it loads the included plugin files and add functions to hooks or filters. The class also handles the admin menu
  *
  * @since 0.1.0
  */
class WPDTPluginPage
{
    /**
  	  * Main Construct Function
  	  *
  	  * Call functions within class
  	  *
  	  * @since 0.1.0
  	  * @uses WPDTPluginPage::load_dependencies() Loads required filed
  	  * @uses WPDTPluginPage::add_hooks() Adds actions to hooks and filters
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

    }

    /**
     * Generates The Content For The Admin Page
     *
     * @since 0.1.0
     */
    public function generate_page()
    {
      if (isset($_POST["new_plugin"]))
      {
        $new_plugin = sanitize_text_field($_POST["new_plugin"]);
        $response = wp_remote_get( "http://api.wordpress.org/plugins/info/1.0/$new_plugin" );
        $plugin_info = unserialize( $response['body'] );
        $ratings = round(($plugin_info->rating/20), 1);
        global $current_user;
  			get_currentuserinfo();
  			$new_plugin_args = array(
  			  'post_title'    => $plugin_info->name,
  			  'post_content'  => "",
  			  'post_status'   => 'publish',
  			  'post_author'   => $current_user->ID,
  			  'post_type' => 'plugin'
  			);
  			$new_plugin_id = wp_insert_post( $new_plugin_args );
  			add_post_meta( $new_plugin_id, 'plugin_slug', $new_plugin );
        add_post_meta( $new_plugin_id, 'average_review', $ratings );
        add_post_meta( $new_plugin_id, 'downloads', $plugin_info->downloaded );
        add_post_meta( $new_plugin_id, 'version', $plugin_info->version );
        add_post_meta( $new_plugin_id, 'last_updated', $plugin_info->last_updated );
        add_post_meta( $new_plugin_id, 'description', $plugin_info->sections["description"] );
        add_post_meta( $new_plugin_id, 'download_link', $plugin_info->download_link );
      }
      $plugin_array = array();
      $my_query = new WP_Query( array('post_type' => 'plugin') );
    	if( $my_query->have_posts() )
    	{
    	  while( $my_query->have_posts() )
    		{
    	    $my_query->the_post();
          $plugin_array[] = array(
            'id' => get_the_ID(),
            'name' => get_the_title(),
            'slug' => get_post_meta( get_the_ID(), 'plugin_slug', true ),
            'permalink' => get_the_permalink(),
            'average_review' => get_post_meta( get_the_ID(), 'average_review', true ),
            'downloads' => get_post_meta( get_the_ID(), 'downloads', true ),
            'last_updated' => get_post_meta( get_the_ID(), 'last_updated', true ),
            'version' => get_post_meta( get_the_ID(), 'version', true ),
          );
    	  }
    	}
    	wp_reset_postdata();
      ?>
      <div class="wrap">
          <h2>WordPress Developer Toolkit</h2>
          <table class="widefat">
            <thead>
              <tr>
                <th>ID</th>
                <th>Plugin</th>
                <th>Average Review</th>
                <th>Downloads</th>
                <th>Version</th>
                <th>Last Updated</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($plugin_array as $plugin)
              {
                echo "<tr>";
                echo "<td>".$plugin["id"]."</td>";
                echo "<td>".$plugin["name"]."</td>";
                echo "<td>".$plugin["average_review"]."</td>";
                echo "<td>".$plugin["downloads"]."</td>";
                echo "<td>".$plugin["version"]."</td>";
                echo "<td>".$plugin["last_updated"]."</td>";
                echo "</tr>";
              }
              ?>
            </tbody>
            <tfoot>
              <tr>
                <th>ID</th>
                <th>Plugin</th>
                <th>Average Review</th>
                <th>Downloads</th>
                <th>Version</th>
                <th>Last Updated</th>
              </tr>
            </tfoot>
          </table>
          <form action="" method="post">
            <label>New Plugin</label>
            <input type="text" name="new_plugin" />
            <input type="submit" value="Add Plugin" />
          </form>
      </div>
      <?php
    }
}
?>
