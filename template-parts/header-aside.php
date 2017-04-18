<div id="header-aside">
	<div id="header-aside-inner">

		<?php
		$create_new_post_page	 = null;
		$bookmarks_page			 = null;
		$bookmark_post			 = null;

		if ( function_exists( 'buddyboss_sap' ) && buddyboss_is_bp_active() ) {
			$create_new_post_page	 = buddyboss_sap()->option( 'create-new-post' );
			$bookmarks_page			 = buddyboss_sap()->option( 'bookmarks-page' );
			$bookmark_post			 = buddyboss_sap()->option( 'bookmark_post' );
		}
		?>

		<?php if ( buddyboss_is_bp_active() && is_user_logged_in() ) { ?>

			<?php get_template_part( 'template-parts/header-user-messages' ); ?>

			<?php get_template_part( 'template-parts/header-user-notifications' ); ?>

		<?php } ?>

		<?php do_action( 'onesocial_notification_buttons' ); ?>

		<?php if ( buddyboss_is_bp_active() && is_user_logged_in() ) { ?>

			<?php
			if ( $bookmarks_page && $bookmark_post && onesocial_get_option( 'bookmarks_button' ) ) {
                                $bookmark_href = trailingslashit( get_permalink( $bookmarks_page ) );
                                //Keeping bookmarkpage same if network activated
                                if (onesocial_userblog_is_network_activated()) {
                                    $bookmark_href = trailingslashit(get_blog_permalink( 1,$bookmarks_page ));
                                }
                                
				?>
				<a href="<?php echo $bookmark_href; ?>" class="header-button boss-tooltip underlined bookmark-page" data-tooltip="<?php _e( 'Bookmarks', 'onesocial' ); ?>">
					<i class="bb-icon-bookmark"></i>
				</a><?php
			}
			
			if( onesocial_get_option( 'profile_setting_button' ) ) { ?>
				<a href="<?php echo trailingslashit( bp_core_get_user_domain( get_current_user_id() ) . 'settings' ); ?>" class="header-button underlined boss-tooltip boss-setting-icon" data-tooltip="<?php _e( 'Edit Profile', 'onesocial' ); ?>">
					<i class="bb-icon-gear"></i>
				</a><?php
			}
		}
		
		if( onesocial_get_option( 'header_search' ) ) { ?>

			<div id="header-search" class="search-form">
				<?php echo get_search_form(); ?>
				<a href="#" id="search-open" class="header-button boss-tooltip" data-tooltip="<?php _e( 'Search', 'onesocial' ); ?>"><i class="bb-icon-search"></i></a>
			</div><?php

		}

		if ( is_user_logged_in() && buddyboss_is_bp_active() && $create_new_post_page && onesocial_get_option( 'write_post_button' ) ) {
			
                        $href = trailingslashit( get_permalink( $create_new_post_page ) );
                        //Keeping addnew post same if network activated
                        if (onesocial_userblog_is_network_activated()) {
                            $href = trailingslashit(get_blog_permalink( 1,$create_new_post_page ));
                        }
                        ?>
			<a href="<?php echo $href; ?>" class="header-button boss-tooltip boss-write-story-icon" data-tooltip="<?php _e( 'Write a Story', 'onesocial' ); ?>">
				<i class="bb-icon-write"></i>
			</a><?php }
		?>

		<?php get_template_part( 'template-parts/header-user-links' ); ?>

	</div>
</div>