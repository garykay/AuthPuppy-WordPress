<?php
	function createForm()
	{
		$name = "Name of the Portal";
		$short_name = "name-of-the-portal";
		$gwid = "";
		$current_user = wp_get_current_user();
		$admin_email = $current_user->user_email;
?>
		<div class="wrap">
			<form method="post" action="">
				<ul>
					<li>
						<label for="name">Name of the portal</label>
						<input type="text" name="name" id="name" value="<?php echo $name; ?> " /> (*)
					</li>
					<li>
						<label for="name">Short-Name of the portal</label>
						<input type="text" name="short_name" id="name" value="<?php echo $short_name; ?>" />
					</li>
					<li>
						<label for="name">Gwid</label>
						<input type="text" name="gwid" id="gwid" value="<?php echo $gwid; ?>" />
					</li>
					<li>
						<label for="name">Admin email</label>
						<input type="text" name="admin_email" id="name" value="<?php echo $admin_email; ?>" disabled="disabled" />
					</li>
					<li>
						<input type="hidden" name="action" value="createSite" />
						<input type="submit" class="button-primary" value="Create the portal" />
					</li>
				</ul>
			</form>
		</div>
<?php
	}
	
	function createSite()
	{	
		if (isset($_GET['name']))
			foreach($_GET as $key=>$value)
				$_POST[$key] = $value;
		
		
		if ($_POST['name'] != "")
		{
			//Name of the new hotspot
			$name = $_POST['name'];
			
			//Shortname = name without space or shortname posted
			if ($_POST['short_name'] == "")
				$short_name = str_replace(" ", "-", strtolower($_POST['name']));
			else
				$short_name = $_POST['short_name'];
			
			$gwid = (int) $_POST['gwid'];
			
			//Email of admin = default or posted
			if ($_POST['admin_email'] == "")
			{
			    $current_user = wp_get_current_user();
				$admin_email = $current_user->user_email;
			}
			else
				$admin_email = $_POST['admin_email'];
			
			include_once (WP_PLUGIN_DIR . '/authpuppy/class/create.php');
			$create = new CREATE();
			$return = $create->newSite($name, $short_name, $gwid, $admin_email);
			
			echo $return['message'];
			if ($return['status'])
			{
?>
				<div class="updated below-h2" id="message">
					<p>
						You can now choose the hotspot owner and give him the Author role! (you can also choose a special administrator for this site) in
						<a href="<?php echo network_site_url().$short_name; ?>/wp-admin/ms-sites.php?action=editblog&id=<?php echo $return['status']; ?>" target="_blank">
							dashboard
						</a>
					</p>
				</div>
				<div class="updated below-h2" id="message">
					<p>
						You can now choose the widget in
						<a href="<?php echo network_site_url().$short_name; ?>/wp-admin/widgets.php" target="_blank">
							Appearance => Widgets
						</a>
					</p>
				</div>
				<div class="updated below-h2" id="message">
					<p>
						Or visit the portal at 
						<a href="<?php echo network_site_url().$short_name; ?>/" target="_blank">
							<?php echo network_site_url().$short_name; ?>/
						</a>
					</p>
				</div>
				<div class="updated below-h2" id="message">
					<p>
						<a href="">
							Or create a new one!
						</a>
					</p>
				</div>
<?php
			}
			else
				createForm();
		}
		else
		{
			echo '<div class="error">Please fill all the informations</div>';
			createForm();
		}
		
	}
	
	function optionForm()
	{
?>
		<div class="wrap">
			<form method="post" action="">
				<ul>
					<li>
						<label for="gwid">Default gwid</label>
						<input type="text" name="gwid" id="gwid" value="<?php echo get_option('gwid'); ?>" />
					</li>
					<li>
						<label for="authpuppy-connect">Active Authpuppy-Connect</label>
						<input type="checkbox" name="authpuppy-connect" id="authpuppy-connect" <?php if (file_exists(WP_PLUGIN_DIR . '/authpuppy/ap-connect.on')) echo "checked='checked'"; ?> />
					</li>
					<li>
						<label for="authpuppy-auto-connect">Active Authpuppy Auto-Connect</label>
						<input type="checkbox" name="authpuppy-auto-connect" id="authpuppy-auto-connect" <?php if (file_exists(WP_PLUGIN_DIR . '/authpuppy/auto-connect.on')) echo "checked='checked'"; ?> />
					</li>
					<li>
						<input type="hidden" name="action" value="optionSave" />
						<input type="submit" class="button-primary" value="Save the options" />
					</li>
				</ul>
			</form>
		</div>
<?php
	}
	
	function optionSave()
	{
		update_option('gwid', $_POST['gwid']);
		
		if ($_POST['authpuppy-connect'])
			fclose(fopen(WP_PLUGIN_DIR . '/authpuppy/ap-connect.on', 'w+'));
		else if(file_exists(WP_PLUGIN_DIR . '/authpuppy/ap-connect.on'))
			unlink(WP_PLUGIN_DIR . '/authpuppy/ap-connect.on');
		
		if ($_POST['authpuppy-auto-connect'])
			fclose(fopen(WP_PLUGIN_DIR . '/authpuppy/auto-connect.on', 'w+'));
		else if(file_exists(WP_PLUGIN_DIR . '/authpuppy/auto-connect.on'))
			unlink(WP_PLUGIN_DIR . '/authpuppy/auto-connect.on');
		
		if ($_POST['authpuppy-connect'])
			update_option('authpuppy-connect', true);
		else
			update_option('authpuppy-connect', false);
		
		echo '<div class="updated below-h2" id="message"><p>Option <b>succesfully</b> updated<br/>';
		optionForm();
	}
?>