<?php
/**
 * The Template for displaying all single posts.
 *
 * @package quadro
 */

get_header(); ?>

	<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>
		
<!-- 			<?php get_the_title(); ?> -->
			
			<?php if(has_post_thumbnail()): ?>
			<div class="featured-image-container" style="background-image: url(<?php the_post_thumbnail_url('full') ?>)">
				<h1><a class="back-parent" href="<?php echo get_site_url().'/solutions';?>">
				<span><</span> INTEGRATED SERVICES</a><?php the_title(); ?></h1>
				<div class="dark-overlay"></div>
			</div>
			<?php endif; ?>
			<?php get_template_part( 'content', 'single-service-header' ); ?>
			<div class="single-wrapper clear">
				<?php
					$contact_info = aecom_get_related_contact_info();
					$contact_count = count($contact_info);
					$empty_style = "";
					if ($contact_count == 0) {
						$empty_style = "float:left;width:100%;";
					}
				?>
				<div id="primary" class="content-area" style="<?=$empty_style;?>">

					<?php get_template_part( 'content', 'single' ); ?>

					<?php quadro_post_nav( '<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>', 'quadro-med-thumb', false ); ?>

				</div><!-- #primary -->
				<?php 
					if ($contact_count) {
						get_sidebar('service'); 
					}
				?> 
<!-- JTF hide sidebars tempoararily 2.26.17 				<?php if ( esc_attr( $quadro_options['single_sidebar'] ) == 'sidebar') get_sidebar(); ?> -->
				
  		  <?php get_template_part( 'template-parts/related-projects' ); ?>

			</div><!-- .single-wrapper -->

		<?php endwhile; // end of the loop. ?>
	
	</main><!-- #main -->

<?php get_footer(); ?>