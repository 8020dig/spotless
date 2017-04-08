jQuery( function( $ ) {

  var office_ajax_request = false;
  var $office_view = $( '.flex-view-office' );
  var default_office_view_content = '';

  var universalize_url = function( url ) {
    return url.replace( aecom_offices_urls.local, aecom_offices_urls.uni );
  }

  if ( $office_view.find( '.flex-view-header' ).is( '.main' ) ) { // 'main'/default office view
    default_office_view_content = $office_view.html();
  }

  $( '.filter-bar' ).on( 'click', '.ae-dropdown-content a', function( e ) {

    e.preventDefault();

    // cancel any other requests
    if ( office_ajax_request ) office_ajax_request.abort();

    // reset dropdown states
    var $filter = $( this ).closest( '.has-dropdown' );
    $filter.removeClass( 'active active-temp' );
    $filter.find( '.ae-dropdown-toggle, .ae-dropdown' ).removeClass( 'active active-temp' );
    var selection_name = $( this ).text();

    // reset other dropdowns' + fields' text
    $( '.filter-bar' ).find( '.ae-dropdown-toggle' ).text( function() {
      return $( this ).attr( 'data-dropdown-title-default' );
    } );
    $( '.filter-bar' ).find( 'input[name=qq]' ).val( '' );

    // set this dropdown's text
    $filter.find( '.ae-dropdown-toggle' ).text( function() {
      return $( this ).attr( 'data-dropdown-title-selected' ).replace( '%s', selection_name );
    } );

    $office_view.attr( 'aria-busy', 'aria-busy' );

    // convert local office URL to universal
    var request_url = universalize_url( $( this ).attr( 'href' ) );

    console.log( request_url );

    office_ajax_request = $.get( request_url, {
      dyn_part: 'offices',
      format: 'json',
      site_id: aecom_offices_urls.site_id
    }, function( data ) {

      console.log( data );

      $office_view.html( data.offices )
        .removeAttr( 'aria-busy' );

    }, 'json' );

  } );

  $( '.filter-bar .search-form' ).on( 'submit', function( e ) {

    e.preventDefault();

    // cancel any other requests
    if ( office_ajax_request ) office_ajax_request.abort();

    // reset dropdowns' text
    $( '.filter-bar' ).find( '.ae-dropdown-toggle' ).text( function() {
      return $( this ).attr( 'data-dropdown-title-default' );
    } );

    var $search_input = $( this ).find( 'input[name=qq]' ).blur();

    $office_view.attr( 'aria-busy', 'aria-busy' );

    var request_url = universalize_url( $( this ).attr( 'action' ) );

    console.log( request_url );
    console.log( $search_input.val() );

    office_ajax_request = $.get( request_url, {
      dyn_part: 'offices',
      format: 'json',
      site_id: aecom_offices_urls.site_id,
      qq: $search_input.val()
    }, function( data ) {

      console.log( data );

      $office_view.html( data.offices )
        .removeAttr( 'aria-busy' );

    }, 'json' );

  } );

  $office_view.on( 'click', 'a', function( e ) {

    e.preventDefault();

    // if a request is already pending, ignore further clicks
    if ( $office_view.attr( 'aria-busy' ) ) {
      return false;
    }

    // toggle grid & list views
    if ( $( this ).is( '.flex-view-options a' ) ) {
      $( this ).closest( '.flex-view' ).removeClass( 'flex-view-grid flex-view-list' )
      .addClass( $( this ).is( '.flex-view-grid-link' ) ? 'flex-view-grid' : 'flex-view-list' );
      return false;
    }

    $office_view.attr( 'aria-busy', 'aria-busy' );

    var resetting = $( this ).is( '.reset-filters' );

    if ( resetting ) {

      // reset other dropdowns' + fields' text
      $( '.filter-bar' ).find( '.ae-dropdown-toggle' ).text( function() {
        return $( this ).attr( 'data-dropdown-title-default' );
      } );
      $( '.filter-bar' ).find( 'input[name=qq]' ).val( '' );

      // if we already know what's contained in the default office view,
      // display it immediately - no need to re-load it
      if ( default_office_view_content ) {
        $office_view.removeClass( 'flex-view-list' ).addClass( 'flex-view-grid' )
          .html( default_office_view_content )
          .removeAttr( 'aria-busy' );
        return false;
      }

      var request_url = $( this ).attr( 'href' );

    }

    // if we're going to make an AJAX request to get the default
    // office view, then make it to this site, not uni!
    var request_url = ( resetting ?
      $( this ).attr( 'href' ) :
      universalize_url( $( this ).attr( 'href' ) )
    );

    console.log( request_url );

    office_ajax_request = $.get( request_url, {
      dyn_part: 'offices',
      format: 'json',
      site_id: aecom_offices_urls.site_id
    }, function( data ) {

      console.log( data );

      if ( resetting ) {
        // reset view (main offices section can't be viewed as a list, only as a grid)
        $office_view.removeClass( 'flex-view-list' ).addClass( 'flex-view-grid' );
        // store the default office view for future resets
        default_office_view_content = data.offices;
      }

      $office_view.html( data.offices )
        .removeAttr( 'aria-busy' );

    }, 'json' );

  } );

} );
