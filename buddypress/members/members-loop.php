<?php
/**
 * BuddyPress - Members Loop
 *
 * Querystring is set via AJAX in _inc/ajax.php - bp_legacy_theme_object_filter()
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */
?>

<?php do_action( 'bp_before_members_loop' ); ?>

<?php if ( bp_has_members( bp_ajax_querystring( 'members' ) ) ) : ?>

	<?php do_action( 'bp_before_directory_members_list' ); ?>

	<div class="dir-list">

		<ul id="members-list" class="item-list">

			<?php while ( bp_members() ) : bp_the_member(); ?>
				<?php $user_id = bp_get_member_user_id(); ?>
				<li>
					<div class="item-avatar">
						<div class="inner-avatar-wrap">
							<?php
							if ( function_exists( 'bp_add_friend_button' ) ) :
								bp_add_friend_button( bp_get_member_user_id() );
							endif;
							?>

							<a class="boss-avatar-container" href="<?php bp_member_permalink(); ?>">
								<?php bp_member_avatar( 'type=full&width=215&height=215' ); ?>
							</a>
						</div>
					</div>

					<div class="item">
						<div class="item-title">
							<a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a>

							<?php if ( is_user_logged_in() && ( $user_id != get_current_user_id() ) ) { ?>
								<div class="bb-member-quick-link-wrapper">
									<div class="action"><?php do_action( 'bp_directory_members_actions' ); ?></div>
									<i class="bb-icon-bars-f"></i>
								</div>
							<?php } ?>
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

						<?php do_action( 'bp_directory_members_item' ); ?>

						<?php
						/*						 * *
						 * If you want to show specific profile fields here you can,
						 * but it'll add an extra query for each member in the loop
						 * (only one regardless of the number of fields you show):
						 *
						 * bp_member_profile_data( 'field=the field name' );
						 */
						?>
					</div>

					<?php
//					$friend_ids = friends_get_friend_user_ids( $user_id );
//					if ( !empty( $friend_ids ) ) {
//
					?>
					<!--<ul class="horiz-gallery">-->
					<?php
//							$i = 0;
//							foreach ( $friend_ids as $id ) {
//
					?>
					<!--								<li>
														<a href="<?php //echo bp_core_get_user_domain( $id )                     ?>">
					<?php //echo bp_core_fetch_avatar( array( $id, 'type' => 'thumb' ) )  ?>
					<?php //echo get_avatar( $id );  ?>
														</a>
													</li>-->
					<?php
//								$i++;
//								if ( $i == 4 ) {
//									break;
//								}
//							}
//
					?>

					<!--				<li class="see-more">
										<a href="<?php //echo bp_member_permalink() . bp_get_friends_slug();                      ?>" class="bb-icon-arrow-right-f"></a>
									</li>

								</ul>-->
					<?php
//					}
					?>

					<div class="clear"></div>
				</li>

			<?php endwhile; ?>

		</ul>

	</div>

	<?php do_action( 'bp_after_directory_members_list' ); ?>

	<?php bp_member_hidden_fields(); ?>

	<div id="pag-bottom" class="pagination">

		<div class="pag-count" id="member-dir-count-bottom">

			<?php bp_members_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="member-dir-pag-bottom">

			<?php bp_members_pagination_links(); ?>

		</div>

	</div>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( "Sorry, no members were found.", 'onesocial' ); ?></p>
	</div>

<?php endif; ?>

<?php do_action( 'bp_after_members_loop' ); ?>