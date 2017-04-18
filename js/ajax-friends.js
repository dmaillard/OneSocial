( function ( $ ) {
    // Get friends list
    var $container = $( '.friends-results' );

    function ajaxCall( $link ) {
        var sort = $link.attr( 'href' );
        $container.empty( sort );
        $container.append( '<div class="fa fa-spin fa-spinner"></div>' );
        $.ajax( {
            url: ajaxfriends.ajaxurl,
            type: 'post',
            data: {
                action: 'buddyboss_get_friends',
                sort: sort,
                page: 'single',
                count: 5,
                friendsNonce: ajaxfriends.friendsNonce
            },
            success: function ( html ) {
                $container.empty();
                $container.append( html );
                $container.find( 'ul' ).fadeIn();
                $link.addClass( 'selected' );
            }
        } );
    }

    $( document ).on( 'click', '#friends-filter a', function ( event ) {
        event.preventDefault();
        $( '#friends-filter a' ).removeClass( 'selected' );
        ajaxCall( $( this ) );
    } );

    if ( $( '#friends-filter' ).length > 0 ) {
        ajaxCall( $( '#friends-filter a#default' ) );
    }

} )( jQuery );