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
		<br/>
	<div id="userbar">
		<ul id="bp-nav">
			<li id="li-nav-all-activity">
				<a href="<?php echo network_home_url(); ?>activity/" id="all-activity">Activities</a>
			</li>
			<li id="li-nav-all-members">
				<a href="<?php echo network_home_url(); ?>members/" id="all-members">Members</a>
			</li>
			<li id="li-nav-all-groups">
				<a href="<?php echo network_home_url(); ?>groups/" id="all-groups">Groups</a>
			</li>
<?php
		if ( is_user_logged_in() )
		{
?>
			<li id="li-nav-avatar">
				<a href="<?php bp_user_link() ?>" id="my-avatar">
					<?php bp_displayed_user_avatar() ?>
				</a>
			</li>
			<li id="li-nav-activity">
				<a href="<?php echo bp_loggedin_user_domain(); ?>activity/" id="my-activity">My Activity</a>
			</li>
			<li id="li-nav-profile">
				<a href="<?php echo bp_loggedin_user_domain(); ?>profile/" id="my-profile">Profile</a>
			</li>
			<li id="li-nav-messages">
				<a href="<?php echo bp_loggedin_user_domain(); ?>messages/" id="my-messages">Messages</a>
			</li>
			<li id="li-nav-friends">
				<a href="<?php echo bp_loggedin_user_domain(); ?>friends/" id="my-friends">Friends</a>
			</li>
			<li id="li-nav-groups">
				<a href="<?php echo bp_loggedin_user_domain(); ?>groups/" id="my-groups"> My Groups</a>
			</li>
			<li id="li-nav-settings">
				<a href="<?php echo bp_loggedin_user_domain(); ?>settings/" id="my-settings">Settings</a>
			</li>
			<li id="li-nav-logout">
				<a href="<?php echo wp_logout_url( network_home_url()."activity/" ); ?>" id="bp-logout">Log Out</a>
			</li>
<?php
		}
		else
		{
			echo '<li id="li-nav-login">';
				echo '<a href="'.wp_login_url(network_home_url()."activity/").'" id="bp-login">You must log in to access your account.</a>';
			echo '</li>';
		}
?>
		</ul>
	</div>
