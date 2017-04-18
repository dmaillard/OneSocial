<?php

function onesocial_login_fonts() {
    // FontAwesome icon fonts. If browsing on a secure connection, use HTTPS.
	wp_register_style( 'fontawesome', "//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css", false, null );
	wp_enqueue_style( 'fontawesome' );
}
add_action( 'login_enqueue_scripts', 'onesocial_login_fonts' );

/**
 * Custom Login Logo and Helper scripts
 */
function onesocial_custom_login_scripts() {

	$show		 = onesocial_get_option( 'boss_custom_login' );
	$admin_logo	 = onesocial_get_option( 'admin_logo_option' );
	$logo_id	 = onesocial_get_option( 'boss_admin_login_logo', 'id' );
	$logo_img	 = wp_get_attachment_image_src( $logo_id, 'full' );

	// Logo styles updated for the best view
	if ( ! $show ) {
		return;
	} ?>

	<script>
        document.addEventListener("DOMContentLoaded", function(event) {
            document.getElementById("user_login").setAttribute( "placeholder", "Username" );
            document.getElementById("user_pass").setAttribute( "placeholder", "Password" );
        });
    </script>

	<?php

	if( 'image' == $admin_logo ) {
		$boss_wp_loginbox_width	 = 312;
		$boss_logo_url			 = $logo_img[ 0 ];
		$boss_logo_width		 = $logo_img[ 1 ];
		$boss_logo_height		 = $logo_img[ 2 ];

		if ( $boss_logo_width > $boss_wp_loginbox_width ) {
			$ratio					 = $boss_logo_height / $boss_logo_width;
			$boss_logo_height		 = ceil( $ratio * $boss_wp_loginbox_width );
			$boss_logo_width		 = $boss_wp_loginbox_width;
			$boss_background_size	 = 'contain';
		} else {
			$boss_background_size = 'auto';
		}

		echo '<style type="text/css">
				#login h1 a { background: url( ' . esc_url( $boss_logo_url ) . ' ) no-repeat 50% 0;
                background-size: ' . esc_attr( $boss_background_size ) . ';
				overflow: hidden;
				text-indent: -9999px;
				display: block;';

		if ( $boss_logo_width && $boss_logo_height ) {
			echo 'height: ' . esc_attr( $boss_logo_height ) . 'px;
					width: ' . esc_attr( $boss_logo_width ) . 'px;
					margin: 0 auto;
					padding: 0;
				}';
		}

		echo '</style>';
	}

	if( 'title' == $admin_logo ) {
		$title_font = onesocial_get_option( 'admin_site_title' );

		if ( empty ( $title_font ) ) {
			return;
		}

		$font_family = isset( $title_font[ 'font-family' ] ) ? $title_font[ 'font-family' ] : null;
		$font_size	 = isset( $title_font[ 'font-size' ] ) ? $title_font[ 'font-size' ] : null;
		$font_weight = isset( $title_font[ 'font-weight' ] ) ? $title_font[ 'font-weight' ] : '';
		$font_style	 = isset( $title_font[ 'font-style' ] ) ? $title_font[ 'font-style' ] : null;
		$color		 = onesocial_get_option( 'admin_site_title_color' );
		$subsets	 = ( isset( $title_font[ 'subsets' ] ) && $title_font[ 'subsets' ] ) ? '&amp;subset=' . $title_font[ 'subsets' ] : '';
		$google		 = $title_font[ 'google' ];

		if ( $google != 'false' && $font_family ) {
			$link = '//fonts.googleapis.com/css?family=' . urlencode( $font_family ) . $font_weight . $subsets;
			echo '<link href="' . $link . '" rel="stylesheet" type="text/css">';
		}

		if ( $font_family ) { ?>
			<style type="text/css">
				#login h1 a {
					width: auto;
					background: transparent;
					text-indent: 0;
					height: auto;

					<?php if ( $font_family ) { ?>
						font-family: <?php echo $font_family; ?>;
					<?php }

					if ( $font_size ) { ?>
						font-size: <?php echo $font_size; ?>;
					<?php }

					if ( $font_weight ) { ?>
						font-weight: <?php echo $font_weight; ?>;
					<?php }

					if ( $color ) { ?>
						color: <?php echo $color; ?>;
					<?php }

					if ( $font_style ) { ?>
						font-style: <?php echo $font_style; ?>;
					<?php } ?>
				}
			</style><?php
		}
	} ?>

	<style type="text/css">
		html {
			background: transparent;
		}

		input:-webkit-autofill {
			-webkit-box-shadow: 0 0 0px 1000px <?php echo esc_attr( onesocial_get_option( 'admin_screen_background_color' ) ); ?> inset !important;
		}

		.login #loginform {
			background: transparent;
			box-shadow: none;
			padding: 10px 0;
		}

		.wp-social-login-connect-with,
		#loginform label {
			color: <?php echo esc_attr( onesocial_get_option( 'admin_screen_text_color' ) ); ?>;
			font-size: 15px;
			font-weight: 600;
		}

		#loginform input[type=text],
		#loginform input[type=password] {
			background: <?php echo esc_attr( onesocial_get_option( 'admin_screen_background_color' ) ); ?> !important;
			font-size: 14px;
			border: 0;
			box-shadow: none;
			border-bottom: 1px solid rgba(0,0,0,0.1);
			padding: 15px 0;
			font-weight: 300;
			margin: 5px 0 35px;
		}

		#rememberme {
			border: 2px solid <?php echo esc_attr( onesocial_get_option( 'admin_screen_button_color' ) ); ?>;
			height: 16px;
			width: 16px;
			box-shadow: none !important;
		}

		#rememberme:focus {
			box-shadow: none !important;
		}

		#login form p.submit {
			clear: both;
			overflow: hidden;
		}

		input#wp-submit {
			display: block;
			width: 100%;
			border: 0;
			text-shadow: none;
			margin: 30px 0 0;
			padding: 0;
			text-transform: uppercase;
			border-radius: 50px;
			height: 40px;
			line-height: 40px;
		}

		#rememberme:checked:before {
			font-size: 25px;
			margin: -7px -6px;
			color: <?php echo esc_attr( onesocial_get_option( 'admin_screen_text_color' ) ); ?>;
		}

		body.login {
			background-color: <?php echo esc_attr( onesocial_get_option( 'admin_screen_background_color' ) ); ?> !important;
		}

		.login #nav,
		.login #backtoblog a,
		.login #nav a {
			color: <?php echo esc_attr( onesocial_get_option( 'admin_screen_text_color' ) ); ?> !important;
		}

		.login #backtoblog a:hover, .login #nav a:hover, .login h1 a:hover {
			color: <?php echo esc_attr( onesocial_get_option( 'admin_screen_button_color' ) ); ?> !important;
		}

		.login form .forgetmenot input[type="checkbox"]:checked + strong:before,
		#login form p.submit input {
			background-color: <?php echo esc_attr( onesocial_get_option( 'admin_screen_button_color' ) ); ?> !important;
			box-shadow: none;
		}

		body.login #backtoblog,
		body.login #nav {
			padding: 0;
		}

		::-webkit-input-placeholder { color: #999; }
		::-moz-placeholder { color: #999; } /* firefox 19+ */
		:-ms-input-placeholder { color: #999; } /* ie */
		input:-moz-placeholder { color: #999; }

		.wp-social-login-connect-with {
			font-weight: bold;
			font-size: 14px;
		}

		.wp-social-login-provider-list.wp-social-login-provider-list {
			padding: 15px 0 20px;
		}

		.wp-social-login-provider-list.wp-social-login-provider-list a {
			border-radius: 40px;
			color: #fff;
			display: inline-block;
			font-size: 14px;
			font-weight: 600;
			margin-bottom: 10px;
			height: 36px;
			width: 36px;
			line-height: 36px;
			margin-right: 4px;
			text-align: center;
			text-transform: uppercase;
		}

		.wp-social-login-provider-list img {
			display: none;
		}

		.wp-social-login-provider-list a:before {
			display: inline-block;
			font-family: "FontAwesome";
			font-size: 14px;
			font-style: normal;
			font-weight: normal;
			line-height: 1;
			text-align: center;
			text-decoration: inherit;
			text-rendering: auto;
			vertical-align: middle;
		}

		.wp-social-login-provider-facebook:before {
			content: "\f09a";
		}

		.wp-social-login-provider-google:before {
			content: "\f0d5";
		}

		.wp-social-login-provider-twitter:before {
			content: "\f099";
		}

		.wp-social-login-provider-wordpress:before {
			content: "\f19a";
		}

		.wp-social-login-provider-yahoo:before {
			content: "\f19e";
		}

		.wp-social-login-provider-linkedin:before {
			content: "\f0e1";
		}

		.wp-social-login-provider-instagram:before {
			content: "\f16d";
		}

		.wp-social-login-provider-reddit:before {
			content: "\f1a1";
		}

		.wp-social-login-provider-foursquare:before {
			content: "\f180";
		}

		.wp-social-login-provider-lastfm:before {
			content: "\f202";
		}

		.wp-social-login-provider-tumblr:before {
			content: "\f173";
		}

		.wp-social-login-provider-stackoverflow:before {
			content: "\f16c";
		}

		.wp-social-login-provider-github:before {
			content: "\f113";
		}

		.wp-social-login-provider-dribbble:before {
			content: "\f17d";
		}

		.wp-social-login-provider-500px:before {
			content: "\f26e";
		}

		.wp-social-login-provider-twitchtv:before {
			content: "\f1e8";
		}

		.wp-social-login-provider-odnoklassniki:before {
			content: "\f263";
		}

		.wp-social-login-provider-steam:before {
			content: "\f1b6";
		}


		.wp-social-login-provider-steam {
			background: #67c1f5;
		}

		.wp-social-login-provider-wordpress {
			background: #0087be;
		}

		.wp-social-login-provider-yahoo {
			background: #410093;
		}

		.wp-social-login-provider-linkedin {
			background: #0077b5;
		}

		.wp-social-login-provider-instagram {
			background: #3f729b;
		}

		.wp-social-login-provider-reddit {
			background: #ff4500;
		}

		.wp-social-login-provider-foursquare {
			background: #f94877;
		}

		.wp-social-login-provider-lastfm {
			background: #d51007;
		}

		.wp-social-login-provider-tumblr {
			background: #35465c;
		}

		.wp-social-login-provider-stackoverflow {
			background: #fe7a15;
		}

		.wp-social-login-provider-github {
			background: #4183c4;
		}

		.wp-social-login-provider-dribbble {
			background: #ea4c89;
		}

		.wp-social-login-provider-500px {
			background: #0099e5;
		}

		.wp-social-login-provider-twitchtv {
			background: #6441a5;
		}

		.wp-social-login-provider-odnoklassniki {
			background: #ed812b;
		}

		.wp-social-login-provider-pixelpin {
			background: #000;
		}

		.wp-social-login-provider-live {
			background: #00bcf2;
		}

		.wp-social-login-provider-aol {
			background: #ff0b00;
		}

		.wp-social-login-provider-yandex {
			background: #ffcc00;
		}

		.wp-social-login-provider-mailru {
			background: #168de2;
		}

		.wp-social-login-provider-vkontakte {
			background: #45668e;
		}

		.wp-social-login-provider-mixi {
			background: #d1ad5a;
		}

		.wp-social-login-provider-skyrock {
			background: #009aff;
		}

		.wp-social-login-provider-goodreads {
			background: #553b08;
		}

		.wp-social-login-provider-disqus {
			background: #2e9fff;
		}

		.wp-social-login-provider-list a {
			margin-bottom: 10px;
		}

		.wp-social-login-provider-list a:hover {
			opacity: 0.8;
		}

		.wp-social-login-provider-list a:after {
			content: attr(title);
			font-size: 14px;
			text-transform: none;
			font-weight: 300;
			display: none;
		}

		.wp-social-login-provider-list {
			padding: 0;
		}

		.wp-social-login-provider-facebook {
			background-color: #3b5998;
		}

		.wp-social-login-provider-google {
			background-color: #d34836;
		}

		.wp-social-login-provider-twitter {
			background-color: #55acee;
		}

	</style>

	<?php
}

add_action( 'login_head', 'onesocial_custom_login_scripts', 9996 );
