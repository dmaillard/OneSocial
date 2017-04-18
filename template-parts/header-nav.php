<nav id="site-navigation" class="main-navigation">

	<div class="nav-inner">

		<a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'onesocial' ); ?>"><?php _e( 'Skip to content', 'onesocial' ); ?></a>

		<?php
		if ( has_nav_menu( 'primary-menu' ) ) {
			$args = array( 'theme_location' => 'primary-menu', 'menu_class' => 'nav-menu onsocial-primary-menu clearfix' );
			wp_nav_menu( $args );
		}
		?>

	</div>

</nav><!-- #site-navigation -->