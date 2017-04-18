<div class="bboss_ajax_search_item bboss_ajax_search_item_product">
	<a href="<?php echo esc_url(add_query_arg( array( 'no_frame' => '1' ), get_permalink() ));?>">
         <div class="item-avatar">
            <?php
            if ( has_post_thumbnail() ) {
                echo get_the_post_thumbnail( $product->id, array(70, 70) );
            } elseif ( wc_placeholder_img_src() ) {
                echo wc_placeholder_img( array(70, 70, 1) );
            }
            ?>
        </div>
		<div class="item">
			<div class="item-title"><?php the_title();?></div>
			<?php  
                $content = wp_strip_all_tags( do_shortcode( get_the_content() ) );
                $trimmed_content = wp_trim_words( $content, 20, '...' ); 
            ?>
			<div class="item-desc"><?php echo $trimmed_content; ?></div>
       
		</div>
	</a>
</div>