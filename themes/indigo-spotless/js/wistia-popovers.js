jQuery( function( $ ) {

  // wistia queue
  window._wq = window._wq || [];

  // get embed code from class
  var video_id_test = /wistia_async_([0-9a-z]*)/;

  $( '.wistia_embed' ).each( function() {

    // ignore non-popup video embeds
    if ( $( this ).prop( 'class' ).indexOf( 'popover=true' ) === -1 ) {
      return;
    }

    var video_id_detection = $( this ).attr( 'class' ).match( video_id_test );

    if ( video_id_detection.length > 1 ) {

      var video_id = video_id_detection[1],
        queue_obj = {};

      // insert API calls into queue
      queue_obj[ video_id ] = function( video ) {

        // close popover when video finishes playing
        video.bind( 'end', function() {
          video.popover.hide();
        } );
      };

      _wq.push( queue_obj );
    }
  } );
} );
