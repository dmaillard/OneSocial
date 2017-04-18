<?php
/**
 * @package WordPress
 * @subpackage OneSocial Theme
 * @since 3.0
 */

/**
 * Sets up a BuddyPress profile login widget to add to your sidebars.
 * BuddyPress must be activated for the widget to appear.
 */
class BuddyBossLoginWidget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'buddyboss-login-widget', 'description' => 'Displays BuddyPress login and profile info.' );
		parent::__construct( 'BuddyBossLoginWidget', '(BuddyBoss) Profile Login Widget', $widget_ops );
	}

	function form( $instance ) {
		$instance	 = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title		 = $instance[ 'title' ];
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></label></p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance			 = $old_instance;
		$instance[ 'title' ] = $new_instance[ 'title' ];
		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );

		echo $before_widget;

		// set widget title when logged out

		if ( !is_user_logged_in() ) :
			$title = empty( $instance[ 'title' ] ) ? '' : apply_filters( 'widget_title', $instance[ 'title' ] );

			if ( !empty( $title ) )
				echo $before_title . $title . $after_title;
		endif;

		// start widget display code

		if ( function_exists( 'bp_is_active' ) ) :
			// check is user is logged in
			if ( is_user_logged_in() ) :

				echo "<div id='sidebarme'>";
				echo "<a href='" . bp_loggedin_user_domain() . "'>";
				echo bp_loggedin_user_avatar( 'type=thumb' );
				echo "</a>";
				echo "<ul class='sidebarme-quicklinks'>";
				echo "<li class='sidebarme-username'>" . bp_core_get_userlink( bp_loggedin_user_id() ) . "</li>";
				echo "<li class='sidebarme-profile'>";
				echo "<a href='" . bp_loggedin_user_domain() . "profile/edit'>" . __( 'Edit Profile', 'onesocial' ) . "</a>";
				echo " &middot; ";
				echo wp_loginout();
				echo "</li>";
				echo "</ul>";
				echo "</div>";

			// check if user is logged out
			else :

				echo "<form name='login-form' id='sidebar-login-form' class='standard-form' action='" . site_url( 'wp-login.php', 'login_post' ) . "' method='post'>";
				echo "<label>" . __( 'Username', 'onesocial' ) . "</label>";
				$return = isset( $_POST[ 'value' ] ) ? $_POST[ 'value' ] : '';
				$return .= "<input type='text' name='log' id='sidebar-user-login' class='input' value='";
				if ( isset( $user_login ) ) {
					$return .= esc_attr( stripslashes( $user_login ) );
				}
				$return .="' tabindex='97' />";
				echo $return;

				echo "<label>" . __( 'Password', 'onesocial' ) . "</label>";
				echo "<input type='password' name='pwd' id='sidebar-user-pass' class='input' value='' tabindex='98' />";

				echo "<p class='forgetmenot'><input name='rememberme' type='checkbox' id='sidebar-rememberme' value='forever' tabindex='99' /> " . __( 'Remember Me', 'onesocial' ) . "</p>";

				echo do_action( 'bp_sidebar_login_form' );
				echo "<input type='submit' name='wp-submit' id='sidebar-wp-submit' value='" . __( 'Log In', 'onesocial' ) . "' tabindex='100' />";

				if ( bp_get_signup_allowed() ) {
					echo " <a class='sidebar-wp-register' href='" . bp_get_signup_page() . "'>" . __( 'Register', 'onesocial' ) . "</a>";
				}

				echo "</form>";

			endif;
		endif;

		// end widget display code

		echo $after_widget;
	}

}

add_action( 'widgets_init', create_function( '', 'return register_widget("BuddyBossLoginWidget");' ) );
