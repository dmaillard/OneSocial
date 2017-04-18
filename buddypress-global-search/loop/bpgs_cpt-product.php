<?php 
    global $BUDDYBOSS_BM;
    if($BUDDYBOSS_BM): 
        wc_get_template_part( 'content', 'product' ); 
    else:
?>
<li class="bboss_search_item bboss_search_item_post">

	<div class="article-outher">

		<div class="content-wrap">

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<div class="header-area">
					<?php
					$header_class = '';

					if ( has_post_thumbnail() ) {
						$thumb_class	 = '';
						$header_class	 = ' has-image';
						$size			 = 'full';

						if ( !is_single() ) {
							$thumb_class = ' category-thumb';
							$size		 = 'post-thumb';
						}
						?>

						<a class="entry-post-thumbnail<?php echo $thumb_class; ?>" href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail( $size ); ?>
						</a>

					<?php } ?>

					<div class="profile-visible"><?php echo get_the_date( 'M j' ); ?></div>

					<!-- Title -->
					<header class="entry-header<?php echo $header_class; ?>">

						<h2 class="entry-title">
							<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'onesocial' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
						</h2>

					</header><!-- .entry-header -->

				</div><!-- /.header-area -->

				<div class="entry-content entry-summary">

					<?php
					global $post;
					$post_content = $post->post_content;
					?>

					<?php the_excerpt(); ?>


				</div><!-- .entry-content -->

			</article><!-- #post -->


		</div>

		<?php get_template_part( 'template-parts/content', 'author' ); ?>

	</div>


</li>
<?php endif; ?>