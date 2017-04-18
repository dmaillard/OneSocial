<?php
/**
 * The template for displaying a "No posts found" message.
 *
 * @package WordPress
 * @subpackage OneSocial Theme
 */
?>

<article id="post-0" class="post no-results not-found">

	<?php
	// Show a different message to a logged-in user who can add posts.
	if ( current_user_can( 'edit_posts' ) ) :
		?>

		<h2 class="entry-title"><?php _e( 'No posts to display', 'onesocial' ); ?></h2>

		<div class="entry-content">
			<p><?php printf( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'onesocial' ), admin_url( 'post-new.php' ) ); ?></p>
		</div><!-- .entry-content -->

	<?php else : ?>

		<h2 class="entry-title"><?php _e( 'Nothing Found', 'onesocial' ); ?></h2>

		<div class="entry-content">
			<p><?php _e( 'Apologies, but no results were found.', 'onesocial' ); ?></p>
		</div>

	<?php endif; ?>

</article>