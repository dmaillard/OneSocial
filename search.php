<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage OneSocial Theme
 * @since OneSocial Theme 1.0.0
 */
get_header();
?>


<div id="primary" class="site-content">

	<header class="page-header dir-header">
		<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'onesocial' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
	</header>

	<div id="content" role="main" class="search-content-wrap">

		<section class="search-content">

			<?php if ( have_posts() ) : ?>

			<div class="search-content-inner">

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'template-parts/content', get_post_format() ); ?>
				<?php endwhile; ?>

			</div>

			<div class="pagination-below">
				<?php buddyboss_pagination(); ?>
			</div>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

		</section>

		<?php
		if ( is_active_sidebar( 'search' ) ) {
			get_sidebar();
		}
		?>

	</div>

</div>

<?php

get_footer();
