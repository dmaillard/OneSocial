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

	<div id="box_container">

		<h2 class="popup_title"><?php echo bwe_option( 'login_popup_title' ); ?></h2>

		<?php
		$desc = bwe_option( 'login_popup_description' );
		if ( !empty( $desc ) ) {
			echo '<p class="description">' . $desc . '</p>';
		}
		?>

		<div class="ajax_login_messages" id="ajax_login_messages"></div>

		<div class="row">

			<div class="<?php echo $class; ?> with-email">

				<h5><?php _e( 'Fill the form', 'onesocial' ); ?></h5>

				<div class="editfield bwe-username">
					<label for="login_username">
						<?php _e( 'Username', 'onesocial' ); ?>
						<input type="text" id="login_username" placeholder="<?php _e( 'Enter', 'onesocial' ); ?>" class="input" />
					</label>
				</div>

				<div class="editfield bwe-password-login">
					<label for="login_password">
						<?php _e( 'Password', 'onesocial' ); ?>
						<input type="password" id="login_password" placeholder="<?php _e( '*****', 'onesocial' ); ?>" class="input" />
					</label>
				</div>

				<div class="editfield boss-rememberme">
					<input name="login_rememberme" type="checkbox" id="login_rememberme" value="forever" />
					<label for="login_rememberme"><?php _e( 'Remember Me', 'onesocial' ); ?></label>
					<a href="<?php echo wp_lostpassword_url(); ?>" class="forgetme"><?php _e( 'Forgot password?', 'onesocial' ); ?></a>
				</div>


				<div class="editfield submit">
					<button id="login_button" class="button"><i class="fa fa-spinner fa-spin" style="display: none"></i> <i class="fa fa-lock"></i> <?php _e( 'Sign In', 'buddyboss-welcome-experience' ); ?> </button>
				</div>

				<?php wp_nonce_field( 'ajax-login-security', 'ajax-login-security' ); ?>

				<?php if ( buddyboss_is_bp_active() && bp_get_signup_allowed() ) : ?>
					<h6><?php _e( 'Not a member?', 'onesocial' ); ?> <a href="#" class="joinbutton"><?php _e( 'Sign Up Now!', 'onesocial' ); ?></a></h6>
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

</div><!--#siteLoginBox-->

<a href="#siteLoginBox" class="boss-login-popup-link mfp-hide">Popup</a>