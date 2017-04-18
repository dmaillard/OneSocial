<?php

function onesocial_ajax_pagination() {

	// Add code to index pages.
	if ( !is_singular() ) {

		$id	= $_POST[ 'id' ];
		$args = array(
			'p' => $id,
			'post_type' => 'post'
		);
		$posts					 = new WP_Query( $args );

		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) {
				$posts->the_post();
				?>
				<div class="article-outher">

					<div class="content-wrap">
						<?php get_template_part( 'template-parts/content', 'ajax' ); ?>
					</div>

					<?php get_template_part( 'template-parts/content', 'author' ); ?>

				</div>
				<?php
			}
		} else {
			echo 'null';
		}

		wp_reset_postdata();

		die();
	}
}

add_action( 'wp_ajax_nopriv_ajax_pagination', 'onesocial_ajax_pagination' );
add_action( 'wp_ajax_ajax_pagination', 'onesocial_ajax_pagination' );
