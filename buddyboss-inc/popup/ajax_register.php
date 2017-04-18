<?php

if ( !function_exists( "get_option" ) ) {
	die( "Wooo!" );
}

/**
 * Function used on ajax request for user ajax registration popup.
 *
 * @return
 */
function func_ajax_register() {

	if ( isset( $_GET[ "ajax-register" ] ) ) {

		if ( !isset( $_POST[ 'ajax-register-security' ] ) || !wp_verify_nonce( $_POST[ 'ajax-register-security' ], 'ajax-register-security' ) ) {

			$txt = __( "Sorry security didn\'t verified, refresh page and try again.", 'onesocial' );
			echo '
		  jQuery("#ajax_register_messages").html("<div class=\"ctmessage error\"><p>' . escapeJavaScriptText( $txt ) . '</p></div>");
		  ';

			die();
		}

		$email		 = @$_POST[ "email" ];
		$username	 = @$_POST[ "username" ];
		$password	 = @$_POST[ "password" ];

		if ( empty( $email ) ) {
			$txt = __( "Enter an Email.", 'onesocial' );
			echo '
		jQuery("#ajax_register_messages").html("<div class=\"ctmessage error\"><p>' . escapeJavaScriptText( $txt ) . '</p></div>");
		jQuery("#register_email").focus();
		';
			exit;
		}

		if ( !is_email( $email ) ) {
			$txt = __( "Entered email is not a valid email address.", 'onesocial' );
			echo '
		jQuery("#ajax_register_messages").html("<div class=\"ctmessage error\"><p>' . escapeJavaScriptText( $txt ) . '</p></div>");
		jQuery("#register_email").focus();
		';
			exit;
		}

		if ( empty( $username ) ) {
			$txt = __( "Enter an Username.", 'onesocial' );
			echo '
		jQuery("#ajax_register_messages").html("<div class=\"ctmessage error\"><p>' . escapeJavaScriptText( $txt ) . '</p></div>");
		jQuery("#register_username").focus();
		';
			exit;
		}
		
		if ( preg_match('/\s/',$username) ) {
			$txt = __( "Username should not contain space.", 'onesocial' );
			echo '
		jQuery("#ajax_register_messages").html("<div class=\"ctmessage error\"><p>' . escapeJavaScriptText( $txt ) . '</p></div>");
		jQuery("#register_username").focus();
		';
			exit;
		}

		if ( empty( $password ) ) {
			$txt = __( "Enter an Password.", 'onesocial' );
			echo '
		jQuery("#ajax_register_messages").html("<div class=\"ctmessage error\"><p>' . escapeJavaScriptText( $txt ) . '</p></div>");
		jQuery("#register_password").focus();
		 ';
			exit;
		}

		$userdata = array(
			'user_login' => $username,
			'user_pass'	 => $password,
			'user_email' => $email
		);

		$user_id = wp_insert_user( $userdata );

        if ( is_int( $user_id ) ) {

	        //Update user status
            sb_update_user_status($user_id,2);

	        //Send activation verification email
	        send_email_verification( $user_id );
        }

		//On success
		if ( !is_wp_error( $user_id ) ) {

			echo '
			jQuery("#siteRegisterBox").find(".registerfields").hide();
			jQuery("#siteRegisterBox").find(".joined").fadeIn();
			';
		} else {
			$txt = $user_id->get_error_message();
			echo 'jQuery("#ajax_register_messages").html("<div class=\"ctmessage error\"><p>' . escapeJavaScriptText( $txt ) . '</p></div>");';
        }
        
		die();
	}
}

add_action( "init", "func_ajax_register" );

