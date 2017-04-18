<article class="hentry boss-create-post-wrapper">

	<div class="boss-post-author-wrap">
		<?php
		global $current_user;
		$current_user_id = get_current_user_id();
                
                if( function_exists('buddyboss_sap') && buddyboss_is_bp_active() ) {
                    $create_new_post_page = buddyboss_sap()->option('create-new-post');
                }

		echo get_avatar( get_current_user_id(), 100 );
        $is_index_page = is_home() ? 'yes' : 'no';
		?>

		<div class="boss-author-info">
			<p class="boss-greeting"><?php _e( 'Write here...', 'onesocial' ); ?></p>
			<p class="boss-author-name"><?php echo esc_html( $current_user->display_name ); ?></p>
		</div>
	</div>

	<div class="boss-editor-area-container">

		<div class="sap-editor-area-wrapper boss-editor-area-wrapper">
			<textarea class="sap-editable-title" data-disable-toolbar="true"></textarea>
			<textarea class="sap-editable-area"></textarea>
		</div>

		<div class="sap-editor-toolbar boss-create-post">
			<div class="sap-editor-publish-wrapper">

				<div class="sap-publish-popup">
					<a class="sap-story-publish" href="#" /><?php _e( 'Save', 'onesocial' ); ?></a>
					<input type="hidden" class="sap-editor-nonce" name="sap_editor_nonce" value="<?php echo wp_create_nonce( 'sap-editor-nonce');?>" >

                    <input type="hidden" name="sap_is_index_page" id="sap_is_index_page" value="<?php echo $is_index_page;?>" />
					
					<a class="boss-close-create-post" href="#" /><?php _e( 'Close', 'onesocial' ); ?></a>

					<?php if ( isset($create_new_post_page) && $create_new_post_page && buddyboss_is_bp_active() ) { ?>
				        <form action="<?php echo trailingslashit(get_permalink($create_new_post_page)); ?>" id="full-screen" method="post">
                            <input type="hidden" name="content">
                            <input type="hidden" name="title">
                            <button type="submit" class="boss-tooltip top expand-to-fullscreen" data-tooltip="<?php _e( 'Expand to the full-screen editor for more features', 'onesocial' ); ?>"><i class="bb-icon-expand"></i></button>
                        </form>
						<?php
					} ?>

				</div>

			</div>
		</div>

	</div>

</article>