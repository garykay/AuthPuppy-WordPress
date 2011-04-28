<?php

	function sorry_game()
	{
?>
			<object width="400" height="300" 
					type="application/x-shockwave-flash" 
					data="http://chat.kongregate.com/flash/GameShell_f856d51af7bcaa9005771a4a6dd997cf.swf" 
					id="gamediv">
						<param name="bgcolor" value="#000000">
						<param name="allownetworking" value="all">
						<param name="allowscriptaccess" value="never">
						<param name="base" value="http://chat.kongregate.com/gamez/0008/5403/live/">
						<param name="flashvars" 
								value="kongregate=true&amp;kongregate_username=Guest&amp;kongregate_user_id=0&amp;kongregate_game_id=85403&amp;kongregate_game_version=1278419209&amp;kongregate_host=http%3A%2F%2Fwww.kongregate.com&amp;kongregate_game_url=http%3A%2F%2Fwww.kongregate.com%2Fgames%2FAragagg%2Ffly-the-copter&amp;kongregate_api_host=http%3A%2F%2Fapi.kongregate.com&amp;kongregate_game_auth_token=84983c60f7daadc1cb8698621f802c0d9f9a3c3c295c810748fb048115c186ec&amp;kongregate_stamp=84983c60f7daadc1cb8698621f802c0d9f9a3c3c295c810748fb048115c186ec&amp;api_path=%2Fflash%2FAPI_17891c1d8cb5e7d6a713dfe97d436647.swf&amp;game_swf=http%3A%2F%2Fchat.kongregate.com%2Fgamez%2F0008%2F5403%2Flive%2F_45f38e48a7.swf%3Fkongregate_game_version%3D1278419209&amp;game_url=http%3A%2F%2Fwww.kongregate.com%2Fgames%2FAragagg%2Ffly-the-copter&amp;kongregate_api_path=%2Fflash%2FAPI_17891c1d8cb5e7d6a713dfe97d436647.swf&amp;kongregate_channel_id=1278441905869">
			</object>
			<script type="text/javascript">
				//&lt;![CDATA[
				if(Prototype.Browser.Opera){
				  $('gamediv').style.position = "relative";
				}

				var query_params = location.search.toQueryParams(), kong_flash_variables = {};
				for( var key in query_params ){
				  if( key.indexOf("kv_") == 0 ){
					kong_flash_variables[key] = query_params[key];
				  }
				}


				//]]&gt;
				</script><script type="text/javascript">
				//&lt;![CDATA[
				function activateGame(){      var swfobject_flash_vars = {"kongregate":"true","kongregate_username":encodeURIComponent(active_user.username()),"kongregate_user_id":encodeURIComponent(active_user.id()),"kongregate_game_id":"85403","kongregate_game_version":"1278419209","kongregate_host":"http%3A%2F%2Fwww.kongregate.com","kongregate_game_url":"http%3A%2F%2Fwww.kongregate.com%2Fgames%2FAragagg%2Ffly-the-copter","kongregate_api_host":"http%3A%2F%2Fapi.kongregate.com","kongregate_game_auth_token":encodeURIComponent(active_user.gameAuthToken()),"kongregate_stamp":encodeURIComponent(active_user.gameAuthToken()),"api_path":"%2Fflash%2FAPI_17891c1d8cb5e7d6a713dfe97d436647.swf","game_swf":"http%3A%2F%2Fchat.kongregate.com%2Fgamez%2F0008%2F5403%2Flive%2F_45f38e48a7.swf%3Fkongregate_game_version%3D1278419209","game_url":"http%3A%2F%2Fwww.kongregate.com%2Fgames%2FAragagg%2Ffly-the-copter","kongregate_api_path":"%2Fflash%2FAPI_17891c1d8cb5e7d6a713dfe97d436647.swf","kongregate_channel_id":encodeURIComponent(channel_id)};
					  if(typeof(kong_flash_variables) == "object"){
						for(var k in kong_flash_variables){
						  swfobject_flash_vars[k] = encodeURIComponent(kong_flash_variables[k]);
						}
					  }
					  swfobject.embedSWF("http://chat.kongregate.com/flash/GameShell_f856d51af7bcaa9005771a4a6dd997cf.swf","gamediv","400","300","6","/flash/expressInstall.swf",swfobject_flash_vars,{"bgcolor":"#000000","allownetworking":"all","allowscriptaccess":"never","base":"http://chat.kongregate.com/gamez/0008/5403/live/"},{});
				}
				//]]&gt;
			</script>
		</div>
<?php
	}
?>