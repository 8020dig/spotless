<?php
/**
 * Functions needed for external AJAX-loading of partial HTML
 */

if ( isset( $_GET['dyn_part'] ) ) {

  // discourage anti-XHR measures from ruining our day
  header( 'Access-Control-Allow-Origin: *' );

  // proclaim the ajaxy disposition of the current pageload
  define( 'AECOM_AJAX_REQUEST', $_GET['format'] === 'json' ? 'json' : 'script' );

  global $aecom_requested_ajax_sections;
  $aecom_requested_ajax_sections = explode( ',', $_GET['dyn_part'] );
  // clean up the requested section names
  array_map( 'sanitize_html_class', $aecom_requested_ajax_sections );

  // disable query monitor plugin output, if enabled
  add_filter( 'qm/process', '__return_false' );

  // prepare to collect + output JSON content if requested
  if ( AECOM_AJAX_REQUEST === 'json' ) {
    global $aecom_rendered_ajax_sections;
    $aecom_rendered_ajax_sections = array();
    add_action( 'shutdown', 'aecom_output_json_sections' );
  }

} else {
  define( 'AECOM_AJAX_REQUEST', false );
}

define( 'AECOM_GENERATING_TEMPLATE', isset( $_GET['get_ext_template'] ) );


function aecom_ajax_start () {
  if ( AECOM_AJAX_REQUEST ) {
    if ( AECOM_AJAX_REQUEST === 'json' ) {
      header( 'Content-Type: application/json;' );
    } else {
      header( 'Content-Type: text/javascript;' );
    }
    ob_start();
  }
}

function aecom_ajax_section_start ( $section, $args = array() ) {

  if ( ! AECOM_AJAX_REQUEST )
    return;

  // honor exceptions
  if ( ! empty( $args['except'] ) ) {
    global $post;
    if ( in_array( $post->post_name, $args['except'] ) )
      return;
  }

  global $aecom_requested_ajax_sections;

  if ( in_array( $section, $aecom_requested_ajax_sections ) ) {
    ob_clean();
  } elseif ( AECOM_GENERATING_TEMPLATE ) {
    // replace following output with div.dynamic-section
    echo '<div class="dynamic-section" id="' . str_replace( '_', '-', $section ) . '"></div>';
    ob_start();
  }
}

function aecom_ajax_section_end ( $section, $args = array() ) {

  if ( ! AECOM_AJAX_REQUEST || AECOM_GENERATING_TEMPLATE )
    return;

  // honor exceptions
  if ( ! empty( $args['except'] ) ) {
    global $post;
    if ( $post && in_array( $post->post_name, $args['except'] ) )
      return;
  }

  global $aecom_requested_ajax_sections;

  if ( in_array( $section, $aecom_requested_ajax_sections ) ) {

    $section_prop_name = str_replace( '-', '_', $section );
    $section_html = ob_get_clean();

    if( AECOM_AJAX_REQUEST === 'script' ) {

      add_filter( 'js_escape', 'aecom_unescape_brackets', 999, 2 );
      ?>
      aecomContent.<?php echo $section_prop_name; ?> = '<?php echo esc_js( $section_html ); ?>';
      <?php
      remove_filter( 'js_escape', 'aecom_unescape_brackets', 999, 2 );

    } else {

      global $aecom_rendered_ajax_sections;
      $aecom_rendered_ajax_sections[ $section_prop_name ] = $section_html;

    }
    ob_start();

  } elseif ( AECOM_GENERATING_TEMPLATE ) {
    // done replacing section; allow output through again
    ob_end_clean();
  }
}

function aecom_ajax_end () {
  if ( AECOM_AJAX_REQUEST )
    ob_end_clean();
}

function aecom_unescape_brackets ( $safe_text, $text = '' ) {
  return str_replace( array( '&lt;', '&gt;', '&quot;' ), array( '<', '>', '"' ), $safe_text );
}

/**
 * output requested section HTML as JSON
 */
function aecom_output_json_sections() {
  global $aecom_rendered_ajax_sections;
  echo json_encode( $aecom_rendered_ajax_sections );
  exit;
}

/**
 * use special 3rd-party template files
 */
add_filter( 'template_include', 'aecom_third_party_template_include', 99 );
function aecom_third_party_template_include( $template ) {
  if ( get_post_type() == 'external_page' ) {
    $post = get_post();
    return get_template_directory() . '/external-pages/' . $post->post_name . '.php';
  }
  return $template;
}

/**
 * enqueue remote loader script if we're generating a template
 */
function aecom_ext_template_scripts() {

  // only relevant if we're generating a template for an external page
  if ( ! ( is_singular( 'external_page' ) && AECOM_GENERATING_TEMPLATE ) )
    return;

  // enqueue template-specific styles
  global $post;
  if ( $post->post_name === 'template-adp' ) {
    wp_enqueue_style( 'aecom-adp', get_stylesheet_directory_uri() . '/external-pages/css/style-adp.css', array() );
  }

  wp_enqueue_script( 'aecom-remote-loader',
    get_template_directory_uri() . '/js/remoteLoader.js',
    array( 'jquery' ),
    false, // version
    true // footer
  );

  $template_base_url = site_url( 'blog/external_page/' );
  $schemaless_url = substr( $template_base_url, strpos( $template_base_url, '//' ) );
  wp_localize_script( 'aecom-remote-loader', 'aecom_template_base_url', $schemaless_url );
}
add_action( 'wp_enqueue_scripts', 'aecom_ext_template_scripts' );

/**
 * add body classes to external page templates
 */
function aecom_ext_template_body_classes( $classes ) {
  if ( is_singular( 'external_page' ) ) {
    global $post;
    $classes[] = $post->post_name;
  }
  return $classes;
}
add_filter( 'body_class', 'aecom_ext_template_body_classes' );
