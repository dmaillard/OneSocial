<?php
/* * **************************************
 * Main.php
 *
 * The main template file, that loads the header, footer and sidebar
 * apart from loading the appropriate rtMedia template
 * *************************************** */
// by default it is not an ajax request
global $rt_ajax_request;
$rt_ajax_request = false;

// check if it is an ajax request
if ( !empty( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) && strtolower( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) == 'xmlhttprequest' ) {
	$rt_ajax_request = true;
}
?>

<div id="buddypress">

	<?php
	//output cover photo.
	if( ! $rt_ajax_request && bp_is_group() ) {
		if ( bp_has_groups() ) {
			while ( bp_groups() ) {
				bp_the_group();
				echo buddyboss_cover_photo( "group", bp_get_group_id() );
			}
		}
	}
	?>
	
	<?php if ( ! $rt_ajax_request ): ?>
	    <div class="buddypress-content-wrap">
			<section class="buddypress-content">
    <?php endif; ?>


			<?php
			//if it's not an ajax request, load headers
			if ( !$rt_ajax_request ) {
				// if this is a BuddyPress page, set template type to
				// buddypress to load appropriate headers
				if ( class_exists( 'BuddyPress' ) && !bp_is_blog_page() && apply_filters( 'rtm_main_template_buddypress_enable', true ) ) {
					$template_type = 'buddypress';
				} else {
					$template_type = '';
				}
				//get_header( $template_type );

				if ( $template_type == 'buddypress' ) {
					//load buddypress markup
					if ( bp_displayed_user_id() ) {

						//if it is a buddypress member profile
						?>
						<?php do_action( 'bp_before_member_home_content' ); ?>

						<div id="item-nav">
							<div class="item-list-tabs no-ajax" id="object-nav" role="navigation">
								<ul id="nav-bar-filter">

									<?php bp_get_displayed_user_nav(); ?>

									<?php do_action( 'bp_member_options_nav' ); ?>

								</ul>
							</div>
						</div><!--#item-nav-->

						<?php echo '<div id="item-body" role="main">'; ?>

						<?php do_action( 'bp_before_member_body' ); ?>
						<?php do_action( 'bp_before_member_media' ); ?>

						<div class="item-list-tabs no-ajax" id="subnav">
							<ul>

								<?php rtmedia_sub_nav(); ?>

								<?php do_action( 'rtmedia_sub_nav' ); ?>

							</ul>

						</div><!-- .item-list-tabs -->

						<?php
					} else if ( bp_is_group() ) {

						//not a member profile, but a group
						?>

						<?php if ( bp_has_groups() ) : while ( bp_groups() ) : bp_the_group(); ?>

								<?php
								/**
								 * Fires before the display of the group home content.
								 *
								 * @since 1.2.0
								 */
								do_action( 'bp_before_group_home_content' );
								?>

								<div id="item-header" role="complementary">

									<?php bp_get_template_part( 'groups/single/group-header' ); ?>

								</div><!-- #item-header -->

								<?php echo '<div id="item-body">'; ?>


								<?php do_action( 'bp_before_group_body' ); ?>
								<?php do_action( 'bp_before_group_media' ); ?>

								<div class="item-list-tabs no-ajax" id="subnav">
									<ul>

										<?php rtmedia_sub_nav(); ?>

										<?php do_action( 'rtmedia_sub_nav' ); ?>

									</ul>
								</div><!-- .item-list-tabs -->
								<?php
							endwhile;
						endif;
					}
				} else {
					//if BuddyPress
					echo '<div id="item-body">';
				}
			}

			// if ajax include the right rtMedia template
			rtmedia_load_template();

			if ( !$rt_ajax_request ) {

				if ( function_exists( "bp_displayed_user_id" ) && $template_type == 'buddypress' && (bp_displayed_user_id() || bp_is_group()) ) {

					if ( bp_is_group() ) {
						do_action( 'bp_after_group_media' );
						do_action( 'bp_after_group_body' );
					}

					if ( bp_displayed_user_id() ) {
						do_action( 'bp_after_member_media' );
						do_action( 'bp_after_member_body' );
					}
				}

				echo '</div><!--#item-body-->';

				if ( function_exists( "bp_displayed_user_id" ) && $template_type == 'buddypress' && (bp_displayed_user_id() || bp_is_group()) ) {

					if ( bp_is_group() ) {
						do_action( 'bp_after_group_home_content' );
					}

					if ( bp_displayed_user_id() ) {
						do_action( 'bp_after_member_home_content' );
					}
				}
			}
			?>
								
		<?php if ( ! $rt_ajax_request ): ?>
			</section>
		<?php endif; ?>

		<?php if ( ! $rt_ajax_request && !( bp_is_user_settings() || bp_is_user_messages() ) ) : ?>

			<div id="secondary" class="widget-area" role="complementary">

				<?php if (  bp_displayed_user_id() ) { ?>
					<div id="item-header" class="item-header-sidebar" role="complementary">
						<?php bp_get_template_part( 'members/single/member-header' ) ?>
					</div><?php
				}
				
				if( bp_is_group() ) { ?>
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

						<div id="item-buttons" class="group">

							<?php do_action( 'bp_group_header_actions' ); ?>

						</div><!-- #item-buttons -->
				
					</div><?php
				}

				if (  bp_displayed_user_id() && is_active_sidebar( 'profile' ) ) {
					global $members_template;
					//backup the group current loop to ignore loop conflict from widgets
					$members_template_safe	 = $members_template;
					dynamic_sidebar( 'profile' );
					//restore the oringal $groups_template before sidebar.
					$members_template		 = $members_template_safe;
				} elseif( bp_is_group() && is_active_sidebar( 'group' ) ) {
					global $members_template;
					//backup the group current loop to ignore loop conflict from widgets
					$members_template_safe	 = $members_template;
					dynamic_sidebar( 'group' );
					//restore the oringal $groups_template before sidebar.
					$members_template		 = $members_template_safe;
				}
				?>

			</div>

		<?php endif; ?>
	
	<?php if ( ! $rt_ajax_request ): ?>
		</div>
	<?php endif; ?>

</div><!--#buddypress-->