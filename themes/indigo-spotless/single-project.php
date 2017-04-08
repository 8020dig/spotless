<?php
/**
 * The Template for displaying all single posts.
 *
 * @package quadro
 */

get_header(); ?>

	<main id="main" class="site-main" role="main">
		<?php //get the projects page ID			
				$quadro_object = get_page_by_path('projects');
				$quadro_id = $quadro_object ->ID;											
		?>
		<?php while ( have_posts() ) : the_post(); ?>
			
			<?php if(has_post_thumbnail()): ?>
<!-- backup featured image header; change featured image bg to spotless blue on project single
			<div class="featured-image-container" style="background-image: url(<?php the_post_thumbnail_url('full') ?>)"> 
	end backup featured image header-->
			<div class="featured-image-container" style="background-image: url(<?php echo get_the_post_thumbnail_url($quadro_id); ?>)">
				<h1><a class="back-parent" href="<?php echo get_site_url().'/projects';?>"><span><</span> CLIENTS</a>
				<?= __("CLIENTS", "aecom-indigo") ?>				
				</h1>
			</div>
			<?php endif; ?>
			<?php get_template_part( 'content', 'single-project-header' ); ?>
			<div class="single-wrapper clear">

				<div id="primary" class="content-area">
				
					<h1><?php the_title(); ?></h1>
					
					<div class="content-featured-image">
						<?php the_post_thumbnail('full'); ?>
					</div>

					<?php get_template_part( 'content', 'single' ); ?>

					<?php quadro_post_nav( '<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>', 'quadro-med-thumb', false ); ?>

				</div><!-- #primary -->
				
				<?php get_sidebar('project'); ?> 
				
  		  		<?php get_template_part( 'template-parts/related-projects' ); ?>

			</div><!-- .single-wrapper -->

		<?php endwhile; // end of the loop. ?>
	
	</main><!-- #main -->

<?php get_footer(); ?>