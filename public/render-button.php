<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Render the promotion button.
 */
function carok_wpb_render_button() {
    $settings = carok_wpb_get_settings();

    // Check if button link and text are set
    if ( empty( $settings['button_link'] ) || empty( $settings['button_text'] ) ) {
        return;
    }

    // Determine the position class
    $position_class = $settings['position'] === 'top' ? 'carok-wpb-top' : 'carok-wpb-bottom';

    // Determine link target
    $link_target = $settings['link_target'] === 'new' ? '_blank' : '_self';

    // Generate inline styles
    $inline_styles = sprintf(
        '.carok-wpb-button { background-color: %s; color: %s; font-size: %spx; font-weight: %s; transition: all ease 1s; }
         .carok-wpb-button:hover { background-color: %s; color: %s; }',
        esc_attr( $settings['bg_color'] ),
        esc_attr( $settings['text_color'] ),
        esc_attr( $settings['font_size'] ),
        esc_attr( $settings['font_weight'] ),
        esc_attr( $settings['bg_hover_color'] ),
        esc_attr( $settings['text_hover_color'] )
    );

    // Output the button HTML
    echo '<style>' . esc_html( $inline_styles ) . '</style>';
    echo '<div class="carok-wpb-button ' . esc_attr( $position_class ) . '">';
    echo '<a href="' . esc_url( $settings['button_link'] ) . '" target="' . esc_attr( $link_target ) . '">' . esc_html( $settings['button_text'] ) . '</a>';
    echo '</div>';
}

// Hook the button rendering into appropriate actions
add_action( 'wp_footer', 'carok_wpb_render_button' );

// Add the button before the header if the position is set to top
if ( carok_wpb_get_settings()['position'] === 'top' ) {
    add_action( 'wp_body_open', 'carok_wpb_render_button' );
}
