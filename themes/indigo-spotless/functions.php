<?php
/**
 * Functions WP file.
 */
 
//add functions file of AECOM
require get_stylesheet_directory() . '/functions-aecom.php';

/**
 * Addition of CSS styles and JS files in the website.
 */
add_action('wp_enqueue_scripts', function(){
  //include CSS styles of parent theme.
wp_enqueue_style( 'indigo-base-style', get_stylesheet_directory_uri() . '/style-aecom.css' );
});

/**
 * Get HTML code with meta info of projects. It is used as a shortcode in sidebar of projects.
 */
function project_meta_info_box(){
  //get ID of current project
  $project_id = get_the_ID();
  
  //get IDs of locations of project
  $locations_ids = urs_projects_get_post_meta_all ( $project_id, 'locations' );
  
  //get data of locations
  $locations_data = get_posts(array(
    'post_type' => 'location',
    'post__in' => $locations_ids,
    'orderby' => 'post__in'
  ));
  
  //get brands
  $brands = Brand::get_project_brands($project_id);
  
  //get services
  $services_ids = urs_projects_get_post_meta_all ( $project_id, 'services' );
  $services = get_posts(array(
    'post_type' => 'service',
    'post__in' => $services_ids,
    'orderby' => 'post__in'
  ));

  //check locations and brands
  if(empty($locations_data) && empty($brands))
    return false;
  
  //create HTML for meta info box
  ob_start();
  ?>
  <div class="project-meta-info">
    <?php if(!empty($locations_data)): ?>
    <div class="project-data-container">
      <h2><?= __("CONTRACT DETAILS", "aecom-indigo") ?></h2>
      <div class="client-container">
        <div class="client-title">
          <span><?= __("CLIENT", "aecom-indigo") ?></span>
        </div>
        <div class="client-name">
          <?= urs_projects_get_post_meta($project_id, 'client') ?>
        </div>
      </div>
      <div class="locations-container">
        <div class="locations-title">
          <span><?= __("LOCATION", "aecom-indigo") ?></span>
        </div>
        <div class="locations-list">         
          <div class="location">

            <?php foreach($locations_data as $location){ 
                $last_post_title=$location->post_title;
                $parent= $location->post_parent;
                $parent_title = get_the_title($parent);
                if ($parent_title != ""){
                  $last_parent_title = $parent_title;
                }                
                /*$grandparent= $parent->post_parent;
                $grandparent_title = get_the_title($grandparent);
                if ($grandparent_title == "Australia"){
                  //echo ",".$grandparent_title;
                }*/
               }
               echo $last_post_title.", ".$last_parent_title; 
            ?>
          </div>
          <?php 
                //}
                //echo "aaa".$parent_title.",".$grandparent_title;

          ?>
        </div>
      </div>
    </div>
    <?php endif; ?>
    
    <?php if(!empty($services)): ?>
    <div class="services-container">
      <h2><?= __("SERVICES", "aecom-indigo") ?></h2>
      <?php foreach($services as $service): ?>
      <div class="service">
        <?= $service->post_title; ?>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
    
    <?php if(!empty($brands)): ?>
    <div class="brands-container">
      <h2><?= __("BRANDS", "aecom-indigo") ?></h2>
      <?php foreach($brands as $brand): ?>
      <div class="brand">
        <?= get_the_post_thumbnail($brand, 'full', array('title' => $brand->post_title)); ?>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>

  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('project-meta-info', 'project_meta_info_box');


function market_meta_info_box(){
    $contact_info = aecom_get_related_contact_info();
    ob_start();
  ?>
  <div class="market-meta-info">
    <div class="market-data-container">
      <h2><?= __("CONTACT DETAILS", "aecom-indigo") ?></h2>
      <?php
      foreach ( array( 'local', 'global' ) as $info_set ) {
        if ( isset( $contact_info[ $info_set ] ) ) {
          echo $contact_info[ $info_set ];
        }
      }
      ?>
    </div>
  </div>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('market-meta-info', 'market_meta_info_box');

function service_meta_info_box(){
    $contact_info = aecom_get_related_contact_info();
    ob_start();
  ?>
  <div class="service-meta-info">
    <div class="service-data-container">
      <h2><?= __("CONTACT DETAILS", "aecom-indigo") ?></h2>
      <?php
      foreach ( array( 'local', 'global' ) as $info_set ) {
        if ( isset( $contact_info[ $info_set ] ) ) {
          echo $contact_info[ $info_set ];
        }
      }
      ?>
    </div>
  </div>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('service-meta-info', 'service_meta_info_box');
/**
 * Sorry, I don't know if there is an existing image size I could use for images on grid but there is no time to research in theme docs and code, so I just make easiest solution, create a new one. 
 */
add_image_size( 'spotless-grid-2x', 400, 250, true );
add_image_size( 'spotless-project-brand', 75, 75, true);

//add Brands
require get_stylesheet_directory() . '/inc/brands.php';

/**
 * Function to create filters in project pages.
 */
function create_project_filter($post, $post_type, $post_type_param, $labels){
  $selected_item = $selected_subitem = false;
  if( is_archive('project')) {
    if(!empty($_GET[$post_type_param])){
      $selected_item = get_post($_GET[$post_type_param][0]);
      //if item have a parent
      if(!! $selected_item->post_parent){
        $selected_subitem = $selected_item;
        $selected_item = get_post( $selected_subitem->post_parent );
      }
    }
  }  
  $item_query = array(
    'post_type'       => $post_type,
    'posts_per_page'  => -1,
    'orderby'         => 'menu_order',
    'post_parent'     => 0,
    'urs_fields'      => array( 'post_title' ),
    'meta_query'      => array(
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
  );

  $main_items = aecom_get_posts( $item_query );

  if ( $selected_item ) {
    $item_query['post_parent'] = $selected_item->ID;
    $subitems = aecom_get_posts( $item_query );
    // if the market we're currently viewing is a hidden submarket,
    // and it has no non-hidden siblings, then add the current market
    if ( empty( $subitems ) && aecom_get_post_meta( $post->ID, 'hide_in_nav' ) ) {
    // to the menu -- otherwise the menu will be empty.
      $subitems = array( $post );
    }
  }

  ?>
  <?php if($post_type != 'location'){ ?>
    <div class="filter select-<?= $post_type ?> has-dropdown">
      <h3><a href="#" class="ae-dropdown-toggle"><?php echo ( $selected_item ?
        sprintf(
          esc_html_x( '%s: %s', 'dropdown text', 'aecom' ),
          $labels['singular'],
          apply_filters( 'the_title', $selected_item->post_title )
        ) :
        sprintf(
          esc_html_x( 'Select a %s', 'dropdown text', 'aecom' ),
          $labels['singular']
        )
      ); ?></a></h3>
      <div class="ae-dropdown"><div class="ae-dropdown-content <?= $post_type ?>">
        <ul class="col">
          <?php foreach ( $main_items as $item ) { ?>
            <li><a href="<?php echo esc_url( get_post_type_archive_link( 'project' ) ) . '?' . $post_type_param . '[]=' . $item->ID; ?>">
              <?php echo apply_filters( 'the_title', $item->post_title ); ?>
            </a></li>
          <?php } ?>
        </ul><!-- .col -->
      </div></div>
    </div>
  <?php }  else  { ?>
      <div class="filter select-<?= $post_type ?> has-dropdown">
      <h3 class="current_location">
       <?php if(!is_page('projects') && !empty($_GET['ql'])){
              $current_title = get_the_title($_GET['ql'][0]);
            }
        ?>
        <a href="#" class="ae-dropdown-toggle <?= $current_title ?>">
          <?php     
              if(!empty($current_title)){ 
                echo (
                 'LOCATION: '.$current_title
                ); 
              }  else {                      
                echo (
                  sprintf(
                    esc_html_x( 'Select a %s', 'dropdown text', 'aecom' ),
                    $labels['singular']
                  )
                ); 
             }
          ?>
        </a>
        </h3>
      <div class="ae-dropdown"><div class="ae-dropdown-content <?= $post_type ?>">
        
          <?php foreach ( $main_items as $item ) { ?> 
            <ul class="col sub_locations">
              <li>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'project' ) ) . '?' . $post_type_param . '[]=' . $item->ID; ?>">
                  <?php echo apply_filters( 'the_title', $item->post_title ); ?>
                </a>
              </li>
                
                <?php
                if($item->post_title != 'New Zealand'){ 
                  $parent_item = $item->ID;
                  //if item have a parent                                 
                  $args = array(
                    'post_type'      => 'location',
                    'posts_per_page' => -1,
                    'post_parent'    => $parent_item,
                    'order'          => 'ASC',
                    'orderby'        => 'post_title'
                  );
                  $get_child = get_children($args);

                ?>                                                        
                <?php foreach ( $get_child as $sub_item ): ?>
                  <li>
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'project' ) ) . '?' . $post_type_param . '[]=' . $sub_item->ID; ?>"><?php echo apply_filters( 'the_title', $sub_item->post_title ); ?></a>
                    </li>
                <?php endforeach; } ?>                
              </ul>
          <?php } ?>
        </ul><!-- .col -->
      </div></div>
    </div>
  <?php } 
} 

