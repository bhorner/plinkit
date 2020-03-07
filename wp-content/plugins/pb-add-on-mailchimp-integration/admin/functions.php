<?php

    /*
     * Function that sets the list settings of the settings option
     *
     * @since v.1.0.0
     *
     * @param string $wppb_mci_api_key
     *
     * @return array
     *
     */
    function wppb_mci_api_get_lists_settings( $api_key ) {

        $wppb_mci_lists = array();

        $api = new WPPB_MailChimp( $api_key );

        $api_lists['data'] = array();
        $api_lists = $api->call('lists/list');

        // If we have list data go ahead and populate the lists array
        if( !empty( $api_lists['data'] ) ) {

            // Go through each list
            foreach( $api_lists['data'] as $mci_list ) {

                // Set the name of the list
                $wppb_mci_lists[ $mci_list['id'] ]['name'] = $mci_list['name'];

                // Get merge vars of the list
                $api_list_merge_vars = $api->call('lists/merge-vars', array( 'id' => array( $mci_list['id'] ) ) );

                // Go through each merge var
                foreach( $api_list_merge_vars['data'][0]['merge_vars'] as $merge_var ) {

                    $wppb_mci_lists[ $mci_list['id'] ]['merge_vars'][ $merge_var['tag'] ] = '';

                    // Set the default e-mail
                    if( $merge_var['tag'] == 'EMAIL' ) {
                        $wppb_mci_lists[ $mci_list['id'] ]['merge_vars'][ $merge_var['tag'] ] = 'email';
                    }

                    // Set the first name
                    if( $merge_var['tag'] == 'FNAME' ) {
                        $wppb_mci_lists[ $mci_list['id'] ]['merge_vars'][ $merge_var['tag'] ] = 'first_name';
                    }

                    // Set the last name
                    if( $merge_var['tag'] == 'LNAME' ) {
                        $wppb_mci_lists[ $mci_list['id'] ]['merge_vars'][ $merge_var['tag'] ] = 'last_name';
                    }

                }
            }
        }

        return $wppb_mci_lists;
    }


    /*
     * Function that returns the merge vars for a given list
     *
     * @since v.1.0.0
     *
     * @param string $api_key
     * @param string $list_id
     *
     * @return array or false
     *
     */
    function wppb_mci_api_get_list_merge_vars( $api_key, $list_id ) {

        $api = new WPPB_MailChimp( $api_key );
        $merge_vars = $api->call('lists/merge-vars', array( 'id' => array( $list_id ) ) );

        if( $merge_vars['success_count'] == 1 ) {
            return $merge_vars['data'][0]['merge_vars'];
        } else {
            return false;
        }

    }


    /*
     * Function that returns the lists settings saved in the option settings
     *
     * @since v.1.0.0
     *
     * @return array or false
     *
     */
    function wppb_mci_get_lists() {
        $settings = get_option( 'wppb_mci_settings' );

        if( isset( $settings['lists'] ) && !empty( $settings['lists'] ) ) {
            return $settings['lists'];
        } else {
            return false;
        }
    }


    /*
     * Function that return the API key
     *
     * @since v.1.0.0
     *
     * @return string or false
     *
     */
    function wppb_mci_get_api_key() {
        $settings = get_option( 'wppb_mci_settings' );

        if( isset( $settings['api_key'] ) && !empty( $settings['api_key'] ) ) {
            return $settings['api_key'];
        } else {
            return false;
        }
    }


    /*
     * Function that subscribes an e-mail address
     *
     * @since v.1.0.0
     *
     * @param string $api_key
     * @param array $args
     *
     */
    function wppb_mci_api_subscribe( $api_key, $args ) {

        $api = new WPPB_MailChimp( $api_key );

        // Default args
        $defaults = array(
            'double_optin'      => false,
            'update_existing'   => true,
            'replace_interests' => false,
            'send_welcome'      => false
        );

        $args = array_merge( $defaults, $args );

        // If all is good we receive the user ids
        $response = $api->call('lists/subscribe', $args );

        return $response;
    }


    /*
     * Function that unsubscribes an e-mail address
     *
     * @since v.1.0.0
     *
     * @param string $api_key
     * @param array $args
     *
     */
    function wppb_mci_api_unsubscribe( $api_key, $args ) {

        $api = new WPPB_MailChimp( $api_key );

        $defaults = array(
            'delete_member' => true
        );

        $args = array_merge( $defaults, $args );

        $response = $api->call('lists/unsubscribe', $args);

        return $response;

    }


    /*
     * Updates a subscribed member's data
     *
     */
    function wppb_mci_api_update_member( $api_key, $args ) {

        $api = new WPPB_MailChimp( $api_key );
        $response = $api->call( 'lists/update-member', $args );

        return $response;

    }


    /*
     * Verifies if a user's e-mail address is subscribed to MailChimp
     *
     */
    function wppb_mci_api_member_is_subscribed( $api_key, $args ) {

        $api = new WPPB_MailChimp( $api_key );
        $response = $api->call( 'lists/member-info', $args );

        if( !empty( $response['success_count'] ) && $response['success_count'] == 1 && $response['data'][0]['status'] == 'subscribed' )
            return true;
        else
            return false;

    }


    /*
     * Returns the arguments needed to subscribe/update a member
     *
     * @param array $request_data
     * @param string $list_id
     * @param int $user_id
     * @param string $form_location
     * @param mixed $old_user_email - bool false / string
     *
     * @return array
     *
     */
    function wppb_mci_api_get_args( $call = 'lists/subscribe', $request_data, $list_id, $user_id, $form_location = '', $old_user_email = false ) {

        // Get settings
        $settings      = get_option( 'wppb_mci_settings' );
        $manage_fields = get_option( 'wppb_manage_fields' );

        // We need the avatar field below, when adding the merge tags. Instead of going through each field
        // in the merge tags loop, we'll just do a loop here and leave only the avatar fields in these
        // manage fields
        if( !empty( $manage_fields ) ) {
            foreach( $manage_fields as $key => $field ) {
                if( $field['field'] != 'Avatar' )
                    unset( $manage_fields[$key] );
            }
        }


        // Set email, merge vars array and groupings array
        $email      = array();
        $merge_vars = array();
        $groupings  = array();


        // Set the correct e-mail
        if( empty( $form_location ) || $form_location == 'register' ) {

            // Comes from wppb_activate_user
            if( empty( $form_location ))
                $email['email'] = $request_data['user_email'];
            elseif( $form_location == 'register' )
                $email['email'] = $request_data['email'];


        } else {

            // Get userdata for the user
            $user_data = get_userdata($user_id);

            // If there's an old e-mail 
            if( $old_user_email !== false ) {

                $email['email']      = trim( $old_user_email );
                $merge_vars['new-email'] = trim( $user_data->data->user_email );

            } else {

                $email['email']      = $user_data->data->user_email;

            }

        }


        // Compatibility issues for username, website field and user role field
        if( !isset( $request_data['custom_field_user_role'] ) && isset( $request_data['role'] ) )
            $request_data['custom_field_user_role'] = $request_data['role'];

        if( !isset( $request_data['website'] ) && isset( $request_data['user_url'] ) )
            $request_data['website'] = $request_data['user_url'];

        if( !isset( $request_data['username'] ) && isset( $request_data['user_login'] ) )
            $request_data['username'] = $request_data['user_login'];


        // Set the merge vars for the rest of the fields
        foreach( $settings['lists'][$list_id]['merge_vars'] as $merge_var => $merge_var_assoc ) {

            if( $merge_var == 'EMAIL' )
                continue;;

            if( $merge_var == 'EMAIL' && empty( $form_location ) )
                $merge_var_assoc = 'user_email';

            if( isset( $request_data[ $merge_var_assoc ] ) && $merge_var_assoc !== 0 ) {
                if( is_array( $request_data[ $merge_var_assoc ] ) ) {
                    $merge_vars[ $merge_var ] = implode( ',', $request_data[ $merge_var_assoc ] );
                } else {

                    // If the field is an Avatar field, get the URL of the image, instead of the
                    // attachment ID
                    if( !empty( $manage_fields ) ) {
                        foreach( $manage_fields as $field ) {
                            if( $field['field'] == 'Avatar' && $field['meta-name'] == $merge_var_assoc ) {

                                // Get the size of the image coresponding to the avatar field settings,
                                // but default to 'thumbnail' if the size doesn't exist for the image
                                $attachment_meta = wp_get_attachment_metadata( $request_data[$merge_var_assoc] );

                                if( false !== $attachment_meta ) {

                                    if( !empty( $attachment_meta['sizes']['wppb-avatar-size-' . $field['avatar-size'] ] ) )
                                        $size = 'wppb-avatar-size-' . $field['avatar-size'];
                                    else
                                        $size = 'thumbnail';
                                    
                                    // Swap the ID with the Image url
                                    $request_data[ $merge_var_assoc ] = wp_get_attachment_image_url( $request_data[$merge_var_assoc], $size );
                                }
                                
                            }
                        }
                    }

                    $merge_vars[ $merge_var ] = trim( $request_data[ $merge_var_assoc ] );
                }
            }
        }


        // Set the groupings in the merge vars
        if( isset( $settings['lists'][$list_id]['groups'] ) ) {

            foreach( $settings['lists'][$list_id]['groups'] as $grouping_id => $field_meta_name ) {

                // Skip to next one if no value is in the request for this field
                if( empty( $request_data[$field_meta_name] ) )
                    continue;

                if( is_array( $request_data[$field_meta_name] ) ) {
                    $groupings[] = array(
                        'id'     => $grouping_id,
                        'groups' => $request_data[$field_meta_name]
                    );
                } else {

                    $field_value = ( array_map( 'trim', explode( ',', $request_data[$field_meta_name] ) ) );

                    $groupings[] = array(
                        'id'     => $grouping_id,
                        'groups' => $field_value
                    );
                }

            }

        }

        // Add groupings to the merge vars
        if( !empty( $groupings ) )
            $merge_vars['groupings'] = $groupings;


        // Check double opt in value
        if( $call = 'lists/subscribe' && $settings['lists'][$list_id]['double_opt_in'] == 'on' )
            $double_opt_in = true;
        else
            $double_opt_in = false;

        // Check send welcome e-mail value
        if( $call = 'lists/subscribe' && $settings['lists'][$list_id]['welcome_email'] == 'on' )
            $welcome_email = true;
        else
            $welcome_email = false;


        // Subscribe users arguments
        $args = array(
            'id'                => $list_id,
            'email'             => $email,
            'merge_vars'        => $merge_vars,
            'update_existing'   => true,
            'replace_interests' => true,
            'double_optin'      => $double_opt_in,
            'send_welcome'      => $welcome_email
        );

        return $args;

    }