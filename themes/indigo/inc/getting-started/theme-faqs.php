<?php
/**
 * Returns theme specific Frequently Asked Questions for the
 * Getting Started page.
 */

$theme = wp_get_theme();
?>

<ul id="theme-faqs-list" class="theme-faqs-list">
	<li><a href="#faqs-register" class="scroll-to-link"><?php esc_html_e('I purchased the theme at Themeforest, how do I register it?', 'indigo'); ?></a></li>
	<li><a href="#faqs-support" class="scroll-to-link"><?php esc_html_e('Where do I get support for ', 'indigo'); echo $theme . '?';  ?></a></li>
	<li><a href="#faqs-demo" class="scroll-to-link"><?php esc_html_e('How can I make the site look like the demo?', 'indigo') ?></a></li>
	<li><a href="#faqs-plugins" class="scroll-to-link"><?php esc_html_e('Should I install all the recommended plugins?', 'indigo') ?></a></li>
	<li><a href="#faqs-update" class="scroll-to-link"><?php esc_html_e('How do I get theme updates?', 'indigo') ?></a></li>
	<li><a href="#faqs-import" class="scroll-to-link"><?php esc_html_e('I installed a demo pack but not every element got installed.', 'indigo') ?></a></li>
</ul>

<div class="theme-faqs-content">

	<div class="theme-faq">
		<h3 id="faqs-register"><?php esc_html_e('How do I register the theme and activate the license? (For Themeforest purchases)', 'indigo'); ?></h3>
		<p><?php echo esc_html__('To register the theme navigate to', 'indigo') . ' <a href="https://artisanthemes.io/register-theme/" target="_blank">artisanthemes.io/register-theme</a>, ' . esc_html__('enter your preferred details for the account and click on "Register Item". You will need to select the theme from a list and enter your purchase key, and that\'s about it. Once you do that you should see the theme appear on the "Your Registered Items" section. The only thing left to do is to enter your Artisan Themes credentials on the General tab of the', 'indigo') . ' <a href="' . admin_url( 'themes.php?page=quadro-settings') . '">Theme Options</a> ' . esc_html__('page. You can click the "Check Now" button after you saved the options to make sure the license has been properly enabled for the theme.', 'indigo'); ?></p>
	</div>
	
	<div class="theme-faq">
		<h3 id="faqs-support"><?php esc_html_e('Where do I get support for ', 'indigo'); echo $theme . '?';  ?></h3>
		<p><?php echo esc_html__('Found yourself in front of a tricky step you don\'t know how to solve? Jump over to our dedicated support forum at', 'indigo') . ' <a href="https://artisanthemes.io/support-forums/" target="_blank">artisanthemes.io/support-forums</a> ' . esc_html__('where our support team will gladly assist you. Access is for licensed users only, so don\'t forget to register your theme first. Oh! And try to be as descriptive as you can when writing your question. Extra kudos for providing a link URL to your site. :)', 'indigo'); ?></p>
	</div>
	
	<div class="theme-faq">
		<h3 id="faqs-demo"><?php esc_html_e('How can I make the site look like the demo?', 'indigo') ?></h3>
		<p><?php echo esc_html__('To make your site look just like the theme\'s demo, navigate to', 'indigo') . ' <a href="' . admin_url( 'themes.php?page=quadro-settings') . '">Theme Options</a>, ' . esc_html__('look for the "Ready Made Sites Import" option and follow the instructions. Be aware that this will import content to your site, as well as replace most of the theme options you might already set up.', 'indigo'); ?></p>
	</div>
	
	<div class="theme-faq">
		<h3 id="faqs-plugins"><?php esc_html_e('Should I install all the recommended plugins?', 'indigo') ?></h3>
		<p><?php esc_html_e('The only required plugins to work with this theme are the Modules Type and the Portfolio Type plugins included in the theme package (and you can skip the Portfolio Type installation if you won\'t be using the Portfolio section). All the other plugins that you will find as "Recommended" are no more than that. They will expand the functionality of the theme but you are free to install them as you wish.', 'indigo'); ?></p>
	</div>
	
	<div class="theme-faq">
		<h3 id="faqs-update"><?php esc_html_e('How do I get theme updates?', 'indigo') ?></h3>
		<p><?php esc_html_e('Once you register the theme and activate the license, you will get update notices at your WordPress Updates dashboard as you would do for any other theme or plugin. Just click the Update option when it is presented to you and theme will automatically update to the latest available version.', 'indigo'); ?></p>
	</div>

	<div class="theme-faq">
		<h3 id="faqs-import"><?php esc_html_e('I installed a demo pack but not every element got installed.', 'indigo') ?></h3>
		<p><?php esc_html_e('Before you install a demo pack, please make sure that the relevant plugins (those that are in use on the demo pack you are about to install) are installed. If you install a demo pack that uses WooCommerce, for example, and you install it without the plugin being activated, the products won\'t get imported.', 'indigo'); ?></p>
		<p><?php esc_html_e('Also, if you made already some demo pack imports, you may have some elements already in your database that won\'t get imported twice. Before attempting the import again, please make sure you have deleted those, and emptied your trash.', 'indigo'); ?></p>
	</div>
	
</div>