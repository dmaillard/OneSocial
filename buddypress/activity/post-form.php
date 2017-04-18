<?php
/**
 * BuddyPress - Activity Post Form
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */
?>

<form action="<?php bp_activity_post_form_action(); ?>" method="post" id="whats-new-form" class="isCollapsed" name="whats-new-form" role="complementary">

	<?php
	/**
	 * Fires before the activity post form.
	 *
	 * @since BuddyPress (1.2.0)
	 */
	do_action( 'bp_before_activity_post_form' );
	?>

    <div id="whats-new-header">
        <div id="whats-new-avatar">
            <a href="<?php echo bp_loggedin_user_domain(); ?>">
				<?php bp_loggedin_user_avatar( 'type=thumb&width=60&height=60' ); ?>
            </a>
        </div>
        <div id="whats-new-header-content">
            <p class="activity-greeting"><?php
				if ( bp_is_group() )
					printf( __( "What's new in %s, %s?", 'onesocial' ), bp_get_group_name(), bp_get_user_firstname( bp_get_loggedin_user_fullname() ) );
				else
					printf( __( "What's new, %s?", 'onesocial' ), bp_get_user_firstname( bp_get_loggedin_user_fullname() ) );
				?></p>
            <p class="whats-author">
				<?php bp_loggedin_user_fullname(); ?>
            </p>
        </div>
        <div id="whats-new-selects">
			<?php if ( bp_is_active( 'groups' ) && !bp_is_my_profile() && !bp_is_group() ) : ?>

				<div id="whats-new-post-in-box">

					<?php _e( 'Post in', 'onesocial' ); ?>:

					<select id="whats-new-post-in" name="whats-new-post-in">
						<option selected="selected" value="0"><?php _e( 'My Profile', 'onesocial' ); ?></option>

						<?php
						if ( bp_has_groups( 'user_id=' . bp_loggedin_user_id() . '&type=alphabetical&max=100&per_page=100&populate_extras=0&update_meta_cache=0' ) ) :
							while ( bp_groups() ) : bp_the_group();
								?>

								<option value="<?php bp_group_id(); ?>"><?php bp_group_name(); ?></option>

								<?php
							endwhile;
						endif;
						?>

					</select>
				</div>
				<input type="hidden" id="whats-new-post-object" name="whats-new-post-object" value="groups" />

			<?php elseif ( bp_is_group_home() ) : ?>

				<input type="hidden" id="whats-new-post-object" name="whats-new-post-object" value="groups" />
				<input type="hidden" id="whats-new-post-in" name="whats-new-post-in" value="<?php bp_group_id(); ?>" />

			<?php endif; ?>
        </div>
    </div>

	<div id="whats-new-content">
		<div id="whats-new-textarea">
			<textarea class="bp-suggestions" name="whats-new" id="whats-new" cols="50" tabindex="-1" rows="10" <?php if ( bp_is_group() ) : ?>data-suggestions-group-id="<?php echo esc_attr( (int) bp_get_current_group_id() ); ?>" <?php endif; ?>
					  >
				<?php if ( isset( $_GET[ 'r' ] ) ) : ?>@<?php echo esc_textarea( $_GET[ 'r' ] ); ?> <?php endif; ?>
			</textarea>

			<div class="boss-insert-buttons">
				<a class="boss-insert-buttons-show" href="#">+</a>
				<ul class="boss-insert-buttons-addons">
					<li><a class="boss-insert-image"><i class="bb-icon-camera"></i></a></li>
					<li><a class="boss-insert-video" data-placeholder="<?php _e( 'Paste a YouTube, Vimeo, Facebook, Twitter or Instagram link and press Publish', 'onesocial' ); ?>"><i class="bb-icon-play"></i></a></li>
				</ul>
			</div>
		</div>

		<div id="whats-new-options">
			<div id="whats-new-submit">
				<input type="submit" name="aw-whats-new-submit" id="aw-whats-new-submit" value="<?php esc_attr_e( 'Publish', 'onesocial' ); ?>" />
			</div>

            <div id="whats-new-close"><?php _e( 'Close', 'onesocial' ); ?></div>

			<?php
			/**
			 * Fires at the end of the activity post form markup.
			 *
			 * @since BuddyPress (1.2.0)
			 */
			do_action( 'bp_activity_post_form_options' );
			?>

		</div><!-- #whats-new-options -->
	</div><!-- #whats-new-content -->

	<?php wp_nonce_field( 'post_update', '_wpnonce_post_update' ); ?>
	<?php
	/**
	 * Fires after the activity post form.
	 *
	 * @since BuddyPress (1.2.0)
	 */
	do_action( 'bp_after_activity_post_form' );
	?>

</form><!-- #whats-new-form -->
