<?php
/*
* Visual Composer Elements
*/

add_action('init', 'onesocial_requireVcExtend',2);
onesocial_addShortcodes();


/**
 * Extend VC
 */
function onesocial_requireVcExtend(){
    
    /*** Slider ***/
    vc_map( array(
        "name" => "Slider",
        "base" => "slider",
        "category" => 'BuddyBoss',
        "icon" => "icon-buddyboss",
        "allowed_container_element" => 'vc_row',
        "params" => array(            
            array(
                'type' => 'param_group',
                'heading' => 'Slides',
                'param_name' => 'slides',
                'description' => 'Add features',
                'params' => array(
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Title",
                        "param_name" => "title"
                    ),                                                        
                    array(
                        "type" => "textarea",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Short Description",
                        "param_name" => "short_description"
                    ), 
                    array(
                        "type" => "attach_image",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Image",
                        "param_name" => "image"
                    ),  
                    array(
                        "type" => "vc_link",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Button 1",
                        "param_name" => "button1"
                    ),                    
                    array(
                        "type" => "vc_link",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Button 2",
                        "param_name" => "button2"
                    )
                )
            )
        )
    ) );   
    
    /*** Testimonials ***/
    vc_map( array(
        "name" => "Testimonials",
        "base" => "testimonials",
        "category" => 'BuddyBoss',
        "icon" => "icon-buddyboss",
        "allowed_container_element" => 'vc_row',
        "params" => array(            
            array(
                'type' => 'param_group',
                'heading' => 'Testimonial',
                'param_name' => 'testimonial_items',
                'description' => 'Add testimonials',
                'params' => array(                                                       
                    array(
                        "type" => "textarea",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Quote",
                        "param_name" => "quote",
                        "value" => "",
                        "description" => ""
                    ), 
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Author",
                        "param_name" => "author"
                    ),
                    array(
                        "type" => "attach_image",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Author Image",
                        "param_name" => "author_image"
                    ), 
                )
            )
        )
    ) );
    
    /*** Service ***/
    vc_map( array(
        "name" => "Service",
        "base" => "service",
        "category" => 'BuddyBoss',
        "icon" => "icon-buddyboss",
        "allowed_container_element" => 'vc_row',
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => "Title",
                "param_name" => "title"
            ),            
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => "Fontawesome Icon Class",
                "param_name" => "icon",
                "value" => "fa-bell"
            ),         
            array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => "Icon Color",
                "param_name" => "color",
                "value" => "#2fd2d1"
            ),
            array(
                "type" => "textarea_html",
                "holder" => "div",
                "class" => "",
                "heading" => "Description",
                "param_name" => "description",
                "value" => "",
                "description" => ""
            )
        )
    ) );
    
    /*** Blog Posts ***/
    vc_map( array(
        "name" => "Blog Posts",
        "base" => "blog_posts",
        "category" => 'BuddyBoss',
        "icon" => "icon-buddyboss",
        "allowed_container_element" => 'vc_row',
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => "Title",
                "param_name" => "title"
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => "Post Count",
                "param_name" => "count"
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => "Post IDs",
                "param_name" => "posts_in"
            )
        )
    ) );
        
    /*** Blog Posts ***/
    vc_map( array(
        "name" => "Blog Post",
        "base" => "blog_post",
        "category" => 'BuddyBoss',
        "icon" => "icon-buddyboss",
        "allowed_container_element" => 'vc_row',
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => "Post ID",
                "param_name" => "id"
            )
        )
    ) );
  
}