//====================================================================================
// add to create for nav menu
function get_posts_children($parent_id){
    $children = array();
    // grab the posts children
    $posts = get_posts( array( 'numberposts' => -1, 'post_status' => 'publish', 'post_type' => 'page', 'post_parent' => $parent_id, 'suppress_filters' => false ));
    // now grab the grand children
    foreach( $posts as $child ){
        // recursion!! hurrah
        $gchildren = get_posts_children($child->ID);
        // merge the grand children into the children array
        if( !empty($gchildren) ) {
            $children = array_merge($children, $gchildren);
        }
    }
    // merge in the direct descendants we found earlier
    $children = array_merge($children,$posts);
    return $children;
}

// ==========================================================================================
// add meta box to post type page for nav menu

function dont_show_navmenu_metaboxes() {
  add_meta_box('page_dont_show_checked', 'Do not show this page in nav menu?', 'dont_show_menu_callback', 'page', 'side', 'high');
}

function dont_show_menu_callback( $post ) {
     
      $page_dont_show_checked = get_post_meta( $post->ID, 'page_dont_show_checked', true );
      
      if ($page_dont_show_checked=="hide"){
         
          $page_checked="checked";

      }else{

          $page_checked="";
      }

      $check_string="Hide Page In NavMenu";
      $outline = '<input type="checkbox" name="page_dont_show_checked" id="page_dont_show_checked" class="page_dont_show_checked" value="hide" '. $page_checked . ' /> Hide Page In NavMenu';
      
      echo $outline;
}

  add_action( 'add_meta_boxes', 'dont_show_navmenu_metaboxes' );

