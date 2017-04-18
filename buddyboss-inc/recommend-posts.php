<?php
/*
 * Recommend Posts
 */

if ( function_exists( 'buddyboss_sap' ) ) {

	$recommend_post = buddyboss_sap()->option( 'recommend_post' );

	if ( $recommend_post != 'on' ) {
		return;
	}
}

/**
 * Register JS
 */
if ( !function_exists( 'sl_enqueue_scripts' ) ) {

	function sl_enqueue_scripts() {
		wp_enqueue_script( 'sap-recommend-it', get_template_directory_uri() . '/js/recommend-it.js', array( 'jquery' ), '0.5', true );
		wp_localize_script( 'sap-recommend-it', 'recommendPost', array(
			'ajaxurl'	 => admin_url( 'admin-ajax.php' ),
			'like'		 => __( 'Recommend this article', 'onesocial' ),
			'unlike'	 => __( 'Discourage recommendation', 'onesocial' )
		) );
	}

	add_action( 'wp_enqueue_scripts', 'sl_enqueue_scripts' );
}

/**
 * Processes like/unlike
 */
if ( !function_exists( 'process_simple_like' ) ) {

	function process_simple_like() {
		// Security
		$nonce = isset( $_REQUEST[ 'nonce' ] ) ? sanitize_text_field( $_REQUEST[ 'nonce' ] ) : 0;
		if ( !wp_verify_nonce( $nonce, 'simple-likes-nonce' ) ) {
			exit( __( 'Not permitted', 'onesocial' ) );
		}
		// Test if javascript is disabled
		$disabled	 = ( isset( $_REQUEST[ 'disabled' ] ) && $_REQUEST[ 'disabled' ] == true ) ? true : false;
		// Test if this is a comment
		$is_comment	 = ( isset( $_REQUEST[ 'is_comment' ] ) && $_REQUEST[ 'is_comment' ] == 1 ) ? 1 : 0;
		// Base variables
		$post_id	 = ( isset( $_REQUEST[ 'post_id' ] ) && is_numeric( $_REQUEST[ 'post_id' ] ) ) ? $_REQUEST[ 'post_id' ] : '';
		$result		 = array();
		$post_users	 = NULL;
		$like_count	 = 0;
		// Get plugin options
		if ( $post_id != '' ) {
			$count	 = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_comment_like_count", true ) : get_post_meta( $post_id, "_post_like_count", true ); // like count
			$count	 = ( isset( $count ) && is_numeric( $count ) ) ? $count : 0;
			if ( !already_liked( $post_id, $is_comment ) ) { // Like the post
				if ( is_user_logged_in() ) { // user is logged in
					$user_id	 = get_current_user_id();
					$post_users	 = post_user_likes( $user_id, $post_id, $is_comment );
					if ( $is_comment == 1 ) {
						// Update User & Comment
						$user_like_count = get_user_option( "_comment_like_count", $user_id );
						$user_like_count = ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
						update_user_option( $user_id, "_comment_like_count", ++$user_like_count );
						if ( $post_users ) {
							update_comment_meta( $post_id, "_user_comment_liked", $post_users );
						}
					} else {
						// Update User & Post
						$user_like_count = get_user_option( "_user_like_count", $user_id );
						$user_like_count = ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
						update_user_option( $user_id, "_user_like_count", ++$user_like_count );
						if ( $post_users ) {
							update_post_meta( $post_id, "_user_liked", $post_users );
						}
					}
				} else { // user is anonymous
					$user_ip	 = sl_get_ip();
					$post_users	 = post_ip_likes( $user_ip, $post_id, $is_comment );
					// Update Post
					if ( $post_users ) {
						if ( $is_comment == 1 ) {
							update_comment_meta( $post_id, "_user_comment_IP", $post_users );
						} else {
							update_post_meta( $post_id, "_user_IP", $post_users );
						}
					}
				}
				$like_count				 = ++$count;
				$response[ 'status' ]	 = "liked";
				$response[ 'icon' ]		 = get_liked_icon();

				// add activity
				add_recommended_activity( $user_id, $post_id );

			} else { // Unlike the post
				if ( is_user_logged_in() ) { // user is logged in
					$user_id	 = get_current_user_id();
					$post_users	 = post_user_likes( $user_id, $post_id, $is_comment );
					// Update User
					if ( $is_comment == 1 ) {
						$user_like_count = get_user_option( "_comment_like_count", $user_id );
						$user_like_count = ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
						if ( $user_like_count > 0 ) {
							update_user_option( $user_id, "_comment_like_count", --$user_like_count );
						}
					} else {
						$user_like_count = get_user_option( "_user_like_count", $user_id );
						$user_like_count = ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
						if ( $user_like_count > 0 ) {
							update_user_option( $user_id, '_user_like_count', --$user_like_count );
						}
					}
					// Update Post
					if ( $post_users ) {
						$uid_key = array_search( $user_id, $post_users );
						unset( $post_users[ $uid_key ] );
						if ( $is_comment == 1 ) {
							update_comment_meta( $post_id, "_user_comment_liked", $post_users );
						} else {
							update_post_meta( $post_id, "_user_liked", $post_users );
						}
					}
				} else { // user is anonymous
					$user_ip	 = sl_get_ip();
					$post_users	 = post_ip_likes( $user_ip, $post_id, $is_comment );
					// Update Post
					if ( $post_users ) {
						$uip_key = array_search( $user_ip, $post_users );
						unset( $post_users[ $uip_key ] );
						if ( $is_comment == 1 ) {
							update_comment_meta( $post_id, "_user_comment_IP", $post_users );
						} else {
							update_post_meta( $post_id, "_user_IP", $post_users );
						}
					}
				}
				$like_count				 = ( $count > 0 ) ? --$count : 0; // Prevent negative number
				$response[ 'status' ]	 = "unliked";
				$response[ 'icon' ]		 = get_unliked_icon();
			}
			if ( $is_comment == 1 ) {
				update_comment_meta( $post_id, "_comment_like_count", $like_count );
				update_comment_meta( $post_id, "_comment_like_modified", date( 'Y-m-d H:i:s' ) );
			} else {
				update_post_meta( $post_id, "_post_like_count", $like_count );
				update_post_meta( $post_id, "_post_like_modified", date( 'Y-m-d H:i:s' ) );
			}

			$response[ 'count' ]	 = get_like_count( $like_count, $post_id );
			$response[ 'testing' ]	 = $is_comment;
			if ( $disabled == true ) {
				if ( $is_comment == 1 ) {
					wp_redirect( get_permalink( get_the_ID() ) );
					exit();
				} else {
					wp_redirect( get_permalink( $post_id ) );
					exit();
				}
			} else {
				wp_send_json( $response );
			}
		}
	}

	add_action( 'wp_ajax_nopriv_process_simple_like', 'process_simple_like' );
	add_action( 'wp_ajax_process_simple_like', 'process_simple_like' );
}

