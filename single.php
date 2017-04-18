<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage OneSocial Theme
 * @since OneSocial Theme 1.0.0
 */
get_header();
?>

<div id="primary" class="site-content">
	<div id="content" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content', get_post_format() ); ?>

			<?php
                        $post_status = get_post_status(get_the_ID());
                        if ( 'publish' == $post_status || 'private' == $post_status ) {
                            comments_template( '', true );
                        } ?>

		<?php endwhile; // end of the loop. ?>

	</div><!-- #content -->
</div><!-- #primary -->

<?php
get_footer();
