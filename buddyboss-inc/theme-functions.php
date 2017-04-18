<?php
/**
 * @package OneSocial Theme
 */
/**
 * Sets up the content width value based on the theme's design and stylesheet.
 */
global $content_width;
$content_width = ( isset( $content_width ) ) ? $content_width : 1400;

/**
 * Sets up theme defaults and registers the various WordPress features that OneSocial supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since OneSocial 1.0.0
 */
function onesocial_setup() {
	// Makes OneSocial available for translation.
	load_theme_textdomain( 'onesocial', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	// Declare theme support for WooCommerce
	add_theme_support( 'woocommerce' );

	// Adds wp_nav_menu() in two locations with BuddyPress deactivated.
	register_nav_menus( array(
		'primary-menu'		 => __( 'Titlebar', 'onesocial' ),
		'secondary-menu'	 => __( 'Footer Menu', 'onesocial' ),
		'header-my-account'	 => __( 'My Profile', 'onesocial' ),
	) );

	// Adds wp_nav_menu() in two additional locations with BuddyPress activated.
	if ( function_exists( 'bp_is_active' ) ) {
		register_nav_menus( array(
			'profile-menu'	 => __( 'Profile: Extra Links', 'onesocial' ),
			'group-menu'	 => __( 'Group: Extra Links', 'onesocial' ),
		) );
	}

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
//	add_theme_support( 'post-formats', array(
//		'aside', 'image', 'video', 'quote', 'link',
//	) );
	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 845, 9999 ); // Unlimited height, soft crop
}

add_action( 'after_setup_theme', 'onesocial_setup' );

/**
 * Disable gallery style
 *
 * @since OneSocial 1.0.0
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Adds Profile menu to BuddyPress profiles
 *
 * @since OneSocial 1.0.0
 */
function buddyboss_add_profile_menu() {
	if ( function_exists( 'bp_is_active' ) ) {
		if ( has_nav_menu( 'profile-menu' ) ) {
			wp_nav_menu( array( 'container' => false, 'theme_location' => 'profile-menu', 'items_wrap' => '%3$s' ) );
		}
	}
}

add_action( 'bp_member_options_nav', 'buddyboss_add_profile_menu' );

/**
 * Adds Group menu to BuddyPress groups
 *
 * @since OneSocial 1.0.0
 */
function buddyboss_add_group_menu() {
	if ( function_exists( 'bp_is_active' ) ) {
		if ( has_nav_menu( 'group-menu' ) ) {
			wp_nav_menu( array( 'container' => false, 'theme_location' => 'group-menu', 'items_wrap' => '%3$s' ) );
		}
	}
}

add_action( 'bp_group_options_nav', 'buddyboss_add_group_menu' );

/**
 * Detecting phones
 *
 * @since OneSocial 1.0.0
 * from detectmobilebrowsers.com
 */
function is_phone() {
	$useragent = $_SERVER[ 'HTTP_USER_AGENT' ];
	if ( preg_match( '/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent ) || preg_match( '/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr( $useragent, 0, 4 ) ) )
		return true;
}

/**
 * Enqueues scripts and styles for front-end.
 *
 * @since OneSocial 1.0.0
 */
function buddyboss_onesocial_scripts_styles() {

	global $bp, $onesocial, $buddyboss_js_params;

	// Used in js file to detect if we are using only mobile layout
	$only_mobile = false;

	/**
	 * Assign the OneSocial version to a var
	 */
	$theme				 = wp_get_theme( 'onesocial' );
	$onesocial_version	 = $theme[ 'Version' ];


	/*	 * **************************** STYLES ***************************** */

	// FontAwesome icon fonts. If browsing on a secure connection, use HTTPS.
	// We will only load if our is latest.
	$recent_fwver	 = (isset( wp_styles()->registered[ "fontawesome" ] )) ? wp_styles()->registered[ "fontawesome" ]->ver : "0";
	$current_fwver	 = "4.7.0";
	if ( version_compare( $current_fwver, $recent_fwver, '>' ) ) {
		wp_deregister_style( 'fontawesome' );
		wp_register_style( 'fontawesome', "//maxcdn.bootstrapcdn.com/font-awesome/{$current_fwver}/css/font-awesome.min.css", false, $current_fwver );
		wp_enqueue_style( 'fontawesome' );
	}

	$css_dest = ( is_rtl() ) ? '/css-rtl' : '/css';
	$css_compressed_dest = ( is_rtl() ) ? '/css-rtl-compressed' : '/css-compressed';

	$CSS_URL = onesocial_get_option( 'boss_minified_css' ) ? get_template_directory_uri() . $css_compressed_dest : get_template_directory_uri() . $css_dest;

	// OneSocial icon fonts.
	wp_register_style( 'icons', $CSS_URL . '/onesocial-icons.css', array(), $onesocial_version, 'all' );
	wp_enqueue_style( 'icons' );

	// Activate our main stylesheets.
	wp_enqueue_style( 'onesocial-main-global', $CSS_URL . '/main-global.css', array( 'icons' ), $onesocial_version, 'all' );

	// is adminbar fixed or floated
	$adminbar_layout = 'fixed';

	// Switch between mobile and desktop
	if ( isset( $_COOKIE[ 'switch_mode' ] ) && (onesocial_get_option( 'boss_layout_switcher' )) ) {
		if ( $_COOKIE[ 'switch_mode' ] == 'mobile' ) {
			wp_enqueue_style( 'onesocial-main-mobile', $CSS_URL . '/main-mobile.css', array( 'icons' ), $onesocial_version, 'all' );
			$only_mobile = true;
		} else {
			wp_enqueue_style( 'onesocial-main-desktop', $CSS_URL . '/main-desktop.css', array( 'icons' ), $onesocial_version, 'screen and (min-width: 481px)' );
			// Activate our own Fixed or Floating (defaults to Fixed) adminbar stylesheet. Load DashIcons and GoogleFonts first.
			wp_enqueue_style( 'buddyboss-wp-adminbar-desktop-' . $adminbar_layout, $CSS_URL . '/adminbar-desktop-' . $adminbar_layout . '.css', array( 'dashicons' ), $onesocial_version, 'screen and (min-width: 481px)' );
			wp_enqueue_style( 'onesocial-main-mobile', $CSS_URL . '/main-mobile.css', array( 'icons' ), $onesocial_version, 'screen and (max-width: 480px)' );
		}
		// Defaults
	} else {
		if ( is_phone() ) {
			wp_enqueue_style( 'onesocial-main-mobile', $CSS_URL . '/main-mobile.css', array( 'icons' ), $onesocial_version, 'all' );
			$only_mobile = true;
		} elseif ( wp_is_mobile() ) {
			if ( onesocial_get_option( 'boss_layout_tablet' ) == 'desktop' ) {
				wp_enqueue_style( 'onesocial-main-desktop', $CSS_URL . '/main-desktop.css', array( 'icons' ), $onesocial_version, 'all' );
				// Activate our own Fixed or Floating (defaults to Fixed) adminbar stylesheet. Load DashIcons and GoogleFonts first.
				wp_enqueue_style( 'buddyboss-wp-adminbar-desktop-' . $adminbar_layout, $CSS_URL . '/adminbar-desktop-' . $adminbar_layout . '.css', array( 'dashicons' ), $onesocial_version, 'all' );
			} else {
				wp_enqueue_style( 'onesocial-main-mobile', $CSS_URL . '/main-mobile.css', array( 'icons' ), $onesocial_version, 'all' );
				$only_mobile = true;
			}
		} else {
			if ( onesocial_get_option( 'boss_layout_desktop' ) == 'mobile' ) {
				wp_enqueue_style( 'onesocial-main-mobile', $CSS_URL . '/main-mobile.css', array( 'icons' ), $onesocial_version, 'all' );
				$only_mobile = true;
			} else {
				wp_enqueue_style( 'onesocial-main-desktop', $CSS_URL . '/main-desktop.css', array( 'icons' ), $onesocial_version, 'screen and (min-width: 481px)' );
				// Activate our own Fixed or Floating (defaults to Fixed) adminbar stylesheet. Load DashIcons and GoogleFonts first.
				wp_enqueue_style( 'buddyboss-wp-adminbar-desktop-' . $adminbar_layout, $CSS_URL . '/adminbar-desktop-' . $adminbar_layout . '.css', array( 'dashicons' ), $onesocial_version, 'screen and (min-width: 481px)' );
			}
		}

		// Media query fallback
		if ( !wp_script_is( 'onesocial-main-mobile', 'enqueued' ) ) {
			wp_enqueue_style( 'onesocial-main-mobile', $CSS_URL . '/main-mobile.css', array( 'icons' ), $onesocial_version, 'screen and (max-width: 480px)' );
		}
	}

	/*
	 * Load our BuddyPress styles manually if plugin is active.
	 * We need to deregister the BuddyPress styles first then load our own.
	 * We need to do this for proper CSS load order.
	 */
	if ( $onesocial->buddypress_active ) {
		// Deregister the built-in BuddyPress stylesheet
		wp_deregister_style( 'bp-child-css' );
		wp_deregister_style( 'bp-parent-css' );
		wp_deregister_style( 'bp-legacy-css' );
		wp_deregister_style( 'bp-legacy-css-rtl' );
	}

	/*
	 * Load our bbPress styles manually if plugin is active.
	 * We need to deregister the bbPress style first then load our own.
	 * We need to do this for proper CSS load order.
	 */
	if ( $onesocial->bbpress_active ) {
		// Deregister the built-in bbPress stylesheet
		wp_deregister_style( 'bbp-child-bbpress' );
		wp_deregister_style( 'bbp-parent-bbpress' );
		wp_deregister_style( 'bbp-default' );
	}

// Load our own adminbar (Toolbar) styles.
	if ( !is_admin() ) {
		// Deregister the built-in adminbar stylesheet
		wp_deregister_style( 'admin-bar' );
	}

	/*	 * **************************** SCRIPTS ***************************** */

	$user_profile = null;

	if ( is_object( $bp ) && is_object( $bp->displayed_user ) && !empty( $bp->displayed_user->domain ) ) {
		$user_profile = $bp->displayed_user->domain;
	}

	/* UI scripts */
	wp_enqueue_script( 'jquery-ui-tooltip' );
	wp_enqueue_script( 'jquery-form' );

	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Heartbeat
	wp_enqueue_script( 'heartbeat' );

	/*
	 * Adds cover scripts
	 */
	/*wp_deregister_script( 'moxie' );
	wp_deregister_script( 'plupload' );
	wp_enqueue_script( 'moxie', get_template_directory_uri() . '/js/plupload/moxie.min.js', array( 'jquery' ), '1.2.1' );
	wp_enqueue_script( 'plupload', get_template_directory_uri() . '/js/plupload/plupload.dev.js', array( 'jquery', 'moxie' ), '2.1.2' );*/

	// Add BuddyBoss words that we need to use in JS to the end of the page
	// so they can be translataed and still used.
	$buddyboss_js_vars = array(
		'select_label'	 => __( 'Show:', 'onesocial' ),
		'post_in_label'	 => __( 'Post in:', 'onesocial' ),
		'tpl_url'		 => get_template_directory_uri(),
		'child_url'		 => get_stylesheet_directory_uri(),
		'user_profile'	 => $user_profile,
		'ajaxurl'		 => admin_url( 'admin-ajax.php' )
	);

	$buddyboss_js_vars = apply_filters( 'buddyboss_js_vars', $buddyboss_js_vars );

	$translation_array = array(
		'only_mobile'	 => $only_mobile,
		'view_desktop'	 => __( 'View as Desktop', 'onesocial' ),
		'view_mobile'	 => __( 'View as Mobile', 'onesocial' ),
		'yes'			 => __( 'Yes', 'onesocial' ),
		'no'			 => __( 'No', 'onesocial' )
	);

	$transport_array = array(
		'eh_url_path' => home_url()
	);

	if ( onesocial_get_option( 'boss_minified_js' ) ) {

		wp_register_script( 'onesocial-main-min', get_template_directory_uri() . '/js/compressed/onesocial-main-min.js', array( 'jquery', 'jquery-form' ), $onesocial_version, true );
		wp_localize_script( 'onesocial-main-min', 'translation', $translation_array );
		wp_localize_script( 'onesocial-main-min', 'transport', $transport_array );
		wp_localize_script( 'onesocial-main-min', 'ajaxposts', array(
			'ajaxurl'	 => admin_url( 'admin-ajax.php' ),
			'postsNonce' => wp_create_nonce( 'ajax-posts-nonce' )
		) );

		wp_localize_script( 'onesocial-main-min', 'ajaxfriends', array(
			'ajaxurl'		 => admin_url( 'admin-ajax.php' ),
			'friendsNonce'	 => wp_create_nonce( 'ajax-friends-nonce' )
		) );

		wp_localize_script( 'onesocial-main-min', 'ajaxmembers', array(
			'ajaxurl'		 => admin_url( 'admin-ajax.php' ),
			'membersNonce'	 => wp_create_nonce( 'ajax-members-nonce' )
		) );

		wp_localize_script( 'onesocial-main-min', 'ajaxfollow', array(
			'ajaxurl'		 => admin_url( 'admin-ajax.php' ),
			'followNonce'	 => wp_create_nonce( 'ajax-follow-nonce' )
		) );

		wp_localize_script( 'onesocial-main-min', 'BuddyBossOptions', $buddyboss_js_vars );
		wp_enqueue_script( 'onesocial-main-min' );
	} else {

		/* Modernizr */
		wp_enqueue_script( 'buddyboss-modernizr', get_template_directory_uri() . '/js/modernizr.min.js', false, '2.8.3', false );

		/* Adds mobile JavaScript functionality. */
		wp_enqueue_script( 'idangerous-swiper', get_template_directory_uri() . '/js/idangerous.swiper.js', array( 'jquery' ), '1.9.2', true );

		/* Adds fitVids script */
		wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/fitvids.js', array( 'jquery' ), '1.1.0' );

		/* Adds cookie script */
		wp_enqueue_script( 'cookie', get_template_directory_uri() . '/js/jquery.cookie.js', array(), '1.4.1' );

		/* Adds resize script */
		wp_enqueue_script( 'resize', get_template_directory_uri() . '/js/resize.js', array(), '1.1', true );

		/* Adds carousel script */
		wp_enqueue_script( 'swipe', get_template_directory_uri() . '/js/jquery.touchSwipe.min.js', array(), '1.4.1' );
		wp_enqueue_script( 'carouFredSel', get_template_directory_uri() . '/js/jquery.carouFredSel-6.2.1-packed.js', array(), '1.4.1' );

		/* Select boxes JS */
		wp_enqueue_script( 'selectboxes-script', get_template_directory_uri() . '/js/selectboxes.js', array( 'jquery' ), '1.0.2' );

		wp_enqueue_script( 'onesocail-growl', get_template_directory_uri() . '/js/jquery.growl.js', array(), '1.2.4', true );

		wp_enqueue_script( 'buddyboss-slider', get_template_directory_uri() . '/js/slider/slick.min.js', array( 'jquery' ), '1.1.2', true );

		/* Images Lazy Loading */
		wp_enqueue_script( 'onesocail-waypoints', get_template_directory_uri() . '/js/jquery.waypoints.js', array(), '1.2.4', true );
		wp_enqueue_script( 'css3-animate-it', get_template_directory_uri() . '/js/css3-animate-it.js', array(), '1.2.4', true );

		/* Popup */
		wp_enqueue_script( 'magnific-popup', get_template_directory_uri() . '/js/popup/jquery.magnific-popup.min.js', array(), '1.0', true );
		wp_enqueue_script( 'popup-action', get_template_directory_uri() . '/js/popup/action.js', array( 'magnific-popup', 'jquery-form' ), '1.0', true );
		wp_localize_script( 'popup-action', 'transport', $transport_array );

		/* Ajax Load Posts */
		wp_enqueue_script( 'onesocial-load-ajax-posts', get_template_directory_uri() . '/js/load-posts.js', array( 'jquery' ), $onesocial_version, true );

		/* Sticky JS */
		wp_enqueue_script( 'onesocial-sticky-js', get_template_directory_uri() . '/js/jquery.sticky.js', array( 'jquery' ), $onesocial_version, true );

		/* Mobile menu */
		wp_enqueue_script( 'onesocial-menu-js', get_template_directory_uri() . '/js/slideout.min.js', array( 'jquery' ), $onesocial_version, true );

		/* Ajax script for posts load */
		wp_enqueue_script( 'ajax-posts', get_template_directory_uri() . '/js/ajax-posts.js', array( 'jquery' ), $onesocial_version, true );
		wp_localize_script( 'ajax-posts', 'ajaxposts', array(
			'ajaxurl'	 => admin_url( 'admin-ajax.php' ),
			'postsNonce' => wp_create_nonce( 'ajax-posts-nonce' )
		) );

		// Ajax script for friends load
		wp_enqueue_script( 'ajax-friends', get_template_directory_uri() . '/js/ajax-friends.js', array( 'jquery' ), $onesocial_version, true );
		wp_localize_script( 'ajax-friends', 'ajaxfriends', array(
			'ajaxurl'		 => admin_url( 'admin-ajax.php' ),
			'friendsNonce'	 => wp_create_nonce( 'ajax-friends-nonce' )
		) );

		// Ajax script for group members load
		wp_enqueue_script( 'ajax-group-members', get_template_directory_uri() . '/js/ajax-group-members.js', array( 'jquery' ), $onesocial_version, true );
		wp_localize_script( 'ajax-group-members', 'ajaxmembers', array(
			'ajaxurl'		 => admin_url( 'admin-ajax.php' ),
			'membersNonce'	 => wp_create_nonce( 'ajax-members-nonce' )
		) );

		// Ajax script for folowing/followers load
		wp_enqueue_script( 'ajax-follow', get_template_directory_uri() . '/js/ajax-follow.js', array( 'jquery' ), $onesocial_version, true );
		wp_localize_script( 'ajax-follow', 'ajaxfollow', array(
			'ajaxurl'		 => admin_url( 'admin-ajax.php' ),
			'followNonce'	 => wp_create_nonce( 'ajax-follow-nonce' )
		) );

		wp_localize_script( 'site-mscript', 'transport', $transport_array );
		wp_enqueue_script( 'site-mscript' );

		/* Adds custom BuddyBoss JavaScript functionality. */
		wp_register_script( 'onesocial-main', get_template_directory_uri() . '/js/onesocial.js', array( 'jquery', 'selectboxes-script' ), $onesocial_version, true );
		wp_localize_script( 'onesocial-main', 'BuddyBossOptions', $buddyboss_js_vars );
		wp_localize_script( 'onesocial-main', 'translation', $translation_array );
		wp_enqueue_script( 'onesocial-main' );
	}

	/**
	 * If we're on the BuddyPress messages component we need to load jQuery Migrate first
	 * before bgiframe, so let's take care of that
	 */
	if ( function_exists( 'bp_is_messages_component' ) && bp_is_messages_component() && bp_is_current_action( 'compose' ) ) {
		$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_dequeue_script( 'bp-jquery-bgiframe' );
		wp_enqueue_script( 'bp-jquery-bgiframe', BP_PLUGIN_URL . "bp-messages/js/autocomplete/jquery.bgiframe{$min}.js", array(), bp_get_version() );
	}
}

