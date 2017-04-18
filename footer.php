<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage OneSocial Theme
 */
?>
</div><!-- #main .wrapper -->
</div><!-- #page -->
</div> <!-- #inner-wrap -->

<!-- Don't delete this -->
<div class="bb-overlay"></div>

</div><!-- #main-wrap (Wrap For Mobile) -->

<?php do_action( 'buddyboss_before_footer' ); ?>

<?php
global $bp, $post;

$post_infinite			 = onesocial_get_option( 'post_infinite' );
$boss_activity_infinite	 = onesocial_get_option( 'boss_activity_infinite' );
$activity				 = isset( $bp ) ? $bp->current_component : false;

// don't remove this filter, marketplace plugin uses it
$show_footer = apply_filters( 'onesocial_show_footer', !( ( is_archive() || is_home() ) && $post_infinite && !( function_exists( 'is_shop' ) && is_shop() ) && !( function_exists( 'is_product_category' ) && is_product_category() ) && !( function_exists( 'is_product_tag' ) && is_product_tag() ) && !( function_exists( 'bbp_is_forum_archive' ) && bbp_is_forum_archive() ) ) || ( $activity == 'activity' && $boss_activity_infinite ) );

if ( $show_footer ) {

	$style = onesocial_get_option( 'onesocial_footer' );
	?>

	<footer id="colophon" class="<?php echo $style; ?>">

		<?php get_template_part( 'template-parts/footer', 'widgets' ); ?>

		<?php if ( 'footer-style-1' == $style ): ?>

		    <div class="footer-inner-bottom">
		        <div class="footer-inner">

		            <div id="footer-links">

						<?php
						$show_copyright	 = onesocial_get_option( 'footer_copyright_content' );
						$copyright		 = onesocial_get_option( 'boss_copyright' );

						if ( $show_copyright && $copyright ) {
							?>

							<div class="footer-credits <?php if ( !has_nav_menu( 'secondary-menu' ) ) : ?>footer-credits-single<?php endif; ?>">
								<?php echo $copyright; ?>
							</div>

						<?php } ?>

						<?php if ( has_nav_menu( 'secondary-menu' ) ) : ?>
							<ul class="footer-menu">
								<?php wp_nav_menu( array( 'container' => false, 'menu_id' => 'nav', 'theme_location' => 'secondary-menu', 'items_wrap' => '%3$s', 'depth' => 1, ) ); ?>
							</ul>
						<?php endif; ?>

		            </div>

					<?php if ( onesocial_get_option( 'boss_layout_switcher' ) ) { ?>
						<form id="switch-mode" name="switch-mode" method="post" action="">
							<input type="submit" value="View as Desktop" tabindex="1" id="switch_submit" name="submit" />
							<input type="hidden" id="switch_mode" name="switch_mode" value="desktop" />
							<?php wp_nonce_field( 'switcher_action', 'switcher_nonce_field' ); ?>
						</form>
					<?php } ?>

					<?php get_template_part( 'template-parts/footer-social-links' ); ?>

				</div><!-- .footer-inner -->

		    </div><!-- .footer-inner-bottom -->

		<?php endif; ?>

		<!-- Don't delete this -->
		<div class="bb-overlay"></div>

	</footer>

<?php } ?>

<?php
if ( !is_user_logged_in() ) {

	if ( onesocial_get_option( 'user_login_option' ) ) {

		if ( buddyboss_is_bp_active() && bp_get_signup_allowed() ) {
			get_template_part( 'template-parts/site-register' );
		}

		get_template_part( 'template-parts/site-login' );
	}
}

// Lost Password
get_template_part( 'template-parts/site-lost-password' );
?>

<?php do_action( 'bp_footer' ) ?>

<?php wp_footer(); ?>

</body>
</html>