/**
 * user course start activity
 */
if ( !function_exists( 'add_recommended_activity' ) ) {

	function add_recommended_activity( $user_id, $post_id ) {
		global $bp;

		$user_link		 = bp_core_get_userlink( $user_id );
		$post_title		 = get_the_title( $post_id );
		$post_link		 = get_permalink( $post_id );
		$post_link_html	 = '<a href="' . esc_url( $post_link ) . '">' . $post_title . '</a>';

		$args = array(
			'type'		 => 'recommended_post_activity',
			'action'	 => apply_filters( 'onesocial_user_recommended_activity', sprintf( __( '%1$s recommended the post %2$s', 'onesocial' ), $user_link, $post_link_html ), $user_id, $post_id ),
			'item_id'	 => $post_id,
			'component'	 => $bp->profile->id,
		);

		$activity_recorded = onesocial_record_activity( $args );

		return $activity_recorded;
	}

}

/**
 * Record an activity item
 */
if ( !function_exists( 'onesocial_record_activity' ) ) {

	function onesocial_record_activity( $args = '' ) {
		global $bp;

		if ( !function_exists( 'bp_activity_add' ) )
			return false;

		$defaults = array(
			'id'				 => false,
			'user_id'			 => $bp->loggedin_user->id,
			'action'			 => '',
			'content'			 => '',
			'primary_link'		 => '',
			'component'			 => $bp->profile->id,
			'type'				 => false,
			'item_id'			 => false,
			'secondary_item_id'	 => false,
			'recorded_time'		 => gmdate( "Y-m-d H:i:s" ),
			'hide_sitewide'		 => false
		);

		$r = wp_parse_args( $args, $defaults );
		extract( $r );

		$activity_id = bp_activity_add( array(
			'id'				 => $id,
			'user_id'			 => $user_id,
			'action'			 => $action,
			'content'			 => $content,
			'primary_link'		 => $primary_link,
			'component'			 => $component,
			'type'				 => $type,
			'item_id'			 => $item_id,
			'secondary_item_id'	 => $secondary_item_id,
			'recorded_time'		 => $recorded_time,
		) );

		return $activity_id;
	}

}

