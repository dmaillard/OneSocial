<?php
/**
 * BuddyPress - Group Header
 *
 * @package BuddyPress
 * @subpackage OneSocial Theme
 */
?>

<?php do_action( 'bp_before_group_header' ); ?>

<div id="item-header-inner" class="table1">

    <div id="item-header-desc">

        <div id="item-title-area" class="boss-group-header">

            <div class="group-header-wrap">

				<div class="bb-group-avatar-wrap-mobile">
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
								<clipPath id="hexagonal-mask-mobile" clipPathUnits="objectBoundingBox">
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

							<image class="before-load" clip-path="url(#hexagonal-mask-mobile)" height="100%" width="100%" xlink:href="<?php echo get_template_directory_uri(); ?>/images/background.png" />
							<image class="after-load" clip-path="url(#hexagonal-mask-mobile)" height="100%" width="100%" xlink:href="<?php echo $src; ?>" />
						</svg>
					</a>

				</div><!-- #item-header-avatar -->

				<div class="group-header-content">
					<h1 class="main-title"><?php bp_group_name(); ?></h1>
					<span class="highlight"><?php bp_group_type(); ?></span>
					<span class="activity"><?php printf( __( 'active %s', 'onesocial' ), bp_get_group_last_active() ); ?></span>
				</div>

				<div class="bb-group-mobile-content">

					<div id="item-header-content">

						<?php do_action( 'bp_before_group_header_meta' ); ?>

						<div id="item-meta">

							<?php bp_group_description(); ?>
							<?php do_action( 'bp_group_header_meta' ); ?>

						</div>

						<div id="item-buttons" class="group">

							<?php do_action( 'bp_group_header_actions' ); ?>

						</div>

					</div><!-- #item-header-content -->

				</div>

				<div id="item-actions">

					<?php if ( bp_group_is_visible() ) : ?>

						<?php
						buddyboss_group_list_admins();

						do_action( 'bp_after_group_menu_admins' );

						if ( bp_group_has_moderators() ) :
							do_action( 'bp_before_group_menu_mods' );
							?>

							<?php
							buddyboss_group_list_mods();

							do_action( 'bp_after_group_menu_mods' );

						endif;

					endif;
					?>

				</div><!-- #item-actions -->

            </div><!-- /.table-cell -->

        </div>
        <!-- /#item-title-area -->

        <div id="item-nav">
            <div class="item-list-tabs no-ajax" id="object-nav" role="navigation">
                <ul id="nav-bar-filter">

					<?php bp_get_options_nav(); ?>

					<?php
					/**
					 * Fires after the display of group options navigation.
					 *
					 * @since BuddyPress (1.2.0)
					 */
					do_action( 'bp_group_options_nav' );
					?>

                </ul>
            </div>
        </div><!-- #item-nav -->
    </div><!-- /#item-header-desc -->
</div>
<!-- /.table -->

<?php
do_action( 'bp_after_group_header' );
?>
