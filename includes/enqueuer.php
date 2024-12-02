<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Enqueue admin styles and scripts.
 */
function carok_wpb_enqueue_admin_assets( $hook ) {
    // Only load on the plugin's admin page
    if ( $hook !== 'toplevel_page_carok-wordpress-promotion-button' ) {
        return;
    }

    wp_enqueue_style(
        'carok-wpb-admin-styles',
        CAROK_WPB_URL . 'assets/css/admin-styles.css',
        array(),
        '1.0.0'
    );
    wp_enqueue_script(
        'carok-wpb-admin-scripts',
        CAROK_WPB_URL . 'assets/js/admin-scripts.js',
        array( 'jquery' ),
        '1.0.0',
        true
    );

    // Localize script to pass data to JavaScript
    wp_localize_script( 'carok-wpb-admin-scripts', 'carok_wpb_admin', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
    ) );
}
add_action( 'admin_enqueue_scripts', 'carok_wpb_enqueue_admin_assets' );

/**
 * Enqueue public styles.
 */
function carok_wpb_enqueue_public_assets() {
    wp_enqueue_style(
        'carok-wpb-styles',
        CAROK_WPB_URL . 'public/styles.css',
        array(),
        '1.0.0'
    );

    // Inject custom CSS from settings
    $settings = carok_wpb_get_settings();

    // Ensure only valid CSS is injected
    if ( ! empty( $settings['custom_css'] ) ) {
        wp_add_inline_style( 'carok-wpb-styles', wp_strip_all_tags( $settings['custom_css'] ) );
    }
}
add_action( 'wp_enqueue_scripts', 'carok_wpb_enqueue_public_assets' );
