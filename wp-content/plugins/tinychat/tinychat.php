<?php
/*
Plugin Name: Tinychat
Plugin URI: http://adcaelo-online.com
Description: Widget which display chat room provide by Tinychat.com
Version: 1.0
Author: Adcaelo
Author URI: http://adcaelo-online.com
*/
	
	function tinychat_init()
	{
		register_sidebar_widget( 'TinyChat', 'tinychat');
		register_widget_control( 'TinyChat', 'tinychat_control', 400);
	}
	add_action("plugins_loaded", "tinychat_init");
	
	function tinychat()
	{
		$tiny = 'key : "'.get_option('tinychat_api_key').'", ';
		if (is_user_logged_in())
		{
			global $current_user;
			get_currentuserinfo();
			$tiny .= 'nick : "'.$current_user->user_login.'", ';
		}
		global $authpuppy_api;
		if ($authpuppy_api->values->Name != "")
			$tiny .= 'room : "Chat room : '.$authpuppy_api->values->Name.'", join: "auto", ';
			
		$tiny .= 'change : "none", api: "none"';
?>
		<script type='text/javascript'> 
			var tinychat = { <?php echo $tiny; ?> };
		</script> 
		<script src="http://tinychat.com/js/embed.js"></script> 
		<div id="client"></div>
<?php
	}
		
	function tinychat_control()
	{
		if ($_POST['tinychat_api_key']) 
			update_option('tinychat_api_key', $_POST['tinychat_api_key']);
?>
		TinyChat API Key (<a href="http://tinychat.com/developer/dashboard">Ask for one</a>)
		<br />
		<input type="text" id="tinychat_api_key" name="tinychat_api_key" value="<?php echo get_option('tinychat_api_key'); ?>" />
<?php
	}
?>