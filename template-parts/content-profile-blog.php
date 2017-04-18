<?php
/**
 * @package OneSocial Theme
 */

global $post;
$post_content = $post->post_content;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="header-area">
		<?php
		$header_class = '';
        ?>
        <div class="formatted-box">
            <img src="<?php echo get_template_directory_uri(); ?>/images/empty-placeholder.png" alt="<?php the_title(); ?>" width="360" height="216" />

            <a class="formatted-content" href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'onesocial' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
                <?php
                    add_filter( 'excerpt_length', 'onesocial_custom_excerpt_length', 999 );
                    the_excerpt();
                    remove_filter( 'excerpt_length', 'onesocial_custom_excerpt_length', 999 );
                ?>
            </a>
        </div>

        <?php
		if ( has_post_thumbnail() ) {
			?>

			<a class="entry-post-thumbnail" href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'medium-thumb', array('class' => 'lazy-img') ) ?>
			</a>

		<?php } ?>
                <div class="sap-post-meta">
                    <div class="post-date alignleft"><?php echo get_the_date( 'M j, Y' ); ?></div>
                    <?php if (bp_displayed_user_id() == bp_loggedin_user_id() ) { ?>
                        <div class="sep alignleft"><?php echo ' &middot; '; ?></div><?php
                    } ?>
                    
                    <?php if(function_exists('sap_edit_post_link')): ?>
                    <div class="sap-post-edit-link alignleft"><?php sap_edit_post_link(); ?></div>
                    <?php endif; ?>

                </div>
                

		<!-- Title -->
		<header class="entry-header<?php echo $header_class; ?>">

			<!-- Search, Blog index, archives -->
			<?php if ( is_search() || is_archive() || is_home() || ( buddyboss_is_bp_active() && bp_is_user() ) ) : ?>

				<h2 class="entry-title">
					<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'onesocial' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h2>

				<!-- Single blog post -->
			<?php else : ?>

				<div class="table">
					<div class="table-cell">
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</div>
				</div>

			<?php endif; // is_single()    ?>

		</header><!-- .entry-header -->

	</div><!-- /.header-area -->

    <div class="entry-content entry-summary">

			<footer class="entry-meta">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'onesocial' ), the_title_attribute( 'echo=0' ) ) ); ?>" class="read-more"><?php _e( 'Continue reading', 'onesocial' ); ?></a>
				<span class="sep"><?php _e( '.', 'onesocial' ) ?></span>
				<span><?php echo boss_estimated_reading_time( $post_content ); ?></span>
				<a href="#" class="to-top bb-icon-arrow-top-f"></a>
			</footer><!-- .entry-meta -->

		</div><!-- .entry-content -->

</article>