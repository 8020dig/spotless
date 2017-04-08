function updateQueryStringParameter(uri, key, value) {
  var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
  var separator = uri.indexOf('?') !== -1 ? "&" : "?";
  if (uri.match(re)) {
    return uri.replace(re, '$1' + key + "=" + value + '$2');
  }
  else {
    return uri + separator + key + "=" + value;
  }
}

jQuery( function( $ ) {

  if ( history.state && ( 'loaded_posts' in history.state ) ) {
    loaded_posts = history.state.loaded_posts;
    // replace posts
    $( '.loadable-posts.' + loaded_posts.scope ).html( loaded_posts.posts );
    // replace nav (so clicking Load More loads the next page, whichever that may be)
    $( '.ajax-posts-navigation' ).replaceWith( loaded_posts.nav );
  }

  $( '#main' ).on( 'click', '.ajax-posts-navigation a', function( e ) {

    e.preventDefault();
    $( this ).off( 'click' ); // prevent double-loading of content by impatient users

    var button = $( this ).closest( '.load-more' ).attr( 'aria-busy', 'aria-busy' );
    var nav = $( this ).closest( '.ajax-posts-navigation' );

    var scope = button.attr( 'data-scope' );

    // the container to which to append newly loaded posts
    var posts = $( '.loadable-posts.' + scope );

    // parts of the next page to load in & incorporate
    var dyn_parts = [ 'posts', 'posts-navigation' ];

    // load the next page, grabbing the above-requested sections and throwing out the rest
    $.get( $( this ).prop( 'href' ), {
      dyn_part: dyn_parts.join( ',' ),
      format: 'json'
    }, function( data ) {

      // insert posts & replace nav with new nav (so user can keep loading next pages)
      posts.append( data.posts );
      nav.replaceWith( data.posts_navigation );

      // alter history so clicking the back button will take you to this same list of posts
      var page = button.data("page");
      var newUrl = window.location.href;
      newUrl = updateQueryStringParameter(newUrl, "pp", page);
      if ( 'replaceState' in history ) {
        history.replaceState( {
          loaded_posts: {
            scope: scope,
            posts: posts.html(),
            nav: data.posts_navigation
          }
        }, window.document.title, newUrl );
      }

    }, 'json' );
  } );
} );
