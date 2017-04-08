<?php
/**
 * The template used for displaying Video & Embeds Modules content
 *
 */
?>

<?php 
$mod_id = get_the_ID();

// Get Video Module data
$header_layout 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_header_layout', true ) );
$overlay		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_overlay', true ) );
$video_url		= esc_url( get_post_meta( $mod_id, 'quadro_mod_video_url', true ) );
$video_layout	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_video_layout', true ) );
$video_width 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_video_width', true ) );
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-video <?php quadro_mod_parallax($mod_id); ?> modheader-<?php echo $header_layout; ?> layout-<?php echo $video_layout; ?> overlay-<?php echo $overlay; ?>">

	<?php // Apply function for inline styles
	quadro_mod_styles( $mod_id ); ?>

	<div class="dark-overlay"></div>
	
	<?php quadro_mod_title( $mod_id ); ?>

	<div class="mod-content">

		<div class="inner-mod">

			<div class="video-mod-wrapper width-<?php echo $video_width; ?>">

				 <?php echo wp_oembed_get( $video_url ); ?>
			
			</div><!-- .video-mod-wrapper -->

		</div><!-- .inner-mod -->

	</div><!-- .mod-content -->

</section><!-- .module -->
