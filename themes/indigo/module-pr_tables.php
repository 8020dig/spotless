<?php
/**
 * The template used for displaying Pricing Tables Modules content
 *
 */
?>

<?php 
$mod_id = get_the_ID();

// Get Pricing Tables Module Layout Style and Posts list
$header_layout 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_header_layout', true ) );
$overlay			= esc_attr( get_post_meta( $mod_id, 'quadro_mod_overlay', true ) );
$plans 				= get_post_meta( $mod_id, 'quadro_mod_pr_tables_plans', true );
$anim 				= esc_attr( get_post_meta( $mod_id, 'quadro_mod_pr_tables_anim', true ) );
$anim_delay 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_pr_tables_anim_delay', true ) );
// Prepare <li> id
$li_id 				= 1;
// Prepare $feat_exists variable
$feat_exists		= 'featured-false';
foreach ( $plans as $plan ) {
	if ( $plan['feat'] == 'true' ) {
		$feat_exists = 'featured-true';
		break;
	}
}
// Ensure minimal default value for animation delay
$anim_delay			= $anim_delay !== '' ? $anim_delay : 0;
$delay 				= 0;

// Retrieve Theme Options & Animations
$quadro_options = quadro_get_options();
$qi_animations = qi_available_animations();

?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-pr-tables <?php quadro_mod_parallax($mod_id); ?> modheader-<?php echo $header_layout; ?> overlay-<?php echo $overlay; ?>">
	
	<?php // Apply function for inline styles
	quadro_mod_styles( $mod_id ); ?>

	<div class="dark-overlay"></div>

	<?php quadro_mod_title( $mod_id ); ?>
	
	<div class="mod-content">

		<div class="inner-mod">

			<ul class="quadro-plans <?php echo $feat_exists; ?> plans-<?php echo count( $plans ); ?>">
				
				<?php foreach ( $plans as $plan ) { ?>
					
					<?php
					// Get options for this Plan
					$highlight 		= esc_attr( $plan['highlight'] );
					$plan_title 	= esc_attr( $plan['title'] );
					$plan_desc 		= strip_tags( $plan['description'], '<div><img><p><span><a><br><strong><em><i><bold><small>' );
					$plan_price 	= esc_attr( $plan['price'] );
					$plan_prterm 	= esc_attr( $plan['price_term'] );
					$plan_prsub 	= esc_attr( $plan['price_subtext'] );
					$plan_features 	= strip_tags( $plan['features'], '<div><img><p><span><a><br><strong><em><i><bold><small>' );
					$plan_features	= explode( '*!', substr( $plan_features, 2 ) );
					$button_url 	= esc_url( $plan['button_url'] );
					$button_text 	= strip_tags( $plan['button_text'], '<span><strong><i><bold><small>' );
					$feat_plan 		= esc_attr( $plan['feat'] ) == 'true' ? 'featured' : 'normal';
					$plan_color 	= esc_attr( $plan['color'] ) != '#' ? esc_attr( $plan['color'] ) : esc_attr( $quadro_options['main_color'] );
					$plan_icon 		= esc_attr( $plan['icon'] );
					?>

					<li id="plan-<?php echo get_the_id() . $li_id;?>" class="quadro-plan <?php echo $qi_animations[$anim]['first']; ?> plan-<?php echo $feat_plan; ?>" data-wow-delay="<?php echo $delay; ?>ms">

						<style scoped>
							<?php // Prepare dynamic colors
							$darker_color = qi_adjust_brightness( $plan_color, -20 ); ?>
							#plan-<?php echo get_the_id() . $li_id;?> .plan-button a.qbtn:hover { background: <?php echo $darker_color; ?> !important; border-color: <?php echo $darker_color; ?> !important; }
							#plan-<?php echo get_the_id() . $li_id;?> .plan-features li i { color: <?php echo $plan_color; ?>; }
						</style>

						<div class="plan-head" style="background: <?php echo $plan_color; ?>;">
							<?php if ( $highlight != '' ) { ?>
								<span class="plan-highlight" style="background: <?php echo $darker_color; ?>;"><?php echo $highlight; ?></span>
							<?php } ?>

							<?php if ( $plan_icon != '' ) { ?>
								<div class="plan-icon">
									<i class="<?php echo $plan_icon; ?>"></i>
								</div>
							<?php } ?>
							
							<?php if ( $plan_title != '' ) { ?>
								<h2 class="plan-title"><?php echo $plan_title; ?></h2>
							<?php } ?>

							<?php if ( $plan_desc != '' ) { ?>
								<p class="plan-desc"><?php echo $plan_desc; ?></p>
							<?php } ?>
						</div>
						
						<?php if ( $plan_price != '' ) { ?>
							<div class="plan-price">
								<p class="price-value">
									<span class="price-numb" style="color: <?php echo $plan_color; ?>;"><?php echo $plan_price; ?></span>
									<span class="price-term"><?php echo $plan_prterm; ?></span>
								</p>
								<?php if ( $plan_prsub != '' ) { ?>
								<p class="price-sub"><?php echo $plan_prsub; ?></p>
								<?php } ?>
							</div>
						<?php } ?>
						
						<?php if ( is_array( $plan_features ) && $plan_features[0] != '' ) { ?>
							<div class="plan-features">
								<ul>
								<?php foreach ( $plan_features as $feature ) {
									echo '<li>' . $feature . '</li>';
								} ?>
								</ul>
							</div>
						<?php } ?>

						<?php if ( $button_url != '' ) { ?>
							<div class="plan-button">
								<a href="<?php echo $button_url; ?>" class="qbtn" style="background: <?php echo $plan_color; ?>; border-color: <?php echo $plan_color; ?>;"><?php echo $button_text; ?></a>
							</div>
						<?php } ?>
					
					</li>

					<?php // Increase animation delay
					$delay = $delay + $anim_delay; ?>

					<?php // Increase <li> id number
					$li_id++; ?>

				<?php } // ends plans loop ?>

			</ul>

		</div><!-- .inner-mod -->

	</div><!-- .mod-content -->

</section>