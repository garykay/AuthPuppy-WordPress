<?php
/*
Plugin Name: Slider
Plugin URI: http://adcaelo-online.com
Description: Create content you can insert into your theme so give the same content in numerous page and only modify them once. Read readme.txt
Version: 0.5
Author: Adcaelo
Author URI: http://adcaelo-online.com
*/

	/*
		include class : Bind, Slide & User
	*/
	include_once (WP_PLUGIN_DIR . '/slider/class/site.php');
	include_once (WP_PLUGIN_DIR . '/slider/class/site-bind.php');
	include_once (WP_PLUGIN_DIR . '/slider/class/user.php');
	include_once (WP_PLUGIN_DIR . '/slider/class/user-bind.php');
	include_once (WP_PLUGIN_DIR . '/slider/class/slide.php');
	
	/*
		include view : Admin, Choose & Author
	*/
	include_once (WP_PLUGIN_DIR . '/slider/view/admin.php');
	include_once (WP_PLUGIN_DIR . '/slider/view/choose.php');
	include_once (WP_PLUGIN_DIR . '/slider/view/author.php');
	
	register_activation_hook(__FILE__,'slider_install');
	function slider_install()
	{
		global $wpdb;
		
		$wpdb->query("CREATE TABLE IF NOT EXISTS  `slider_slide` (
						`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
						`title` VARCHAR( 150 ) NOT NULL ,
						`content` TEXT NOT NULL ,
						`image` VARCHAR( 250 ) NOT NULL ,
						`url` VARCHAR( 250 ) NULL
						) ENGINE = MYISAM ;");
		
		$wpdb->query("CREATE TABLE IF NOT EXISTS  `slider_user_bind` (
						`user` bigint(20) NOT NULL ,
						`slide` bigint(20) NOT NULL ,
						PRIMARY KEY (  `user` ,  `slide` )
						) ENGINE = MYISAM ;");
		
		$wpdb->query("CREATE TABLE IF NOT EXISTS  `slider_site_bind` (
						`site` bigint(20) NOT NULL ,
						`slide` bigint(20) NOT NULL ,
						PRIMARY KEY (  `site` ,  `slide` )
						) ENGINE = MYISAM ;");
	}
	
	
	/*
	//JS and CSS not search / not admin
	add_action("wp_head", "slider_header");
	function slider_header() 
	{
		if (!is_search())
			wp_enqueue_script('authpuppy.slider', WP_PLUGIN_DIR . '/slider/js/slider.js');
	}
	*/
	
	/* wp defaut setting page */
	// create custom plugin settings menu
	add_action('admin_menu', 'slider_menu');
	function slider_menu()
	{
		//create new top-level menu
		add_menu_page('Slider', 'Slider', 'publish_posts', 'Slider', 'sliderAuthor', plugins_url('/images/icon.png', __FILE__));
		add_submenu_page( "Slider", "Slider", "Give Access", "administrator", "sliderAdmin", "sliderAdmin");
		add_submenu_page( "Slider", "Slider", "Choose Slide", "administrator", "sliderChoose", "sliderChoose");

	}
	
	
	
	/* Widgets */
	function sliderInit()
	{
	  register_sidebar_widget(__('Slider'), 'sliderWidget');
	}
	add_action("plugins_loaded", "sliderInit");
	
	function sliderWidget()
	{
		echo '<div id="authslider">';
			include_once (WP_PLUGIN_DIR . '/slider/view/slider.php');
		echo '</div>';
	}
	
	
	//Admin Action
	function sliderAdmin()
	{
		if (isset($_POST['action']))
			$action = $_POST['action'];
		else
			$action = "showAdmin";
			
		$action();
	}
	
	function sliderChoose()
	{
		if (isset($_POST['action']))
			$action = $_POST['action'];
		else
			$action = "showChoose";
			
		$action();
	}
	
	//Editor Action
	function sliderAuthor()
	{
		if (isset($_POST['action']))
			$action = $_POST['action'];
		else
			$action = "showAuthor";
			
		$action();
	}
?>