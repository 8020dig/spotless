<?php
/*
Template Name: Modular Page
*/

get_header(); ?>

<?php 
// Get Page metadata
$page_id = get_the_ID();

$hide_header 		= esc_attr( get_post_meta( $page_id, 'quadro_page_header_hide', true ) );
if ( $hide_header != 'true' ) {
	$header_pos 	= esc_attr( get_post_meta( $page_id, 'quadro_page_header_pos', true ) );
	$header_size 	= esc_attr( get_post_meta( $page_id, 'quadro_page_header_size', true ) );
	$use_tagline 	= esc_attr( get_post_meta( $page_id, 'quadro_page_show_tagline', true ) );
	$page_tagline 	= esc_attr( get_post_meta( $page_id, 'quadro_page_tagline', true ) );
	$back_color     = esc_attr( get_post_meta( $page_id, 'quadro_page_header_back_color', true ) );
}
$qi_mods_nav = array();
$qi_mods_count = 0;
?>	

	<main id="main" class="modular-wrapper" role="main">
	
		<div id="primary" class="modular-modules">	

			<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php if ( $hide_header != 'true' ) { ?>
				<header class="page-header <?php echo $header_pos; ?>-header <?php echo $header_size; ?>-header">
					<div class="page-inner-header">
						<h1 class="page-title"><?php the_title(); ?></h1>
						<?php if ( $use_tagline == 'true' ) { ?>
						<h2 class="page-tagline"><?php echo $page_tagline; ?></h2>
						<?php } ?>
						<?php quadro_breadcrumbs(); ?>
					</div>
				</header><!-- .page-header -->
				<?php } ?>

				<?php // Call Transients Fragment Cache
				qi_fragment_cache( 'modpage' . get_the_ID(), 7 * DAY_IN_SECONDS, function() { ?>

					<?php // Query for the Modular Template Modules
					$args = array(
						'post_type' => 'quadro_mods',
						'posts_per_page' => -1,
						'no_found_rows' => true,
						'update_post_term_cache' => false,
					);
					// Bring selected modules for this page
					$args = quadro_add_selected_posts( get_the_ID(), 'quadro_mod_temp_modules', $args );
					$quadro_mods = new WP_Query( $args );
					?>
					
					<?php if ( $quadro_mods->have_posts() ) : while( $quadro_mods->have_posts() ) : $quadro_mods->the_post(); ?>
							
						<?php // Store data for later use in navigation
						global $qi_mods_nav, $qi_mods_count;
						$qi_mods_nav[$qi_mods_count]['id'] 	= get_the_ID();
						$qi_mods_nav[$qi_mods_count]['title'] = get_the_title(); 
						$qi_mods_count++; ?>

						<?php // Retrieve Module type
						$mod_type = esc_attr( get_post_meta( get_the_ID(), 'quadro_mod_type', true ) ); ?>
						<?php // and call the template for it
						get_template_part( 'module', $mod_type ); ?>

					<?php endwhile; endif; // ends 'quadro_mods' loop ?>
					<?php wp_reset_postdata(); ?>

				<?php }); ?>

			</section><!-- #post-## -->

			<?php // Bring Modules Navigation if Enabled
			if ( esc_attr( get_post_meta( $page_id, 'quadro_mod_temp_navigation', true ) ) == 'on' ) { ?>
				<nav class="modules-navigation">
					<ul>
						<?php foreach ($qi_mods_nav as $nav_item) {
							echo '<li class="clear"><a href="#post-' . $nav_item['id'] . '" class="scroll-to-link"></a>
							<span class="mod-nav-tooltip">' . $nav_item['title'] . '</span></li>';
						} ?>
					</ul>
				</nav>
			<?php } ?>

		</div><!-- #primary -->
		
	</main><!-- #main -->

<?php get_footer(); ?>