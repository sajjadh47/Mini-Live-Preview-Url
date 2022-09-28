<?php
/*
Plugin Name: Mini Live Preview URL
Plugin URI : https://github.com/Sajjad-Hossain-Sagor/Mini-Live-Preview-URL
Description: Mini Live Preview URL is a simple Wordpress plugin for adding live previews of links on mouse hover.
Version: 1.0.1
Author: Sajjad Hossain Sagor
Author URI: https://profiles.wordpress.org/sajjad67
Text Domain: wp-mini-live-preview-url
Domain Path: /languages

License: GPL2
This WordPress Plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

This free software is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this software. If not, see http://www.gnu.org/licenses/gpl-2.0.html.
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// ---------------------------------------------------------
// Define Plugin Folders Path
// ---------------------------------------------------------
define( "WPMLPU_PLUGIN_PATH", plugin_dir_path( __FILE__ ) );
define( "WPMLPU_PLUGIN_URL", plugin_dir_url( __FILE__ ) );

// Action to add some style and script
add_action( 'wp_enqueue_scripts', 'wpmlpu_enqueue_frontend_scripts' );

// add plugin url to site header
add_action( 'wp_head', function()
{
	echo "<script> var WPMLPU_PLUGIN_URL = '".WPMLPU_PLUGIN_URL."'</script>";
});

// add settings api wrapper
require WPMLPU_PLUGIN_PATH . '/includes/class.settings-api.php';

/**
 * Category & Taxonomy Settings Class
 *
 * @author Sajjad Hossain Sagor
 */
class WPMLPU_SETTINGS
{
    private $settings_api;

    function __construct()
    {    
        $this->settings_api = new WpMiniLivePreviewUrl_Settings_API;

        add_action( 'admin_init', array( $this, 'admin_init') );
        
        add_action( 'admin_menu', array( $this, 'admin_menu') );
    }

    public function admin_init()
    {
        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    public function admin_menu()
    {
        add_options_page( 'Mini Live Preview URL', 'Mini Live Preview URL', 'manage_options', 'wp-mini-live-preview-url.php', array( $this, 'render_mini_live_preview_url_settings' ) );
    }

    public function get_settings_sections()
    {
        $sections = array(
            array(
                'id'    => 'wpmlpu_basic_settings',
                'title' => __( 'General Settings', 'wp-mini-live-preview-url' )
            )
        );
        
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    public function get_settings_fields()
    {
		$settings_fields = array(
            'wpmlpu_basic_settings' => array(
                array(
                    'name'    => 'enable_preview',
                    'label'   => __( 'Enable URL Preview', 'wp-mini-live-preview-url' ),
                    'type'    => 'checkbox'
                )    
            )
        );

        return $settings_fields;
    }

    /**
     * Render settings fields
     *
     */

    public function render_mini_live_preview_url_settings()
    {    
        echo '<div class="wrap">';

	        $this->settings_api->show_navigation();
	       
	        $this->settings_api->show_forms();

        echo '</div>';
    }
}

/**
 * Returns option value
 *
 * @return string|array option value
 */

function wpmlpu_get_option( $option, $section, $default = '' )
{
    $options = get_option( $section );

    if ( isset( $options[$option] ) )
    {
        return $options[$option];
    }

    return $default;
}

$wpmlpu_settings = new WPMLPU_SETTINGS();

/**
 * Function to add frontend scripts and styles
 */
function wpmlpu_enqueue_frontend_scripts()
{
	$enable_preview = wpmlpu_get_option( 'enable_preview', 'wpmlpu_basic_settings' );

	if ( $enable_preview != 'on' ) return;
	
	// Enqueue Mini Preview CSS Files
	wp_enqueue_style( 'wpmlpu-minipreview-css',  	WPMLPU_PLUGIN_URL . 'assets/css/jquery.minipreview.css', array(), time() );	
	
	// Enqueue Mini Preview JS Files
	wp_enqueue_script( 'wpmlpu-minipreview-script', WPMLPU_PLUGIN_URL . 'assets/js/jquery.minipreview.js', array( 'jquery' ), time(), true );
	
    wp_enqueue_script( 'wpmlpu-main-script', 		WPMLPU_PLUGIN_URL . 'assets/js/script.js', array( 'wpmlpu-minipreview-script' ), time(), true );
}
