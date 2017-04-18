<?php
/**
 * BuddyPress - Users Header
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */
?>

<?php do_action( 'bp_before_member_header' ); ?>

<div id="item-header-avatar">
	<div class="item-avatar author-avatar">
		<div class="inner-avatar-wrap">
			<?php
			$current_user	 = get_current_user_id();
			$displayed_user	 = bp_displayed_user_id();

			if ( $current_user != $displayed_user ) {
				if ( function_exists( 'bp_follow_add_follow_button' ) ) {
					remove_action( 'bp_member_header_actions', 'bp_follow_add_profile_follow_button' );
					bp_follow_add_follow_button();
				} elseif ( bp_is_active( 'friends' ) ) {
					remove_action( 'bp_member_header_actions', 'bp_add_friend_button', 5 );
					bp_add_friend_button( bp_displayed_user_id() );
				}

				if ( bp_is_active( 'messages' ) ) {
					remove_action( 'bp_member_header_actions', 'bp_send_private_message_button', 20 );
					bp_send_private_message_button();
				}
			}
			?>

			<a class="boss-avatar-container" href="<?php echo bp_core_get_user_domain( $displayed_user ); ?>">
				<?php bp_displayed_user_avatar( 'type=full&width=215&height=215' ); ?>
			</a>
		</div>
	</div>
</div><!-- #item-header-avatar -->

<div id="item-header-content">

	<h1><?php echo bp_get_displayed_user_fullname(); ?></h1>

	<?php if ( bp_is_active( 'activity' ) && bp_activity_do_mentions() ) : ?>
		<h2 class="user-nicename">@<?php bp_displayed_user_mentionname(); ?></h2>
	<?php endif; ?>

	<?php
	$bio_field = onesocial_get_option( 'boss_bio_field' );
	if ( $bio_field && function_exists( 'bp_get_profile_field_data' ) ) {
		$bio = bp_get_profile_field_data( array( 'field' => $bio_field ) );
		if ( $bio ) {
			?>
			<p id="item-desc"><?php echo stripslashes( $bio ); ?></p>
			<?php
		}
	}
	?>

	<!-- Socials -->
	<div class="btn-group social">

		<?php
		add_filter( "buddyboss_get_user_social_array", "buddyboss_user_social_remove_disabled" ); //remove disabled.

		foreach ( buddyboss_get_user_social_array() as $social => $name ):
			$url = buddyboss_get_user_social( bp_displayed_user_id(), $social );
			?>

			<?php if ( !empty( $url ) ): ?>
				<a class="btn" href="<?php echo $url; ?>" title="<?php echo esc_attr( $name ); ?>" target="_blank"><i class="bb-icon-<?php echo $social; ?>"></i></a>
			<?php endif; ?>

		<?php endforeach; ?>

	</div>

	<?php do_action( 'bp_before_member_header_meta' ); ?>

	<div id="item-meta" class="author-header-meta">

		<?php if ( $current_user != $displayed_user ) {
			?>

			<div id="item-buttons">

				<?php do_action( 'bp_member_header_actions' ); ?>

			</div><!-- #item-buttons -->

		<?php } ?>

		<?php
		/*		 * *
		 * If you'd like to show specific profile fields here use:
		 * bp_member_profile_data( 'field=About Me' ); -- Pass the name of the field
		 */
		do_action( 'bp_profile_header_meta' );
		?>

	</div><!-- #item-meta -->

</div><!-- #item-header-content -->

<?php do_action( 'bp_after_member_header' ); ?>

<?php do_action( 'template_notices' ); ?>