function onesocial_addShortcodes(){  
    
    /* Slider */
    if (!function_exists('slider')) {
        function slider($atts, $content = null) {
        
            $args = array(
                "slides"   => "",
            );

            extract(shortcode_atts($args, $atts));                 
            $slides = (array) vc_param_group_parse_atts( $slides );
            
            $el_start = '<li>';
            $el_end = '</li>';
            $slides_wrap_start = '<ul class="slides">';
            $slides_wrap_end = '</ul>';
            wp_enqueue_style( 'flexslider' );
            wp_enqueue_script( 'flexslider' );
            
            $type = ' wpb_flexslider flexslider_fade flexslider';
            $flex_fx = ' data-flex_fx="fade"';
            
            $interval = 7;
            
            $i = - 1;

            foreach ( $slides as $slide ) {
                $i ++;
                if ( $slide['image'] > 0 ) {
                    $post_thumbnail = wp_get_attachment_image( $slide['image'], 'large' );
                } 

                $slide_content = "\n" . '<div class="slide-content">';
                $slide_content .= "\n\t" . '<div class="table">';
                $slide_content .= "\n\t\t" . '<div class="table-cell">';
                $slide_content .= "\n\t\t\t" . '<h2>'.$slide['title'].'</h2>';
                $slide_content .= "\n\t\t\t" . '<p>'.$slide['short_description'].'</p>';
                $button1 = vc_build_link( $slide['button1'] );
                $button2 = vc_build_link( $slide['button2'] );
                if($button1['url']) {
                $slide_content .= "\n\t\t\t" . '<a href="'. $button1['url'] .'" class="button" target="' . $button1['target'] . '">' . trim($button1['title']) .'</a>';
                }
                if($button2['url']) {
                $slide_content .= "\n\t\t\t" . '<a href="'. $button2['url'] .'" class="button primary" target="' . $button2['target'] . '">' . trim($button2['title']) .'</a>';
                }
                $slide_content .= "\n\t\t" . '</div>';
                $slide_content .= "\n\t" . '</div>';
                $slide_content .= "\n" . '</div>';
                
                $gal_images .= $el_start . $post_thumbnail . $slide_content . $el_end;
            }
            $css_class = 'vc_column-inner onesocial-slider';
            $output .= "\n\t" . '<div class="' . $css_class . '">';
            $output .= "\n\t\t" . '<div class="wpb_wrapper">';
            $output .= '<div class="wpb_gallery_slides' . $type . '" data-interval="' . $interval . '"' . $flex_fx . '>' . $slides_wrap_start . $gal_images . $slides_wrap_end . '</div>';
            $output .= "\n\t\t" . '</div> ';
            $output .= "\n\t" . '</div> ';
            echo $output;
        }
    }

    add_shortcode('slider', 'slider');
    
    /* Service */
    if (!function_exists('service')) {

        function service($atts, $content = null) {
            $args = array(
                "title"     => "",
                "icon"     => "fa-bell",
                "color"     => "#2fd2d1",
                "description"   => ""
            );

            extract(shortcode_atts($args, $atts));
            
            ob_start();
            ?>
            <div class="onesocial-service">					
                <i class="fa <?php echo $icon; ?>" style="color: <?php echo $color; ?>"></i>
                <div class="service-content">
                    <h4 class="title"><?php echo $title; ?></h4>
                    <p><?php echo $description; ?></p>
                </div>
									
            </div>                         
            <?php
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }
    }
    add_shortcode('service', 'service'); 
    
    /* Blog Posts */
    if (!function_exists('blog_posts')) {

        function blog_posts($atts, $content = null) {

            $args = array(
                "title"     => "",
                "count"     => 3,
                "posts_in"     => ""
            );

            extract(shortcode_atts($args, $atts));
            
            ob_start();
            ?>
			<div class="onesocial-posts-carousel">
				<?php
				$query_args = array();
            
                if ( $posts_in != '' ) {
                    $query_args['post__in'] = explode( ",", $posts_in );
                }
        
                // Post teasers count
                if ( $count != '' && ! is_numeric( $count ) ) {
                    $count = - 1;
                }
                if ( $count != '' && is_numeric( $count ) ) {
                    $query_args['posts_per_page'] = $count;
                }

				$posts = new WP_Query( $query_args );

				if ( $posts->have_posts() ) :
					?>

					<div id="posts-carousel">

						<div class="clearfix bb-carousel-header">
							<h3 class="title"><?php echo $title; ?></h3>

							<span class="arrows">
								<a href="#" id="prev" class="bb-icon-chevron-left"></a>
								<a href="#" id="next" class="bb-icon-chevron-right"></a>
							</span>
						</div>

						<ul>
							<!-- Start the Loop -->
							<?php
                            $i = 0;
							while ( $posts->have_posts() ) :
								$posts->the_post();
                                if($i == 0) echo '<li>';
								?>
                                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                                    <div class="header-area">
                                        <?php
                                        $thumb_class	 = '';

                                        if ( has_post_thumbnail() ) :
                                            $thumb_class = 'category-thumb';
                                            $size		 = 'thumbnail';
                                            ?>

                                            <a class="<?php echo $thumb_class; ?>" href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail( $size ); ?>
                                            </a>

                                        <?php endif; ?>

                                        <?php
                                            printf( '<a href="%1$s" title="%2$s" rel="bookmark" class="entry-date"><i class="fa fa-calendar"></i><time datetime="%3$s">%4$s</time></a>',
                                                   esc_url( get_permalink() ), 
                                                   esc_attr( get_the_time() ), 
                                                   esc_attr( get_the_date( 'c' ) ), 
                                                   esc_html( get_the_date() )
                                            );
                                        ?>
                                        <h4><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'onesocial' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h4>

                                    </div>

                                </article>
								<?php  
                                    if($i == 1) echo '</li><!-- li -->';
                                    $i++;
                                    if($i == 2) $i = 0;
                                ?>
							<?php endwhile; ?>
							<?php if($i == 1) echo '</li><!-- li -->'; ?>
							<?php wp_reset_query(); ?>
						</ul>
					</div>

				<?php endif; ?>

			</div>                       
            <?php
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }
    }
    add_shortcode('blog_posts', 'blog_posts');    
    
    /* Blog Post */
    if (!function_exists('blog_post')) {

        function blog_post($atts, $content = null) {

            $args = array(
                "id"     => ""
            );

            extract(shortcode_atts($args, $atts));
            
            ob_start();
            
            global $post;
            $save_post = $post;
            $post = get_post( $id ); 
            ?>

            <article class="post-box">

                <?php
                if ( has_post_thumbnail() ) :
                    $thumb_class = 'category-thumb';
                    $size		 = 'medium-thumb';
                    ?>

                    <a class="<?php echo $thumb_class; ?>" href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail( $size ); ?>
                    </a>

                <?php endif; ?>
                <div class="entry-summary">
                    <?php
                        printf( '<a href="%1$s" title="%2$s" rel="bookmark" class="entry-date"><i class="fa fa-calendar"></i><time datetime="%3$s">%4$s</time></a>',
                               esc_url( get_permalink() ), 
                               esc_attr( get_the_time() ), 
                               esc_attr( get_the_date( 'c' ) ), 
                               esc_html( get_the_date() )
                        );
                    ?>
                    <h3><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'onesocial' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                    <p><?php the_excerpt(); ?></p>
                    <a class="button content-button" href="<?php the_permalink(); ?>">More</a>
                </div>
            </article>
                      
            <?php
            $post = $save_post;
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }
    }
    add_shortcode('blog_post', 'blog_post');  
    
    /* Testimonials */
    if (!function_exists('testimonials')) {

        function testimonials($atts, $content = null) {

            $args = array(
                "testimonial_items"   => "",
            );

            extract(shortcode_atts($args, $atts));
            $testimonials = (array) vc_param_group_parse_atts( $testimonial_items );
            ob_start();
            ?>

            <div class="testimonials-wrap">
                <!-- Teatimonials  -->
                <div class="testimonial-items">
                    <?php 
                    $authors = '';
                    $i = 1;
                    foreach ( $testimonials as $testimonial ) { 
                    ?>
                    <!-- Testimonial -->
                    <div class="testimonial" id="<?php echo $i; ?>">
                        <div>
                            <div class="quote">
                                <p>"<?php echo $testimonial['quote']; ?>"</p>
                            </div>
                            <span class="autor">
                                <?php echo $testimonial['author']; ?>
                            </span>
                        </div>
                    </div>
                    <!-- Testimonial -->
                    <?php 
                        if ( $testimonial['author_image'] > 0 ) {
                            $post_thumbnail = wp_get_attachment_image( $testimonial['author_image'], 'thumbnail' );
                        } 
                        $authors .= 
                        '<li>
                            <span data-id="'.$i.'">
                                '.$post_thumbnail.'
                            </span>
                        </li>';
                        $i++;
                    ?>
                    <?php } ?>
                </div>
                <!-- Testimonials -->

                <!-- Authors -->
                <ul class="author-images">
                    <?php echo $authors; ?>
                </ul>
                <!-- End Authors -->
            </div>
                      
            <?php
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }
    }
    add_shortcode('testimonials', 'testimonials');
}
            