add_action( 'wp_enqueue_scripts', 'buddyboss_onesocial_scripts_styles' );

/**
 * Admin styles
 */
function onesocial_admin_assets() {

	/**
	 * Assign the OneSocial version to a var
	 */
	$theme				 = wp_get_theme( 'onesocial' );
	$onesocial_version	 = $theme[ 'Version' ];

	wp_enqueue_style( 'buddyboss-bm-main-admin-css', get_template_directory_uri() . '/css/admin.css', array(), $onesocial_version, 'all' );
}

add_action( 'admin_enqueue_scripts', 'onesocial_admin_assets' );

function escapeJavaScriptText( $string ) {
	$string	 = str_replace( array( "\n", '"' ), array( '', '\"' ), $string );
	$string	 = preg_replace( '/\s+/', ' ', trim( $string ) );
	return $string;
}

/**
 * We need to enqueue jQuery migrate before anything else for legacy
 * plugin support.
 * WordPress version 3.9 onwards already includes jquery 1.11.n version, which we required,
 * and jquery migrate is also properly enqueued.
 * So we dont need to do anything for WP versions greater than 3.9.
 *
 * @package  BuddyPress
 * @since    BuddyPress 3.0
 */
function buddyboss_scripts_jquery_migrate() {
	global $wp_version;

	if ( $wp_version >= 3.9 ) {
		return;
	}

// Deregister the built-in version of jQuery
	wp_deregister_script( 'jquery' );

// Register jQuery. If browsing on a secure connection, use HTTPS.
	wp_register_script( 'jquery', "//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js", false, null );
// Activate the jQuery script
	wp_enqueue_script( 'jquery' );

// Activate the jQuery Migrate script from WordPress
	wp_enqueue_script( 'jquery-migrate', false, array( 'jquery' ) );
}

add_action( 'wp_enqueue_scripts', 'buddyboss_scripts_jquery_migrate', 0 );

/**
 * Removes CSS in the header so we can control the admin bar and be responsive
 *
 * @package  BuddyPress
 * @since    BuddyPress 3.1
 */
function buddyboss_remove_adminbar_inline_styles() {
	if ( !is_admin() ) {

		remove_action( 'wp_head', 'wp_admin_bar_header' );
		remove_action( 'wp_head', '_admin_bar_bump_cb' );
	}
}

add_action( 'wp_head', 'buddyboss_remove_adminbar_inline_styles', 9 );

/**
 * Dynamically removes the no-js class from the <body> element.
 *
 * By default, the no-js class is added to the body (see bp_dtheme_add_no_js_body_class()). The
 * JavaScript in this function is loaded into the <body> element immediately after the <body> tag
 * (note that it's hooked to bp_before_header), and uses JavaScript to switch the 'no-js' body class
 * to 'js'. If your theme has styles that should only apply for JavaScript-enabled users, apply them
 * to body.js.
 *
 * This technique is borrowed from WordPress, wp-admin/admin-header.php.
 *
 * @package BuddyPress
 * @since BuddyPress (1.5).1
 * @see bp_dtheme_add_nojs_body_class()
 */
function buddyboss_remove_nojs_body_class() {
	?><script type="text/JavaScript">//<![CDATA[
		(function(){var c=document.body.className;c=c.replace(/no-js/,'js');document.body.className=c;})();
		$=jQuery.noConflict();
		//]]></script>
	<?php
}

add_action( 'buddyboss_before_header', 'buddyboss_remove_nojs_body_class' );

/**
 * Determines if the currently logged in user is an admin
 * TODO: This should check in a better way, by capability not role title and
 * this function probably belongs in a functions.php file or utility.php
 */
function buddyboss_is_admin() {
	return is_user_logged_in() && current_user_can( 'administrator' );
}

function buddyboss_members_latest_update_filter( $latest ) {
	$latest = str_replace( array( '- &quot;', '&quot;' ), '', $latest );

	return $latest;
}

add_filter( 'bp_get_activity_latest_update_excerpt', 'buddyboss_members_latest_update_filter' );

/**
 * Moves sitewide notices to the header
 *
 * Since BuddyPress doesn't give us access to BP_Legacy, let
 * us begin the hacking
 *
 * @since OneSocial Theme 1.0.0
 */
function buddyboss_fix_sitewide_notices() {
// Check if BP_Legacy is being used and messages are active
	if ( class_exists( 'BP_Legacy' ) && bp_is_active( 'messages' ) ) {
		remove_action( 'wp_footer', array( 'BP_Legacy', 'sitewide_notices' ), 9999 );

		global $wp_filter;

		// Get the wp_footer callbacks
		$footer = !empty( $wp_filter[ 'wp_footer' ] ) && is_array( $wp_filter[ 'wp_footer' ] ) ? $wp_filter[ 'wp_footer' ] : false;

		// Make sure we have some
		if ( is_array( $footer ) && count( $footer ) > 0 ) {
			$new_footer_cbs = array();

			// Cycle through each callback and remove any with sitewide_notices in it,
			// then replace and add to the header
			foreach ( $footer as $priority => $footer_cb ) {
				if ( is_array( $footer_cb ) && !empty( $footer_cb ) ) {
					$keys	 = array_keys( $footer_cb );
					$key	 = $keys[ 0 ];

					if ( stristr( $key, 'sitewide_notices' ) ) {
						add_action( 'buddyboss_inside_wrapper', 'buddyboss_print_sitewide_notices', 9999 );
					} else {
						$new_footer_cbs[ $priority ] = $footer_cb;
					}
				} else {
					$new_footer_cbs[ $priority ] = $footer_cb;
				}
			}

			$wp_filter[ 'wp_footer' ] = $new_footer_cbs;
		}
	}
}

add_action( 'wp', 'buddyboss_fix_sitewide_notices' );

/**
 * Prints sitewide notices (used in the header, by default is in footer)
 */
function buddyboss_print_sitewide_notices() {
	@BP_Legacy::sitewide_notices();
}

/**
 * Load admin bar in header (fixes JetPack chart issue)
 */
function buddyboss_admin_bar_in_header() {
	if ( !is_admin() ) {
		remove_action( 'wp_footer', 'wp_admin_bar_render', 1000 );
		add_action( 'buddyboss_before_header', 'wp_admin_bar_render' );
	}
}

add_action( 'wp', 'buddyboss_admin_bar_in_header' );

/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since OneSocial 1.0.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function buddyboss_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

// Add the site name.
	$title .= get_bloginfo( 'name' );

// Add the site description for the home/front page.
	$site_description	 = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title				 = "$title $sep $site_description";

// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'onesocial' ), max( $paged, $page ) );

	return $title;
}

//add_filter( 'wp_title', 'buddyboss_wp_title', 10, 2 );

/**
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 *
 * @since OneSocial 1.0.0
 */
function buddyboss_page_menu_args( $args ) {
	$args[ 'show_home' ] = true;
	return $args;
}

add_filter( 'wp_page_menu_args', 'buddyboss_page_menu_args' );

/**
 * Registers all of our widget areas.
 *
 * @since OneSocial Theme 1.0.0
 */
function buddyboss_widgets_init() {
// Area 1, located in the pages and posts right column.
	register_sidebar( array(
		'name'			 => 'Page Sidebar',
		'id'			 => 'sidebar',
		'description'	 => 'The default Page/Post widget area.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h3 class="widgettitle">',
		'after_title'	 => '</h3>'
	) );

	// Area 2, located in the homepage right column.
	register_sidebar( array(
		'name'			 => 'Homepage',
		'id'			 => 'home-sidebar',
		'description'	 => 'The Homepage widget area. Only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h3 class="widgettitle">',
		'after_title'	 => '</h3>'
	) );

// Area 6, located in the Individual Member Profile right column. Right column only appears if widgets are added.
	register_sidebar( array(
		'name'			 => 'Member &rarr; Single Profile',
		'id'			 => 'profile',
		'description'	 => 'The Individual Profile widget area. Only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h3 class="widgettitle">',
		'after_title'	 => '</h3>'
	) );
// Area 8, located in the Individual Group right column. Right column only appears if widgets are added.
	register_sidebar( array(
		'name'			 => 'Group &rarr; Single Group',
		'id'			 => 'group',
		'description'	 => 'The Individual Group widget area. Only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h3 class="widgettitle">',
		'after_title'	 => '</h3>'
	) );
// Area 9, located in the Activity Directory right column. Right column only appears if widgets are added.
	register_sidebar( array(
		'name'			 => 'Activity &rarr; Directory',
		'id'			 => 'activity',
		'description'	 => 'The Activity Directory widget area. Only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h3 class="widgettitle">',
		'after_title'	 => '</h3>'
	) );
// Area 10, located in the Forums Directory right column. Right column only appears if widgets are added.
	register_sidebar( array(
		'name'			 => 'Forums &rarr; Directory & Single',
		'id'			 => 'forums',
		'description'	 => 'The Forums Directory widget area. Only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h3 class="widgettitle">',
		'after_title'	 => '</h3>'
	) );
// Area 11, located in the Members Directory right column. Right column only appears if widgets are added.
	register_sidebar( array(
		'name'			 => 'Blogs &rarr; Directory (multisite)',
		'id'			 => 'blogs',
		'description'	 => 'The Blogs Directory widget area (only for Multisite). Only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h3 class="widgettitle">',
		'after_title'	 => '</h3>'
	) );
	// Area 16, Only appears on serach results page.
	register_sidebar( array(
		'name'			 => 'Search Results',
		'id'			 => 'search',
		'description'	 => 'The search widget area. Only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h4 class="widgettitle">',
		'after_title'	 => '</h4>'
	) );
	global $woocommerce;
	if ( $woocommerce ) {
		// Area 17, dedicated sidebar for WooCommerce
		register_sidebar( array(
			'name'			 => 'WooCommerce',
			'id'			 => 'woo_sidebar',
			'description'	 => 'The widget area on WooCommerce shop index and Category pages.',
			'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'	 => '</aside>',
			'before_title'	 => '<h4 class="widgettitle">',
			'after_title'	 => '</h4>',
		) );
	}

// Area 12, located in the Footer column 1. Only appears if widgets are added.
	register_sidebar( array(
		'name'			 => 'Footer #1',
		'id'			 => 'footer-1',
		'description'	 => 'The first footer widget area. Only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h4 class="widgettitle">',
		'after_title'	 => '</h4>'
	) );
// Area 13, located in the Footer column 2. Only appears if widgets are added.
	register_sidebar( array(
		'name'			 => 'Footer #2',
		'id'			 => 'footer-2',
		'description'	 => 'The second footer widget area. Only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h4 class="widgettitle">',
		'after_title'	 => '</h4>'
	) );
// Area 14, located in the Footer column 3. Only appears if widgets are added.
	register_sidebar( array(
		'name'			 => 'Footer #3',
		'id'			 => 'footer-3',
		'description'	 => 'The third footer widget area. Only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h4 class="widgettitle">',
		'after_title'	 => '</h4>'
	) );
// Area 15, located in the Footer column 4. Only appears if widgets are added.
	register_sidebar( array(
		'name'			 => 'Footer #4',
		'id'			 => 'footer-4',
		'description'	 => 'The fourth footer widget area. Only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h4 class="widgettitle">',
		'after_title'	 => '</h4>'
	) );
}

