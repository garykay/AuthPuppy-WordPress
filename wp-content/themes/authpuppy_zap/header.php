<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Authpuppy
 * @since Authpuppy 1.0
 */
	get_header("main");
?>	
	<div id="main">
	<?php
		if (! dynamic_sidebar( 'header-widget-area' ) ) :
			if (file_exists(WP_PLUGIN_DIR . '/slider/view/slider.php'))
				include(WP_PLUGIN_DIR . '/slider/view/slider.php');
		endif;
	?>
	
	<div id="main">
		<br/>