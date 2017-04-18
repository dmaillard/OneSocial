<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage OneSocial Theme
 * @since OneSocial Theme 1.0.0
 */
?>

<aside id="post-<?php the_ID(); ?>-author" class="post-author">

    <div class="author-details">
        <div class="author-top">

			<div class="author vcard">

				<?php
				$user_link = get_author_posts_url( get_the_author_meta( 'ID' ) );
				
				if( function_exists('bp_core_get_userlink') && !function_exists( 'buddyboss_sap' ) ) {
					$user_link = bp_core_get_userlink( get_the_author_meta( 'ID' ), false, true );
				}
				
				if( function_exists('bp_core_get_userlink') && function_exists( 'buddyboss_sap' ) ) {
					$user_link = bp_core_get_userlink( get_the_author_meta( 'ID' ), false, true ) . 'blog';
				}
				?>

				<a class="url fn n" href="<?php echo $user_link; ?>" title="<?php echo get_the_author(); ?>" rel="author">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 200, '', get_the_author() ); ?>
					<span class="name"><?php echo get_the_author(); ?></span>
				</a>

				<span class="post-date">
					<a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_time(); ?>" rel="bookmark" class="entry-date">
						<time datetime="<?php echo get_the_date( 'c' ); ?>"><?php echo get_the_date( 'M j' ); ?></time>
					</a>
				</span>
				
				<div class="load-more-posts">
					<i class="bb-icon-bars-f"></i>
					<a href="<?php echo get_the_author_meta( 'ID' ); ?>" data-sort="recommended" data-target="target-<?php the_ID(); ?>" data-sequence="500"><?php _e( 'Most recommended stories', 'onesocial' ); ?></a>
					<a href="<?php echo get_the_author_meta( 'ID' ); ?>" data-sort="latests" class="show-latest" data-target="target-<?php the_ID(); ?>" data-sequence="500"><?php _e( 'Latest stories', 'onesocial' ); ?></a>
				</div>
			</div>
        </div>

        <div class="author-middle">
			<?php
			if ( buddyboss_is_bp_active() ):
				global $bp;
				
				$bio_field = onesocial_get_option( 'boss_bio_field' );
				if ( $bio_field && function_exists( 'bp_get_profile_field_data' ) ) {
					$bio = bp_get_profile_field_data( array( 'field' => $bio_field, 'user_id' => get_the_author_meta( 'ID' ) ) );
					if ( $bio ) {
						?>
						<div class="author-bio"><?php echo onesocial_custom_excerpt( $bio, 15 ); ?></div>
						<?php
					}
				}

				$showing = null;
				//if bp-followers activated then show it.
				if ( function_exists( "bp_follow_add_follow_button" ) ) {
					$showing	 = "follows";
					$followers	 = bp_follow_total_follow_counts( array( "user_id" => get_the_author_meta( 'ID' ) ) );
				} elseif ( function_exists( "bp_add_friend_button" ) ) {
					$showing = "friends";
				}
				?>

				<ul class="author-stats">
					<?php if ( $showing == "follows" ):
						$following_link = bp_core_get_userlink( get_the_author_meta( 'ID' ), false, true ) . 'following';
						$followers_link = bp_core_get_userlink( get_the_author_meta( 'ID' ), false, true ) . 'followers';
						?>
						<li>
							<a href="<?php echo $following_link; ?>">
								<span><?php echo (int) $followers[ "following" ]; ?></span><?php _e( "Following", 'onesocial' ); ?>
							</a>
						</li>

						<li>
							<a href="<?php echo $followers_link; ?>">
								<span><?php echo (int) $followers[ "followers" ]; ?></span><?php _e( "Followers", 'onesocial' ); ?>
							</a>
						</li>
					<?php endif; ?>
					<?php if ( $showing == "friends" ):
						$friends_count = (int) friends_get_total_friend_count( get_the_author_meta( 'ID' ) );
						$friend_text = $friends_count == 1 ? 'Friend' : 'Friends';
						$friends_slug = isset( $bp->friends->slug ) ? $bp->friends->slug : '';

						if( function_exists('bp_core_get_userlink') && !empty($friends_slug) ) {
							$friends_link = bp_core_get_userlink( get_the_author_meta( 'ID' ), false, true ) . $friends_slug;
						}
						?>
						<li>
							<a href="<?php echo $friends_link; ?>">
								<span><?php echo $friends_count; ?></span><?php printf( esc_html__( '%s', 'onesocial' ), $friend_text ); ?>
							</a>
						</li>
					<?php endif; ?>
				</ul>
			<?php endif; ?>
        </div>
    </div>

	<?php
	if ( buddyboss_is_bp_active() && get_the_author_meta( 'ID' ) != get_current_user_id() ):
		if ( $showing == "follows" ) {
			?>
			<div class="author-follow">
				<?php
				$args = array(
					'leader_id' => get_the_author_meta( 'ID' )
				);

				if ( function_exists( "bp_follow_add_follow_button" ) ) {
					bp_follow_add_follow_button( $args );
				}
				?>

			</div><?php
		} elseif ( $showing == "friends" ) { ?>
			<div class="author-follow">
				<?php bp_add_friend_button( get_the_author_meta( 'ID' ) ); ?>
			</div><?php
		}
	endif;
	?>

</aside>