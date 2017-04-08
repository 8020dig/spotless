<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package quadro
 */
//add JS file for transitions in grid
wp_register_script('grid-tiles-transition', get_stylesheet_directory_uri() . '/js/grid-tiles-transition.js', array('jquery', 'wp-util'), null, true);
wp_enqueue_script('wp-util');
wp_enqueue_script('grid-tiles-transition');

//add JS file for load more button in grid
wp_register_script('grid-load-more-button', get_stylesheet_directory_uri() . '/js/grid-load-more-button.js', array('jquery', 'grid-tiles-transition'), null, true);
wp_enqueue_script('grid-load-more-button');

get_header(); ?>

<?php // Retrieve Theme Options
$quadro_options = quadro_get_options(); ?>

<?php // Define Animations
$anim = esc_attr($quadro_options['blog_layout']) == 'masonry' ? 'anim-grid' : ''; ?>

<?php // Define Sidebar class
$sidebar = esc_attr($quadro_options['blog_sidebar']) == 'sidebar' ? 'with-sidebar' : 'no-sidebar'; ?>
		
<?php if ( have_posts() ) : ?>
	
	<main id="main" class="site-main blog-style-<?php echo esc_attr($quadro_options['blog_layout']); ?> masonry-margins-<?php echo esc_attr($quadro_options['masonry_margins']); ?> <?php echo $sidebar; ?>" role="main">

		<header class="archive-header">
			<h1 class="archive-title"><?php echo esc_html__( 'Search Results', 'indigo' ); ?></h1>
		</header><!-- .archive-header -->

		<div class="page-wrapper clear">

			<div id="primary" class="content-area">

				<p>
				<?php
				global $wp_query;
				printf( esc_html__( 'Search Results for: "%s".', 'indigo' ), '<span>' . get_search_query() . '</span>' ); ?>
				</p>

				<div id="grid" class="<?php echo $anim; ?> anim-<?php echo esc_attr($quadro_options['blog_animation']); ?> blog-container blog-content blog-<?php echo esc_attr($quadro_options['blog_layout']); ?> blog-columns-<?php echo esc_attr($quadro_options['blog_columns']); ?>">

					<?php /* Start the Loop */ ?>
					<?php //while ( have_posts() ) : the_post(); ?>

						<?php // Call template for post content
						//get_template_part( 'content', esc_attr($quadro_options['blog_layout']) ); ?>

					<?php //endwhile; ?>

				</div>

				<div class="grid-load-more-container">
				  <a id="gridLoadMoreButton" href="#" data-current-page="0"><?= __('Load more', 'indigo') ?></a>
				</div>

			</div><!-- #primary -->

			<?php get_sidebar(); ?>

		</div><!-- .page-wrapper -->
	
	</main><!-- #main -->
<?php // Call template for post content
get_template_part( 'template-parts/grid', 'item-tile' ); ?>

<script type="text/javascript">
jQuery(document).ready(function(){
  GridLoadMoreButton.init({
    remote_url: '<?= admin_url("admin-ajax.php") ?>',
    wp_action: 'ajax_search',
    template_name: 'grid-item',
    additional_data: {s: '<?= get_search_query() ?>'},
    page: 1,
    grid_container: jQuery("#grid"),
    button: jQuery("#gridLoadMoreButton")
  });
});
</script>

<?php else : ?>

	<main id="main" class="site-main" role="main">
		<div class="page-wrapper clear">
			<div id="primary" class="content-area">
				<?php get_template_part( 'content', 'none' ); ?>
			</div><!-- #primary -->
			<?php get_sidebar(); ?>
		</div><!-- .page-wrapper -->
	</main><!-- #main -->

<?php endif; ?>

<?php get_footer(); ?>
