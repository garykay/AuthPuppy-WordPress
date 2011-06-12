<?php
	do_action( 'bp_before_profile_content' );
	do_action( 'bp_before_profile_loop_content' );
	
	if ( function_exists('xprofile_get_profile') )
	{
		if ( bp_has_profile() )
		{
			while ( bp_profile_groups() )
			{
				bp_the_profile_group();
				
				if ( bp_profile_group_has_fields() )
				{
					do_action( 'bp_before_profile_field_content' );

					echo '<div class="bp-widget '.bp_get_the_profile_group_slug().'">';
					
						if ( 1 != bp_get_the_profile_group_id() )
							echo "<h4>".bp_get_the_profile_group_name()."</h4>";
?>
						<table class="profile-fields">
							<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>
								<?php if ( bp_field_has_data() ) : ?>
									<tr>
										<td class="label">
											<?php bp_the_profile_field_name() ?>
										</td>
										<td class="data">
											<?php bp_the_profile_field_value() ?>
										</td>
									</tr>
								<?php endif; ?>
								<?php do_action( 'bp_profile_field_item' ) ?>
							<?php endwhile; ?>
						</table>
					</div>
<?php
					do_action( 'bp_after_profile_field_content' );
				}
			}

			do_action( 'bp_profile_field_buttons' );
		}
	}
	else
	{
		/* Just load the standard WP profile information, if BP extended profiles are not loaded. */
		bp_core_get_wp_profile();
	}
	
	do_action( 'bp_after_profile_loop_content' );
	do_action( 'bp_after_profile_content' );
?>