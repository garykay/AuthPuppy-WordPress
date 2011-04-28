<?php
	function showAdmin()
	{
		//Create Object
		$userObj = new User();
		$slideObj = new Slide();
		$bindObj = new UserBind();
		
		if (count($slideObj->getSlides()) == 0)
		{
?>
			<div class="error"><p>Sorry, there is no Slide currently created. Create a new one First</p></div>
			<form method="post" action="/wp-admin/admin.php?page=Slider">
				<input type="hidden" name="action" value="editSlide" />
				<input type="submit" value="Create a new Slide" />
			</form>
<?php
		}
		else
		{
?>
			<style>
				div.postbox div.inside {
					margin:10px;
					position:relative;
				}
				.inside
				{
					max-height: 250px;
					overflow: auto;
				}
			</style>

			<div class="wrap">
				<h2>Slider UserRights</h2>

				<form method="post" action="">
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Bind Users with Slides') ?>" />
				</p>
				<div class="meta-box-sortables ui-sortable" id="side-sortables">
<?php
					//Get All User that are not Admin
					foreach ($userObj->getUsers() as $user)
					{
						if ($user->__get('user_level') != 10)
						{
?>
							<input type="hidden" name="users[]" value="<?php echo $user->__get('id'); ?>" />
							<div class="postbox " id="user_<?php echo $user->__get('id'); ?>_list">
								<div title="Click to toggle" class="handlediv"><br></div>
								<h3 class="handle"><span>Bind  <?php echo $user->__get('name'); ?> With Slides</span></h3>
								<div class="inside">
									<ul>
<?php
									//All Hotspot
									foreach ($slideObj->getSlides() as $slide)
									{
?>
										<li>
											<input 	type="checkbox"
													id="user_<?php echo $user->__get('id'); ?>_slide_<?php echo $slide->__get('id'); ?>" 
													name="user_<?php echo $user->__get('id'); ?>[]" 
													value="<?php echo $slide->__get('id'); ?>" 
													<?php if ($bindObj->getBind($user, $slide)) echo 'checked="checked"'; ?>
											/>
											<label for="user_<?php echo $user->__get('id'); ?>_slide_<?php echo $slide->__get('id'); ?>">
												<?php echo $slide->__get('title'); ?>
											</label>
										</li>
<?php
									}
?>
									</ul>
								</div>
							</div>
<?php
						}
					}
?>
					<p class="submit">
						<input type="hidden" name="action" value="saveAdminForm" />
						<input type="submit" class="button-primary" value="<?php _e('Bind Users with this Slides') ?>" />
					</p>
				</form>
				</div>
			</div>
<?php	
		}
	}
	
	function saveAdminForm()
	{
		$bindObj = new UserBind();
		$userObj = new User();
		$slideObj = new Slide();
		
		foreach ($_POST["users"] as $userID)
		{
			$userObj = $userObj->getUser($userID);
			$bindObj->emptyForUser($userObj);
			if (isset($_POST["user_".$userID]))
			{
				foreach ($_POST["user_".$userID] as $slideID)
				{
					$slideObj = $slideObj->getSlide($slideID);
					echo $bindObj->setBind($userObj, $slideObj);
				}
			}
		}
		echo '<div class="updated below-h2" id="message"><p>All selected Slides <strong>succesfully</strong> binded to all selected Users</p></div>';
		showAdmin();
	}
?>