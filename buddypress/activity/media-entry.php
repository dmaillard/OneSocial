<?php

/**
 * BuddyPress - Activity Stream (Single Item)
 *
 * This template is used by activity-loop.php and AJAX functions to show
 * each activity.
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<?php do_action( 'bp_before_activity_entry' ); ?>

	<?php if ( bp_activity_has_content() ) : ?>

		<li class="bbmedia-grid-item" id="activity-<?php bp_activity_id(); ?>">

			<?php bp_activity_content_body(); ?>
			
			<div class="buddyboss_media_caption">
				<div class="buddyboss_media_caption_action"><?php bp_activity_action();?></div>
				<div class="buddyboss_media_caption_body">
					<?php remove_filter( 'bp_get_activity_content_body', array( buddyboss_media()->types->photo->hooks, 'bp_get_activity_content_body' ) ); ?>
					<?php bp_activity_content_body();?>
					<?php add_filter( 'bp_get_activity_content_body', array( buddyboss_media()->types->photo->hooks, 'bp_get_activity_content_body' ) ); ?>
				</div>
			</div>
			
		</li>

	<?php endif; ?>

<?php do_action( 'bp_after_activity_entry' ); ?>