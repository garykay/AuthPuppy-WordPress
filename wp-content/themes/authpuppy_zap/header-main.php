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
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	
	<?php
		include_once __DIR__."/config.php";
	?>
	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo GMAPS_KEY; ?>" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo WP_CONTENT_URL; ?>/themes/authpuppy/js/jquery-1.2.6.min.js"></script>
	<script type="text/javascript" src="<?php echo WP_CONTENT_URL; ?>/themes/authpuppy/js/utils.js"></script>
	<script type="text/javascript" src="<?php echo WP_CONTENT_URL; ?>/themes/authpuppy/js/hotspots_status_map.js"></script>
	
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo WP_CONTENT_URL; ?>/themes/authpuppy/style-bp.css" />
	<? /* 
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo WP_CONTENT_URL; ?>/themes/authpuppy/bp.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo WP_CONTENT_URL; ?>/themes/authpuppy/adminbar.css" />
	*/ ?>
	
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */

	wp_head();
	
	$language = "french";
?>
	<title>
<?php
		global $authpuppy_api;
		if ($authpuppy_api->values->Name != "")
			$blog_name = $blog_name = $authpuppy_api->values->Name;
		else
			$blog_name = $blog_name = get_bloginfo('name');
			
		// Returns the title based on what is being viewed
		if ( is_single() or is_page() ) { // single posts or WordPress Pages
			single_post_title();
			echo ' | '.$blog_name;
		// The home page or, if using a static front page, the blog posts page.
		}
		elseif ( is_home() || is_front_page() ) {
			echo $blog_name;
			if( get_bloginfo( 'description' ) )
			{
				echo ' | ' ;
				bloginfo( 'description' );
			}	
			authpuppy_the_page_number();
		}
		elseif ( is_search() ) { // Search results
			printf( __( 'Search results for %s', 'authpuppy' ), '"'.get_search_query().'"' );
			authpuppy_the_page_number();
			echo ' | '.$blog_name;
		}
		elseif ( is_404() ) {  // 404 (Not Found)
			_e( 'Not Found', 'authpuppy' );
			echo ' | '.$blog_name;
		}
		else { // Otherwise:
			wp_title( '' );
			echo ' | '.$blog_name;
			authpuppy_the_page_number();
		}
?>
	</title>
</head>

