<?php
function carok_wpb_add_admin_menu() {
    add_menu_page(
        esc_html__( 'Promotion Button', 'carok-wp-promotion-button' ),
        esc_html__( 'Promotion Button', 'carok-wp-promotion-button' ),
        'manage_options',
        'carok-wp-promotion-button',
        'carok_wpb_admin_page',
        'dashicons-megaphone',
        20
    );
}
add_action( 'admin_menu', 'carok_wpb_add_admin_menu' );

function carok_wpb_admin_page() {
    if ( isset( $_POST['carok_wpb_save_settings'] ) ) {
        // Check user capabilities
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'You are not allowed to perform this action.', 'carok-wp-promotion-button' ) );
        }

        // Verify nonce
        if ( ! isset( $_POST['carok_wpb_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['carok_wpb_nonce'] ) ), 'carok_wpb_save_settings' ) ) {
            wp_die( esc_html__( 'Invalid nonce verification.', 'carok-wp-promotion-button' ) );
        }

        // Sanitize and validate settings
        $settings = array(
            'button_text'       => isset( $_POST['button_text'] ) ? sanitize_text_field( wp_unslash( $_POST['button_text'] ) ) : '',
            'button_link'       => isset( $_POST['button_link'] ) ? esc_url_raw( wp_unslash( $_POST['button_link'] ) ) : '',
            'link_target'       => isset( $_POST['link_target'] ) ? sanitize_text_field( wp_unslash( $_POST['link_target'] ) ) : 'self',
            'custom_css'        => isset( $_POST['custom_css'] ) ? sanitize_textarea_field( wp_unslash( $_POST['custom_css'] ) ) : '',
            'position'          => isset( $_POST['position'] ) ? sanitize_text_field( wp_unslash( $_POST['position'] ) ) : 'bottom',
            'bg_color'          => isset( $_POST['bg_color'] ) ? sanitize_hex_color( wp_unslash( $_POST['bg_color'] ) ) : '#ff6600',
            'bg_hover_color'    => isset( $_POST['bg_hover_color'] ) ? sanitize_hex_color( wp_unslash( $_POST['bg_hover_color'] ) ) : '#cc5200',
            'text_color'        => isset( $_POST['text_color'] ) ? sanitize_hex_color( wp_unslash( $_POST['text_color'] ) ) : '#ffffff',
            'text_hover_color'  => isset( $_POST['text_hover_color'] ) ? sanitize_hex_color( wp_unslash( $_POST['text_hover_color'] ) ) : '#ffffff',
            'font_size'         => isset( $_POST['font_size'] ) ? absint( wp_unslash( $_POST['font_size'] ) ) : 16,
            'font_weight'       => isset( $_POST['font_weight'] ) ? sanitize_text_field( wp_unslash( $_POST['font_weight'] ) ) : 'normal',
        );


        // Update the plugin options
        update_option( 'carok_wpb_settings', $settings );

        // Add a success message
        add_settings_error(
            'carok_wpb_messages',
            'carok_wpb_message',
            esc_html__( 'Settings saved successfully.', 'carok-wp-promotion-button' ),
            'updated'
        );
    }

    // Display any settings errors
    settings_errors( 'carok_wpb_messages' );

    // Retrieve the current settings
    $settings = get_option( 'carok_wpb_settings', array() );
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Promotion Button Settings', 'carok-wp-promotion-button' ); ?></h1>
        <form method="post">
            <?php wp_nonce_field( 'carok_wpb_save_settings', 'carok_wpb_nonce' ); ?>
            <table class="form-table">
                <tr>
                    <th><label for="button_text"><?php esc_html_e( 'Button Text', 'carok-wp-promotion-button' ); ?></label></th>
                    <td><input type="text" id="button_text" name="button_text" value="<?php echo esc_attr( $settings['button_text'] ?? '' ); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="button_link"><?php esc_html_e( 'Button Link', 'carok-wp-promotion-button' ); ?></label></th>
                    <td><input type="url" id="button_link" name="button_link" value="<?php echo esc_url( $settings['button_link'] ?? '' ); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="link_target"><?php esc_html_e( 'Open in New Tab', 'carok-wp-promotion-button' ); ?></label></th>
                    <td><input type="checkbox" id="link_target" name="link_target" <?php checked( $settings['link_target'] ?? '', 'new' ); ?>></td>
                </tr>
                <tr>
                    <th><label for="position"><?php esc_html_e( 'Position', 'carok-wp-promotion-button' ); ?></label></th>
                    <td>
                        <select id="position" name="position">
                            <option value="top" <?php selected( $settings['position'] ?? '', 'top' ); ?>><?php esc_html_e( 'Top', 'carok-wp-promotion-button' ); ?></option>
                            <option value="bottom" <?php selected( $settings['position'] ?? '', 'bottom' ); ?>><?php esc_html_e( 'Bottom', 'carok-wp-promotion-button' ); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="bg_color"><?php esc_html_e( 'Background Color', 'carok-wp-promotion-button' ); ?></label></th>
                    <td><input type="color" id="bg_color" name="bg_color" value="<?php echo esc_attr( $settings['bg_color'] ?? '#ff6600' ); ?>"></td>
                </tr>
                <tr>
                    <th><label for="bg_hover_color"><?php esc_html_e( 'Background Hover Color', 'carok-wp-promotion-button' ); ?></label></th>
                    <td><input type="color" id="bg_hover_color" name="bg_hover_color" value="<?php echo esc_attr( $settings['bg_hover_color'] ?? '#cc5200' ); ?>"></td>
                </tr>
                <tr>
                    <th><label for="text_color"><?php esc_html_e( 'Text Color', 'carok-wp-promotion-button' ); ?></label></th>
                    <td><input type="color" id="text_color" name="text_color" value="<?php echo esc_attr( $settings['text_color'] ?? '#ffffff' ); ?>"></td>
                </tr>
                <tr>
                    <th><label for="text_hover_color"><?php esc_html_e( 'Text Hover Color', 'carok-wp-promotion-button' ); ?></label></th>
                    <td><input type="color" id="text_hover_color" name="text_hover_color" value="<?php echo esc_attr( $settings['text_hover_color'] ?? '#ffffff' ); ?>"></td>
                </tr>
                <tr>
                    <th><label for="font_size"><?php esc_html_e( 'Font Size (px)', 'carok-wp-promotion-button' ); ?></label></th>
                    <td><input type="number" id="font_size" name="font_size" value="<?php echo esc_attr( $settings['font_size'] ?? 16 ); ?>" min="10" max="50"></td>
                </tr>
                <tr>
                    <th><label for="font_weight"><?php esc_html_e( 'Font Weight', 'carok-wp-promotion-button' ); ?></label></th>
                    <td>
                        <select id="font_weight" name="font_weight">
                            <option value="normal" <?php selected( $settings['font_weight'] ?? '', 'normal' ); ?>><?php esc_html_e( 'Normal', 'carok-wp-promotion-button' ); ?></option>
                            <option value="bold" <?php selected( $settings['font_weight'] ?? '', 'bold' ); ?>><?php esc_html_e( 'Bold', 'carok-wp-promotion-button' ); ?></option>
                            <option value="bolder" <?php selected( $settings['font_weight'] ?? '', 'bolder' ); ?>><?php esc_html_e( 'Bolder', 'carok-wp-promotion-button' ); ?></option>
                            <option value="lighter" <?php selected( $settings['font_weight'] ?? '', 'lighter' ); ?>><?php esc_html_e( 'Lighter', 'carok-wp-promotion-button' ); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="custom_css"><?php esc_html_e( 'Custom CSS', 'carok-wp-promotion-button' ); ?></label></th>
                    <td><textarea id="custom_css" name="custom_css" class="large-text"><?php echo esc_textarea( $settings['custom_css'] ?? '' ); ?></textarea></td>
                </tr>
            </table>
            <p class="submit">
                <input type="submit" name="carok_wpb_save_settings" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'carok-wp-promotion-button' ); ?>">
            </p>
        </form>
    </div>
    <?php
}
