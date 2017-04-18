<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage OneSocial Theme
 * @since OneSocial Theme 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <!-- Search, Blog index, archives, Profile -->
	<?php if ( is_search() || is_archive() || is_home() ) : ?>

		<div class="posts-stream">
			<div class="loader"><?php _e( 'Loading...', 'onesocial' ); ?></div>
		</div>

	<?php endif; ?>

	<?php
	if ( !is_single() ) {
		?>

		<div class="header-area">
			<?php
			$header_class = '';

			if ( has_post_thumbnail() ) {
				$header_class = ' category-thumb';
				?>

				<a class="entry-post-thumbnail" href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail( 'post-thumb' ); ?>
				</a>

			<?php } ?>

			<div class="profile-visible"><?php echo get_the_date( 'M j' ); ?></div>

			<!-- Title -->
			<header class="entry-header<?php echo $header_class; ?>">

				<!-- Search, Blog index, archives -->
				<?php if ( is_search() || is_archive() || is_home() || ( buddyboss_is_bp_active() && bp_is_user() ) ) : ?>

					<h2 class="entry-title">
						<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'onesocial' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
					</h2>
					<!-- Single blog post -->
				<?php else : ?>

					<div class="table">
						<div class="table-cell">
							<h1 class="entry-title"><?php the_title(); ?></h1>
						</div>
					</div>

				<?php endif; // is_single()    ?>

			</header><!-- .entry-header -->

		</div><!-- /.header-area -->

	<?php } ?>

	<!-- Search, Blog index, archives, Profile -->
	<?php if ( is_search() || is_archive() || is_home() || ( buddyboss_is_bp_active() && bp_is_user() ) ) : // Only display Excerpts for Search, Blog index, Profile and archives    ?>

		<div class="entry-content entry-summary">

			<?php
			global $post;
			$post_content = $post->post_content;
			?>

			<?php the_excerpt(); ?>

			<footer class="entry-meta">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'onesocial' ), the_title_attribute( 'echo=0' ) ) ); ?>" class="read-more"><?php _e( 'Continue reading', 'onesocial' ); ?></a>
				<span class="sep"><?php _e( '.', 'onesocial' ) ?></span>
				<span><?php echo boss_estimated_reading_time( $post_content ); ?></span>
				<a href="#" class="to-top bb-icon-arrow-top-f"></a>
			</footer><!-- .entry-meta -->

		</div><!-- .entry-content -->

		<!-- all other templates -->
	<?php else : ?>
		<div class="entry-main">
			<div class="entry-content">
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'onesocial' ) ); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'onesocial' ), 'after' => '</div>' ) ); ?>
			</div><!-- .entry-content -->

			<footer class="entry-meta">
				<div class="row">
					<div class="entry-tags col">
						<?php
						$terms = wp_get_post_tags( get_the_ID() );
						if ( $terms ) {
							?>
							<h3><?php _e( 'Tagged in', 'onesocial' ); ?></h3><?php
							foreach ( $terms as $t ) {
								echo '<a href="' . get_tag_link( $t->term_id ) . '">' . $t->name . '<span>' . $t->count . '</span></a>';
							}
						}
						?>
					</div>

                                <?php if ( get_post_status(get_the_ID()) == 'publish' ) { ?>
					<!-- /.entry-tags -->
					<div class="entry-share col">
						<?php
						if ( function_exists( 'get_simple_likes_button' )  && is_singular( 'post' ) ) {
							echo get_simple_likes_button( get_the_ID() );
						}
						?>

						<ul class="helper-links">

							<?php if ( function_exists( 'sap_get_bookmark_button' ) && is_singular( 'post' ) && is_user_logged_in() ) { ?>
								<li>
									<?php
									$button = sap_get_bookmark_button();

									if ( !empty( $button ) ) {
										echo $button;
									} else {
										?>
										<a id="bookmarkme" href="#siteLoginBox" class="bookmark-it onesocial-login-popup-link">
											<span class="fa bb-helper-icon fa-bookmark-o"></span>
											<span><?php _e( 'Bookmark', 'onesocial' ); ?></span>
										</a><?php
									}
									?>
								</li>
							<?php } ?>

							<?php if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) { ?>
								<li>
									<?php ADDTOANY_SHARE_SAVE_KIT( array( 'use_current_page' => true ) ); ?>
								</li><?php
							}
							?>
						</ul>
					</div>
					<!-- /.entry-share -->
                                <?php } ?>
				</div>

				<?php //edit_post_link( __( 'Edit', 'onesocial' ), '<span class="edit-link">', '</span>' );    ?>

			</footer><!-- .entry-meta -->
		</div>
		<!-- /.entry-main -->

	<?php endif; ?>

