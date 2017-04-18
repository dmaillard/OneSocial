( function ( $ ) {

    $( document ).on( 'click', '.button-load-more-posts', function ( event ) {
        event.preventDefault();

        var self = $( this );

        var page = self.data( 'page' ),
            template = self.data( 'template' ),
            href = self.attr( 'href' );

        self.addClass( 'loading' );

        $.get( href, function ( response ) {
            $( '.pagination-below' ).remove();

            if ( template === 'home' ) {
                $( response ).find( '.article-outher' ).each( function () {
                    $( '#content' ).append( $( this ) );
                } );
            } else if ( template === 'search' ) {
                $( response ).find( 'article.hentry' ).each( function () {
                    $( '.search-content-inner' ).append( $( this ) );
                } );
            } else {
                $( response ).find( 'article.type-post' ).each( function () {
                    $( '#content' ).append( $( this ) );
                } );
            }

            $( '#content' ).append( $( response ).find( '.pagination-below' ) );
        } );
    } );

    $( document ).on( 'scroll', function () {

        var load_more_posts = $( '.post-infinite-scroll' );

        if ( load_more_posts.length ) {

            var pos = load_more_posts.offset();

            if ( $( window ).scrollTop() + $( window ).height() > pos.top ) {

                if ( !load_more_posts.hasClass( 'loading' ) ) {
                    load_more_posts.trigger( 'click' );
                }
            }
        }

    } );

} )( jQuery );
