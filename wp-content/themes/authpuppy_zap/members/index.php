<?php get_header("no-sidebar") ?>
<div id="container">
	<div id="content-bp">

		<form action="" method="post" id="members-directory-form" class="dir-form">

			<h3><?php _e( 'Members Directory', 'buddypress' ) ?></h3>

			<?php do_action( 'bp_before_directory_members_content' ) ?>
			<div class="item-list-tabs no-ajax" id="subnav">
				<div class="item-list-tabs">
					<ul>
						<li>
							<?php bp_directory_members_search_form(); ?>
						</li>
						
						<?php if ( is_user_logged_in() && function_exists( 'bp_get_total_friend_count' ) && bp_get_total_friend_count( bp_loggedin_user_id() ) ) : ?>
							<li id="members-personal">
								<a href="<?php echo bp_loggedin_user_domain() . BP_FRIENDS_SLUG . '/my-friends/' ?>">
									<?php printf( __( 'My Friends (%s)', 'buddypress' ), bp_get_total_friend_count( bp_loggedin_user_id() ) ) ?>
								</a>
							</li>
						<?php endif; ?>
						
						<li>
							<?php echo "<a href='".network_site_url()."members/'>All</a>"; ?>
						</li>

					</ul>
				</div><!-- .item-list-tabs -->
			</div>
			<div class="clear"></div>
			<div id="members-dir-list" class="members dir-list">
				<?php locate_template( array( 'members/members-loop.php' ), true ) ?>
			</div><!-- #members-dir-list -->

			<?php do_action( 'bp_directory_members_content' ) ?>

			<?php wp_nonce_field( 'directory_members', '_wpnonce-member-filter' ) ?>

			<?php do_action( 'bp_after_directory_members_content' ) ?>

		</form><!-- #members-directory-form -->

	</div><!-- #content -->
</div><!-- #container -->

<?php
	locate_template( array( 'sidebar.php' ), true );
	get_footer();
?>