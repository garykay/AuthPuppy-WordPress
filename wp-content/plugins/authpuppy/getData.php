<?php
	/*
		This is a very simple example of what you can do with the Authpuppy API...
	*/

	//If Authpuppy Plugin is activate, we can access Authpuppy API
	if (is_plugin_active('authpuppy/authpuppy.php'))
	{
		//Get Data from Authpuppy API
		$api = new API();
		$node = $api->getNode(3);
		
		//if Authpuppy API find the node we ask for
		if ( ($node['result'] != 0) or ($node == false) )
		{
			/*
				{"result":1,"values":{"Name":"test node jason","Id":3,"GwId":"00121746F9A6","CreationDate":"2010-06-06 12:26:10","Status":"IN_TESTING"}}
			*/
			echo "Everythings is fine<br/>";
			foreach ($node['values'] as $key => $value)
				echo $key." : ".$value."<br/>";
		}
		//if Authpuppy API don't find the node, there is a probleme
		else
		{
			/*
				{"result":0,"values":{"type":"WSException","message":"Web service exception: Object of class Node with id 300 not found (8802)"}}
			*/
			echo "We Are In The Caca<br/>";
			foreach ($node['values'] as $key => $value)
				echo "Error ".$key." : ".$value."<br/>";
		}
	}
?>