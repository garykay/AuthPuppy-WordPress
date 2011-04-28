<?php
/**
 * The Footer widget areas.
 *
 * @package WordPress
 * @subpackage Authpuppy
 * @since Authpuppy 1.0
 */
?>
			<div id="footer-widget-area" role="complementary">

				<div id="first" class="widget-area">
					<ul class="xoxo">
						<?php if (! dynamic_sidebar( 'first-footer-widget-area' )) : ?>
							<!-- Contenu par défaut du footer #1 !-->
							<p class="rssbar">
								<a href="http://twitter.com/statuses/user_timeline/124939290.rss">S'abonner au fil (RSS)</a>
							</p>
						<?php endif; ?>
					</ul>
				</div><!-- #first .widget-area -->

				<div id="second" class="widget-area">
					<ul class="xoxo">
						<?php if (! dynamic_sidebar( 'second-footer-widget-area' )) : ?>
							<!-- Contenu par défaut du footer #2 !-->
							<script src="http://static.ak.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php/fr_CA" type="text/javascript"></script>
							<script type="text/javascript">FB.init("cd9190ab66db74a5f76c04d99d6da43e");</script>
							<fb:fan profile_id="69137093097" stream="" connections="10" width="293"></fb:fan>
							<div color="009900" style="font-size:8px; padding-left:0px" css="<?php echo WP_CONTENT_URL ?>/themes/authpuppy/style.css">
						<?php endif; ?>
					</ul>
				</div><!-- #second .widget-area -->

				<div id="third" class="widget-area">
					<ul class="xoxo">
						<?php if (! dynamic_sidebar( 'third-footer-widget-area' )) : ?>
							<!-- Contenu par défaut du footer #3 !-->
							<a href="<?php echo network_site_url(); ?>feedback/" alt="Question? Besoin d'aide?" title="Feedback">
								<center>
									<img src="<?php echo network_home_url(); ?>wp-content/themes/authpuppy/images/buttons-feedback.png" />
								</center>
							</a>

							<a href="<?php echo network_site_url(); ?>modalites/" alt="Modalités de Service de île sans fil" title="Modalités de Service de île sans fil">
								<center>
									<img src="<?php echo network_home_url(); ?>wp-content/themes/authpuppy/images/buttons-modalites.png" />
								</center>
							</a>

							<a href="http://itunes.apple.com/ca/app/id363223622" alt="Téléchargez l’application gratuite Île sans fil sur l’App Store" title="Téléchargez l’application gratuite Île sans fil sur l’App Store">
								<center>
									<img src="<?php echo network_home_url(); ?>wp-content/themes/authpuppy/images/download_french.jpg" />
								</center>
							</a>
<?php
							if ( is_user_logged_in() )
							{
?>
							<a href="<?php echo bp_loggedin_user_domain() ?>">
								<center>Section membres</center>
							</a>
<?php
							}
?>
						<?php endif; ?>
					</ul>
				</div><!-- #third .widget-area -->

			</div><!-- #footer-widget-area -->
