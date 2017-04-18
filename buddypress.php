<?php
/**
 * The template for displaying BuddyPress content.
 *
 * @package WordPress
 * @subpackage OneSocial Theme
 * @since OneSocial Theme 1.0.0
 */
get_header();
?>

<div id="primary" class="site-content">


	<?php
	/**
	 * The template used for displaying page content in page.php
	 *
	 * @package WordPress
	 * @subpackage OneSocial Theme
	 * @since OneSocial Theme 1.0.0
	 */
	?>

	<?php
	/**
	 * Get page title & content
	 */
	global $bp;

	$custom_title	 = $custom_content	 = false;

	$bp_title = get_the_title();

	if ( bp_is_directory() ) {
		foreach ( (array) $bp->pages as $page_key => $bp_page ) {
			if ( is_page( $page_key ) ) {
				$page_id = $bp_page->id;

				$page_query = new WP_query( array(
					'post_type'	 => 'page',
					'page_id'	 => $page_id
				) );

				while ( $page_query->have_posts() ) {
					$page_query->the_post();

					$custom_title	 = get_the_title();
					$custom_content	 = wpautop( get_the_content() );
				}

				wp_reset_postdata();
			}
		}

		$pattern = '/([\s]*|&nbsp;)<a/im';

		// If we have a custom title and need to grab a BP title button
		if ( $custom_title != false && (int) preg_match( $pattern, $bp_title ) > 0 ) {
			$token = md5( '#b#u#d#d#y#b#o#s#s#' );

			$bp_title_parsed = preg_replace( $pattern, $token, $bp_title );
			$bp_title_parts	 = explode( $token, $bp_title_parsed, 2 );

			$custom_title .= '&nbsp;<a' . $bp_title_parts[ 1 ];
		}
	}

	// Fall back to BP generated title if we didn't grab a custom one above
	if ( !$custom_title ) {
		$custom_title = $bp_title;
	}
	?>

	<?php $activity_dir	 = ( bp_is_current_component( 'activity' ) && !bp_is_user() ) ? true : false; ?>
	<?php $members_dir	 = ( bp_is_current_component( 'members' ) && !bp_is_user() ) ? true : false; ?>
	<?php $blogs_dir		 = ( bp_is_blogs_component() ) ? true : false; ?>
	<?php $groups_dir		 = ( bp_is_current_component( 'groups' ) && !bp_is_group() && !bp_is_user() ) ? true : false; ?>
	<?php $blog_create	 = (is_multisite() && bp_is_blogs_component() && bp_is_current_action( 'create' )); ?>

	<?php if ( !bp_is_group() && !bp_is_user() && !$blog_create ): ?>
		<header class="entry-header buddypress <?php echo ($members_dir) ? 'members-dir-header dir-header' : ''; ?><?php echo ($groups_dir) ? 'groups-dir-header dir-header' : ''; ?><?php echo ($activity_dir) ? 'activity-dir-header dir-header' : ''; ?><?php echo ($blogs_dir) ? 'blogs-dir-header dir-header' : ''; ?>">
			<h1 class="entry-title">
				<?php
				if ( $members_dir ) {
					echo '<span class="bb-count">' . bp_get_total_member_count() . '</span>';
				} elseif ( $groups_dir ) {
					echo '<span class="bb-count">' . bp_get_total_group_count() . '</span>';
				}

				echo $custom_title;
				?>
			</h1>
		</header>


		<div id="content" role="main" class="buddypress-content-wrap">

			<section class="buddypress-content">

				<?php while ( have_posts() ): the_post(); ?>
					<div class="entry-content">
						<?php
						if ( $custom_content ) {
							echo $custom_content;
						}

						the_content();
						?>
					</div><!-- .entry-content -->

					<footer class="entry-meta buddypress">
						<?php edit_post_link( __( 'Edit', 'onesocial' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-meta -->

					<?php comments_template( '', true ); ?>
				<?php endwhile; // end of the loop.    ?>

			</section>

			<?php get_sidebar( 'buddypress' ); ?>

		</div>
	<?php else: ?>

		<div id="content" role="main">
			<?php while ( have_posts() ): the_post(); ?>
				<div class="entry-content">
					<?php
					if ( $custom_content ) {
						echo $custom_content;
					}

					the_content();
					?>
				</div><!-- .entry-content -->

				<footer class="entry-meta buddypress">
					<?php edit_post_link( __( 'Edit', 'onesocial' ), '<span class="edit-link">', '</span>' ); ?>
				</footer><!-- .entry-meta -->

				<?php comments_template( '', true ); ?>
			<?php endwhile; // end of the loop.    ?>
		</div>

	<?php endif; ?>

</div>

<?php
get_footer();
