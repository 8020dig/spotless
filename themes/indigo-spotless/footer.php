<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package quadro
 */
?>

<?php // Retrieve Theme Options
$quadro_options = quadro_get_options(); ?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		
		<?php // Print Footer Widgetized area if enabled.
		quadro_widget_area( 'widgetized_footer_display', 'widgetized_footer_layout', 'inner-footer', 'footer-sidebar' ); ?>

		<div class="bottom-footer clear">
			
			<div class="site-info">
				<span class="circle-c">&copy;</span><?php echo date("Y"); ?> Spotless Group. All rights reserved.
			</div><!-- .site-info -->
			
			<?php quadro_social_icons('social_footer_display', 'footer-social-icons', 'footer_icons_scheme', 'footer_icons_color_type'); 
			wp_reset_query();
			?>
			
		</div>
		
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php // Bring Back to Top functionality if enabled
if ( $quadro_options['backto_enable'] == true ) echo '<a href="#" class="back-to-top"></a>'; ?>

<?php wp_footer(); ?>

</body>
</html>
