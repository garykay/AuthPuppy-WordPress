<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage Authpuppy
 * @since Authpuppy 1.0
 */
?>
	</div><!-- #main -->
	<div class="clear"></div>
	
	<div id="footer" role="contentinfo">
		<div id="colophon">

<?php
	/* A sidebar in the footer? Yep. You can can customize
	 * your footer with four columns of widgets.
	 */
	get_sidebar( 'footer' );
?>

			<div id="site-info">
				<a href="<?php echo home_url( '/' ) ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					<?php bloginfo( 'name' ); ?>
				</a>
			</div><!-- #site-info -->

			<div id="site-generator">
				<?php do_action( 'authpuppy_credits' ); ?>
				<a href="<?php echo esc_url( __('http://wordpress.org/', 'authpuppy') ); ?>"
						title="<?php esc_attr_e('Semantic Personal Publishing Platform', 'authpuppy'); ?>" rel="generator">
					<?php printf( __('Proudly powered by %s.', 'authpuppy'), 'WordPress' ); ?>
				</a>
			</div><!-- #site-generator -->

		</div><!-- #colophon -->
	</div><!-- #footer -->

</div><!-- #wrapper -->

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>

	<script type="text/javascript">
		var uservoiceOptions = {
		  /* required */
		  key: 'portailauthpuppy',
		  host: 'portailauthpuppy.uservoice.com', 
		  forum: '61431',
		  showTab: true,  
		  /* optional */
		  alignment: 'left',
		  background_color:'#f00', 
		  text_color: 'white',
		  hover_color: '#06C',
		  lang: 'en'
		};

		function _loadUserVoice() {
		  var s = document.createElement('script');
		  s.setAttribute('type', 'text/javascript');
		  s.setAttribute('src', ("https:" == document.location.protocol ? "https://" : "http://") + "cdn.uservoice.com/javascripts/widgets/tab.js");
		  document.getElementsByTagName('head')[0].appendChild(s);
		}
		_loadSuper = window.onload;
		window.onload = (typeof window.onload != 'function') ? _loadUserVoice : function() { _loadSuper(); _loadUserVoice(); };
	</script>

</body>
</html>
