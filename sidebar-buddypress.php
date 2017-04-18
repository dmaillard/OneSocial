<?php
/**
 * The sidebar containing the BuddyPress widget areas.
 *
 * If no active widgets in sidebar, let's hide it completely.
 *
 * @package WordPress
 * @subpackage OneSocial Theme
 */
global $bp;

if ( function_exists( 'bp_is_active' ) ) {
	?>

	<?php if ( is_active_sidebar( 'activity' ) && bp_is_current_component( 'activity' ) && !bp_is_user() ) : ?>

		<div id="secondary" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'activity' ); ?>
		</div>

	<?php elseif ( is_active_sidebar( 'blogs' ) && is_multisite() && bp_is_current_component( 'blogs' ) && !bp_is_user() ) : ?>

		<div id="secondary" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'blogs' ); ?>
		</div>

	<?php elseif ( is_active_sidebar( 'forums' ) && bp_is_current_component( 'forums' ) && !bp_is_user() ) : ?>

		<div id="secondary" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'forums' ); ?>
		</div>

		<?php
	endif;
}