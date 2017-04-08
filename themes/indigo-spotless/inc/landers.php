<?php
/**
 * support for lander (pseudo-archive) pages
 */

// ============= template tags etc. =============

/**
 * get the permalink for the lander page of a post type,
 * falling back on post type archive if none exists
 */
function aecom_get_post_type_lander_link( $post_type ) {
  if ( $lander = aecom_get_post_type_lander( $post_type ) ) {
    return get_permalink( $lander );
  }
  return get_post_type_archive_link( $post_type );
}

/**
 * get the lander for a post type, if one exists
 */
function aecom_get_post_type_lander( $post_type ) {
  if ( ! is_object( $post_type ) )
    $post_type = get_post_type_object( $post_type );

  return get_page_by_path( $post_type->rewrite['slug'] );
}

/**
 * get the post type that $lander_page is a lander for, if it is one
 */
function aecom_get_lander_post_type( $lander_page ) {
  if ( ! is_object( $lander_page ) )
    $lander_page = get_post( $lander_page );

  // get all post types (really there can only be one) whose
  // rewrite slugs match the current post's slug
  $post_type_candidates = get_post_types( array(
    'rewrite' => array(
      'slug' => $lander_page->post_name,
      'with_front' => false,
      'pages' => 1,
      'feeds' => true,
      'ep_mask' => EP_PERMALINK,
    ),
  ), 'objects' );

  if ( empty( $post_type_candidates ) )
    return false;

  return array_shift( $post_type_candidates );
}


// ============= class filters =============

/**
 * add ancestor class to current post type's lander in nav menus
 */
function aecom_lander_menu_class( $classes, $item, $args ) {

  $post_type = false;

  // don't highlight lander nav items if this is a global search
  // that's just been filtered by post type
  if ( aecom_is_site_search() ) {
    return array_diff( $classes, array( 'current-page-ancestor' ) );
  }

  if ( is_post_type_archive() ) {
    $post_type = get_queried_object();
  }
  if ( is_single() ) {
    $post_type = get_post_type_object( get_post()->post_type );
  }

  if ( $post_type && ( $lander = aecom_get_post_type_lander( $post_type ) ) ) {
    if ( is_post_type_archive() && $lander->ID === $item->ID ) {
      $classes[] = 'current-menu-item current_page';
    } else {
      $ancestors = get_post_ancestors( $lander );
      array_push( $ancestors, $lander->ID );

      $object_id = get_post_meta( $item->ID, '_menu_item_object_id', true );
      if ( in_array( $item->ID, $ancestors ) || in_array( $object_id, $ancestors ) )
        $classes[] = 'current-menu-item-ancestor current_page_ancestor';
    }
  }

  return $classes;
}
add_filter( 'nav_menu_css_class', 'aecom_lander_menu_class', 50, 3 );
add_filter( 'page_css_class', 'aecom_lander_menu_class', 50, 3 );

/**
 * add body classes to treat lander as archive
 */
function aecom_lander_body_classes( $classes ) {
  if ( ! is_page() ) return $classes;

  if ( $post_type = aecom_get_lander_post_type( get_post() ) ) {
    $classes[] = 'post-type-archive post-type-archive-' . $post_type->name;
  }
  return $classes;
}
// add_filter( 'body_class', 'aecom_lander_body_classes' );


// ============= templates =============

/**
 * use archive templates for searches
 */
function aecom_lander_template_include( $template ) {
  if ( is_post_type_archive() && aecom_is_search() ) {
    $template = get_archive_template();
  }
  return $template;
}
add_filter( 'template_include', 'aecom_lander_template_include' );


// ============= adapt urs-* plugins =============

/**
 * remove 'has_archive' from URS custom post types
 * hook runs late so it happens after urs_projects_register_cpt()
 */
function aecom_use_lander_pages() {
  global $wp_post_types;

  // post types that should use a lander page
  $lander_post_types = array(
    'market',
    'project',
    'service',
    'person',
  );

  foreach ( $lander_post_types as $post_type ) {
    if ( isset( $wp_post_types[ $post_type ] ) ) {

      $post_type_object =& $wp_post_types[ $post_type ];
      $slug = $post_type_object->rewrite['slug'];

      if ( $landing_page = aecom_get_post_type_lander( $post_type_object ) ) {
        $post_type_object->has_archive = false;
        add_rewrite_rule( "{$slug}/?$", 'index.php?pagename=' . $landing_page->post_name, 'top' );
      }

    }
  }
}
// add_action( 'init', 'aecom_use_lander_pages', 60 );


// ============= hook into admin bar =============

/**
 * add an "edit lander page" to post type archives that have landers
 */
function aecom_add_edit_lander_link( $wp_admin_bar ) {
  if ( is_post_type_archive() ) {
    $post_type = get_queried_object();
    if ( $lander = aecom_get_post_type_lander( $post_type ) ) {
      // see wp-includes/admin-bar.php:574
      $wp_admin_bar->add_menu( array(
        'id' => 'edit',
        'title' => __( 'Edit Lander Page', 'aecom' ),
        'href' => get_edit_post_link( $lander->ID ),
      ) );
    }
  }
}
// match priority of 'wp_admin_bar_edit_menu' - see wp-includes/class-wp-admin-bar.php:567
add_action( 'admin_bar_menu', 'aecom_add_edit_lander_link', 80 );
