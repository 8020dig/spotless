<?php
/**
 * The template used for displaying Gallery Modules content
 *
 */
?>

<?php 
$mod_id = get_the_ID();

// Get Gallery Module data
$header_layout 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_header_layout', true ) );
$overlay		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_overlay', true ) );
$style 			= esc_attr( get_post_meta( $mod_id, 'quadro_mod_gallery_style', true ) );
$layout 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_gallery_layout', true ) );
$margins 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_gallery_margins', true ) );
$captions 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_gallery_captions', true ) );
$lightbox 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_gallery_lightbox', true ) );
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-gallery style-<?php echo $style; ?> layout-<?php echo $layout; ?> margins-<?php echo $margins; ?> captions-<?php echo $captions; ?> <?php quadro_mod_parallax($mod_id); ?> modheader-<?php echo $header_layout; ?> overlay-<?php echo $overlay; ?>">

	<?php // Apply function for inline styles
	quadro_mod_styles( $mod_id ); ?>

	<div class="dark-overlay"></div>
	
	<?php quadro_mod_title( $mod_id ); ?>

	<div class="mod-content">

		<div class="inner-mod">

			<?php if ( $style == 'mosaic' ) {

				// Build Maximum Counters Per Layout
				if ( $layout == 'layout1' || $layout == 'layout2' || $layout == 'layout6' ) $max_pos = 6;
				if ( $layout == 'layout3' || $layout == 'layout8' ) $max_pos = 10;
				if ( $layout == 'layout4' ) $max_pos = 9;
				if ( $layout == 'layout5' ) $max_pos = 7;
				if ( $layout == 'layout7' ) $max_pos = 8;

				// Prepare Counter
				$x = 1;
				
				// Retrieve custom field
				$gallery = esc_attr( get_post_meta( $mod_id, 'quadro_mod_gallery_gallery', true ) );

				if ( $gallery != '' ) {

					// Prepare image IDs
					preg_match_all( '!\d+!', $gallery, $pic_ids );

					// Build Gallery
					echo '<div class="gallery-gallery"><ul class="slides">';
					foreach( $pic_ids[0] as $pic_id ) {
						$image = wp_get_attachment_image_src( $pic_id, 'full' );
						echo '<li class="gal-pos-' . $x . '"><div class="mosaic-item" style="background-image: url(\'' . esc_url( $image[0] ) . '\');">';
						echo '<p class="gallery-caption">' . esc_attr( get_post( $pic_id )->post_excerpt ) . '</p>';
						if ( $lightbox == 'enabled' ) echo '<a href="' . esc_url( $image[0] ) . '" rel="lightbox"></a>';
						echo '</div></li>';
						// Increase position counter
						if ( $x < $max_pos ) { $x++; } else { $x = 1; }
					}
					echo '</ul></div>';

				}
			
			} elseif ( $style == 'masonry' ) {
				
				$link = $lightbox == 'enabled' ? true : false;
				quadro_maybe_print_gallery_field( 'quadro_mod_gallery_gallery', $mod_id, 'full', 'gallery-gallery', true, $link );
			
			} else {
				
				$link = $lightbox == 'enabled' ? true : false;
				quadro_maybe_print_gallery_field( 'quadro_mod_gallery_gallery', $mod_id, 'quadro-med-thumb', 'gallery-gallery', true, $link );
			
			} ?>
		
		</div><!-- .inner-mod -->

	</div><!-- .mod-content -->

</section><!-- .module -->
