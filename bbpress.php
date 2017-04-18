<?php
/**
 * The template for displaying bbPress content.
 *
 * @package WordPress
 * @subpackage OneSocial Theme
 */
get_header();
?>

<div id="primary" class="site-content">

	<?php while ( have_posts() ) : the_post(); ?>
		<?php bbp_breadcrumb(); ?>

		<header class="entry-header">
			<h1 class="entry-title big"><?php the_title(); ?></h1>
		</header>

	<?php endwhile; // end of the loop. ?>

	<div id="content" role="main" class="buddypress-content-wrap">

		<section class="buddypress-content">

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'onesocial' ), 'after' => '</div>' ) ); ?>
					</div><!-- .entry-content -->

					<footer class="entry-meta"></footer><!-- .entry-meta -->

				</article><!-- #post -->

				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>

		</section>

		<?php get_sidebar( 'bbpress' ); ?>

	</div>

</div>

<?php
get_footer();