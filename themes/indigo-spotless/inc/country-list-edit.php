<?php
/**
 * Country List settings page
 */

function aecom_country_list_edit() {
  // check permissions
  if ( ! current_user_can( 'administrator' ) && !is_super_admin() )  {
    wp_die( __( 'You do not have sufficient permissions to access this page.', 'aecom' ) );
  }

  // load current settings
  $countries = get_site_option( 'aecom_theme_countries', array() );
  $country_names = get_site_option( 'aecom_theme_country_names', array() );

  $sort_alpha = ( isset( $countries['_sort_alpha'] ) && !! $countries['_sort_alpha'] );
  unset( $countries['_sort_alpha'] );

  // load sites
  $sites = aecom_get_blogs();
  usort( $sites, 'aecom_blog_list_compare' );

  // load flags
  $flags = array();
  $flag_path = '/images/flags/';

  if ( $handle = opendir( get_template_directory() . $flag_path ) ) {
    while ( false !== ( $entry = readdir( $handle ) ) ) {
      if ( preg_match( '/\.png$/isU', $entry ) ) {
        $flags[] = $entry;
        if ( !isset( $countries[$entry] ) ) {
          $countries[$entry] = 0;
          $country_names[$entry] = '';
        }
      }
    }
    closedir($handle);
  }

  // process save
  $errors = array();
  if ( !empty($_POST) && wp_verify_nonce($_POST['aecom_theme_content_nonce'], 'aecom_theme_content_nonce') ) {

    // get submited data
    $countries = is_array( $_POST['countries'] ) ? $_POST['countries'] : array();
    $country_names = is_array( $_POST['country_names'] ) ? $_POST['country_names'] : array();

    $sort_alpha = ( isset( $countries['_sort_alpha'] ) && !! $countries['_sort_alpha'] );

    // strip slashes if any
    if ( !get_magic_quotes_gpc() ) {
      $countries = stripslashes_deep( $countries );
      $country_names = stripslashes_deep( $country_names );
    }

    // save settings
    if ( count($errors) <= 0 ) {
      update_site_option( 'aecom_theme_countries', $countries );
      update_site_option( 'aecom_theme_country_names', $country_names );
      $success = 'Settings were successfully saved!';
    }

    // unset alpha sort option so it doesn't show up as another country!
    unset( $countries['_sort_alpha'] );
  }
  ?>

  <h2><?php echo __( 'Country List', 'aecom' ); ?></h2>

  <?php if ( count($errors) > 0 ) : ?>
  <div class="message error"><?php echo wpautop(implode("\n", $errors)); ?></div>
  <?php endif; ?>
  <?php if ( isset($success) && !empty($success) ) : ?>
  <div class="message updated"><?php echo wpautop($success); ?></div>
  <?php endif; ?>

  <p><?php esc_html_e( 'Choose the sites to list in the Countries dropdown in the global nav. Drag & drop to reorder.', 'aecom' ); ?></p>

  <form method="post" action="" enctype="multipart/form-data">
  <div class="aecom-sortable">
  <?php reset( $countries );
  foreach ( $countries as $flag => $country ) { ?>
  <div class="ui-state-default">
    <span class="ui-icon ui-icon-arrowthick-2-n-s left"></span>
    <img src="<?php echo get_template_directory_uri() . $flag_path . $flag; ?>" style="vertical-align: middle;" />
    <input type="text" value="<?php echo esc_attr( $country_names[$flag] ); ?>" name="country_names[<?php echo esc_attr( $flag ); ?>]" placeholder="<?php _e( 'Country name' ); ?>" />
    <select name="countries[<?php echo esc_attr( $flag ); ?>]">
    <option value="">---</option>
    <?php
    reset( $sites );
    foreach ( $sites as $site ) { ?>
      <option value="<?php echo esc_attr( $site->blog_id ); ;?>"<?php
        if ( $countries[$flag] == $site->blog_id )
          echo ' selected="selected"';
      ?>><?php echo $site->blogname; ?> (<?php echo $site->siteurl; ?>)</option>
    <?php } ?>
    </select>
  </div>
  <?php } ?>
  </div>

  <p>
    <label><input type="checkbox" name="countries[_sort_alpha]" value="1" <?php checked( $sort_alpha ); ?> /> <?php esc_html_e( 'List countries alphabetically (ignore custom sorting)', 'aecom' ); ?></label>
  </p>

  <p>
    <input type="submit" class="button-primary" value="Save Settings &raquo;" />
    <?php wp_nonce_field('aecom_theme_content_nonce', 'aecom_theme_content_nonce'); ?>
  </p>

  </form>
  <?php
}

/**
 * Sort blogs
 */
function aecom_blog_list_compare( $a, $b ) {
  if ( is_object( $a ) )
    return strcmp( strtolower( $a->blogname ), strtolower( $b->blogname ) );

  return strcmp( strtolower( $a['blogname'] ), strtolower( $b['blogname'] ) );
}
