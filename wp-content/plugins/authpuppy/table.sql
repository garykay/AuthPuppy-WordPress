/*
	private $device_token;			// string	Primary key
	private $num_badge;				//	int
	private $app_name;				// string
	private $app_version;			// string
	private $device_uid;			// string
	private $device_name;			// string
	private $device_model;			// string
	private $device_version;		// string
	
	
		
		global $wpdb;
		$wpdb->query("CREATE TABLE IF NOT EXISTS  `".$wpdb->prefix."push_devices` (
`device_token` VARCHAR( 64 ) NOT NULL PRIMARY KEY ,
`num_badge` int(11) NULL ,
`app_name` VARCHAR( 75 ) NULL ,
`app_version` VARCHAR( 15 ) NULL ,
`device_uid` VARCHAR( 64 ) NULL ,
`device_name` VARCHAR( 50 ) NULL ,
`device_model` VARCHAR( 50 ) NULL ,
`device_version` VARCHAR( 15 ) NULL
) ENGINE = MYISAM ;");
	
	
*/

CREATE TABLE IF NOT EXISTS  `push_devices` (
`device_token` VARCHAR( 64 ) NOT NULL PRIMARY KEY ,
`num_badge` int(11) NULL ,
`app_name` VARCHAR( 75 ) NULL ,
`app_version` VARCHAR( 15 ) NULL ,
`device_uid` VARCHAR( 64 ) NULL ,
`device_name` VARCHAR( 50 ) NULL ,
`device_model` VARCHAR( 50 ) NULL ,
`device_version` VARCHAR( 15 ) NULL
) ENGINE = MYISAM ;