<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


// We don't need this in the admin
if ( is_admin() ) {
	return;
}


// Tracking Code
if ( !function_exists( 'boss_tracking' ) ) {

	function boss_tracking() {
		$on			 = onesocial_get_option( 'tracking' );
		$tracking	 = onesocial_get_option( 'boss_tracking_code' );

		if ( $on && $tracking ) {
			echo $tracking;
		}
	}

	// Hook function to wp_footer
	add_action( 'wp_footer', 'boss_tracking', 99996 );
}

// Custom CSS
if ( !function_exists( 'boss_custom_css' ) ) {

	function boss_custom_css() {
		$on	 = onesocial_get_option( 'custom_css' );
		$css = onesocial_get_option( 'boss_custom_css' );

		if ( $on && $css ) {
			echo '<style>' . $css . '</style>';
		}
	}

	// Hook function to wp_head
	add_action( 'wp_head', 'boss_custom_css', 9993 );
}

// Custom JavaScript
if ( !function_exists( 'boss_custom_js' ) ) {

	function boss_custom_js() {
		$on	 = onesocial_get_option( 'custom_js' );
		$js	 = onesocial_get_option( 'boss_custom_js' );

		if ( $on && $js ) {
			echo '<script>' . stripcslashes( $js ) . '</script>';
		}
	}

	// Hook function to wp_footer
	add_action( 'wp_footer', 'boss_custom_js', 9993 );
}