<?php
/**
 * @package OneSocial Theme
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <header class="entry-header">

		<?php
		if ( is_single() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
		} else {
			the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
		}
		?>

        <div class="entry-meta">
			<?php buddyboss_entry_meta(); ?>
        </div><!-- .entry-meta -->

    </header><!-- .entry-header -->

    <div class="entry-content">
		<?php
		/* post thumbnail */
		if ( has_post_thumbnail() ) { ?>
			<a class="entry-post-thumbnail<?php echo $thumb_class; ?>" href="<?php the_permalink(); ?>"><?php
				the_post_thumbnail('post-thumb'); ?>
			</a><?php
		}
		?>
		
		<?php the_excerpt(); ?>

		<footer class="entry-meta">
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'onesocial' ), the_title_attribute( 'echo=0' ) ) ); ?>" class="read-more"><?php _e( 'Continue reading', 'onesocial' ); ?></a>
			<span class="sep"><?php _e( '.', 'onesocial' ) ?></span>
                        <span><?php echo boss_estimated_reading_time( get_the_content() ); ?></span>
			<a href="#" class="to-top bb-icon-arrow-top-f"></a>
		</footer><!-- .entry-meta -->

	</div>

</article>