<?php

/*
 *  Process lost password
 */

function lost_pass_callback() {

	global $wpdb, $wp_hasher;

	$nonce = $_POST[ 'nonce' ];

	if ( !wp_verify_nonce( $nonce, 'rs_user_lost_password_action' ) ) {
		die( 'Security checked!' );
	}

	//We shall SQL escape all inputs to avoid sql injection.
	$user_login = $_POST[ 'user_login' ];

	$errors = new WP_Error();

	if ( empty( $user_login ) ) {
		$errors->add( 'empty_username', __( '<strong>ERROR</strong>: Enter a username or e-mail address.', 'onesocial' ) );
	} else if ( strpos( $user_login, '@' ) ) {
		$user_data = get_user_by( 'email', trim( $user_login ) );

		if ( empty( $user_data ) ) {
			$errors->add( 'invalid_email', __( '<strong>ERROR</strong>: There is no user registered with that email address.', 'onesocial' ) );
		}
	} else {
		$login		 = trim( $user_login );
		$user_data	 = get_user_by( 'login', $login );
	}

	/**
	 * Fires before errors are returned from a password reset request.
	 *
	 * @since 2.1.0
	 * @since 4.4.0 Added the `$errors` parameter.
	 *
	 * @param WP_Error $errors A WP_Error object containing any errors generated
	 *                         by using invalid credentials.
	 */
	do_action( 'lostpassword_post', $errors );

	if ( $errors->get_error_code() || !$user_data ) {
		$errors->add( 'invalidcombo', __( 'ERROR: Invalid username or email.', 'onesocial' ) );
		$errors->get_error_message( $errors->get_error_code() );
	}

	if ( !empty( $user_data ) ) {

		// Redefining user_login ensures we return the right case in the email.
		$user_login	 = $user_data->user_login;
		$user_email	 = $user_data->user_email;
		$key		 = get_password_reset_key( $user_data );

		if ( is_wp_error( $key ) ) {
			return $key;
		}

		$message = __( 'Someone requested that the password be reset for the following account:', 'onesocial' ) . "\r\n\r\n";
		$message .= network_home_url( '/' ) . "\r\n\r\n";
		$message .= sprintf( __( 'Username: %s', 'onesocial' ), $user_login ) . "\r\n\r\n";
		$message .= __( 'If this was a mistake, just ignore this email and nothing will happen.', 'onesocial' ) . "\r\n\r\n";
		$message .= __( 'To reset your password, visit the following address:', 'onesocial' ) . "\r\n\r\n";
		$message .= network_site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' ) . "\r\n";
		// replace PAGE_ID with reset page ID
		//$message .= esc_url( get_permalink( PAGE_ID ) . "/?action=rp&key=$key&login=" . rawurlencode( $user_login ) ) . "\r\n";

		if ( is_multisite() ) {
			$blogname = $GLOBALS[ 'current_site' ]->site_name;
		} else {
			/*
			 * The blogname option is escaped with esc_html on the way into the database
			 * in sanitize_option we want to reverse this for the plain text arena of emails.
			 */
			$blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
		}

		$title = sprintf( __( '[%s] Password Reset', 'onesocial' ), $blogname );

		/**
		 * Filter the subject of the password reset email.
		 *
		 * @since 2.8.0
		 * @since 4.4.0 Added the `$user_login` and `$user_data` parameters.
		 *
		 * @param string  $title      Default email title.
		 * @param string  $user_login The username for the user.
		 * @param WP_User $user_data  WP_User object.
		 */
		$title = apply_filters( 'retrieve_password_title', $title, $user_login, $user_data );

		/**
		 * Filter the message body of the password reset mail.
		 *
		 * @since 2.8.0
		 * @since 4.1.0 Added `$user_login` and `$user_data` parameters.
		 *
		 * @param string  $message    Default mail message.
		 * @param string  $key        The activation key.
		 * @param string  $user_login The username for the user.
		 * @param WP_User $user_data  WP_User object.
		 */
		$message = apply_filters( 'retrieve_password_message', $message, $key, $user_login, $user_data );

		if ( wp_mail( $user_email, wp_specialchars_decode( $title ), $message ) ) {
			$errors->add( 'confirm', __( 'Check your e-mail for the confirmation link.', 'onesocial' ), 'message' );
		} else {
			$errors->add( 'could_not_sent', __( 'The e-mail could not be sent.', 'onesocial' ) . "<br />\n" . __( 'Possible reason: your host may have disabled the mail() function.', 'onesocial' ), 'message' );
		}
	}

	// display error message
	if ( $errors->get_error_code() ) {
		$class = ('confirm' == $errors->get_error_code()) ? 'updated' : 'error';
		echo '<div class="ctmessage ' . $class . '"><p>' . $errors->get_error_message( $errors->get_error_code() ) . '</p></div>';
	}

	// return proper result
	die();
}

add_action( 'wp_ajax_nopriv_lost_pass', 'lost_pass_callback' );
add_action( 'wp_ajax_lost_pass', 'lost_pass_callback' );
