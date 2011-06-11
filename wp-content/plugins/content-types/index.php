<?php

global $jal_db_version;
$zapct_db_version = "1.0";

// Updating the Database
register_activation_hook(__FILE__,'zapct_install');

function zapct_install () {
   global $wpdb, $zapct_db_version;

   $table_name = $wpdb->prefix . "zap_content_type"; 

	$sql = "CREATE TABLE " . $table_name . " (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		  name tinytext NOT NULL,
		  text text NOT NULL,
		  UNIQUE KEY id (id)
		);";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);

	add_option("zapct_db_version", $zapct_db_version);

}

function zapct_admin_menu() {
	add_options_page('Content type options', 'Content Types', 'manage_options', 'zapct', 'zapct_option_page');
}

function zapct_option_page(){
	include('admin-options.php');
}