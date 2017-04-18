<?php
$class = 'full-width-col';
global $WORDPRESS_SOCIAL_LOGIN_VERSION;

if ( $WORDPRESS_SOCIAL_LOGIN_VERSION ) {
	$class = 'col';
}
?>

<div id="siteRegisterBox-step-1">

	<h2 class="popup_title"><?php echo bwe_option( 'register_popup_title' ); ?></h2>

	<input type="hidden" name="step" value="1" >
	<?php wp_nonce_field( 'ajax-register-security', 'ajax-register-security', false ); ?>

	<?php
	$desc = bwe_option( 'register_popup_description' );
	if ( !empty( $desc ) ) {
		?>
		<p class="description"><?php echo $desc; ?></p>
		<?php
	}
	?>

	<div class="ajax_register_messages"></div>

	<div class="row">

		<div class="<?php echo $class; ?> with-email">

			<h5><?php _e( 'Fill the form', 'onesocial' ); ?></h5>

			<div class="editfield bwe-username">
				<input type="text" id="register_username" name="register_username" placeholder="Username" class="input" value="<?php echo isset( $_POST[ 'register_username' ] ) ? esc_attr( $_POST[ 'register_username' ] ) : ''; ?>" />
			</div>

			<div class="editfield bwe-email">
				<input type="text" id="register_email" name="register_email" placeholder="Email" class="input" value="<?php echo isset( $_POST[ 'register_email' ] ) ? esc_attr( $_POST[ 'register_email' ] ) : ''; ?>" />
			</div>

			<div class="editfield bwe-password">
				<input type="password" id="register_password" name="register_password" placeholder="Choose a Password" class="input"/>
			</div>

			<div class="editfield bwe-password bwe-password-confirm">
				<input type="password" id="register_password_confirm" name="register_password_confirm" placeholder="Confirm Password" class="input"/>
			</div>

			<?php do_action( 'bwe_after_signup_profile_fields' ); ?>

			<div class="editfield submit">
				<button id="register_button" class="button" type="submit"><i class="fa fa-spinner fa-spin" style="display: none"></i> <i class="fa fa-check"></i> <?php _e( 'Register', 'buddyboss-welcome-experience' ); ?></button>
			</div>

			<h6>
				<span><?php _e( 'Already a member?', 'buddyboss-welcome-experience' ); ?></span>
				<a href="#siteLoginBox" class="bwe-login-now"><?php _e( 'Sign In', 'buddyboss-welcome-experience' ); ?>.</a>
			</h6>

		</div>

		<div class="<?php echo $class; ?> with-plugin">

			<?php do_action( 'login_form' ); ?>

			<?php
			$login_message = onesocial_get_option( 'boss_login_message' );

			if ( !empty( $WORDPRESS_SOCIAL_LOGIN_VERSION ) && !empty( $login_message ) ) {
				?>
				<p class="login-message"><?php echo $login_message; ?></p>
			<?php } ?>

		</div>

	</div>

</div><!-- /.row -->