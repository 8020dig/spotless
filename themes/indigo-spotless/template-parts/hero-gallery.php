<?php
/**
 * Hero image content for the current page.
 */

aecom_ajax_section_start( 'hero' );

if ( $hero_panels = aecom_get_panels( 'before_content' ) ) {
  // random slider background styles
  $hero_line_styles = array( 'a', 'b', 'c' );
  shuffle( $hero_line_styles );
  $hero_background_colors = array( 'teal', 'green', 'orange' );
  shuffle( $hero_background_colors );
  ?>
  <div class="hero-panels lines-<?php echo esc_attr( $hero_line_styles[0] ); ?> background-<?php echo esc_attr( $hero_background_colors[0] ); ?>"><?php echo $hero_panels; ?></div>
<?php }

aecom_ajax_section_end( 'hero' );
