<?php
/**
 * Functions for including special template files
 */

/**
 * include special template for "searches" of employees
 * by career path
 */
function aecom_testimonial_search_template_include( $template ) {
  if ( is_post_type_archive( 'person' ) && ! empty( $_GET['qp'] ) ) {
    $templates = array( 'archive-person-filtered.php', 'archive-person.php', 'archive.php' );
    $template = locate_template( $templates );
  }
  return $template;
}
add_filter( 'template_include', 'aecom_testimonial_search_template_include' );

/**
 * include template for one-page site home
 */
function aecom_one_page_site_template_include( $template ) {
  if ( aecom_is_one_page() && is_front_page() ) {
    $templates = array( 'page_one-page-home.php', 'page', 'archive.php' );
    $template = locate_template( $templates );
  }
  return $template;
}
add_filter( 'template_include', 'aecom_one_page_site_template_include' );
