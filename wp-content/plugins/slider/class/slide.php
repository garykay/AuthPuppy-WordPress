<?php
	/* Class Slide */
	class Slide
	{
		private $id;			//id		=> int auto_increment
		private $title;			//title		=> string(150)
		private $content;		//content	=> plain text
		private $image;			//image		=> string(250) [image url on local server]
		private $url;			//url		=> string(250)	[website or other url / link]
		
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
			return get_option("slideTableName");
		}
		public function setTableName($tableName = "slider_slide")
		{
			update_option("slideTableName", $tableName);
		}
		
		public function getSlides()
		{
			//Get All Users
			global $wpdb;
			
			//Select all slide
			$wp_slides = $wpdb->get_results("SELECT * FROM ".$this->getTableName().";");
			
			//Create an array of Slide Objects
			$slides = array();
			foreach ( $wp_slides as $wp_slide )
			{
				//Create Slide object
				$slide = new Slide();
				
				//Add Slide Object information
				$slide->__set('id', $wp_slide->id);
				$slide->__set('title', stripslashes($wp_slide->title));
				$slide->__set('content', stripslashes($wp_slide->content));
				$slide->__set('image', $wp_slide->image);
				$slide->__set('url', $wp_slide->url);
				
				//Add this Slide Object in Slide Array
				$slides[] = $slide;
			}
			return $slides;
		}
		
		public function getSlidesFor($for, $obj=false)
		{
			if ($for != 'user' and $for != 'site')
				return false;
			
			//Create a bind object
			$bind = ucfirst($for).'Bind';
			$bind = new $bind();
			
			//Get All Users
			global $wpdb;
			
			//Select all slide for this User / Site
			if ($obj == false)
				$sql = "SELECT * FROM ".$bind->getTableName().";";
			//Select all slide
			else
				$sql = "SELECT * FROM ".$bind->getTableName()." WHERE ".$for."=".$obj->__get('id').";";
			
			$wp_slides = $wpdb->get_results($sql);
			
			//Create an array of Slide Objects
			$slides = array();
			foreach ( $wp_slides as $wp_slide )
				$slides[] = $this->getSlide($wp_slide->slide);
				
			return $slides;
		}
		
		public function getSlide($id)
		{
			//Get All Users
			global $wpdb;
			
			//Select all slide
			$wp_slide = false;
			$wp_slide = $wpdb->get_row("SELECT * FROM ".$this->getTableName()." WHERE id=".$id.";");
			
			if ($wp_slide)
			{
				//Create Slide object
				$slide = new Slide();
				
				//Add Slide Object information
				$slide->__set('id', $wp_slide->id);
				$slide->__set('title', stripslashes($wp_slide->title));
				$slide->__set('content', stripslashes($wp_slide->content));
				$slide->__set('image', $wp_slide->image);
				$slide->__set('url', $wp_slide->url);
				
				return $slide;
			}
			else
				return false;
		}
		
		public function setSlide($slide)
		{
			global $wpdb;
			
			//Save
			if ($slide->__get('id') == null)
			{
				$data = array(
								'title' => $slide->__get('title'),
								'content' => $slide->__get('content'),
								'image' => $slide->__get('image'),
								'url' => $slide->__get('url')
							);
				
				//%s as string; %d as decimal number; and %f as float.
				$format = array('%s', '%s', '%s', '%s');
				
				$wpdb->insert($this->getTableName(), $data, $format );
				$slide->__set('id', $wpdb->insert_id);
			}
			//Update
			else
			{
				$data = array(
								'id' => $slide->__get('id'),
								'title' => $slide->__get('title'),
								'content' => $slide->__get('content'),
								'image' => $slide->__get('image'),
								'url' => $slide->__get('url')
							);
				
				//%s as string; %d as decimal number; and %f as float.
				$format = array('%d', '%s', '%s', '%s', '%s');
				
				$wpdb->update($this->getTableName(), $data, array('id' =>  $slide->__get('id')), $format, array('%d'));
			}
			return $slide;
		}
		
		public function removeSlide($slide)
		{
			$bindObj = new SiteBind();
			global $wpdb;
			$wpdb->query("DELETE FROM ".$this->getTableName()." WHERE id = ".$slide->__get('id').";");
			$wpdb->query("DELETE FROM ".$bind->getTableName()." WHERE slide = ".$slide->__get('id').";");
			
			unlink (WP_PLUGIN_DIR . "/slider/uploads/" . $slideObj->__get('id'));
		}
	}
?>