<div id="dashboard-links" class="bp_components dashboard-links">
	<ul>
		<?php if ( is_multisite() ): ?>
			<?php if ( is_super_admin() ): ?>
				<li class="menupop">
					<a class="ab-item" href="<?php echo admin_url( 'my-sites.php' ); ?>"><?php _e( 'My Sites', 'onesocial' ); ?></a>
					<div class="ab-sub-wrapper">
						<ul class="ab-submenu">
							<li class="menupop network-menu">
								<a class="ab-item" href="<?php echo network_admin_url(); ?>"><?php _e( 'Network Admin', 'onesocial' ); ?></a>
								<div class="ab-sub-wrapper">
									<ul class="ab-submenu">
										<li>
											<a href="<?php echo network_admin_url(); ?>"><?php _e( 'Dashboard', 'onesocial' ); ?></a>
											<a href="<?php echo network_admin_url( 'admin.php?page=onesocial_options' ); ?>"><?php _e( 'OneSocial Options', 'onesocial' ); ?></a>
											<a href="<?php echo network_admin_url( 'sites.php' ); ?>"><?php _e( 'Sites', 'onesocial' ); ?></a>
											<a href="<?php echo network_admin_url( 'users.php' ); ?>"><?php _e( 'Users', 'onesocial' ); ?></a>
											<a href="<?php echo network_admin_url( 'themes.php' ); ?>"><?php _e( 'Themes', 'onesocial' ); ?></a>
											<a href="<?php echo network_admin_url( 'plugins.php' ); ?>"><?php _e( 'Plugins', 'onesocial' ); ?></a>
										</li>
									</ul>
								</div>
							</li>
							<?php
							$current_blog_id = get_current_blog_id();

							global $wp_admin_bar;
							foreach ( (array) $wp_admin_bar->user->blogs as $blog ) {
								switch_to_blog( $blog->userblog_id );
								$blogname = empty( $blog->blogname ) ? $blog->domain : $blog->blogname;
								?>
								<li class="menupop">
									<a class="ab-item" href="<?php echo home_url(); ?>"><?php echo $blogname; ?></a>
									<div class="ab-sub-wrapper">
										<ul class="ab-submenu">
											<li>
												<a href="<?php echo admin_url(); ?>"><?php _e( 'Dashboard', 'onesocial' ); ?></a>
												<a href="<?php echo admin_url( 'admin.php?page=onesocial_options' ); ?>"><?php _e( 'OneSocial Options', 'onesocial' ); ?></a>
												<a href="<?php echo admin_url( 'users.php' ); ?>"><?php _e( 'Users', 'onesocial' ); ?></a>
												<a href="<?php echo admin_url( 'themes.php' ); ?>"><?php _e( 'Themes', 'onesocial' ); ?></a>
												<a href="<?php echo admin_url( 'plugins.php' ); ?>"><?php _e( 'Plugins', 'onesocial' ); ?></a>
											</li>
										</ul>
									</div>
								</li>
								<?php
							}

							//switch back to current blog
							switch_to_blog( $current_blog_id );
							?>
						</ul>
					</div>
				</li>
			<?php endif; ?>
			<li class="menupop">
				<a class="ab-item" href="<?php echo admin_url(); ?>"><?php _e( 'Dashboard', 'onesocial' ); ?></a>
				<div class="ab-sub-wrapper">
					<ul class="ab-submenu">
						<li>
							<a href="<?php echo admin_url( 'admin.php?page=onesocial_options' ); ?>"><?php _e( 'OneSocial Options', 'onesocial' ); ?></a>
							<a href="<?php echo admin_url( 'customize.php' ); ?>"><?php _e( 'Customize', 'onesocial' ); ?></a>
							<a href="<?php echo admin_url( 'widgets.php' ); ?>"><?php _e( 'Widgets', 'onesocial' ); ?></a>
							<a href="<?php echo admin_url( 'nav-menus.php' ); ?>"><?php _e( 'Menus', 'onesocial' ); ?></a>
							<a href="<?php echo admin_url( 'plugins.php' ); ?>"><?php _e( 'Plugins', 'onesocial' ); ?></a>
							<a href="<?php echo admin_url( 'themes.php' ); ?>"><?php _e( 'Themes', 'onesocial' ); ?></a>
						</li>
					</ul>
				</div>
			</li>
		<?php else: ?>
			<li class="menupop">
				<a class="ab-item" href="<?php echo admin_url(); ?>"><?php _e( 'Dashboard', 'onesocial' ); ?></a>
				<div class="ab-sub-wrapper">
					<ul class="ab-submenu">
						<li>
							<a href="<?php echo admin_url( 'admin.php?page=onesocial_options' ); ?>"><?php _e( 'OneSocial Options', 'onesocial' ); ?></a>
							<a href="<?php echo admin_url( 'customize.php' ); ?>"><?php _e( 'Customize', 'onesocial' ); ?></a>
							<a href="<?php echo admin_url( 'widgets.php' ); ?>"><?php _e( 'Widgets', 'onesocial' ); ?></a>
							<a href="<?php echo admin_url( 'nav-menus.php' ); ?>"><?php _e( 'Menus', 'onesocial' ); ?></a>
							<a href="<?php echo admin_url( 'plugins.php' ); ?>"><?php _e( 'Plugins', 'onesocial' ); ?></a>
							<a href="<?php echo admin_url( 'themes.php' ); ?>"><?php _e( 'Themes', 'onesocial' ); ?></a>
						</li>
					</ul>
				</div>
			</li>
		<?php endif; ?>
	</ul>
</div>