add_action( "wp_ajax_nopriv_os_ajax_register", "os_ajax_register" );
function os_ajax_register(){
    $response = array(
        'success'   => false,
        'message'   => '',
        'js'        => '',
    );
    
    if ( !isset( $_POST[ 'ajax-register-security' ] ) || !wp_verify_nonce( $_POST[ 'ajax-register-security' ], 'ajax-register-security' ) ) {
        $response['message'] = __( "Sorry security didn\'t verified, refresh page and try again.", 'onesocial' );
        die(json_encode($response) );
    }
    
    $email		 = @$_POST[ "register_email" ];
    $username	 = @$_POST[ "register_username" ];
    $password	 = @$_POST[ "register_password" ];

    if ( empty( $email ) ) {
        $response['message'] = __( "Enter an Email.", 'onesocial' );
        $response['js'] = 'jQuery("#register_email").focus();';
        die( json_encode($response) );
    }

    if ( !is_email( $email ) ) {
        $response['message'] = __( "Entered email is not a valid email address.", 'onesocial' );
        $response['js'] = 'jQuery("#register_email").focus();';
        die( json_encode($response) );
    }

    if ( empty( $username ) ) {
        $response['message'] = __( "Enter an Username.", 'onesocial' );
        $response['js'] = 'jQuery("#register_username").focus();';
        die( json_encode($response) );
    }
		
    if ( preg_match('/\s/',$username) ) {
        $response['message'] = __( "Username should not contain space.", 'onesocial' );
        $response['js'] = 'jQuery("#register_username").focus();';
		die( json_encode($response) );
    }

    if ( empty( $password ) ) {
        $response['message'] = __( "Enter an Password.", 'onesocial' );
        $response['js'] = 'jQuery("#register_password").focus();';
		die( json_encode($response) );
    }
    
    global $bp;
        
    // validate 
    $result = bp_core_validate_user_signup ( $username, $email );

    // if errors
    if ( !empty ( $result["errors"]->errors ) ) {
        $error_fields = array();
        if ( isset ( $result["errors"]->errors["user_name"] ) ) {
            foreach ( $result["errors"]->errors["user_name"] as $error ) {
                $error_fields["username"][] = $error;
            }
            $error_fields["username"] = implode("<br />", $error_fields["username"] );
        }

        if ( isset ( $result["errors"]->errors["user_email"] ) ) {
            foreach ( $result["errors"]->errors["user_email"] as $error ) {
                $error_fields["email"][] = $error;
            }
            $error_fields["email"] = implode("<br />", $error_fields["email"] );
        }
    }

	/**
	 * if errors buddyboss membertype option validation
	 */
	do_action( 'bp_signup_validate' );
	if ( !empty( $bp->signup->errors ) ) {
		$result = (array) $bp->signup->errors;

		if ( ! empty( $result['field_bmt_member_type'] ) ){
			$error_fields["bmt_member_type"] = $result['field_bmt_member_type'];
		}
	}

    // if there are errors
    if ( !empty ( $error_fields ) ){
	    $message = array();
	    if( !empty( $error_fields['username'] ) ){
		    $message[] = $error_fields['username'];
		    $response['js'] .= 'jQuery("#register_username").focus();';
	    }
	    if( !empty( $error_fields['email'] ) ){
		    $message[] = $error_fields['email'];
		    $response['js'] .= 'jQuery("#register_email").focus();';
	    }
	    if( !empty( $error_fields['bmt_member_type'] ) ){
		    $message[] = $error_fields['bmt_member_type'];
		    $response['js'] .= 'jQuery(".bmt-member-type").focus();';
	    }
	    $response['message'] = implode("<br />", $message );
        die( json_encode($response) );
    }

    // create usermeta
    $usermeta = array();
    $usermeta["profile_field_ids"] = @$_POST['signup_profile_field_ids'];
    if( !empty( $usermeta["profile_field_ids"] ) ){
        $all_fields_valid = true;
        
        // Let's compact any profile field info into an array.
        $profile_field_ids = explode( ',', $usermeta["profile_field_ids"] );

        // Loop through the posted fields formatting any datebox values then validate the field.
        foreach ( (array) $profile_field_ids as $field_id ) {
            if ( !isset( $_POST['field_' . $field_id] ) ) {
                if ( !empty( $_POST['field_' . $field_id . '_day'] ) && !empty( $_POST['field_' . $field_id . '_month'] ) && !empty( $_POST['field_' . $field_id . '_year'] ) )
                    $_POST['field_' . $field_id] = date( 'Y-m-d H:i:s', strtotime( $_POST['field_' . $field_id . '_day'] . $_POST['field_' . $field_id . '_month'] . $_POST['field_' . $field_id . '_year'] ) );
            }

            // Create errors for required fields without values.
            if ( xprofile_check_is_required_field( $field_id ) && empty( $_POST[ 'field_' . $field_id ] ) && ! bp_current_user_can( 'bp_moderate' ) ){
                $all_fields_valid = false;
                $response['js'] .= 'jQuery(".editfield.field_'. $field_id .'").after("<p class=\"ctmessage error field_erorr\">'. __( 'This is a required field', 'buddypress' ) .'</p>");';
            }
            
            if ( !empty( $_POST['field_' . $field_id] ) )
                $usermeta['field_' . $field_id] = $_POST['field_' . $field_id];

            if ( !empty( $_POST['field_' . $field_id . '_visibility'] ) )
                $usermeta['field_' . $field_id . '_visibility'] = $_POST['field_' . $field_id . '_visibility'];
        }
        
        if( !$all_fields_valid ){
            die( json_encode( $response ) );
        }
            
    } else {
        // Must have at least one profile field
        $usermeta["profile_field_ids"] = '1';
        $usermeta["field_1"] = $username;
    }

    $usermeta['password'] = wp_hash_password( $password );

	/**
	 * buddyboss membertype option save
	 */
	if ( isset( $_POST['bmt_member_type'] ) ){
		$usermeta['bmt_member_type'] = $_POST['bmt_member_type'];
	}

     /**
     * bp-core-filters.php line #558
     * if( buddypress()->members->admin->signups_page == get_current_screen()->id )
     * this condition check is always true, since both the values are false.
     * And therefore, it returns a true value, buddpress notification is not sent, dfault wpmu notification is sent instead.
     * 
     * Hack it!
     */
    $orig = buddypress()->members->admin->signups_page;
    buddypress()->members->admin->signups_page = 888;//random number

    bp_core_signup_user($username,$password,$email,$usermeta);

    buddypress()->members->admin->signups_page = $orig;
    
    $response['status'] = true;
    $response['js'] = 'jQuery("#siteRegisterBox").find(".registerfields").hide();jQuery("#siteRegisterBox").find(".joined").fadeIn();';
    die( json_encode( $response ) );
}
