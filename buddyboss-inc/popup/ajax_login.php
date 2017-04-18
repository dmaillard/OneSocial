<?php
if(!function_exists("get_option")) {
	die("Wooo!");
}

//its an ajax request function for ajax login request.

function func_ajax_login() {

	if(isset($_GET["ajax-login"])) {

		/**
		 * all administrators can login successfully (and the pop window actually closes);
		 * however, with any other user level, the login pop-up window seems to freeze at "Checking Credentials…".
		 * Nevertheless, it actually does log in the user (in the background) but the "Checking Credentials…" message never switches to "Login Successful"
		 * and the window stays open. If you manually close and browse the website, you will notice that you are actually logged in.
		 *
		 * most likely because s2member is trying to redirect,
		 * and the Modal login plugin is waiting for a response, which it isnt getting.
		 * s2member will only respond to the redirect_to var or disable the s2member login redirection totally,
		 * so we any popup-login to work.
		 *
		 * Disable s2member redirecting;
		 */
		add_filter( 'ws_plugin__s2member_login_redirect', '__return_false' );

		if (!isset( $_POST['ajax-login-security'] ) || ! wp_verify_nonce( $_POST['ajax-login-security'], 'ajax-login-security' )) { //Security check etc.

		  $txt = __("Sorry security didn't verified, refresh page and try again.",'onesocial');
		  echo '
		  jQuery("#ajax_login_messages").html("<div class=\"ctmessage error\"><p>'.escapeJavaScriptText($txt).'</p></div>");
		  ';

		  die();

		}

		$username = @$_POST["username"];
		$password = @$_POST["password"];


		if(empty($username)) {
		$txt = __("Enter an Username.",'onesocial');
		echo '
		jQuery("#ajax_login_messages").html("<div class=\"ctmessage error\"><p>'.escapeJavaScriptText($txt).'</p></div>");
		jQuery("#login_username").focus();
		';
		  exit;
		}

                $user_data = get_user_by('login', $username);

		if ( !sb_is_user_verified( $user_data->ID ) && $user_data->data->user_status == '2' ) { //Check for activation
			$txt = __("Your account has not been activated. Check your email for the activation link.", 'onesocial');
                echo '
				jQuery("#ajax_login_messages").html("<div class=\"ctmessage error\"><p>' . escapeJavaScriptText($txt) . '</p></div>");
				jQuery("#login_username").focus();
				';
                exit;
		}

		if(empty($password)) {
		$txt = __("Enter an Password.",'onesocial');
		echo '
		jQuery("#ajax_login_messages").html("<div class=\"ctmessage error\"><p>'.escapeJavaScriptText($txt).'</p></div>");
		jQuery("#login_password").focus();
		 ';
		  exit;
		}

		$creds = array();
		$creds['user_login'] = $username;
		$creds['user_password'] = $password;
		$creds['remember'] = true;

		$user = wp_signon( $creds, false );

        if(isset($_COOKIE['login_redirect']) && $_COOKIE['login_redirect'] != '') {
        	if($_COOKIE['login_redirect'] == 'vendor'){
		        if(function_exists("activate_wcvendors_pro")){
		        	$id = WCVendors_Pro::get_option( 'dashboard_page_id' );
		        	if($id) {
		            	$dashboard_page = get_permalink($id);
		            	$redirect = $dashboard_page;
		        	}
		        } else {
		        	$id = WC_Vendors::$pv_options->get_option( 'vendor_dashboard_page' );
		        	if($id) {
		        		$vendor_dashboard_page = get_permalink($id);
		        		$redirect = $vendor_dashboard_page;
		        	}
		        }
            } else {
                $redirect = wp_nonce_url( bp_core_get_user_domain($user->ID) . bp_get_messages_slug() . $_COOKIE['login_redirect']);
            }
            unset($_COOKIE['login_redirect']);
            setcookie('login_redirect', null, -1, '/');
        }

		if ( is_wp_error($user) ) {
			$jshtml = $user->get_error_message();
			echo '
			jQuery("#ajax_login_messages").html("<div class=\"ctmessage error\"><p>'.escapeJavaScriptText($jshtml).'</p></div>");
			';
			exit;
		}
			$txt = __("You have been successfully logged in. Please wait.",'onesocial');

			/**
			 * Filter the overlay login redirect URL
			 *
			 * @param string           $redirect_to           The redirect destination URL
			 * @param WP_User|WP_Error $user                  WP_User object if login was successful, WP_Error object otherwise.
			 */
			$redirect = apply_filters( 'onesocial_login_redirect', $redirect, $user );

			if($redirect) {
                echo 'window.location ="'.$redirect.'";';
                echo 'jQuery("#ajax_login_messages").html("<div class=\"ctmessage updated\"><p>'.escapeJavaScriptText($redirect).'</p></div>");';
            } else {
				echo '
				jQuery("#ajax_login_messages").html("<div class=\"ctmessage updated\"><p>'.escapeJavaScriptText($txt).'</p></div>");

	            var url = window.location,
	                parameter = "user_verification_code";

	                //prefer to use l.search if you have a location/link object
	                var urlparts= url.toString().split("?");
	                if (urlparts.length>=2) {

	                    var prefix= encodeURIComponent(parameter)+"=";
	                    var pars= urlparts[1].split(/[&;]/g);

	                    //reverse iteration as may be destructive
	                    for (var i= pars.length; i-- > 0;) {
	                        //idiom for string.startsWith
	                        if (pars[i].lastIndexOf(prefix, 0) !== -1) {
	                            pars.splice(i, 1);
	                        }
	                    }

	                    url= urlparts[0]+"?"+pars.join("&");
	                }

			 	window.location = url;
				';
			}

		die();

	} //if(isset($_GET["ajax-login"])...

}

add_action("init","func_ajax_login");


/***
 * Filter whether the given user can be authenticated base on
 * register email activation confirmation
 */
add_filter( 'wp_authenticate_user', 'onesocial_wp_authenticate_user', 10, 2 );

function onesocial_wp_authenticate_user( $user, $password ) {

	if ( ! is_wp_error( $user ) ) {

		// run your curl check here
		if ( ! sb_is_user_verified( $user->ID ) ) {
			return new WP_Error( 'login_fail', __( '<strong>ERROR:</strong> Your account has not been activated. Check your email for the activation link.', 'onesocial' ) );
		}
	}

	return $user;
};
?>
