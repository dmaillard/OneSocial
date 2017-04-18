<?php
$notifications	 = buddyboss_adminbar_notification();
$link			 = $notifications[ 0 ];
unset( $notifications[ 0 ] );

if ( $link && onesocial_get_option( 'notifications_button' ) && bp_is_active( 'notifications' ) ) {
	?>

	<div id="all-notificatios" class="header-notifications">

		<a class="notification-link header-button underlined" href="<?php echo $link->href; ?>">
			<?php echo preg_replace('/>([0-9]*)<\/span/', '><b>$1</b></span', $link->title); ?>
		</a>

		<div class="pop">

			<?php
			foreach ( $notifications as $notification ) {
				echo '<a href="' . $notification->href . '">' . $notification->title . '</a>';
			}
			?>
		</div>

	</div>

	<?php
}