add_action( 'widgets_init', 'buddyboss_widgets_init' );

if ( !function_exists( 'buddyboss_content_nav' ) ) {

	/**
	 * Displays navigation to next/previous pages when applicable.
	 *
	 * @since OneSocial 1.0.0
	 */
	function buddyboss_content_nav( $nav_id ) {
		global $wp_query;

		if ( $wp_query->max_num_pages > 1 ) :
			?>
			<nav id="<?php echo esc_attr( $nav_id ); ?>" class="navigation" role="navigation">
				<h3 class="assistive-text"><?php _e( 'Post navigation', 'onesocial' ); ?></h3>
				<div class="nav-previous alignleft"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'onesocial' ) ); ?></div>
				<div class="nav-next alignright"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'onesocial' ) ); ?></div>
			</nav><!-- #<?php echo esc_attr( $nav_id ); ?> .navigation -->
			<?php
		endif;
	}

}

if ( !function_exists( 'buddyboss_entry_meta' ) ) {

	/**
	 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
	 *
	 * Create your own buddyboss_entry_meta() to override in a child theme.
	 *
	 * @since OneSocial 1.0.0
	 */
	function buddyboss_entry_meta() {
		// Translators: used between list items, there is a space after the comma.
		$categories_list = get_the_category_list( __( ', ', 'onesocial' ) );

		// Translators: used between list items, there is a space after the comma.
		$tag_list = get_the_tag_list( '', __( ', ', 'onesocial' ) );

		$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark" class="meta-item"><time class="entry-date" datetime="%3$s">%4$s</time></a>', esc_url( get_permalink() ), esc_attr( get_the_time() ), esc_attr( get_the_date( 'c' ) ), esc_html( get_the_date() ) );
		$author = sprintf( '<span class="author vcard meta-item"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s%4$s</a></span>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_attr( sprintf( __( 'View all posts by %s', 'onesocial' ), get_the_author() ) ), get_avatar( get_the_author_meta( 'ID' ), 30, '', get_the_author() ), get_the_author() );

		echo $author;
		echo $date;
		echo '<span class="meta-item">' . $categories_list . '</span>';

		$post_format		 = get_post_format( get_the_ID() );
		$post_format_link	 = get_post_format_link( $post_format );

		if ( $post_format_link ) {
			printf( '<span class="post-format">Post Format: <a href="%s">%s</a></span>', $post_format_link, $post_format );
		}
	}

}

if ( !function_exists( 'buddyboss_post_thumbnail' ) ) :

	/**
	 * Display an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 *
	 * @since 1.0.0
	 */
	function buddyboss_post_thumbnail() {
		if ( post_password_required() || is_attachment() || !has_post_thumbnail() ) {
			return;
		}

		if ( is_single() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail( 'post-thumbnail' ); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
				<?php
				the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title() ) );
				?>
			</a>

		<?php
		endif; // End is_singular()
	}

endif;


if ( !function_exists( 'buddyboss_post_content' ) ) :

	/**
	 * Prints post content.
	 */
	function buddyboss_post_content() {
		if ( is_single() ) {
			the_content();
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'onesocial' ),
				'after'	 => '</div>',
			) );
		} else {
			the_excerpt();
		}
	}

endif;

/**
 * Check if we are on some of WC pages
 * */
function onesocial_is_woocommerce() {

	if ( function_exists( 'is_woocommerce' ) ) {
		return (is_woocommerce() || is_shop() || is_product_tag() || is_product_category() || is_product()
		//  || is_cart()
		//  || is_checkout()
		//  || is_account_page()
		);
	}
}

/**
 * Extends the default WordPress body classes.
 *
 * @since OneSocial 1.0.0
 *
 * @param array Existing class values.
 * @return array Filtered class values.
 */
function buddyboss_body_class( $classes ) {
	global $bp, $wp_customize;

	if ( !empty( $wp_customize ) ) {
		$classes[] = 'wp-customizer';
	}

	if ( !is_multi_author() ) {
		$classes[] = 'single-author';
	}

	if ( current_user_can( 'manage_options' ) ) {
		$classes[] = 'role-admin';
	}

	if ( buddyboss_is_bp_active() && ( bp_is_user_activity() || ( bp_is_group_home() && bp_is_active( 'activity' ) ) || bp_is_group_activity() || bp_is_current_component( 'activity' ) ) ) {
		$classes[] = 'has-activity';
	}

	// Default layout class
	if ( is_phone() ) {
		$classes[] = 'is-mobile';
	} elseif ( wp_is_mobile() ) {
		if ( onesocial_get_option( 'boss_layout_tablet' ) == 'desktop' ) {
			$classes[] = 'is-desktop';
		} else {
			$classes[] = 'is-mobile';
		}
		$classes[] = 'tablet';
	} else {
		if ( onesocial_get_option( 'boss_layout_desktop' ) == 'mobile' ) {
			$classes[] = 'is-mobile';
		} else {
			$classes[] = 'is-desktop';
		}
	}

	// Switch layout class
	if ( isset( $_COOKIE[ 'switch_mode' ] ) && (onesocial_get_option( 'boss_layout_switcher' )) ) {
		if ( $_COOKIE[ 'switch_mode' ] == 'mobile' ) {
			if ( ($key = array_search( 'is-desktop', $classes )) !== false ) {
				unset( $classes[ $key ] );
			}
			$classes[] = 'is-mobile';
		} else {
			if ( ($key = array_search( 'is-mobile', $classes )) !== false ) {
				unset( $classes[ $key ] );
			}
			$classes[] = 'is-desktop';
		}
	}

	// WooCommerce sidebar
	if ( is_active_sidebar( 'woo_sidebar' ) && onesocial_is_woocommerce() ) {
		$woocommerce_sidebar_alignment	 = onesocial_get_option( 'woocommerce_sidebar' );
		$classes[]						 = 'woo-sidebar-active bb-has-sidebar sidebar-' . $woocommerce_sidebar_alignment;
	}

	// Search sidebar
	if ( is_active_sidebar( 'search' ) && is_search() ) {
		$search_sidebar_alignment	 = onesocial_get_option( 'search_sidebar' );
		$classes[]					 = 'search-sidebar-active bb-has-sidebar sidebar-' . $search_sidebar_alignment;
	}

	$page_sidebar		 = onesocial_get_option( 'page_sidebar' );
	$sidebar_alignment	 = ($page_sidebar) ? $page_sidebar : 'right';

	// Home sidebar
	if ( is_active_sidebar( 'sidebar' ) && is_home() && !is_front_page() ) {
		$classes[] = 'page-sidebar-active home-page bb-has-sidebar sidebar-' . $sidebar_alignment;
	}

	$page_for_posts	 = get_option( 'page_for_posts' );
	$front_page		 = get_option( 'page_on_front' );

	// Home sidebar
	if ( is_active_sidebar( 'home-sidebar' ) && is_front_page() ) {
		$home_sidebar_alignment	 = onesocial_get_option( 'home_sidebar' );
		$classes[]				 = 'homepage-sidebar-active frontpage-page bb-has-sidebar sidebar-' . $home_sidebar_alignment;
	}

	// Blog sidebar
	if ( is_active_sidebar( 'sidebar' ) && !is_front_page() && is_home() && isset( $page_for_posts ) && $page_for_posts != 0 ) {
		$classes[] = 'page-sidebar-active home-page bb-has-sidebar sidebar-' . $sidebar_alignment;
	}

	// Page sidebar
	if ( is_active_sidebar( 'sidebar' ) && is_page() && !is_front_page() && !buddyboss_is_bp_active() ) {
		$classes[] = 'page-sidebar-active bb-has-sidebar sidebar-' . $sidebar_alignment;
	}

	// Page sidebar
	if ( is_active_sidebar( 'sidebar' ) && is_page() && !is_front_page() && buddyboss_is_bp_active() && !bp_current_component() && !bp_is_user() ) {
		$classes[] = 'page-sidebar-active bb-has-sidebar sidebar-' . $sidebar_alignment;
	}

	// Archive sidebar
	if ( is_active_sidebar( 'sidebar' ) && is_archive() && !( function_exists( 'bbp_is_forum_archive' ) && bbp_is_forum_archive() ) && !( function_exists( 'is_shop' ) && is_shop())
	) {
		$classes[] = 'archive-sidebar-active bb-has-sidebar sidebar-' . $sidebar_alignment;
	}

	// Blogs sidebar
	$blogs_sidebar = onesocial_get_option( 'blogs_sidebar' ) ? onesocial_get_option( 'blogs_sidebar' ) : 'left';
	if ( buddyboss_is_bp_active() && is_active_sidebar( 'blogs' ) && is_multisite() && bp_is_current_component( 'blogs' ) && !bp_is_user() ) {
		$classes[] = 'blogs-sidebar-active bb-has-sidebar sidebar-' . $blogs_sidebar;
	}

	// Activity sidebar
	$activity_sidebar = onesocial_get_option( 'activity_sidebar' ) ? onesocial_get_option( 'activity_sidebar' ) : 'left';
	if ( buddyboss_is_bp_active() && is_active_sidebar( 'activity' ) && bp_is_current_component( 'activity' ) && !bp_is_user() ) {
		$classes[] = 'activity-sidebar-active bb-has-sidebar sidebar-' . $activity_sidebar;
	}

	// Members sidebar
	$profile_sidebar = onesocial_get_option( 'profile_sidebar' ) ? onesocial_get_option( 'profile_sidebar' ) : 'left';
	if ( buddyboss_is_bp_active() && bp_is_user() && ( 'messages' != $bp->current_component ) && ( 'settings' != $bp->current_component ) ) {
		$sidebar_alignment	 = onesocial_get_option( 'profile_sidebar' );
		$classes[]			 = 'profile-sidebar-active bb-has-sidebar sidebar-' . $profile_sidebar;
	}

	// Single group sidebar
	$single_group_sidebar = onesocial_get_option( 'single_group_sidebar' ) ? onesocial_get_option( 'single_group_sidebar' ) : 'left';
	if ( buddyboss_is_bp_active() && bp_is_group() ) {
		$classes[] = 'group-sidebar-active bb-has-sidebar sidebar-' . $single_group_sidebar;
	}

	// Forums sidebar
	$forums = onesocial_get_option( 'forums_sidebar' ) ? onesocial_get_option( 'forums_sidebar' ) : 'left';
	if ( is_active_sidebar( 'forums' ) && function_exists( 'is_bbpress' ) && is_bbpress() && !( function_exists( 'bp_is_user' ) && bp_is_user() ) ) {
		$classes[] = 'forums-sidebar-active bb-has-sidebar sidebar-' . $forums;
	}

	//Post create template
	if ( function_exists( 'buddyboss_sap' ) && buddyboss_is_bp_active() ) {
		$create_new_post_page = buddyboss_sap()->option( 'create-new-post' );
		if ( !empty( $create_new_post_page ) && $create_new_post_page == get_the_ID() ) {
			$classes[] = 'page-template-sap-post-create-template';
		}
	}

	//Adminbar
	if ( !onesocial_get_option( 'boss_adminbar' ) ) {
		$classes[] = 'no-adminbar';
	}

	//Sticky Header
	if ( onesocial_get_option( 'sticky_header' ) ) {
		$classes[] = 'sticky-header';
	}

	//Sticky Header
	if ( is_home() && onesocial_get_option( 'boss_homepage_sidebar_switch' ) ) {
		$classes[] = 'bb-sidebar-on';
	}

	// header class
	$header_style	 = onesocial_get_option( 'boss_header' );
	$classes[]		 = $header_style;

	return array_unique( $classes );
}

add_filter( 'body_class', 'buddyboss_body_class' );


/* * **************************** LOGIN FUNCTIONS ***************************** */

function buddyboss_is_login_page() {
	return in_array( $GLOBALS[ 'pagenow' ], array( 'wp-login.php', 'wp-register.php' ) );
}

add_filter( 'login_redirect', 'buddyboss_redirect_previous_page', 10, 3 );

function buddyboss_redirect_previous_page( $redirect_to, $request, $user ) {
	if ( buddyboss_is_bp_active() ) {
		$bp_pages = bp_get_option( 'bp-pages' );

		$activate_page_id = !empty( $bp_pages ) && isset( $bp_pages[ 'activate' ] ) ? $bp_pages[ 'activate' ] : null;

		if ( (int) $activate_page_id <= 0 ) {
			return $redirect_to;
		}

		$activate_page = get_post( $activate_page_id );

		if ( empty( $activate_page ) || empty( $activate_page->post_name ) ) {
			return $redirect_to;
		}

		$activate_page_slug = $activate_page->post_name;

		if ( strpos( $request, '/' . $activate_page_slug ) !== false ) {
			$redirect_to = home_url();
		}
	}

	$request = isset( $_SERVER[ "HTTP_REFERER" ] ) && !empty( $_SERVER[ "HTTP_REFERER" ] ) ? $_SERVER[ "HTTP_REFERER" ] : false;

	if ( !$request ) {
		return $redirect_to;
	}

	$req_parts	 = explode( '/', $request );
	$req_part	 = array_pop( $req_parts );

	if ( substr( $req_part, 0, 3 ) == 'wp-' ) {
		return $redirect_to;
	}

	$request = str_replace( array( '?loggedout=true', '&loggedout=true' ), '', $request );

	return $request;
}

/**
 * Custom Login Link
 *
 * @since OneSocial 1.0.0.8
 */
function change_wp_login_url() {
	return home_url();
}