/**
 * Utility to test if the post is already liked
 */
if ( !function_exists( 'already_liked' ) ) {

	function already_liked( $post_id, $is_comment ) {
		$post_users	 = NULL;
		$user_id	 = NULL;
		if ( is_user_logged_in() ) { // user is logged in
			$user_id		 = get_current_user_id();
			$post_meta_users = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_user_comment_liked" ) : get_post_meta( $post_id, "_user_liked" );
			if ( count( $post_meta_users ) != 0 ) {
				$post_users = $post_meta_users[ 0 ];
			}
		} else { // user is anonymous
			$user_id		 = sl_get_ip();
			$post_meta_users = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_user_comment_IP" ) : get_post_meta( $post_id, "_user_IP" );
			if ( count( $post_meta_users ) != 0 ) { // meta exists, set up values
				$post_users = $post_meta_users[ 0 ];
			}
		}
		if ( is_array( $post_users ) && in_array( $user_id, $post_users ) ) {
			return true;
		} else {
			return false;
		}
	}

}

/**
 * Output the like button
 */
if ( !function_exists( 'get_simple_likes_button' ) ) {

	function get_simple_likes_button( $post_id, $is_comment = NULL ) {
		$is_comment	 = ( NULL == $is_comment ) ? 0 : 1;
		$output		 = '';
		$nonce		 = wp_create_nonce( 'simple-likes-nonce' ); // Security

		if ( $is_comment == 1 ) {
			$post_id_class	 = esc_attr( ' sl-comment-button-' . $post_id );
			$comment_class	 = esc_attr( ' sl-comment' );
			$like_count		 = get_comment_meta( $post_id, "_comment_like_count", true );
			$like_count		 = ( isset( $like_count ) && is_numeric( $like_count ) ) ? $like_count : 0;
		} else {
			$post_id_class	 = esc_attr( ' sl-button-' . $post_id );
			$comment_class	 = esc_attr( '' );
			$like_count		 = get_post_meta( $post_id, "_post_like_count", true );
			$like_count		 = ( isset( $like_count ) && is_numeric( $like_count ) ) ? $like_count : 0;
		}

		$count		 = get_like_count( $like_count, $post_id );
		$icon_empty	 = get_unliked_icon();
		$icon_full	 = get_liked_icon();

		// Liked/Unliked Variables
		if ( already_liked( $post_id, $is_comment ) ) {
			$class	 = esc_attr( ' liked' );
			$title	 = __( 'Discourage recommendation', 'onesocial' );
			$icon	 = $icon_full;
		} else {
			$class	 = '';
			$title	 = __( 'Recommend this article', 'onesocial' );
			$icon	 = $icon_empty;
		}

		if ( is_user_logged_in() ) {
			$output = '<span class="sl-wrapper"><a href="' . admin_url( 'admin-ajax.php?action=process_simple_like' . '&nonce=' . $nonce . '&post_id=' . $post_id . '&disabled=true&is_comment=' . $is_comment ) . '" class="sl-button' . $post_id_class . $class . $comment_class . '" data-nonce="' . $nonce . '" data-post-id="' . $post_id . '" data-iscomment="' . $is_comment . '" title="' . $title . '">' . $icon . $count . '</a></span>';
		} else {
			$output = '<span class="sl-wrapper"><a href="#siteLoginBox" class="sl-button onesocial-login-popup-link" title="' . $title . '">' . $icon . $count . '</a></span>';
		}

		return $output;
	}

}

/**
 * Processes shortcode to manually add the button to posts.
 */
if ( !function_exists( 'sl_shortcode' ) ) {

	function sl_shortcode() {
		return get_simple_likes_button( get_the_ID(), 0 );
	}

	add_shortcode( 'recommend', 'sl_shortcode' );
}

/**
 * Utility retrieves post meta user likes (user id array), then adds new user id to retrieved array.
 */
if ( !function_exists( 'post_user_likes' ) ) {

	function post_user_likes( $user_id, $post_id, $is_comment ) {
		$post_users		 = '';
		$post_meta_users = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_user_comment_liked" ) : get_post_meta( $post_id, "_user_liked" );

		if ( count( $post_meta_users ) != 0 ) {
			$post_users = $post_meta_users[ 0 ];
		}

		if ( !is_array( $post_users ) ) {
			$post_users = array();
		}

		if ( !in_array( $user_id, $post_users ) ) {
			$post_users[ 'user-' . $user_id ] = $user_id;
		}

		return $post_users;
	}

}

