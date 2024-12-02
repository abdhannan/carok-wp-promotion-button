<?php
/**
 * Plugin Name: Carok WP Promotion Button
 * Description: Plugin to display a promotional button in the top bar or as a fixed position at the bottom.
 * Version: 1.0.0
 * Author: Abd Hannan
 * Author URI: https://abdhannan.codes
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: carok-wp-promotion-button
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( defined( 'CAROK_WPB_VERSION' ) ) {
    return;
}

define( 'CAROK_WPB_VERSION', '1.0.0' );
define( 'CAROK_WPB_PATH', plugin_dir_path( __FILE__ ) );
define( 'CAROK_WPB_URL', plugin_dir_url( __FILE__ ) );

// Include necessary files
foreach ( array( 'includes/helpers.php', 'includes/enqueuer.php', 'admin/admin-page.php', 'public/render-button.php' ) as $file ) {
    $filepath = CAROK_WPB_PATH . $file;
    if ( file_exists( $filepath ) ) {
        require_once $filepath;
    } else {
        // Remove this line in production:
        // error_log( "File missing: $filepath" );
    }
}


// Activation Hook
register_activation_hook( __FILE__, 'carok_wpb_activate' );
function carok_wpb_activate() {
    add_option( 'carok_wpb_settings', array() );
}

// Deactivation Hook
register_deactivation_hook( __FILE__, 'carok_wpb_deactivate' );
function carok_wpb_deactivate() {
    // Optionally clean up settings
    // delete_option( 'carok_wpb_settings' );
}

/**
 * Load plugin textdomain for translations.
 */
function carok_wpb_load_textdomain() {
    load_plugin_textdomain( 'carok-wp-promotion-button', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'carok_wpb_load_textdomain' );
