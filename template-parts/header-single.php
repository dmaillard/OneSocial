<div class="header-area">
	<?php
	global $post;

	$header_class = ' not-image';

	if ( has_post_thumbnail( $post->ID ) ) {
		$header_class	 = ' has-image';
		$image_id = get_post_thumbnail_id( $post->ID );
		$full_image = wp_get_attachment_image_src( $image_id, 'large-thumb' );
		?>

		<div class="entry-post-thumbnail" style="background-image:url(<?php echo $full_image[ 0 ]; ?>);">
			<?php the_post_thumbnail('large-thumb'); ?>
		</div>

	<?php } ?>

	<div class="profile-visible"><?php echo get_the_date( 'M j' ); ?></div>

	<!-- Title -->
	<header class="entry-header<?php echo $header_class; ?>">

		<div class="table">
			<div class="table-cell">

				<h1 class="entry-title"><?php the_title(); ?><?php if(function_exists('sap_edit_post_link')) sap_edit_post_link(); ?></h1>

			</div>
		</div>

	</header>

</div>