function change_wp_login_title() {
	get_option( 'blogname' );
}

add_filter( 'login_headerurl', 'change_wp_login_url' );
add_filter( 'login_headertitle', 'change_wp_login_title' );


/* * **************************** ADMIN BAR FUNCTIONS ***************************** */

/**
 * Remove certain admin bar links
 *
 * @since OneSocial 1.0.0
 */
function remove_admin_bar_links() {
	if ( is_admin() ) { //nothing to do on admin
		return;
	}
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu( 'wp-logo' );

	if ( !current_user_can( 'administrator' ) ):
		$wp_admin_bar->remove_menu( 'site-name' );
	endif;
}

add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );

/**
 * Replace admin bar "Howdy" text
 *
 * @since OneSocial 1.0.0
 */
function replace_howdy( $wp_admin_bar ) {

	if ( is_user_logged_in() ) {

		$my_account	 = $wp_admin_bar->get_node( 'my-account' );
		$newtitle	 = str_replace( 'Howdy,', '', $my_account->title );
		$wp_admin_bar->add_node( array(
			'id'	 => 'my-account',
			'title'	 => $newtitle,
		) );
	}
}

add_filter( 'admin_bar_menu', 'replace_howdy', 25 );


/* * **************************** AVATAR FUNCTIONS ***************************** */

/**
 * Replace default member avatar
 *
 * @since OneSocial 1.0.0
 */
if ( !function_exists( 'buddyboss_add_gravatar' ) ) {

	function buddyboss_add_gravatar( $avatar_defaults ) {
		$myavatar = get_template_directory_uri() . '/images/avatar-member.png';
		//$myavatar = '//upload.wikimedia.org/wikipedia/en/b/b0/Avatar-Teaser-Poster.jpg';

		$avatar_defaults[ $myavatar ] = 'BuddyBoss Man';

		return $avatar_defaults;
	}

	add_filter( 'avatar_defaults', 'buddyboss_add_gravatar' );
}

/**
 * Replace default group avatar
 *
 * @since OneSocial 1.0.0
 */
function buddyboss_default_group_avatar( $avatar ) {
	global $bp, $groups_template;
	if ( strpos( $avatar, 'group-avatars' ) ) {
		return $avatar;
	} else {
		$custom_avatar	 = get_template_directory_uri() . '/images/avatar-group.png';
		$alt			 = 'group avatar';

		if ( $groups_template ) {
			$alt = esc_attr( $groups_template->group->name );
		}

		if ( $bp->current_action == "" ) {
			return '<img width="215" height="215" src="' . $custom_avatar . '" class="avatar" alt="' . $alt . '" />';
		} else {
			return '<img width="' . BP_AVATAR_FULL_WIDTH . '" height="' . BP_AVATAR_FULL_HEIGHT . '" src="' . $custom_avatar . '" class="avatar" alt="' . $alt . '" />';
		}
	}
}

add_filter( 'bp_get_group_avatar', 'buddyboss_default_group_avatar' );
add_filter( 'bp_get_new_group_avatar', 'buddyboss_default_group_avatar' );


/* * **************************** WORDPRESS FUNCTIONS ***************************** */

/**
 * BuddyBoss Previous Logo Support
 *
 * @since OneSocial 1.0.0
 */
function buddyboss_set_previous_logo() {

// If there was a logo uploaded prior to upgrading to BuddyBoss 3.1,
// set it as the new logo to be used in the Theme Customizer

	$previous_logo	 = '';
	$previous_logo	 = get_option( "buddyboss_custom_logo" );

	if ( $previous_logo != '' ) {
		set_theme_mod( 'buddyboss_logo', $previous_logo );
	}

// Remove the previous logo option afterwards

	delete_option( "buddyboss_custom_logo" );
}

add_action( 'after_setup_theme', 'buddyboss_set_previous_logo' );

/**
 * Custom Pagination
 * Credits: http://www.kriesi.at/archives/how-to-build-a-wordpress-post-pagination-without-plugin
 *
 * @since OneSocial Theme 1.0.0
 */
function buddyboss_pagination() {
	global $paged, $wp_query;

	$max_page = 0;

	if ( !$max_page ) {
		$max_page = $wp_query->max_num_pages;
	}

	if ( !$paged ) {
		$paged = 1;
	}

	$nextpage = intval( $paged ) + 1;

	if ( is_front_page() || is_home() ) {
		$template = 'home';
	} elseif ( is_category() ) {
		$template = 'category';
	} elseif ( is_search() ) {
		$template = 'search';
	} else {
		$template = 'archive';
	}

	$class	 = ( onesocial_get_option( 'post_infinite' ) ) ? ' post-infinite-scroll' : '';
	$label	 = __( 'Load More', 'onesocial' );

	if ( !is_single() && ( $nextpage <= $max_page ) ) {
		/**
		 * Filter the anchor tag attributes for the next posts page link.
		 *
		 * @since 2.7.0
		 *
		 * @param string $attributes Attributes for the anchor tag.
		 */
		$attr = 'data-page=' . $nextpage . ' data-template=' . $template;

		echo '<a class="button-load-more-posts' . $class . '" href="' . next_posts( $max_page, false ) . "\" $attr>" . preg_replace( '/&([^#])(?![a-z]{1,8};)/i', '&#038;$1', $label ) . '</a>';
	}
}

/**
 * Checks if a plugin is active.
 *
 * @since OneSocial 1.0.0
 */
function buddyboss_is_plugin_active( $plugin ) {
	return in_array( $plugin, (array) get_option( 'active_plugins', array() ) );
}

/**
 * Return the ID of a page set as the home page.
 *
 * @return false|int ID of page set as the home page
 * @since OneSocial Theme 1.0.0
 */
if ( !function_exists( 'bp_dtheme_page_on_front' ) ) :

	function bp_dtheme_page_on_front() {
		if ( 'page' != get_option( 'show_on_front' ) )
			return false;

		return apply_filters( 'bp_dtheme_page_on_front', get_option( 'page_on_front' ) );
	}

endif;

/**
 * Add a View Profile link in Dashboard > Users panel
 *
 * @since OneSocial 1.0.0
 */
function user_row_actions_bp_view( $actions, $user_object ) {
	if ( function_exists( 'bp_is_active' ) ) {

		$actions[ 'view' ] = '<a href="' . bp_core_get_user_domain( $user_object->ID ) . '">' . __( 'View Profile', 'onesocial' ) . '</a>';
		return $actions;
	}
}

add_filter( 'user_row_actions', 'user_row_actions_bp_view', 10, 2 );

/**
 * Function that checks if BuddyPress plugin is active
 *
 * @since OneSocial Theme 1.0.0
 */
