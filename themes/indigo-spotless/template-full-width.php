<?php
/**
 * Template Name: Page - Full Width
 * 
 * The template for displaying full width standard pages.
 * Note: Page styles function gets called in header.php
 * 
 */

get_header(); ?>

	<main id="main" class="site-main" role="main">
		
		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'page-header' ); ?>

			<div class="menu-wrapper">

				
				<?php 
				// ---- import data from Database ----
					if ($post->post_parent!=0){
						$current_id = $post->post_parent;
					}else{
					 	$current_id = $post->ID;
					}

					$args = array(
						'post_parent' => $current_id,
						'post_type'   => 'any', 
						'numberposts' => -1,
						'post_status' => 'publish'
					);
					$args = array(
					    'post_type'      => 'page',
					    'posts_per_page' => -1,
					    'post_parent'    => $current_id,
					    'order'          => 'ASC',
					    'orderby'        => 'menu_order'
					 );
					$get_child = get_children($args);
				?>  <!-- end importing data -->

				<ul>
					<?php
						/*wp_list_pages( array(
					        'title_li'    => '',
					        'child_of' => $post->ID
					    ) );*/
						
						// import data of child page and export
						foreach ($get_child as $key) {

							$sub_title  = $key -> post_title;
							$get_checked=get_post_meta($key->ID, 'page_dont_show_checked', true);

						if($get_checked!="hide"){ 

							if (($key->ID) == ($post->ID)) { ?>
								<li class="active"><a href = <?php echo(esc_url(get_permalink($key->ID))); ?> > <?php echo $sub_title; ?></a></li>
							<?php }else { ?>
					
								<li keyid=<?php echo $key->ID; ?> postid=<?php echo $post->ID; ?>><a href = <?php echo(esc_url(get_permalink($key->ID))); ?> > <?php echo $sub_title; ?></a></li>	
							<?php } ?>
					
					<?php 
							}
						}	
					?>
				</ul>
			</div>


			<div class="page-wrapper clear">

				<div id="primary" class="content-area">

					<?php get_template_part( 'content', 'page' ); ?>

					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || '0' != get_comments_number() ) :
							comments_template();
						endif;
					?>

				</div><!-- #primary -->

			</div><!-- .page-wrapper -->

		<?php endwhile; // end of the loop. ?>

	</main><!-- #main -->

<?php get_footer(); ?>
