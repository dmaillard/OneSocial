<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to buddyboss_comment() which is
 * located in the functions.php file.
 *
 * @package WordPress
 * @subpackage OneSocial Theme
 * @since OneSocial Theme 1.0.0
 */
/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>

<?php if ( comments_open() || have_comments() ) : ?>

	<div id="comments" class="comments-area">
		<div class="inner">
			<?php
			$user			 = wp_get_current_user();
			$user_identity	 = $user->exists() ? $user->display_name : '';

			$buttons = '<div class="boss-insert-buttons">
				<a class="boss-insert-buttons-show" href="#">+</a>
				<ul class="boss-insert-buttons-addons">
					<li><a class="boss-insert-image"><i class="bb-icon-camera"></i></a></li>
					<li><a data-placeholder="' . __( 'Write a response...', 'onesocial' ) . '" class="boss-insert-text"><i class="bb-icon-pencil-square-o"></i></a></li>
				</ul>
			</div>';
			?>

			<h3 class="comments-title"><?php _e( 'Responses', 'onesocial' ); ?></h3>

			<?php
			$args	 = array(
				'title_reply'			 => '',
				'logged_in_as'			 => '',
				'comment_notes_after'	 => '',
				'comment_field'			 => '<div class="comment-form-comment">' . $buttons . '<span class="bb-user-name">' . $user_identity . '</span><textarea id="comment" name="comment" cols="45" rows="2" aria-required="true" required="required" placeholder="' . __( 'Write a response...', 'onesocial' ) . '"></textarea></div>',
				'label_submit'			 => __( 'Comment', 'onesocial' )
			);
			?>
			<?php
			//if ( is_user_logged_in() ) {
				comment_form( $args );
			//}
			?>

			<?php if ( have_comments() ) : ?>

				<ol class="commentlist">
					<?php wp_list_comments( array( 'callback' => 'buddyboss_comment', 'style' => 'ol' ) ); ?>
				</ol><!-- .commentlist -->

				<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through  ?>
					<nav id="comment-nav-below" class="navigation" role="navigation">
						<h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'onesocial' ); ?></h1>
						<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'onesocial' ) ); ?></div>
						<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'onesocial' ) ); ?></div>
					</nav>
				<?php endif; // check for comment navigation  ?>

				<?php
				/* If there are no comments and comments are closed, let's leave a note.
				 * But we only want the note on posts and pages that had comments in the first place.
				 */
				if ( !comments_open() && get_comments_number() ) :
					?>
					<p class="nocomments"><?php _e( 'Comments are closed.', 'onesocial' ); ?></p>
				<?php endif; ?>

			<?php endif; // have_comments() ?>

		</div><!-- /.inner -->

	</div><!-- #comments .comments-area -->

	<?php
endif; // comments_open() ?>