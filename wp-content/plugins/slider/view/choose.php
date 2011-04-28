<?php
	function showChoose()
	{
		//Create Object
		$siteObj = new Site();
		$slideObj = new Slide();
		$bindObj = new SiteBind();
		
		//Get the Site
		$siteObj = $siteObj->getSite();
		if ($siteObj)
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
				<h2>Choose Slide for this Site</h2>

				<form method="post" action="">
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Bind This Site with Slides') ?>" />
				</p>
				<div class="meta-box-sortables ui-sortable" id="side-sortables"><div class="postbox " id="site_<?php echo $siteObj->__get('id'); ?>_list">
					<div title="Click to toggle" class="handlediv"><br></div>
					<h3 class="handle"><span>Bind  <?php echo $siteObj->__get('name'); ?> With Slides</span></h3>
					<div class="inside">
						<ul>
<?php
						//All Hotspot
						foreach ($slideObj->getSlides() as $slide)
						{
?>
							<li>
								<input 	type="checkbox"
										id="site_<?php echo $siteObj->__get('id'); ?>_slide_<?php echo $slide->__get('id'); ?>" 
										name="site_<?php echo $siteObj->__get('id'); ?>[]" 
										value="<?php echo $slide->__get('id'); ?>" 
										<?php if ($bindObj->getBind($siteObj, $slide)) echo 'checked="checked"'; ?>
								/>
								<label for="site_<?php echo $siteObj->__get('id'); ?>_slide_<?php echo $slide->__get('id'); ?>">
									<?php echo $slide->__get('title'); ?>
								</label>
							</li>
<?php
						}
?>
						</ul>
					</div>
				</div>
					<p class="submit">
						<input type="hidden" name="action" value="saveChoose" />
						<input type="submit" class="button-primary" value="<?php _e('Bind This Site with Slides') ?>" />
					</p>
				</form>
				</div>
			</div>
<?php
		}
		else if (count($slideObj->getSlides()) == 0)
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
			echo '<div class="error"><p>Sorry, an unexpected error happened and we were unable to determine which site this is.</p></div>';
		}
	}
	
	function saveChoose()
	{
		$bindObj = new SiteBind();
		$siteObj = new Site();
		$slideObj = new Slide();
		
		$siteObj = $siteObj->getSite();
		if ($siteObj)
		{
			$bindObj->emptyForSite($siteObj);
			if (isset($_POST["site_".$siteObj->__get('id')]))
			{
				foreach ($_POST["site_".$siteObj->__get('id')] as $slideID)
				{
					$slideObj = $slideObj->getSlide($slideID);
					echo $bindObj->setBind($siteObj, $slideObj);
				}
			}
			echo '<div class="updated below-h2" id="message"><p>All selected Slides <strong>succesfully</strong> binded to this Site</p></div>';
			showChoose();
		}
		else
		{
			echo '<div class="error"><p>Sorry, an error occured!</p></div>';
			showChoose();
		}
	}
?>