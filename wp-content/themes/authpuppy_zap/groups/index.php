<?php get_header("no-sidebar") ?>

<div id="container">
	<div id="content-bp">

		<form action="" method="post" id="groups-directory-form" class="dir-form">
			<h3><?php _e( 'Groups Directory', 'buddypress' ) ?></h3>

			<?php do_action( 'bp_before_directory_groups_content' ) ?>
			
			<div class="item-list-tabs no-ajax" id="subnav">
				<div class="item-list-tabs">
					<ul>
						<li>
							<?php bp_directory_groups_search_form(); ?>
						</li>
						<li>
							<a href="<?php echo network_site_url(); ?>groups/">All groups</a>
						</li>
						<?php if ( is_user_logged_in() ) : ?> 
						<li>
							<a href="<?php  echo bp_loggedin_user_domain(); ?>groups/">My groups</a>
						</li>
						<li>
							<a class="button" href="<?php echo bp_get_root_domain() . '/' . BP_GROUPS_SLUG . '/create/' ?>">
								<?php _e( 'Create a Group', 'buddypress' ) ?>
							</a>
						</li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
			
			<div id="groups-dir-list" class="groups dir-list">
				<?php locate_template( array( 'groups/groups-loop.php' ), true ) ?>
			</div><!-- #groups-dir-list -->

			<?php do_action( 'bp_directory_groups_content' ) ?>

			<?php wp_nonce_field( 'directory_groups', '_wpnonce-groups-filter' ) ?>

		</form><!-- #groups-directory-form -->

		<?php do_action( 'bp_after_directory_groups_content' ) ?>

	</div><!-- #content -->
</div><!-- #container -->

	<?php locate_template( array( 'sidebar.php' ), true ) ?>

<?php get_footer() ?>