/**
 * Utility retrieves post meta ip likes (ip array), then adds new ip to retrieved array.
 */
if ( !function_exists( 'post_ip_likes' ) ) {

	function post_ip_likes( $user_ip, $post_id, $is_comment ) {
		$post_users		 = '';
		$post_meta_users = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_user_comment_IP" ) : get_post_meta( $post_id, "_user_IP" );

		// Retrieve post information
		if ( count( $post_meta_users ) != 0 ) {
			$post_users = $post_meta_users[ 0 ];
		}

		if ( !is_array( $post_users ) ) {
			$post_users = array();
		}

		if ( !in_array( $user_ip, $post_users ) ) {
			$post_users[ 'ip-' . $user_ip ] = $user_ip;
		}

		return $post_users;
	}

}

/**
 * Utility to retrieve IP address
 */
if ( !function_exists( 'sl_get_ip' ) ) {

	function sl_get_ip() {

		if ( isset( $_SERVER[ 'HTTP_CLIENT_IP' ] ) && !empty( $_SERVER[ 'HTTP_CLIENT_IP' ] ) ) {
			$ip = $_SERVER[ 'HTTP_CLIENT_IP' ];
		} elseif ( isset( $_SERVER[ 'HTTP_X_FORWARDED_FOR' ] ) && !empty( $_SERVER[ 'HTTP_X_FORWARDED_FOR' ] ) ) {
			$ip = $_SERVER[ 'HTTP_X_FORWARDED_FOR' ];
		} else {
			$ip = ( isset( $_SERVER[ 'REMOTE_ADDR' ] ) ) ? $_SERVER[ 'REMOTE_ADDR' ] : '0.0.0.0';
		}

		$ip	 = filter_var( $ip, FILTER_VALIDATE_IP );
		$ip	 = ( $ip === false ) ? '0.0.0.0' : $ip;

		return $ip;
	}

}

/**
 * Utility returns the button icon for "like" action
 */
if ( !function_exists( 'get_liked_icon' ) ) {

	function get_liked_icon() {
		/* If already using Font Awesome with your theme, replace svg with: <i class="fa fa-heart"></i> */
		$icon = '<span class="sl-icon"><i class="fa fa-heart"></i></span>';
		return $icon;
	}

}

/**
 * Utility returns the button icon for "unlike" action.
 */
if ( !function_exists( 'get_unliked_icon' ) ) {

	function get_unliked_icon() {
		/* If already using Font Awesome with your theme, replace svg with: <i class="fa fa-heart-o"></i> */
		$icon = '<span class="sl-icon"><i class="fa fa-heart-o"></i></span>';
		return $icon;
	}

}

/**
 * Utility function to format the button count, appending "K" if one thousand or greater, "M" if one million or greater, and "B" if one billion or greater (unlikely).
 * $precision = how many decimal points to display (1.25K)
 */
if ( !function_exists( 'sl_format_count' ) ) {

	function sl_format_count( $number ) {
		$precision = 2;

		if ( $number >= 1000 && $number < 1000000 ) {
			$formatted = number_format( $number / 1000, $precision ) . 'K';
		} else if ( $number >= 1000000 && $number < 1000000000 ) {
			$formatted = number_format( $number / 1000000, $precision ) . 'M';
		} else if ( $number >= 1000000000 ) {
			$formatted = number_format( $number / 1000000000, $precision ) . 'B';
		} else {
			$formatted = $number; // Number is less than 1000
		}

		$formatted = str_replace( '.00', '', $formatted );
		return $formatted;
	}

}

/**
 * Utility retrieves count plus count options, returns appropriate format based on options.
 */
