<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage OneSocial Theme
 */
get_header();
?>

<div id="primary" class="site-content">

	<div id="content" role="main">

		<article id="post-0" class="post error404 no-results not-found">

			<header class="entry-header">
				<h1 class="entry-title"><?php _e( '404', 'onesocial' ); ?></h1>
				<p><?php _e( 'We’re sorry, We seem to have lost this page, but We don’t want to lose You.', 'onesocial' ); ?></p>
			</header>

			<div class="entry-content">
				<?php
				$args = array(
					'posts_per_page' => 3
				);

				$posts = new WP_Query( $args );

				if ( $posts->have_posts() ) :
					?>

					<div id="posts-carousel">

						<div class="clearfix bb-carousel-header">
							<h2 class="title"><?php _e( 'Latest Articles', 'onesocial' ); ?></h2>

							<span class="arrows">
								<a href="#" id="prev" class="bb-icon-chevron-left"></a>
								<a href="#" id="next" class="bb-icon-chevron-right"></a>
							</span>
						</div>

						<ul>
							<!-- Start the Loop -->
							<?php
							while ( $posts->have_posts() ) :
								$posts->the_post();
								?>
								<li>
									<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

										<div class="header-area">
											<?php
											$thumb_class	 = '';

											if ( has_post_thumbnail() ) :
												$thumb_class = ' category-thumb';
												$size		 = 'medium-thumb';
												?>

												<a class="entry-post-thumbnail<?php echo $thumb_class; ?>" href="<?php the_permalink(); ?>">
													<?php the_post_thumbnail( $size ); ?>
												</a>

											<?php endif; ?>

											<h3><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'onesocial' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
										</div>

										<footer class="entry-meta">
											<div class="about table">
												<div class="table-cell">
													<?php
													printf( '<a class="url fn n author" href="%1$s" title="%2$s" rel="author">%3$s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_attr( sprintf( __( 'View all posts by %s', 'onesocial' ), get_the_author() ) ), get_avatar( get_the_author_meta( 'ID' ), 75, '', get_the_author() )
													);
													?>
												</div>

												<div class="table-cell">
													<?php
													$categories_list = get_the_category_list( __( ', ', 'onesocial' ) );
													printf( __( 'In %s', 'onesocial' ), $categories_list );
													printf( '%1$s<a class="url fn n" href="%2$s" title="%3$s" rel="author">%4$s</a>', __( ', by ', 'onesocial' ), esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_attr( sprintf( __( 'View all posts by %s', 'onesocial' ), get_the_author() ) ), get_the_author()
													);
													printf( '<small><a href="%1$s" title="%2$s" rel="bookmark" class="entry-date"><time datetime="%3$s">%4$s</time></a></small>', esc_url( get_permalink() ), esc_attr( get_the_time() ), esc_attr( get_the_date( 'c' ) ), esc_html( get_the_date( 'M j' ) )
													);
													?>
												</div>
											</div>

											<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'onesocial' ), the_title_attribute( 'echo=0' ) ) ); ?>" class="read-more"><?php _e( 'Continue reading', 'onesocial' ); ?></a>
										</footer>

									</article>
								</li>
							<?php endwhile; ?>
						</ul>
					</div>

				<?php endif; ?>

			</div>

		</article>

	</div>

</div>

<?php
get_footer();