<?php get_header("no-sidebar") ?>

<div id="container">
	<div id="content-bp">
		<div class="activity no-ajax">
			<?php if ( bp_has_activities( 'display_comments=threaded&include=' . bp_current_action() ) ) : ?>

				<ul id="activity-stream" class="activity-list item-list">
				<?php while ( bp_activities() ) : bp_the_activity(); ?>

					<?php locate_template( array( 'activity/entry.php' ), true ) ?>

				<?php endwhile; ?>
				</ul>

			<?php endif; ?>
		</div>
	</div><!-- #content -->
</div><!-- #container -->


<?php
	locate_template( array( 'sidebar.php' ), true );
	get_footer();
?>