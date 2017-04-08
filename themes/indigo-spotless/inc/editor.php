<?php
/**
 * Editor buttons & tweaks
 *
 * mostly ripped from urs.com - thanks Martynas!
 */

/**
 * Add custom styles to TinyMCE editor
 */

add_filter( 'tiny_mce_before_init', 'aecom_tiny_mce_before_init' );
function aecom_tiny_mce_before_init( $init_array ) {

  $style_formats = array(
    array(
      'title'   => 'Emphasized intro',
      'selector'  => 'p,h1,h2,h3,h4,h5,h6,td,th,div',
      'block' => 'p',
      'classes' => 'editor-emphasized',
      'wrapper' => false,
    ),
    array(
      'title' => 'Heading level 2',
      'block' => 'h2',
      'wrapper' => false,
    ),
    array(
      'title' => 'Heading level 3',
      'block' => 'h3',
      'wrapper' => false,
    ),
    array(
      'title' => 'Heading level 4',
      'block' => 'h4',
      'wrapper' => false,
    ),
    array(
      'title' => 'Fast Facts section',
      'block' => 'div',
      'classes' => 'fast-facts',
      'wrapper' => true,
    ),
    array(
      'title' => 'Panel contents',
      'items' => array(
        array(
          'title' => 'Panel intro text',
          'selector' => 'h1,h2,h3,h4,h5,h6,p',
          'classes' => 'heading-smallcaps',
          'wrapper' => false,
        ),
        array(
          'title' => 'Panel header',
          'selector' => 'h1,h2,h3,h4,h5,h6,p',
          'classes' => 'heading-light',
          'wrapper' => false,
        ),
        array(
          'title' => 'Panel CTA link',
          'selector' => 'a',
          'classes' => 'ae-panel-button',
          'wrapper' => false,
        ),
        array(
          'title' => 'Panel footnote',
          'block' => 'div',
          'classes' => 'ae-panel-footnote',
          'wrapper' => true,
        ),
        array(
          'title' => 'Light text',
          'block' => 'div',
          'classes' => 'light-text',
          'wrapper' => true,
        ),
        array(
          'title' => 'Dark text',
          'block' => 'div',
          'classes' => 'dark-text',
          'wrapper' => true,
        ),
        array(
          'title' => 'Text with shadow',
          'block' => 'div',
          'classes' => 'shadow-text',
          'wrapper' => true,
        ),
        array(
          'title' => 'Text without shadow',
          'block' => 'div',
          'classes' => 'no-shadow',
          'wrapper' => true,
        ),
      ),
    ),
    /* array( */
    /*   'title' => 'Heading', */
    /*   'block */
    /* array( */
    /*   'selector'  => 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li', */
    /*   'title'   => 'Paragraph title', */
    /*   //'block'   => 'p', */
    /*   'classes' => 'editor-parapgraph-title', */
    /*   'wrapper' => true */
    /* ), */
    /* array( */
    /*   //'selector'  => 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li', */
    /*   'title'   => 'Bigger text', */
    /*   'block'   => 'span', */
    /*   'classes' => 'editor-bigger-text', */
    /*   'wrapper' => true */
    /* ), */
    /* array( */
    /*   'selector'  => 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li', */
    /*   'title'   => 'Boxed content title', */
    /*   'block'   => 'div', */
    /*   'classes' => 'editor-boxed-title', */
    /*   'wrapper' => true */
    /* ), */
    /* array( */
    /*   //'selector'  => 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li', */
    /*   'title'   => 'Boxed content', */
    /*   'block'   => 'div', */
    /*   'classes' => 'editor-boxed', */
    /*   'wrapper' => true */
    /* ), */
    array(
      'title' => 'Tables',
      'items' => array(
        array(
          'selector'  => 'table',
          'title'   => 'Table (autoformats rows)',
          'block'   => 'table',
          'classes' => 'editor-table',
          'wrapper' => true
        ),
        array(
          'selector'  => 'tr',
          'title'   => 'Header Row',
          'block'   => 'tr',
          'classes' => 'editor-table-header',
          'wrapper' => true
        ),
        array(
          'selector'  => 'tr',
          'title'   => 'Sub-Header Row',
          'block'   => 'tr',
          'classes' => 'editor-table-subheader',
          'wrapper' => true
        ),
        array(
          'selector'  => 'tr',
          'title'   => 'Row',
          'block'   => 'tr',
          'classes' => 'editor-table-row',
          'wrapper' => true
        ),
        array(
          'selector'  => 'tr',
          'title'   => 'Alternative Row',
          'block'   => 'tr',
          'classes' => 'editor-table-row-alt',
          'wrapper' => true
        ),
        array(
          'selector'  => 'table',
          'title'   => 'Table for Testimonials',
          'block'   => 'table',
          'classes' => 'editor-table-testimonials',
          'wrapper' => true
        ),
        array(
          'selector'  => 'table',
          'title'   => 'Mobile Table (auto-layout columns)',
          'block'   => 'table',
          'classes' => 'editor-mobile-table',
          'wrapper' => true
        )
      )
    )
  );
  $init_array['style_formats'] = json_encode( $style_formats );
  $init_array['theme_advanced_buttons2_add_before'] = 'styleselect';
  $init_array['wordpress_adv_hidden'] = false;
  $init_array['table_styles'] = 'Formatted Table=editor-table;Mobile Table=editor-mobile-table';
  $init_array['table_cell_styles'] = 'Centered Cell=editor-table-cell-centered;';
  $init_array['table_row_styles'] = 'Table Row=editor-table-row;Alternative Table Row=editor-table-row-alt';
  return $init_array;
}

/**
 * Modify MCE button list
 */

add_filter( 'mce_buttons', 'aecom_mce_buttons' );
function aecom_mce_buttons( $buttons ) {
  if ( aecom_is_uberuser() ) {
    $remove = array(
      'strikethrough',
      'wp_adv'
    );
  }
  else {
    $remove = array(
      'formatselect',
      'wp_adv',
      'blockquote',
      'wp_more'
    );
  }

  foreach( $remove as $button ) {
    if ( ( $key = array_search( $button, $buttons ) ) !== false ) {
      unset( $buttons[$key] );
    }
  }
  return $buttons;
}

add_filter( 'mce_buttons_2', 'aecom_mce_buttons_2' );
function aecom_mce_buttons_2( $buttons ) {
  if ( aecom_is_uberuser() ) {
    $remove = array(
      'formatselect'
    );
  }
  else {
    $remove = array(
      'formatselect',
      'justifyfull',
      'forecolor',
      'pasteword',
      'underline'
    );
  }

  foreach( $remove as $button ) {
    if ( ( $key = array_search( $button, $buttons ) ) !== false ) {
      unset( $buttons[$key] );
    }
  }

  $buttons[] = 'superscript';
  $buttons[] = 'subscript';

  return $buttons;
}

add_filter( 'mce_buttons_3', 'aecom_mce_buttons_3' );
function aecom_mce_buttons_3( $buttons ) {
  $buttons[] = 'styleselect';
  $buttons[] = 'table';
  return $buttons;
}

add_action( 'admin_head', 'aecom_remove_media_buttons' );
function aecom_remove_media_buttons () {
  if ( !aecom_is_uberuser() ) {
    remove_action( 'media_buttons', 'media_buttons' );
  }
}

/**
 * Returns true if user has at least super_editor role
 */

function aecom_is_uberuser () {
  return is_super_admin() || current_user_can( 'super_editor' ) || current_user_can( 'administrator' );
}
