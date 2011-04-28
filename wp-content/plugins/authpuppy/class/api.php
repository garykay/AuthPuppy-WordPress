<?php
	/* Class API*/
	class API
	{
		private $node_url;
		
		function __construct($type = "node")
		{
			$this->node_url = "http://auth.ilesansfil.org/authpuppy/ws/";
			if ($type == "node")
				$this->node_url = $this->node_url."?action=get&object_class=Node&object_id=";
			else if ($type == "user")
				$this->node_url = $this->node_url."?&action=auth&submit[apAuthLocalUserconnect]=Connect";
		}
		
		public function __set($key, $val)
		{
			$this->$key = $val;
		}
		public function __get($key)
		{
			return $this->$key;
		}
		
		public function getNode($gwid)
		{
			$contents = wp_remote_fopen($this->__get('node_url').$gwid);
			if ($contents != null)
				return json_decode($contents);
			else
				return false;
		}
		
		public function getUser($username, $pwd)
		{	
			$contents = wp_remote_fopen($this->__get('node_url')."&apAuthLocalUser[username]=".$username."&apAuthLocalUser[password]=".$pwd);
			if ($contents != null)
				return json_decode($contents);
			else
				return false;
		}
	}
?>