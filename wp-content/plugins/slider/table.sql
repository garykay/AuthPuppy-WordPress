/*
slider_slide
	private $id;			//id		=> int auto_increment
	private $title;			//title		=> string(150)
	private $content;		//content	=> plain text
	private $image;			//image		=> string(250) [image url on local server]
	private $url;			//url		=> string(250)	[website or other url / link]
*/

CREATE TABLE IF NOT EXISTS  `slider_slide` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`title` VARCHAR( 150 ) NOT NULL ,
`content` TEXT NOT NULL ,
`image` VARCHAR( 250 ) NOT NULL ,
`url` VARCHAR( 250 ) NULL
) ENGINE = MYISAM ;

-------------------------------------------------------------------

/*
slider_user_bind	
	private $user;			//title		=> int user
	private $slide;			//id		=> int slide
*/

CREATE TABLE IF NOT EXISTS  `slider_user_bind` (
`user` bigint(20) NOT NULL ,
`slide` bigint(20) NOT NULL ,
PRIMARY KEY (  `user` ,  `slide` )
) ENGINE = MYISAM ;

---------------------------------------------------------------------


/*
slider_site_bind	
	private $user;			//title		=> int user
	private $slide;			//id		=> int slide
*/

CREATE TABLE IF NOT EXISTS  `slider_site_bind` (
`site` bigint(20) NOT NULL ,
`slide` bigint(20) NOT NULL ,
PRIMARY KEY (  `site` ,  `slide` )
) ENGINE = MYISAM ;