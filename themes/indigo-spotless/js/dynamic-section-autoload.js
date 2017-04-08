jQuery( function( $ ) {
  $( '.aecom-loader-placeholder.autoload' ).each( function() {

    var placeholder = $( this );

    $.get( aecom_dynamic_loader_info.url, {
      section: $( this ).attr( 'data-section' ),
      site: aecom_dynamic_loader_info.blog_id,
      lang: aecom_dynamic_loader_info.lang
    }, function( data ) {

      // insert dynamic HTML
      if ( data && data.html ) {
        placeholder.replaceWith( data.html );
      } else {
        // nothing to fetch (maybe something went wrong) - remove placeholder anyway
        placeholder.remove();
      }

    } );
  } )
} );
