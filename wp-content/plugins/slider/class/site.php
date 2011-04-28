<?php
	/* Class Site */
	class Site
	{
		private $id;			//blog_id
		private $site;			//site_id
		private $domain;		//domain
		private $path;			//path
		
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
			global $wpdb;
			
			$id = explode('_', $wpdb->prefix);
			$id = (int) $id[count($id) - 2];
			
			if (!is_int($id))
				return $wpdb->prefix."blogs";
			else
			{	
				$prefix = preg_replace("/_\d+_$/", "_", $wpdb->prefix);
				return $prefix."blogs";
			}
		}
		
		public function getSites()
		{
			//Get All sites
			global $wpdb;
			
			//Select all sites
			$wp_sites = $wpdb->get_results("SELECT * FROM ".$this->getTableName().";");
			
			//Create an array of site Objects
			$Sites = array();
			foreach ( $wp_sites as $wp_site )
			{
				//Create Site object
				$site = new Site();
				
				//Add Site Object information
				$site->__set('id', $wp_site->blog_id);
				$site->__set('site', $wp_site->site_id);
				$site->__set('domain', $wp_site->domain);
				$site->__set('path', $wp_site->path);
				
				//Add this Site Object in site Array
				$sites[] = $site;
			}
			return $Sites;
		}
		
		public function getSite($id = "current")
		{
			global $wpdb;
			
			//If no id => get the current site
			if ($id == "current")
			{
				$id = explode('_', $wpdb->prefix);
				
				if (count($id) > 2)
					$id = (int) $id[count($id) - 2];
				else
					$id = 1;
			}
			
			$wp_site = false;
			$wp_site = $wpdb->get_row("SELECT * FROM ".$this->getTableName()." WHERE blog_id = ".$id.";");
			
			if ($wp_site)
			{
				//Create Site object
				$site = new Site();
				
				//Add site Object information
				$site->__set('id', $wp_site->blog_id);
				$site->__set('site', $wp_site->site_id);
				$site->__set('domain', $wp_site->domain);
				$site->__set('path', $wp_site->path);
				
				return $site;
			}
			else
				return false;
		}
	}
?>