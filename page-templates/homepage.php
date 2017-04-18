<?php
/**
 * Template Name: Home Page Template
 *
 * Description: Use this page template for a page with VC plugin.
 *
 * @package WordPress
 * @subpackage OneSocial Theme
 * @since OneSocial 1.0.0
 */
get_header();
?>

<div id="primary" class="site-content">
    
	<div id="content" role="main">

		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/content', 'page' ); ?>
			<?php comments_template( '', true ); ?>
		<?php endwhile; // end of the loop.  ?>

	</div>

</div>

<?php
get_footer();