function buddyboss_is_bp_active() {
	if ( function_exists( 'bp_is_active' ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Add image size for posts
 *
 * @since OneSocial Theme 1.0.0
 */
add_image_size( 'post-thumb', 845, 312, true );
add_image_size( 'medium-thumb', 360, 216, true );
add_image_size( 'large-thumb', 9999, 800, true );

/**
 * Show more posts on profile
 *
 * @since OneSocial Theme 1.0.0
 */
function buddyboss_more_posts_profile( $posts, $sort, $count, $data_target ) {
	?>
	<div class="wrap">
		<h3 class="title black"><?php _e( 'Articles', 'onesocial' ); ?><span><?php echo $count; ?></span></h3>
		<div class="inner">
			<?php
			while ( $posts->have_posts() ) {
				$posts->the_post();
				get_template_part( 'template-parts/content', get_post_format() );
			}
			?>
		</div>
	</div>
	<?php
}

/**
 * Show more posts on blog page
 *
 * @since OneSocial Theme 1.0.0
 */
function buddyboss_more_posts_blog( $posts, $sort, $count, $data_target ) {
	?>
	<div class="inner">
		<h2 class="title"><?php echo ($sort === 'recommended') ? __( 'Most recommended stories', 'onesocial' ) : __( 'Latest stories', 'onesocial' ); ?></h2>
		<ul class="animatedParent1">
			<?php
			$post_count = 0;
			while ( $posts->have_posts() ) {
				$posts->the_post();
				$post_count++;
				?>
				<li class="animated fadeInLeftShort <?php echo $data_target; ?>" data-id="<?php echo $post_count; ?>">
					<?php
					printf( '<a href="%1$s" title="%2$s" rel="bookmark" class="entry-date"><time datetime="%3$s"><div>%4$s</div><div>%5$s</div><div>%6$s</div></time></a>', esc_url( get_permalink() ), esc_attr( get_the_time() ), esc_attr( get_the_date( 'c' ) ), esc_html( get_the_date( 'M' ) ), esc_html( get_the_date( 'j' ) ), esc_html( get_the_date( 'Y' ) )
					);
					?>
					<h3>
						<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'onesocial' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
					</h3>
				</li>
			<?php }
			?>
		</ul>
	</div>
	<?php
}

/**
 * Get posts by ajax
 *
 * @since OneSocial Theme 1.0.0
 */
add_action( 'wp_ajax_nopriv_buddyboss_ajax_posts', 'buddyboss_ajax_posts' );
add_action( 'wp_ajax_buddyboss_ajax_posts', 'buddyboss_ajax_posts' );

function buddyboss_ajax_posts() {

	$nonce = $_POST[ 'postsNonce' ];

	if ( !wp_verify_nonce( $nonce, 'ajax-posts-nonce' ) ) {
		die( 'Busted!' );
	}

	$data_target = $_POST[ 'data_target' ];
	$page		 = $_POST[ 'page' ];
	$sort		 = (isset( $_POST[ 'sort' ] )) ? $_POST[ 'sort' ] : 'latests';
	$per_page	 = -1;

	if ( $page == 'blog' ) {
		$per_page = 3;
	}

	if ( $sort === 'recommended' ) {
		$args = array(
			'author'		 => $_POST[ 'author' ],
			'posts_per_page' => $per_page,
			'orderby'		 => 'meta_value',
			'meta_key'		 => '_post_like_count',
			'orderby'		 => 'meta_value_num',
			'order'			 => 'DESC',
		);
	} else {
		$args = array(
			'author'		 => $_POST[ 'author' ],
			'posts_per_page' => $per_page
		);
	}

	$posts = new WP_Query( $args );

	ob_start();

	if ( $posts->have_posts() ) {
		$function = 'buddyboss_more_posts_' . $page;
		$function( $posts, $sort, $posts->post_count, $data_target );
	} else {
		_e( 'No stories found', 'onesocial' );
	}

	$html = ob_get_contents();
	ob_end_clean();

	wp_reset_postdata();

	echo $html;

	die();
}

/**
 * Output a block of group members.
 *
 *
 */
add_action( 'wp_ajax_nopriv_buddyboss_get_group_members', 'buddyboss_get_group_members' );
add_action( 'wp_ajax_buddyboss_get_group_members', 'buddyboss_get_group_members' );

function buddyboss_get_group_members() {

	$nonce = $_POST[ 'membersNonce' ];

	if ( !wp_verify_nonce( $nonce, 'ajax-members-nonce' ) )
		die( 'Busted!' );

	$sort		 = $_POST[ 'sort' ];
	$page		 = $_POST[ 'page' ];
	$count_num	 = $_POST[ 'count' ];

//	if ( !$friend_ids = wp_cache_get( 'friends_friend_ids_' . bp_displayed_user_id(), 'bp' ) ) {

	if ( $page == 'single' ) {
//        $id = bp_displayed_user_id();
	} else {
		$id = $_POST[ 'id' ];
	}

	$members = groups_get_group_members( array(
		'group_id' => $id
	) );

//		wp_cache_set( 'friends_friend_ids_' . bp_displayed_user_id(), $friend_ids, 'bp' );
//	}
	?>

	<?php if ( $members[ 'members' ] ) { ?>

		<ul class="horiz-gallery">

			<?php
			$count	 = count( $members[ 'members' ] );
			if ( $count > $count_num )
				$count	 = $count_num;
			?>

			<?php for ( $i = 0; $i < $count; ++$i ) { ?>

				<li>
					<a href="<?php echo bp_core_get_user_domain( $members[ 'members' ][ $i ]->id ) ?>"><?php echo bp_core_fetch_avatar( array( 'item_id' => $members[ 'members' ][ $i ]->id, 'type' => 'thumb' ) ) ?></a>
					<h5><?php echo bp_core_get_userlink( $members[ 'members' ][ $i ]->id ) ?></h5>
				</li>

			<?php } ?>

			<li class="see-more">
				<a href="<?php echo trailingslashit( bp_displayed_user_domain() . bp_get_friends_slug() ) ?>" class="bb-icon-arrow-right-f"></a>
			</li>

		</ul>

		<?php
	}

	die();
}

/**
 * Output a block of friends.
 *
 *
 */
add_action( 'wp_ajax_nopriv_buddyboss_get_friends', 'buddyboss_get_friends' );
add_action( 'wp_ajax_buddyboss_get_friends', 'buddyboss_get_friends' );

function buddyboss_get_friends() {

	$nonce = $_POST[ 'friendsNonce' ];

	if ( !wp_verify_nonce( $nonce, 'ajax-friends-nonce' ) )
		die( 'Busted!' );

	$sort		 = $_POST[ 'sort' ];
	$page		 = $_POST[ 'page' ];
	$count_num	 = $_POST[ 'count' ];
	$sort		 = 'friends_get_' . $sort;
//	if ( !$friend_ids = wp_cache_get( 'friends_friend_ids_' . bp_displayed_user_id(), 'bp' ) ) {

	if ( $page == 'single' ) {
		$id = bp_displayed_user_id();
	} else {
		$id = bp_get_member_user_id();
	}

	$friends = $sort( bp_displayed_user_id(), 5 );

//		wp_cache_set( 'friends_friend_ids_' . bp_displayed_user_id(), $friend_ids, 'bp' );
//	}
	?>

	<?php if ( $friends[ 'users' ] ) { ?>

		<ul class="horiz-gallery">

			<?php
			$count	 = count( $friends[ 'users' ] );
			if ( $count > $count_num )
				$count	 = $count_num;
			?>

			<?php for ( $i = 0; $i < $count; ++$i ) { ?>

				<li>
					<a href="<?php echo bp_core_get_user_domain( $friends[ 'users' ][ $i ]->id ) ?>"><?php echo bp_core_fetch_avatar( array( 'item_id' => $friends[ 'users' ][ $i ]->id, 'type' => 'thumb' ) ) ?></a>
					<h5><?php echo bp_core_get_userlink( $friends[ 'users' ][ $i ]->id ) ?></h5>
				</li>

			<?php } ?>

			<li class="see-more">
				<a href="<?php echo trailingslashit( bp_displayed_user_domain() . bp_get_friends_slug() ) ?>" class="bb-icon-arrow-right-f"></a>
			</li>

		</ul>

	<?php } else { ?>

		<div id="message" class="info">
			<p><?php bp_word_or_name( __( "You haven't added any friend connections yet.", 'onesocial' ), __( "%s hasn't created any friend connections yet.", 'onesocial' ) ) ?></p>
		</div>

		<?php
	}

	die();
}

/**
 * Get IDs of followers or following.
 *
 * @since 1.0.0
 *
 * @param int $user_id ID of user which followers or following we are fetching.
 * @param string What we want followers or following.
 * @param string Sort method.
 *
 * @return array
 */
function get_follow( $user_id, $group, $sort ) {
	global $bp, $wpdb;

	$what_to_get = 'leader_id';
	$from		 = 'follower_id';

	if ( $group == 'followers' ) {
		$what_to_get = 'follower_id';
		$from		 = 'leader_id';
	}

	$sql[ 'select_main' ] = "SELECT DISTINCT u.{$what_to_get}";

	$sql[ 'from' ] = "FROM {$bp->follow->table_name} u LEFT JOIN {$wpdb->usermeta} um ON um.user_id = u.{$what_to_get}";

	if ( 'alphabetically' == $sort ) {
		$sql[ 'join_profiledata_alpha' ] = "LEFT JOIN {$bp->profile->table_name_data} pd ON u.{$what_to_get} = pd.user_id";
	}

	$sql[ 'where_active' ] = $wpdb->prepare( "WHERE u.{$from} = %d", $user_id );

	if ( 'recently_active' == $sort || 'newest' == $sort ) {
		$sql[ 'where_and' ] = $wpdb->prepare( "AND um.meta_key = %s", bp_get_user_meta_key( 'last_activity' ) );
	}

	if ( 'alphabetically' == $sort ) {
		$sql[ 'where_alpha' ] = "AND pd.field_id = 1";
	}

	switch ( $sort ) {
		case 'recently_active': default:
			$sql[]	 = "ORDER BY um.meta_value DESC";
			break;
		case 'newest':
			$sql[]	 = "ORDER BY u.leader_id DESC";
			break;
		case 'alphabetically':
			$sql[]	 = "ORDER BY pd.value ASC";
			break;
	}

	return $wpdb->get_col( join( ' ', (array) $sql ) );
}

/**
 * Display followers or following.
 *
 * @since 1.0.0
 *
 * @param string What we want followers or following.
 *
 * @return html
 */
add_action( 'wp_ajax_nopriv_buddyboss_get_follow', 'buddyboss_get_follow' );
add_action( 'wp_ajax_buddyboss_get_follow', 'buddyboss_get_follow' );

function buddyboss_get_follow() {
	if ( !class_exists( 'BP_Follow_Component' ) ) {
		return;
	}

	$nonce = $_POST[ 'followNonce' ];

	if ( !wp_verify_nonce( $nonce, 'ajax-follow-nonce' ) )
		die( 'Busted!' );

	$sort	 = isset( $_POST[ 'sort' ] ) ? $_POST[ 'sort' ] : 'recently_active';
	$group	 = $_POST[ 'group' ];

	global $bp;

	$follow = get_follow( bp_displayed_user_id(), $group, $sort );
	?>

	<?php if ( $follow ) { ?>

		<ul class="horiz-gallery">

			<?php
			$count	 = count( $follow );
			if ( $count > 5 )
				$count	 = 5;
			?>

			<?php for ( $i = 0; $i < $count; ++$i ) { ?>

				<li>
					<a href="<?php echo bp_core_get_user_domain( $follow[ $i ] ) ?>"><?php echo bp_core_fetch_avatar( array( 'item_id' => $follow[ $i ], 'type' => 'thumb' ) ) ?></a>
					<h5><?php echo bp_core_get_userlink( $follow[ $i ] ) ?></h5>
				</li>

			<?php } ?>

			<li class="see-more">
				<?php
				if ( $group == 'followers' ) {
					$slug = $bp->follow->followers->slug;
				} else {
					$slug = $bp->follow->following->slug;
				}
				?>
				<a href="<?php echo trailingslashit( bp_displayed_user_domain() . $slug ); ?>" class="bb-icon-arrow-right-f"></a>
			</li>

		</ul>

	<?php } else { ?>

		<div id="message" class="info">
			<?php if ( $group == 'followers' ) { ?>
				<p><?php bp_word_or_name( __( "You don't have any followers yet.", 'onesocial' ), __( "%s doesn't have any followers yet.", 'onesocial' ) ) ?></p>
			<?php } else { ?>
				<p><?php bp_word_or_name( __( "You don't have any following yet.", 'onesocial' ), __( "%s doesn't have any following yet.", 'onesocial' ) ) ?></p>
			<?php } ?>
		</div>

		<?php
	}

	die();
}

/**
 * Output a fancy description of the current forum, including total topics,
 * total replies, and last activity.
 *
 * @since OneSocial 1.0.0
 *
 * @param array $args Arguments passed to alter output
 * @uses bbp_get_single_forum_description() Return the eventual output
 */
function buddyboss_bbp_single_forum_description( $args = '' ) {
	echo buddyboss_bbp_get_single_forum_description( $args );
}

/**
 * Return a fancy description of the current forum, including total
 * topics, total replies, and last activity.
 *
 * @since OneSocial 1.0.0
 *
 * @param mixed $args This function supports these arguments:
 *  - forum_id: Forum id
 *  - before: Before the text
 *  - after: After the text
 *  - size: Size of the avatar
 * @uses bbp_get_forum_id() To get the forum id
 * @uses bbp_get_forum_topic_count() To get the forum topic count
 * @uses bbp_get_forum_reply_count() To get the forum reply count
 * @uses bbp_get_forum_freshness_link() To get the forum freshness link
 * @uses bbp_get_forum_last_active_id() To get the forum last active id
 * @uses bbp_get_author_link() To get the author link
 * @uses add_filter() To add the 'view all' filter back
 * @uses apply_filters() Calls 'bbp_get_single_forum_description' with
 *                        the description and args
 * @return string Filtered forum description
 */
function buddyboss_bbp_get_single_forum_description( $args = '' ) {

// Parse arguments against default values
	$r = bbp_parse_args( $args, array(
		'forum_id'	 => 0,
		'before'	 => '<div class="bbp-template-notice info"><p class="bbp-forum-description">',
		'after'		 => '</p></div>',
		'size'		 => 14,
		'feed'		 => true
	), 'get_single_forum_description' );

// Validate forum_id
	$forum_id = bbp_get_forum_id( $r[ 'forum_id' ] );

// Unhook the 'view all' query var adder
	remove_filter( 'bbp_get_forum_permalink', 'bbp_add_view_all' );

// Get some forum data
	$tc_int		 = bbp_get_forum_topic_count( $forum_id, false );
	$rc_int		 = bbp_get_forum_reply_count( $forum_id, false );
	$topic_count = bbp_get_forum_topic_count( $forum_id );
	$reply_count = bbp_get_forum_reply_count( $forum_id );
	$last_active = bbp_get_forum_last_active_id( $forum_id );

// Has replies
	if ( !empty( $reply_count ) ) {
		$reply_text = sprintf( _n( '%s reply', '%s replies', $rc_int, 'onesocial' ), $reply_count );
	}

// Forum has active data
	if ( !empty( $last_active ) ) {
		$topic_text		 = bbp_get_forum_topics_link( $forum_id );
		$time_since		 = bbp_get_forum_freshness_link( $forum_id );
		$last_updated_by = bbp_get_author_link( array( 'post_id' => $last_active, 'size' => $r[ 'size' ] ) );

		// Forum has no last active data
	} else {
		$topic_text = sprintf( _n( '%s topic', '%s topics', $tc_int, 'onesocial' ), $topic_count );
	}

// Forum has active data
	if ( !empty( $last_active ) ) {

		if ( !empty( $reply_count ) ) {

			if ( bbp_is_forum_category( $forum_id ) ) {
				$retstr = sprintf( __( '<span class="post-num">%1$s and %2$s</span> <span class="last-activity">Last updated by %3$s %4$s</span>', 'onesocial' ), $topic_text, $reply_text, $last_updated_by, $time_since );
			} else {
				$retstr = sprintf( __( '<span class="post-num">%1$s and %2$s</span> <span class="last-activity">Last updated by %3$s %4$s<span>', 'onesocial' ), $topic_text, $reply_text, $last_updated_by, $time_since );
			}
		} else {

			if ( bbp_is_forum_category( $forum_id ) ) {
				$retstr = sprintf( __( '<span class="post-num">%1$s</span> <span class="last-activity">Last updated by %2$s %3$s</span>', 'onesocial' ), $topic_text, $last_updated_by, $time_since );
			} else {
				$retstr = sprintf( __( '<span class="post-num">%1$s</span> <span class="last-activity">Last updated by %2$s %3$s</span>', 'onesocial' ), $topic_text, $last_updated_by, $time_since );
			}
		}

		// Forum has no last active data
	} else {

		if ( !empty( $reply_count ) ) {

			if ( bbp_is_forum_category( $forum_id ) ) {
				$retstr = sprintf( __( '<span class="post-num">%1$s and %2$s</span>', 'onesocial' ), $topic_text, $reply_text );
			} else {
				$retstr = sprintf( __( '<span class="post-num">%1$s and %2$s</span>', 'onesocial' ), $topic_text, $reply_text );
			}
		} else {

			if ( !empty( $topic_count ) ) {

				if ( bbp_is_forum_category( $forum_id ) ) {
					$retstr = sprintf( __( '<span class="post-num">%1$s</span>', 'onesocial' ), $topic_text );
				} else {
					$retstr = sprintf( __( '<span class="post-num">%1$s</span>', 'onesocial' ), $topic_text );
				}
			} else {
				$retstr = __( '<span class="post-num">0 topics and 0 posts</span>', 'onesocial' );
			}
		}
	}

// Add the 'view all' filter back
	add_filter( 'bbp_get_forum_permalink', 'bbp_add_view_all' );

// Combine the elements together
	$retstr = $r[ 'before' ] . $retstr . $r[ 'after' ];

// Return filtered result
	return apply_filters( 'bbp_get_single_forum_description', $retstr, $r );
}

/**
 * Output a fancy description of the current topic, including total topics,
 * total replies, and last activity.
 *
 * @since OneSocial 1.0.0
 *
 * @param array $args See {@link bbp_get_single_topic_description()}
 * @uses bbp_get_single_topic_description() Return the eventual output
 */
function buddyboss_bbp_single_topic_description( $args = '' ) {
	echo buddyboss_bbp_get_single_topic_description( $args );
}

/**
 * Return a fancy description of the current topic, including total topics,
 * total replies, and last activity.
 *
 * @since OneSocial 1.0.0
 *
 * @param mixed $args This function supports these arguments:
 *  - topic_id: Topic id
 *  - before: Before the text
 *  - after: After the text
 *  - size: Size of the avatar
 * @uses bbp_get_topic_id() To get the topic id
 * @uses bbp_get_topic_voice_count() To get the topic voice count
 * @uses bbp_get_topic_reply_count() To get the topic reply count
 * @uses bbp_get_topic_freshness_link() To get the topic freshness link
 * @uses bbp_get_topic_last_active_id() To get the topic last active id
 * @uses bbp_get_reply_author_link() To get the reply author link
 * @uses apply_filters() Calls 'bbp_get_single_topic_description' with
 *                        the description and args
 * @return string Filtered topic description
 */
function buddyboss_bbp_get_single_topic_description( $args = '' ) {

// Parse arguments against default values
	$r = bbp_parse_args( $args, array(
		'topic_id'	 => 0,
		'before'	 => '<div class="bbp-template-notice info"><p class="bbp-topic-description">',
		'after'		 => '</p></div>',
		'size'		 => 14
	), 'get_single_topic_description' );

// Validate topic_id
	$topic_id = bbp_get_topic_id( $r[ 'topic_id' ] );

// Unhook the 'view all' query var adder
	remove_filter( 'bbp_get_topic_permalink', 'bbp_add_view_all' );

// Build the topic description
	$vc_int		 = bbp_get_topic_voice_count( $topic_id, true );
	$voice_count = bbp_get_topic_voice_count( $topic_id, false );
	$reply_count = bbp_get_topic_replies_link( $topic_id );
	$time_since	 = bbp_get_topic_freshness_link( $topic_id );

// Singular/Plural
	$voice_count = sprintf( _n( '%s voice', '%s voices', $vc_int, 'onesocial' ), $voice_count );

// Topic has replies
	$last_reply = bbp_get_topic_last_reply_id( $topic_id );
	if ( !empty( $last_reply ) ) {
		$last_updated_by = bbp_get_author_link( array( 'post_id' => $last_reply, 'size' => $r[ 'size' ] ) );
		$retstr			 = sprintf( __( '<span class="post-num">%1$s, %2$s</span> <span class="last-activity">Last updated by %3$s %4$s</span>', 'onesocial' ), $reply_count, $voice_count, $last_updated_by, $time_since );

		// Topic has no replies
	} elseif ( !empty( $voice_count ) && !empty( $reply_count ) ) {
		$retstr = sprintf( __( '<span class="post-num">%1$s, %2$s</span>', 'onesocial' ), $voice_count, $reply_count );

		// Topic has no replies and no voices
	} elseif ( empty( $voice_count ) && empty( $reply_count ) ) {
		$retstr = sprintf( __( '<span class="post-num">0 replies</span>', 'onesocial' ), $voice_count, $reply_count );
	}

// Add the 'view all' filter back
	add_filter( 'bbp_get_topic_permalink', 'bbp_add_view_all' );

// Combine the elements together
	$retstr = $r[ 'before' ] . $retstr . $r[ 'after' ];

// Return filtered result
	return apply_filters( 'bbp_get_single_topic_description', $retstr, $r );
}

/**
 * Add @handle to forum replies
 *
 * @since OneSocial Theme 1.0.0
 *
 */
function buddyboss_add_handle() {
	echo '<span class="bbp-user-nicename"><span class="handle-sign">@</span>' . bp_core_get_username( bbp_get_reply_author_id( bbp_get_reply_id() ) ) . '</span>';
}

add_action( 'bbp_theme_after_reply_author_details', 'buddyboss_add_handle' );

/**
 * Remove "Nav" items from profile navigation
 *
 * @since Creative 1.0.0
 * @since 1.1.2 Updated
 */
function buddyboss_remove_settings_nav() {
    /**
     * Don't hide it if bp-reorder-tabs plugin is trying to list nav items
     */
    if( isset( $_GET['secret'] ) && $_GET['secret']=='yuYmn_erin2356UY' ){
        return;
    }

    $bp = buddypress();

    if ( version_compare( BP_VERSION, '2.6', '<' ) ){
        //legacy code
        unset( $bp->bp_nav[ 'settings' ] );
        unset( $bp->bp_nav[ 'messages' ] );
        unset( $bp->bp_nav[ 'notifications' ] );
    } else {
        //new navigation apis
        $to_hide = array( 'settings', 'messages', 'notifications' );
        foreach( $to_hide as $nav ){
            add_filter( 'bp_get_displayed_user_nav_' . $nav, '__return_false' );
        }
    }
}

add_action( 'bp_setup_nav', 'buddyboss_remove_settings_nav', 15 );

/**
 * Remove "Submenu" from profile navigation
 *
 * @since Creative 1.0.0
 *
 */
function onesocial_bp_remove_nav_item() {
	if ( function_exists( 'bp_core_remove_subnav_item' ) ) {
		global $bp;
		bp_core_remove_subnav_item( $bp->profile->slug, 'change-cover-image' );
	}
}

add_action( 'wp', 'onesocial_bp_remove_nav_item' );

/* * **************************** ADMIN BAR FUNCTIONS ***************************** */

/**
 * Strip all waste and unuseful nodes and keep components only and memory for notification
 * @since OneSocial 1.0.0
 * */
function buddyboss_strip_unnecessary_admin_bar_nodes( &$wp_admin_bar ) {
	global $admin_bar_myaccount, $bb_adminbar_notifications, $bb_adminbar_messages, $bp;

    $dontalter_adminbar = apply_filters( 'onesocial_prevent_adminbar_processing', is_admin() );
	if ( $dontalter_adminbar ) { //nothing to do on admin
		return;
	}
	$nodes = $wp_admin_bar->get_nodes();

	$bb_adminbar_notifications[] = @$nodes[ "bp-notifications" ];

	$current_href = $_SERVER[ "HTTP_HOST" ] . $_SERVER[ "REQUEST_URI" ];

	foreach ( $nodes as $name => $node ) {

		if ( $node->parent == "bp-notifications" ) {
			$bb_adminbar_notifications[] = $node;
		}

		if ( $node->parent == "" || $node->parent == "top-secondary" AND $node->id != "top-secondary" ) {
			if ( $node->id == "my-account" ) {
				continue;
			}
		}

		//adding active for parent link
		if ( $node->id == "my-account-xprofile-edit" ||
		$node->id == "my-account-groups-create" ) {

			if ( strpos( "http://" . $current_href, $node->href ) !== false ||
			strpos( "https://" . $current_href, $node->href ) !== false ) {
				buddyboss_adminbar_item_add_active( $wp_admin_bar, $name );
			}
		}

		if ( $node->id == "my-account-activity-personal" ) {
			if ( $bp->current_component == "activity" AND $bp->current_action == "just-me" AND bp_displayed_user_id() == get_current_user_id() ) {
				buddyboss_adminbar_item_add_active( $wp_admin_bar, $name );
			}
		}

		if ( $node->id == "my-account-xprofile-public" ) {
			if ( $bp->current_component == "profile" AND $bp->current_action == "public" AND bp_displayed_user_id() == get_current_user_id() ) {
				buddyboss_adminbar_item_add_active( $wp_admin_bar, $name );
			}
		}

		if ( $node->id == "my-account-messages-inbox" ) {
			$bb_adminbar_messages[] = $node;
			if ( $bp->current_component == "messages" AND $bp->current_action == "inbox" ) {
				buddyboss_adminbar_item_add_active( $wp_admin_bar, $name );
			}
		}

		//adding active for child link
		if ( $node->id == "my-account-settings-general" ) {
			if ( $bp->current_component == "settings" ||
			$bp->current_action == "general" ) {
				buddyboss_adminbar_item_add_active( $wp_admin_bar, $name );
			}
		}

		/*
		  //add active class if it has viewing page href
		  if(!empty($node->href)) {
		  if("http://".$current_href == $node->href AND "https://".$current_href == $node->href ) {
		  buddyboss_adminbar_item_add_active($wp_admin_bar,$name);
		  }
		  } */


		//add active class if it has viewing page href
		if ( !empty( $node->href ) ) {
			if (
			( "http://" . $current_href == $node->href || "https://" . $current_href == $node->href ) ||
			( $node->id = 'my-account-xprofile-edit' && strpos( "http://" . $current_href, $node->href ) === 0 )
			) {
				buddyboss_adminbar_item_add_active( $wp_admin_bar, $name );
				//add active class to its parent
				if ( $node->parent != '' && $node->parent != 'my-account-buddypress' ) {
					foreach ( $nodes as $name_inner => $node_inner ) {
						if ( $node_inner->id == $node->parent ) {
							buddyboss_adminbar_item_add_active( $wp_admin_bar, $name_inner );
							break;
						}
					}
				}
			}
		}
	}
}

add_action( 'admin_bar_menu', 'buddyboss_strip_unnecessary_admin_bar_nodes', 999 );

function buddyboss_adminbar_item_add_active( &$wp_admin_bar, $name ) {
	$gnode = $wp_admin_bar->get_node( $name );
	if ( $gnode ) {
		$gnode->meta[ "class" ] = isset( $gnode->meta[ "class" ] ) ? $gnode->meta[ "class" ] . " active" : " active";
		$wp_admin_bar->add_node( $gnode ); //update
	}
}

/**
 * Store adminbar specific nodes to use later for buddyboss
 * @since OneSocial 1.0.0
 * */
function buddyboss_memory_admin_bar_nodes() {
	static $bb_memory_admin_bar_step;
	global $bb_adminbar_myaccount;

	$dontalter_adminbar = apply_filters( 'onesocial_prevent_adminbar_processing', is_admin() );
	if ( $dontalter_adminbar ) { //nothing to do on admin
		return;
	}

	if ( !empty( $bb_adminbar_myaccount ) ) { //avoid multiple run
		return false;
	}

	if ( empty( $bb_memory_admin_bar_step ) ) {
		$bb_memory_admin_bar_step = 1;
		ob_start();
	} else {
		$admin_bar_output = ob_get_contents();
		ob_end_clean();

		echo $admin_bar_output;

		//strip some waste
		$admin_bar_output = str_replace( array( 'id="wpadminbar"',
			'role="navigation"',
			'class ',
			'class="nojq nojs"',
			'class="quicklinks" id="wp-toolbar"',
			'id="wp-admin-bar-top-secondary" class="ab-top-secondary ab-top-menu"',
		), '', $admin_bar_output );

		//remove screen shortcut link
		$admin_bar_output	 = @explode( '<a class="screen-reader-shortcut"', $admin_bar_output, 2 );
		$admin_bar_output2	 = "";
		if ( count( $admin_bar_output ) > 1 ) {
			$admin_bar_output2 = @explode( "</a>", $admin_bar_output[ 1 ], 2 );
			if ( count( $admin_bar_output2 ) > 1 ) {
				$admin_bar_output2 = $admin_bar_output2[ 1 ];
			}
		}
		$admin_bar_output = $admin_bar_output[ 0 ] . $admin_bar_output2;

		//remove screen logout link
		$admin_bar_output	 = @explode( '<a class="screen-reader-shortcut"', $admin_bar_output, 2 );
		$admin_bar_output2	 = "";
		if ( count( $admin_bar_output ) > 1 ) {
			$admin_bar_output2 = @explode( "</a>", $admin_bar_output[ 1 ], 2 );
			if ( count( $admin_bar_output2 ) > 1 ) {
				$admin_bar_output2 = $admin_bar_output2[ 1 ];
			}
		}
		$admin_bar_output = $admin_bar_output[ 0 ] . $admin_bar_output2;

		//remove script tag
		$admin_bar_output	 = @explode( '<script', $admin_bar_output, 2 );
		$admin_bar_output2	 = "";
		if ( count( $admin_bar_output ) > 1 ) {
			$admin_bar_output2 = @explode( "</script>", $admin_bar_output[ 1 ], 2 );
			if ( count( $admin_bar_output2 ) > 1 ) {
				$admin_bar_output2 = $admin_bar_output2[ 1 ];
			}
		}
		$admin_bar_output = $admin_bar_output[ 0 ] . $admin_bar_output2;

		//remove user details
		$admin_bar_output	 = @explode( '<a class="ab-item"', $admin_bar_output, 2 );
		$admin_bar_output2	 = "";
		if ( count( $admin_bar_output ) > 1 ) {
			$admin_bar_output2 = @explode( "</a>", $admin_bar_output[ 1 ], 2 );
			if ( count( $admin_bar_output2 ) > 1 ) {
				$admin_bar_output2 = $admin_bar_output2[ 1 ];
			}
		}
		$admin_bar_output = $admin_bar_output[ 0 ] . $admin_bar_output2;

		//add active class into vieving link item
		$current_link = $_SERVER[ "HTTP_HOST" ] . $_SERVER[ "REQUEST_URI" ];

		$bb_adminbar_myaccount = $admin_bar_output;
	}
}

add_action( "wp_before_admin_bar_render", "buddyboss_memory_admin_bar_nodes" );
add_action( "wp_after_admin_bar_render", "buddyboss_memory_admin_bar_nodes" );

/**
 * Get adminbar myaccount section output
 * Note :- this function can be overwrite with child-theme.
 * @since OneSocial 1.0.0
 *
 * */
function buddyboss_adminbar_myaccount() {
	global $bb_adminbar_myaccount;
	echo $bb_adminbar_myaccount;
}

/**
 * Removing woocomerce function that disables adminbar for subsribers
 *
 * @since OneSocial 1.0.0
 *
 */
remove_filter( 'show_admin_bar', 'wc_disable_admin_bar' );

/**
 * Removing 3rd party hooks
 */
if ( !function_exists( 'onesocial_remove_hooks' ) ) {

	function onesocial_remove_hooks() {
		// Bookmark Button Single Post
		remove_filter( 'the_content', 'sap_add_bookmark_button_after_post' );

		// Recommend Button Single Post
		remove_filter( 'the_content', 'sap_add_recommend_button_after_post' );
	}

	add_action( 'init', 'onesocial_remove_hooks' );
}

/**
 * Get Notification from admin bar
 * @since OneSocial 1.0.0
 * */
function buddyboss_adminbar_notification() {
	global $bb_adminbar_notifications;
	return @$bb_adminbar_notifications;
}

function buddyboss_adminbar_messages() {
	global $bb_adminbar_messages;
	return @$bb_adminbar_messages;
}

/**
 * Correct notification count in header notification
 *
 * @since OneSocial 1.0.0
 *
 */
function buddyboss_js_correct_notification_count() {
	if ( !is_user_logged_in() || !buddyboss_is_bp_active() || !function_exists( 'bp_notifications_get_all_notifications_for_user' ) ) {
		return;
	}

	$notifications = bp_notifications_get_all_notifications_for_user( bp_loggedin_user_id() );

	if ( !empty( $notifications ) ) {
		$count = count( $notifications );
		?>
		<script type="text/javascript">
		    jQuery( 'document' ).ready( function ( $ ) {
		        $( '.header-notifications .notification-link span.alert' ).html( '<?php echo $count; ?>' );
		    } );
		</script>
		<?php
	}
}

add_action( 'wp_footer', 'buddyboss_js_correct_notification_count' );

/**
 * Heartbeat settings
 *
 * @since OneSocial 1.0.0
 *
 */
function buddyboss_heartbeat_settings( $settings ) {
	$settings[ 'interval' ] = 5; //pulse on each 20 sec.
	return $settings;
}

add_filter( 'heartbeat_settings', 'buddyboss_heartbeat_settings' );

/**
 * Sending a heartbeat for notification updates
 *
 * @since OneSocial 1.0.0
 *
 */
function buddyboss_notification_count_heartbeat( $response, $data, $screen_id ) {
    $notifications = array();

	if ( function_exists( "bp_friend_get_total_requests_count" ) )
		$friend_request_count	 = bp_friend_get_total_requests_count();
	if ( function_exists( "bp_notifications_get_all_notifications_for_user" ) )
		$notifications			 = bp_notifications_get_all_notifications_for_user( get_current_user_id() );

	$notification_count		 = count( $notifications );

	if ( function_exists( "bp_notifications_get_all_notifications_for_user" ) ) {
		$notifications			 = bp_notifications_get_notifications_for_user( get_current_user_id() );
		$notification_content	 = '';
        if( !empty( $notifications ) ){
            foreach ( (array) $notifications as $notification ) {
                if( is_array( $notification ) ){
                    if( isset( $notification['link'] ) && isset( $notification['text'] ) ){
                        $notification_content .= "<a href='". esc_url( $notification['link'] ) ."'>{$notification['text']}</a>";
                    }
                } else {
                    $notification_content .= $notification;
                }
            }
        }

		if ( empty( $notification_content ) )
			$notification_content = '<a href="' . bp_loggedin_user_domain() . '' . BP_NOTIFICATIONS_SLUG . '/">' . __( "No new notifications", "buddypress" ) . '</a>';
	}
	if ( function_exists( "messages_get_unread_count" ) )
		$unread_message_count = messages_get_unread_count();

	$response[ 'bb_notification_count' ] = array(
		'friend_request'		 => @intval( $friend_request_count ),
		'notification'			 => @intval( $notification_count ),
		'notification_content'	 => @$notification_content,
		'unread_message'		 => @intval( $unread_message_count )
	);

	return $response;
}

// Logged in users:
add_filter( 'heartbeat_received', 'buddyboss_notification_count_heartbeat', 10, 3 );


/**
 * Add avatar to comment form
 *
 * @since Education 1.0.0
 *
 */
add_action( 'comment_form_logged_in_after', 'post_comment_form_avatar' );

function post_comment_form_avatar() {
	$user_link = get_author_posts_url( get_current_user_id() );

	if ( function_exists( 'bp_core_get_userlink' ) && !function_exists( 'buddyboss_sap' ) ) {
		$user_link = bp_core_get_userlink( get_current_user_id(), false, true );
	}

	if ( function_exists( 'bp_core_get_userlink' ) && function_exists( 'buddyboss_sap' ) ) {
		$user_link = bp_core_get_userlink( get_current_user_id(), false, true ) . 'blog';
	}

	printf( '<span class="comment-avatar authors-avatar vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>', $user_link, esc_attr( sprintf( __( 'View all posts by %s', 'onesocial' ), get_the_author() ) ), get_avatar( get_current_user_id(), 85, '', get_the_author() ) );
}

/**
 * Places "Compose" to the first place on messages navigation links
 *
 * @since OneSocial 1.0.0
 *
 */
function buddyboss_change_bp_tag_position() {
	global $bp;
    $version_compare = version_compare( BP_VERSION, '2.6', '<' );
    if ( $version_compare ){
        $bp->bp_options_nav[ 'messages' ][ 'compose' ][ 'position' ] = 10;
        $bp->bp_options_nav[ 'messages' ][ 'inbox' ][ 'position' ]	 = 11;
        $bp->bp_options_nav[ 'messages' ][ 'sentbox' ][ 'position' ] = 30;
        $bp->bp_options_nav[ 'messages' ][ 'notices' ][ 'position' ] = 40;
    } else {
        if( !empty( $bp->messages ) ){
            $subnavs = array( 'compose' => 10, 'inbox' => 11, 'sentbox' => 30, 'notices' => 40, );
            foreach( $subnavs as $subnav => $pos ){
                $nav_args = array( 'position' => $pos );
                $bp->members->nav->edit_nav( $nav_args, $subnav, 'messages' );
            }
        }
    }
}

add_action( 'bp_init', 'buddyboss_change_bp_tag_position', 999 );



if ( !function_exists( 'buddyboss_get_options_nav' ) ) :

	/**
	 * Messages navigation
	 *
	 * @since Education 1.0.0
	 * @since 1.1.2 updated
	 */
	function buddyboss_get_options_nav( $parent_slug = '' ) {
		$bp = buddypress();

		// If we are looking at a member profile, then the we can use the current
		// component as an index. Otherwise we need to use the component's root_slug
		$component_index = !empty( $bp->displayed_user ) ? bp_current_component() : bp_get_root_slug( bp_current_component() );
		$selected_item	 = bp_current_action();

		if ( !bp_is_single_item() ) {
            $options_nav = buddyboss_bp_options_nav( $component_index );
			if ( empty( $options_nav ) ) {
				return false;
			} else {
				$the_index = $component_index;
			}
		} else {
			$current_item = bp_current_item();

			if ( !empty( $parent_slug ) ) {
				$current_item	 = $parent_slug;
				$selected_item	 = bp_action_variable( 0 );
			}

            $options_nav = buddyboss_bp_options_nav( $current_item );
			if ( empty( $options_nav ) ) {
				return false;
			} else {
				$the_index = $current_item;
			}
		}
		global $wpdb;

		$user_id = get_current_user_id();

		$sentbox = (int) $wpdb->query( "SELECT * FROM {$bp->messages->table_name_messages} WHERE sender_id = " . $user_id );
		$inbox	 = '';
		$starred = (int) $wpdb->query( "SELECT * FROM {$bp->messages->table_name_recipients} m LEFT JOIN {$bp->messages->table_name_meta} mt ON m.id=mt.message_id WHERE mt.meta_key = 'starred_by_user' AND mt.meta_value = {$user_id}" );
		$notices = (int) $wpdb->query( "SELECT * FROM {$bp->messages->table_name_notices}" );

		//Is buddyboss-inbox activated?
		$bb_inbox_active = function_exists( 'buddyboss_messages' ) ? true : false;

		//let buddyboss inbox plugin to add message count
		$unread_count = (int) $wpdb->get_var( $wpdb->prepare( "SELECT SUM(unread_count) FROM {$bp->messages->table_name_recipients} WHERE user_id = %d AND is_deleted = 0 AND sender_only = 0", $user_id ) );

		if ( !$bb_inbox_active ) {
			$inbox = $unread_count;
		}

		$number_of_items = array( '<i class="bb-icon-messages"></i>', $inbox, $starred, $sentbox, $notices );

		//Fill 0 for vacant draft count
		if ( $bb_inbox_active ) {
			$user_drafts = bbm_get_user_draft_ids();
			if ( empty( $user_drafts ) ) {
				$number_of_items[] = 0;
			}
		}

		$i = 0;
		// Loop through each navigation item
        $subnav_items = (array) buddyboss_bp_options_nav( $the_index );
		foreach ( $subnav_items as $subnav_item ) {
			if ( empty( $subnav_item[ 'user_has_access' ] ) ) {
				$i++;
				continue;
			}

			// If the current action or an action variable matches the nav item id, then add a highlight CSS class.
			if ( $subnav_item[ 'slug' ] == $selected_item ) {
				$selected = ' class="current selected"';
			} else {
				$selected = '';
			}

			// List type depends on our current component
			$list_type = bp_is_group() ? 'groups' : 'personal';

			// echo out the final list item
			echo apply_filters( 'bb_get_options_nav_' . $subnav_item[ 'css_id' ], '<li id="' . $subnav_item[ 'css_id' ] . '-' . $list_type . '-li" ' . $selected . '><a id="' . $subnav_item[ 'css_id' ] . '" href="' . $subnav_item[ 'link' ] . '">' . $subnav_item[ 'name' ] . '<span>' . $number_of_items[ $i ] . '</span></a></li>', $subnav_item, $selected_item );

			$i++;
		}
	}

endif;

/**
 * Messages date function
 *
 * @since Education 1.0.0
 *
 */
function buddyboss_format_time( $time, $just_date = true, $localize_time = true ) {

	if ( !isset( $time ) || !is_numeric( $time ) ) {
		return false;
	}

// Get GMT offset from root blog
	$root_blog_offset = false;
	if ( !empty( $localize_time ) ) {
		$root_blog_offset = get_blog_option( bp_get_root_blog_id(), 'gmt_offset' );
	}

// Calculate offset time
	$time_offset = $time + ( $root_blog_offset * 3600 );

// Current date (January 1, 2010)
	$date = date_i18n( 'M j', $time_offset );

// Should we show the time also?
	if ( empty( $just_date ) ) {
		// Current time (9:50pm)
		$time = date_i18n( get_option( 'time_format' ), $time_offset );

		// Return string formatted with date and time
		$date = sprintf( __( '%1$s at %2$s', 'buddypress' ), $date, $time );
	}

	return apply_filters( 'bp_format_time', $date );
}

if ( !function_exists( 'bb_get_new_group_invite_friend_list' ) ) :

	/**
	 * Overrides buddypress function bp_get_new_group_invite_friend_list
	 *
	 * @since OneSocial Theme 1.0.0
	 *
	 */
	function bb_get_new_group_invite_friend_list( $args = '' ) {
		$bp = buddypress();

		if ( !bp_is_active( 'friends' ) ) {
			return false;
		}

		$defaults = array(
			'group_id'	 => false,
			'separator'	 => 'li'
		);

		$r = wp_parse_args( $args, $defaults );
		extract( $r, EXTR_SKIP );

		if ( empty( $group_id ) ) {
			$group_id = !empty( $bp->groups->new_group_id ) ? $bp->groups->new_group_id : $bp->groups->current_group->id;
		}

		if ( $friends = friends_get_friends_invite_list( bp_loggedin_user_id(), $group_id ) ) {
			$invites = groups_get_invites_for_group( bp_loggedin_user_id(), $group_id );

			for ( $i = 0, $count = count( $friends ); $i < $count; ++$i ) {
				$checked = '';

				if ( !empty( $invites ) ) {
					if ( in_array( $friends[ $i ][ 'id' ], $invites ) ) {
						$checked = ' checked="checked"';
					}
				}

				$items[] = '<' . $separator . '><input' . $checked . ' type="checkbox" name="friends[]" id="f-' . $friends[ $i ][ 'id' ] . '" value="' . esc_attr( $friends[ $i ][ 'id' ] ) . '" /><strong>' . bp_core_fetch_avatar( array( 'item_id' => $friends[ $i ][ 'id' ], 'type' => 'full', 'width' => '50', 'height' => '50' ) ) . $friends[ $i ][ 'full_name' ] . '</strong></' . $separator . '>';
			}
		}

		if ( !empty( $items ) ) {
			return implode( "\n", (array) $items );
		}

		return false;
	}

endif;


/**
 * Add title to notes
 *
 * @since OneSocial Theme 1.0.0
 *
 */
add_action( 'incom_cancel_x_before', 'onesocial_add_notes_title' );
add_action( 'sap_incom_cancel_x_before', 'onesocial_add_notes_title' );

function onesocial_add_notes_title() {
	echo '<span class="notes-title">' . __( 'Notes', 'onesocial' ) . '</span>';
}

/**
 * Remove plugin info
 *
 * @since OneSocial Theme 1.0.0
 *
 */
add_filter( 'incom_plugin_info', 'onesocial_remove_plugin_info' );
add_filter( 'sap_incom_plugin_info', 'onesocial_remove_plugin_info' );

function onesocial_remove_plugin_info() {
	return '';
}

/**
 * Remove plugin info
 *
 * @since OneSocial Theme 1.0.0
 *
 */
add_filter( 'incom_comment_form_args', 'onesocial_fileter_note_form' );
add_filter( 'sap_incom_comment_form_args', 'onesocial_fileter_note_form' );

function onesocial_fileter_note_form() {
	$user			 = wp_get_current_user();
	$user_identity	 = $user->exists() ? $user->display_name : '';

	$args = array(
		'id_form'				 => 'incom-commentform',
		'comment_form_before'	 => '',
		'comment_notes_before'	 => '',
		'comment_notes_after'	 => '',
		'label_submit'			 => __( 'Save', 'onesocial' ),
		'title_reply'			 => '',
		'title_reply_to'		 => '',
		'logged_in_as'			 => '<p class="logged-in-as">' .
		sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>.', 'onesocial' ), admin_url( 'profile.php' ), $user_identity ) . '</p>',
		'user_identity'			 => $user_identity,
		'comment_field'			 => '<p class="comment-form-comment"><label for="comment">' . $user_identity .
		'</label><textarea id="sap-comment" name="comment" cols="45" rows="2" aria-required="true" placeholder="' . __( 'Leave a note', 'onesocial' ) . '">' .
		'</textarea></p>',
	);

	return $args;
}

/**
 * Returns xprofile fields list
 *
 * @since OneSocial Theme 1.0.0
 */
function buddyboss_customizer_xprofile_field_choices() {
	$options = array();

	if ( function_exists( 'bp_is_active' ) ) {
		if ( bp_is_active( 'xprofile' ) && bp_has_profile( array( 'user_id' => bp_loggedin_user_id() ) ) ) {
			while ( bp_profile_groups() ) {
				bp_the_profile_group();
				if ( bp_profile_group_has_fields() ) {
					while ( bp_profile_fields() ) {
						bp_the_profile_field();
						$options[ bp_get_the_profile_field_id() ] = bp_get_the_profile_field_name();
					}
				}
			}
		}
	}

	return $options;
}

/**
 * Remove Output the "Add Friend" button in the member loop.
 */
remove_action( 'bp_directory_members_actions', 'bp_member_add_friend_button' );

/**
 * Estimate time required to read the article
 *
 * @return string
 */
function boss_estimated_reading_time( $post_content ) {

	$words	 = str_word_count( strip_tags( $post_content ) );
	$minutes = floor( $words / 120 );
	$seconds = floor( $words % 120 / ( 120 / 60 ) );

	if ( 1 <= $minutes ) {
		$estimated_time = $minutes . __( ' min read', 'onesocial' );
	} else {
		$estimated_time = $seconds . __( ' sec read', 'onesocial' );
	}

	return $estimated_time;
}

/**
 * Change group excerpt length
 * group-description
 */
function boss_custom_group_excerpt() {
	global $groups_template;

	$group = $groups_template->group;

	if ( isset( $group->description ) ) {
		return bp_create_excerpt( $group->description, 125 );
	}
}

add_filter( 'bp_get_group_description_excerpt', 'boss_custom_group_excerpt' );

// Search default text
if ( !function_exists( 'boss_bp_get_search_default_text' ) ) {

	function boss_bp_get_search_default_text( $param ) {
		return __( 'Type to Search', 'onesocial' );
	}

}

add_filter( 'bp_get_search_default_text', 'boss_bp_get_search_default_text' );

// Custom Excerpt
if ( !function_exists( 'onesocial_custom_excerpt' ) ) {

	function onesocial_custom_excerpt( $content, $limit ) {
		$excerpt = explode( ' ', $content, $limit );
		if ( count( $excerpt ) >= $limit ) {
			array_pop( $excerpt );
			$excerpt = implode( " ", $excerpt ) . '&hellip;';
		} else {
			$excerpt = implode( " ", $excerpt );
		}
		$excerpt = preg_replace( '`\[[^\]]*\]`', '', $excerpt );
		return $excerpt;
	}

}

// Change more
function onesocial_excerpt_more() {
	return '&hellip;';
}

add_filter( 'excerpt_more', 'onesocial_excerpt_more' );

// BuddyPress excerpt append.
function onesocial_bp_excerpt_append_text() {
	return '&hellip;';
}

add_filter( 'bp_excerpt_append_text', 'onesocial_bp_excerpt_append_text' );

function onesocial_custom_excerpt_length() {
	return 15;
}

/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own buddyboss_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Twelve 1.0
 */
if ( !function_exists( 'buddyboss_comment' ) ) {

	function buddyboss_comment( $comment, $args, $depth ) {

		$GLOBALS[ 'comment' ] = $comment;

		switch ( $comment->comment_type ) {
			case 'pingback' :
			case 'trackback' :
				?>

				<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
					<p><?php _e( 'Pingback:', 'onesocial' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'onesocial' ), '<span class="edit-link">', '</span>' ); ?></p>
					<?php
					break;
				default :
					global $post;
					?>
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<article id="comment-<?php comment_ID(); ?>" class="comment">
						<header class="comment-meta comment-author vcard">
							<?php
							$author_id	 = $comment->user_id;
							$user_link	 = get_author_posts_url( $author_id );

							if ( function_exists( 'bp_core_get_userlink' ) && !function_exists( 'buddyboss_sap' ) ) {
								$user_link = bp_core_get_userlink( $author_id, false, true );
							}

							if ( function_exists( 'bp_core_get_userlink' ) && function_exists( 'buddyboss_sap' ) ) {
								$user_link = bp_core_get_userlink( $author_id, false, true ) . 'blog';
							}

							printf( '<span class="authors-avatar vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>', $user_link, esc_attr( sprintf( __( 'View all posts by %s', 'onesocial' ), get_the_author() ) ), get_avatar( $author_id, 85, '', get_the_author() ) );

							//echo get_avatar( $comment, 44 );
							printf( '<cite class="fn">%1$s %2$s</cite>', get_comment_author_link(),
							// If current post author is also comment author, make it known visually.
			   ( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'onesocial' ) . '</span>' : ''
							);
							printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>', esc_url( get_comment_link( $comment->comment_ID ) ), get_comment_time( 'c' ),
							/* translators: 1: date, 2: time */ sprintf( __( '%1$s at %2$s', 'onesocial' ), get_comment_date(), get_comment_time() )
							);
							?>
						</header><!-- .comment-meta -->

						<?php if ( '0' == $comment->comment_approved ) : ?>
							<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'onesocial' ); ?></p>
						<?php endif; ?>

						<section class="comment-content comment">
							<?php comment_text(); ?>
						</section><!-- .comment-content -->

						<div class="reply">
							<?php edit_comment_link( __( 'Edit', 'onesocial' ), '<span class="edit-link">', '</span>' ); ?>
							<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'onesocial' ), 'depth' => $depth, 'max_depth' => $args[ 'max_depth' ] ) ) ); ?>
						</div><!-- .reply -->
					</article><!-- #comment-## -->
					<?php
					break;
			} // end comment_type check
		}

	}

	function boss_get_new_group_invite_friend_list( $args = '' ) {
		$bp			 = buddypress();
		$alt_avatar	 = esc_url( get_template_directory_uri() ) . '/images/avatar-member.png';

		if ( !bp_is_active( 'friends' ) ) {
			return false;
		}

		$defaults = array(
			'group_id'	 => false,
			'separator'	 => 'li'
		);

		$r = wp_parse_args( $args, $defaults );
		extract( $r, EXTR_SKIP );

		if ( empty( $group_id ) ) {
			$group_id = !empty( $bp->groups->new_group_id ) ? $bp->groups->new_group_id : $bp->groups->current_group->id;
		}

		if ( $friends = friends_get_friends_invite_list( bp_loggedin_user_id(), $group_id ) ) {
			$invites = groups_get_invites_for_group( bp_loggedin_user_id(), $group_id );

			for ( $i = 0, $count = count( $friends ); $i < $count; ++$i ) {
				$checked = '';

				if ( !empty( $invites ) ) {
					if ( in_array( $friends[ $i ][ 'id' ], $invites ) ) {
						$checked = ' checked="checked"';
					}
				}

				$items[] = '<' . $separator . '><input' . $checked . ' type="checkbox" name="friends[]" id="f-' . $friends[ $i ][ 'id' ] . '" value="' . esc_attr( $friends[ $i ][ 'id' ] ) . '" /> ' . bp_get_activity_avatar( array( 'user_id' => $friends[ $i ][ 'id' ], 'width' => '50', 'alt' => $alt_avatar ) ) . $friends[ $i ][ 'full_name' ] . '</' . $separator . '>';
			}
		}

		if ( !empty( $items ) ) {
			return implode( "\n", (array) $items );
		}

		return false;
	}

	/**
	 * Woocommerce remove sidebar
	 */
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

	/* --------------------------------
	 * Woocommerce pages markup
	  -------------------------------- */
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

	add_action( 'woocommerce_before_main_content', 'onesocial_theme_wrapper_start', 10 );
	add_action( 'woocommerce_after_main_content', 'onesocial_theme_wrapper_end', 10 );

	function onesocial_theme_wrapper_start() {
		// Fixed - Sidebar moved to the bottom of shop page (Not needed)
		//		if ( is_active_sidebar( 'woo_sidebar' ) ) {
		//			echo '<div class="page-right-sidebar">';
		//		} else {
		//			echo '<div class="page-full-width">';
		//		}

		echo '<div id="primary" class="site-content">';
		echo '<div id="content" role="main" class="woo-content">';
	}

	function onesocial_theme_wrapper_end() {
		echo '</div><!-- .woo-content -->';
		echo '</div><!-- #primary -->';
		$show_sidebar = apply_filters( 'onesocial_show_woo_sidebar', true );
		if ( is_active_sidebar( 'woo_sidebar' ) && $show_sidebar ) {
			echo '<div id="secondary" class="widget-area" role="complementary">';
			dynamic_sidebar( 'woo_sidebar' );
			echo '</div><!-- #secondary -->';
		}
		// Fixed - Sidebar moved to the bottom of shop page (Not needed)
		// echo '</div>';
	}

	/**
	 * Add image size for cover photo.
	 *
	 * @since OneSocial 1.0.0
	 */
	if ( !function_exists( 'boss_cover_thumbnail' ) ) :

		add_action( 'after_setup_theme', 'boss_cover_thumbnail' );

		function boss_cover_thumbnail() {
			add_image_size( 'boss-cover-image', 1500, 500, true );
		}

	endif;

	/**
	 * Remove change cover image option from adminbar.
	 */
	if ( !function_exists( 'buddyboss_admin_bar_remove_links' ) ) {

		function buddyboss_admin_bar_remove_links() {
			global $wp_admin_bar;
			$wp_admin_bar->remove_node( 'my-account-xprofile-change-cover-image' );
		}

		add_action( 'wp_before_admin_bar_render', 'buddyboss_admin_bar_remove_links' );
	}


	/**
	 * Output markup listing group admins.
	 *
	 * @param object|bool $group Optional. Group object.
	 *                           Default: current group in loop.
	 */
	if ( !function_exists( 'buddyboss_group_list_admins' ) ) {

		function buddyboss_group_list_admins( $group = false ) {
			global $groups_template;

			if ( empty( $group ) ) {
				$group = & $groups_template->group;
			}

			// fetch group admins if 'populate_extras' flag is false
			if ( empty( $group->args[ 'populate_extras' ] ) ) {
				$query = new BP_Group_Member_Query( array(
					'group_id'	 => $group->id,
					'group_role' => 'admin',
					'type'		 => 'first_joined',
				) );

				if ( !empty( $query->results ) ) {
					$group->admins = $query->results;
				}
			}

			if ( !empty( $group->admins ) ) {
				?>
				<ul id="group-admins">
					<?php foreach ( (array) $group->admins as $admin ) { ?>
						<li>
							<a class="group-admin-container" href="<?php echo bp_core_get_user_domain( $admin->user_id, $admin->user_nicename, $admin->user_login ) ?>">
								<?php echo bp_core_fetch_avatar( array( 'item_id' => $admin->user_id, 'email' => $admin->user_email, 'alt' => sprintf( __( 'Profile picture of %s', 'buddypress' ), bp_core_get_user_displayname( $admin->user_id ) ) ) ) ?>
								<h5 class="group-admin-name"><?php echo bp_core_get_user_displayname( $admin->user_id ); ?></h5>
							</a>
						</li>
					<?php } ?>
				</ul>
			<?php } else { ?>
				<span class="activity"><?php _e( 'No Admins', 'buddypress' ) ?></span>
			<?php } ?>
			<?php
		}

	}

	/**
	 * Output markup listing group mod.
	 *
	 * @param object|bool $group Optional. Group object.
	 *                           Default: current group in loop.
	 */
	if ( !function_exists( 'buddyboss_group_list_mods' ) ) {

		function buddyboss_group_list_mods( $group = false ) {
			global $groups_template;

			if ( empty( $group ) ) {
				$group = & $groups_template->group;
			}

			// fetch group mods if 'populate_extras' flag is false
			if ( empty( $group->args[ 'populate_extras' ] ) ) {
				$query = new BP_Group_Member_Query( array(
					'group_id'	 => $group->id,
					'group_role' => 'mod',
					'type'		 => 'first_joined',
				) );

				if ( !empty( $query->results ) ) {
					$group->mods = $query->results;
				}
			}

			if ( !empty( $group->mods ) ) :
				?>

				<ul id="group-mods">

					<?php foreach ( (array) $group->mods as $mod ) { ?>

						<li>
							<a href="<?php echo bp_core_get_user_domain( $mod->user_id, $mod->user_nicename, $mod->user_login ) ?>"><?php echo bp_core_fetch_avatar( array( 'item_id' => $mod->user_id, 'email' => $mod->user_email, 'alt' => sprintf( __( 'Profile picture of %s', 'buddypress' ), bp_core_get_user_displayname( $mod->user_id ) ) ) ) ?></a>
							<h5 class="group-admin-name"><?php echo bp_core_get_user_displayname( $mod->user_id ); ?></h5>
						</li>

					<?php } ?>

				</ul>

			<?php else : ?>

				<span class="activity"><?php _e( 'No Mods', 'buddypress' ) ?></span>

			<?php
			endif;
		}

	}

	if ( !function_exists( 'onesocial_xprofile_cover_image' ) ) {

		function onesocial_xprofile_cover_image( $settings = array() ) {
			$settings[ 'height' ] = '350';

			return $settings;
		}

		add_filter( 'bp_before_groups_cover_image_settings_parse_args', 'onesocial_xprofile_cover_image', 10, 1 );
	}

	function onesocial_categorized_blog() {
		if ( false === ( $all_the_cool_cats = get_transient( 'onesocial_categories' ) ) ) {
			// Create an array of all the categories that are attached to posts.
			$all_the_cool_cats = get_categories( array(
				'fields'	 => 'ids',
				'hide_empty' => 1,
				// We only need to know if there is more than one category.
				'number'	 => 2,
			) );

			// Count the number of categories that are attached to the posts.
			$all_the_cool_cats = count( $all_the_cool_cats );

			set_transient( 'onesocial_categories', $all_the_cool_cats );
		}

		if ( $all_the_cool_cats > 1 ) {
			// This blog has more than 1 category so tmsrvd_categorized_blog should return true.
			return true;
		} else {
			// This blog has only 1 category so tmsrvd_categorized_blog should return false.
			return false;
		}
	}

	function onesocial_entry_categories() {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ', ', 'onesocial' ) );
		if ( $categories_list && onesocial_categorized_blog() ) {
			print( '<span class="cat-links">' . $categories_list . '</span>' );
		}
	}

	function onesocial_posted_on() {
                    printf( '<a href="%1$s" title="%2$s" rel="bookmark" class="entry-date"><time datetime="%3$s">%4$s</time></a>', esc_url( get_permalink() ), esc_attr( get_the_time() ), esc_attr( get_the_date( 'c' ) ), esc_html( get_the_date( 'M j, Y' ) ));
	}

	if ( !function_exists( 'buddyboss_slider' ) ) {

		function buddyboss_slider() {
			if ( 'page' == get_option( 'show_on_front' ) && is_front_page() ) {
				// Frontpage Slider
				get_template_part( 'content', 'slides' );
				do_action( 'onesocial_custom_slider' );
			}
		}

	}
	add_action( 'buddyboss_inside_wrapper', 'buddyboss_slider' );

	/**
	 * Run custom slider shortcode
	 */
	if ( !function_exists( 'onesocial_execute_slider_shortcode' ) ):

		function onesocial_execute_slider_shortcode() {
			$slider_shortcode = onesocial_get_option( 'boss_plugins_slider' );
			if ( !empty( $slider_shortcode ) && !onesocial_get_option( 'boss_slider_switch' ) ) {
				echo do_shortcode( onesocial_get_option( 'boss_plugins_slider' ) );
			}
		}

	endif;

	add_action( 'onesocial_custom_slider', 'onesocial_execute_slider_shortcode' );

	global $BUDDYBOSS_BM;

	if ( $BUDDYBOSS_BM ) {
		if ( !function_exists( 'woocommerce_get_product_thumbnail' ) ) {

			/**
			 * Override woocommerce product loop thumbnail
			 * @param  [[Type]] [$size = 'bm-product-archive'] [[Description]]
			 * @param  [[Type]] [$deprecated1 = 0]             [[Description]]
			 * @param  [[Type]] [$deprecated2 = 0]             [[Description]]
			 * @return [[Type]] [[Description]]
			 */
			function woocommerce_get_product_thumbnail( $size = 'bm-product-archive', $deprecated1 = 0, $deprecated2 = 0 ) {
				global $post;

				if ( has_post_thumbnail() ) {
					return get_the_post_thumbnail( $post->ID, $size );
				} elseif ( wc_placeholder_img_src() ) {
					return wc_placeholder_img( $size );
				}
			}

		}
	}

	function onesocial_userblog_is_network_activated() {
		$network_activated = '';
		if ( is_multisite() ) {
			if ( !function_exists( 'is_plugin_active_for_network' ) )
				require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
			if ( is_plugin_active_for_network( basename( constant( 'BP_PLUGIN_DIR' ) ) . '/bp-loader.php' ) && is_plugin_active_for_network( basename( constant( 'BUDDYBOSS_SAP_PLUGIN_DIR' ) ) . '/bp-user-blog.php' ) ) {
				$network_activated = TRUE;
			}
		}

		return $network_activated;
	}

