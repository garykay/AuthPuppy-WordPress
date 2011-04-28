<?php
/*
Plugin Name: Authpuppy
Plugin URI: http://www.authpuppy.org
Description: Authpuppy Connect & Authpuppy API access
Version: 0.1
Author: Adcaelo
Author URI: http://adcaelo-online.com
*/
	//Plugin init
	register_activation_hook(__FILE__, 'authpuppy_register');
	function authpuppy_register()
	{
		update_option('authpuppy-connect', true);
		update_option('authpuppy-auto-connect', true);
	}

	// Session start
	add_action('template_redirect', 'authpuppy_init', 0);
	function authpuppy_init () {
		$session_id = session_id();
		if(empty($session_id)) 
			session_start();
		//	after init and after when the wp query string is parsed but before anything is displayed
		//	add_action(‘template_redirect’, ‘service_smtp_init’, 0);
		// thanks to http://www.spirion.fr/wordpress/utiliser-les-sessions-avec-wordpress/
	}

	/*
		include class : Message & Device
	*/
	include_once (WP_PLUGIN_DIR . '/authpuppy/class/api.php');
	include_once (WP_PLUGIN_DIR . '/authpuppy/view/fonction.php');
	
	/*
		include view : Message Device
	*/
	//include_once (WP_PLUGIN_DIR . '/push-notification/view/message.php');
	//include_once (WP_PLUGIN_DIR . '/push-notification/view/device.php');

	add_action("wp_head", "authpuppy_header", 1);
	add_action("admin_head", "authpuppy_header", 1);
	//JS and CSS not search / not admin
	function authpuppy_header() 
	{
		global $authpuppy_api;
		global $gwid;
		
		if ($_SESSION['time'] < time())
		{
			unset($_SESSION['time']);
			unset($_SESSION['gwid']);
		}
		
		if (isset($_GET['gwid']))
		{
			$_SESSION['gwid'] = $gwid = $_GET['gwid'];
			$_SESSION['time'] = time() + (60 *60);	//For 1 hours
		}
		else if ($_SESSION['time'] > time())
			$gwid = $_SESSION['gwid'];
		else if (get_option('gwid') != "")
			$gwid = get_option('gwid');
		else
			$gwid = false;
		
		//Get Data from Authpuppy API
		$api = new API();
		
		$authpuppy_api = $api->getNode($gwid);
		// if we need action not in dashboard
	}
	
	add_action('init', 'authpuppy_auto_login');
	function authpuppy_auto_login()
	{
		/* The Authpuppy Connect */
		if ((file_exists(WP_PLUGIN_DIR . '/authpuppy/ap-connect.on')) && ($_GET['identityname']))
		{
			$creds = array();
			$creds['user_login'] = $_GET['identityname'];
			$creds['user_password'] = 'authpuppypasswordbyadcaelo';
			$creds['remember'] = false;
			$user = wp_signon( $creds, false );
			/*
			if ( is_wp_error($user) )
				echo $user->get_error_message();
			*/
		}
	}
	
	/* The Authpuppy Connect */
	if (!function_exists(wp_authenticate))
	{
		function wp_authenticate($username, $password)
		{
			require_once( ABSPATH . 'wp-includes/class-phpass.php');
			require_once(ABSPATH . WPINC . '/registration.php');
			
			if ( '' == $username )
				return new WP_Error('empty_username', __('<strong>ERROR</strong>: The username field is empty.'));
			if ( '' == $password )
				return new WP_Error('empty_password', __('<strong>ERROR</strong>: The password field is empty.'));
			
			if (username_exists($username))							//Check Local User
			{
				$user = get_userdatabylogin($username);						//Get User data
				$wp_hasher = new PasswordHash(8, TRUE);
				if ($wp_hasher->CheckPassword($password, $user->user_pass))	//If username/pwd is good => local user
					return new WP_User($user->ID);							//Log user
			}
			else if (!file_exists(WP_PLUGIN_DIR . '/authpuppy/ap-connect.on'))
				return new WP_Error('incorrect_password', __('<strong>ERROR</strong>: Mauvais mot de passe. (Authpuppy Connect disable)'));
			
			$generic_password = "authpuppypasswordbyadcaelo"; 		//Generic pwd so we can auto-login user!
			$api = New API('user');
			$api = $api->getUser($username, $password);				//Get User from Authpuppy
			
			if ($api == false)										//No API
			{
				do_action( 'wp_login_failed', $username );
				return new WP_Error('incorrect_username', __('<strong>ERROR</strong>: Aucune connexion à Auhtpuppy'));
			}
			else if ($api->result == 0)								//No Callback
			{
				do_action( 'wp_login_failed', $username );
				return new WP_Error('incorrect_username', __('<strong>ERROR</strong>: Aucun retour Authpuppy '));
			}
			else if ($api->values->auth == 0)						//Bad Login/PWD
			{
				do_action( 'wp_login_failed', $username );
				return new WP_Error('incorrect_username', __('<strong>ERROR</strong>: Login ou Mot de passe Auhtpuppy incorrect'));
			}
			else
			{
				$redirect_to = $api->values->redirect;
			}
			
			if (!username_exists($username))						//User exist on authpuppy but not in WP so we copy it!
			{
				wp_create_user( $username, $generic_password, time()."@yopmail.com" );
				$user = get_userdatabylogin($username);
			}
			
			return new WP_User($user->ID);							//Connect User
		}
	}
	/* End of Authpuppy Connect */
	
	// create custom plugin settings menu
	add_action('admin_menu', 'authpuppy_menu');
	function authpuppy_menu()
	{
		//create new top-level menu
		add_menu_page('Authpuppy Options', 'Authpuppy', 'manage_options', 'Authpuppy', 'defineOption', plugins_url('/images/icon.png', __FILE__));
		add_submenu_page( "Authpuppy", "Create a new Portal", "Create a new portal", "manage_options", "authpuppyFct", "authpuppyFct");
	}
	
	//Admin Action
	function authpuppyFct()
	{
		if (isset($_GET['action']))
			$action = $_GET['action'];
		else if (isset($_POST['action']))
			$action = $_POST['action'];
		else
			$action = "createForm";
		
		$action();
	}
	
	function defineOption()
	{
		echo get_option('_wpnonce_add-blog');
		
		if (isset($_POST['action']))
			$action = $_POST['action'];
		else
			$action = "optionForm";
		$action();
	}
	
	/* Widgets */
	include_once (WP_PLUGIN_DIR . '/authpuppy/widget.php');
	
	/* BuddyPress Fix for Authpuppy */
	function user_row_actions_bp_view($actions, $user_object)
	{
		global $bp;
		$actions['view'] = '<a href="' . bp_core_get_user_domain($user_object->ID) . '">' . __('View Profile') . '</a>';
		
		return $actions;
	}
	add_filter('user_row_actions', 'user_row_actions_bp_view', 10, 2);
?>