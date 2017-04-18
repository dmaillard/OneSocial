<?php do_action( 'bp_before_directory_groups_page' ); ?>

<div id="buddypress">

	<?php do_action( 'bp_before_directory_groups' ); ?>

	<?php do_action( 'bp_before_directory_groups_content' ); ?>

	<?php bp_get_template_part( 'common/search/dir-search-form' ); ?>
	
	<form action="" method="post" id="groups-directory-form" class="dir-form">

		<?php do_action( 'template_notices' ); ?>

		<div class="item-list-tabs" role="navigation">
			<ul>
				<?php do_action( 'bp_groups_directory_group_filter' ); ?>

				<?php do_action( 'bp_groups_directory_group_types' ); ?>

				<?php if ( is_user_logged_in() && bp_get_total_group_count_for_user( bp_loggedin_user_id() ) ) : ?>
					<li id="groups-personal"><a href="<?php echo bp_loggedin_user_domain() . bp_get_groups_slug() . '/my-groups/'; ?>"><?php printf( __( 'My Groups <span>%s</span>', 'onesocial' ), bp_get_total_group_count_for_user( bp_loggedin_user_id() ) ); ?></a></li>
				<?php endif; ?>

				<li class="selected" id="groups-all"><a href="<?php bp_groups_directory_permalink(); ?>"><?php printf( __( 'All Groups <span>%s</span>', 'onesocial' ), bp_get_total_group_count() ); ?></a></li>

				<li id="groups-order-select" class="last filter">

					<label class="bb-order-by" for="groups-order-by"><?php _e( 'Order by ', 'onesocial' ); ?></label>

					<select id="groups-order-by">
						<option value="active"><?php _e( 'Last Active', 'onesocial' ); ?></option>
						<option value="popular"><?php _e( 'Most Members', 'onesocial' ); ?></option>
						<option value="newest"><?php _e( 'Newly Created', 'onesocial' ); ?></option>
						<option value="alphabetical"><?php _e( 'Alphabetical', 'onesocial' ); ?></option>

						<?php do_action( 'bp_groups_directory_order_options' ); ?>
					</select>
				</li>

			</ul>
		</div><!-- .item-list-tabs -->


		<?php if ( bp_get_current_group_directory_type() ) : ?>
			
			<?php bp_current_group_directory_type_message() ?>

		<?php endif; ?>

		<div id="groups-dir-list" class="groups dir-list">
			<?php bp_get_template_part( 'groups/groups-loop' ); ?>
		</div><!-- #groups-dir-list -->

		<?php do_action( 'bp_directory_groups_content' ); ?>

		<?php wp_nonce_field( 'directory_groups', '_wpnonce-groups-filter' ); ?>

		<?php do_action( 'bp_after_directory_groups_content' ); ?>

	</form><!-- #groups-directory-form -->

	<?php do_action( 'bp_after_directory_groups' ); ?>

</div><!-- #buddypress -->

<?php do_action( 'bp_after_directory_groups_page' ); ?>