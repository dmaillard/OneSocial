jQuery( document ).ready( function ( $ ) {

    $( document ).on( 'click', '#onesocial_recommend', function () {
        var link = $( this );

        if ( link.hasClass( 'active' ) ) {
            return false;
        }


        var id = $( this ).data( 'recid' ),
            suffix = link.find( '.onesocial_recommend-suffix' ).text();

        $.post( onesocial_recommendthis.ajaxurl, {
            action: 'onesocial-recommend',
            recommend_id: id,
            suffix: suffix
        }, function ( data ) {
            link.addClass( 'active' ).attr( 'title', 'You already recommended this' );
            $( '#onesocial-recommended-by .recommenders-list' ).html( data );
        } );

        return false;
    } );

} );