<body <?php body_class(); ?> style="padding-top:0px">

	<div id="map">
		<div id="map_outer_wrapper">
			<div class='legend'>
				<img src='<?php echo WP_CONTENT_URL; ?>/themes/authpuppy/images/HotspotStatusMap/up.png' width='10px' />Connect&eacute;&nbsp;&nbsp;
				<img src='<?php echo WP_CONTENT_URL; ?>/themes/authpuppy/images/HotspotStatusMap/down.png' width='10px' />D&eacute;connect&eacute;
			</div>
			<!-- The list of hotspots will be injected into this DIV -->
			<div id="map_outer_hotspots_list">
				<div id="map_hotspots_list"></div>
			</div>
			<!-- The Google Maps mashup will be injected into this DIV -->
			<div id="map_frame"></div>	
			<?php
				global $authpuppy_api;
				if ($authpuppy_api->values->Latitute != "" and $authpuppy_api->values->Longitude != "")
				{
					$lat = $authpuppy_api->values->Latitute;
					$lon = $authpuppy_api->values->Longitude;
					$zoom = 16;
				}
				//If no authpuppy api or no location
				//default location = berry uqam metro station
				else
				{
					$lat =45.515971;
					$lon = -73.576813;
					$zoom = 12;
				}
			?>
			<script type="text/javascript">
				//<![CDATA[
					translations = new HotspotsMapTranslations('Desole, votre navigateur n\'est pas en mesure d\'afficher cette carte.', 'Page d\'accueil', 'Montre-moi sur la carte', 'Chargement en cours, veuillez patienter...');

					window.onload = function() {
						document.getElementById("openmap_trigger").onclick = function() {
							hotspots_map = new HotspotsMap('map_frame', 'hotspots_map', translations, '<?php echo WP_CONTENT_URL; ?>/themes/authpuppy/images/');
							hotspots_map.setXmlSourceUrl('<?php echo WP_CONTENT_URL; ?>/themes/authpuppy/scripts/isf_hotspots_status_ws_proxy.php');
							hotspots_map.setHotspotsInfoList('map_hotspots_list');
							//hotspots_map.setInitialPosition(longitude, latitude, zoom);
							hotspots_map.setInitialPosition(<?php echo $lat.", ".$lon.", ".$zoom; ?>);
							hotspots_map.setMapType(G_NORMAL_MAP);
							hotspots_map.redraw();
						}
					}

					window.onunload = function () {
						GUnload();
					}
				//]]>
			</script>
		</div>
	</div><!-- end of map -->

	<div id="wrapper" class="hfeed">
		<div id="header">
			<ul id="authutilsnav">
				<li><a title="Changer mon mot de passe" href="http://auth.ilesansfil.org/authpuppy/authlocaluser/my-account/">Changer mon mot de passe</a></li>
				<?php
					if ( is_user_logged_in() )
						echo '<li><a title="Se Deconnecter" href="'.wp_logout_url( network_home_url()."activity/" ).'">Se Deconnecter</a></li>';
					else
						echo '<li><a title="Se Connecter" href="'.wp_login_url(network_home_url()."activity/").'">Se Connecter</a></li>';
				?>
				<li><a title="Contact" href="http://www.ilesansfil.org/contact/">Contact</a></li>
				<?php /*<li>
					<?php
						if ($language = "french")
							echo '<a title="Welcome" href="?lng=english">Welcome</a>';
						else
							echo '<a title="Welcome" href="?lng=french">Bonjour</a>';
					?>
				</li> */ ?>
			</ul>
			
			<p id="openmap" class="map_trigger">
				<a href="" id="openmap_trigger">
					<?php
						if($language == 'french')
							echo 'Carte des points d&rsquo;acc&egrave;s';
						else
							echo 'Map of Access Points';
					?>
				</a>
			</p>
		</div><!-- #header -->
		<div id="autbanner">
			<a id="logo-link" title="<?php echo WHO_ARE_YOU; ?>" href="<?php echo WHERE_ARE_YOU; ?>" target="_blank">
				<img src="<?php echo header_image(); ?>" alt="<?php echo WHO_ARE_YOU; ?>" width="125px" height="90px" />
			</a>
			<h1 id="site-title">
				<span>
					<?php
						$url = home_url( '/' );
						
						if (isset($_GET['node_id']))
							$url .= "?node_id=".$_GET['node_id'];
					?>
					<a href="<?php echo $url; ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
						<?php echo $blog_name; ?>
					</a>
				</span>
			</h1>
			
			<div id="site-description">
				<?php /* bloginfo( 'description' ); */ ?>
			</div>
		</div>
		<div id="authheader">
			<div id="authmenu">
				<ul>
					<?php
						if (MENU_2_LOGIN && is_user_logged_in())
						{
							$what = MENU_2_WHAT;
							$link = MENU_2_LINK;
						}
						else
						{
							$what = "Se connecter";
							$link = wp_login_url( network_home_url()."activity/");
						}
					?>
					<li><a title="<?php echo MENU_1_WHAT; ?>" href="<?php echo MENU_1_LINK; ?>"><?php echo MENU_1_WHAT; ?></a></li>
					<li><a title="<?php echo $what; ?>" href="<?php echo $link; ?>"><?php echo $what; ?></a></li>
					<li><a title="<?php echo MENU_3_WHAT; ?>" href="<?php echo MENU_3_LINK; ?>"><?php echo MENU_3_WHAT; ?></a></li>
					<li><a title="<?php echo MENU_4_WHAT; ?>" href="<?php echo MENU_4_LINK; ?>"><?php echo MENU_4_WHAT; ?></a></li>
					<li><a title="<?php echo MENU_5_WHAT; ?>" href="<?php echo MENU_5_LINK; ?>"><?php echo MENU_5_WHAT; ?></a></li>
				</ul>
			</div>
			<div id="authsearch">
				<form action="http://www.ilesansfil.org" method="get" id="authsearchform">
					<div>
						<input type="text" accesskey="S" tabindex="1" size="20" value="" class="text-input" name="s" id="s">
						<input type="submit" tabindex="2" value="Chercher" name="searchsubmit" class="submit-button" id="searchsubmit">
					</div>
				</form>
			</div>
		</div>