<nav id="mobile-right-panel" class="main-navigation">

	<?php
	if ( has_nav_menu( 'primary-menu' ) ) {
		$args = array( 'theme_location' => 'primary-menu', 'container' => false, 'menu_class' => 'nav-menu clearfix' );
		wp_nav_menu( $args );
	}
	?>

</nav>