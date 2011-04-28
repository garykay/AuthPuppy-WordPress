<?php  
  
	//Include class we need  
	include_once (WP_PLUGIN_DIR . '/slider/class/site.php');
	include_once (WP_PLUGIN_DIR . '/slider/class/slide.php');
	include_once (WP_PLUGIN_DIR . '/slider/class/site-bind.php');
	$slideObj = new Slide();
	$slideObj = new Slide();
	$siteObj = new Site();
	$slideObj = $slideObj->getSlidesFor('site', $siteObj->getSite());
	  
	//If there is slide for this site  
	if (count($slideObj) > 0)  
	{
?>		<script language="javascript" src="<?php echo WP_PLUGIN_URL; ?>/slider/js/slider.js"></script>
		<link type="text/css" rel="stylesheet" href="<?php echo WP_PLUGIN_URL; ?>/slider/css/slider.css">
		<ul class="slideshow">
<?php  
			$bool = false;
			foreach ($slideObj as $slide)  
			{  
				if ($bool)  
					echo "<li>";
				else  
				{  
					$bool = true;
					echo '<li class="show">';
				}
?>  
					<a href="<?php echo $slide->__get('url'); ?>">  
						<img src="<?php echo WP_PLUGIN_URL . "/slider/uploads/" .$slide->__get('image'); ?>"   
							style="max-width:945px; max-height:200px;"   
							title="<?php echo $slide->__get('title'); ?>"   
							alt="<?php echo $slide->__get('content'); ?>"/>  
					</a>  
				</li>  
<?php  
			}  
?>  
		</ul>
<?php  
	}  
?>