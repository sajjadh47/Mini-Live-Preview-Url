<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @package           Mini_Live_Preview_Url
 * @author            Sajjad Hossain Sagor <sagorh672@gmail.com>
 *
 * Plugin Name:       Mini Live Preview URL
 * Plugin URI:        https://wordpress.org/plugins/mini-live-preview-url/
 * Description:       Mini Live Preview URL is a simple WordPress plugin for adding live previews of links on mouse hover.
 * Version:           2.0.4
 * Requires at least: 5.6
 * Requires PHP:      8.0
 * Author:            Sajjad Hossain Sagor
 * Author URI:        https://sajjadhsagor.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mini-live-preview-url
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'MINI_LIVE_PREVIEW_URL_PLUGIN_VERSION', '2.0.4' );

/**
 * Define Plugin Folders Path
 */
define( 'MINI_LIVE_PREVIEW_URL_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

define( 'MINI_LIVE_PREVIEW_URL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

define( 'MINI_LIVE_PREVIEW_URL_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mini-live-preview-url-activator.php
 *
 * @since    2.0.0
 */
function on_activate_mini_live_preview_url() {
	require_once MINI_LIVE_PREVIEW_URL_PLUGIN_PATH . 'includes/class-mini-live-preview-url-activator.php';

	Mini_Live_Preview_Url_Activator::on_activate();
}

register_activation_hook( __FILE__, 'on_activate_mini_live_preview_url' );

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mini-live-preview-url-deactivator.php
 *
 * @since    2.0.0
 */
function on_deactivate_mini_live_preview_url() {
	require_once MINI_LIVE_PREVIEW_URL_PLUGIN_PATH . 'includes/class-mini-live-preview-url-deactivator.php';

	Mini_Live_Preview_Url_Deactivator::on_deactivate();
}

register_deactivation_hook( __FILE__, 'on_deactivate_mini_live_preview_url' );

/**
 * The core plugin class that is used to define admin-specific and public-facing hooks.
 *
 * @since    2.0.0
 */
require MINI_LIVE_PREVIEW_URL_PLUGIN_PATH . 'includes/class-mini-live-preview-url.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    2.0.0
 */
function run_mini_live_preview_url() {
	$plugin = new Mini_Live_Preview_Url();

	$plugin->run();
}

run_mini_live_preview_url();
