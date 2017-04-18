<?php
/**
 * The sidebar containing the widget area for WordPress blog posts and pages.
 *
 * @package WordPress
 * @subpackage OneSocial Theme
 * @since OneSocial Theme 1.0.0
 */

$show_sidebar = apply_filters('onesocial_show_page_sidebar', true );

if($show_sidebar) {
    if( is_active_sidebar( 'search' ) && is_search() ) { ?>

        <div id="secondary" class="widget-area" role="complementary">
            <?php dynamic_sidebar( 'search' ); ?>	
        </div><?php

    } elseif ( is_active_sidebar( 'home-sidebar' ) && is_front_page() ) { ?>

        <div id="secondary" class="widget-area" role="complementary">
            <?php dynamic_sidebar( 'home-sidebar' ); ?>	
        </div><?php

    } elseif ( is_active_sidebar( 'sidebar' ) && !is_front_page() && ! is_search() ) { ?>

        <div id="secondary" class="widget-area" role="complementary">
            <?php dynamic_sidebar( 'sidebar' ); ?>	
        </div><?php

    }
}