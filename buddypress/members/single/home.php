<div id="buddypress">

	<?php do_action( 'bp_before_member_home_content' ); ?>

	<div class="buddypress-content-wrap">

		<section class="buddypress-content">

			<?php if ( !(bp_is_user_settings() || bp_is_user_messages()) ) : ?>
				<div id="item-header" class="item-header-mobile" role="complementary">
					<?php bp_get_template_part( 'members/single/member-header' ) ?>
				</div>
			<?php endif; ?>

			<?php if ( !bp_is_user_messages() ) : ?>
				<div id="item-nav">
					<?php if ( bp_is_user_settings() ) : ?>
						<div id="show-nav" class="bb-icon-more"></div>
					<?php endif; ?>
					<div class="item-list-tabs no-ajax" id="object-nav" role="navigation">
						<ul id="nav-bar-filter">

							<?php bp_get_displayed_user_nav(); ?>

							<?php do_action( 'bp_member_options_nav' ); ?>

						</ul>
					</div>
				</div><!-- #item-nav -->
			<?php endif; ?>

			<?php if ( bp_is_user_settings() ) : ?>
				<h1 class="title big"><?php _e( 'Settings', 'onesocial' ); ?></h1>
			<?php endif; ?>

			<div id="item-body" role="main">

				<?php
				do_action( 'bp_before_member_body' );

				if ( bp_is_user_activity() || !bp_current_component() ) :
					bp_get_template_part( 'members/single/activity' );

				elseif ( bp_is_user_blogs() ) :
					bp_get_template_part( 'members/single/blogs' );

				elseif ( bp_is_user_friends() ) :
					bp_get_template_part( 'members/single/friends' );

				elseif ( bp_is_user_groups() ) :
					bp_get_template_part( 'members/single/groups' );

				elseif ( bp_is_user_messages() ) :
					bp_get_template_part( 'members/single/messages' );

				elseif ( bp_is_user_profile() ) :
					bp_get_template_part( 'members/single/profile' );

				elseif ( bp_is_user_forums() ) :
					bp_get_template_part( 'members/single/forums' );

				elseif ( bp_is_user_notifications() ) :
					bp_get_template_part( 'members/single/notifications' );

				elseif ( bp_is_user_settings() ) :
					bp_get_template_part( 'members/single/settings' );

				// If nothing sticks, load a generic template
				else :
					bp_get_template_part( 'members/single/plugins' );

				endif;

				do_action( 'bp_after_member_body' );
				?>

			</div>

		</section>

		<?php if ( !(bp_is_user_settings() || bp_is_user_messages()) ) : ?>
		
			<div id="secondary" class="widget-area" role="complementary">

				<div id="item-header" class="item-header-sidebar" role="complementary">
					<?php bp_get_template_part( 'members/single/member-header' ) ?>
				</div>

				<?php if ( is_active_sidebar( 'profile' ) ) :
					global $members_template;
					//backup the group current loop to ignore loop conflict from widgets
					$members_template_safe = $members_template;
					dynamic_sidebar( 'profile' );
					//restore the oringal $groups_template before sidebar.
					$members_template = $members_template_safe;
				endif; ?>

			</div>

		<?php endif; ?>

	</div>

	<?php do_action( 'bp_after_member_home_content' ); ?>

</div>