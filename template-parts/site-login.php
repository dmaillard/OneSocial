<?php
$wrapper_class	 = 'modal-without-social-login';
$class			 = 'full-width-col';

global $WORDPRESS_SOCIAL_LOGIN_VERSION;

if ( $WORDPRESS_SOCIAL_LOGIN_VERSION ) {
	$class			 = 'col';
	$wrapper_class	 = 'modal-with-social-login';
}
?>

<div id="siteLoginBox" class="mfp-hide boss-modal-form popup-content <?php echo $wrapper_class; ?>">

	<div class="animated fadeInDownShort LoginBox slow">

		<?php
		$title	 = onesocial_get_option( 'login_form_title' );
		$desc	 = onesocial_get_option( 'login_form_description' );

		if ( $title ) {
			echo '<h4 class="popup_title">' . $title . '</h4>';
		}

		if ( $desc ) {
			echo '<div class="description">' . $desc . '</div>';
		}
		?>

		<div id="ajax_login_messages" class="messages-output"></div>

		<div class="row">

			<div class="<?php echo $class; ?> with-email">

				<h5><?php _e( 'Fill the form', 'onesocial' ); ?></h5>

				<p class="username-wrap">
					<label for="login_username"><?php _e( 'Username', 'onesocial' ); ?></label>
					<input type="text" id="login_username" placeholder="<?php _e( 'Enter', 'onesocial' ); ?>" class="input" />
				</p>

				<p class="password-wrap">
					<label for="login_password">
						<?php _e( 'Password', 'onesocial' ); ?>
					</label>

					<!-- fake fields are a workaround for chrome autofill getting the wrong fields -->
					<input style="display:none" type="password" name="fakepasswordremembered" />
					<input type="password" id="login_password" placeholder="<?php _e( '****', 'onesocial' ); ?>" class="input" />
				</p>

				<p class="options-wrap">
					<input name="login_rememberme" type="checkbox" id="login_rememberme" value="forever" />
					<label for="login_rememberme"><?php _e( 'Remember Me', 'onesocial' ); ?></label>
					<a href="<?php echo wp_lostpassword_url(); ?>" class="forgetme"><?php _e( 'Forgot password?', 'onesocial' ); ?></a>
				</p>

				<p>
					<button id="login_button" class="button"><i class="fa fa-spinner fa-spin" style="display: none"></i> <?php _e( 'Sign In', 'onesocial' ); ?></button>
				</p>

				<?php wp_nonce_field( 'ajax-login-security', 'ajax-login-security' ); ?>

				<?php if ( buddyboss_is_bp_active() && bp_get_signup_allowed() ) : ?>
					<h6><?php _e( 'Not a member?', 'onesocial' ); ?> <a href="#siteRegisterBox" class="joinbutton"><?php _e( 'Sign Up Now!', 'onesocial' ); ?></a></h6>
				<?php endif; ?>

			</div><!-- /.col-6 -->

			<div class="<?php echo $class; ?> with-plugin">

				<?php do_action( 'login_form' ); ?>

				<?php
				$login_message = onesocial_get_option( 'boss_login_message' );

				if ( !empty( $WORDPRESS_SOCIAL_LOGIN_VERSION ) && !empty( $login_message ) ) {
					?>
					<p class="login-message"><?php echo $login_message; ?></p>
				<?php } ?>

			</div>

		</div><!-- /.row -->

	</div>

</div>

<a href="#siteLoginBox" class="onesocial-login-popup-link mfp-hide"><?php _e( 'Login', 'onesocial' ); ?></a>