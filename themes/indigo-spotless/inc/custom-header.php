<?php
/**
 * Sample implementation of the Custom Header feature.
 *
 * @link http://codex.wordpress.org/Custom_Headers
 *
 * @package AECOM
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses aecom_header_style()
 * @uses aecom_admin_header_style()
 * @uses aecom_admin_header_image()
 */
function aecom_custom_header_setup() {
  add_theme_support( 'custom-header', apply_filters( 'aecom_custom_header_args', array(
    'header-text'            => false,
    'width'                  => 126,
    'height'                 => 29,
  ) ) );
}
add_action( 'after_setup_theme', 'aecom_custom_header_setup' );

function aecom_header_style() {
  if ( $image = get_header_image() ) {
    wp_add_inline_style( 'aecom-style', ".site-title a { background-image: url($image); }" );
  }
}
add_action( 'wp_enqueue_scripts', 'aecom_header_style' );
