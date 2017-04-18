<?php $pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0'; ?>
<div id="buddypress" <?php if(onesocial_get_option( 'boss_cover_group_size' ) != 200 && !$pageWasRefreshed ) echo "style='margin-top:-260px;'"; ?> data-page-refreshed="<?php echo ($pageWasRefreshed)?1:0; ?>"  data-cover-size="<?php echo onesocial_get_option( 'boss_cover_group_size' ); ?>">

<?php if ( bp_has_groups() ) : while ( bp_groups() ) : bp_the_group(); ?>

			<?php
			//output cover photo.
			echo buddyboss_cover_photo( "group", bp_get_group_id() );
			?>

			<div class="buddypress-content-wrap">

				<section class="buddypress-content">

				<?php
				/**
				 * Fires before the display of the group home content.
				 *
				 * @since BuddyPress (1.2.0)
				 */
				do_action( 'bp_before_group_home_content' );
				?>

				<div id="item-header" role="complementary">

					<?php bp_get_template_part( 'groups/single/group-header' ); ?>

				</div><!-- #item-header -->

				<div id="item-body">
					<?php
					do_action( 'template_notices' );
					?>

					<?php
					/**
					 * Fires before the display of the group home body.
					 *
					 * @since BuddyPress (1.2.0)
					 */
					do_action( 'bp_before_group_body' );

					/**
					 * Does this next bit look familiar? If not, go check out WordPress's
					 * /wp-includes/template-loader.php file.
					 *
					 * @todo A real template hierarchy? Gasp!
					 */
					// Looking at home location
					if ( bp_is_group_home() ) :

						if ( bp_group_is_visible() ) {

							// Load appropriate front template
							bp_groups_front_template_part();

						} else {

							/**
							 * Fires before the display of the group status message.
							 *
							 * @since BuddyPress (1.1.0)
							 */
							do_action( 'bp_before_group_status_message' );
							?>

							<div id="message" class="info">
								<p><?php bp_group_status_message(); ?></p>
							</div>

							<?php
							/**
							 * Fires after the display of the group status message.
							 *
							 * @since BuddyPress (1.1.0)
							 */
							do_action( 'bp_after_group_status_message' );
						}

					// Not looking at home
					else :

						// Group Admin
						if ( bp_is_group_admin_page() ) : bp_get_template_part( 'groups/single/admin' );

						// Group Activity
						elseif ( bp_is_group_activity() ) : bp_get_template_part( 'groups/single/activity' );

						// Group Members
						elseif ( bp_is_group_members() ) : bp_groups_members_template_part();

						// Group Invitations
						elseif ( bp_is_group_invites() ) : bp_get_template_part( 'groups/single/send-invites' );

						// Old group forums
						elseif ( bp_is_group_forum() ) : bp_get_template_part( 'groups/single/forum' );

						// Membership request
						elseif ( bp_is_group_membership_request() ) : bp_get_template_part( 'groups/single/request-membership' );

						// Anything else (plugins mostly)
						else : bp_get_template_part( 'groups/single/plugins' );

						endif;

					endif;

					/**
					 * Fires after the display of the group home body.
					 *
					 * @since BuddyPress (1.2.0)
					 */
					do_action( 'bp_after_group_body' );
					?>

				</div><!-- #item-body -->

				<?php
				/**
				 * Fires after the display of the group home content.
				 *
				 * @since BuddyPress (1.2.0)
				 */
				do_action( 'bp_after_group_home_content' );
				?>
			</section>

			<div id="secondary" class="widget-area" role="complementary">

				<div class="bb-group-avatar-wrap-desktop">

					<div id="item-header-avatar" class="bb-group-avatar-wrap">
						<?php
						$html	 = bp_get_group_avatar( 'type=full' );
						$doc	 = new DOMDocument();
						$doc->loadHTML( $html );
						$xpath	 = new DOMXPath( $doc );
						$src	 = $xpath->evaluate( "string(//img/@src)" );
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

					</div><!-- #item-header-avatar -->

					<div id="item-header-content">

						<?php do_action( 'bp_before_group_header_meta' ); ?>

						<div id="item-meta">

							<?php bp_group_description(); ?>
							<?php do_action( 'bp_group_header_meta' ); ?>

						</div>
					</div><!-- #item-header-content -->

					<?php if ( $group_type_list =  bp_get_group_type_list( bp_get_group_id() ) ): ?>
						<div id="group-types-list">

							<?php echo $group_type_list ?>

						</div><!-- #group-types-list-->
					<?php endif; ?>

					<div id="item-buttons" class="group">

						<?php do_action( 'bp_group_header_actions' ); ?>

					</div><!-- #item-buttons -->

				</div>

				<?php

				global $bp;
				if ( is_active_sidebar( 'group' ) && bp_is_group() && ( 'create' !== $bp->current_action ) ) {
					global $groups_template;
					//backup the group current loop to ignore loop conflict from widgets
					$groups_template_safe = $groups_template;
					dynamic_sidebar( 'group' );
					//restore the oringal $groups_template before sidebar.
					$groups_template = $groups_template_safe;
				} ?>
			</div>


		</div><!--.buddypress-content-wrap-->

		<?php endwhile;
	endif; ?>

</div><!-- #buddypress -->
