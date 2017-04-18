<?php
/**
 * The template for displaying BuddyBoss slides.
 * Slides post type is registered at /buddyboss-inc/buddyboss-slides/buddyboss-slides-loader.php
 *
 * @package WordPress
 * @subpackage OneSocial Theme
 * @since OneSocial 1.0.0
 */
?>	

<?php
$queryObject = new WP_Query( array( 'post_type' => 'buddyboss_slides', 'posts_per_page' => -1 ) ); 
// Check if we have posts from buddyboss_slides post type
if ($queryObject->have_posts()) { 
	?>

    <script type="text/javascript">
        jQuery(document).ready(function(){
            new fws2().init({
                unique     : "fwslider", // ID of the slider instance 
                
                duration   : "1000",  /* Slides Fade Speed (miliseconds) */
                hoverpause : "1",     /* Pause autoslide on mousehover, 0 - OFF, 1 - ON */
                pause      : "6000",  /* Autoslide pause between slides (miliseconds), 0 - OFF */
                arrows     : "1",     /* Show navigation Arrows, 0 - OFF, 1 - ON */
                bullets    : "0"      /* Show navigation Bullets, 0 - OFF, 1 - ON */
            });
        });
    </script>

	<div class="buddyboss_slides_container">

	    <div id="fwslider">
	        <div class="slider_container">

		    <?php
		    while ($queryObject->have_posts()) {
		        $queryObject->the_post();
		        ?>
	        
				<div class="slide"> 
						               
				    <?php the_post_thumbnail( 'buddyboss_slides' ); ?>

				    <div class="slide_content">
				        <div class="slide_content_wrap">
				            
				        	<!-- display Title -->
				            <h4 class="title"><?php the_title(); ?></h4>

							<!-- display Subtitle, if entered -->
				            <?php $subtitle = get_post_meta($post->ID, "_subtitle", true); ?>
					        <?php
					        if (!empty($subtitle)) {
					        echo '<p class="description">'.esc_html($subtitle).'</p>';
					        }
					        ?>

							<!-- display Learn More button, if entered -->
				            <?php $learnmore_text = get_post_meta($post->ID, "_text", true); ?>
				            <?php $learnmore_url = get_post_meta($post->ID, "_url", true); ?>
				            <?php $learnmore_target = get_post_meta($post->ID, '_target', true); ?>
					        
					        <?php if (!empty($learnmore_url) && !empty($learnmore_text)) : ?>
					        	<p class="readmore">
					        		<a href="<?php echo esc_url($learnmore_url); ?>" <?php if( $learnmore_target == "checked" ) { echo 'target="_blank"'; } ?> /><?php echo esc_html($learnmore_text); ?></a>
					        	</p>
					        <?php endif; ?>

				        </div>
				    </div>
				</div>
	        	        
		    <?php
		    }
		    ?>

	        </div><!-- /slider_container -->
	        <div class="timers"></div>
	        <div class="slidePrev"><span></span></div>
	        <div class="slideNext"><span></span></div>
	    </div><!-- /fwslider -->

	</div><!-- /slider_container -->

<?php
}
?>
