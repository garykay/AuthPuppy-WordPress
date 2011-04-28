<?php do_action( 'bp_before_profile_edit_content' ) ?>

<?php if ( bp_has_profile( 'profile_group_id=' . bp_get_current_profile_group_id() ) ) : while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

<form action="<?php bp_the_profile_group_edit_form_action() ?>" method="post" id="profile-edit-form" class="standard-form <?php bp_the_profile_group_slug() ?>">

	<?php do_action( 'bp_before_profile_field_content' ) ?>
	
		<ul class="button-nav">
			<?php bp_profile_group_tabs(); ?>
		</ul>
		<div class="clear"></div>
		
		<h4><?php printf( __( "Editing '%s' Profile Group", "buddypress" ), bp_get_the_profile_group_name() ); ?></h4>
		<div class="clear"></div>
		
		<div class="bp-widget authpuppy">
			<table class="profile-fields">
				<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>
					<?php if ( bp_field_has_data() ) : ?>
						<tr <?php bp_field_css_class( 'editfield' ) ?>>

							<?php if ( 'textbox' == bp_get_the_profile_field_type() ) : ?>
								<td class="label">
									<label for="<?php bp_the_profile_field_input_name() ?>"><?php bp_the_profile_field_name() ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'buddypress' ) ?><?php endif; ?></label>
								</td>
								<td class="data">
									<input type="text" name="<?php bp_the_profile_field_input_name() ?>" id="<?php bp_the_profile_field_input_name() ?>" value="<?php bp_the_profile_field_edit_value() ?>" />
								</td>
							<?php endif; ?>

							<?php if ( 'textarea' == bp_get_the_profile_field_type() ) : ?>
								<td class="label">
									<label for="<?php bp_the_profile_field_input_name() ?>"><?php bp_the_profile_field_name() ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'buddypress' ) ?><?php endif; ?></label>
								</td>
								<td class="data">
									<textarea rows="5" cols="40" name="<?php bp_the_profile_field_input_name() ?>" id="<?php bp_the_profile_field_input_name() ?>"><?php bp_the_profile_field_edit_value() ?></textarea>
								</td>
							<?php endif; ?>

							<?php if ( 'selectbox' == bp_get_the_profile_field_type() ) : ?>
								<td class="label"
									<label for="<?php bp_the_profile_field_input_name() ?>"><?php bp_the_profile_field_name() ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'buddypress' ) ?><?php endif; ?></label>
								</td>
								<td class="data">
									<select name="<?php bp_the_profile_field_input_name() ?>" id="<?php bp_the_profile_field_input_name() ?>">
										<?php bp_the_profile_field_options() ?>
									</select>
								</td>

							<?php endif; ?>

							<?php if ( 'multiselectbox' == bp_get_the_profile_field_type() ) : ?>
								<td class="label">
									<label for="<?php bp_the_profile_field_input_name() ?>"><?php bp_the_profile_field_name() ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'buddypress' ) ?><?php endif; ?></label>
								</td>
								<td class="data">
									<select name="<?php bp_the_profile_field_input_name() ?>" id="<?php bp_the_profile_field_input_name() ?>" multiple="multiple">
										<?php bp_the_profile_field_options() ?>
									</select>
								</td>

							<?php endif; ?>

							<?php if ( 'radio' == bp_get_the_profile_field_type() ) : ?>

								<td class="label radio">
									<span class="label"><?php bp_the_profile_field_name() ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'buddypress' ) ?><?php endif; ?></span>
								</td>
								<td class="data">
									<?php bp_the_profile_field_options() ?>

									<?php if ( !bp_get_the_profile_field_is_required() ) : ?>
										<a class="clear-value" href="javascript:clear( '<?php bp_the_profile_field_input_name() ?>' );"><?php _e( 'Clear', 'buddypress' ) ?></a>
									<?php endif; ?>
								</td>

							<?php endif; ?>

							<?php if ( 'checkbox' == bp_get_the_profile_field_type() ) : ?>

								<td class="label checkbox">
									<span class="label"><?php bp_the_profile_field_name() ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'buddypress' ) ?><?php endif; ?></span>
								</td>
								<td class="data">
									<?php bp_the_profile_field_options() ?>
								</td>

							<?php endif; ?>

							<?php if ( 'datebox' == bp_get_the_profile_field_type() ) : ?>

								<td class="label datebox">
									<label for="<?php bp_the_profile_field_input_name() ?>_day"><?php bp_the_profile_field_name() ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'buddypress' ) ?><?php endif; ?></label>
								</td>
								<td class="data">
									<select name="<?php bp_the_profile_field_input_name() ?>_day" id="<?php bp_the_profile_field_input_name() ?>_day">
										<?php bp_the_profile_field_options( 'type=day' ) ?>
									</select>

									<select name="<?php bp_the_profile_field_input_name() ?>_month" id="<?php bp_the_profile_field_input_name() ?>_month">
										<?php bp_the_profile_field_options( 'type=month' ) ?>
									</select>

									<select name="<?php bp_the_profile_field_input_name() ?>_year" id="<?php bp_the_profile_field_input_name() ?>_year">
										<?php bp_the_profile_field_options( 'type=year' ) ?>
									</select>
								</td>

							<?php endif; ?>

							<?php do_action( 'bp_custom_profile_edit_fields' ) ?>
						</tr>
						<tr>
							<td class="description" colspan="2">
								<?php bp_the_profile_field_description() ?>
							</td>
						</tr>
					<?php endif; ?>
					<?php do_action( 'bp_profile_field_item' ) ?>
				<?php endwhile; ?>
			</table>
		</div>
		
		<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>

		<?php endwhile; ?>

	<?php do_action( 'bp_after_profile_field_content' ) ?>

	<div class="submit">
		<input type="submit" name="profile-group-edit-submit" id="profile-group-edit-submit" value="<?php _e( 'Save Changes', 'buddypress' ) ?> " />
	</div>

	<input type="hidden" name="field_ids" id="field_ids" value="<?php bp_the_profile_group_field_ids() ?>" />
	<?php wp_nonce_field( 'bp_xprofile_edit' ) ?>

</form>

<?php endwhile; endif; ?>

<?php do_action( 'bp_after_profile_edit_content' ) ?>