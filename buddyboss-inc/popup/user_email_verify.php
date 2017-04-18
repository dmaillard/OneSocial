<?php

if ( !function_exists( "get_option" ) ) {
	die( "Wooo!" );
}

function send_email_verification( $userid ) {

	$user_details = get_userdata( $userid );

	$name		 = get_bloginfo( "name" );
	$from_email	 = get_bloginfo( "admin_email" );

	$headers = 'From: ' . $name . ' <' . $from_email . '>' . "\r\n";

	$message = '
Hi ' . $user_details->display_name . ',

Welcome to ' . $name . '. Please Activate your Account now:

' . get_user_email_verification_link( $userid ) . '

Thank you for registering at ' . $name . ' - we\'re excited you\'re here.

Thanks,
' . $name . '
	 ';

	wp_mail( $user_details->user_email, '[' . $name . '] Activate your Account', $message, $headers );
}

function get_user_email_verification_link( $userid ) {
	$user_details = get_userdata( $userid );
	return home_url() . "?user_verification_code=1&u=" . $user_details->user_login . "&k=" . get_user_verification_code( $userid );
}

function get_user_verification_code( $userid ) {
	$user_details = get_userdata( $userid );
	if ( !$user_details ) {
		return '';
	}
	$key = get_user_meta( $userid, "user_verification_code", true );
	if ( $key == "" ) {
		//make a new code
		$key = sha1( uniqid() . $user_details->user_login );
		update_user_meta( $userid, "user_verification_code", $key );
		update_user_meta( $userid, "is_verified", '0' );
	}
	return $key;
}

$user_verify_email_html = "";

function user_verify_email() {
	global $user_verify_email_html;


	if ( isset( $_GET[ "user_verification_code" ] ) ) {

		$username	 = @$_GET[ "u" ];
		$key		 = @$_GET[ "k" ];

		if ( empty( $key ) ) {
			return false;
		}

		$userid = username_exists( $username );
        
		if ( $userid ) {
            
			$user_key = get_user_meta( $userid, "user_verification_code", true );
            
			if ( $user_key == $key ) {
				//Update user status
				update_user_meta( $userid, "user_verification_code", "" );
				update_user_meta( $userid, "is_verified", "1" );
				sb_update_user_status( $userid, 0 );

				$txt_act	 = __( "Successfully Activated", 'onesocial' );
				$txt_desc	 = __( "Thanks for activating your account!", 'onesocial' );

                $txt = sprintf( __( '<div class="verification-content vefification-success"><h2>%s</h2><p>%s</p></div>', 'onesocial' ), $txt_act, $txt_desc );

			} else {

				$txt = __( '<div class="verification-content vefification-failed"><h2>Oops</h2><p>Verification failed. <br />Please contact to support.</p>', 'onesocial' );
                
			}
		} else {

			$txt = __( '<div class="verification-content vefification-failed email-not-found"><h2>Oops!</h2> <p>An account with that email address was not found.!</p>', 'onesocial' );
            
		}
        
        $user_verify_email_html = '
        <script>
        jQuery("document").ready(function(){
            jQuery.magnificPopup.open({
              items: {
                src: "' . escapeJavaScriptText( $txt ) . '",
                type: "inline",
                closeOnBgClick: false,
                closeMarkup: "<button title=\"%title%\" class=\"mfp-close bb-icon-close\"></button>",
                callbacks: {
                    open: function() {
                        $("body").addClass("popup-open");
                    },
                    close: function() {
                        $("body").removeClass("popup-open");
                    }
                }
              }
            });
        });
        </script>
        ';
	}
}

//add_action( "wp_head", "user_verify_email", 11 );

function user_verify_email_wp_head() {
    user_verify_email();
	global $user_verify_email_html;
	if ( $user_verify_email_html != "" ) {
		echo $user_verify_email_html;
	}
}

add_action( "wp_head", "user_verify_email_wp_head" );

function sb_is_user_verified( $userid ) {
	$is_verified = get_user_meta( $userid, "is_verified", true );
	if ( $is_verified == "0" ) {
		return false;
	}
	return true;
}

/**
 * Update user status
 */
function sb_update_user_status( $id, $value ) {

	global $wpdb;
	
	$wpdb->update( $wpdb->users, array( 'user_status' => $value ), array( 'ID' => $id ) );
	
}