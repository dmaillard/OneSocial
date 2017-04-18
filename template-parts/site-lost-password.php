<?php
$wrapper_class	 = 'modal-without-social-login';
$class			 = 'full-width-col';
?>

<div id="siteLostPassword" class="mfp-hide boss-modal-form popup-content <?php echo $wrapper_class; ?>">

	<div class="animated fadeInDownShort LostPasswordBox slow">

		<?php
		$title			 = onesocial_get_option( 'reset_password_title' );
		$desc			 = onesocial_get_option( 'reset_password_description' );

		if ( $title ) {
			echo '<h4 class="popup_title">' . $title . '</h4>';
		}

		if ( $desc ) {
			echo '<div class="description">' . $desc . '</div>';
		}
		?>

		<h5 class="title"><?php _e( 'Lost Password', 'onesocial' ); ?></h5>
		<div class="info"><?php _e( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'onesocial' ); ?></div>

		<div id="message" class="messages-output"></div>

		<form id="lostPasswordForm" method="post">
			<?php
			// this prevent automated script for unwanted spam
			if ( function_exists( 'wp_nonce_field' ) ) {
				wp_nonce_field( 'rs_user_lost_password_action', 'rs_user_lost_password_nonce' );
			}
			?>

			<p>
				<label for="user_login"><?php _e( 'Username or E-mail:', 'onesocial' ) ?>
					<br />
					<input type="text" name="user_login" id="user_login" class="input" value="" size="20" />
				</label>
			</p>

			<?php
			/**
			 * Fires inside the lostpassword <form> tags, before the hidden fields.
			 *
			 * @since 2.1.0
			 */
			do_action( 'lostpassword_form' );
			?>

			<button id="lost-pass-button" class="button"><i class="fa fa-spinner fa-spin" style="display: none"></i> <?php _e( 'Reset Password', 'onesocial' ); ?></button>

		</form>

	</div>

</div>

<a href="#siteLostPassword" class="onesocial-lost-password-popup-link mfp-hide"><?php _e( 'Lost Password', 'onesocial' ); ?></a>