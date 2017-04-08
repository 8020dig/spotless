<?php
/**
 * The template used for displaying Modules Columns content
 *
 */
?>

<?php 
// Retrieve Theme Options
$quadro_options = quadro_get_options();

$mod_id = get_the_ID();

// Get Columns Module data
$header_layout 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_header_layout', true ) );
$overlay		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_overlay', true ) );
$columns_layout = esc_attr( get_post_meta( $mod_id, 'quadro_mod_columns_layout', true ) );

// Query for the Columns Modules
$args = array(
	'post_type' =>  'quadro_mods',
	'posts_per_page' => -1,
	'no_found_rows' => true,
	'update_post_term_cache' => false,
);
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-columns columns-<?php echo $columns_layout; ?> clear <?php quadro_mod_parallax($mod_id); ?> overlay-<?php echo $overlay; ?>">

	<?php // Apply function for inline styles
	quadro_mod_styles( $mod_id ); ?>

	<div class="dark-overlay"></div>

	<div class="inner-mod">

		<div class="modules-columns clear">

			<div class="mod-column mod-column-1">
				
				<?php // Bring picked posts if there are some
				$picked_posts = esc_attr( get_post_meta( $mod_id, 'quadro_mod_columns_modules1', true ) );
				if ( $picked_posts != '' ) {
					
					// Prepare the picked posts list to use in query
					$picked_posts 		= explode( ', ', $picked_posts );
					$args['post__in'] 	= $picked_posts;
					$args['orderby'] 	= 'post__in';
					$column_query 		= new WP_Query( $args );
					
					if ( $column_query->have_posts() ) : while( $column_query->have_posts() ) : $column_query->the_post();
						// Retrieve Module type
						$mod_type = esc_attr( get_post_meta( get_the_ID(), 'quadro_mod_type', true ) );
						// and call the template for it
						get_template_part( 'module', $mod_type );
					endwhile; endif; // ends 'column_query' loop

				} ?>
			
			</div>

			<div class="mod-column mod-column-2">
	
				<?php // Bring picked posts if there are some
				$picked_posts = esc_attr( get_post_meta( $mod_id, 'quadro_mod_columns_modules2', true ) );
				if ( $picked_posts != '' ) {
					
					// Prepare the picked posts list to use in query
					$picked_posts 		= explode( ', ', $picked_posts );
					$args['post__in'] 	= $picked_posts;
					$args['orderby'] 	= 'post__in';
					$column_query 		= new WP_Query( $args );

					if ( $column_query->have_posts() ) : while( $column_query->have_posts() ) : $column_query->the_post();
						// Retrieve Module type
						$mod_type = esc_attr( get_post_meta( get_the_ID(), 'quadro_mod_type', true ) );
						// and call the template for it
						get_template_part( 'module', $mod_type );
					endwhile; endif; // ends 'column_query' loop

				} ?>
			
			</div>

			<div class="mod-column mod-column-3">

				<?php // layout conditional
				if ( $columns_layout == 'layout2' || $columns_layout == 'layout3' || $columns_layout == 'layout4' || $columns_layout == 'layout5' || $columns_layout == 'layout10' || $columns_layout == 'layout11' || $columns_layout == 'layout14' || $columns_layout == 'layout15' ) {

					// Bring picked posts if there are some
					$picked_posts = esc_attr( get_post_meta( $mod_id, 'quadro_mod_columns_modules3', true ) );
					if ( $picked_posts != '' ) {
						
						// Prepare the picked posts list to use in query
						$picked_posts 		= explode( ', ', $picked_posts );
						$args['post__in'] 	= $picked_posts;
						$args['orderby'] 	= 'post__in';
						$column_query 		= new WP_Query( $args );

						if ( $column_query->have_posts() ) : while( $column_query->have_posts() ) : $column_query->the_post();
							// Retrieve Module type
							$mod_type = esc_attr( get_post_meta( get_the_ID(), 'quadro_mod_type', true ) );
							// and call the template for it
							get_template_part( 'module', $mod_type );
						endwhile; endif; // ends 'column_query' loop

					}

				} ?>
			
			</div>

			<div class="mod-column mod-column-4">

				<?php // layout conditional
				if ( $columns_layout == 'layout3' ) {

					// Bring picked posts if there are some
					$picked_posts = esc_attr( get_post_meta( $mod_id, 'quadro_mod_columns_modules4', true ) );
					if ( $picked_posts != '' ) {
						
						// Prepare the picked posts list to use in query
						$picked_posts 		= explode( ', ', $picked_posts );
						$args['post__in'] 	= $picked_posts;
						$args['orderby'] 	= 'post__in';
						$column_query 		= new WP_Query( $args );
	
						// Bring picked posts if there are some
						$args = quadro_add_selected_posts( $mod_id, 'quadro_mod_columns_modules4', $args );
						$column_query = new WP_Query( $args );

						if ( $column_query->have_posts() ) : while( $column_query->have_posts() ) : $column_query->the_post();
							// Retrieve Module type
							$mod_type = esc_attr( get_post_meta( get_the_ID(), 'quadro_mod_type', true ) );
							// and call the template for it
							get_template_part( 'module', $mod_type );
						endwhile; endif; // ends 'column_query' loop

					}

				} ?>
			
			</div>

		</div>
		
		<?php wp_reset_postdata(); ?>

	</div>

</section>