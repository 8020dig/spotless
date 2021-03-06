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
			</div>
			<?php endif; ?>
			<?php get_the_title(); ?>
			<?php get_template_part( 'content', 'single-project-header' ); ?>
			<div class="single-wrapper clear">

				<div id="primary" class="content-area">

					<?php get_template_part( 'content', 'single' ); ?>

					<?php quadro_post_nav( '<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>', 'quadro-med-thumb', false ); ?>

				</div><!-- #primary -->

<!-- JTF hide sidebars tempoararily 2.26.17 				<?php if ( esc_attr( $quadro_options['single_sidebar'] ) == 'sidebar') get_sidebar(); ?> -->
				
  		  <?php get_template_part( 'template-parts/related-projects' ); ?>

			</div><!-- .single-wrapper -->

		<?php endwhile; // end of the loop. ?>
	
	</main><!-- #main -->

<?php get_footer(); ?>