<?php
	/* Class User */
	class User
	{
		private $id;			//ID
		private $login;			//user_login
		private $niceName;		//user_nicename
		private $email;			//user_email
		private $url;			//user_url
		private $name;			//display_name
		private $user_level;	// $sql = "SELECT meta_value FROM ".$wpdb->usermeta." WHERE user_id = ".$wp_user->ID." AND meta_key = '".$wpdb->prefix."user_level';";
		
		public function __set($key, $val)
		{
			$this->$key = $val;
		}
		public function __get($key)
		{
			return $this->$key;
		}
		
		public function getUsers()
		{
			//Get All Users
			global $wpdb;
			
			//Select all Users
			$wp_users = $wpdb->get_results("SELECT * FROM ".$wpdb->users.";");
			
			//Create an array of User Objects
			$users = array();
			foreach ( $wp_users as $wp_user )
			{
				//Create user object
				$user = new User();
				$sql = "SELECT meta_value FROM ".$wpdb->usermeta." WHERE user_id = ".$wp_user->ID." AND meta_key = '".$wpdb->prefix."user_level';";
				$wp_level = $wpdb->get_var($sql);
				
				if ($wp_level >= 2)
				{
					//Add User Object information
					$user->__set('id', $wp_user->ID);
					$user->__set('login', $wp_user->user_login);
					$user->__set('niceName', $wp_user->user_nicename);
					$user->__set('email', $wp_user->user_email);
					$user->__set('url', $wp_user->user_url);
					$user->__set('name', $wp_user->display_name);
					$user->__set('user_level', $wp_level);
					
					//Add this User Object in User Array
					$users[] = $user;
				}
			}
			return $users;
		}
		
		public function getUser($id)
		{
			//Get All Users
			global $wpdb;
			
			$wp_user = false;
			//Select all user id and username (login) Not Admin
			$wp_user = $wpdb->get_row("SELECT * FROM ".$wpdb->users." WHERE ID = ".$id.";");
			
			if ($wp_user)
			{
				//Create user object
				$user = new User();
				
				//Get Level
				$sql = "SELECT meta_value FROM ".$wpdb->usermeta." WHERE user_id = ".$wp_user->ID." AND meta_key = '".$wpdb->prefix."user_level';";
				$wp_level = $wpdb->get_var($sql);
				
				
				//Add User Object information
				$user->__set('id', 	$wp_user->ID);
				$user->__set('login', $wp_user->user_login);
				$user->__set('niceName', $wp_user->user_nicename);
				$user->__set('email', $wp_user->user_email);
				$user->__set('url', $wp_user->user_url);
				$user->__set('name', $wp_user->display_name);
				$user->__set('user_level', $wp_level);
				
				return $user;
			}
			else
				return false;
		}
	}
?>