<?php
$messages	 = buddyboss_adminbar_messages();
$link		 = $messages[ 0 ];
unset( $messages[ 0 ] );

if ( $link && onesocial_get_option( 'messages_button' ) ) {
	?>

	<div class="header-notifications">

		<a id="user-messages" class="header-button underlined" href="<?php echo $link->href; ?>">
			<?php
			if ( preg_match( "/[0-9]/", $link->title ) ) {
				echo preg_replace('/>([0-9]*)<\/span/', '><b>$1</b></span', $link->title);
			} else {
				echo '<span class="no-alert"><b>0</b></span>';
			}
			?>
		</a>

		<div class="pop">
			<?php if ( bp_has_message_threads( 'type=unread' ) ) { ?>

				<ul class="bb-user-notifications">
					<?php while ( bp_message_threads() ) : bp_message_thread(); ?>

						<li>

							<?php bp_message_thread_avatar( 'height=20&width=20' ); ?>

							<?php bp_message_thread_from() ?>

							<a class="bb-message-link" href="<?php esc_url( bp_message_thread_view_link() ); ?>">
								<?php _e( 'Sent you message', 'onesocial' ); ?>
							</a>

						</li>

					<?php endwhile; ?>
				</ul>

			<?php } else { ?>
				<div><?php _e( 'No unread messages', 'onesocial' ); ?></div>
			<?php } ?>
		</div>

	</div>

	<?php
}