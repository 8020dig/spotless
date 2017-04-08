/**
 * add a 'focus' class to the search form when it gains focus.
 *
 * this allows us to style the form itself like an input,
 * change width according to focus state, etc.
 */

( function( $ ) {
  $( function() {

    $( 'body' ).on( 'focusout', '.search-form', function( e ) {
      $( this ).removeClass( 'focus' );
    } ).on( 'focusin', '.search-form', function( e ) {
      $( this ).addClass( 'focus' );
    } );

  } );
} )( jQuery );
