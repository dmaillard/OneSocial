<?php
if ( !is_user_logged_in() ) {

	if ( onesocial_get_option( 'user_login_option' ) ) {

		if ( buddyboss_is_bp_active() && bp_get_signup_allowed() ) {
			?>

			<a href="<?php echo bp_get_signup_page(); ?>" class="register header-button animatedClick boss-tooltip" data-target="RegisterBox" data-tooltip="<?php _e( 'Register', 'onesocial' ); ?>"><i class="bb-icon-pencil-square-o"></i></a><?php
			//get_template_part( 'template-parts/site-register' );
		}

		?>

		<a href="#" class="login header-button animatedClick boss-tooltip" data-target="LoginBox" data-tooltip="<?php _e( 'Login', 'onesocial' ); ?>"><i class="bb-icon-exit"></i></a><?php
		//get_template_part( 'template-parts/site-login' );
	} else {

		if ( bp_get_signup_allowed() ) {
			?>
			<a href="<?php echo bp_get_signup_page(); ?>" class="header-button boss-tooltip" data-tooltip="<?php _e( 'Register', 'onesocial' ); ?>"><i class="bb-icon-pencil-square-o"></i></a>
		<?php } ?>

		<a href="<?php echo wp_login_url(); ?>" class="header-button boss-tooltip" data-tooltip="<?php _e( 'Login', 'onesocial' ); ?>"><i class="bb-icon-exit"></i></a>

		<?php
	}
} else {

	$user_link = function_exists( 'bp_core_get_user_domain' ) ? bp_core_get_user_domain( get_current_user_id() ) : '#';
    
    if(function_exists( 'is_buddypress' )) {
	?>
	<div class="header-account-login header-button">

		<a class="user-link" href="<?php echo $user_link; ?>">
			<?php echo get_avatar( get_current_user_id(), 100 ); ?>
		</a>

		<div class="pop">
			<?php
			if ( onesocial_get_option( 'boss_dashboard' ) && ( current_user_can( 'level_10' ) || ( function_exists( 'bp_get_member_type' ) && bp_get_member_type( get_current_user_id() )) == 'teacher' || ( function_exists( 'bp_get_member_type' ) && bp_get_member_type( get_current_user_id() )) == 'group_leader') ) {
				get_template_part( 'template-parts/header-dashboard-links' );
			}
			
			$class = function_exists( 'is_buddypress' ) ? 'bp-active' : 'bp-inactive';
			?>

			<div id="adminbar-links" class="bp_components adminbar-links <?php echo $class; ?>">
				<?php buddyboss_adminbar_myaccount(); ?>
			</div>

			<?php
			if ( onesocial_get_option( 'boss_profile_adminbar' ) ) {
				wp_nav_menu( array( 'theme_location' => 'header-my-account', 'fallback_cb' => '', 'menu_class' => 'links' ) );
			}
			?>

			<a class="boss-logout" href="<?php echo wp_logout_url(); ?>"><?php _e( 'Logout', 'onesocial' ); ?></a>
		</div>

	</div>

	<?php
    }
}