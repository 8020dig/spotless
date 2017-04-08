<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package AECOM
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function aecom_body_classes( $classes ) {
  global $post;

  // Adds a class of group-blog to blogs with more than 1 published author.
  if ( is_multi_author() ) {
    $classes[] = 'group-blog';
  }

  if ( is_search() && ( ! is_post_type_archive() || get_query_var( 'search_type' ) ) ) {
    $classes[] = 'site-search';
  }

  if ( is_singular( array( 'project', 'person' ) ) ) {
    $classes[] = 'has-post-navigation';
  }

  if ( $post ) {

    if ( $post->post_parent > 0 ) {
      $classes[] = 'in-subsection';
    }

    if ( strpos( $post->post_name, 'template-investors' ) === 0 ) {
      $classes[] = 'has-sidebar';
      if ( $post->post_name === 'template-investors-secondary' ) {
        $classes[] = 'in-subsection';
      }
    }

    if ( $post->post_name === 'news-publications' || is_singular( 'press-release' ) ) {
      $classes[] = 'newsroom';
    }
  }

  if ( aecom_is_one_page() ) {
    $classes[] = 'one-page-site';
  }

  if ( AECOM_GENERATING_TEMPLATE ) {
    $classes[] = 'remote-template-loading';
  }

  return $classes;
}
add_filter( 'body_class', 'aecom_body_classes' );

/**
 * Get posts with filters enabled (enables caching of results)
 */
function aecom_get_posts( $args ) {
  $args['suppress_filters'] = false;
  return get_posts( $args );
}

/**
 * add async attribute to selected scripts
 */
function aecom_async_attribute( $script_tag, $handle ) {
  if ( ! in_array( $handle, array( 'wistia-api' ) ) )
    return $script_tag;

  return str_replace( " src=", " async='async' src=", $script_tag );
}
add_filter( 'script_loader_tag', 'aecom_async_attribute', 10, 2 );

/**
 * remove Yoast SEO comment that reveals plugin version #
 */
function aecom_remove_wpseo_version_comment() {
  global $wpseo_front;
  if ( $wpseo_front ) {
    remove_action( 'wpseo_head', array( $wpseo_front, 'debug_marker' ), 2 );
  }
}
add_action( 'init', 'aecom_remove_wpseo_version_comment', 11 ); // run AFTER wpseo's init action
