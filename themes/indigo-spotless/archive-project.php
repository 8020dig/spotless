<?php
/**
 * The template for displaying Archive pages.
 *
 * @package quadro
 *
 * Sorry by duplicating code but there is no time to modularize, then I just copy the same code used for markets.
 * TO-DO: Use just one template for archive pages. This file is the same than archive-market.
 */
get_header();
//global $wp_query;
//print_r($wp_query);
//exit;
 ?>

<?php // Define Animations
$anim = esc_attr($quadro_options['blog_layout']) == 'masonry' ? 'anim-grid' : ''; ?>

<?php // Define Sidebar class
$sidebar = esc_attr($quadro_options['blog_sidebar']) == 'sidebar' ? 'with-sidebar' : 'no-sidebar'; ?>	
	<?php if ( have_posts() ) : ?>

	<main id="main" class="site-main blog-style-<?php echo esc_attr($quadro_options['blog_layout']); ?> masonry-margins-<?php echo esc_attr($quadro_options['masonry_margins']); ?> <?php echo $sidebar; ?>" role="main">
	<?php //get the projects page ID			
				$quadro_object = get_page_by_path('projects');
				$quadro_id = $quadro_object ->ID;											
		?>
		<header class="archive-header dafd" <?php echo $style; ?> style="background-image: url(<?php echo get_the_post_thumbnail_url($quadro_id); ?>)">
			<div class="inner-archive"><h1 class="archive-title">Clients</h1></div>
		</header><!-- .archive-header -->
		
		
		<div class="page-wrapper clear">
		
		  <?php get_template_part( 'template-parts/filter', $post->post_type ); ?>
		
			<div id="primary" class="content-area">
			
			  <?php
					  if( $paged <= 1 ):
					    //$post_type = get_post_type();
		          get_template_part( 'template-parts/content', 'lander' );
		        endif;
		        ?>

				<div id="grid" class="<?php echo $anim; ?> anim-<?php echo esc_attr($quadro_options['blog_animation']); ?> blog-container blog-content blog-<?php echo esc_attr($quadro_options['blog_layout']); ?> blog-columns-<?php echo esc_attr($quadro_options['blog_columns']); ?>">

					<?php /* Start the Loop */ 
						/*$location_id = $_GET['ql'][0];							
						if(!empty($location_id)){
							$state = 0;			
							$args = array(
								'post_type' => 'project',
								'post_status' => 'publish',
								'posts_per_page' => -1
							);
							$project_query = new wp_query($args);
							if ( $project_query -> have_posts() ){
								while ( $project_query -> have_posts() ) {
									$project_query -> the_post();
									$project_id = $post->ID;	
									$meta_info = get_post_custom($project_id);								
									$property_location = $meta_info['_locations'];
									foreach ($property_location as $key => $value) {
										if($value == $location_id){										
											get_template_part( 'content', esc_attr($quadro_options['blog_layout']) ); 
											$state ++;
										}
									}
								}
								wp_reset_postdata();
							}																		
							if($state == 0 ){
								echo '<p style="text-align: center;">There are no records present for this area.<p>';
							}							
						} else {*/
							while ( have_posts() ) : the_post(); // Call template for post content
								get_template_part( 'content', esc_attr($quadro_options['blog_layout']) ); 					
						endwhile; //}
						wp_reset_postdata();
					?>

				</div>

				<?php quadro_paging_nav( '<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>' ); ?>

			</div><!-- #primary -->

			<?php get_sidebar(); ?>

		</div><!-- .page-wrapper -->

	</main><!-- #main -->

	<?php else : ?>

	<main id="main" class="site-main <?php echo $sidebar; ?>" role="main">
		
		<div class="page-wrapper clear">

			<div id="primary" class="content-area">
				<?php get_template_part( 'content', 'none' ); ?>
			</div><!-- #primary -->
			
			<?php get_sidebar(); ?>

		</div><!-- .page-wrapper -->
	
	</main><!-- #main -->

	<?php endif; ?>

<?php get_footer(); ?>
