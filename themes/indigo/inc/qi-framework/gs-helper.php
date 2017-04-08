<?php

/**
 * Redirects to Getting Started page on theme activation
 */
function qi_get_started_redirect() {
	global $pagenow;
	if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
		wp_redirect( admin_url( "themes.php?page=getting-started" ) );
	}
}
add_action( 'after_switch_theme', 'qi_get_started_redirect' );
// add_action( 'admin_init', 'qi_get_started_redirect' );


/**
 * Registers Getting Started Menu
 */
function qi_register_gs_menu() {
	add_theme_page( 'Getting Started', 'Getting Started', 'manage_options', 'getting-started', 'qi_geting_started' );
}
add_action('admin_menu', 'qi_register_gs_menu');


/**
 * Getting Started Page Callback
 */
function qi_geting_started() {
	
	global $qi_docs_url, $qi_support_url, $theme_slug;
	$theme = wp_get_theme();
	?>

	<div class="wrap">

		<div id="qi-welcome-panel" class="qi-welcome-panel">
				
			<div class="qi-welcome-header">
				<a href="https://artisanthemes.io" title="Artisan Themes"><img src="<?php echo get_template_directory_uri(); ?>/inc/qi-framework/images/at-logo.png" /></a>
				<h3><?php printf( esc_html__( 'Welcome to %1$s! Please read through this page to get started setting up your theme.', 'quadro' ), $theme ); ?></h3>
			</div>

			<div class="qi-welcome-content clear">

				<ul id="gs-tabs-list" class="gs-tabs-list">
					<li id="start" class="current"><a href="#"><i class="fa fa-check"></i> <?php esc_html_e( 'Getting Started', 'quadro' ); ?></a></li>
					<li id="plugins"><a href="#"><i class="fa fa-plug"></i> <?php esc_html_e( 'Plugins', 'quadro' ); ?></a></li>
					<li id="support"><a href="#"><i class="fa fa-question"></i> <?php esc_html_e( 'FAQ & Support', 'quadro' ); ?></a></li>
				</ul>

				<div id="started-tabs" class="gs-tabs">
					<div id="start-tab" class="gs-tab visible">
						<?php // Include Theme Specific Getting Started Content
						require( get_template_directory() . '/inc/getting-started/getting-started.php' );
						?>
					</div>
					<div id="plugins-tab" class="gs-tab">
						<?php 
						global $tgmpa;
						$tgmpa->install_plugins_page();
						?>
					</div>
					<div id="support-tab" class="gs-tab">
						<?php // Include Theme Specific FAQ Content
						require( get_template_directory() . '/inc/getting-started/theme-faqs.php' );
						?>
						<p class="gs-more-faqs">Looking for some other question? <a href="https://artisanthemes.io/support-center/" target="_blank">Take a look at more FAQs here.</a></p>
					</div>
				</div>

			</div>

			<div class="qi-welcome-footer clear">
				<ul class="qi-socials">
					<li><a href="https://artisanthemes.io" title="Artisan Themes">artisanthemes.io</a></li>
					<li><a href="https://twitter.com/artisanthemeswp" title="Follow us on Twitter"><i class="fa fa-twitter-square"></i></a></li>
					<li><a href="https://www.facebook.com/artisanthemes" title="Join our Facebook Page"><i class="fa fa-facebook-square"></i></a></li>
					<li><a href="https://instagram.com/artisanthemes" title="Follow us on Instagram"><i class="fa fa-instagram"></i></a></li>
				</ul>
			</div>

			<div class="getting-started-sidebar">
				<?php //do_action( 'qi_options_sidebar' ); ?>
			</div>
			
		</div>

	</div>

	<?php
}