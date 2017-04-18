<?php
$wrapper_class	 = 'modal-without-social-login';
$class			 = 'full-width-col';

global $WORDPRESS_SOCIAL_LOGIN_VERSION;

if ( $WORDPRESS_SOCIAL_LOGIN_VERSION ) {
	$class			 = 'col';
	$wrapper_class	 = 'modal-with-social-login';
}
?>

<div id="siteRegisterBox" class="mfp-hide boss-modal-form popup-content <?php echo $wrapper_class; ?>">

	<div class="registerfields">

		<div class="animated fadeInDownShort RegisterBox slow">
			<?php
			$title	 = onesocial_get_option( 'register_form_title' );
			$desc	 = onesocial_get_option( 'register_form_description' );

			if ( $title ) {
				echo '<h4 class="popup_title">' . $title . '</h4>';
			}

			if ( $desc ) {
				echo '<div class="description">' . $desc . '</div>';
			}
			?>

			<div id="ajax_register_messages" class="messages-output"></div>

			<div class="row">

				<div class="<?php echo $class; ?> with-email">
                    <form method="POST" action="<?php echo admin_url( 'admin-ajax.php' );?>" id="frm_siteRegisterBox">
						<input type="hidden" name="action" value="os_ajax_register">

						<h5><?php _e( 'Fill the form', 'onesocial' ); ?></h5>

						<p class="email-wrap">
							<input type="email" id="register_email" name="register_email" placeholder="Email" class="input" />
						</p>

						<p class="username-wrap">
							<!-- fake fields are a workaround for chrome autofill getting the wrong fields -->
							<input style="display:none" type="password" name="fakepasswordremembered"/>
							<input type="text" id="register_username" name="register_username" placeholder="<?php _e( 'Username', 'onesocial' ) ?>" class="input" />
						</p>

						<p class="password-wrap">
							<input type="password" id="register_password" name="register_password" placeholder="<?php _e( 'Password', 'onesocial' ) ?>" class="input" />
						</p>

						<?php

						/**
						 * Fires and displays any extra member registration details fields.
						 *
						 * @since 1.2
						 */
						do_action( 'bp_account_details_fields' ); ?>

						<?php

						/**
						 * Fires after the display of member registration account details fields.
						 *
						 * @since 1.1.0
						 */
						do_action( 'bp_after_account_details_fields' ); ?>

						<?php /***** Extra Profile Details ******/ ?>

						<br/>

						<?php do_action( 'onesocial_registration_fields' ); ?>

						<?php if ( bp_is_active( 'xprofile' ) ) : if ( bp_has_profile( array( 'profile_group_id' => 1, 'fetch_field_data' => false ) ) ) : while ( bp_profile_groups() ) : bp_the_profile_group(); ?>
                        
						<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>

							<div<?php bp_field_css_class( 'editfield' ); ?>>

								<?php
								$field_type = bp_xprofile_create_field_type( bp_get_the_profile_field_type() );
								$field_type->edit_field_html();

								/**
								 * Fires before the display of the visibility options for xprofile fields.
								 *
								 * @since 1.7.0
								 */
								do_action( 'bp_custom_profile_edit_fields_pre_visibility' );

								if ( bp_current_user_can( 'bp_xprofile_change_field_visibility' ) ) : ?>
									<p class="field-visibility-settings-toggle" id="field-visibility-settings-toggle-<?php bp_the_profile_field_id() ?>">
										<?php
										printf(
											__( 'This field can be seen by: %s', 'buddypress' ),
											'<span class="current-visibility-level">' . bp_get_the_profile_field_visibility_level_label() . '</span>'
										);
										?>
										<a href="#" class="visibility-toggle-link"><?php _ex( 'Change', 'Change profile field visibility level', 'buddypress' ); ?></a>
									</p>

									<div class="field-visibility-settings" id="field-visibility-settings-<?php bp_the_profile_field_id() ?>" style="display: none;">
										<fieldset>
											<legend><?php _e( 'Who can see this field?', 'buddypress' ) ?></legend>

											<?php bp_profile_visibility_radio_buttons() ?>

										</fieldset>
										<a class="field-visibility-settings-close" href="#"><?php _e( 'Close', 'buddypress' ) ?></a>
									</div>

								<?php else : ?>
									<p class="field-visibility-settings-notoggle" id="field-visibility-settings-toggle-<?php bp_the_profile_field_id() ?>">
										<?php
										printf(
											__( 'This field can be seen by: %s', 'buddypress' ),
											'<span class="current-visibility-level">' . bp_get_the_profile_field_visibility_level_label() . '</span>'
										);
										?>
									</p>
								<?php endif ?>

								<?php

								/**
								 * Fires after the display of the visibility options for xprofile fields.
								 *
								 * @since 1.1.0
								 */
								do_action( 'bp_custom_profile_edit_fields' ); ?>

								<p class="description"><?php bp_the_profile_field_description(); ?></p>

							</div>

						<?php endwhile; ?>

						<input type="hidden" name="signup_profile_field_ids" id="signup_profile_field_ids" value="<?php bp_the_profile_field_ids(); ?>" />

						<?php endwhile; endif; endif; ?>

	                    <?php

	                    /**
	                     * Fires and displays any extra member registration xprofile fields & Memeber type fields.
	                     */
	                    do_action( 'bp_signup_profile_fields' ); ?>
                        
                        <?php remove_filter( 'bp_xprofile_is_richtext_enabled_for_field', 'onesocial_disable_richtext_for_fields', 90 );?>

						<p>
							<button id="register_button" class="button" type="submit"><i class="fa fa-spinner fa-spin" style="display: none"></i> <?php _e( 'Register Now', 'onesocial' ); ?></button>
						</p>

						<?php wp_nonce_field( 'ajax-register-security', 'ajax-register-security' ); ?>

						<h6><?php _e( 'Already a member?', 'onesocial' ); ?> <a href="#" class="siginbutton"><?php _e( 'Sign In', 'onesocial' ); ?></a>.</h6>
                    
                    </form><!-- #frm_siteRegisterBox -->
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

		</div>

	</div>

	<div class="joined" style="display:none">
		<h4 class="popup_title"><?php  printf( __( 'Welcome to %s', 'onesocial' ), get_bloginfo( 'name' ) ) ?></h4>

		<p class="express"><?php _e( 'To finish activating your account, check your inbox for our Welcome message and confirm your email address.', 'onesocial' ); ?></p>

		<button id="register_okay" class="button"><i class="fa fa-spinner fa-spin" style="display: none"></i> <?php _e( 'Okay', 'onesocial' ); ?></button>

	</div>

</div>

<a href="#siteRegisterBox" class="onesocial-register-popup-link mfp-hide"><?php _e( 'Register', 'onesocial' ); ?></a>
