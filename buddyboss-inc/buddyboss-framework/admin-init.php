<?php

/**
 * Register BuddyBoss Menu Page
 */
if ( !function_exists( 'register_buddyboss_menu_page' ) ) {

	function register_buddyboss_menu_page() {
		// Set position with odd number to avoid confict with other plugin/theme.
		add_menu_page( 'BuddyBoss', 'BuddyBoss', 'manage_options', 'buddyboss-settings', '', get_template_directory_uri() . '/buddyboss-inc/buddyboss-framework/assets/images/logo.svg', 61.000129 );
		// To remove empty parent menu item.
		add_submenu_page( 'buddyboss-settings', 'BuddyBoss', 'BuddyBoss', 'manage_options', 'buddyboss-settings' );
		remove_submenu_page( 'buddyboss-settings', 'buddyboss-settings' );
	}

	add_action( 'admin_menu', 'register_buddyboss_menu_page' );
}

/**
 * Load extensions - MUST be loaded before your options are set
 */
if ( file_exists( dirname( __FILE__ ) . '/boss-extensions/extensions-init.php' ) ) {
	require_once( dirname( __FILE__ ) . '/boss-extensions/extensions-init.php' );
}

/**
 * Load redux
 */
if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/admin/ReduxCore/framework.php' ) ) {
	require_once( dirname( __FILE__ ) . '/admin/ReduxCore/framework.php' );
}

/**
 * Load the theme/plugin options
 */
if ( !function_exists( 'load_boss_theme_options' ) ) {

	function load_boss_theme_options() {
		if ( file_exists( dirname( __FILE__ ) . '/options-init.php' ) ) {
			require_once( dirname( __FILE__ ) . '/options-init.php' );
		}
		if ( file_exists( dirname( __FILE__ ) . '/plugin-support.php' ) ) {
			require_once( dirname( __FILE__ ) . '/plugin-support.php' );
		}
		if ( file_exists( dirname( __FILE__ ) . '/help-support.php' ) ) {
			require_once( dirname( __FILE__ ) . '/help-support.php' );
		}
	}

	// This is used to show xProfile fields in option settings.
	if ( function_exists( 'bp_is_active' ) ) {
		add_action( 'bp_init', 'load_boss_theme_options' );
	} else {
		load_boss_theme_options();
	}
}

/**
 * Remove redux menu under the tools
 */
if ( !function_exists( 'boss_remove_redux_menu' ) ) {

	function boss_remove_redux_menu() {
		remove_submenu_page( 'tools.php', 'redux-about' );
	}

	add_action( 'admin_menu', 'boss_remove_redux_menu', 12 );
}

/**
 * Remove redux demo links
 */
if ( !function_exists( 'boss_remove_DemoModeLink' ) ) {

	function boss_remove_DemoModeLink() {
		// Be sure to rename this function to something more unique
		if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
			remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks' ), null, 2 );
		}

		if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
			remove_action( 'admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );
		}
	}

	add_action( 'init', 'boss_remove_DemoModeLink' );
}

/**
 * Remove redux dashboard widget
 */
if ( !function_exists( 'boss_remove_dashboard_widget' ) ) {

	function boss_remove_dashboard_widget() {
		remove_meta_box( 'redux_dashboard_widget', 'dashboard', 'side' );
	}

	// Hook into the 'wp_dashboard_setup' action to register our function
	add_action( 'wp_dashboard_setup', 'boss_remove_dashboard_widget', 999 );
}

/**
 * Custom panel styles
 */
if ( !function_exists( 'boss_custom_panel_styles_scripts' ) ) {

	function boss_custom_panel_styles_scripts() {

		$buddyboss_redux_js_vars = array(
			'boss_header'	 => onesocial_get_option( 'boss_header' ),
			'color_scheme'	 => onesocial_get_option( 'onsocial_scheme_select' )
		);

		wp_register_style( 'redux-custom-panel', get_template_directory_uri() . '/buddyboss-inc/buddyboss-framework/assets/css/redux-custom-panel.css', array( 'redux-admin-css' ), time(), 'all' );
		wp_enqueue_style( 'redux-custom-panel' );

		wp_register_script( 'redux-custom-script', get_template_directory_uri() . '/buddyboss-inc/buddyboss-framework/assets/js/boss-custom-admin.js' );
		wp_enqueue_script( 'redux-custom-script' );

		$buddyboss_redux_js_vars = apply_filters( 'buddyboss_redux_js_vars', $buddyboss_redux_js_vars );
		wp_localize_script( 'redux-custom-script', 'BuddyBossReduxOptions', $buddyboss_redux_js_vars );
	}

	// This example assumes your opt_name is set to redux_demo, replace with your opt_name value
	add_action( 'redux/page/onesocial_options/enqueue', 'boss_custom_panel_styles_scripts' );
}

/**
 * Hide Redux Notifications and Ads
 */
if ( !function_exists( 'boss_remove_redux_ads' ) ) {

	function boss_remove_redux_ads() {
		echo '<style type="text/css">
		#wpbody-content .redux-messageredux-notice,
		.redux-message.redux-notice,
		#redux-header .rAds,
		#onesocial_options-boss_favicon,
		#onesocial_options-admin_custom_colors {
			display: none !important;
			opacity: 0;
			visibility: hidden;
		}
		</style>';
	}

	add_action( 'admin_head', 'boss_remove_redux_ads' );
}

/**
 * Redux dev mode false
 */
if ( !function_exists( 'redux_disable_dev_mode_plugin' ) ) {

	function redux_disable_dev_mode_plugin( $redux ) {
		if ( $redux->args[ 'opt_name' ] != 'onesocial_options' ) {
			$redux->args[ 'dev_mode' ]				 = false;
			$redux->args[ 'forced_dev_mode_off' ]	 = false;
		}
	}

	add_action( 'redux/construct', 'redux_disable_dev_mode_plugin' );
}