<?php
/**
 * BuddyPress - Groups Loop
 *
 * Querystring is set via AJAX in _inc/ajax.php - bp_legacy_theme_object_filter()
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */
?>

<?php do_action( 'bp_before_groups_loop' ); ?>

<?php if ( bp_has_groups( bp_ajax_querystring( 'groups' ) ) ) : ?>

	<?php do_action( 'bp_before_directory_groups_list' ); ?>

	<ul id="groups-list" class="item-list">

		<?php while ( bp_groups() ) : bp_the_group(); ?>

			<li <?php bp_group_class(); ?>>

				<div class="item-avatar">
					<div class="inner-avatar-wrap bb-group-avatar-wrap">

						<div class="action">
							<?php do_action( 'bp_directory_groups_actions' ); ?>

							<div class="meta bb-meta">
								<?php
								//bp_group_type();

								global $groups_template;

								if ( empty( $group ) )
									$group = & $groups_template->group;

								if ( 'public' == $group->status ) {
									$type = '<i class="fa bb-icon fa-unlock-alt"></i><span>' . __( 'Public', 'buddypress' ) . '</span>';
								} elseif ( 'hidden' == $group->status ) {
									$type = '<i class="fa bb-icon fa-eye-slash"></i><span>' . __( 'Hidden', 'buddypress' ) . '</span>';
								} elseif ( 'private' == $group->status ) {
									$type = '<i class="fa bb-icon fa-lock"></i><span>' . __( 'Private', 'buddypress' ) . '</span>';
								} else {
									$type = ucwords( $group->status ) . ' ' . __( 'Group', 'buddypress' );
								}

								echo $type;
								?>
							</div>
						</div>

						<?php
						global $groups_template;

						$html			 = bp_get_group_avatar( 'type=full' );
						$doc			 = new DOMDocument();
						$doc->loadHTML( $html );
						$xpath			 = new DOMXPath( $doc );
						$src			 = $xpath->evaluate( "string(//img/@src)" );
						?>
						<a href="<?php bp_group_permalink(); ?>" title="<?php bp_group_name(); ?>">
							<svg class="svg-graphic" width="190" height="190" xmlns="http://www.w3.org/2000/svg" xlink="http://www.w3.org/1999/xlink" version="1.1">
								<g>
									<clipPath id="hexagonal-mask" clipPathUnits="objectBoundingBox">
										<circle cx="0.504" cy="0.123" r="0.123"/>
										<circle cx="0.177" cy="0.311" r="0.123"/>
										<circle cx="0.177" cy="0.689" r="0.123"/>
										<circle cx="0.504" cy="0.877" r="0.123"/>
										<circle cx="0.83" cy="0.688" r="0.123"/>
										<circle cx="0.83" cy="0.311" r="0.123"/>
										<polygon points="0.441,0.017 0.566,0.017 0.891,0.204 0.953,0.312 0.953,0.687 0.891,0.795 0.566,0.983 0.441,0.983 0.117,0.796
												 0.054,0.687 0.054,0.311 0.117,0.204 "/>
									</clipPath>
								</g>

								<image class="before-load" clip-path="url(#hexagonal-mask)" height="100%" width="100%" xlink:href="<?php echo get_template_directory_uri(); ?>/images/background.png" />
								<image class="after-load" clip-path="url(#hexagonal-mask)" height="100%" width="100%" xlink:href="<?php echo $src; ?>" />
							</svg>
						</a>

					</div>
				</div>

				<div class="item boss-group-content">
					<div class="item-title">
						<a href="<?php bp_group_permalink(); ?>">
							<?php
							$title			 = bp_get_group_name( $group );
							echo onesocial_custom_excerpt( $title, 6 );
							?>
						</a>
					</div>
					<div class="item-desc"><?php bp_group_description_excerpt(); ?></div>

					<?php do_action( 'bp_directory_groups_item' ); ?>

				</div>

                <div class="after_group_content">
                <?php do_action('bb_after_group_content'); ?>
                </div>

				<?php
				$total_members	 = bp_get_group_total_members();

				if ( $total_members > 0 ) {
					?>

					<div class="info-group">
						<div class="bb-follow-title"><?php _e( "Members", 'onesocial' ); ?><span><?php echo $total_members; ?></span></div>

						<?php if ( bp_group_has_members( 'group_id=' . bp_get_group_id() . '&exclude_admins_mods=0&per_page=4' ) ) : ?>
							<div class="group-members-results">
								<ul class="horiz-gallery">
									<?php while ( bp_group_members() ) : bp_group_the_member(); ?>

										<li>
											<?php
											global $members_template;
											echo '<a href="' . bp_core_get_user_domain( $members_template->member->user_id, $members_template->member->user_nicename, $members_template->member->user_login ) . '">' . bp_get_group_member_avatar_thumb() . '</a>';
											?>
										</li>
									<?php endwhile; ?>
									<li class="see-more">
										<a href="<?php echo bp_get_group_permalink(); ?>members" class="bb-icon-arrow-right-f"></a>
									</li>
								</ul>
							</div>
							<?php
						endif;
						?>

					</div>
                <?php
				}
				?>
			</li>

		<?php endwhile; ?>

	</ul>

	<?php do_action( 'bp_after_directory_groups_list' ); ?>

	<div id="pag-bottom" class="pagination">

		<div class="pag-count" id="group-dir-count-bottom">

			<?php bp_groups_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="group-dir-pag-bottom">

			<?php bp_groups_pagination_links(); ?>

		</div>

	</div>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'There were no groups found.', 'onesocial' ); ?></p>
	</div>

<?php endif; ?>

<?php do_action( 'bp_after_groups_loop' ); ?>
