( function ( $ ) {
    // Get member blog posts on blog page
    $( document ).on( 'click', '.load-more-posts a', function ( event ) {
        event.preventDefault();

        var $link = $( this ),
            author_id = $link.attr( 'href' ),
            data_target = $link.attr( 'data-target' ),
            sort = $link.data( 'sort' ),
            $parent = $link.parent( '.load-more-posts' );
        $container = $link.parents( '.article-outher' ).find( '.posts-stream' );

        $parent.addClass( 'active' );

        if ( $parent.hasClass( 'loaded' ) ) {
            $container.html( '<div class="loader">Loading...</div>' );
        }

        $container.next( '.header-area' ).hide();
        $container.next().next().hide();
        $container.fadeIn();
        $.ajax( {
            url: ajaxposts.ajaxurl,
            type: 'post',
            data: {
                action: 'buddyboss_ajax_posts',
                author: author_id,
                data_target: data_target,
                sort: sort,
                page: 'blog',
                postsNonce: ajaxposts.postsNonce
            },
            success: function ( html ) {
                $container.find( '.loader' ).fadeOut();
                $container.html( html );
                $container.find( '.inner' ).fadeIn();
                $parent.addClass( 'loaded' );
//                $( 'html,body' ).animate( { scrollTop: $( document ).scrollTop().valueOf() + 1 } );

                setTimeout( function () {
                    animatePosts( $link );
                }, 90 );

            }
        } );
    } );

    $( document ).on( 'click', '.load-more-posts.loaded i', function ( event ) {
        var $link = $( this ),
            $anchor = $( this ).next(),
            $parent = $link.parent( '.load-more-posts' ),
            $container = $link.parents( '.article-outher' ).find( '.posts-stream' );

        setTimeout( function () {
            animatePosts( $anchor );
        }, 500 );


        $parent.toggleClass( 'active' );
        $container.next( '.header-area' ).toggle();
        $container.next().next().toggle();
        $container.toggle();
    } );


} )( jQuery );


function animatePosts( $link ) {
    var target = $link.attr( 'data-target' );
    if ( $link.attr( 'data-sequence' ) !== undefined ) {
        var firstId = $( "." + target + ":first" ).attr( 'data-id' );
        var lastId = $( "." + target + ":last" ).attr( 'data-id' );
        var number = firstId;

        //Add or remove the class
        if ( $( "." + target + "[data-id=" + number + "]" ).hasClass( 'go' ) ) {
            $( "." + target + "[data-id=" + number + "]" ).addClass( 'goAway' );
            $( "." + target + "[data-id=" + number + "]" ).removeClass( 'go' );
        } else {
            $( "." + target + "[data-id=" + number + "]" ).addClass( 'go' );
            $( "." + target + "[data-id=" + number + "]" ).removeClass( 'goAway' );
        }
        number++;
        delay = Number( $link.attr( 'data-sequence' ) );
        $.doTimeout( delay, function () {
            //console.log( lastId );

            //Add or remove the class
            if ( $( "." + target + "[data-id=" + number + "]" ).hasClass( 'go' ) ) {
                $( "." + target + "[data-id=" + number + "]" ).addClass( 'goAway' );
                $( "." + target + "[data-id=" + number + "]" ).removeClass( 'go' );
            } else {
                $( "." + target + "[data-id=" + number + "]" ).addClass( 'go' );
                $( "." + target + "[data-id=" + number + "]" ).removeClass( 'goAway' );
            }

            //increment
            ++number;

            //continute looping till reached last ID
            if ( number <= lastId ) {
                return true;
            }
        } );
    }
}