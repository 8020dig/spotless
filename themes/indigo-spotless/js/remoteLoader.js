var aecomContent = {};
( function( $ ) {
  $( document ).ready( function( e ) {

    var template = '', page_name = '';

    if ( 'aecom_remote_template' in window ) {

      template = aecom_remote_template;

    } else {

      var classes = $( 'body' ).attr( 'class' ).split(' ');

      for ( var i = 0; i < classes.length; i++ ) {
        if (classes[i].match(/^template\-/)) {
          template = classes[i];
        }
        if ( classes[i].match( /^page\-/ ) ) {
          page_name = classes[i];
        }
      }
      if ( '' === template )
        return; // give up if no template found

    }

    var count = $( '.dynamic-section' ).length;
    var processed = 0;

    $( '.dynamic-section' ).each( function () {
      var container = $( this );
      var section_id = container.attr( 'id' ).split('-').join('_');

      $.get( aecom_template_base_url + template, {
        dyn_part: container.attr( 'id' ),
        page_name: page_name
      },
        function() {
          container.replaceWith( aecomContent[section_id] );
          processed++;
          if ( processed == count ) {
            $( 'body' ).removeClass( 'remote-template-loading' );
          }
        },
        'script'
      ).fail( function() {
        $( 'body' ).addClass( 'remote-template-load-error' ).removeClass( 'remote-template-loading' );
      } );
    } );

    return false;
  } );
} )( jQuery );
