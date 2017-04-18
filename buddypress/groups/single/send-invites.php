<?php do_action( 'bp_before_group_send_invites_content' ); ?>

<?php if ( bp_get_total_friend_count( bp_loggedin_user_id() ) ) : ?>

	<form action="<?php bp_group_send_invite_form_action(); ?>" method="post" id="send-invite-form" class="standard-form send-invite-form" role="main">

		<div class="left-menu">

			<div id="invite-list" class="boss-group-invite-friend-list">
				<ul>
					<?php //bp_new_group_invite_friend_list(); ?>
					<?php echo boss_get_new_group_invite_friend_list(); ?>
				</ul>

				<?php wp_nonce_field( 'groups_invite_uninvite_user', '_wpnonce_invite_uninvite_user' ); ?>
			</div>

		</div><!-- .left-menu -->

		<div class="main-column">

			<div id="message" class="info">
				<p><?php _e( 'Select people to invite from your friends list.', 'onesocial' ); ?></p>
			</div>

			<?php do_action( 'bp_before_group_send_invites_list' ); ?>

			<?php /* The ID 'friend-list' is important for AJAX support. */ ?>
			<ul id="friend-list" class="item-list groups bb-invite-list">
				<?php if ( bp_group_has_invites() ) : ?>

					<?php while ( bp_group_invites() ) : bp_group_the_invite(); ?>

						<li id="<?php bp_group_invite_item_id(); ?>">
							<?php bp_group_invite_user_avatar(); ?>
							<div id="item-content" class="groups">
								<h5><?php bp_group_invite_user_link(); ?></h5>
								<span class="activity"><?php bp_group_invite_user_last_active(); ?></span>

								<?php do_action( 'bp_group_send_invites_item' ); ?>
							</div>

							<div class="action">
								<a class="button remove" href="<?php bp_group_invite_user_remove_invite_url(); ?>" id="<?php bp_group_invite_item_id(); ?>"><?php _e( 'Remove Invite', 'onesocial' ); ?></a>

								<?php do_action( 'bp_group_send_invites_item_action' ); ?>
							</div>
						</li>

					<?php endwhile; ?>

				<?php endif; ?>
			</ul><!-- #friend-list -->

			<?php do_action( 'bp_after_group_send_invites_list' ); ?>

		</div><!-- .main-column -->

		<div class="clear"></div>

		<div class="submit">
			<input type="submit" name="submit" id="submit" value="<?php _e( 'Send Invites', 'onesocial' ); ?>" />
		</div>

		<?php wp_nonce_field( 'groups_send_invites', '_wpnonce_send_invites' ); ?>

		<?php /* This is important, don't forget it */ ?>
		<input type="hidden" name="group_id" id="group_id" value="<?php bp_group_id(); ?>" />

	</form><!-- #send-invite-form -->

<?php else : ?>

	<div id="message" class="info" role="main">
		<p><?php _e( 'Once you have built up friend connections you will be able to invite others to your group.', 'onesocial' ); ?></p>
	</div>

<?php endif; ?>

<?php do_action( 'bp_after_group_send_invites_content' ); ?>