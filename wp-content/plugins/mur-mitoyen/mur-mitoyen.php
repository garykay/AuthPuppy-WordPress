<?php
/*
Plugin Name: Mur Mitoyen
Plugin URI: http://mur.mitoyen.net
Description: Widget which display local events in MTL from Le Mur Mitoyen
Version: 1.0
Author: Adcaelo
Author URI: http://adcaelo-online.com
*/
	
	function mur_mitoyen_init()
	{
		register_sidebar_widget( 'Mur Mitoyen', 'mur_mitoyen');
		register_widget_control( 'Mur Mitoyen', 'mur_mitoyen_control', 400);
	}
	add_action("plugins_loaded", "mur_mitoyen_init");
	
	function mur_mitoyen()
	{
		$options = mur_mitoyen_options();
		
		$param_manual = false;
		$param_auto = false;
		//If nothing found => Berry Uqam Metro Station (why? why not !)
		$param_mm = "lat=45.515226&long=-73.561127";
		
		//Get param in plugin options
		if ($options['latitute'] != "" and $options['longitude'] != "")
			$param_manual = "lat=".$options['latitute']."&lon=".$options['longitude'];
			
		//Get param with authpuppy api
		global $authpuppy_api;
		if ($authpuppy_api->values->Latitude != "" and $authpuppy_api->values->Longitude != "")
			$param_auto = "lat=".$authpuppy_api->values->Latitude."&lon=".$authpuppy_api->values->Longitude;	
		
		if ( (($options['mode'] == "auto") and ($param_auto != false)) or ($param_manual == false) )
			$param_mm = $param_auto;
		
		if ( (($options['mode'] == "man") and ($param_manual != false)) or ($param_auto == false) )
			$param_mm = $param_manual;
		
		$param .= $param_mm."&km=".$options['rayon']."&max=".$options['max'];
		
		if (($param_mm == $param_auto) && ($authpuppy_api->values->Name != ""))
			echo "<h2>&Eacute;v&eacute;nements &agrave; proximit&eacute; de ".$authpuppy_api->values->Name."</h2>";
		else
			echo "<h2>".$options['title']."</h2>";
?>
		<!-- Local Event with Le Mur Mitoyen -->
		<link rel="stylesheet" type="text/css" href="http://mur.mitoyen.net/events/js/syndication.css" />
		<script language="JavaScript"
				type="text/JavaScript"
				src="http://mur.mitoyen.net/events/js/syndicationproximite.php?<?php echo $param; ?>"
		>
		</script>
<?php
	}
	/* Widget options */
	function mur_mitoyen_options()
	{
		//Default location = Current location get with authpuppy api
		global $authpuppy_api;
		if ($authpuppy_api->values->Latitude != "" and $authpuppy_api->values->Longitude != "")
		{
			$title = "&Eacute;v&eacute;nements &agrave; proximit&eacute; de ".$authpuppy_api->values->Name;
			$rayon = 1;
			$max = 10;
			$mode = "auto";
			$lat = $authpuppy_api->values->Latitude;
			$lon = $authpuppy_api->values->Longitude;
		}
		//If no authpuppy api or no location
		//default location = berry uqam metro station
		else
		{
			$title = "&Eacute;v&eacute;nements &agrave; proximit&eacute; de Metro Berry UQAM";
			$rayon = 1;
			$max = 10;
			$mode = "man";
			$lat = 45.515226;
			$lon = -73.561127;
		}
		
		$defaults = array( 
							'title' => $title,
							'rayon' => $rayon,
							'max' => $max,
							'mode' => $mode,
							'latitude' => $lat,
							'longitude' => $lon
						);
		$options = (array) get_option('mur_mitoyen');
		
		foreach ( $defaults as $key => $value )
			if ( !isset($options[$key]) )
				$options[$key] = $defaults[$key];
		
		return $options;
	}
		
	function mur_mitoyen_control()
	{
		if ($_POST['mm-submit']) 
		{
			$newoptions['title'] = strip_tags(stripslashes($_POST['mm-title']));
			$newoptions['rayon'] = (float) $_POST['mm-rayon'];
			$newoptions['max'] = (int) $_POST['mm-max'];
			$newoptions['mode'] = (string) $_POST['mm-mode'];
			$newoptions['latitude'] = (float) $_POST['mm-latitude'];
			$newoptions['longitude'] = (float) $_POST['mm-longitude'];
			
			//If Reset
			if (isset($_POST['mm-reset']))
			{
				update_option('mur_mitoyen', null);
				$options = $newoptions = mur_mitoyen_options();
			}
			else
				$options = mur_mitoyen_options();
			
			//if option <> new options
			if ( $options != $newoptions ) 
			{
				$options = $newoptions;
				update_option('mur_mitoyen', $options);
			}
		}
		else
			$options = mur_mitoyen_options();
		
		$title = attribute_escape($options['title']);
		$rayon = (float) $options['rayon'];
		$max = (int) $options['max'];
		$mode = (string) $options['mode'];
		$latitude = (float) $options['latitude'];
		$longitude = (float) $options['longitude'];
	?>
		<fieldset>
				<legend>Basic options:</legend>
				<p style="text-align:left;margin-left:30px;">				
					<label style="line-height:25px;">
						<input type="text" id="mm-title" name="mm-title" size="45" value="<?php echo $title ?>" />
					</label>
					<br />
					<label style="line-height:25px;">
						<input type="text" id="mm-rayon" name="mm-rayon" size="5" value="<?php echo $rayon ?>" /> km maximum
					</label>
					<br />
					<label style="line-height:25px;">
						<input type="text" id="mm-max" name="mm-max" size="5" value="<?php echo $max ?>" /> events maximum
					</label>
				</p>
		</fieldset>	
		<fieldset>
			<legend>Location Mode:</legend>
			<ul>
				<li>
					<label>
						<input type="radio" id="mm-mode-auto" name="mm-mode" value="auto" <?php if ($mode == "auto") echo 'checked="checked"'; ?> />
						Automatic : get the location with authpuppy API
					</label>
				</li>
				<li>
					<label> 
						<input type="radio" id="mm-mode-manual" name="mm-mode" value="man" <?php if ($mode == "man") echo 'checked="checked"'; ?> />
						Manual : get the location with value :
					</label>
					<p>
						<label style="line-height:25px;">
							Latitude: <input type="text" id="mm-latitude" name="mm-latitude" size="20" value="<?php echo $latitude ?>" />
						</label><br />
						<label style="line-height:25px;">
							Longitude: <input type="text" id="mm-longitude" name="mm-longitude" size="20" value="<?php echo $longitude ?>" />
						</label><br />
					</p>
				</li>
				<li>
					<p>
						<label>
							<input type="checkbox" name="mm-reset" value="reset" /> Reset
						</label>
					</p>
				</li>
			</ul>
		</fieldset>
		<input type="hidden" id="mm-submit" name="mm-submit" value="1" />
<?php
	}
?>