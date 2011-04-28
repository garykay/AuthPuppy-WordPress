<?php
	function showAuthor()
	{
?>
		<div class="wrap">
			<h2>Welcome on your Slide editor page</h2>
			<br />
<?php
			$userObj = new User();
			$slideObj = new Slide();
			$bindObj = new UserBind();
			
			$userObj = $userObj->getUser(get_current_user_id());
			
			if ($userObj->__get('user_level') == 10)
			{
?>
				<form method="post" action="">
					<input type="hidden" name="action" value="editSlide" />
					<input type="submit" value="Create a new Slide" />
				</form>
<?php
				//Get All Slide because Admin
				$slideObj = $slideObj->getSlides();
			}
			else
				//Get only your slide
				$slideObj = $slideObj->getSlidesFor('user', $userObj);
				
			foreach ($slideObj as $slide)
			{
?>
				<br />
				<form method="post" action="">
					<input type="hidden" name="action" value="editSlide" />
					<input type="hidden" name="slide" value="<?php echo $slide->__get('id'); ?>" />
					<input type="submit" value="Edit Slide #<?php echo $slide->__get('id'); ?>" />
					<?php echo $slide->__get('title'); ?>
				</form>
<?php
				if ($userObj->__get('user_level') == 10)
				{
?>
				<form method="post" action="">
					<input type="hidden" name="action" value="removeSlide" />
					<input type="hidden" name="slide" value="<?php echo $slide->__get('id'); ?>" />
					<input type="submit" value="Remove Slide #<?php echo $slide->__get('id'); ?>" />
				</form>
				<br />
<?php
				}
			}
?>
		</div>
<?php
	}
	
	function editSlide()
	{
		$slideObj = new Slide();
		$userObj = new User();
		$bindObj = new UserBind();
		
		if (isset($_POST['slide']))
			$slideObj = $slideObj->getSlide($_POST['slide']);
		else if (isset($_POST['id']))
		{
			$slideObj = $slideObj->getSlide($_POST['id']);
			$slideObj->__set('id', $_POST['id']);	
			$slideObj->__set('title', $_POST['title']);
			$slideObj->__set('content', $_POST['content']);
			$slideObj->__set('url', $_POST['url']);
		}
		
		//Can User access? (bind or admin)
		$userObj = $userObj->getUser(get_current_user_id());
		
		if (($userObj->__get('user_level') == 10) or ($bindObj->getBind($userObj, $slideObj)))
		{
?>
			<div class="wrap">
<?php 
			if ($slideObj->__get('id') == null)
				echo "<h2>Create a new Slide :<h2>";
			else
				echo "<h2>Editing Slide <strong>#".$slideObj->__get('id')."</strong><h2>";
?>
				<form method="post" action="" enctype="multipart/form-data">
					Title<br />
						<input type="hidden" name="slideID" value="<?php echo $slideObj->__get('id'); ?>" />
						<input type="text" name="title" value="<?php echo $slideObj->__get('title'); ?>" size="140" />
					<br />
					<br />Text<br />
						<textarea name="content" cols="150" rows="7"><?php echo $slideObj->__get('content'); ?></textarea>
					<br />
					<br />Background Image<br />
						<input type="file" name="image" />
						<input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
<?php
						if (($slideObj->__get('image') != null) 
						and (file_exists(WP_PLUGIN_DIR . "/slider/uploads/" . $slideObj->__get('image'))))
						{
							echo "<img src='".WP_PLUGIN_URL . "/slider/uploads/" .$slideObj->__get('image')."' width='20%' height='20%' />";
?>
							<input type="checkbox" id="removeImg" name="removeImg" />
							<label for="removeImg">Remove this background</label>
<?php
						}
?>
					<br />
					<br />Website or Link<br />
						<input type="text" name="url" value="<?php echo $slideObj->__get('url'); ?>" size="140" />
<?php
						if ($slideObj->__get('url') != null)
							echo "<a href='".$slideObj->__get('url')."' target='_blank'>View website</a>";
?>
					<p class="submit">
						<input type="hidden" name="action" value="saveSlide" />
						<input type="submit" class="button-primary" value="Save" />
					</p>
				</form>
			</div>
<?php
		}
		else
		{
			echo '<div class="error"><p>Sorry, but you can\'t edit this slide!</p></div>';
			include_once (WP_PLUGIN_DIR . '/slider/sorry.php');
			sorry_game();
		}
	}
	
	function removeSlide()
	{
		$slideObj = new Slide();
		$userObj = new User();
		$bindObj = new UserBind();
		
		$userObj = $userObj->getUser(get_current_user_id());
		$slideObj = $slideObj->getSlide($_POST['slide']);
		
		//Can User access? (bind or admin)
		if ($userObj->__get('user_level') == 10)
		{
			$slideObj->removeSlide($slideObj);
			echo '<div class="updated below-h2" id="message"><p>Your Slide has been <strong>succesfully</strong> remove from database</p></div>';
			showAuthor();
		}
		else
		{
			echo '<div class="error"><p>Sorry, but you can\'t delete this slide!</p></div>';
			editSlide();
		}
	
	}
	
	function saveSlide()
	{
		$slideObj = new Slide();
		$userObj = new User();
		$bindObj = new UserBind();
		
		$userObj = $userObj->getUser(get_current_user_id());
		$slideObj = $slideObj->getSlide($_POST['slideID']);
		
		//Can User access? (bind or admin)
		if (($userObj->__get('user_level') == 10) or ($bindObj->getBind($userObj, $slideObj)))
		{
			$slideObj = new Slide();
			
			$slideObj->__set('id', $_POST['slideID']);
			$slideObj->__set('title', $_POST['title']);
			$slideObj->__set('content', $_POST['content']);
			$slideObj->__set('url', $_POST['url']);
			
			$slideObj = $slideObj->setSlide($slideObj);
						
			echo '<div class="updated below-h2" id="message"><p>Your Slide has been <strong>succesfully</strong> saved in database</p></div>';
			
			if ((isset($_POST['removeImg']))
				and (file_exists(WP_PLUGIN_DIR . "/slider/uploads/" . $slideObj->__get('id'))))
			{
				unlink (WP_PLUGIN_DIR . "/slider/uploads/" . $slideObj->__get('id'));
				$slideObj->__set('image', '');
				$slideObj->setSlide($slideObj);
				echo '<div class="updated below-h2" id="message"><p>Your background image has been <strong>succesfully</strong> remove</p></div>';
				
				showAuthor();
			}
			else if (isset($_FILES['image']))
			{
				$extension = end(explode(".", strtolower($_FILES['image']['name'])));
				$allowedExtensions = array("jpg","jpeg","gif","png"); 
				if (in_array($extension, $allowedExtensions))
				{
					$img = $slideObj->__get('id') . '.' . $extension;
					
					$move = WP_PLUGIN_DIR . "/slider/uploads/" . $img;
					$tmp = $_FILES['image']['tmp_name'];
					$resultat = move_uploaded_file($tmp, $move);
					
					$slideObj->__set('image', $img);
					$slideObj->setSlide($slideObj);			
					echo '<div class="updated below-h2" id="message"><p>Your background image has been <strong>succesfully</strong> upload, now you can crop it</p></div>';
					cropImage($img);
				}
				else
				{
					echo '<div class="error"><p>Sorry, you do not choose a good file</p></div>';
				}
			}
			else
				showAuthor();
		}
		else
		{
			echo '<div class="error"><p>Sorry, but you can update this slide!</p></div>';
			editSlide();
		}
	}
	
	function cropImage($img)
	{
?>
		<script language="javascript" src="<?php echo WP_PLUGIN_URL; ?>/slider/js/jquery.Jcrop.min.js"></script>
		<script language="javascript" src="<?php echo WP_PLUGIN_URL; ?>/slider/js/crop.js"></script>
		<link type="text/css" rel="stylesheet" href="<?php echo WP_PLUGIN_URL; ?>/slider/css/jquery.Jcrop.css">
		
		<form action="" method="post">
			<input type="hidden" name="action" value="saveCropImage" />
			
			<input type="hidden" name="image" value="<?php echo $img ?>" />
			<input type="hidden" id="coordx" name="coordx" value="0" />
			<input type="hidden" id="coordy" name="coordy" value="0" />
			<input type="hidden" id="coordx2" name="coordx2" value="0" />
			<input type="hidden" id="coordy2" name="coordy2" value="0" />
			<input type="submit" class="primary-button" value="Crop like This" />
		</form>
		<br />
		<img src="<?php echo WP_PLUGIN_URL. "/slider/uploads/" . $img; ?>" id="cropbox" />
<?php
	}
	
	function saveCropImage()
	{
		$url = WP_PLUGIN_URL . "/slider/crop.php?image=".$_POST['image']."&coordx=".$_POST['coordx']."&coordy=".$_POST['coordy']."&coordx2=".$_POST['coordx2']."&coordy2=".$_POST['coordy2'];
		echo $url;
		wp_remote_fopen($url);
		showAuthor();
	}
?>