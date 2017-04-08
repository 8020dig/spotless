<?php
/**
 * The template used for displaying Call to Action Modules content
 *
 */
?>

<?php 
$mod_id = get_the_ID();

// Get Call to Action Module data
$header_layout 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_header_layout', true ) );
$overlay		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_overlay', true ) );
$cta_text 		= wp_kses_post( get_post_meta( $mod_id, 'quadro_mod_cta_text', true ) );
$action_text 	= wp_kses_post( get_post_meta( $mod_id, 'quadro_mod_cta_action_text', true ) );
if ( $action_text != '' ) {
	$action_link 	= esc_url( get_post_meta( $mod_id, 'quadro_mod_cta_action_link', true ) );
	$action_color 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_cta_action_color', true ) );
	$action_back 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_cta_action_back', true ) );
}
$size			= esc_attr( get_post_meta( $mod_id, 'quadro_mod_cta_size', true ) );
$anim 			= esc_attr( get_post_meta( $mod_id, 'quadro_mod_cta_anim', true ) );
$anim_delay 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_cta_anim_delay', true ) );
// Ensure minimal default value for animation delay
$anim_delay		= $anim_delay !== '' ? $anim_delay : 0;

// Bring avaiable animations
$qi_animations = qi_available_animations();

?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-cta <?php quadro_mod_parallax($mod_id); ?> modheader-<?php echo $header_layout; ?> size-<?php echo $size; ?> overlay-<?php echo $overlay; ?>">

	<?php // Apply function for inline styles
	quadro_mod_styles( $mod_id ); ?>

	<div class="dark-overlay"></div>
	
	<?php quadro_mod_title( $mod_id ); ?>

	<div class="mod-content">

		<div class="inner-mod">

			<div class="cta-wrapper">
				
				<div class="cta-content-wrapper <?php echo $qi_animations[$anim]['first']; ?>">
					<?php $cta_text = apply_filters( 'the_content', $cta_text );
					echo $cta_text; ?>
				</div>


				<div class="cta-button-wrapper">
					<?php if ( $action_text != '' ) { ?>
						<a href="<?php echo $action_link; ?>" style="color: <?php echo $action_color; ?> !important; background: <?php echo $action_back; ?>;" class="cta-button qbtn <?php echo $qi_animations[$anim]['second']; ?>" data-wow-delay="<?php echo $anim_delay; ?>ms"><?php echo $action_text; ?></a>
					<?php } ?>
				</div>
			
			</div><!-- .cta-wrapper -->

		</div><!-- .inner-mod -->

	</div><!-- .mod-content -->

</section><!-- .module -->
