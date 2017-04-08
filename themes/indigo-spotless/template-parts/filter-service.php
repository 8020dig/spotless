<?php
/**
 * Filter controls for Services.
 *
 * Sorry by duplicating code but there is no time to modularize, then I just copy the same code used for markets.
 * TO-DO: Create a function to create filters.
 */

?>

<div class="filter-bar">

  <div class="filters">

    <?php
    $selected_service = $selected_subservice = false;
    if ( is_singular( 'service' ) ) {
      if ( !! $post->post_parent ) {
        $selected_subservice = $post;
        $selected_service = get_post( $post->post_parent );
      } else {
        $selected_service = $post;
      }
    }

    $service_query = array(
      'post_type'       => 'service',
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

    $main_services = aecom_get_posts( $service_query );

    if ( $selected_service ) {
      $service_query['post_parent'] = $selected_service->ID;
      $subservices = aecom_get_posts( $service_query );
      // if the service we're currently viewing is a hidden subservice,
      // and it has no non-hidden siblings, then add the current service
      // to the menu -- otherwise the menu will be empty.
      if ( empty( $subservices ) && aecom_get_post_meta( $post->ID, 'hide_in_nav' ) ) {
        $subservices = array( $post );
      }
    }

    ?>

    <div class="filter select-service has-dropdown">
      <h3><a href="#" class="ae-dropdown-toggle"><?php echo ( $selected_service ?
        sprintf(
          esc_html_x( 'Service: %s', 'dropdown text', 'aecom' ),
          apply_filters( 'the_title', $selected_service->post_title )
        ) :
        esc_html__( 'Select a Service', 'aecom' )
      ); ?></a></h3>
      <div class="ae-dropdown"><div class="ae-dropdown-content services">
        <ul class="col">
          <?php foreach ( $main_services as $service ) { ?>
            <li><a href="<?php echo esc_url( get_permalink( $service->ID ) ); ?>">
              <?php echo apply_filters( 'the_title', $service->post_title ); ?>
            </a></li>
          <?php } ?>
        </ul><!-- .col -->
      </div></div>
    </div>

    <?php if ( $subservices ) : ?>

    <div class="filter select-subservice has-dropdown">
      <h3><a href="#" class="ae-dropdown-toggle"><?php echo ( ! empty( $selected_subservice ) ?
        sprintf(
          esc_html_x( 'Subservice: %s', 'dropdown text', 'aecom' ),
          apply_filters( 'the_title', $selected_subservice->post_title )
        ) :
        esc_html__( 'Select a Subservice', 'aecom' )
      ); ?></a></h3>
      <div class="ae-dropdown"><div class="ae-dropdown-content subservices">
        <h3 class="ae-dropdown-title"><?php printf( esc_html__( 'Subservices of %s', 'aecom' ), apply_filters( 'the_title', $selected_service->post_title ) ) ;?></h3>
        <ul class="col">
          <?php foreach ( $subservices as $service ) { ?>
            <li><a href="<?php echo esc_url( get_permalink( $service->ID ) ); ?>"><?php echo apply_filters( 'the_title', $service->post_title ); ?></a></li><?php
          } ?>
        </ul><!-- .col -->
      </div></div>
    </div>

    <?php endif; ?>

  </div><!-- .filters -->

  <div class="search">
    <?php aecom_search_form( 'service' ); ?>
  </div><!-- .search -->

</div>