/**
 * Save meta box content.
 *

 * @param int $post_id Post ID
 */
function page_save_show_checked( $post_id ) {
    // Save logic goes here. Don't forget to include nonce checks!
    if ( 'page' == $_POST['post_type'] ) {
        // Sanitize the user input.
        $page_dont_show_checked = sanitize_text_field( $_POST['page_dont_show_checked'] );
 
        // Update the meta field.
        update_post_meta( $post_id, 'page_dont_show_checked', $page_dont_show_checked );   
  }
}
add_action( 'save_post', 'page_save_show_checked' );

// =========================================================================================
// setting the background header of achive pages

if ( ! function_exists( 'get_quadro_archive_title' ) ) :
/**
 * Shim for `quadro_archive_title()`.
 *
 * Display the archive title based on the queried object.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the title. Default empty.
 * @param string $after  Optional. Content to append to the title. Default empty.
 */
function get_quadro_archive_title() {
  if ( is_category() ) {
    $title = single_cat_title( '', false );
  } elseif ( is_tag() ) {
    $title = single_tag_title( '', false );
  } elseif ( is_author() ) {
    $title = sprintf( esc_html__( 'Author: %s', 'quadro' ), '<span class="vcard">' . get_the_author() . '</span>' );
  } elseif ( is_year() ) {
    $title = sprintf( esc_html__( 'Year: %s', 'quadro' ), get_the_date( esc_html_x( 'Y', 'yearly archives date format', 'quadro' ) ) );
  } elseif ( is_month() ) {
    $title = sprintf( esc_html__( 'Month: %s', 'quadro' ), get_the_date( esc_html_x( 'F Y', 'monthly archives date format', 'quadro' ) ) );
  } elseif ( is_day() ) {
    $title = sprintf( esc_html__( 'Day: %s', 'quadro' ), get_the_date( esc_html_x( 'F j, Y', 'daily archives date format', 'quadro' ) ) );
  } elseif ( is_tax( 'post_format' ) ) {
    if ( is_tax( 'post_format', 'post-format-aside' ) ) {
      $title = esc_html_x( 'Asides', 'post format archive title', 'quadro' );
    } elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
      $title = esc_html_x( 'Galleries', 'post format archive title', 'quadro' );
    } elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
      $title = esc_html_x( 'Images', 'post format archive title', 'quadro' );
    } elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
      $title = esc_html_x( 'Videos', 'post format archive title', 'quadro' );
    } elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
      $title = esc_html_x( 'Quotes', 'post format archive title', 'quadro' );
    } elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
      $title = esc_html_x( 'Links', 'post format archive title', 'quadro' );
    } elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
      $title = esc_html_x( 'Statuses', 'post format archive title', 'quadro' );
    } elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
      $title = esc_html_x( 'Audio', 'post format archive title', 'quadro' );
    } elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
      $title = esc_html_x( 'Chats', 'post format archive title', 'quadro' );
    }
  } elseif ( is_post_type_archive() ) {
    $title = post_type_archive_title( '', false );
  } elseif ( is_tax() ) {
    $tax = get_taxonomy( get_queried_object()->taxonomy );
    /* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
    $title = sprintf( esc_html__( '%1$s: %2$s', 'quadro' ), $tax->labels->singular_name, single_term_title( '', false ) );
  } else {
    $title = esc_html__( 'Archives', 'quadro' );
  }

  /**
   * Filter the archive title.
   */
  // $title = apply_filters( 'get_the_archive_title', $title );

  if ( ! empty( $title ) ) {
    return $title;
  }
}
endif;

