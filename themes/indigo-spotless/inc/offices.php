<?php
/**
 * functions relating to the Offices page
 */

/**
 * return info on the Offices page on the specified site
 */
function aecom_get_offices_page_info( $site_id = 0 ) {

  if ( ! $site_id ) { // no site specified, return archive URL on the current site
    $site_id = get_current_blog_id();
  }

  // check cache
  if ( $offices_pages_by_site = get_site_transient( 'aecom_offices_pages' ) ) {
    if ( isset( $offices_pages_by_site[ $site_id ] ) ) {
      return $offices_pages_by_site[ $site_id ];
    }
  } else {
    // initialize office page array if no info in cache
    $offices_pages_by_site = array();
  }

  // URL not found in cache? go find it
  switch_to_blog( $site_id );

  // find the most recent page using the Offices template
  $template_pages = get_posts( array(
    'post_type' => 'page',
    'meta_query' => array( array(
      'key' => '_wp_page_template',
      'value' => 'page_offices.php',
    ) ),
    'order' => array(
      'post_date' => 'DESC',
    ),
    'numberposts' => 1,
  ) );

  if ( ! empty( $template_pages ) ) {
    $offices_pages_by_site[ $site_id ] = array(
      'ID' => $template_pages[0]->ID,
      'permalink' => get_permalink( $template_pages[0]->ID ),
    );
  } else {
    // if no pages use the Offices template, fall back on a hard-coded URL
    $offices_pages_by_site[ $site_id ] = array(
      'ID' => null,
      'permalink' => site_url( 'offices/' ),
    );
  }

  restore_current_blog();

  // cache results
  set_site_transient( 'aecom_offices_pages', $offices_pages_by_site );

  return $offices_pages_by_site[ $site_id ];
}

/**
 * return the URL of the Offices page on the specified site
 */
function aecom_get_offices_url( $site_id = 0 ) {
  $page = aecom_get_offices_page_info( $site_id );
  return $page['permalink'];
}

/**
 * return the ID of the Offices page on the specified site
 */
function aecom_get_offices_page_id( $site_id = 0 ) {
  $page = aecom_get_offices_page_info( $site_id );
  return $page['ID'];
}

/**
 * is this the Offices page?
 */
function aecom_is_offices_page() {
  $page_id = aecom_get_offices_page_id();
  return $page_id && is_page( $page_id );
}

/**
 * return filterable office attributes
 */
function aecom_get_office_classificators() {
  if ( function_exists( 'urs_content_get_office_classificators' ) ) {
    return urs_content_get_office_classificators();
  } else {
    return array(
      'countries'         => array(),
      'states'            => array(),
      'states_by_country' => array(),
      'cities'            => array(),
    );
  }
}
