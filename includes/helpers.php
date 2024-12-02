<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Helper function to retrieve plugin settings with defaults.
 *
 * @return array
 */
function carok_wpb_get_settings() {
    $defaults = array(
        'button_text'       => __( 'Click Me', 'carok-wp-promotion-button' ),
        'button_link'       => '#',
        'link_target'       => 'self',
        'custom_css'        => '',
        'position'          => 'top',
        'bg_color'          => '#ff6600',
        'bg_hover_color'    => '#cc5200',
        'text_color'        => '#ffffff',
        'text_hover_color'  => '#ffffff',
        'font_size'         => 16,
        'font_weight'       => 'normal',
    );

    $settings = get_option( 'carok_wpb_settings', array() );
    return wp_parse_args( $settings, $defaults );
}

/**
 * Helper function to sanitize and validate settings.
 *
 * @param array $settings Raw settings data.
 * @return array Sanitized settings data.
 */
function carok_wpb_sanitize_settings( $settings ) {
    return array(
        'button_text'       => sanitize_text_field( $settings['button_text'] ?? '' ),
        'button_link'       => esc_url_raw( $settings['button_link'] ?? '' ),
        'link_target'       => $settings['link_target'] === 'new' ? 'new' : 'self',
        'custom_css'        => sanitize_textarea_field( $settings['custom_css'] ?? '' ),
        'position'          => $settings['position'] === 'top' ? 'top' : 'bottom',
        'bg_color'          => sanitize_hex_color( $settings['bg_color'] ?? '#ff6600' ),
        'bg_hover_color'    => sanitize_hex_color( $settings['bg_hover_color'] ?? '#cc5200' ),
        'text_color'        => sanitize_hex_color( $settings['text_color'] ?? '#ffffff' ),
        'text_hover_color'  => sanitize_hex_color( $settings['text_hover_color'] ?? '#ffffff' ),
        'font_size'         => absint( $settings['font_size'] ?? 16 ),
        'font_weight'       => sanitize_text_field( $settings['font_weight'] ?? 'normal' ),
    );
}
