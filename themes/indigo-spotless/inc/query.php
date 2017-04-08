<?php
/**
 * Functions for customizing post queries
 */

/* ============= "soft" (performant, paging-friendly) random ordering ============= */

/**
 * randomize post order within a page of results
 */
function aecom_soft_rand_shuffle( $posts, $query ) {
  if ( aecom_should_randomize_query( $query ) ) {
    // save original order - mainly for use in project archive's ?qp=...
    // (for paging thru individual projects)
    $i = ( ( $query->is_paged() ? $query->get( 'paged' ) : 1 ) - 1 ) * $query->get( 'posts_per_page' );
    foreach( $posts as &$post ) {
      $post->original_query_order = $i + 1;
      $i += 1;
    }
    // randomize order - or special semi-rand order for projects
    if ( $query->get( 'post_type' ) === 'project' ) {
      usort( $posts, 'aecom_sort_projects' );
    } else {
      shuffle( $posts );
    }
  }
  return $posts;
}
//add_filter( 'posts_results', 'aecom_soft_rand_shuffle', 10, 2 );

/**
 * should a given query be randomized?
 */
function aecom_should_randomize_query( $query ) {
  if ( ! aecom_should_filter_query( $query ) ) return false;
  if ( ! $post_type = $query->get( 'post_type' ) ) return false;

  if ( in_array( $post_type, array( 'person', 'project' ) ) ) return true;

  return false;
}

/* ============= special paging for people ============= */

/**
 * show two fewer people on the first page of people,
 * to make room for the callout box
 */
function aecom_page_people( $query ) {
  if ( aecom_should_filter_query( $query ) && $query->is_post_type_archive( 'person' ) ) {

    if ( empty( $_GET['qp'] ) ) { // unfiltered - the "people" lander

      if ( ! $query->is_paged ) {
        $query->set( 'posts_per_page', 14 );
      } else {
        $query->set( 'posts_per_page', 16 );
        $query->set( 'offset', 16 * ( $query->get( 'paged' ) - 1 ) - 2 );
      }

    } else { // filtered - a "military/students/etc testimonials" page

      $query->set( 'posts_per_page', 6 );
    }
  }
  return $query;
}
add_action( 'pre_get_posts', 'aecom_page_people' );


/* ============= general query alteration helpers ============= */

/**
 * only filter main queries
 */
function aecom_should_filter_query( $query ) {
  if ( ! $query->is_main_query() ) return false;
  if ( $query->is_admin() ) return false;
  return true;
}


/* ============= custom searches ============= */

/**
 * interpret search_type query var
 *
 * `search_type` serves as a proxy for slightly more ungainly query var combos,
 * and by checking for it in inc/templates.php, we can ensure we always use
 * the search template for search results and not a post type archive template.
 */
function aecom_use_search_types( $query ) {

  // if this isn't one of our custom searches, then who cares?
  if ( ! $search_type = $query->get( 'search_type' ) ) return;

  switch ( $search_type ) {
  /* *********** DEACTIVATED WHILE IT IS COMPLETED: it is missing to format results in global search
  case 'offices':
    //search of offices are performed in the universal site only, so change blog temporally
    switch_to_blog(aecom_get_uni_blog_id());
    $query->set( 'post_type', 'office' );
    break;*/
  case 'markets':
    $query->set( 'post_type', 'market' );
    break;
  case 'solutions':
    $query->set( 'post_type', 'service' );
    break;
  case 'projects':
    $query->set( 'post_type', 'project' );
    break;
  case 'insights':
    if ( $documents_page = get_page_by_path( 'documents' ) )
      $query->set( 'post_parent', $documents_page->ID );
    break;
  case 'careers':
    // TODO
    break;
  case 'press-releases':
    $query->set( 'post_type', 'press-release' );
    break;
  }
}
add_action( 'pre_get_posts', 'aecom_use_search_types' );

/**
 * This function is created just to restore blog after a search for offices because this search is done in the universal blog, then a change of blog is done temporally.
 */
/* *********** DEACTIVATED WHILE IT IS COMPLETED: it is missing to format results in global search
function restore_blog_from_office_search($found_posts, $query){
  if ( ! $search_type = $query->get( 'search_type' ) ) return;

  //check if query was for offices
  if('offices' == $search_type )
    restore_current_blog();

  return $found_posts;
}
add_filter('found_posts', 'restore_blog_from_office_search', 10, 2);*/

/**
 * add ?search_type= query var
 */
function aecom_add_search_type_query_var( $qvars ) {
  $qvars[] = 'search_type';
  return $qvars;
}
add_filter( 'query_vars', 'aecom_add_search_type_query_var' );