/**
 * Addition o ajax request handler to manage search.
 */
function ajax_search(){
  //get page and term from GET param
  $page = isset($_GET['page']) ? $_GET['page'] : 1;
  $s = isset($_GET['s']) ? $_GET['s'] : '';
  
  //create query for search
  //$posts_per_page = get_option('posts_per_page');
  $posts_per_page = 12;
  //$posts_per_page = 2;
  $items = get_posts([
    's' => $s,
    'post_type' => 'any',
    'posts_per_page' => $posts_per_page,
    'offset' => ($page - 1) * $posts_per_page,
    'orderby' => 'relevance'
  ]);
  
  //check items
  if(empty($items))
    wp_send_json(false);

  //add additional info in items
  $items = array_map(function($item) {
    $post_class = get_post_class($item->ID);
    array_push($post_class, 'blog-item');
    array_push($post_class, 'size-item');
    $item->post_class = implode(' ', $post_class);
    $item->thumbnail = get_formatted_post_thumbnail($item);
    $item->summary = get_formatted_post_summary($item);
    return $item;
  }, $items);
  //send publications
  wp_send_json($items);
}
add_action('wp_ajax_ajax_search', 'ajax_search');
add_action('wp_ajax_nopriv_ajax_search', 'ajax_search');

function get_formatted_post_thumbnail($item) {
  $post_format = get_post_format($item->ID);
  switch ( $post_format ) {
			 case 'video':

				// if post thumbnail, bring it
				if ( has_post_thumbnail($item->ID) && ! post_password_required($item->ID) ) { 
					return '<a href="' . get_the_permalink($item->ID) . '" rel="bookmark">' . get_the_post_thumbnail($item->ID, 'quadro-med-thumb') . '</a>';
        } else {
					// there's no thumbnail, try to bring a video screenshot
					return quadro_video_screenshot( get_the_content($item->ID), esc_url( get_the_permalink($item->ID) ), get_the_title($item->ID) );
				}
				break;
			
			case 'image':
				if ( has_post_thumbnail($item->ID) && ! post_password_required($item->ID) ) {
          return '<a href="' . get_the_permalink($item->ID) . '" rel="bookmark">' . get_the_post_thumbnail($item->ID, 'full') . '</a>';
        }
				break;

			case 'gallery':
				if ( get_post_gallery($item->ID) ) {
					// Retrieve first gallery
					$gallery = get_post_gallery( $item->ID, false );
					if ( isset($gallery['ids']) ) {
						// Remove Galleries from content
						$content = quadro_strip_shortcode_gallery($item->post_content);
            
						$gal = '<div class="entry-gallery"><ul class="slides">';
						/* Loop through all images and output them one by one */
						$gallery_ids = explode(',', $gallery['ids']);
						foreach( $gallery_ids as $pic_id ) {
							$gal .= '<li class="gallery-item">';
							$gal .= wp_get_attachment_image( $pic_id, 'quadro-med-thumb' );
							$gal .= ( get_post($pic_id) && get_post($pic_id)->post_excerpt != '' ) ? '<p class="gallery-caption">' . get_post($pic_id)->post_excerpt . '</p>' : '';
							$gal .= '</li>';
						}
						$gal .= '</ul></div>';
            return $gal;
					} else {
						// Exit if gallery has no ids (old versions),
						// and leave content intact.
						$content = $item->post_content;
					}
				} else {
					// Bring Content if no gallery anyway
					$content = $item->post_content;
				}
				// Filter through the_content filter
				$content = apply_filters( 'the_content', $content );
				$content = str_replace( ']]>', ']]&gt;', $content );
        return $content;
				break;

			default:
				if ( has_post_thumbnail($item->ID) && ! post_password_required($item->ID) && $post_format != 'aside' && $post_format != 'status' )
				  return '<a href="' . get_the_permalink($item->ID) . '" rel="bookmark">' . get_the_post_thumbnail($item->ID, 'spotless-grid-2x', array('alt' => $item->post_title, 'title' => $item->post_title, 'class' => 'attachment-quadro-med-thumb wp-post-image lazy') ) . '</a>';
				break;
  }
}