</article><!-- #post -->

<?php if ( is_single() ): ?>
	<div class="post-author-info">
		<div class="container">
			<div class="inner">
				<?php
				$user_link = get_author_posts_url( get_the_author_meta( 'ID' ) );

				if ( function_exists( 'bp_core_get_userlink' ) && !function_exists( 'buddyboss_sap' ) ) {
					$user_link = bp_core_get_userlink( get_the_author_meta( 'ID' ), false, true );
				}

				if ( function_exists( 'bp_core_get_userlink' ) && function_exists( 'buddyboss_sap' ) ) {
					$user_link = bp_core_get_userlink( get_the_author_meta( 'ID' ), false, true ) . 'blog';
				}

				printf( '<span class="authors-avatar vcard table-cell"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>', $user_link, esc_attr( sprintf( __( 'View all posts by %s', 'onesocial' ), get_the_author() ) ), get_avatar( get_the_author_meta( 'ID' ), 85, '', get_the_author() ) );
				?>

				<div class="details table-cell">
					<?php
					printf( '<span class="author-name vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>', $user_link, esc_attr( sprintf( __( 'View all posts by %s', 'onesocial' ), get_the_author() ) ), get_the_author()
					);

					if ( buddyboss_is_bp_active() ):
						$bio_field = onesocial_get_option( 'boss_bio_field' );
						if ( $bio_field ) {
							$bio = bp_get_profile_field_data( array( 'field' => $bio_field, 'user_id' => get_the_author_meta( 'ID' ) ) );
							if ( $bio ) {
								?>
								<div class="author-bio"><?php echo onesocial_custom_excerpt( $bio, 15 ); ?></div>
								<?php
							}
						}
					endif;

					echo '<div class="entry-meta">';
					_e( 'Published', 'onesocial' );
					onesocial_entry_categories();
					_e( ' on ', 'onesocial' );
					onesocial_posted_on();
					echo '</div>';


					$current_user_id = get_current_user_id();
					$post_author_id	 = get_the_author_meta( 'ID' );

					if ( $current_user_id != $post_author_id ) {

						if ( buddyboss_is_bp_active() ):
							$showing = null;
							//if bp-followers activated then show it.
							if ( function_exists( "bp_follow_add_follow_button" ) ) {
								$showing	 = "follows";
								$followers	 = bp_follow_total_follow_counts( array( "user_id" => get_the_author_meta( 'ID' ) ) );
							} elseif ( function_exists( "bp_add_friend_button" ) ) {
								$showing = "friends";
							}
							?>
						<?php endif; ?>
						<div class="author-follow">
							<?php
							if ( buddyboss_is_bp_active() ):
								if ( $showing == "follows" ) {
									$args = array(
										'leader_id' => get_the_author_meta( 'ID' )
									);

									if ( function_exists( "bp_follow_add_follow_button" ) ) {
										bp_follow_add_follow_button( $args );
									}
								} elseif ( $showing == "friends" ) {
									bp_add_friend_button( get_the_author_meta( 'ID' ) );
								}
							endif;
							?>
						</div><!--.author-follow-->

					<?php } ?>

				</div><!--.details-->
			</div>
		</div>
	</div><!--.post-author-info-->
<?php endif; ?>