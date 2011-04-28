<?php
	/* Widgets */
	function authpuppy_widget_init()
	{
		register_sidebar_widget(__('Authpuppy'), 'authpuppy_widget_authpuppy');
		register_sidebar_widget(__('Redirection'), 'authpuppy_widget_redirection');
		register_sidebar_widget(__('Membres En Ligne'), 'authpuppy_widget_online');
		register_sidebar_widget(__('SidebarWidget - Main Widget Area'), 'authpuppy_widget_main');
		register_sidebar_widget(__('SidebarWidget - Other Widget Area'), 'authpuppy_widget_other');
		register_sidebar_widget(__('SidebarWidget - 2 Col Widget Area'), 'authpuppy_widget_cols');
		register_sidebar_widget(__('Posts'), 'authpuppy_widget_posts');
	}
	add_action("plugins_loaded", "authpuppy_widget_init");
	
	/* Authpuppy */
	function authpuppy_widget_authpuppy()
	{
		global $authpuppy_api;
		
			
			//if Authpuppy API don't find the node, there is a probleme
			if ( ($authpuppy_api->result == 0) or ($authpuppy_api == false) )
			{
				/*
					{"result":0,"values":{"type":"WSException","message":"Web service exception: Object of class Node with id 300 not found (8802)"}}
				*/
				/*
					echo "<dl>";
						echo "<dt>Info from Authpuppy API</dd>";
						echo "<dt>Error type</dt><dd>".$authpuppy_api->values->type."</dd>";
						echo "<dt>Error message</dt><dd>".$authpuppy_api->values->message."</dd>";
					echo "</dl>";
				/* */
			}
			//if Authpuppy API find the node information we ask for
			else
			{
				if ($authpuppy_api->values->Status == null)
					$status_img = "null";
				else
					$status_img = $authpuppy_api->values->Status;
				$status_img = '<img src="'.WP_PLUGIN_URL.'/authpuppy/images/status/'.strtolower($status_img).'.png" />';
				
				echo '<h3 class="widget-title">'.$authpuppy_api->values->Name.'&nbsp;&nbsp;&nbsp;'.$status_img.'</h3>';
				echo "<ul>";
					if ($authpuppy_api->values->Description != null)
						echo "<li id='' class='apinfo'>".$authpuppy_api->values->Description."</li>";
					
					if (($authpuppy_api->values->CivicNumber != null) or ($authpuppy_api->values->CivicNumber != null))
						echo "<li class='haddr apinfo'>";
							echo $authpuppy_api->values->CivicNumber;
							echo " ";
							echo $authpuppy_api->values->StreetName;
							
							echo "<br/>";
						
						if (($authpuppy_api->values->City != null) or ($authpuppy_api->values->Province != null))
								echo $authpuppy_api->values->City;
								echo " ";
								echo $authpuppy_api->values->Province;
							echo " ";
							
							echo "<br/>";
							
						if (($authpuppy_api->valueshdescription->PostalCode != null) or ($authpuppy_api->values->Country != null))
								echo $authpuppy_api->values->PostalCode;
								echo " ";
								echo $authpuppy_api->values->Country;
						echo"</li>";
						
					if ($authpuppy_api->values->Email != null)
						echo "<li id='hemail' class='apinfo'><a href='mailto:".$authpuppy_api->values->Email."?subject=Mise%20en%20relation%20depuis%20votre%20page%20Portail'>Envoyer un email &agrave; ".$authpuppy_api->values->Name."</a></li>";
					
					if ($authpuppy_api->values->MassTransitInfo != null)
						echo "<li id='hmasstransit' class='apinfo'>A proximit&eacute; de ".$authpuppy_api->values->MassTransitInfo."</li>";					
				echo "</ul>";

				if ($authpuppy_api->values->Latitude != "" and $authpuppy_api->values->Longitude != "")
					echo '<img src="http://maps.google.com/maps/api/staticmap
											?center='.$authpuppy_api->values->Latitude.','.$authpuppy_api->values->Longitude.'
											&zoom=16
											&size=220x220
											&maptype=roadmap
											&markers='.$authpuppy_api->values->Latitude.','.$authpuppy_api->values->Longitude.'
											&sensor=false" />';
			}
	}
	
	function authpuppy_widget_redirection()
	{
		if (isset($_GET["originurl"]) && ($_GET["originurl"]!= ""))
		{
?>
			<div id="btn_redirect">
				<a href="<?php echo $_GET["originurl"]; ?>" target="_blank">
					<button class="fat-blue">
<?php				
						$originurl = $_GET["originurl"];
						$originurl = preg_replace('/^http:\/\//', '', $originurl);
						echo substr($originurl, 0, 15)."...";
?>
					</button> 
				</a>
			</div>
<?php
		}
	}
	
	function authpuppy_widget_online()
	{
		require_once(ABSPATH . WPINC . '/registration.php');
		global $authpuppy_api;
		if (($authpuppy_api->values->NumOnlineUsers != null) && ($authpuppy_api->values->NumOnlineUsers > 0))
		{
			echo '<div id="authpuppy-user-online">';
				echo '<h3 class="widget-title">Membres connect&eacute;s</h3>';
				foreach($authpuppy_api->values->OnlineUsers as $user)
				{
					if ($user->auth_type == "apAuthLocalUser")
					{
						if (username_exists($user->identity))
							$wp_user = get_userdatabylogin($user->identity);
						else
						{
							$user_id = wp_create_user( $user->identity, "authpuppypasswordbyadcaelo", $user->identity."@yopmail.com");
							$wp_user = get_userdatabylogin($user->identity);
						}
						
						$s = '40';																//Default size
						//$d = urlencode(WP_PLUGIN_URL . '/authpuppy/images/mystery-man.jpg');	//Default avatar url
						$d = "identicon";
						$avatar = 'http://www.gravatar.com/avatar/'.md5(strtolower(trim($wp_user->user_email)))."?s=".$s."&d=".$d;
						
						$bp_user = new BP_Core_User( $user_id );
						
						echo '<div class="item-avatar">';
							echo '<a href="'.network_site_url().'members/'.$user->identity.'/">';
								if ($bp_user->avatar_thumb)
									echo $bp_user->avatar_thumb;
								else
									echo '<img src="'.$avatar.'" alt="'.$user->identity.'" title="'.$user->identity.'" width="'.$s.'px" />';
							echo '</a>';
						echo '</div>';
					}
				}
			echo '</div>';
		}
	}
	
	function authpuppy_widget_cols()
	{
		if ( is_active_sidebar( 'left-col-widget-area' ) && is_active_sidebar( 'right-col-widget-area' ) ) :
			echo "<br/>";
			echo '<div class="leftcol">';
					dynamic_sidebar( 'left-col-widget-area' );
			echo '</div>';
			echo '<div class="rightcol">';
					dynamic_sidebar( 'right-col-widget-area' );
			echo '</div>';
		endif;
	}
	
	//Authpuppy widget Post
	
	function authpuppy_widget_posts()
	{
		get_template_part( 'loop', 'index' );
	}
?>