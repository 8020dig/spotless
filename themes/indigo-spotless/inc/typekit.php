<?php
/**
 * Typekit-related functions
 */

// ============= public-facing =============

/**
 * load typekit fonts
 */
function aecom_load_typekit_fonts() {
?>
<script src="<?php
  echo esc_url( 'https://use.typekit.net/' . aecom_get_typekit_id() . '.js' );
?>"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>
<?php
}
add_action( 'wp_head', 'aecom_load_typekit_fonts' );


// ============= admins/editors only =============

/**
 * load outside MCE first,
 * because sometimes TypeKit doesn't want you loading in a sourceless iframe
 */
add_action( 'admin_head', 'aecom_load_typekit_fonts' );

/**
 * load typekit fonts in tinymce
 * props Tom J Nowell ~ https://gist.github.com/Tarendai/3690149#file-typekit-editor-php
 */
function aecom_mce_typekit( $plugin_array ) {
  $plugin_array['typekit'] = get_template_directory_uri() . '/js/typekit.tinymce.js';
  return $plugin_array;
}
add_filter( 'mce_external_plugins', 'aecom_mce_typekit' );

/**
 * add the typekit ID as a global JS variable in admin
 */
function aecom_enqueue_typekit_id() {
  // global $wp_scripts; print_r( $wp_scripts ); exit;
  wp_localize_script( 'editor', 'aecom_typekit_id', aecom_get_typekit_id() );
}
add_action( 'admin_enqueue_scripts', 'aecom_enqueue_typekit_id' );


// ============= general =============

/**
 * get typekit ID
 * allows override for dev environments
 */
function aecom_get_typekit_id() {
  return defined( 'LOCAL_TYPEKIT_ID' ) ? LOCAL_TYPEKIT_ID : 'rxs8mqx';
}
