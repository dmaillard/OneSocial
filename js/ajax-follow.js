( function ( $ ) {
    // Get Follow lists

    function ajaxCall( $link, $container, group ) {
        var sort = $link.attr( 'href' );
        $container.empty();
        $container.append( '<div class="fa fa-spin fa-spinner"></div>' );
        $.ajax( {
            url: ajaxfollow.ajaxurl,
            type: 'post',
            data: {
                action: 'buddyboss_get_follow',
                sort: sort,
                group: group,
                followNonce: ajaxfollow.followNonce
            },
            success: function ( html ) {
                $container.empty();
                $container.append( html );
                $container.find( 'ul' ).fadeIn();
                $link.addClass( 'selected' );
            }
        } );
    }

    $( document ).on( 'click', '#following-filter a', function ( event ) {
        event.preventDefault();
        $( '#following-filter a' ).removeClass( 'selected' );
        ajaxCall( $( this ), $( '#following-results' ), 'following' );
    } );

    $( document ).on( 'click', '#followers-filter a', function ( event ) {
        event.preventDefault();
        $( '#followers-filter a' ).removeClass( 'selected' );
        ajaxCall( $( this ), $( '#followers-results' ), 'followers' );
    } );

    ajaxCall( $( '#following-filter a#default' ), $( '#following-results' ), 'following' );
    ajaxCall( $( '#followers-filter a#default' ), $( '#followers-results' ), 'followers' );

} )( jQuery );