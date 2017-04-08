<?php
/**
 * The Sidebar for single project template.
 *
 * 
 */
?>

<div id="secondary" class="widget-area" role="complementary">
	<?php do_action( 'before_sidebar' ); ?>
	<?php if ( ! dynamic_sidebar( 'service' ) ) : ?>
		<aside class="help">
			<p><?php esc_html_e('Would like to activate some Widgets?', 'indigo'); ?>
			<br /><?php esc_html_e('Go to Appearance > Widgets. Just like that!', 'indigo'); ?></p>
		</aside>
	<?php endif; // end sidebar widget area ?>
</div><!-- #secondary -->

