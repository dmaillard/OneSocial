<?php
/**
 * BuddyPress - Groups Members
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<?php if ( bp_group_has_members( bp_ajax_querystring( 'group_members' ) ) ) : ?>

	<?php

	/**
	 * Fires before the display of the group members content.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_group_members_content' ); ?>

	<?php

	/**
	 * Fires before the display of the group members list.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_group_members_list' ); ?>

	<ul id="member-list" class="item-list bb-group-members">

		<?php while ( bp_group_members() ) : bp_group_the_member(); ?>
			<?php $user_id = bp_get_member_user_id(); ?>
			<li>

				<div class="item-avatar">
					<div class="inner-avatar-wrap">
						<?php
						if ( function_exists( 'bp_add_friend_button' ) ) :
							bp_add_friend_button( $user_id );
						endif;
						?>

						<a class="boss-avatar-container" href="<?php bp_group_member_domain(); ?>">
							<?php bp_group_member_avatar_thumb( 'type=full&width=215&height=215' ); ?>
						</a>
					</div>
				</div>

				<div id="item-content" class="groups">
					<div class="item-title">
						<div class="title-wrap">
							<?php bp_group_member_link(); ?>

							<?php if ( is_user_logged_in() && ( $user_id != get_current_user_id() ) ) { ?>
								<div class="bb-member-quick-link-wrapper">
									<div class="action"><?php do_action( 'bp_group_members_list_item_action' ); ?></div>
									<i class="bb-icon-bars-f"></i>
								</div>
							<?php } ?>
						</div>
						<span class="activity"><?php bp_group_member_joined_since(); ?></span>
					</div>

					<?php do_action( 'bp_group_members_list_item' ); ?>

				</div>

				<div class="item-desc">
					<?php
					$bio_field = onesocial_get_option( 'boss_bio_field' );
					if ( $bio_field ) {
						$bio = bp_get_profile_field_data( array( 'field' => $bio_field, 'user_id' => $user_id ) );
						if ( $bio ) {
							?>
							<div class="author-bio"><?php echo onesocial_custom_excerpt( $bio, 15 ); ?></div>
							<?php
						}
					}
					?>
				</div>

			</li>

		<?php endwhile; ?>

	</ul>

	<?php

	/**
	 * Fires after the display of the group members list.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_after_group_members_list' ); ?>

	<div id="pag-bottom" class="pagination">

		<div class="pag-count" id="member-count-bottom">

			<?php bp_members_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="member-pag-bottom">

			<?php bp_members_pagination_links(); ?>

		</div>

	</div>

	<?php

	/**
	 * Fires after the display of the group members content.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_after_group_members_content' ); ?>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'No members were found.', 'buddypress' ); ?></p>
	</div>

<?php endif; ?>