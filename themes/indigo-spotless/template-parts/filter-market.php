<?php
/**
 * Filter controls for Markets
 */

?>

<div class="filter-bar">

  <div class="filters">

    <?php
    $selected_market = $selected_submarket = false;
    if ( is_singular( 'market' ) ) {
      if ( !! $post->post_parent ) {
        $selected_submarket = $post;
        $selected_market = get_post( $post->post_parent );
      } else {
        $selected_market = $post;
      }
    }

    $market_query = array(
      'post_type'       => 'market',
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

    $main_markets = aecom_get_posts( $market_query );

    if ( $selected_market ) {
      $market_query['post_parent'] = $selected_market->ID;
      $submarkets = aecom_get_posts( $market_query );
      // if the market we're currently viewing is a hidden submarket,
      // and it has no non-hidden siblings, then add the current market
      // to the menu -- otherwise the menu will be empty.
      if ( empty( $submarkets ) && aecom_get_post_meta( $post->ID, 'hide_in_nav' ) ) {
        $submarkets = array( $post );
      }
    }

    ?>

    <div class="filter select-market has-dropdown">
      <h3><a href="#" class="ae-dropdown-toggle"><?php echo ( $selected_market ?
        sprintf(
          esc_html_x( 'Market: %s', 'dropdown text', 'aecom' ),
          apply_filters( 'the_title', $selected_market->post_title )
        ) :
        esc_html__( 'Select a Market', 'aecom' )
      ); ?></a></h3>
      <div class="ae-dropdown"><div class="ae-dropdown-content markets">
        <ul class="col">
          <?php foreach ( $main_markets as $market ) { ?>
            <li><a href="<?php echo esc_url( get_permalink( $market->ID ) ); ?>">
              <?php echo apply_filters( 'the_title', $market->post_title ); ?>
            </a></li>
          <?php } ?>
        </ul><!-- .col -->
      </div></div>
    </div>

    <?php if ( $submarkets ) : ?>

    <div class="filter select-submarket has-dropdown">
      <h3><a href="#" class="ae-dropdown-toggle"><?php echo ( ! empty( $selected_submarket ) ?
        sprintf(
          esc_html_x( 'Submarket: %s', 'dropdown text', 'aecom' ),
          apply_filters( 'the_title', $selected_submarket->post_title )
        ) :
        esc_html__( 'Select a Submarket', 'aecom' )
      ); ?></a></h3>
      <div class="ae-dropdown"><div class="ae-dropdown-content submarkets">
        <h3 class="ae-dropdown-title"><?php printf( esc_html__( 'Submarkets of %s', 'aecom' ), apply_filters( 'the_title', $selected_market->post_title ) ) ;?></h3>
        <ul class="col">
          <?php foreach ( $submarkets as $market ) { ?>
            <li><a href="<?php echo esc_url( get_permalink( $market->ID ) ); ?>"><?php echo apply_filters( 'the_title', $market->post_title ); ?></a></li><?php
          } ?>
        </ul><!-- .col -->
      </div></div>
    </div>

    <?php endif; ?>

  </div><!-- .filters -->

  <div class="search">
    <?php aecom_search_form( 'market' ); ?>
  </div><!-- .search -->

</div>
