<?php 
$style = onesocial_get_option('onesocial_footer'); 
$show_copyright	 = onesocial_get_option( 'footer_copyright_content' );
$copyright		 = onesocial_get_option( 'boss_copyright' );
$switch_button = onesocial_get_option( 'boss_layout_switcher' );
?>

<?php if ( 
    ( 
      'footer-style-1' == $style && 
      ( is_active_sidebar('footer-1') 
      || is_active_sidebar('footer-2') 
      || is_active_sidebar('footer-3') 
      || is_active_sidebar('footer-4') 
        )
     ) 
|| 
    'footer-style-2' == $style &&
    ( is_active_sidebar('footer-1') 
      || is_active_sidebar('footer-2') 
      || is_active_sidebar('footer-3') 
      || is_active_sidebar('footer-4') 
      || ($show_copyright && $copyright)
      || ( onesocial_get_option( 'boss_layout_switcher' ) )
    )

     ) : ?>


<div class="footer-inner-top">

    <div class="footer-inner widget-area">
        
        <?php if ( 'footer-style-2' == $style && ( ($show_copyright && $copyright) || $switch_button )) : ?>
            <div class="footer-widget">
				
				<div class="widget"><?php

					if ( $show_copyright && $copyright ) { ?>
						<div class="site-credits">
							<?php echo $copyright; ?>
						</div><?php
					}

					// Social Links
					get_template_part( 'template-parts/footer-social-links' );

					if ( $switch_button ) { ?>
						<form id="switch-mode" name="switch-mode" method="post" action="">
							<input type="submit" value="View as Desktop" tabindex="1" id="switch_submit" name="submit" />
							<input type="hidden" id="switch_mode" name="switch_mode" value="desktop" />
							<?php wp_nonce_field( 'switcher_action', 'switcher_nonce_field' ); ?>
						</form><?php
					} ?>

				</div>

            </div><!-- .footer-widget -->

        <?php endif; ?>

        <?php if ( 'footer-style-2' == $style && has_nav_menu( 'secondary-menu' ) ) : ?>
            <div class="footer-widget">
                <?php 
                $menu_locations = (array) get_nav_menu_locations();
                $menu = get_term_by( 'id', (int) $menu_locations[ 'secondary-menu' ], 'nav_menu', ARRAY_A );
                ?>
                <aside class="widget">
                    <?php if(!empty($menu[ 'name' ])): ?>
                    <h4 class="widgettitle"><?php echo $menu[ 'name' ]; ?></h4>
                    <?php endif; ?>
                    <ul>
                        <?php wp_nav_menu( array( 'container' => false, 'menu_id' => 'nav', 'theme_location' => 'secondary-menu', 'items_wrap' => '%3$s', 'depth' => 1, ) ); ?>
                    </ul>
                </aside>
            </div><!-- .footer-widget -->
        <?php endif; ?>
        
        <?php if ( is_active_sidebar('footer-1') ) : ?>
            <div class="footer-widget">
                <?php dynamic_sidebar( 'footer-1' ); ?>
            </div><!-- .footer-widget -->
        <?php endif; ?>
        
        <?php if ( is_active_sidebar('footer-2') ) : ?>
            <div class="footer-widget">
                <?php dynamic_sidebar( 'footer-2' ); ?>
            </div><!-- .footer-widget -->
        <?php endif; ?>

        <?php if ( is_active_sidebar('footer-3') ) : ?>
            <div class="footer-widget">
                <?php dynamic_sidebar( 'footer-3' ); ?>
            </div><!-- .footer-widget -->
        <?php endif; ?>

        <?php if ( is_active_sidebar('footer-4') ) : ?>
            <div class="footer-widget">
                <?php dynamic_sidebar( 'footer-4' ); ?>
            </div><!-- .footer-widget -->
        <?php endif; ?>

    </div><!-- .footer-inner -->

</div><!-- .footer-inner-top -->

<?php endif;