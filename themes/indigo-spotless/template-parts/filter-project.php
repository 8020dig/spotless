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
    /**
     * Markets filter
     */
    create_project_filter($post, 'market', 'qm', array(
    	'singular' => 'Market',
    	'subitem_singular' => 'Submarket',
    	'subitem_plural' => 'Submarkets',
    ));
    ?>
    
    <?php
    /**
     * Services filter.
     */
    create_project_filter($post, 'service', 'qs', array(
    	'singular' => 'Service',
    	'subitem_singular' => 'Subservice',
    	'subitem_plural' => 'Subservices',
    ));
    ?>
    
    <?php
    /**
     * Locations filter.
     */
    create_project_filter($post, 'location', 'ql', array(
    	'singular' => 'Location',
    	'subitem_singular' => 'Sublocation',
    	'subitem_plural' => 'Sublocations',
    ));
    ?>
    
    <?php
    /**
     * Brands filter.
     */
    create_project_filter($post, 'brand', 'qb', array(
    	'singular' => 'Brand',
    	'subitem_singular' => 'Subbrand',
    	'subitem_plural' => 'Subbrands',
    ));
    ?>

  </div><!-- .filters -->

  <div class="search">
    <?php aecom_search_form( 'project' ); ?>
  </div><!-- .search -->

</div>
