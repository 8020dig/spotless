<?php
/**
 * The Template for displaying single modular post (just for playing nice, they
 * are not supposed to be accessed individually).
 */

// Exclude Custom Post Type from SE Crawling
function qi_mods_noindex() {
	echo '<meta name="robots" content="noindex, nofollow">';
}
add_action( 'wp_head', 'qi_mods_noindex' );

get_header(); ?>

<?php // Enable Modules Preview only when coming from internal request
if ( is_user_logged_in() && isset($_GET['qi']) && $_GET['qi'] === 'internal-preview' ) {
	
	echo '<div id="primary" class="modular-wrapper">
		<main id="main" class="modular-modules" role="main">';

	while ( have_posts() ) : the_post();

		// Retrieve Module type
		$mod_type = esc_attr( get_post_meta( get_the_ID(), 'quadro_mod_type', true ) );
		// and call the template for it
		get_template_part( 'module', $mod_type );

	endwhile; // end of the loop.

	echo '</div><!-- #content -->
		</main><!-- #main -->';

} else { ?>
	
	<main id="main" class="site-main" role="main">
		<header class="page-header">
			<div class="page-inner-header">
				<h1 class="page-title">
					<?php echo esc_attr( $quadro_options['404_title'] ); ?>
				</h1>
			</div>
		</header><!-- .page-header -->
		<div class="page-wrapper clear">
			<div id="primary" class="content-area">
				<section class="error-404 not-found">
					<div class="page-content">
						<div class="error-404-text">
							<?php echo strip_tags( $quadro_options['404_text'], '<div><img><p><span><a><br><strong><em><i><bold><small>' ); ?>
						</div>
						<?php get_search_form(); ?>
					</div><!-- .page-content -->
				</section><!-- .error-404 -->
			</div><!-- #primary -->
			<?php get_sidebar(); ?>
		</div><!-- .page-wrapper -->
	</main><!-- #main -->

<?php } ?>

<?php get_footer(); ?>