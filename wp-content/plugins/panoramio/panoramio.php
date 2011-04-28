<?php
/*
Plugin Name: Panoramio
Plugin URI: http://adcaelo-online.com
Description: Widget which display  photo from Panoramio.com
Version: 1.0
Author: Adcaelo
Author URI: http://adcaelo-online.com
*/
	
	function panoramio_init()
	{
		register_sidebar_widget( 'Panoramio', 'panoramio');
		register_widget_control( 'Panoramio', 'panoramio_control', 400);
	}
	add_action("plugins_loaded", "panoramio_init");
	
	
	//JS and CSS not search / not admin
	add_action("wp_head", "panoramio_header");
	function panoramio_header() 
	{
		if (!is_search())
		{
			//wp_enqueue_script('panoramio.api', 'http://www.panoramio.com/wapi/wapi.js?v=1&hl=fr');
			echo '<script type="text/javascript" src="http://www.panoramio.com/wapi/wapi.js?v=1"></script>';
		}
	}

	/* Widget options */
	function panoramio_options()
	{
		//Default location = Current location get with authpuppy api
		global $authpuppy_api;
		if ($authpuppy_api->values->Latitude != "" and $authpuppy_api->values->Longitude != "")
		{
			$title = "Photographies &agrave; proximit&eacute; de ".$authpuppy_api->values->Name;
			$rayon = 0.001;
			$mode = "auto";
			$lat = $authpuppy_api->values->Latitude;
			$lon = $authpuppy_api->values->Longitude;
		}
		//If no authpuppy api or no location
		//default location = berry uqam metro station
		else
		{
			$title = "Photographies &agrave; proximit&eacute; de Metro Berry UQAM";
			$rayon = 0.001;
			$mode = "man";
			$lat = 45.515226;
			$lon = -73.561127;
		}
		
		$defaults = array( 
							'title' => $title,
							'rayon' => $rayon,
							'mode' => $mode,
							'latitude' => $lat,
							'longitude' => $lon
						);
		
		$options = (array) get_option('panoramio');
		
		foreach ( $defaults as $key => $value )
			if ( !isset($options[$key]) )
				$options[$key] = $defaults[$key];
		
		return $options;
	}
	
	function panoramio()
	{
		global $authpuppy_api;
		
		$options = panoramio_options();
		$coords = array("default" => false, "manual" => false, "auto" => false);
		
		//If nothing found => Berry Uqam Metro Station (why? why not !)
		$coords['default']['lat'] = 45.495;
		$coords['default']['lon'] = -73.586;
		
		//Get param in plugin options
		if ($options['latitute'] != "" and $options['longitude'] != "")
		{
			$coords['manual']['lat'] = 45.495;
			$coords['manual']['lon'] = -73.586;
		}
		
		//Get param with authpuppy api
		global $authpuppy_api;
		if ($authpuppy_api->values->Latitude != "" and $authpuppy_api->values->Longitude != "")
		{
			$coords['auto']['lat'] = $authpuppy_api->values->Latitude;
			$coords['auto']['lon'] = $authpuppy_api->values->Longitude;
		}
		
		if ( (($options['mode'] == "auto") and ($coords['auto'] != false)) or ($coords['manual'] == false) )
			$coords['default'] = $coords['auto'];
		
		if ( (($options['mode'] == "man") and ($coords['manual'] != false)) or ($coords['auto'] == false) )
			$coords['default'] = $coords['manual'];
		
		if (($coords['default'] == $coords['auto']) && ($authpuppy_api->values->Name != ""))
			echo "<h2>Photographies &agrave; proximit&eacute; de ".$authpuppy_api->values->Name."</h2>";
		else
			echo "<h2>".$options['title']."</h2>";
		
		$south = $coords['default']['lat'] - $options['rayon'];
		$west = $coords['default']['lon'] - $options['rayon'];
		$north = $coords['default']['lat'] + $options['rayon'];
		$east = $coords['default']['lon'] + $options['rayon'];
?>
		<div id="div_photo" style="float: right; margin: 10px 15px">
		  <a href="http://www.panoramio.com">Panoramio - Photos of the World</a>
		</div>
		<script type="text/javascript">
			var myRequest = {	'rect': {
											'sw': {
												'lat': <?php echo floatval($south); ?>,
												'lng': <?php echo floatval($west); ?>
													},
											'ne': {
												'lat': <?php echo floatval($north); ?>,
												'lng': <?php echo floatval($east); ?>
													}
										}
							};
			
			var myOptions = {
			  'width': 600,
			  'height': 400
			};
			
			var photo_widget = new panoramio.PhotoWidget('div_photo', myRequest, myOptions);
			photo_widget.setPosition(0);
		</script>
<?php	
	}
		
	function panoramio_control()
	{
		if ($_POST['pn-submit']) 
		{
			$newoptions['title'] = strip_tags(stripslashes($_POST['pn-title']));
			$newoptions['rayon'] = (float) $_POST['pn-rayon'];
			$newoptions['max'] = (int) $_POST['pn-max'];
			$newoptions['mode'] = (string) $_POST['pn-mode'];
			$newoptions['latitude'] = (float) $_POST['pn-latitude'];
			$newoptions['longitude'] = (float) $_POST['pn-longitude'];
			
			//If Reset
			if (isset($_POST['pn-reset']))
			{
				update_option('panoramio', null);
				$options = $newoptions = panoramio_options();
			}
			else
				$options = panoramio_options();
			
			//if option <> new options
			if ( $options != $newoptions ) 
			{
				$options = $newoptions;
				update_option('panoramio', $options);
			}
		}
		else
			$options = panoramio_options();

		
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
						<input type="text" id="pn-title" name="pn-title" size="45" value="<?php echo $title ?>" />
					</label>
					<br />
					<label style="line-height:25px;">
						<input type="text" id="pn-rayon" name="pn-rayon" size="5" value="<?php echo $rayon ?>" /> 0.001 => 1.112km, 0.0001 => 111.2 m
					</label>
				</p>
		</fieldset>	
		<fieldset>
			<legend>Location Mode:</legend>
			<ul>
				<li>
					<label>
						<input type="radio" id="pn-mode-auto" name="pn-mode" value="auto" <?php if ($mode == "auto") echo 'checked="checked"'; ?> />
						Automatic : get the location with authpuppy API
					</label>
				</li>
				<li>
					<label> 
						<input type="radio" id="pn-mode-manual" name="pn-mode" value="man" <?php if ($mode == "man") echo 'checked="checked"'; ?> />
						Manual : get the location with value :
					</label>
					<p>
						<label style="line-height:25px;">
							Latitude: <input type="text" id="pn-latitude" name="pn-latitude" size="20" value="<?php echo $latitude ?>" />
						</label><br />
						<label style="line-height:25px;">
							Longitude: <input type="text" id="pn-longitude" name="pn-longitude" size="20" value="<?php echo $longitude ?>" />
						</label><br />
					</p>
				</li>
				<li>
					<p>
						<label>
							<input type="checkbox" name="pn-reset" value="reset" /> Reset
						</label>
					</p>
				</li>
			</ul>
		</fieldset>
		<input type="hidden" id="pn-submit" name="pn-submit" value="1" />
<?php
	}
?>