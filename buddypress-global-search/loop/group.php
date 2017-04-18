<li class="bboss_search_item bboss_search_item_group">

	<div class="bb-search-result-group">

		<div class="item-avatar">
			<a href="<?php bp_group_permalink(); ?>"><?php bp_group_avatar( 'type=full&width=100&height=100' ); ?></a>
		</div>

		<div class="item">
			<div class="item-title">
				<a class="bb-group-title" href="<?php bp_group_permalink(); ?>"><?php bp_group_name(); ?></a>
				<span class="bb-group-type">(<?php bp_group_type(); ?>)</span>
				<span class="activity"><?php printf( __( 'active %s', 'onesocial' ), bp_get_group_last_active() ); ?></span>
			</div>

			<div class="item-desc">
				<?php bp_group_description_excerpt(); ?>
			</div>
		</div>

	</div>

</li>