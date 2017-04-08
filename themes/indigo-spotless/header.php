<?php
/**
 * The Header for our theme.
 *
 * IMPORTANT ANALYTICS NOTE: All tracking (Google Analytics, Hotjar, etc) must be added via plugins or using additional child themes.
 *
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head <?php do_action( 'add_head_attributes' ); ?>>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<script src="http://clients3.weblink.com.au/Clients/SpotlessGroup/PriceJS.aspx"></script>

<?php // Retrieve Theme Options
$quadro_options = quadro_get_options(); ?>

<?php if ( ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) && $quadro_options['favicon_img'] ) { ?>
<link rel="shortcut icon" href="<?php echo esc_url( $quadro_options['favicon_img'] ); ?>">
<?php } ?>

<?php // Get ID (with conditional for WooCommerce shop)
$page_id = class_exists( 'Woocommerce' ) && is_shop() ? get_option('woocommerce_shop_page_id') : get_the_id();

// Bring Show Search Option
$show_search = esc_attr( $quadro_options['search_header_display'] );

$hide_header_class = '';
?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php 
if ( is_page() ) {

	// Apply function for inline styles
	quadro_page_styles( $page_id ); 
	// Check for Hidden Header class
	$hide_header 		= esc_attr( get_post_meta( $page_id, 'quadro_page_header_hide', true ) );
	$hide_header_class 	= $hide_header == 'true' ? ' header-hide' : '';
} ?>

<?php if ( class_exists( 'Woocommerce' ) && ( is_woocommerce() ) ) {
	// Apply function for inline styles of WooCommerce special pages
	// using the selected Shop page options
	quadro_page_styles( get_option('woocommerce_shop_page_id') ); 
} ?>

<div id="page" class="hfeed site">

	<header id="masthead" class="site-header <?php echo $show_search; ?>-search">

		<div class="header-1st-row">
			<div class="inner-header">
				<?php qi_header_1st_row_left(); ?><a class="ticker" href="/investors/"><div class="wl-last-price-div"></div><span class="fa-icon_info"></span></a>
				<?php qi_header_1st_row_center(); ?>
				<?php qi_header_1st_row_right(); ?>
			</div>
		</div>

		<div class="header-2nd-row">
			<div class="inner-header">
				<?php qi_header_2nd_row_left(); ?>
				<?php qi_header_2nd_row_center(); ?>
				<?php qi_header_2nd_row_right(); ?>
			</div>
		</div>

		<?php // Print Topper Widget Area if enabled
		quadro_widget_area( 'widgetized_header_display', 'widgt_header_layout', 'topper-header', 'header-sidebar', false ); ?>
	
	</header><!-- #masthead -->
	<div id="content" class="site-content <?php echo $hide_header_class; ?>">
