<?php
    /*
    Plugin Name: Profile Builder - MailChimp Add-On
    Plugin URI: http://www.cozmoslabs.com/wordpress-profile-builder/
    Description: Easily associate MailChimp list fields with Profile Builder fields and set advanced settings for each list. Also, make use of the Profile Builder MailChimp Widget to add more subscribers to your lists.
    Version: 1.1.5
    Author: Cozmoslabs, Mihai Iova
    Author URI: http://www.cozmoslabs.com/
    License: GPL2

    == Copyright ==
    Copyright 2014 Cozmoslabs (www.cozmoslabs.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
    */


    /*
     * Define plugin path and include dependencies
     *
     */
    define('WPPBMCI_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . dirname( plugin_basename(__FILE__) ));
    define('WPPBMCI_PLUGIN_URL', plugin_dir_url(__FILE__));

    // Include the needed API
    if (file_exists(WPPBMCI_PLUGIN_DIR . '/mailchimp/mailchimp-api.php'))
        include_once(WPPBMCI_PLUGIN_DIR . '/mailchimp/mailchimp-api.php');

    // Include the file with general functions
    if (file_exists(WPPBMCI_PLUGIN_DIR . '/admin/functions.php'))
        include_once(WPPBMCI_PLUGIN_DIR . '/admin/functions.php');

    // Include the file that manages manage fields
    if (file_exists(WPPBMCI_PLUGIN_DIR . '/admin/manage-fields.php'))
        include_once(WPPBMCI_PLUGIN_DIR . '/admin/manage-fields.php');

    // Include the file for the subpage
    if (file_exists(WPPBMCI_PLUGIN_DIR . '/admin/mailchimp-page.php'))
        include_once(WPPBMCI_PLUGIN_DIR . '/admin/mailchimp-page.php');

    // Include the file for widget
    if (file_exists(WPPBMCI_PLUGIN_DIR . '/admin/widget.php'))
        include_once(WPPBMCI_PLUGIN_DIR . '/admin/widget.php');

    // Include the file for the custom field
    if (file_exists(WPPBMCI_PLUGIN_DIR . '/front-end/mailchimp-field.php'))
        include_once(WPPBMCI_PLUGIN_DIR . '/front-end/mailchimp-field.php');


    /*
     * Check for updates
     *
     */
    if (file_exists(WPPBMCI_PLUGIN_DIR . '/update/update-checker.php')) {
        include_once(WPPBMCI_PLUGIN_DIR . '/update/update-checker.php');

        //we don't know what version we have installed so we need to check both
        $localSerial = get_option('wppb_profile_builder_pro_serial');
        if( empty( $localSerial ) )
            $localSerial = get_option('wppb_profile_builder_hobbyist_serial');

        $wppb_mci_update = new wppb_PluginUpdateChecker('http://updatemetadata.cozmoslabs.com/?localSerialNumber=' . $localSerial . '&uniqueproduct=CLPBMC', __FILE__, 'wppb-mci-add-on');
    }


    /*
     * Function that fires up on add-on activation and saved data
     *
     * @since v.1.0.0
     *
     */
    function wppb_mci_activation() {
        if( get_option( 'wppb_mailchimp_api_key_validated', 'not_found' ) == 'not_found' )
            add_option( 'wppb_mailchimp_api_key_validated', false );
    }
    register_activation_hook( __FILE__, 'wppb_mci_activation' );


    /*
     * Function that enqueues the necessary scripts in the admin area
     *
     * @since v.1.0.0
     *
     */
    function wppb_mci_scripts_and_styles_admin() {
        wp_enqueue_script( 'wppb-mailchimp-integration', plugin_dir_url(__FILE__) . 'assets/js/main.js', array( 'jquery' ) );
        wp_enqueue_style( 'wppb-mailchimp-integration', plugin_dir_url(__FILE__) . 'assets/css/style-back-end.css' );
    }
    add_action( 'admin_enqueue_scripts', 'wppb_mci_scripts_and_styles_admin' );


    /*
     * Function that enqueues the necessary scripts in the front end area
     *
     * @since v.1.0.0
     *
     */
    function wppb_mci_scripts_and_styles_front_end() {
        wp_enqueue_style( 'wppb-mailchimp-integration', plugin_dir_url(__FILE__) . 'assets/css/style-front-end.css' );
    }
    add_action( 'wp_enqueue_scripts', 'wppb_mci_scripts_and_styles_front_end' );


    /*
     * Function that registers the settings for the MailChimp options page
     *
     * @since v1.0.0
     *
     */
    function wppb_mci_register_settings() {
        register_setting( 'wppb_mci_settings', 'wppb_mci_settings', 'wppb_mci_settings_sanitize' );
    }
    if ( is_admin() ) {
        add_action('admin_init', 'wppb_mci_register_settings');
    }


    /*
     * Function that handles the visibility of the field
     *
     * @since v.1.0.0
     *
     * @param bool $display_field      - By default true, to continue displaying the field
     * @param array $field             - The current field
     * @param string $form_location    - The location of the form. It can be register, edit_profile and back_end
     * @param string $form_role        - The role that will be attributed by default to new users
     * @param int $user_id
     *
     * @return bool
     */
    function wppb_mci_handle_output_display_state( $display_field, $field, $form_location, $form_role, $user_id ) {
        if( $form_location != 'register' && $field['field'] == 'MailChimp Subscribe' && isset( $field['mailchimp-hide-field'] ) && $field['mailchimp-hide-field'] == 'yes' ) {
            $display_field = false;
        }

        return $display_field;
    }
    add_filter( 'wppb_output_display_form_field', 'wppb_mci_handle_output_display_state', 10, 5 );


    /*
     * Function that returns the request name of a field
     *
     * @since v.1.0.0
     *
     * @param array $field  - The field from the manage fields option
     *
     * @return string
     *
     */
    function wppb_mci_get_request_name( $field ) {

        switch( $field['field'] ) {
            case 'Default - Username':
                return 'username';
                break;
            case 'Default - E-mail':
                return 'email';
                break;
            case 'Default - Website':
                return 'website';
                break;
            case 'Default - Biographical Info':
                return 'description';
                break;
            case 'Default - Display name publicly as':
                return 'display_name';
                break;
            case 'Select (User Role)':
                return 'custom_field_user_role';
                break;
            default:
                return $field['meta-name'];
                break;
        }

    }

    /**
     * Initialize the translation for the Plugin.
     * @since v.1.0
     * @return null
     */
    function wppb_mci_init_translation(){
        $current_theme = wp_get_theme();
        if( !empty( $current_theme->stylesheet ) && file_exists( get_theme_root().'/'. $current_theme->stylesheet .'/local_pb_lang' ) )
            load_plugin_textdomain( 'profile-builder-mailchimp-add-on', false, basename( dirname( __FILE__ ) ).'/../../themes/'.$current_theme->stylesheet.'/local_pb_lang' );
        else
            load_plugin_textdomain( 'profile-builder-mailchimp-add-on', false, basename(dirname(__FILE__)) . '/translation/' );
    }
    add_action( 'init', 'wppb_mci_init_translation', 8 );