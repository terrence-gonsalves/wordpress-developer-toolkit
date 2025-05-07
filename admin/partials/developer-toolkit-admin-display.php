<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://profiles.wordpress.org/tegonsalves/
 * @since      1.0.0
 *
 * @package    Developer_Toolkit
 * @subpackage Developer_Toolkit/admin/partials
 */
?>

<div class="dtk-header">				
    <h1><?php _e( 'Developer Toolkit for WordPress', 'developer-toolkit' ); ?></h1>
    <h2 class="nav-tab-wrapper">
        <a href="javascript:wpdt_setTab(1);" id="tab_1" class="nav-tab nav-tab-active">
            <?php _e( "What's New!", 'developer-toolkit' ); ?>
        </a>
        <a href="javascript:wpdt_setTab(2);" id="tab_2" class="nav-tab">
            <?php _e( 'Changelog', 'developer-toolkit' ); ?>
        </a>
    </h2>
</div>
