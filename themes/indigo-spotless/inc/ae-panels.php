<?php
/**
 * AE-Panels tie-ins
 */

/**
 * Modify images in main slider of projects to cover full width of container if image is almost as long as its container.
 */
add_filter('ae_panel_cover_surface', function($html, $surfaceObj, $aePanelObj){
  //apply change only to projects
  if(!is_singular('project'))
    return $html;

  //Indicates the max width for cover images(i.e: images in main slider of projects). If an images is greather, then it should cover all its container instead leaving an small space at right side.
  $AE_MAX_COVER_IMAGE_WIDTH = 1062;

  //extract width from image tag
  $width = null;
  preg_match("/width=\"([^\"]*)\"/", $html, $matches);
  if(!empty($matches[1]))
    $width = $matches[1];

  //if the image has a width attribute
  if(!is_null($width)){
    //check width against limit
    if($AE_MAX_COVER_IMAGE_WIDTH < $width){
      //add style elements to the image
      $html = preg_replace("/<img /", '<img style="width: 100%; height: auto;" ', $html);
      //delete sizes attribute because the entire image will be used in all screen sizes
      $html = preg_replace("/sizes=\"([^\"]*)\"/", '', $html);
    }
  }
  return $html;
}, 10, 3);

/**
 * safe fallback for ae_get_panels() in case plugin is disabled
 */
function aecom_get_panels() {
  if ( function_exists( 'ae_get_panels' ) ) {
    return call_user_func_array( 'ae_get_panels', func_get_args() );
  }
  return '';
}

/**
 * set project hero sliders to 'fit' images instead of cropping them
 */
function aecom_project_panel_layout( $panel_data, $post_type ) {

  if ( $post_type === 'project' ) {
    return array(
      'before_content' => array( array(
        'type' => 'cover',
        'query' => 'easy_image_gallery',
        'aspect_ratio' => '0.45',
        'constrain_method' => 'fit',
      ) ),
    );
  }
  return $panel_data;
}
add_filter( 'ae_panels_default_layout', 'aecom_project_panel_layout', 11, 2 );

/**
 * make one-page sites use image gallery images if present
 */
function aecom_one_page_panel_layout( $panel_data, $post_ID ) {

  if ( ! aecom_is_one_page() ) return $panel_data;

  $post = get_post( $post_ID );
  if ( $post->post_name !== 'home' ) return $panel_data;

  // leave sites with no gallery as is (use global hero panel)
  if ( ! aecom_get_post_meta( $post_ID, 'easy_image_gallery_local' ) ) return $panel_data;

  return array(
    'before_content' => array( array(
      'type' => 'cover',
      'query' => 'easy_image_gallery_local',
      'aspect_ratio' => '0.45',
      'constrain_method' => 'fit',
    ) ),
  );
}
add_filter( 'ae_panels_get_data', 'aecom_one_page_panel_layout', 11, 2 );
