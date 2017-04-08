<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package AECOM
 */

// ============= low-level / utility =============

/**
 * return an i18n-friendly comma-separated list
 */
function aecom_commatize( $items ) {
  /* translators: used between list items, there is a space after the comma */
  return implode( __( ', ', 'aecom' ), array_filter( $items ) );
}

/**
 * get the current url
 */
function aecom_this_url() {
  return 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

/**
 * return an ellipsis-truncated string
 */
function aecom_substr( $str, $length = 18, $hellip = '&hellip;' ) {
  if ( strlen( $str ) <= $length ) return $str;
  return substr( $str, 0, $length - 1 ) . $hellip;
}

/**
 * weighted random sort function
 *
 * should be called with params by a separate function for use with usort()
 */
function aecom_weighted_random_sort( $weight_a, $weight_b ) {
  $order_a = mt_rand( 0, 1000 ) + ( (int) $weight_a * 10000 );
  $order_b = mt_rand( 0, 1000 ) + ( (int) $weight_b * 10000 );
  return $order_b - $order_a;
}


// ============= _s builtins =============

if ( ! function_exists( 'aecom_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function aecom_posted_on() {
  $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
  if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
    $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
  }

  $time_string = sprintf( $time_string,
    esc_attr( get_the_date( 'c' ) ),
    esc_html( get_the_date() ),
    esc_attr( get_the_modified_date( 'c' ) ),
    esc_html( get_the_modified_date() )
  );

  $posted_on = sprintf(
    esc_html_x( 'Posted on %s', 'post date', 'aecom' ),
    '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
  );

  $byline = sprintf(
    esc_html_x( 'by %s', 'post author', 'aecom' ),
    '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
  );

  echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function aecom_categorized_blog() {
  if ( false === ( $all_the_cool_cats = get_transient( 'aecom_categories' ) ) ) {
    // Create an array of all the categories that are attached to posts.
    $all_the_cool_cats = get_categories( array(
      'fields'     => 'ids',
      'hide_empty' => 1,

      // We only need to know if there is more than one category.
      'number'     => 2,
    ) );

    // Count the number of categories that are attached to the posts.
    $all_the_cool_cats = count( $all_the_cool_cats );

    set_transient( 'aecom_categories', $all_the_cool_cats );
  }

  if ( $all_the_cool_cats > 1 ) {
    // This blog has more than 1 category so aecom_categorized_blog should return true.
    return true;
  } else {
    // This blog has only 1 category so aecom_categorized_blog should return false.
    return false;
  }
}

/**
 * Flush out the transients used in aecom_categorized_blog.
 */
function aecom_category_transient_flusher() {
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    return;
  }
  // Like, beat it. Dig?
  delete_transient( 'aecom_categories' );
}
add_action( 'edit_category', 'aecom_category_transient_flusher' );
add_action( 'save_post',     'aecom_category_transient_flusher' );


// ============= urs-multilang =============

/**
 * langup a post, if possible
 */
function aecom_langup_post( $post ) {
  if ( function_exists( 'urs_multilang_langup_post' ) )
    return urs_multilang_langup_post( $post );
  return $post;
}

/**
 * get the user's chosen language
 */
function aecom_get_lang() {
  return defined( 'URS_LANG' ) ? URS_LANG : 'en';
}

/**
 * add a lang suffix to a field name
 */
function aecom_lang_suffix( $field_name ) {
  return $field_name . '_' . aecom_get_lang();
}

/**
 * get a translated field value
 */
function aecom_get_post_meta__( $post_id, $field_name ) {
  return aecom_get_post_meta( $post_id, aecom_lang_suffix( $field_name ) );
}

/**
 * get a single hidden (underscored) meta field value
 */
function aecom_get_post_meta( $post_id, $field_name ) {
  return get_post_meta( $post_id, "_$field_name", true );
}

/**
 * get an array of hidden (underscored) meta field values
 */
function aecom_get_post_meta_all( $post_id, $field_name ) {
  return get_post_meta( $post_id, "_$field_name" );
}



// ============= urs-projects =============

/**
 * retrieve related projects for the current post
 *
 * @param int $desired_rows the number of rows of projects (of length
 *                          $row_length) to display. if fewer than this
 *                          number can be found, the largest possible
 *                          multiple of $row_length will be returned.
 *
 * @param int $row_length   the length of a row.
 */
function aecom_get_related_projects( $desired_rows = 1, $row_length = 3 ) {

  $is_one_page = aecom_is_one_page();
  $is_service = is_singular( 'service' );
  $market = aecom_get_the_market();

  if ( ! ( $is_one_page || $is_service || $market ) )
    return;

  global $post;

  $desired_count = $desired_rows * $row_length;

  $meta_query = array(
    'has_thumbnail' => array(
      'key'     => '_thumbnail_id',
      'compare' => 'EXISTS',
    ),
    /*'featured'  => array(
      'key'     => '_featured_projects',
      'compare' => 'EXISTS',
    ),*/
  );

  if ( $is_service || $market ) {
    $meta_query['market'] = array(
      'key'     => $is_service ? '_services' : '_markets',
      'value'   => $is_service ? $post->ID   : $market->ID,
      'type'    => 'numeric',
      'compare' => 'IN',
    );
  }

  $query = array(
    'post_type'       => 'project',
    'posts_per_page'  => -1,
    /*'orderby'         => array(
      'featured'         => 'DESC',
      'post_title'       => 'ASC',
    ),*/
    'exclude'         => array( $post->ID ),
    'no_filter'       => true, // disable urs-projects pre_get_posts filter
    'urs_fields'      => array( 'post_title' ),
    'meta_query'      => $meta_query,
  );

  $projects = aecom_get_posts( $query );

  //order projects by featured, local and then regular
  $projects_ordered = array(
    'local' => array(),
    'featured' => array(),
    'regular' => array(),
  );
  $flags = array(
    '_featured_projects' => 'featured',
    '_exclusive_project' => 'local'
  );
  //group projects by type
  //while(!empty($project_ids)){
  foreach($projects as $proj){
    $project_id = $proj->ID;
    //get custom fields from WP cache
    $metaInfo = get_post_custom($project_id);

    //check type of project
    $grouped = false;
    foreach($flags as $customFieldName => $group)
      if(!empty($metaInfo[$customFieldName]) &&
        $metaInfo[$customFieldName][count($metaInfo[$customFieldName]) - 1]){ //check the last value for the field
        $projects_ordered[$group] []= $proj;
        $grouped = true;
        $proj->featured_project = true;
      }
    //if project is normal
    if(!$grouped)
     $projects_ordered['regular'] []= $proj;

    unset($metaInfo);
  }

  //random projects
  shuffle($projects_ordered['local']);
  shuffle($projects_ordered['featured']);
  shuffle($projects_ordered['regular']);

  //flat projects
  $projects = array_merge($projects_ordered['local'], array_merge($projects_ordered['featured'], $projects_ordered['regular']));

  $projects = array_splice( $projects, 0, $desired_count );

  // do we still need to fill empty spots in the list?
  $blank_spots = $desired_count - count( $projects );

  if ( $blank_spots > 0 ) {

    // don't add projects we're already showing
    $exclude_project_ids = wp_list_pluck( $projects, 'ID' );
    $exclude_project_ids[] = $post->ID;

    // add fallback markets:
    // current market's parents and, if this is a project,
    // the project's other markets
    $additional_markets = ( function_exists( 'urs_get_project_related_item_ids' ) ?
      urs_get_project_related_item_ids( $post->ID, 'market' ) :
      array()
    );

    $additional_markets = array_merge( $additional_markets, get_posts( array(
      'post_type' => 'market',
      // note: if $market is top level, post_parent will be 0, so we'll be
      // looking at all top level markets - but that's not unreasonable.
      'post_parent' => $market->post_parent,
      'fields' => 'ids',
    ) ) );

    // reuse query vars from original query
    $query['posts_per_page'] = $blank_spots;
    $query['exclude'] = $exclude_project_ids;
    $query['meta_query'][0]['value'] = $additional_markets;

    $additional_projects = aecom_get_posts( $query );

    $projects = array_merge( $projects, $additional_projects );
  }

  if ( empty( $projects ) ) return;

  if ( count( $projects ) < $desired_count ) {
    $return_count = $row_length * max( 1, floor( count( $projects ) / $row_length ) );
    array_splice( $projects, $return_count );
  }

  return $projects;
}

/**
 * weighted random sort for projects
 *
 * places featured projects before others, in random order,
 * followed by others in alpha order by post title
 */
function aecom_sort_projects( $a, $b ) {
  $weight_a = ( (int) aecom_get_post_meta( $a->ID, 'featured_projects' ) ) + ( (int) aecom_get_post_meta( $a->ID, 'featured_locally' ) );
  $weight_b = ( (int) aecom_get_post_meta( $b->ID, 'featured_projects' ) ) + ( (int) aecom_get_post_meta( $b->ID, 'featured_locally' ) );
  if ( ( $weight_a > 0 ) || ( $weight_b > 0 ) ) {
    return aecom_weighted_random_sort( $weight_a, $weight_b );
  } else {
    // neither is featured - order alphabetically
    return strcmp( $a->post_title, $b->post_title );
  }
}

/**
 * retrieve "ancestors" for a project for nav purposes -
 * that is, a search for its market & the projects lander
 */
function aecom_get_project_ancestors( $post = 0 ) {
  $post = get_post( $post );

  if ( $post->post_type !== 'project' )
    return array();

  $post_type = get_post_type_object( 'project' );

  $ancestors = array();

  if ( function_exists( 'urs_projects_get_the_market' )
    && ( $market = urs_projects_get_the_market() ) ) {

    // urs_projects_get_the_market() always returns a submarket,
    // so in case the market in $_GET['qm'] is a top-level market,
    // override $_GET for aecom_projects_search_link()
    $search_link = aecom_projects_search_link( array(
      'qm' => array( $market->ID ),
      'qs' => array(),
      'ql' => array(),
      's' => '',
    ) );

    $ancestors[] = sprintf(
      '<a href="%s" title="%s" class="current-page-parent">%s</a>',
      esc_url( $search_link ),
      sprintf( __( 'View all %s in the %s market', 'aecom' ),
        esc_attr( $post_type->labels->name ),
        esc_attr( $market->post_title )
      ),
      esc_html( $market->post_title )
    );
  }

  return $ancestors;
}

/**
 * retrieve the current market
 *
 * (either the market currently being viewed directly, the one
 * we're searching for, or the current project's market)
 */
function aecom_get_the_market( $post_ID = false ) {
  if ( function_exists( 'urs_projects_get_the_market' ) ) {
    return urs_projects_get_the_market( $post_ID );
  }
  return false;
}

/**
 * retrieve related project content, if possible
 */
function aecom_get_project_related( $type, $post = 0, $include_special_services = false ) {
  $post = get_post( $post );

  if ( ! function_exists( 'urs_get_project_related_items' ) )
    return array();
  $res = urs_get_project_related_items( $post->ID, $type );

  if($include_special_services){
    $specific_services = urs_get_project_specific_services($post->ID);
    $res = array_merge($res, array_filter(array_map("trim", split("\n", $specific_services))));
  }

  return $res;
}

/**
 * return a comma-separated list of related urs-projects content
 */
function aecom_list_project_related( $type, $post = 0 ) {
  $post = get_post( $post );
  $items = aecom_get_project_related( $type, $post );
  $item_names = array();
  if(!empty($items) && is_array($items))
    foreach( $items as $item ) {
      $item = aecom_langup_post( $item );
      $item_names[] = esc_html( $item->post_title );;
    }
  return aecom_commatize( $item_names );
}

/**
 * get specific services.
 */
function aecom_get_project_specific_services( $post_id ){
  return urs_get_project_specific_services($post_id);
}

/**
 * get highlights.
 */
function aecom_get_project_highlights( $post_id ){
  return urs_get_project_highlights($post_id);
}

/**
 * print a project's market(s)
 */
function aecom_project_market( $post = 0, $label = false ) {
  $market_list = aecom_list_project_related( 'market', $post );
  echo ( empty( $market_list ) ? '' :
    '<span class="aecom-project-market">' . $market_list . '</span>'
  );
}

/**
 * get a project's location(s)
 */
function aecom_get_project_location( $post = 0 ) {
  $post = get_post( $post );

  $city_tags = wp_get_post_terms( $post->ID, 'city' );
  $city_names = array();
  foreach( $city_tags as $city_tag ) {
    $city_names[] = $city_tag->name;
  }
  $city_list = aecom_commatize( $city_names );

  $location_list = aecom_list_project_related( 'location', $post );
  return ( empty( $location_list ) ? '' :
    '<span class="aecom-project-location">' . esc_html( aecom_commatize( array( $city_list, $location_list ) ) ) . '</span>'
  );
}

/**
 * print a project's location
 */
function aecom_project_location( $post = 0 ) {
  echo aecom_get_project_location( $post );
}

/**
 * get prev/next project navigation
 *
 * based on get_the_post_navigation() - see wp-includes/link-template.php
 */
function aecom_get_the_project_navigation( $args = array() ) {

  $args = wp_parse_args( $args, array(
    'prev_text'          => __( 'Previous project', 'aecom' ),
    'next_text'          => __( 'Next project', 'aecom' ),
    'screen_reader_text' => __( 'Project navigation', 'aecom' ),
    'back_text'          => __( 'Back to results', 'aecom' ),
  ) );

  $previous = $next = $navigation = '';

  if ( ! isset( $_GET['qp'] ) && function_exists( 'urs_projects_setup_project_query' ) ) {
    urs_projects_setup_project_query();
  }
  $project_page = (int) $_GET['qp'];

  //** Create link to back to search results or list of projects
  $projectsReferer = get_project_listing_referer();
  if($projectsReferer)
    $backLink = sprintf('<div class="nav-back"><a href="%s" rel="back">%s</a></div>',
      $projectsReferer,
      esc_html( $args['back_text'] )
    );
  else
    $backLink = "";

  //get next and previous project
  $navigation_projects = aecom_get_session_closest_projects();

  if ( $navigation_projects && $navigation_projects['prev'] ) {
    $previous = sprintf(
      '<div class="nav-previous"><a href="%s" rel="search">%s</a></div>',
      get_permalink($navigation_projects['prev']),
      esc_html( $args['prev_text'] )
    );
  }

  if ( $navigation_projects && $navigation_projects['next'] ) {
    $next = sprintf(
      '<div class="nav-next"><a href="%s" rel="next">%s</a></div>',
      get_permalink($navigation_projects['next']),
      esc_html( $args['next_text'] )
    );
  }

  //separator between links to go to previous and next projects
  $separator = !empty($next) && !empty($previous) ? '<span class="separator">|</span>' : "";

  // Only add markup if there's somewhere to navigate to.
  if ( $previous || $next || $backLink) {
    $navigation = _navigation_markup( $backLink . $next . $separator . $previous, 'post-navigation', $args['screen_reader_text'] );
  }

  return $navigation;
}

/**
 * return a permalink with search params
 */
function aecom_permalink_w_search( $post_id = false, $page = 1 ) {
  if ( function_exists( 'urs_projects_permalink_w_search' ) ) {
    return urs_projects_permalink_w_search( $post_id, $page, ! empty( $_GET['qn'] ) );
  }
  return get_permalink( $post_id );
}

/**
 * return an archive link with search params
 */
function aecom_projects_search_link( $get = array() ) {
  if ( function_exists( 'urs_projects_search_link' ) ) {
    return urs_projects_search_link( $get );
  }
  return get_post_type_archive_link( 'projects' );
}

/**
 * return whether or not the main query is a project search
 */
function aecom_is_search() {
  if ( function_exists( 'urs_projects_is_search' ) ) {
    return urs_projects_is_search();
  }
  return is_search();
}

/**
 * is this Solution a Specialized solution (as opposed to Global)?
 */
function aecom_is_specialized_solution( $post_id = false ) {
  if ( ! $post_id ) {
    global $post;
    $post_id = $post->ID;
  }

  return aecom_get_post_meta( $post_id, 'is_solution' ) === '1';
}

/**
 * was this post specified as "local"/"native" for the current site?
 *
 * (see urs_projects_admin_locations_box() in urs-projects/includes/editing.php)
 */
function aecom_is_local_post( $post_id = false ) {
  if ( ! $post_id ) {
    global $post;
    $post_id = $post->ID;
  }

  $post_sites = array_map( 'intval', aecom_get_post_meta_all( $post_id, 'sites' ) );
  return in_array( get_current_blog_id(), $post_sites );
}

/**
 * get project filter data
 */
function aecom_project_get_filter_data() {
  if ( ! function_exists( 'urs_project_get_filter_data' ) ) {
    return;
  }
  $args = func_get_args();
  return call_user_func_array( 'urs_project_get_filter_data', $args );
}


// ============= urs-content =============

/**
 * is this the Universal Content site?
 */
function aecom_can_push() {
  if ( function_exists( 'urs_content_can_push' ) ) {
    return urs_content_can_push();
  }
  return false;
}

/**
 * get the blog ID of the Universal Content site
 */
function aecom_get_uni_blog_id() {
  if ( function_exists( 'urs_content_get_uni_blog_id' ) ) {
    return urs_content_get_uni_blog_id();
  }
  return false;
}

/**
 * switch to the Universal Content site
 * returns false if we're already on uni, or if urs-content isn't active
 */
function aecom_maybe_switch_to_uni() {

  // no need to switch if this IS uni
  if ( aecom_can_push() ) {
    return false;
  }

  if ( $uni_blog_id = aecom_get_uni_blog_id() ) {
    return switch_to_blog( $uni_blog_id );
  }
  return false;
}

/**
 * get related links/publications
 */
function aecom_get_related_links() {
  if ( function_exists( 'urs_content_get_related_links' ) ) {
    return urs_content_get_related_links();
  }
  return false;
}

/**
 * get related contact info
 */
function aecom_get_related_contact_info() {
  if ( function_exists( 'urs_content_get_related_contact_info' ) ) {
    return urs_content_get_related_contact_info();
  }
  return false;
}
function aecom_get_individual_contact_info() {
  if ( function_exists( 'urs_content_get_individual_contact_info' ) ) {
    return urs_content_get_individual_contact_info();
  }
  return false;
}
function aecom_get_individual_contacts_label(){
  if ( function_exists( 'urs_content_get_individual_contact_label' ) ) {
    return urs_content_get_individual_contact_label();
  }
  return false;
}

/**
 * get syndicated blogs
 */
function aecom_get_blogs () {
  global $wpdb;

  $blogs = $wpdb->get_results( $wpdb->prepare("
    SELECT blog_id, domain, path
    FROM $wpdb->blogs
    WHERE site_id = %d
      -- AND public = '1'
      AND archived = '0'
      AND mature = '0'
      AND spam = '0'
      AND deleted = '0'
    ORDER BY registered DESC
  ", $wpdb->siteid), OBJECT );

  $blog_list = array();

  foreach ( (array) $blogs as $details ) {
    //$blog_list[ $details['blog_id'] ] = get_blog_details($details['blog_id'], true);
    $blog_info = $wpdb->get_row( $wpdb->prepare( "SELECT option_value FROM " . $wpdb->get_blog_prefix( $details->blog_id ) . "options WHERE option_name = %s LIMIT 1", 'blogname' ) );
    $details->siteurl = 'http://' . $details->domain . $details->path;
    $details->blogname = $blog_info->option_value;
    $blog_list[ $details->blog_id ] = $details;
  }

  return $blog_list;
}

/**
 * countries dropdown content
 */
function aecom_country_dropdown() {

  $countries = aecom_data_get_site_option( 'aecom_theme_countries', array() );
  $country_names = aecom_data_get_site_option( 'aecom_theme_country_names', array() );
  if ( false === ( $blogs = aecom_data_get( 'blogs' ) ) ) {
    $blogs = aecom_get_blogs();
    aecom_data_set( 'blogs', $blogs, 'common', true ); // global
  }

  // add blog names for any country names that were left blank
  foreach ( $countries as $flag => $site_id ) {
    if ( ! isset( $country_names[ $flag ] ) )
      $country_names[ $flag ] = $blogs[ $site_id ]->blogname;
  }

  if ( isset( $countries['_sort_alpha'] ) && !! $countries['_sort_alpha'] ) {
    unset( $countries['_sort_alpha'] );
    uasort( $country_names, 'strcasecmp' );
  }

  $list = array();
  $flag_dir = get_template_directory_uri() . '/images/flags/';

  foreach ( $country_names as $flag => $country_name ) {
    $site_id = isset( $countries[ $flag ] ) ? $countries[ $flag ] : false;
    if ( $site_id && isset( $blogs[$site_id] ) ) {
      $list[] = array(
        'blog_id'   => $blogs[$site_id]->blog_id,
        'siteurl'   => $blogs[$site_id]->siteurl,
        'blogname'  => $country_name,
        'flag'      => $flag_dir . $flag
      );
    }
  }

  $break = ceil( sizeof( $list ) / 3 );
  $break2 = ceil( sizeof( $list ) / 2 );
  //usort( $list, 'urs_blog_list_compare' );

  $current_blog_id = get_current_blog_id();

  $dropdown_title = ( $current_blog_id === 1 ?
    esc_html__( 'Locations', 'aecom' ) :
    '<span class="current-country-name">' . esc_html( aecom_data_get_option( 'blogname' ) ) . '</span>'
  );

  ?>
  <a href="#" class="ae-dropdown-toggle"><?php echo $dropdown_title; ?></a>
  <div class="ae-dropdown country-list"><div class="ae-dropdown-content">
    <ul class="col">
      <?php
      $i = 0;
      foreach ( $list as $site ) {

        if ( $i == $break ) {
          $i = 0;
          ?></ul><ul class="col"><?php
        }
        $i++;

        $active = ( $current_blog_id == $site['blog_id'] ?
          ' class="active"' : ''
        );
        ?>
        <li<?php echo $active; ?>><a href="<?php echo esc_attr( $site['siteurl'] ); ?>"><span class="flag" style="background-image: url(<?php echo esc_attr( $site['flag'] ); ?>)"></span><span class="country-name"><?php echo str_replace( '/', '/<br />', esc_html( $site['blogname'] ) ); ?></span></a></li>
        <?php
      } ?>
    </ul>
  </div></div>
  <?php
}

/**
 * get the contents of the "sidebar content" box
 */
function aecom_get_sidebar_content( $post = 0 ) {
  $post = get_post( $post );
  return do_shortcode(aecom_get_post_meta__( $post->ID, 'sidebar' ));
}

/**
 * format a stock quote
 */
function aecom_stock_quote() {

  if ( ! defined( 'AECOM_AJAX_REQUEST' ) || ! AECOM_AJAX_REQUEST ) {
    // for locally loaded pages, insert a placeholder
    // which will be replaced by js/dynamic-section-autoload.js
    ?>
    <div class="aecom-loader-placeholder autoload" data-section="stock"></div>
    <?php
    return;
  }

  if ( ! $quote = get_site_option( 'urs_content_stock_data' ) )
    return;

  $delta_class = '';
  $delta_text = __( '%1s: unchanged as of %3$s' );
  if ( floatval( $quote['change'] ) > 0 ) {
    $delta_class = 'up';
    $delta_text = __( '%1s: +%2s as of %3$s' );
  } elseif ( floatval( $quote['change'] ) < 0 ) {
    $delta_class = 'down';
    $delta_text = __( '%1s: %2s as of %3$s' );
  }

  // switch to UTC to get date/time
  // TODO: except... the feed is in ET. what?
  $normal_tz = date_default_timezone_get();
  date_default_timezone_set( 'UTC' );
  $date = date( 'h:i A \E\T m/d/Y', $quote['time'] );
  date_default_timezone_set( $normal_tz );

  $delta_text = sprintf( $delta_text, $quote['ticker'], $quote['change'], $date );

  ?>
  <aside class="stock-quote">
    <a href="http://phx.corporate-ir.net/phoenix.zhtml?c=131318&p=irol-irhome">
      <?php echo esc_html( $quote['exchange'] ); ?>
      <span class="quote-value" title="<?php echo esc_attr( $delta_text ); ?>">
        <span class="stock-status-indicator <?php echo esc_attr( $delta_class ); ?>"></span>
        <?php echo '$' . esc_html( $quote['trade'] ); ?>
      </span>
    </a>
  </aside>
  <?php
}

/**
 * is this a one-page site?
 */
function aecom_is_one_page( $site_id = false ) {
  if ( function_exists( 'urs_content_one_page' ) )
    return urs_content_one_page( $site_id );
  return false;
}

/**
 * return whether or not the main query is an office search
 */
function aecom_is_office_search() {
  if ( function_exists( 'urs_content_is_office_search' ) ) {
    return urs_content_is_office_search();
  }
  return is_search();
}


// ============= employees/people =============

/**
 * get the current person's position (job title)
 */
function aecom_get_person_position( $post = 0 ) {
  $post = get_post( $post );
  return aecom_get_post_meta__( $post->ID, 'position' );
}

/**
 * get the current person's quote
 */
function aecom_get_person_quote( $post = 0 ) {
  $post = get_post( $post );
  return aecom_get_post_meta__( $post->ID, 'quote' );
}

/**
 * retrieve "ancestors" for a person for nav purposes -
 * that is, the "why aecom" and "careers" pages
 */
function aecom_get_person_ancestors() {

  $ancestors = array();

  if ( $lander = aecom_get_post_type_lander( 'person' ) )
    $ancestors[] = $lander;

  if ( $careers = get_page_by_path( 'careers' ) )
    $ancestors[] = $careers;

  return $ancestors;
}

/**
 * retrieve "ancestors" for a filtered person archive -
 * that is, the career path and the "who we hire" page
 */
function aecom_get_filtered_person_archive_ancestors() {

  $ancestors = array();

  if ( ! empty( $_GET['qp'] ) && $career_path = get_post( (int) $_GET['qp'] ) )
    $ancestors[] = $career_path;

  // TODO: change slug of Who We Hire lander page to 'who-we-hire' when template is ready,
  // and use this instead:
  // if ( $lander = aecom_get_post_type_lander( 'career_path' ) )
  if ( $lander = get_page_by_path( 'careers/hire' ) )
    $ancestors[] = $lander;

  error_log( print_r( $lander, true ) );

  return $ancestors;
}

/**
 * get all posts in the career_path post type, except the current one
 * for listing, nav menus, etc
 */
function aecom_get_career_paths( $which = 'all' ) {

  $omit = array();
  if ( is_singular( 'career_path' ) && ( $which === 'other' ) ) {
    global $post;
    $omit[] = $post->ID;
  }

  return aecom_get_posts( array(
    'post_type' => 'career_path',
    'posts_per_page' => -1,
    'urs_fields' => array( 'post_title' ),
    'post__not_in' => $omit,
    'meta_query' => array(
      'relation'  => 'OR',
      array(
        'key'     => '_hide_in_nav',
        'compare' => '!=',
        'value'   => '1',
      ),
      array(
        'key'     => '_hide_in_nav',
        'compare' => 'NOT EXISTS',
      )
    ),
  ) );
}

/**
 * get a permalink for testimonials for a given career path
 */
function aecom_career_path_testimonials_url( $qvar ) {
  return get_post_type_archive_link( 'people' ) . '?' . $qvar;
}

/**
 * get a random employee for the current career path
 */
function aecom_get_related_people( &$more_link = null ) {

  if ( ! is_singular( 'career_path' ) ) return;

  global $post;

  // pass back a search link by reference
  $more_link = aecom_get_post_type_lander_link( 'person' ) . '?qp=' . $post->ID;

  $people = aecom_get_posts( array(
    'post_type' => 'person',
    'posts_per_page' => -1,
    'urs_fields' => array( 'post_title', 'post_content' ),
    'meta_query' => array( array(
      'key' => '_career_paths',
      'value' => $post->ID,
      'compare' => '=',
    ) ),
  ) );

  if ( ! $people ) return false;

  // randomize order, return only one
  shuffle( $people );
  array_splice( $people, 1 );
  return $people;
}


// ============= headers/menus/nav =============

/**
 * return HTML for a breadcrumb
 *
 * @param array $ancestors all the posts/objects above the current one
 * @param int   $max_depth the maximum number of ancestors to display
 */
function aecom_breadcrumb( $ancestors = array(), $current_post = false, $max_depth = 2 ) {

  $breadcrumb = '';
  $depth = 0;
  if ( ! $current_post ) {
    global $post;
    $current_post = $post;
  }

  // add post type archive as top-level ancestor, except for Pages
  if ( $current_post->post_type !== 'page' ) {
    if ( $post_type = get_post_type_object( $current_post->post_type ) ) {
      array_push( $ancestors, '<a href="' . esc_url( get_post_type_archive_link( $post_type->name ) ) . '">' . $post_type->labels->name . '</a>' );
    }
  }

  while ( $depth < $max_depth && ( $ancestor = array_shift( $ancestors ) ) ) {

    if ( is_string( $ancestor ) ) { // assume it's a link to drop in directly
      $prefix = $ancestor;
    } else {
      $ancestor = get_post( $ancestor );
      $link_class = ( $depth === 0 ? ' class="current-page-parent"' : '' );

      $prefix = '<a href="' . esc_url( get_permalink( $ancestor ) ) . '"' . $link_class . '>' . esc_html( $ancestor->post_title ) . '</a>';
    }

    // add :, unless this is the first (lowest) item in the breadcrumb
    $prefix .= ( ! empty( $breadcrumb ) ? ': ' : '' );

    $breadcrumb = $prefix . $breadcrumb;

    $depth++;
  }

  return '<p class="breadcrumb">' . $breadcrumb . '</p>';
}

/**
 * return HTML for a list of hierarchical posts
 *
 * @param int    $parent_ID ID of the post whose descendants we should list
 * @param string $post_type the (hierarchical) post type to look for
 */
function aecom_list_children( $parent_ID, $post_type = 'page', $additional_args = array() ) {
  add_filter( 'the_title', 'aecom_wrap_nav_link_title' );
  $list = wp_list_pages( array_merge( array(
    'child_of' => $parent_ID,
    'title_li' => false,
    'echo' => false,
    'depth' => 1,
    'post_type' => $post_type,
    'walker' => ( class_exists( 'URS_Multilang_Walker_Page' ) ?
      new URS_Multilang_Walker_Page :
      new Walker_Page
    ),
  ), (array) $additional_args ) );
  remove_filter( 'the_title', 'aecom_wrap_nav_link_title' );
  return $list;
}

/**
 * return the children of the current post whose _hide_in_nav option is ON
 */
function aecom_get_hidden_children( $parent = 0, $post_type = 'page' ) {
  $parent = get_post( $parent );

  $hidden_children = aecom_get_posts( array(
    'post_parent' => $parent->ID,
    'post_type' => 'page',
    'meta_key' => '_hide_in_nav',
    'meta_value' => '1',
  ) );

  return $hidden_children;
}

/**
 * sneakily word-wrap titles for long nav menus
 */
function aecom_wrap_nav_link_title( $title ) {
  return wordwrap( $title, 20 );
}

/**
 * display/return search form, optionally for a custom post type
 */
function aecom_search_form( $post_type = false, $echo = true ) {
  global $aecom_search_post_type;
  $previous_search_post_type = $aecom_search_post_type;

  $aecom_search_post_type = $post_type;
  $form = get_search_form( $echo );

  $aecom_search_post_type = $previous_search_post_type;

  return $form;
}

/**
 * display Load More links for the current query
 *
 * @param string $scope a class assigned to the element to which newly loaded
 *                      posts will be appended
 */
function aecom_posts_navigation( $scope = 'grid' ) {

  $navigation = '';

  // Don't print empty markup if there's only one page.
  if ( $GLOBALS['wp_query']->max_num_pages > 1 ) {

    $dots = '<span class="dots">' . str_repeat( '<span class="dot"></span>', 3 ) . '</span>';

    if ( $prev_link = get_next_posts_link( __( 'Load more', 'aecom' ) ) ) {
      $page = get_query_var('paged') ? get_query_var('paged') + 1 : 2;
      $navigation .= '<div class="load-more" data-page="' . $page . '" data-scope="' . esc_attr( $scope ) . '">' . $prev_link . $dots . '</div>';
    }

    $navigation = _navigation_markup( $navigation, 'ajax-posts-navigation', __( 'Explore', 'aecom' ) );
  }

  aecom_ajax_section_start( 'posts-navigation' );
  echo $navigation;
  aecom_ajax_section_end( 'posts-navigation' );
}

/**
 * return the URL for the dynamic loader PHP file
 */
function aecom_get_loader_url() {
  return get_template_directory_uri() . '/inc/dynamic/loader.php';
}

/**
 * Return current URL overriding certain query string parameters
 */
function aecom_override_current_url( $params = false ) {
  global $wp, $wp_query;

  // if query is paged, remove the page query var from the URL
  // and put it in the GET array so we can override it
  if ( $wp_query->get( 'paged' ) > 1 ) {
    $request = array( 'paged' => $wp_query->get( 'paged' ) );
    $url = preg_replace( '!/page/[0-9]+!', '', $wp->request );
  } else {
    $request = array();
    $url = $wp->request;
  }

  $request = array_merge( $request, $_GET );
  if ( $params ) {
    foreach( $params as $key => $val ) {
      if ( $val == '' )
        unset( $request[ $key ] );
      else
        $request[ $key ] = $val;
    }
  }

  // re-urlencode any & all query vars
  urlencode_deep( $request );

  return site_url( add_query_arg( $request, $url ) );
}

/**
 * is this a global search of the site?
 * (as opposed to a search from the projects filter bar)
 */
function aecom_is_site_search() {
  return !! get_query_var( 'search_type' );
}

/**
 * Change limit of posts per page when search of projects is performed
 */
add_action('pre_get_posts', function($query){
  //if it is the request to load more projects
  if(isset($_GET['dyn_part']))
    return;

  //if page parameter is in URL
  $page = empty($_GET['pp']) ? 0 : (int)$_GET['pp'];
  if($page)
    //if post type is projects
    if('project' == $query->query_vars['post_type'] || ('projects' == $_GET['search_type'] && is_search()))
      //if main query is a search
      if ( $query->is_main_query() && (is_search() || is_archive()) ){
        $query->set('posts_per_page', get_option('posts_per_page') * $page);
      }
});

/**
 * Returns the last URL used to list or search for projects.
 */
function get_project_listing_referer(){
  //open session
  if(!session_id())
    session_start();
  //if there is a tag parameter
  if(!empty($_GET['p_tag']))
    return get_post_type_archive_link('project') . '?p_tag=' . $_GET['p_tag'];

  return isset($_SESSION['project_list_referer']) ? $_SESSION['project_list_referer'] : false;
}

/**
 * Create or update the last URL to list or search for projects.
 */
function update_project_listing_referer($ajaxUpdate = false){
  //get query vars in URL
  $queryVars = array();
  if(get_query_var('s'))
    $queryVars['s'] = get_query_var('s');
  if(get_query_var('paged'))
    $queryVars['pp'] = get_query_var('paged');
  //additional vars
  $additionalVars = array('search_type', 'qm', 'qs', 'ql', 'fpp', 'p_tag');
  foreach($additionalVars as $varName)
    if(isset($_GET[$varName]))
      $queryVars[$varName] = $_GET[$varName];

  //open session
  if(!session_id())
    session_start();

  //if it is an ajax update, then use the project lander page as referer
  if($ajaxUpdate) {
    $referer = get_bloginfo('url') . "/projects/";
  }
  else {
    //get current URL and store it as referer
    $path = explode("/", $_SERVER['REDIRECT_URL']);
    $newPath = array();
    foreach($path as $e)
      if('page' != $e)
        $newPath []= $e;
      else
        break;
    $newPath = implode("/", $newPath);
    if("/" != $newPath[strlen($newPath) - 1])
      $newPath .= "/";
    $referer = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$newPath}";
  }

  //add query string
  if(!empty($queryVars))
    $referer .= "?" . http_build_query($queryVars);

  //store referer in session
  $_SESSION['project_list_referer'] = $referer;
}
/**
 * Due to WP query is modified to retrieve all projects specified by page parameter in listing page of projects,
 * it is required to reset the query.
 */
function clean_query_after_initial_projects_load(){
  $page = empty($_GET['pp']) ? 0 : (int)$_GET['pp'];
  if($page && (is_search() || is_archive()) && !isset($_GET['dyn_part'])){
    //change pagination values to build navigation links
    global $wp_query, $paged;
    $wp_query->set('paged', $page);
    $paged = $page;
    $totalPages = ceil($wp_query->found_posts / get_option('posts_per_page'));
    $wp_query->max_num_pages = $totalPages;
    $wp_query->is_paged = true;
  }
}

/**
 * Ajax listener to update the referer with pagination in the lander page of projects.
 */
add_action('wp_ajax_update_projects_referer', 'ajax_update_projects_referer');
add_action('wp_ajax_nopriv_update_projects_referer', 'ajax_update_projects_referer');
function ajax_update_projects_referer(){
  update_project_listing_referer(true);
  exit;
}

/**
 * @see urs_multilang_language_select_input in plugins/urs-multilang/includes/utils.php
 */
function aecom_multilang_switch() {
  if ( function_exists( 'urs_multilang_language_select_input' ) ) {
    return urs_multilang_language_select_input();
  }
  return false;
}
