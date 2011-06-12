<?php
/**
 * The Sidebar containing the primary and secondary widget areas.
 *
 * @package WordPress
 * @subpackage Authpuppy
 * @since Authpuppy 1.0
 */
?>
	<div id="primary" class="widget-area" role="complementary">
	<ul class="xoxo">

<?php
	/* When we call the dynamic_sidebar() function, it'll spit out
	 * the widgets for that widget area. If it instead returns false,
	 * then the sidebar simply doesn't exist, so we'll hard-code in
	 * some default sidebar stuff just in case.
	 */
	if ( ! dynamic_sidebar( 'primary-sidebar-widget-area' ) ) : ?>
	
			<li id="nodeinfo" class="widget-container">
				Glisser - D&eacute;poser ici vos widgets (Redirection, Authpuppy) ou bien un widget texte vierge pour faire disparaitre ce message
			
				<?php /*
					//if isset authpuppy api
					global $authpuppy_api;
					if ($authpuppy_api)
					{
						if (function_exists("authpuppy_widget_authpuppy"))
							authpuppy_widget_authpuppy;
					}	
				*/ ?>
			</li>
	<?php endif; // end primary widget area ?>
			</ul>
		</div><!-- #primary .widget-area -->

<?php
	// A second sidebar for widgets, just because.
	if ( is_active_sidebar( 'secondary-sidebar-widget-area' ) ) : ?>

		<div id="secondary" class="widget-area" role="complementary">
			<ul class="xoxo">
				<?php dynamic_sidebar( 'secondary-sidebar-widget-area' ); ?>
			</ul>
		</div><!-- #secondary .widget-area -->

<?php endif; ?>
