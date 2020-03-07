<?php

    class WPPB_Mailchimp_Widget extends WP_Widget {

        /*
         * Register widget with WordPress.
         *
         * @since v.1.0.0
         *
         */
        function __construct() {
            parent::__construct(
                'wppb_mailchimp_widget',
                __( 'Profile Builder MailChimp Widget', 'profile-builder-mailchimp-add-on' ),
                array( 'description' => __( 'Adds a basic subscribe form so that your users can subscribe to your MailChimp lists', 'profile-builder-mailchimp-add-on' ), )
            );

            add_action( 'wp_ajax_display_list_fields', array( $this, 'display_list_fields' ) );
        }


        /*
         * Function that returns the saved values for a instance
         *
         * @since v.1.0.0
         *
         * @param int $widget_number    - The instance number
         *
         */
        public function get_instance( $widget_number = '' ) {

            if( empty( $widget_number ) )
                $widget_number = $this->number;

            $option = get_option( $this->option_name );
            $instance = $option[ $widget_number ];

            return $instance;
        }


        /*
         * Function that displays the widget in the front-end
         *
         * @since v.1.0.0
         *
         * @param array $args     Widget arguments.
         * @param array $instance Saved values from database.
         *
         */
        public function widget( $args, $instance ) {

            $validate_response = $this->validate_front_end_form();

            $wppb_mci_api_key_validated = get_option('wppb_mailchimp_api_key_validated', false);
            $wppb_mci_api_key = wppb_mci_get_api_key();


            // If the key is invalid or missing display an error message to the admins
            if( ( !$wppb_mci_api_key_validated || empty( $wppb_mci_api_key ) ) && current_user_can( 'manage_options' ) ) {

                echo $args['before_widget'];

                if ( ! empty( $instance['title'] ) ) {
                    echo $args['before_title'] . apply_filters( 'wpp_mci_widget_title', $instance['title'] ). $args['after_title'];
                }

                echo __( 'Something went wrong. Either the MailChimp API key is missing or it is invalid.', 'profile-builder-mailchimp-add-on' );

                echo $args['after_widget'];

            // If API key is okay display the form
            } else {

                echo $args['before_widget'];

                if ( ! empty( $instance['title'] ) ) {
                    echo $args['before_title'] . apply_filters( 'wpp_mci_widget_title', $instance['title'] ). $args['after_title'];
                }

                if( $validate_response['success'] == 1 ) {

                    $response = wppb_mci_api_subscribe( $wppb_mci_api_key, $validate_response['subscribe_arguments'] );

                    if( isset( $response['euid'] ) ) {

                        echo '<div class="wppb-mci-widget-subscribe-success-wrapper">';
                            if( $instance['double_opt_in'] == 'on' )
                                echo '<p class="wppb-mci-widget-subscribe-success-message">' . sprintf( __( '%s', 'profile-builder-mailchimp-add-on' ), apply_filters( 'wppb_mci_widget_subscribe_new_success_double_opt_in', 'A confirmation e-mail has been sent to the e-mail address you have provided' ) ) . '</p>';
                            else
                                echo '<p class="wppb-mci-widget-subscribe-success-message">' . sprintf( __( '%s', 'profile-builder-mailchimp-add-on' ), apply_filters( 'wppb_mci_widget_subscribe_new_success', 'You have been subscribed to our newsletter' ) ) . '</p>';
                        echo '</div>';

                    }

                } else {

                    if (!empty($instance['list_id']) && !empty($instance['lists_fields'])) {
                        echo '<form enctype="multipart/form-data" method="POST" action="' . apply_filters('wppb_mci_widget_subscribe_form_action', '') . '">';

                        // Add hidden inputs with the list ids
                        echo '<input type="hidden" name="wppb_mci_list_id" value="' . $instance['list_id'] . '" />';

                        foreach ($instance['lists_fields'] as $key => $list_field) {

                            if (isset($list_field['tag']) && !empty($list_field['tag'])) {

                                // Asign error class to variable if we have errors
                                $error_class = '';
                                if (isset( $validate_response['success'] ) && $validate_response['success'] == 0 && isset($validate_response['fields'][$list_field['tag']]) && isset($validate_response['fields'][$list_field['tag']]['errors']) ) {
                                    $error_class = 'wppb-mci-widget-field-error';
                                }

                                // Field wrapper
                                echo '<div class="wppb-mci-widget-field-wrapper ' . $error_class . '">';

                                // Display field label
                                echo '<label for="wppb_mci_widget_request_' . $key . '">' . $list_field['name'] . '</label>';

                                // Display required span if field is required
                                if ($list_field['req'])
                                    echo '<span class="wppb-mci-widget-field-required">' . apply_filters('wppb_mci_widget_field_required', '*') . '</span>';

                                // If there was an error get the values that were sent
                                $field_value = '';
                                if (isset($validate_response['success']) && $validate_response['success'] == 0 && isset($validate_response['fields'][$list_field['tag']]) && isset($validate_response['fields'][$list_field['tag']]['value'])) {
                                    $field_value = $validate_response['fields'][$list_field['tag']]['value'];
                                }

                                // Display the actual input
                                echo '<input type="text" id="wppb_mci_widget_request_' . $key . '" name="wppb_mci_widget_request_' . $list_field['tag'] . '" value="' . $field_value . '" />';

                                // Display field errors under the input if there are any
                                if (isset($validate_response['success']) && $validate_response['success'] == 0 && isset($validate_response['fields'][$list_field['tag']]) && isset($validate_response['fields'][$list_field['tag']]['errors'])) {
                                    foreach ($validate_response['fields'][$list_field['tag']]['errors'] as $error) {
                                        echo '<div class="wppb-mci-widget-field-error-message-wrapper"><span class="wppb-mci-widget-field-error-message">' . $error . '</span></div>';
                                    }
                                }

                                echo '</div>';

                            }

                        }

                        // Display the submit button
                        echo '<input type="submit" value="' . apply_filters('wppb_mci_widget_submit_button_text', __('Submit', 'profile-builder-mailchimp-add-on')) . '" />';

                        echo '</form>';
                    }

                }

                echo $args['after_widget'];

            }

        }

        /*
         * Function that displays the widget in the back-end
         *
         * @since v.1.0.0
         *
         * @param array $instance Previously saved values from database.
         *
         */
        public function form( $instance ) {

            $wppb_mci_api_key = wppb_mci_get_api_key();

            if( get_option('wppb_mailchimp_api_key_validated', false) && !empty( $wppb_mci_api_key ) ) {

                $title = !empty($instance['title']) ? $instance['title'] : __('Subscribe to Newsletter', 'profile-builder-mailchimp-add-on');
                $list_id = !empty($instance['list_id']) ? $instance['list_id'] : '';
                $double_opt_in = isset( $instance['double_opt_in'] ) ? $instance['double_opt_in'] : 'on';
                $welcome_email = isset( $instance['welcome_email'] ) ? $instance['welcome_email'] : 'off';

                ?>

                <div class="wppb-mci-widget-wrapper">
                    <label class="wppb-mci-widget-label" for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title', 'profile-builder-mailchimp-add-on' ); ?></label>
                    <div class="wppb-mci-widget-input-wrapper">
                        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
                    </div>

                    <label class="wppb-mci-widget-label" for="wppb_mci_widget_list_select"><?php _e( 'Select the list your new subscriber will be added to', 'profile-builder-mailchimp-add-on' ); ?></label><br />
                    <div class="wppb-mci-widget-input-wrapper">
                        <select id="wppb_mci_widget_list_select" name="<?php echo $this->get_field_name('list_id'); ?>" data-number="<?php echo $this->number; ?>" class="widefat">
                        <option value="0"><?php echo __( 'Select...', 'profile-builder-mailchimp-add-on' ); ?></option>
                        <?php
                            $wppb_mci_lists = wppb_mci_get_lists();

                            if( $wppb_mci_lists ) {
                                foreach( $wppb_mci_lists as $mci_list_id => $mci_list ) {
                                    $selected = ( $mci_list_id == $list_id ) ? 'selected' : '';

                                    echo '<option value="' . $mci_list_id . '" ' . $selected . '>' . $mci_list['name'] . '</option>';
                                }
                            }
                        ?>
                        </select>
                    </div>

                    <label class="wppb-mci-widget-label"><?php echo __( 'Select which fields to show', 'profile-builder-mailchimp-add-on' ); ?></label>
                    <div class="wppb_mci_widget_list_fields wppb-mci-widget-input-wrapper" data-number="<?php echo $this->number; ?>">

                        <?php
                            $this->display_list_fields( $list_id, $this->number );
                        ?>

                    </div>

                    <label class="wppb-mci-widget-label"><?php echo __( 'Extra Options', 'profile-builder-mailchimp-add-on' ); ?></label>
                    <div class="wppb-mci-widget-input-wrapper">

                        <div class="wppb-mci-widget-setting-double-opt-in">
                            <label><input type="checkbox" name="<?php echo $this->get_field_name('double_opt_in'); ?>" <?php checked( $double_opt_in, 'on' ) ?> /><?php echo __( 'Double Opt-In', 'profile-builder-mailchimp-add-on' ); ?></label>
                            <p class="description"><?php echo __( 'If you select double opt-in, the user will receive an e-mail to confirm the subscribtion', 'profile-builder-mailchimp-add-on' ); ?></p>
                        </div>

                        <?php
                            // Add hidden class to welcome to email if opt in is set
                            $hidden_class = '';
                            if( $double_opt_in == 'on' )
                                $hidden_class = 'hidden';
                        ?>

                        <div class="wppb-mci-widget-setting-welcome-email <?php echo $hidden_class; ?>">
                            <label><input type="checkbox" name="<?php echo $this->get_field_name('welcome_email'); ?>" <?php checked( $welcome_email, 'on' ) ?> /><?php echo __( 'Send Welcome E-mail', 'profile-builder-mailchimp-add-on' ); ?></label>
                            <p class="description"><?php echo __( 'If checked will send an e-mail to welcome the user to the subscribtion area', 'profile-builder-mailchimp-add-on' ); ?></p>
                        </div>
                    </div>
                </div>

            <?php
            } else {

                echo __( 'Something went wrong. Either the MailChimp API key is missing or it is invalid.', 'profile-builder-mailchimp-add-on' );

            }
        }


        /*
         * Function that sanitizes the widget form values as they are saved
         *
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         */
        public function update( $new_instance, $old_instance ) {

            $instance = array();

            // Update the title field
            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

            // Update the lists ids
            $instance['list_id'] = !empty( $new_instance['list_id'] ) ? $new_instance['list_id'] : '';

            // Update the lists fields
            $lists_fields = array( 'email' => '', 'first_name' => '', 'last_name' => '');
            if( !empty( $new_instance['lists_fields'] ) ) {
                foreach( $lists_fields as $key => $mci_merge_var ) {
                    $instance['lists_fields'][ $key ] = $new_instance['lists_fields'][ $key ];

                    if( !isset( $instance['lists_fields'][ $key ]['tag'] ) )
                        $instance['lists_fields'][ $key ]['tag'] = '';

                    if( !isset( $instance['lists_fields'][ $key ]['name'] ) )
                        $instance['lists_fields'][ $key ]['name'] = '';
                }
            } else {
                foreach( $lists_fields as $key => $mci_merge_var ) {
                    $instance['lists_fields'][ $key ]['name'] = '';
                    $instance['lists_fields'][ $key ]['tag'] = '';
                    $instance['lists_fields'][ $key ]['req'] = '';
                }
            }

            // Update double opt in
            $instance['double_opt_in'] = !empty( $new_instance['double_opt_in'] ) ? $new_instance['double_opt_in'] : 'off';

            // Update welcome e-mail
            $instance['welcome_email'] = !empty( $new_instance['welcome_email'] ) ? $new_instance['welcome_email'] : 'off';

            return $instance;
        }


        /*
         * Function that displays the fields of a list in the widget
         *
         * @since v1.0.0
         *
         * @param string $list_id
         * @param int $widget_number
         * @param bool $is_ajax
         *
         */
        public function display_list_fields( $list_id = '', $widget_number = '', $is_ajax = false ) {

            if( empty($list_id) && empty($widget_number) )
                $is_ajax = true;

            if( empty($list_id) && isset( $_POST['wppb_mci_list_id'] ) )
                $list_id = $_POST['wppb_mci_list_id'];

            if( empty($widget_number) && isset( $_POST['wppb_widget_data_number'] ) )
                $widget_number = $_POST['wppb_widget_data_number'];


            if( !empty($list_id) && !empty( $widget_number ) ) {

                $wppb_mci_api_key = wppb_mci_get_api_key();
                $merge_vars = wppb_mci_api_get_list_merge_vars( $wppb_mci_api_key , $list_id );

                $instance = $this->get_instance($widget_number);
                $lists_fields = $instance['lists_fields'];

                if( $merge_vars ) {
                    foreach ($merge_vars as $merge_var) {

                        $merge_var_tag = '';
                        $merge_var_name = '';
                        $merge_var_req = '';
                        $field_key = '';

                        if ($merge_var['tag'] == 'EMAIL') {

                            $merge_var_tag = $merge_var['tag'];
                            $merge_var_name = $merge_var['name'];
                            $merge_var_req = $merge_var['req'];

                            echo '<input type="hidden" name="widget-' . $this->id_base . '[' . $widget_number . '][lists_fields]' . '[email][tag]" value="' . $merge_var_tag . '" />';
                            echo '<input type="hidden" name="widget-' . $this->id_base . '[' . $widget_number . '][lists_fields]' . '[email][name]" value="' . $merge_var_name . '" />';
                            echo '<input type="hidden" name="widget-' . $this->id_base . '[' . $widget_number . '][lists_fields]' . '[email][req]" value="' . $merge_var_req . '" />';
                            echo '<label class="wppb-mci-widget-label"><input type="checkbox" value="" disabled checked />' . $merge_var_name . '</label>';

                        } else {

                            if ($merge_var['tag'] == 'FNAME' || $merge_var['tag'] == 'LNAME') {
                                $merge_var_tag = $merge_var['tag'];
                                $merge_var_name = $merge_var['name'];
                                $merge_var_req = $merge_var['req'];
                            }

                            if ($merge_var['tag'] == 'FNAME') {
                                $field_key = 'first_name';
                            }

                            if ($merge_var['tag'] == 'LNAME') {
                                $field_key = 'last_name';
                            }

                            if ($merge_var['tag'] == 'FNAME' || $merge_var['tag'] == 'LNAME') {
                                echo '<input type="hidden" name="widget-' . $this->id_base . '[' . $widget_number . '][lists_fields]' . '[' . $field_key . '][name]" value="' . $merge_var_name . '" />';
                                echo '<input type="hidden" name="widget-' . $this->id_base . '[' . $widget_number . '][lists_fields]' . '[' . $field_key . '][req]" value="' . $merge_var_req . '" />';
                                echo '<label class="wppb-mci-widget-label"><input type="checkbox" name="widget-' . $this->id_base . '[' . $widget_number . '][lists_fields]' . '[' . $field_key . '][tag]" value="' . $merge_var_tag . '"' . checked($lists_fields[$field_key]['tag'], $merge_var_tag, false) . '/>' . $merge_var_name . '</label>';
                            }

                        }

                    }
                }

            } else {

                echo '<span class="wppb-mci-widget-span-message">' . __( 'Please select a list first', 'profile-builder-mailchimp-add-on') . '</span>';

            }

            if( $is_ajax )
                wp_die();
        }


        /*
         * Function that validates the front-end field
         *
         * @since v.1.0.0
         *
         * @return array
         *
         */
        public function validate_front_end_form() {

            $response = array( 'success' => 1 );
            $response_error = array( 'success' => 0 );
            $error = 0;

            // Validate list id
            if( isset( $_POST['wppb_mci_list_id'] ) && !empty( $_POST['wppb_mci_list_id'] ) )
                $response['subscribe_arguments']['id'] = htmlspecialchars(trim($_POST['wppb_mci_list_id']));
            else
                return false;

            // Validate fields
            $instance = $this->get_instance();

            foreach( $instance['lists_fields'] as $list_field ) {

                if( isset( $_POST['wppb_mci_widget_request_' . $list_field['tag']] ) ) {

                    $field_value = htmlspecialchars(trim( $_POST['wppb_mci_widget_request_' . $list_field['tag']] ) );

                    if( !empty( $field_value ) ) {

                        if( $list_field['tag'] == 'EMAIL' && !is_email( $field_value ) ) {
                            $response_error['fields'][ $list_field['tag'] ]['errors'][] = apply_filters( 'wppb_mci_widget_field_error_email_not_valid', 'The e-mail is not valid' );
                            $error = 1;
                        } elseif( is_email( $field_value ) ) {
                            $response['subscribe_arguments']['email']['email'] = $field_value;
                        }

                        $response['subscribe_arguments']['merge_vars'][ $list_field['tag'] ] = $field_value;

                    } elseif( $list_field['req'] ) {
                        $response_error['fields'][ $list_field['tag'] ]['errors'][] = apply_filters( 'wppb_mci_widget_field_error_required', 'This field is required' , $list_field['tag'] );
                        $error = 1;
                    }

                    // Return field value on error
                    if( !empty( $field_value ) )
                        $response_error['fields'][ $list_field['tag'] ]['value'] = $field_value;
                }


            }

            // Validate double opt-in
            if( isset( $instance['double_opt_in'] ) && $instance['double_opt_in'] == 'on' )
                $response['subscribe_arguments']['double_optin'] = true;
            else
                $response['subscribe_arguments']['double_optin'] = false;

            // Validate welcome e-mail
            if( isset( $instance['welcome_email'] ) && $instance['welcome_email'] == 'on' )
                $response['subscribe_arguments']['send_welcome'] = true;
            else
                $response['subscribe_arguments']['send_welcome'] = false;


            // Return results
            if( $error == 1 )
                return $response_error;
            else
                return $response;

        }

    }

    function wppb_mci_widget_init() {
        register_widget( 'WPPB_Mailchimp_Widget' );
    }
    add_action( 'widgets_init', 'wppb_mci_widget_init' );