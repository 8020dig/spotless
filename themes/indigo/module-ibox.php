<?php
/**
 * The template used for displaying Info Box Modules content
 *
 */
?>

<?php 
$mod_id = get_the_ID();

// Get Info Box Module data
$header_layout 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_header_layout', true ) );
$overlay		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_overlay', true ) );

$ibox_title 	= wp_kses_post( get_post_meta( $mod_id, 'quadro_mod_ibox_title', true ) );
$ibox_text 		= wp_kses_post( get_post_meta( $mod_id, 'quadro_mod_ibox_text', true ) );
$ibox_icon 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_ibox_icon', true ) );

$button_text 	= wp_kses_post( get_post_meta( $mod_id, 'quadro_mod_ibox_button_text', true ) );
if ( $button_text != '' ) {
	$button_link 	= esc_url( get_post_meta( $mod_id, 'quadro_mod_ibox_button_link', true ) );
	$button_color 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_ibox_button_color', true ) );
	$button_back 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_ibox_button_back', true ) );
}

$ibox_position		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_ibox_position', true ) );
$ibox_background	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_ibox_background', true ) );
$text_color			= esc_attr( get_post_meta( $mod_id, 'quadro_mod_ibox_color', true ) );
$anim 				= esc_attr( get_post_meta( $mod_id, 'quadro_mod_ibox_anim', true ) );


// Bring avaiable animations
$qi_animations = qi_available_animations();

?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-ibox <?php quadro_mod_parallax($mod_id); ?> modheader-<?php echo $header_layout; ?> position-<?php echo $ibox_position; ?> overlay-<?php echo $overlay; ?>">

	<?php // Apply function for inline styles
	quadro_mod_styles( $mod_id ); ?>

	<div class="dark-overlay"></div>
	
	<?php quadro_mod_title( $mod_id ); ?>

	<div class="mod-content">

		<div class="inner-mod">

			<div class="ibox-wrapper <?php echo $qi_animations[$anim]['first']; ?>" style="background: <?php echo $ibox_background; ?>; color: <?php echo $text_color; ?>;">

				<?php if ( $ibox_icon != '' ) 
					echo '<span class="ibox-icon"><i class="' . $ibox_icon . '"></i></span>'; ?>

				<?php if ( $ibox_title != '' ) 
					echo '<h2 class="ibox-title">' . $ibox_title . '</h2>'; ?>

				<?php if ( $ibox_text != '' ) {
					$ibox_text = apply_filters( 'the_content', $ibox_text );
					echo '<div class="ibox-text">' . $ibox_text . '</div>';
				} ?>

				<?php if ( $button_text != '' ) { ?>
					<a href="<?php echo $button_link; ?>" style="color: <?php echo $button_color; ?> !important; background: <?php echo $button_back; ?>;" class="ibox-button qbtn scroll-to-link" title="<?php echo $button_text; ?>"><?php echo $button_text; ?></a>
				<?php } ?>
			
			</div><!-- .ibox-wrapper -->

		</div><!-- .inner-mod -->

	</div><!-- .mod-content -->

</section><!-- .module -->
