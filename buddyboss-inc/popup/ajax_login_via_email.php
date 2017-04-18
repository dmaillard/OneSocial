<?php
if(!function_exists("get_option")) {
	die("Wooo!");
}

//its an ajax request function for ajax login request.

function func_ajax_login() {	
		
	if(isset($_GET["ajax-login"])) {
		
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
		$txt = __("Enter an Username / Email.",'onesocial');
		echo '
		jQuery("#ajax_login_messages").html("<div class=\"ctmessage error\"><p>'.escapeJavaScriptText($txt).'</p></div>");
		jQuery("#login_username").focus();
		';	
		  exit;
		}
		
		// if its an email...
		if(filter_var($username, FILTER_VALIDATE_EMAIL)) { //let convert it into username
			$username = get_user_by('email',$username);
			if(empty($username)) {
				$txt = __("Enter email is not registered with us.",'onesocial');
				echo '
				jQuery("#ajax_login_messages").html("<div class=\"ctmessage error\"><p>'.escapeJavaScriptText($txt).'</p></div>");
				jQuery("#login_username").focus();
				';	
				  exit;
			} else {
				$username = $username->user_login;
			}
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
		
		if ( is_wp_error($user) ) {
			$jshtml = $user->get_error_message();
			echo '
			jQuery("#ajax_login_messages").html("<div class=\"ctmessage error\"><p>'.escapeJavaScriptText($jshtml).'</p></div>");
			';
			exit;
		}
			$txt = __("You have been successfully logged in. Please wait.",'onesocial');
			echo '
			jQuery("#ajax_login_messages").html("<div class=\"ctmessage updated\"><p>'.escapeJavaScriptText($txt).'</p></div>");
		 	location.reload();
			';
		
		die();
		
	} //if(isset($_GET["ajax-login"])...
	
}

add_action("init","func_ajax_login");

?>