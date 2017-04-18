( function ( $ ) {

    'use strict';

    $( document ).on( 'click', '.sl-button', function () {
        var button = $( this );
        var post_id = button.attr( 'data-post-id' );
        var security = button.attr( 'data-nonce' );
        var iscomment = button.attr( 'data-iscomment' );
        var allbuttons;

        if ( iscomment === '1' ) { /* Comments can have same id */
            allbuttons = $( '.sl-comment-button-' + post_id );
        } else {
            allbuttons = $( '.sl-button-' + post_id );
        }

        if ( post_id !== '' ) {

            $.ajax( {
                type: 'POST',
                url: recommendPost.ajaxurl,
                data: {
                    action: 'process_simple_like',
                    post_id: post_id,
                    nonce: security,
                    is_comment: iscomment
                },
                beforeSend: function () {
                    button.find( 'i' ).addClass( 'fa-spinner fa-spin' );
                },
                success: function ( response ) {
                    //console.log( response );
                    var icon = response.icon;
                    var count = response.count;
                    allbuttons.html( icon + count );

                    if ( response.status === 'unliked' ) {
                        var like_text = recommendPost.like;
                        allbuttons.prop( 'title', like_text );
                        allbuttons.removeClass( 'liked' );
                    } else {
                        var unlike_text = recommendPost.unlike;
                        allbuttons.prop( 'title', unlike_text );
                        allbuttons.addClass( 'liked' );
                    }

                    button.find( 'i' ).removeClass( 'fa-spinner fa-spin' );
                }
            } );

        }

        return false;
    } );

    // Load more posts
    $( document ).on( 'ready', function () {
        $( '#sort-posts-form #sort' ).on( 'change', function () {
            $( this ).parents( 'form' ).submit();
        } );

        $( document ).on( 'click', '.sap-load-more-posts', function ( e ) {
            e.preventDefault();

            var self = $( this ),
                sort = self.attr( 'data-sort' ),
                max = self.attr( 'data-max' ),
                paged = self.attr( 'data-paged' );

            $.ajax( {
                type: 'POST',
                url: recommendPost.ajaxurl,
                data: {
                    action: 'sap_posts_pagination',
                    sort: sort,
                    paged: paged,
                },
                beforeSend: function () {
                    self.addClass( 'loading' );
                },
                success: function ( html ) {

                    // Remove loading class
                    self.removeClass( 'loading' );

                    // Append Post Markup
                    self.parent().before( html );

                    // Remove Button
                    if ( html === 'null' ) {
                        self.remove();
                        return;
                    }

                    // Remove Button
                    if ( max === paged ) {
                        self.remove();
                    }

                    paged++;
                    self.attr( 'data-paged', paged );
                }
            } );
        } );

    } );

} )( jQuery );