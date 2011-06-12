<?php
/**
 * Authpuppy functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, Authpuppy_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'Authpuppy_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Authpuppy
 * @since Authpuppy 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640;

/** Tell WordPress to run Authpuppy_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'Authpuppy_setup' );

if ( ! function_exists( 'Authpuppy_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override Authpuppy_setup() in a child theme, add your own Authpuppy_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support() To add support for post thumbnails, navigation menus, and automatic feed links.
 * @uses add_custom_background() To add support for a custom background.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Authpuppy 1.0
 */
function Authpuppy_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'Authpuppy', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'Authpuppy' ),
	) );

	// This theme allows users to set a custom background
	add_custom_background();

	// Your changeable header business starts here
	define( 'HEADER_TEXTCOLOR', '' );
	// No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.
	define( 'HEADER_IMAGE', '%s/images/headers/zapquebec.png' );

	// The height and width of your custom header. You can hook into the theme's own filters to change these values.
	// Add a filter to Authpuppy_header_image_width and Authpuppy_header_image_height to change these values.
	define( 'HEADER_IMAGE_WIDTH', apply_filters( 'Authpuppy_header_image_width', 125 ) );
	define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'Authpuppy_header_image_height', 200 ) );

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be 125 pixels wide by 90 pixels tall.
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );

	// Don't support text inside the header image.
	define( 'NO_HEADER_TEXT', true );

	// Add a way for the custom header to be styled in the admin panel that controls
	// custom headers. See Authpuppy_admin_header_style(), below.
	add_custom_image_header( '', 'Authpuppy_admin_header_style' );

	// ... and thus ends the changeable header business.

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'&Icirc;le Sans Fil' => array(
			'url' => '%s/images/headers/isf.png',
			'thumbnail_url' => '%s/images/headers/isf.png',
			/* translators: header image description */
			'description' => __( 'Isf.logo', 'Authpuppy' )
		),
		'Zap Qu&ecute;bec' => array(
			'url' => '%s/images/headers/zap.png',
			'thumbnail_url' => '%s/images/headers/zap.png',
			/* translators: header image description */
			'description' => __( 'Zap.logo', 'Authpuppy' )
		),
		'Yours' => array(
			'url' => '%s/images/headers/yours.png',
			'thumbnail_url' => '%s/images/headers/yours.png',
			/* translators: header image description */
			'description' => __( 'Yours.logo', 'Authpuppy' )
		)
	) );
}
endif;

if ( ! function_exists( 'Authpuppy_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in Authpuppy_setup().
 *
 * @since Authpuppy 1.0
 */
function Authpuppy_admin_header_style() {
?>
<style type="text/css">
/* Shows the same border as on front end */
#headimg {
	border-bottom: 1px solid #000000;
	border-top: 4px solid #000000;
}

/* If NO_HEADER_TEXT is false, you can style here the header text preview */
#headimg #name {
}

#headimg #desc {
}
</style>
<?php
}
endif;

if ( ! function_exists( 'Authpuppy_the_page_number' ) ) :
/**
 * Prints the page number currently being browsed, with a vertical bar before it.
 *
 * Used in Authpuppy's header.php to add the page number to the <title> HTML tag.
 *
 * @since Authpuppy 1.0
 */
function Authpuppy_the_page_number() {
	global $paged; // Contains page number.
	if ( $paged >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'Authpuppy' ), $paged );
}
endif;

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 * @since Authpuppy 1.0
 */
function Authpuppy_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'Authpuppy_page_menu_args' );

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since Authpuppy 1.0
 * @return int
 */
function Authpuppy_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'Authpuppy_excerpt_length' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis.
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since Authpuppy 1.0
 * @return string An ellipsis
 */
function Authpuppy_auto_excerpt_more( $more ) {
	return ' &hellip;';
}
add_filter( 'excerpt_more', 'Authpuppy_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since Authpuppy 1.0
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function Authpuppy_custom_excerpt_more( $output ) {
	return $output . ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'Authpuppy' ) . '</a>';
}
add_filter( 'get_the_excerpt', 'Authpuppy_custom_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in Authpuppy's style.css.
 *
 * @since Authpuppy 1.0
 * @return string The gallery style filter, with the styles themselves removed.
 */
function Authpuppy_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'Authpuppy_remove_gallery_css' );