if( !function_exists( 'buddyboss_bp_options_nav' ) ):
/**
 * Support legacy buddypress nav items manipulation
 */
function buddyboss_bp_options_nav( $component_index = false, $current_item = false ){
    $secondary_nav_items = false;

    $bp = buddypress();

    $version_compare = version_compare( BP_VERSION, '2.6', '<' );
    if ( $version_compare ){
        /**
         * @todo In future updates, remove the version compare check completely and get rid of legacy code
         */

        //legacy code
        $secondary_nav_items = isset( $bp->bp_options_nav[ $component_index ] ) ? $bp->bp_options_nav[ $component_index ] : false;
    } else {
        //new navigation apis

        // Default to the Members nav.
        if( !bp_is_single_item() ){
            $secondary_nav_items = $bp->members->nav->get_secondary( array( 'parent_slug' => $component_index ) );
        } else {
            $component_index =  $component_index ? $component_index : bp_current_component();
            $current_item = $current_item ? $current_item : bp_current_item();

            // If the nav is not defined by the parent component, look in the Members nav.
            if ( ! isset( $bp->{$component_index}->nav ) ) {
                $secondary_nav_items = $bp->members->nav->get_secondary( array( 'parent_slug' => $current_item ) );
            } else {
                $secondary_nav_items = $bp->{$component_index}->nav->get_secondary( array( 'parent_slug' => $current_item ) );
            }
        }
    }

    return $secondary_nav_items;
}
endif;

// BuddyPress Group Email Subscription support
if ( function_exists('ass_loader') ) {
	remove_action ( 'bp_directory_groups_actions', 'ass_group_subscribe_button' );
	add_action ( 'bb_after_group_content', 'ass_group_subscribe_button' );
}

//Search Form for Groups Manage Members Screens (Trac https://buddypress.trac.wordpress.org/ticket/6385)
add_action( 'bp_before_group_admin_form',    'onesocial_theme_group_manage_members_add_search', 5 );

/**
 * Add a search box to a single group's manage members screen.
 *
 * @since 2.7.0
 *
 * @return string HTML for the search form.
 */
function onesocial_theme_group_manage_members_add_search() {
	if ( bp_is_action_variable( 'manage-members' ) ) :

	//Remove legacy search box to a single group's manage members screen.
	remove_action( 'bp_before_group_admin_form', 'bp_legacy_theme_group_manage_members_add_search' );
	?>
	<div id="members-dir-search" class="dir-search no-ajax boss-search-wrapper" role="search">
		<?php bp_directory_members_search_form(); ?>
	</div>
	<?php
endif;
}