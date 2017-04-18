<?php

/**
 * To view theme functions, navigate to /buddyboss-inc/theme.php
 *
 * @package OneSocial Theme
 */
$init_file = get_template_directory() . '/buddyboss-inc/init.php';

if ( !file_exists( $init_file ) ) {

	$err_msg = __( 'OneSocial cannot find the starter file, should be located at: *wp root*/wp-content/themes/buddyboss/buddyboss-inc/init.php', 'onesocial' );

	wp_die( $err_msg );
}

require_once( $init_file );
