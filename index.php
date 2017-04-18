<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage OneSocial Theme
 */
get_header();
?>

<a href="#" id="trigger-sidebar" class="" title="<?php _e( 'Toggle Sidebar', 'onesocial' ); ?>">
	<span class="bb-side-icon" aria-hidden="true"></span>
</a>

<div class="home-inner-wrap">

	<div id="primary" class="site-content">

		<div id="content" role="main">

			<?php
			if ( is_home() && is_user_logged_in() && function_exists( 'buddyboss_sap' ) && onesocial_get_option('onesocial_adding_posts') ) {
				get_template_part( 'template-parts/create-post' );
			}
			?>

			<!-- Display blog posts -->
			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<div class="article-outher">

						<?php get_template_part( 'template-parts/content', 'author' ); ?>
						
						<div class="content-wrap">
							<?php get_template_part( 'template-parts/content', get_post_format() ); ?>
						</div>

					</div>

					<!-- /.article-outher -->

				<?php endwhile; ?>

				<div class="pagination-below">
					<?php buddyboss_pagination(); ?>
				</div>

			<?php else : ?>

				<?php get_template_part( 'template-parts/content', 'none' ); ?>

			<?php endif; // end have_posts() check     ?>

		</div><!-- #content -->

	</div><!-- #primary -->

	<?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>