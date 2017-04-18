<?php
/**
 * The sidebar containing the bbPress widget area.
 *
 * If no active widgets in sidebar, let's hide it completely.
 *
 * @package WordPress
 * @subpackage OneSocial Theme
 * @since OneSocial Theme 1.0.0
 */
if ( is_active_sidebar( 'forums' ) ) {
	?>

	<div id="secondary" class="widget-area" role="complementary">
		<?php dynamic_sidebar( 'forums' ); ?>
	</div>

	<?php
}