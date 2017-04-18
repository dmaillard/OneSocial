<?php
/**
 * Search
 *
 * @package bbPress
 * @subpackage Theme
 */
?>

<form method="get" id="bbp-search-index-form" action="<?php bbp_search_url(); ?>">
	<label class="bb-search-forums-label" for="bbp_search">
		<input tabindex="<?php bbp_tab_index(); ?>" type="text" value="<?php echo esc_attr( bbp_get_search_terms() ); ?>" name="bbp_search" id="bbp_search" placeholder="<?php _e( 'Type to search', 'onesocial' ); ?>"/>
	</label>

	<button tabindex="<?php bbp_tab_index(); ?>" class="button" type="submit" id="bbp_search_submit" title="<?php esc_attr_e( 'Search', 'onesocial' ); ?>"><i class="bb-icon-search"></i></button>
</form>