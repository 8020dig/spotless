/**
 * Simple dropdown menus
 */
( function( $ ) {

  var deactivate_soon = function( $dropdown ) {
    return setTimeout( function() {
      $dropdown.removeClass( 'active-temp' )
        .closest( '.has-dropdown' ).removeClass( 'active-temp' );
    }, 500 );
  };

  $( function() {

    var toggles = $( '.has-dropdown .ae-dropdown-toggle' ),
      dropdowns = $( '.has-dropdown .ae-dropdown' );
      dropdown_parts = $( '.has-dropdown, .has-dropdown .ae-dropdown-toggle, .has-dropdown .ae-dropdown' );

    $( '.has-dropdown' ).each( function() {
      $( this ).data( 'dropdown', $( this ).find( '.ae-dropdown' ) );
    } );

    $( '.has-dropdown' ).hover( function() {
      if ( ! $( this ).find( '.ae-dropdown-toggle' ).is( '.active' ) && $( '.ae-dropdown-toggle.active' ).length < 1 ) {

        clearTimeout( $( this ).data( 'deactivator' ) );
        dropdown_parts.removeClass( 'active-temp' );
        $( this ).data( 'dropdown' ).addClass( 'active-temp' )
          .closest( '.has-dropdown' ).addClass( 'active-temp' );

      }
    }, function() {
      $( this ).data( 'deactivator', deactivate_soon( $( this ).data( 'dropdown' ) ) );
    } );

    toggles.on( 'click', function( e ) {

      var was_active = $( this ).is( '.active' );

      dropdown_parts.removeClass( 'active active-temp' );

      if ( ! was_active ) {
        $( this ).addClass( 'active' )
          .closest( '.has-dropdown' ).addClass( 'active' );
          if($(this).data( 'dropdown' ) ){
            $(this).data( 'dropdown' ).addClass( 'active' );
          }
      }

      e.preventDefault();
    } );

    $( 'body' ).on( 'mousedown', function() {
      dropdown_parts.removeClass( 'active active-temp' );
    } );

    dropdown_parts.on( 'mousedown', function( e ) {
      //e.stopPropagation(); // prevent bubbling up to body ^
    } );

    // change body class to replace basic :hover functionality with nicer JS-based .active-temp
    $( 'body' ).removeClass( 'ae-dropdowns-basic' );

  } );

} )( jQuery );
