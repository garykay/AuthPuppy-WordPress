<?php
	/* Class UserBind */
	class UserBind
	{
		private $user;			//user		=> bigint(20) user
		private $slide;			//slide		=> bigint(20) slide
		
		public function __set($key, $val)
		{
			$this->$key = $val;
		}
		public function __get($key)
		{
			return $this->$key;
		}
		
		public function getTableName()
		{
			$this->setTableName();
			return get_option("userBindTableName");
		}
		public function setTableName($tableName = "slider_user_bind")
		{
			update_option("userBindTableName", $tableName);
		}
		
		public function getBinds()
		{
			//Get All Users
			global $wpdb;
			
			//Select all bind
			$wp_binds = $wpdb->get_results("SELECT * FROM ".$this->getTableName().";");
			
			//Create an array of Bind Objects
			$binds = array();
			foreach ( $wp_binds as $wp_bind )
			{
				//Create user object
				$bind = new Bind();
				
				//Add User Object information
				$bind->__set('slide', $wp_bind->slide);
				$bind->__set('user', $wp_bind->user);
				
				//Add this User Object in User Array
				$binds[] = $bind;
			}
			return $binds;
		}
		
		public function getBindsFor($for, $obj=false)
		{
			if ($for != 'slide' and $for != 'user')
				return false;
				
			//Get All Users
			global $wpdb;
			
			//Select all bind and order by Slide or User
			if ($obj == false)
				$wp_binds = $wpdb->get_results("SELECT * FROM ".$this->getTableName().";");
			//Select all bind for a specific Slide or User
			else
				$wp_binds = $wpdb->get_results("SELECT * FROM ".$this->getTableName()." WHERE ".$for."=".$obj->__get('id').";");
			
			//Create an array of Binded Objects
			$binds = array();
			foreach ( $wp_binds as $wp_bind )
			{
				//Create Bind object
				$bind = new Bind();
				
				//Add Bind Object information
				$bind->__set('slide', $wp_bind->slide);
				$bind->__set('user', $wp_bind->user);
				
				//Add this Bind Object in Bind Array
				$binds[] = $bind;
			}
			return $binds;
		}
		
		public function getBind($user, $slide)
		{
			//Get All Users
			global $wpdb;
			
			$wp_bind = false;
			$wp_bind = $wpdb->get_row("SELECT * FROM ".$this->getTableName()." WHERE user=".$user->__get('id')." AND slide=".$slide->__get('id').";");
			
			if ($wp_bind)
			{
				//Create Bind object
				$bind = new UserBind();
				
				//Add Bind Object information
				$bind->__set('slide', $wp_bind->slide);
				$bind->__set('user', $wp_bind->user);
			
				return $bind;
			}
			else
				return false;
		}
		
		public function setBind($user, $slide)
		{
			global $wpdb;
			if (!$this->getBind($user, $slide))
			{
				$data = array(
								'slide' => $slide->__get('id'),
								'user' => $user->__get('id')
							);
				
				//%s as string; %d as decimal number; and %f as float.
				$format = array('%d', '%d');
				$wpdb->insert($this->getTableName(), $data, $format );
			}
		}
		
		public function removeBind($bind)
		{
			global $wpdb;
			$wpdb->query("DELETE FROM ".$this->getTableName()." WHERE slide=".$bind->__get('slide')." AND user=".$bind->__get('user').";");
		}
		
		public function emptyForUser($user)
		{
			global $wpdb;
			$wpdb->query("DELETE FROM ".$this->getTableName()." WHERE user=".$user->__get('id').";");
		}
	}
?>