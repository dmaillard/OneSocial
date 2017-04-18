<?php
$wrapper_class = 'modal-without-social-login';
global $WORDPRESS_SOCIAL_LOGIN_VERSION;

if ( $WORDPRESS_SOCIAL_LOGIN_VERSION ) {
	$wrapper_class = 'modal-with-social-login';
}
?>

<div id="siteRegisterBox" class="mfp-hide boss-modal-form popup-content <?php echo $wrapper_class; ?>">
	<div id="box_container">
		<form method="POST" action="<?php echo admin_url( 'admin-ajax.php' ); ?>" id="frm_siteRegister" class="siteRegisterBoxsteps frm_siteRegister">

			<input type="hidden" name="action" value="ajax_siteRegister" />

			<div class="boxcontent">
				<?php
				if ( is_user_logged_in() ) {
					bboss_we_load_template( 'profile' );
				} else {
					bboss_we_load_template( 'register' );
				}
				?>
			</div>

		</form>
	</div>

</div><!--#siteRegisterBox-->

<a href="#siteRegisterBox" class="boss-register-popup-link mfp-hide">popup</a>