<?php

/**
 * OneSocial_Social_Links
 * @see WP_Widget
 */
class OneSocial_Social_Links extends WP_Widget {

	/**
	 * @since 2.8.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array( 'classname' => 'onesocial_social_links', 'description' => __( 'Social links that are set in Theme Options.', 'onesocial' ) );
		parent::__construct( 'social_links', __( 'OneSocial Social Links', 'onesocial' ), $widget_ops );
	}

	/**
	 * Outputs the content for the current widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current widget instance.
	 */
	public function widget( $args, $instance ) {

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', empty( $instance[ 'title' ] ) ? '' : $instance[ 'title' ], $instance, $this->id_base );

		echo $args[ 'before_widget' ];
		if ( !empty( $title ) ) {
			echo $args[ 'before_title' ] . $title . $args[ 'after_title' ];
		}
        
        $show_social_links	 = onesocial_get_option( 'footer_social_links' );
        $social_links		 = onesocial_get_option( 'boss_footer_social_links' );

        if ( $show_social_links && is_array( $social_links ) ) {
        ?>

        <ul class="social-icons">
            <?php
            foreach ( $social_links as $key => $link ) {
                if ( !empty( $link ) ) {
                    $href = ( $key == 'email' ) ? 'mailto:' . sanitize_email( $link ) : esc_url( $link );
                    ?>
                    <li>
                        <a class="link-<?php echo $key; ?>" title="<?php echo $key; ?>" href="<?php echo $href; ?>" target="_blank">
                            <?php if($key == 'google-plus') $key = __('google+', 'onesocial'); ?>
                            <span></span><i><?php echo $key; ?></i>
                        </a>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
                
        <?php
        }

		echo $args[ 'after_widget' ];
	}

	/**
	 * Handles updating settings for the current Text widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Settings to save or bool false to cancel saving.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance			 = $old_instance;
		$instance[ 'title' ] = sanitize_text_field( $new_instance[ 'title' ] );
		return $instance;
	}

	/**
	 * Outputs the Text widget settings form.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$instance	 = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title		 = sanitize_text_field( $instance[ 'title' ] );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'onesocial' ); ?></label>
			<input class="" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php
	}

}

/**
 * OneSocial_Profile_Widget
 * @see WP_Widget
 */
class OneSocial_Profile_Widget extends WP_Widget {

	/**
	 * @since 2.8.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array( 'classname' => 'profile_widget', 'description' => __( 'Shows user friends, followings and followers. Can be used only on profile page.', 'onesocial' ) );
		parent::__construct( 'profile_widget', __( 'OneSocial Profile', 'onesocial' ), $widget_ops );
	}

	/**
	 * Outputs the content for the current widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current widget instance.
	 */
	public function widget( $args, $instance ) {
		if ( !buddyboss_is_bp_active() || !bp_is_user() ) {
			return;
		}

		$is_friends = ! empty( $instance['friends'] ) ? '1' : '0';
		$is_followers = ! empty( $instance['followers'] ) ? '1' : '0';
		$is_followings = ! empty( $instance['followings'] ) ? '1' : '0';

		echo $args[ 'before_widget' ];
		?>

		<div id="item-header-content">

			<?php
			global $bp;
			if ( $bp->follow ) {
				$follow			 = BP_Follow::get_counts( bp_displayed_user_id() );
				$following_count = $follow[ 'following' ];
				$followers_count = $follow[ 'followers' ];
				if ( $following_count != 0 && $is_followings ) {
					?>
					<div class="info-group">
						<div class="bb-follow-title"><?php _e( 'Following', 'onesocial' ); ?><span><?php echo $follow[ 'following' ]; ?></span></div>
						<div class="filter-wrap">
							<span class="trigger-filter notactive"></span>
							<ul id="following-filter" class="members-list-filter">
								<li><a href="recently_active" id="default"><?php _e( 'Last Active', 'onesocial' ); ?></a></li>
								<li><a href="newest"><?php _e( 'Newest Registered', 'onesocial' ); ?></a></li>
								<li><a href="alphabetically"><?php _e( 'Alphabetical', 'onesocial' ); ?></a></li>
							</ul>
						</div>
						<div id="following-results" class="members-list-results"></div>
					</div><?php
				}
				if ( $followers_count != 0 && $is_followers ) {
					?>

					<div class="info-group">
						<div class="bb-follow-title"><?php _e( 'Followers', 'onesocial' ); ?><span><?php echo $follow[ 'followers' ]; ?></span></div>
						<div class="filter-wrap">
							<span class="trigger-filter notactive"></span>
							<ul id="followers-filter" class="members-list-filter">
								<li><a href="recently_active" id="default"><?php _e( 'Last Active', 'onesocial' ); ?></a></li>
								<li><a href="newest"><?php _e( 'Newest Registered', 'onesocial' ); ?></a></li>
								<li><a href="alphabetically"><?php _e( 'Alphabetical', 'onesocial' ); ?></a></li>
							</ul>
						</div>
						<div id="followers-results" class="members-list-results"></div>
					</div><?php
				}
			}

			if ( bp_is_active( 'friends' ) && $is_friends ) {
				$friends_count = BP_Friends_Friendship::total_friend_count( bp_displayed_user_id() );

				if ( $friends_count != 0 ) {
					?>
					<div class="info-group">
						<div class="bb-follow-title"><?php _e( 'Friends', 'onesocial' ); ?><span><?php echo BP_Friends_Friendship::total_friend_count( bp_displayed_user_id() ) ?></span></div>
						<div class="filter-wrap">
							<span class="trigger-filter notactive"></span>
							<ul id="friends-filter" class="members-list-filter">
								<li><a href="recently_active" id="default"><?php _e( 'Last Active', 'onesocial' ); ?></a></li>
								<li><a href="newest"><?php _e( 'Newest Registered', 'onesocial' ); ?></a></li>
								<li><a href="alphabetically"><?php _e( 'Alphabetical', 'onesocial' ); ?></a></li>
							</ul>
						</div>
						<div class="friends-results members-list-results"></div>
					</div>
					<?php
				}
			}
			?>
		</div>
		<?php
		echo $args[ 'after_widget' ];
	}

	/**
	 * Handles updating settings for the current Text widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Settings to save or bool false to cancel saving.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		//$new_instance = wp_parse_args( (array) $new_instance, array( 'friends' => 1, 'followers' => 1, 'followings' => 1) );
		$instance['friends'] = ! empty( $new_instance['friends'] );
		$instance['followers'] = ! empty( $new_instance['followers'] );
		$instance['followings'] = ! empty( $new_instance['followings'] );
		
		return $instance;
	}

	/**
	 * Outputs the Text widget settings form.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'friends' => 1, 'followers' => 1, 'followings' => 1) );
		$friends = isset( $instance['friends'] ) ? $instance['friends'] : 1;
		$followers = isset( $instance['followers'] ) ? $instance['followers'] : 1;
		$followings = isset( $instance['followings'] ) ? $instance['followings'] : 1;
		?>
		<p>
			<input class="checkbox" type="checkbox"<?php checked( $friends ); ?> id="<?php echo $this->get_field_id('friends'); ?>" name="<?php echo $this->get_field_name('friends'); ?>" /> <label for="<?php echo $this->get_field_id('friends'); ?>"><?php _e('Show friends', 'onesocial'); ?></label>
			<br/>

			<?php if ( class_exists( 'BP_Follow_Component' ) ) { ?>
				<input class="checkbox" type="checkbox"<?php checked( $followers ); ?> id="<?php echo $this->get_field_id('followers'); ?>" name="<?php echo $this->get_field_name('followers'); ?>" /> <label for="<?php echo $this->get_field_id('followers'); ?>"><?php _e('Show followers', 'onesocial'); ?></label>

				<br/>
				<input class="checkbox" type="checkbox"<?php checked( $followings ); ?> id="<?php echo $this->get_field_id('followings'); ?>" name="<?php echo $this->get_field_name('followings'); ?>" /> <label for="<?php echo $this->get_field_id('followings'); ?>"><?php _e('Show followings', 'onesocial'); ?></label>
			<?php } ?>
		</p>
		<?php
	}

}

/**
 * Registers all Custom Widgets
 */
function onesocial_custom_register_widgets() {
	register_widget( 'OneSocial_Profile_Widget' );
	register_widget( 'OneSocial_Social_Links' );
}

add_action( 'widgets_init', 'onesocial_custom_register_widgets' );
