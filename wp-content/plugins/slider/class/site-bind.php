<?php
	/* Class SiteBind */
	class SiteBind
	{
		private $site;			//site		=> bigint(20) site
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
			return get_option("siteBindTableName");
		}
		public function setTableName($tableName = "slider_site_bind")
		{
			update_option("siteBindTableName", $tableName);
		}
		
		public function getBinds()
		{
			//Get All Sites
			global $wpdb;
			
			//Select all bind
			$wp_binds = $wpdb->get_results("SELECT * FROM ".$this->getTableName().";");
			
			//Create an array of Bind Objects
			$binds = array();
			foreach ( $wp_binds as $wp_bind )
			{
				//Create site object
				$bind = new Bind();
				
				//Add Site Object information
				$bind->__set('slide', $wp_bind->slide);
				$bind->__set('site', $wp_bind->site);
				
				//Add this Site Object in Site Array
				$binds[] = $bind;
			}
			return $binds;
		}
		
		public function getBindsFor($for, $obj=false)
		{
			if ($for != 'slide' and $for != 'site')
				return false;
				
			//Get All Sites
			global $wpdb;
			
			//Select all bind and order by Slide or Site
			if ($obj == false)
				$wp_binds = $wpdb->get_results("SELECT * FROM ".$this->getTableName().";");
			//Select all bind for a specific Slide or Site
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
				$bind->__set('site', $wp_bind->site);
				
				//Add this Bind Object in Bind Array
				$binds[] = $bind;
			}
			return $binds;
		}
		
		public function getBind($site, $slide)
		{
			//Get All Sites
			global $wpdb;
			
			$wp_bind = false;
			$wp_bind = $wpdb->get_row("SELECT * FROM ".$this->getTableName()." WHERE site=".$site->__get('id')." AND slide=".$slide->__get('id').";");
			
			if ($wp_bind)
			{
				//Create Bind object
				$bind = new SiteBind();
				
				//Add Bind Object information
				$bind->__set('slide', $wp_bind->slide);
				$bind->__set('site', $wp_bind->site);
			
				return $bind;
			}
			else
				return false;
		}
		
		public function setBind($site, $slide)
		{
			global $wpdb;
			if (!$this->getBind($site, $slide))
			{
				$data = array(
								'site' => $site->__get('id'),
								'slide' => $slide->__get('id')
							);
				
				//%s as string; %d as decimal number; and %f as float.
				$format = array('%d', '%d');
				$wpdb->insert($this->getTableName(), $data, $format );
			}
		}
		
		public function removeBind($bind)
		{
			global $wpdb;
			$wpdb->query("DELETE FROM ".$this->getTableName()." WHERE slide=".$bind->__get('slide')." AND site=".$bind->__get('site').";");
		}
		
		public function emptyForSite($site)
		{
			global $wpdb;
			$wpdb->query("DELETE FROM ".$this->getTableName()." WHERE site=".$site->__get('id').";");
		}
	}
?>