if ( !function_exists( 'get_like_count' ) ) {

	function get_like_count( $like_count, $post_id ) {
		$post_users		 = '';
		$post_meta_users = get_post_meta( $post_id, "_user_liked" );

		// Retrieve post information
		if ( count( $post_meta_users ) != 0 ) {
			$post_users = $post_meta_users[ 0 ];
		}

		if ( !is_array( $post_users ) ) {
			$post_users = array();
		}

		$like_text = __( '0', 'onesocial' );

		if ( is_numeric( $like_count ) && $like_count > 0 ) {
			$number = sl_format_count( $like_count );
		} else {
			$number = $like_text;
		}

		$output		 = '';
		$total_count = count( $post_users );

		if ( in_array( get_current_user_id(), $post_users ) ) {
			$output = '<span class="count-num">' . __( 'You', 'onesocial' ) . '</span>';

			if ( $total_count > 1 ) {
				$output = '<span class="count-num">' . __( 'You ', 'onesocial' ) . '</span>' . __( 'and ', 'onesocial' );
				if ( $total_count == 2 ) {
					$you_removed = array_diff( $post_users, array( get_current_user_id() ) );
					$user		 = get_user_by( 'id', array_shift( $you_removed ) );
					$output .= '<span class="user-name">' . $user->display_name . '</span>';
				} else {
					$without_you = $like_count - 1;
					if ( is_numeric( $without_you ) && $without_you > 0 ) {
						$number = sl_format_count( $without_you );
					} else {
						$number = 0;
					}

					$output .= '<span class="count-num">' . $number . '</span>' . _n( ' other', ' others', $without_you, 'onesocial' );
				}
			}

			$output .= __( ' recommended', 'onesocial' ) ;
		} else {
			if ( is_numeric( $like_count ) && $like_count > 0 ) {
				$number = sl_format_count( $like_count );
			} else {
				$number = 0;
			}

			$output = '<span class="count-num">' . $number . '</span>' . _n( ' recommendation', ' recommendations', $like_count, 'onesocial' );
		}

		$action_text = __( 'Recommended', 'onesocial' );

		if ( $total_count == 0 ) {
			$action_text = __( 'Recommend', 'onesocial' );
		}

		$count = '<span class="sl-count"><span class="recommend-title">' . $action_text . '</span>' . $output . '</span>';
		return $count;
	}

}

/**
 * User Profile List
 */
if ( !function_exists( 'show_user_likes' ) ) {

	function show_user_likes( $user ) {
		?>
		<table class="form-table">
			<tr>
				<th><label for="user_likes"><?php _e( 'You Like:', 'onesocial' ); ?></label></th>
				<td>
					<?php
					$types		 = get_post_types( array( 'public' => true ) );
					$args		 = array(
						'numberposts'	 => -1,
						'post_type'		 => $types,
						'meta_query'	 => array(
							array(
								'key'		 => '_user_liked',
								'value'		 => $user->ID,
								'compare'	 => 'LIKE'
							)
						) );
					$sep		 = '';
					$like_query	 = new WP_Query( $args );
					if ( $like_query->have_posts() ) :
						?>
						<p>
							<?php
							while ( $like_query->have_posts() ) : $like_query->the_post();
								echo $sep;
								?><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
								<?php
								$sep = ' &middot; ';
							endwhile;
							?>
						</p>
					<?php else : ?>
						<p><?php _e( 'You do not like anything yet.', 'onesocial' ); ?></p>
					<?php
					endif;
					wp_reset_postdata();
					?>
				</td>
			</tr>
		</table>
		<?php
	}

	add_action( 'show_user_profile', 'show_user_likes' );
	add_action( 'edit_user_profile', 'show_user_likes' );
}


/**
 * User Profile Blog List
 */
if ( !function_exists( 'sap_posts_ajax_pagination' ) ) {

	function sap_posts_ajax_pagination() {

		$paged	 = $_POST[ 'paged' ];
		$sort	 = (isset( $_POST[ 'sort' ] )) ? $_POST[ 'sort' ] : 'latest';

		if ( $sort === 'recommended' ) {
			$query_args = array(
				'author'		 => bp_displayed_user_id(),
				'post_type'		 => 'post',
				'post_status'	 => 'publish',
				'meta_key'		 => '_post_like_count',
				'orderby'		 => 'meta_value_num',
				'order'			 => 'DESC',
				'paged'			 => $paged,
			);
		} else {
			$query_args = array(
				'author'		 => bp_displayed_user_id(),
				'post_type'		 => 'post',
				'post_status'	 => 'publish',
				'paged'			 => $paged,
			);
		}

		$posts = new WP_Query( $query_args );

		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) {
				$posts->the_post();
				sap_load_template_multiple_times( 'profile-blog-list' );
			}
		}

		wp_reset_postdata();

		die();
	}

	add_action( 'wp_ajax_sap_posts_pagination', 'sap_posts_ajax_pagination' );
	add_action( 'wp_ajax_nopriv_sap_posts_pagination', 'sap_posts_ajax_pagination' );
}