if ( ! function_exists( 'Authpuppy_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own Authpuppy_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Authpuppy 1.0
 */
function Authpuppy_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; ?>
	<?php if ( '' == $comment->comment_type ) : ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( __( '%s <span class="says">says:</span>', 'Authpuppy' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em><?php _e( 'Your comment is awaiting moderation.', 'Authpuppy' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'Authpuppy' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'Authpuppy' ), ' ' );
			?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php else : ?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'Authpuppy' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'Authpuppy'), ' ' ); ?></p>
	<?php endif;
}
endif;

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override Authpuppy_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * @since Authpuppy 1.0
 * @uses register_sidebar
 */
function Authpuppy_widgets_init() {
	// Area A, located in the main.
	register_sidebar( array(
		'name' => __( 'Main Area', 'Authpuppy' ),
		'id' => 'main-area',
		'description' => __( 'The Main area, move here the widget you want and the "Sidebar Widget" you want to use', 'Authpuppy' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	// Area B, located in the header.
	register_sidebar( array(
		'name' => __( 'Header Widget Area', 'Authpuppy' ),
		'id' => 'header-widget-area',
		'description' => __( 'The header widget area, leaver blank to show the slider', 'Authpuppy' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	// Area C1, located in the main - Show with SidebarWidget.
	register_sidebar( array(
		'name' => __( 'Left Col Widget Area', 'Authpuppy' ),
		'id' => 'left-col-widget-area',
		'description' => __( 'The Two col main - Left Part', 'Authpuppy' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	// Area C2, located in the main - Show with SidebarWidget.
	register_sidebar( array(
		'name' => __( 'Right Col Widget Area', 'Authpuppy' ),
		'id' => 'right-col-widget-area',
		'description' => __( 'The Two col main - Right Part', 'Authpuppy' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => __( 'Primary Sidebar Widget Area', 'Authpuppy' ),
		'id' => 'primary-sidebar-widget-area',
		'description' => __( 'The primary widget area', 'Authpuppy' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 2, located below the Primary Widget Area in the sidebar. Empty by default.
	register_sidebar( array(
		'name' => __( 'Secondary Sidebar Widget Area', 'Authpuppy' ),
		'id' => 'secondary-sidebar-widget-area',
		'description' => __( 'The secondary widget area', 'Authpuppy' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 3, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'First Footer Widget Area', 'Authpuppy' ),
		'id' => 'first-footer-widget-area',
		'description' => __( 'The first footer widget area', 'Authpuppy' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 4, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Second Footer Widget Area', 'Authpuppy' ),
		'id' => 'second-footer-widget-area',
		'description' => __( 'The second footer widget area', 'Authpuppy' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 5, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Third Footer Widget Area', 'Authpuppy' ),
		'id' => 'third-footer-widget-area',
		'description' => __( 'The third footer widget area', 'Authpuppy' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
/** Register sidebars by running Authpuppy_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'Authpuppy_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 * To override this in a child theme, remove the filter and optionally add your own
 * function tied to the widgets_init action hook.
 *
 * @since Authpuppy 1.0
 */
function Authpuppy_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'Authpuppy_remove_recent_comments_style' );

if ( ! function_exists( 'Authpuppy_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post—date/time and author.
 *
 * @since Authpuppy 1.0
 */
function Authpuppy_posted_on() {
	printf( __( '<span %1$s>Posted on</span> %2$s by %3$s', 'Authpuppy' ),
		'class="meta-prep meta-prep-author"',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a> <span class="meta-sep">',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '</span> <span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'Authpuppy' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;

if ( ! function_exists( 'Authpuppy_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since Authpuppy 1.0
 */
function Authpuppy_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'Authpuppy' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'Authpuppy' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'Authpuppy' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;



/* BP for authpuppy */



// **** "My Account" Menu ******
function authpuppy_alter_bp_adminbar()
{
	remove_action('bp_adminbar_menus', 'bp_adminbar_account_menu', 4);
	add_action('bp_adminbar_menus', 'authpuppy_adminbar_account_menu', 4);
	
	remove_action( 'bp_adminbar_menus', 'bp_adminbar_random_menu', 100 );
	add_action( 'bp_adminbar_menus', 'authpuppy_adminbar_visit_menu', 100 );
}
add_action('wp_footer','authpuppy_alter_bp_adminbar', 1);

function authpuppy_adminbar_account_menu()
{

?>
	<li id="bp-adminbar-account-menu"><a href="<?php echo bp_loggedin_user_domain(); ?>">
		Shortcut
		<ul>
			<li><a href="<?php echo network_home_url(); ?>activity/">Activity</a></li>
			<li><a href="<?php echo network_home_url(); ?>members/">Members</a></li>
			<li>
				<a href="<?php echo network_home_url(); ?>groups/">Groups</a>
				<ul>
					<li><a href="<?php echo network_home_url(); ?>groups/create/">Create Groups</a></li>
				</ul>
			</li>
		</ul>
	</li>
<?php

	global $bp;
	if ( !$bp->bp_nav || !is_user_logged_in() )
		return false;

	echo '<li id="bp-adminbar-account-menu"><a href="' . bp_loggedin_user_domain() . '">';

		echo __( 'My Account', 'buddypress' ) . '</a>';
		echo '<ul>';

			/* Loop through each navigation item */
			$counter = 0;
			foreach( (array)$bp->bp_nav as $nav_item ) {
				$alt = ( 0 == $counter % 2 ) ? ' class="alt"' : '';

				echo '<li' . $alt . '>';
				echo '<a id="bp-admin-' . $nav_item['css_id'] . '" href="' . $nav_item['link'] . '">' . $nav_item['name'] . '</a>';

				if ( is_array( $bp->bp_options_nav[$nav_item['slug']] ) ) {
					echo '<ul>';
					$sub_counter = 0;

					foreach( (array)$bp->bp_options_nav[$nav_item['slug']] as $subnav_item ) {
						$link = str_replace( $bp->displayed_user->domain, $bp->loggedin_user->domain, $subnav_item['link'] );
						$name = str_replace( $bp->displayed_user->userdata->user_login, $bp->loggedin_user->userdata->user_login, $subnav_item['name'] );
						$alt = ( 0 == $sub_counter % 2 ) ? ' class="alt"' : '';
						echo '<li' . $alt . '><a id="bp-admin-' . $subnav_item['css_id'] . '" href="' . $link . '">' . $name . '</a></li>';
						$sub_counter++;
					}
					echo '</ul>';
				}
				echo '</li>';
				$counter++;
			}
			$alt = ( 0 == $counter % 2 ) ? ' class="alt"' : '';
			echo '<li' . $alt . '><a id="bp-admin-logout" class="logout" href="' . wp_logout_url( site_url() ) . '">' . __( 'Log Out', 'buddypress' ) . '</a></li>';
		echo '</ul>';
	echo '</li>';
}


function authpuppy_adminbar_visit_menu()
{
	global $bp; ?>
	<li class="align-right" id="bp-adminbar-visitrandom-menu">
		<a href="#"><?php _e( 'Visit', 'buddypress' ) ?></a>
		<ul class="random-list">
			<li><a href="http://www.ilesansfil.org">&Icirc;le Sans Fil</a></li>
			
			<li><a href="<?php echo $bp->root_domain . '/' . BP_MEMBERS_SLUG . '/?random-member' ?>"><?php _e( 'Random Member', 'buddypress' ) ?></a></li>

			<?php if ( function_exists('groups_install') ) : ?>
			<li class="alt"><a href="<?php echo $bp->root_domain . '/' . $bp->groups->slug . '/?random-group' ?>"><?php _e( 'Random Group', 'buddypress' ) ?></a></li>
			<?php endif; ?>


			<?php if ( function_exists('bp_blogs_install') && bp_core_is_multisite() ) : ?>
			<li><a href="<?php echo $bp->root_domain . '/' . $bp->blogs->slug . '/?random-blog' ?>"><?php _e( 'Random Blog', 'buddypress' ) ?></a></li>

			<?php endif; ?>

			<?php do_action( 'bp_adminbar_random_menu' ) ?>
		</ul>
	</li>
	<?php
}