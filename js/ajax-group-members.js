( function ( $ ) {
    // friends lists members page
    //groupMembersResult();

    // Search results page
    $( 'body' ).on( 'click', '.search_filters .groups a, .search_filters > ul li:first-child a', function () {
        setTimeout( function () {
            groupMembersResult();
        }, 900 );
    } );

    function groupMembersResult() {
        var $containers = $( '.group-members-results' );

        $containers.each( function () {
            var $container = $( this );
            $container.empty();
            $container.append( '<div class="spin">Loading...</div>' );
            $.ajax( {
                url: ajaxmembers.ajaxurl,
                type: 'post',
                data: {
                    action: 'buddyboss_get_group_members',
                    sort: 'recently_active',
                    page: 'dir',
                    id: $container.data( 'group-id' ),
                    count: 4,
                    membersNonce: ajaxmembers.membersNonce
                },
                success: function ( html ) {
                    $container.empty();
                    $container.append( html );
                    $container.find( 'ul' ).fadeIn();
                }
            } );
        } );
    }

} )( jQuery );