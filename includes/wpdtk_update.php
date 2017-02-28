<?php
if ( ! defined( 'ABSPATH' ) ) exit;
function wpdt_update()
{
  global $wp_developer_toolkit;

  $data = $wp_developer_toolkit->version;

  if ( ! get_option( 'wpdt_version' ) ) {
    add_option( 'wpdt_version', $data );
  } elseif (  $data !== get_option( 'wpdt_version' ) ) {
    update_option('wpdt_version' , $data);

    if ( ! isset( $_GET['activate-multi'] ) ) {
      wp_safe_redirect( admin_url( 'index.php?page=wpdt_about' ) );
      exit;
    }
  }
}
