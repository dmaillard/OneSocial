<?php
global $buddyboss_media;
if ( $buddyboss_media ):
	global $bp;
	foreach ( $bp->bp_nav as $nav ) {
		if ( $nav[ 'slug' ] == 'photos' ) {
			$title = $nav[ 'name' ];
		}
	}
	preg_match_all( '!\d+!', $title, $matches );
	$count = (int) $matches[ 0 ][ 0 ];
	if ( $count && $count > 0 ):

		$query = array( "action"	 => false,
			"type"		 => "activity_update",
			"user_id"	 => bp_displayed_user_id(),
			"page"		 => 1,
			"per_page"	 => 4,
			"meta_query" => array(
				array( "key" => "buddyboss_media_aid", "compare" => "EXISTS" ),
				array( "key" => "buddyboss_pics_aid", "compare" => "EXISTS" ),
				array( "key" => "bboss_pics_aid", "compare" => "EXISTS" ),
				"relation" => "OR" )
		);

		$photos_component = $bp->current_component;

		if ( !( bp_is_user_settings() || bp_is_user_messages() ) && ('photos' != $photos_component) ) :
			?>
			<div id="item-photos">
				<div class="wrap">
					<h3 class="title black"><?php echo $title; ?></h3>
					<div class="activity">
						<?php if ( bp_has_activities( $query ) ) : ?>

							<?php if ( empty( $_POST[ 'page' ] ) ) : ?>

								<div id="bbmedia-grid-wrapper">
									<ul id="bb-activity-stream" class="bb-activity-list">

									<?php endif; ?>

									<?php while ( bp_activities() ) : bp_the_activity(); ?>

										<?php bp_get_template_part( 'activity/media-entry' ); ?>

									<?php endwhile; ?>

									<?php if ( empty( $_POST[ 'page' ] ) ) : ?>

									</ul>
								</div><!-- #bbmedia-grid-wrapper" -->

							<?php endif; ?>

						<?php endif; ?>
					</div>
				</div>
			</div><!-- #item-photos -->
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>