function get_formatted_post_summary($post) {
  $post_format = get_post_format($post->ID);
  if ( $post_format == '' || $post_format == 'gallery' ) { 
			// display the length of the summary content
			//return get_quadro_excerpt($post, get_the_excerpt($post->ID), 100, ''); 
      $content_post = get_post($post->ID);
      $summary_content=strip_tags($content_post->post_content);
      $content_length=strlen($summary_content);
      if($content_length>100){
        $subcontent=substr($summary_content,0,100);
        return $subcontent."...";
      }else{
        return $summary_content;
      }
  } else {
		if ( $post_format == 'quote' ) {
			return '<a href="' . esc_url( get_the_permalink($post->ID) ) . '">' . quadro_just_quote($post->post_content, '', '') . '</a>';
		} elseif ( $post_format == 'link' && is_array($the_link = quadro_getUrls($post->post_content)) && isset($the_link[0]) ) {
			// $the_link = quadro_getUrls(get_the_content())[0];
			$the_link = $the_link[0];
			$the_link_parsed = parse_url($the_link);
			return '<p class="the-link-url"><a href="' . esc_url( $the_link ) . '" title="' . $the_link . '">' . $the_link_parsed['host'] . '</a></p>';
		} elseif ( $post_format == 'audio' || $post_format == 'video' ) {
			return get_quadro_excerpt($post, get_the_excerpt($post->ID), 100, '');
		} elseif ( $post_format == 'image' ) {
			// nothing here
		} elseif ( $post_format == 'aside' || $post_format == 'status' ) {
			// Bring the full content for the other formats (aside & status between others)
      return $post->post_content;
		} else { 
			return get_quadro_excerpt($post, get_the_excerpt($post->ID), 100, '');
		}
	} 
}


