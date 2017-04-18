/**
 * BuddyBoss JavaScript functionality
 *
 * @since    3.0
 * @package  buddyboss
 *
 * ====================================================================
 *
 * 1. jQuery Global
 * 2. Main BuddyBoss Class
 * 3. Inline Plugins
 */


/**
 * 1. jQuery Global
 * ====================================================================
 */
var jq = $ = jQuery;

/*--------------------------------------------------------------------------------------------------------
 Group Load Scroll
 --------------------------------------------------------------------------------------------------------*/
$( document ).ready( function ( $ ) {
    $( '.single-item #buddypress' ).attr( 'style', '' );
    $body = $( 'body' );
    if ( $body.hasClass( 'single-item' ) && $body.hasClass( 'groups' ) && $body.scrollTop() == 0 && $( '#buddypress' ).data( 'cover-size' ) !== 200 && !$( '#buddypress' ).data( 'page-refreshed' ) ) {

        $( "html,body" ).scrollTop( 260 );
    }
} );
/**
 * 2. Main BuddyBoss Class
 *
 * This class takes care of BuddyPress additional functionality and
 * provides a global name space for BuddyBoss plugins to communicate
 * through.
 *
 * Event name spacing:
 * $(document).on( "buddyboss:*module*:*event*", myCallBackFunction );
 * $(document).trigger( "buddyboss:*module*:*event*", [a,b,c]/{k:v} );
 * ====================================================================
 * @return {class}
 */
var BuddyBossMain = ( function ( $, window, undefined ) {

    /**
     * Globals/Options
     */
    var _l = {
        $document: $( document ),
        $window: $( window )
    };

    // Controller
    var App = { };

    // Custom Events
    var Vent = $( { } );

    // Responsive
    var Responsive = { };

    // BuddyPress Defaults
    var BuddyPress = { };

    // BuddyPress Legacy
    var BP_Legacy = { };


    /** --------------------------------------------------------------- */

    /**
     * Application
     */

    // Initialize, runs when script is processed/loaded
    App.init = function () {

        _l.$document.ready( App.domReady );

        BP_Legacy.init();
    }

    // When the DOM is ready (page laoded)
    App.domReady = function () {
        _l.body = $( 'body' );
        _l.$buddypress = $( '#buddypress' );

        Responsive.domReady();
    }

    /** --------------------------------------------------------------- */

    /**
     * BuddyPress Responsive Help
     */
    Responsive.domReady = function () {

        // GLOBALS *
        // ---------
        window.BuddyBoss = window.BuddyBoss || { };

        window.BuddyBoss.is_mobile = null;

        var
            $document = $( document ),
            $window = $( window ),
            $body = $( 'body' ),
            mobile_width = 720,
            is_mobile = false,
            has_item_nav = false,
            mobile_modified = false,
            swiper = false,
            $main = $( '#main-wrap' ),
            $inner = $( '#inner-wrap' ),
            $buddypress = $( '#buddypress' ),
            $item_nav = $buddypress.find( '#item-nav' ),
            Panels = { },
            inputsEnabled = $( 'body' ).data( 'inputs' ),
            $mobile_nav_wrap,
            $mobile_item_wrap,
            $mobile_item_nav;

        // Detect android stock browser
        // http://stackoverflow.com/a/17961266
        var isAndroid = navigator.userAgent.indexOf( 'Android' ) >= 0;
        var webkitVer = parseInt( ( /WebKit\/([0-9]+)/.exec( navigator.appVersion ) || 0 )[1], 10 ) || void 0; // also match AppleWebKit
        var isNativeAndroid = isAndroid && webkitVer <= 534 && navigator.vendor.indexOf( 'Google' ) == 0;

        /*------------------------------------------------------------------------------------------------------
         1.0 - Core Functions
         --------------------------------------------------------------------------------------------------------*/

        // get viewport size
        function viewport() {
            var e = window, a = 'inner';
            if ( !( 'innerWidth' in window ) ) {
                a = 'client';
                e = document.documentElement || document.body;
            }
            return { width: e[ a + 'Width' ], height: e[ a + 'Height' ] };
        }
        /**
         * Checks for supported mobile resolutions via media query and
         * maximum window width.
         *
         * @return {boolean} True when screen size is mobile focused
         */
        function check_is_mobile() {
            // The $mobile_check element refers to an empty div#mobile-check we
            // hide or show with media queries. We use this to determine if we're
            // on mobile resolution

//                mobile_css = window.document.getElementById('boss-main-mobile-css'),
//                $mobile_css = $(mobile_css);

            if ( $.cookie( 'switch_mode' ) != 'mobile' ) {
//                    if(($mobile_css.attr('media') != 'all')) {
                if ( ( !translation.only_mobile ) ) {
                    if ( viewport().width < 480 ) {
                        $( 'body' ).removeClass( 'is-desktop' ).addClass( 'is-mobile' );
                    } else {
                        $( 'body' ).removeClass( 'is-mobile' ).addClass( 'is-desktop' );
                    }
                }
            }

            is_mobile = BuddyBoss.is_mobile = $( 'body' ).hasClass( 'is-mobile' );

            return is_mobile;
        }

        /**
         * Checks for a BuddyPress sub-page menu. On smaller screens we turn
         * this into a left/right swiper
         *
         * @return {boolean} True when BuddyPress item navigation exists
         */
        function check_has_item_nav() {
            if ( $item_nav && $item_nav.length ) {
                has_item_nav = true;
            }

            return has_item_nav;
        }

        function render_layout() {
            var
                window_height = $window.height(), // window height - 60px (Header height) - carousel_nav_height (Carousel Navigation space)
                carousel_width = ( $item_nav.find( 'li' ).length * 94 );

            // If on small screens make sure the main page elements are
            // full width vertically
            if ( is_mobile && ( $inner.height() < $window.height() ) ) {
                $( '#page' ).css( 'min-height', $window.height() - ( $( '#mobile-header' ).height() + $( '#colophon' ).height() ) );
            }

            // Swipe/panel shut area
            if ( is_mobile && $( '#buddyboss-swipe-area' ).length && Panels.state ) {
                $( '#buddyboss-swipe-area' ).css( {
                    left: Panels.state === 'left' ? 240 : 'auto',
                    right: Panels.state === 'right' ? 240 : 'auto',
                    width: $( window ).width() - 240,
                    height: $( window ).outerHeight( true ) + 200
                } );
            }

            // Log out link in left panel
            var $left_logout_link = $( '#wp-admin-bar-logout' ),
                $left_account_panel = $( '#wp-admin-bar-user-actions' ),
                $left_settings_menu = $( '#wp-admin-bar-my-account-settings .ab-submenu' ).first();

            if ( $left_logout_link.length && $left_account_panel.length && $left_settings_menu.length ) {
                // On mobile user's accidentally click the link when it's up
                // top so we move it into the setting menu
                if ( is_mobile ) {
                    $left_logout_link.appendTo( $left_settings_menu );
                }
                // On desktop we move it back to it's original place
                else {
                    $left_logout_link.appendTo( $left_account_panel );
                }
            }

            // Runs once, first time we experience a mobile resolution
            if ( is_mobile && has_item_nav && !mobile_modified ) {
                mobile_modified = true;
                $mobile_nav_wrap = $( '<div id="mobile-item-nav-wrap" class="mobile-item-nav-container mobile-item-nav-scroll-container">' );
                $mobile_item_wrap = $( '<div class="mobile-item-nav-wrapper">' ).appendTo( $mobile_nav_wrap );
                $mobile_item_nav = $( '<div id="mobile-item-nav" class="mobile-item-nav">' ).appendTo( $mobile_item_wrap );
                $mobile_item_nav.append( $item_nav.html() );

                $mobile_item_nav.css( 'width', ( $item_nav.find( 'li' ).length * 94 ) );
                $mobile_nav_wrap.insertBefore( $item_nav ).show();
                $( '#mobile-item-nav-wrap, .mobile-item-nav-scroll-container, .mobile-item-nav-container' ).addClass( 'fixed' );
                $item_nav.css( { display: 'none' } );
            }
            // Resized to non-mobile resolution
            else if ( !is_mobile && has_item_nav && mobile_modified ) {
                $mobile_nav_wrap.css( { display: 'none' } );
                $item_nav.css( { display: 'block' } );
                $document.trigger( 'menu-close.buddyboss' );
            }
            // Resized back to mobile resolution
            else if ( is_mobile && has_item_nav && mobile_modified ) {
                $mobile_nav_wrap.css( {
                    display: 'block',
                    width: carousel_width
                } );

                $mobile_item_nav.css( {
                    width: carousel_width
                } );

                $item_nav.css( { display: 'none' } );
            }

            // Update select drop-downs
            if ( typeof Selects !== 'undefined' ) {
                if ( $.isFunction( Selects.populate_select_label ) ) {
                    Selects.populate_select_label( is_mobile );
                }
            }
        }

        /**
         * Renders the layout, called when the page is loaded and on resize
         *
         * @return {void}
         */
        function do_render()
        {
            check_is_mobile();
            check_has_item_nav();
            render_layout();
            mobile_carousel();
        }

        /*------------------------------------------------------------------------------------------------------
         1.1 - Startup (Binds Events + Conditionals)
         --------------------------------------------------------------------------------------------------------*/

        // Render layout
        do_render();

        // Re-render layout after everything's loaded
        $window.bind( 'load', function () {
            do_render();
        } );

        // Re-render layout on resize
        var throttle;
        $window.resize( function () {
            clearTimeout( throttle );
            throttle = setTimeout( do_render, 150 );
        } );

        function elementInViewport( el ) {
            var top = el.offsetTop;
            var left = el.offsetLeft;
            var width = el.offsetWidth;
            var height = el.offsetHeight;

            while ( el.offsetParent ) {
                el = el.offsetParent;
                top += el.offsetTop;
                left += el.offsetLeft;
            }

            return (
                top < ( window.pageYOffset + window.innerHeight ) &&
                left < ( window.pageXOffset + window.innerWidth ) &&
                ( top + height ) > window.pageYOffset &&
                ( left + width ) > window.pageXOffset
                );
        }

        var $images_out_of_viewport =
            $( '#main-wrap img, .svg-graphic' ).filter( function ( index ) {
            return !elementInViewport( this );
        } );

        $images_out_of_viewport.each( function () {
            this.classList.add( "not-loaded" );
        } );


        var waypoints = $images_out_of_viewport
            .waypoint( {
                handler: function ( direction ) {
                    if ( this.element != undefined ) {
                        this.element.classList.add( "loaded" );
                    } else {
                        //fallback
                        this.classList.add( "loaded" );
                    }
                },
                offset: '85%'
            } );

        $( window ).trigger( 'scroll' );

        $( document ).ajaxSuccess( function () {
            setTimeout( function () {
                Waypoint.refreshAll();
                waypoints = $( '#main-wrap img, .svg-graphic' )
                    .waypoint( {
                        handler: function ( direction ) {
                            if ( this.element !== undefined ) {
                                this.element.classList.add( "loaded" );
                            }
                        },
                        offset: '85%'
                    } );
            }, 200 );
        } );

        /*------------------------------------------------------------------------------------------------------
         1.9 - Group Avatar upload fix
         --------------------------------------------------------------------------------------------------------*/
        $( document ).ajaxSuccess( function ( event, request, settings ) {
            if ( $( 'body' ).hasClass( 'groups' ) && event.currentTarget.URL.indexOf( 'admin/group-avatar' ) > -1 && request.responseJSON && request.responseJSON.data && request.responseJSON.data.avatar ) {
                $( '#item-header-avatar image' ).attr( 'xlink:href', request.responseJSON.data.avatar );
            }
        } );

        $( document ).ajaxSuccess( function ( event, request, settings ) {
            if ( $( 'body' ).hasClass( 'group-create' ) && event.currentTarget.URL.indexOf( 'step/group-avatar' ) > -1 && request.responseJSON && request.responseJSON.data && request.responseJSON.data.avatar ) {
                $( '.left-menu img' ).attr( 'src', request.responseJSON.data.avatar );
            }
        } );

        /*------------------------------------------------------------------------------------------------------
         2.0 - Responsive Menus
         --------------------------------------------------------------------------------------------------------*/
//        $( '#main-nav' ).on( 'click', function ( e ) {
//            e.preventDefault();
//            $( 'body' ).toggleClass( 'open-right' );
//        } );
//
//        $( '#user-nav' ).on( 'click', function ( e ) {
//            e.preventDefault();
//            $( 'body' ).toggleClass( 'open-left' );
//        } );
//
//        $( document ).mouseup( function ( e ) {
//            var container = $( '#mobile-right-panel, #wpadminbar.mobile' );
//            if ( !container.is( e.target ) && container.has( e.target ).length === 0 ) {
//                $( 'body' ).removeClass( 'open-right open-left' );
//            }
//        } );

        /*------------------------------------------------------------------------------------------------------
         2.1 - Mobile/Tablet Carousels
         --------------------------------------------------------------------------------------------------------*/

        function mobile_carousel() {
            if ( is_mobile && has_item_nav ) {
                /* Remove submenu if there is any */
                if ( $( '#mobile-item-nav #nav-bar-filter .hideshow ul' ).length > 0 ) {
                    $( '#mobile-item-nav #nav-bar-filter' ).append( $( '#mobile-item-nav #nav-bar-filter .hideshow ul' ).html() );
                    $( '#mobile-item-nav #nav-bar-filter .hideshow' ).remove();
                }

                if ( !swiper ) {
                    // console.log( 'Setting up mobile nav swiper' );
                    swiper = $( '.mobile-item-nav-scroll-container' ).swiper( {
                        scrollContainer: true,
                        slideElement: 'div',
                        slideClass: 'mobile-item-nav',
                        wrapperClass: 'mobile-item-nav-wrapper'
                    } );
                }
            }
        }

        /*------------------------------------------------------------------------------------------------------
         2.2 - Responsive Dropdowns
         -------------------------------------------------------------------------------------------------------*/
        if ( typeof Selects !== 'undefined' ) {
            if ( $.isFunction( Selects.init_select ) ) {
                Selects.init_select( is_mobile, inputsEnabled );
            }
        }

        if ( $( 'body' ).hasClass( 'messages' ) ) {
            $document.ajaxComplete( function () {
                setTimeout( function () {
                    if ( $.isFunction( Selects.init_select ) ) {
                        Selects.init_select( is_mobile, inputsEnabled );
                    }
                    if ( typeof Selects !== 'undefined' ) {
                        if ( $.isFunction( Selects.populate_select_label ) ) {
                            Selects.populate_select_label( is_mobile );
                        }
                    }
//                    $('.message-check, #select-all-messages').addClass('styled').after('<strong></strong>');

                }, 500 );
            } );
        }

        $( window ).on( 'load', function () {
            $( 'body' ).addClass( 'boss-page-loaded' );
        } );

        $( '#mobile-right-panel .menu-item-has-children' ).each( function () {
            $( this ).prepend( '<i class="fa submenu-btn fa-angle-down"></i>' );
        } );

        $( '#mobile-right-panel .submenu-btn' ).on( 'click', function ( e ) {
            e.preventDefault();
            $( this ).toggleClass( 'fa-angle-left fa-angle-down' ).parent().find( '.sub-menu' ).slideToggle();
        } );

        /*------------------------------------------------------------------------------------------------------
         2.3 - Notifications Area
         -------------------------------------------------------------------------------------------------------*/

        // Add Notifications Area, if there are notifications to show

        if ( is_mobile && $window.width() < 720 ) {

            if ( $( '#wp-admin-bar-bp-notifications' ).length != 0 ) {

                // Clone and Move the Notifications Count to the Header
                $( 'li#wp-admin-bar-bp-notifications a.ab-item > span#ab-pending-notifications' ).clone().appendTo( '#user-nav' );

            }
        }

        /*------------------------------------------------------------------------------------------------------
         3.0 - Send To Full Editor
         --------------------------------------------------------------------------------------------------------*/
        $( '#full-screen' ).on( 'submit', function ( e ) {
            var editor = new MediumEditor( '.sap-editable-area' ),
                title = new MediumEditor( '.sap-editable-title' ),
                post_content_wrap = $( '.sap-editable-area' ).attr( 'id' ),
                post_content_obj = editor.serialize(),
                post_title_obj = title.serialize(),
                post_title_wrap = $( '.sap-editable-title' ).attr( 'id' );
                        $( this ).find( 'input[name="content"]' ).val( post_content_obj[post_content_wrap].value.replace( /(\r\n|\n|\r)/gm, "" ) );
                        $( this ).find( 'input[name="title"]' ).val( post_title_obj[post_title_wrap].value.replace( /(\r\n|\n|\r)/gm, "" ) );
                } );

        /*------------------------------------------------------------------------------------------------------
         3.0 - Content
         --------------------------------------------------------------------------------------------------------*/

        if ( !$( '#buddyboss-media-add-photo' ).length ) {
            $( '#whats-new-textarea .boss-insert-buttons-addons li:first-child' ).remove();
        }

        $( '#whats-new-textarea .boss-insert-buttons-show' ).on( 'click', function ( e ) {
            e.preventDefault();
            $( '#whats-new' ).removeAttr( 'placeholder' );
            $( this ).parents( '#whats-new-form' ).toggleClass( 'boss-show-buttons' );
        } );

        $( '#whats-new-textarea .boss-insert-image' ).on( 'click', function ( e ) {
            e.preventDefault();
            $( '#buddyboss-media-open-uploader-button' ).trigger( 'click' );
        } );

        $( '#whats-new-textarea .boss-insert-video' ).on( 'click', function ( e ) {
            e.preventDefault();
            $( '#whats-new-form' ).removeClass( 'boss-show-buttons' );
            $( '#whats-new' ).attr( 'placeholder', $( this ).data( 'placeholder' ) ).focus();
        } );

        $( '.comment-form-comment .boss-insert-buttons-show' ).on( 'click', function ( e ) {
            e.preventDefault();

            if ( $( this ).parents( '.comment-form' ).hasClass( 'boss-show-buttons' ) ) {
                setTimeout( function () {
                    $( '#comment' ).css( 'visibility', 'visible' ).attr( 'placeholder', $( '.comment-form-comment .boss-insert-text' ).data( 'placeholder' ) ).focus();
                }, 150 );
            } else {
                $( '#comment' ).removeAttr( 'placeholder' ).css( 'visibility', 'hidden' );
                ;
            }

            $( this ).parents( '.comment-form' ).toggleClass( 'boss-show-buttons' );
        } );

        $( '.comment-form-comment .boss-insert-image' ).on( 'click', function ( e ) {
            e.preventDefault();
            $( '#attachment' ).trigger( 'click' );
        } );

        $( '#attachment' ).change( function () {
            String.prototype.filename = function ( extension ) {
                var s = this.replace( /\\/g, '/' );
                s = s.substring( s.lastIndexOf( '/' ) + 1 );
                // With extension
                return s;
                // Without extension
                // return extension ? s.replace( /[?#].+$/, '' ) : s.split( '.' )[0];
            };

            var fileName = $( this ).val().filename();
            $( '#comments' ).find( '.attached-image' ).remove();
            $( '#comment' ).after( '<p class="attached-image"><i class="fa fa-picture-o" aria-hidden="true"></i>' + fileName + '</p>' );
        } );

        // Turning On HTML5 Native Form Validation For WordPress Comments.
        $( '#commentform, #attachmentForm' ).removeAttr( 'novalidate' );

        $( '.comment-form-comment .boss-insert-text' ).on( 'click', function ( e ) {
            e.preventDefault();
            self = $( this );
            $( '#attachmentForm' ).removeClass( 'boss-show-buttons' );

            setTimeout( function () {
                $( '#comment' ).css( 'visibility', 'visible' ).attr( 'placeholder', self.data( 'placeholder' ) ).focus();
            }, 150 );
        } );

        $( 'body' ).on( 'mouseup', '.mfp-close', function () {
            $( '.RegisterBox' ).removeClass( 'go' );
            $( '.LoginBox' ).removeClass( 'go' );
        } );

        $( '#groups-dir-list' ).on( 'click', '.group-button a', function () {
            $( this ).parent().addClass( 'loading' );
        } );

        $( '#buddypress' ).on( 'click', '.group-button .leave-group', function () {
            $( this ).parent().addClass( 'loading' );
        } );

        $( document ).ajaxComplete( function () {
            $( '.generic-button.group-button' ).removeClass( 'loading' );
        } );

        $( 'body' ).on( 'change keyup keydown paste cut', '#comment', function () {
            $( this ).height( 0 ).height( this.scrollHeight );
        } ).find( 'textarea#comment' ).change();

        $( 'body' ).on( 'change keyup keydown paste cut focusout focus', '#whats-new', function () {
            $( this ).unbind( 'focus blur' );
            $( '#aw-whats-new-submit' ).prop( 'disabled', false );

            $( this ).height( 0 ).height( this.scrollHeight );

            var whats_content = $( this ).val();

            if ( whats_content !== '' ) {
                $( '.boss-insert-video' ).hide();
            } else {
                $( '.boss-insert-video' ).show();
            }
        } ).find( 'textarea#whats-new' ).change();

        /*--------------------------------------------------------------------------------------------------------
         3.21 - Responsive Menus (...)
         --------------------------------------------------------------------------------------------------------*/

        if ( !is_mobile ) {
            $( "body:not(.settings) #item-nav" ).find( "#nav-bar-filter" ).jRMenuMore( 60 );
            $datawidthFix = parseInt( $( '#site-navigation' ).attr( 'data-widthfix' ) );
            $widthFix = ( isNaN( $datawidthFix ) ) ? 120 : $datawidthFix;
            $( '#site-navigation .nav-menu' ).jRMenuMore( $widthFix );
        }

        /*------------------------------------------------------------------------------------------------------
         3.1 - Members (Group Admin)
         --------------------------------------------------------------------------------------------------------*/

        // Hide/Reveal action buttons
        $( 'a.show-options' ).click( function ( event ) {
            event.preventDefault();

            $( this ).next().slideToggle();

        } );


        /*------------------------------------------------------------------------------------------------------
         3.2 - Search Input Field
         --------------------------------------------------------------------------------------------------------*/
        $( '#buddypress div.dir-search form, #buddypress div.message-search form, div.bbp-search-form form, form#bbp-search-form' ).append( '<a href="#" id="clear-input"> </a>' );
        $( 'a#clear-input' ).click( function () {
            jQuery( "#buddypress div.dir-search form input[type=text], #buddypress div.message-search form input[type=text], div.bbp-search-form form input[type=text], form#bbp-search-form input[type=text]" ).val( "" );
        } );

        function searchWidthMobile() {
            if ( is_mobile ) {
                var $mobile_search = $( '#mobile-header .searchform' );
                if ( $mobile_search.length ) {
                    $mobile_search.focusin( function () {
                        $mobile_search.addClass( 'animate-form' );
                    } );

                    $mobile_search.focusout( function () {
                        $mobile_search.removeClass( 'animate-form' );
                    } );
                }
            }
        }

        searchWidthMobile();


        /*------------------------------------------------------------------------------------------------------
         3.3 - Hide Profile and Group Buttons Area, when there are no buttons (ex: Add Friend, Join Group etc...)
         --------------------------------------------------------------------------------------------------------*/

        if ( !$( '#buddypress #item-header #item-buttons .generic-button' ).length ) {
            $( '#buddypress #item-header #item-buttons' ).hide();
        }

        /*------------------------------------------------------------------------------------------------------
         3.4 - Load Posts on new submited
         --------------------------------------------------------------------------------------------------------*/

        $( document ).ajaxSuccess( function ( event, jqXHR, ajaxOptions, data ) {

            try {
                if ( jqXHR.status == 200 && ajaxOptions.data && ajaxOptions.data.indexOf( 'sap_save_post' ) > -1 && ajaxOptions.data.indexOf( 'post_status=public' ) > -1 ) {
                    $.ajax( {
                        url: BuddyBossOptions.ajaxurl,
                        type: 'post',
                        data: {
                            action: 'ajax_pagination',
                            id: data
                        },
                        success: function ( html ) {
                            $( '.boss-create-post-wrapper' ).after( html );
                        }
                    } );
                }
            } catch ( err ) {
                //console.log(err);
            }
        } );

        /*------------------------------------------------------------------------------------------------------
         3.5 - Spinners
         --------------------------------------------------------------------------------------------------------*/
        function initSpinner() {
            $( '.generic-button:not(.pending)' ).on( 'click', function () {
                $link = $( this ).find( 'a' );
                if ( !$link.find( 'i' ).length && !$link.hasClass( 'pending' ) ) {
                    $link.append( '<i class="fa fa-spinner fa-spin"></i>' );
                }
            } );
        }

        initSpinner();

        $( document ).ajaxComplete( function () {
            setTimeout( function () {
                initSpinner();
            }, 500 );

            setTimeout( function () {
                initSpinner();
            }, 1500 );
        } );
        /*------------------------------------------------------------------------------------------------------
         3.5 - Select unread and read messages in inbox
         --------------------------------------------------------------------------------------------------------*/

        // Overwrite/Re-do some of the functionality in buddypress.js,
        // to accommodate for UL instead of tables in buddyboss theme
        jq( "#message-type-select" ).change(
            function () {
                var selection = jq( "#message-type-select" ).val();
                var checkboxes = jq( "ul input[type='checkbox']" );
                checkboxes.each( function ( i ) {
                    checkboxes[i].checked = "";
                } );

                switch ( selection ) {
                    case 'unread':
                        var checkboxes = jq( "ul.unread input[type='checkbox']" );
                        break;
                    case 'read':
                        var checkboxes = jq( "ul.read input[type='checkbox']" );
                        break;
                }
                if ( selection != '' ) {
                    checkboxes.each( function ( i ) {
                        checkboxes[i].checked = "checked";
                    } );
                } else {
                    checkboxes.each( function ( i ) {
                        checkboxes[i].checked = "";
                    } );
                }
            }
        );

        /* Bulk delete messages */
        jq( "#delete_inbox_messages, #delete_sentbox_messages" ).on( 'click', function () {
            checkboxes_tosend = '';
            checkboxes = jq( "#message-threads ul input[type='checkbox']" );

            jq( '#message' ).remove();
            jq( this ).addClass( 'loading' );

            jq( checkboxes ).each( function ( i ) {
                if ( jq( this ).is( ':checked' ) )
                    checkboxes_tosend += jq( this ).attr( 'value' ) + ',';
            } );

            if ( '' == checkboxes_tosend ) {
                jq( this ).removeClass( 'loading' );
                return false;
            }

            jq.post( ajaxurl, {
                action: 'messages_delete',
                'thread_ids': checkboxes_tosend
            }, function ( response ) {
                if ( response[0] + response[1] == "-1" ) {
                    jq( '#message-threads' ).prepend( response.substr( 2, response.length ) );
                } else {
                    jq( '#message-threads' ).before( '<div id="message" class="updated"><p>' + response + '</p></div>' );

                    jq( checkboxes ).each( function ( i ) {
                        if ( jq( this ).is( ':checked' ) )
                            jq( this ).parent().parent().fadeOut( 150 );
                    } );
                }

                jq( '#message' ).hide().slideDown( 150 );
                jq( "#delete_inbox_messages, #delete_sentbox_messages" ).removeClass( 'loading' );
            } );
            return false;
        } );

        /*------------------------------------------------------------------------------------------------------
         3.6 - Make Video Embeds Responsive - Fitvids.js
         --------------------------------------------------------------------------------------------------------*/

        if ( typeof $.fn.fitVids !== 'undefined' && $.isFunction( $.fn.fitVids ) ) {
            $( '.wp-video' ).find( 'object' ).addClass( 'fitvidsignore' );
            $( '#content' ).fitVids();

            // This ensures that after and Ajax call we check again for
            // videos to resize.
            var fitVidsAjaxSuccess = function () {
                $( '.wp-video' ).find( 'object' ).addClass( 'fitvidsignore' );
                $( '#content' ).fitVids();
            }
            $( document ).ajaxSuccess( fitVidsAjaxSuccess );
        }

        /*--------------------------------------------------------------------------------------------------------
         3.7 - Infinite Scroll
         --------------------------------------------------------------------------------------------------------*/

        if ( $( '#masthead' ).data( 'infinite' ) == 'on' ) {
            var is_activity_loading = false;//We'll use this variable to make sure we don't send the request again and again.

            jq( document ).on( 'scroll', function () {
                //Find the visible "load more" button.
                //since BP does not remove the "load more" button, we need to find the last one that is visible.
                var load_more_btn = jq( ".load-more:visible" );
                //If there is no visible "load more" button, we've reached the last page of the activity stream.
                if ( !load_more_btn.get( 0 ) )
                    return;

                //Find the offset of the button.
                var pos = load_more_btn.offset();

                //If the window height+scrollTop is greater than the top offset of the "load more" button, we have scrolled to the button's position. Let us load more activity.
                //            console.log(jq(window).scrollTop() + '  '+ jq(window).height() + ' '+ pos.top);

                if ( jq( window ).scrollTop() + jq( window ).height() > pos.top ) {

                    load_more_activity();
                }

            } );

            /**
             * This routine loads more activity.
             * We call it whenever we reach the bottom of the activity listing.
             *
             */
            function load_more_activity() {

                //Check if activity is loading, which means another request is already doing this.
                //If yes, just return and let the other request handle it.
                if ( is_activity_loading )
                    return false;

                //So, it is a new request, let us set the var to true.
                is_activity_loading = true;

                //Add loading class to "load more" button.
                //Theme authors may need to change the selector if their theme uses a different id for the content container.
                //This is designed to work with the structure of bp-default/derivative themes.
                //Change #content to whatever you have named the content container in your theme.
                jq( "#content li.load-more" ).addClass( 'loading' );


                if ( null == jq.cookie( 'bp-activity-oldestpage' ) )
                    jq.cookie( 'bp-activity-oldestpage', 1, {
                        path: '/'
                    } );

                var oldest_page = ( jq.cookie( 'bp-activity-oldestpage' ) * 1 ) + 1;

                //Send the ajax request.
                jq.post( ajaxurl, {
                    action: 'activity_get_older_updates',
                    'cookie': encodeURIComponent( document.cookie ),
                    'page': oldest_page
                },
                function ( response )
                {
                    jq( ".load-more" ).hide();//Hide any "load more" button.
                    jq( "#content li.load-more" ).removeClass( 'loading' );//Theme authors, you may need to change #content to the id of your container here, too.

                    //Update cookie...
                    jq.cookie( 'bp-activity-oldestpage', oldest_page, {
                        path: '/'
                    } );

                    //and append the response.
                    jq( "#content ul.activity-list" ).append( response.contents );

                    //Since the request is complete, let us reset is_activity_loading to false, so we'll be ready to run the routine again.

                    is_activity_loading = false;
                }, 'json' );

                return false;

            }
        }

        /*--------------------------------------------------------------------------------------------------------
         3.8 - Switch Layout
         --------------------------------------------------------------------------------------------------------*/
        if ( is_mobile ) {
            $( '#switch_mode' ).val( 'desktop' );
            $( '#switch_submit' ).val( translation.view_desktop );
        } else {
            $( '#switch_mode' ).val( 'mobile' );
            $( '#switch_submit' ).val( translation.view_mobile );
        }

        $( '#switch_submit' ).click( function () {
            $.cookie( 'switch_mode', $( '#switch_mode' ).val(), { path: '/' } );
        } );

        /*--------------------------------------------------------------------------------------------------------
         3.9 - Search
         --------------------------------------------------------------------------------------------------------*/

        var $search_form = $( '#header-search' ).find( 'form' );

        $( '#search-open' ).click( function ( e ) {
            e.preventDefault();
            $search_form.fadeIn();
            setTimeout( function () {
                $search_form.find( '#s' ).focus();
            }, 301 );
        } );

        $( '#search-close' ).click( function ( e ) {
            e.preventDefault();
            $search_form.fadeOut();
        } );

        $( document ).click( function ( e )
        {
            var container = $( "#header-search" );

            if ( !container.is( e.target ) // if the target of the click isn't the container...
                && container.has( e.target ).length === 0 ) // ... nor a descendant of the container
            {
                $search_form.fadeOut();
            }
        } );

        function search_width() {
            var buttons_width = 0;

            $( '#header-search' ).nextAll( 'div, a' ).each( function () {
                buttons_width = buttons_width + $( this ).width();
            } );

            $search_form.width( $( '.header-wrapper' ).width() - $( '#logo-area' ).width() - buttons_width );
        }

        search_width();
        $window.resize( function () {
//            setTimeout(function(){
            search_width();
//            }, 10);
        } );

        //BuddyBoss Inbox Additional Label Functionality Code

        jQuery( document ).on( 'click', '.bb-add-label-button', function ( e ) {
            e.preventDefault();

            _this = jQuery( this );

            _this.find( ".fa-spin" ).fadeOut();

            var label_name = jQuery( '.bb-label-name' ).val();
            var data = {
                action: 'bbm_label_ajax',
                task: 'add_new_label',
                thread_id: 0,
                label_name: label_name
            };

            jQuery.post( ajaxurl, data, function ( response ) {

                _this.find( ".fa-spin" ).fadeIn();

                var response = jQuery.parseJSON( response );

                if ( response.label_id != '' ) {

                    jQuery( ".bb-label-container" ).load( window.location.href + " .bb-label-container", function () {
                        jQuery( ".bb-label-container > .bb-label-container" ).attr( "class", "" );
                    } );

                }

                if ( typeof response.message == 'undefined' ) {
                    return false;
                }

                if ( response.message != '' ) {
                    alert( response.message );
                }

            } );
        } );

        jQuery( document ).on( "keydown", ".bb-label-name", function ( e ) {
            if ( e.keyCode == 13 ) {
                jQuery( ".bb-add-label-button" ).click();
            }
        } );

        /*--------------------------------------------------------------------------------------------------------
         3.9 - Sidebar
         --------------------------------------------------------------------------------------------------------*/
        if ( !is_mobile ) {
            $( '#trigger-sidebar' ).click( function ( e ) {
                e.preventDefault();
                $( 'body' ).toggleClass( 'bb-sidebar-on' );
            } );
        }

        /*--------------------------------------------------------------------------------------------------------
         3.14 - To Top Button
         --------------------------------------------------------------------------------------------------------*/
        //Scroll Effect
        $( '.to-top' ).bind( 'click', function ( event ) {

            event.preventDefault();

            var $anchor = $( this );

            //, 'easeInOutExpo'
            $( 'html, body' ).stop().animate( {
                scrollTop: "0px"
            }, 500 );

        } );

        // Sticky Header
        var topSpace = 0;
        if ( $( '#wpadminbar' ).is( ':visible' ) ) {
            topSpace = 32;
        }

        $( '.sticky-header #masthead' ).sticky( { topSpacing: topSpace } );

        /*--------------------------------------------------------------------------------------------------------
         3.15 - Friends Lists
         --------------------------------------------------------------------------------------------------------*/
        $document.ajaxComplete( function () {
            $( 'ul.horiz-gallery h5, ul#group-admins h5, ul#group-mods h5' ).each( function () {
                $( this ).css( {
                    left: -$( this ).width() / 2 + 25
                } );
            } );
        } );

        $( '.trigger-filter' ).click( function () {
            $( this ).next().fadeToggle( 200 );
            $( this ).toggleClass( 'notactive active' );
        } );

        /*--------------------------------------------------------------------------------------------------------
         3.16 - Profile Settings Radio Buttons
         --------------------------------------------------------------------------------------------------------*/
        $( '#buddypress table.notification-settings .yes input[type="radio"]' ).after( '<label>' + translation.yes + '</label>' );
        $( '#buddypress table.notification-settings .no input[type="radio"]' ).after( '<label>' + translation.no + '</label>' );

        /*--------------------------------------------------------------------------------------------------------
         3.17 - 404 carousel posts
         --------------------------------------------------------------------------------------------------------*/

        function initFullwidthCarousel() {
            $( '#posts-carousel ul' ).carouFredSel( {
                responsive: true,
                width: '100%',
                items: {
                    width: 310,
                    visible: {
                        min: 1,
                        max: 1
                    }
                },
                swipe: {
                    onTouch: true,
                    onMouse: true
                },
                scroll: {
                    items: 1,
                    fx: 'crossfade'
                },
                auto: false,
                prev: {
                    button: function () {
                        return $( this ).closest( '#posts-carousel' ).find( '#prev' );
                    },
                    key: "left"
                },
                next: {
                    button: function () {
                        return $( this ).closest( '#posts-carousel' ).find( '#next' );
                    },
                    key: "right"
                }
            } );

        }
        if ( $( '#posts-carousel' ).length > 0 ) {
            initFullwidthCarousel();
        }

        /*--------------------------------------------------------------------------------------------------------
         3.18 - Testimonials
         --------------------------------------------------------------------------------------------------------*/

        //Set testimonial item active on mousehover( hoverIntent ) :)
        function setActiveTestimonials() {
            $( ".testimonials-wrap" ).each( function () {
                var t = $( this ),
                    n = t.find( ".author-images" ),
                    r = t.find( ".testimonial-items" );
                n.find( "span" ).hoverIntent( function () {
                    var t = $( this ).attr( "data-id" ),
                        n = r.find( 'div[id^="' + t + '"]' ),
                        i = n.outerHeight() + 30;
                    $( this ).parent().siblings( "li" ).removeClass( "active-test-item" ).end().addClass( "active-test-item" );
                    r.css( "height", i );
                    r.find( ".testimonial" ).removeClass( "active-test" );
                    n.addClass( "active-test" );
                } );
            } );
        }

        $( window ).resize( setActiveTestimonials );

        //Init testimonial slider and set the first item as an active
        function initTestimonials() {
            $( ".testimonials-wrap" ).each( function () {
                var t = $( this ),
                    n = t.find( ".author-images" ),
                    r = t.find( ".testimonial-items" );

                //Set first item as an active
                n.find( "li" ).first().addClass( "active-test-item" );
                r.css( "height", r.find( ".testimonial" ).first().outerHeight() + 30 );
                r.find( ".testimonial" ).first().addClass( "active-test" );
            } );
        }

        initTestimonials();

        /*--------------------------------------------------------------------------------------------------------
         3.18 - BuddyPanel bubbles
         --------------------------------------------------------------------------------------------------------*/

        function setCounters() {
            $( '#wp-admin-bar-my-account-buddypress' ).find( 'li' ).each( function () {
                var $this = $( this ),
                    $count = $this.children( 'a' ).children( '.count' ),
                    id,
                    $target;

                if ( $count.length != 0 ) {
                    id = $this.attr( 'id' );
                    $target = $( '.bp-menu.bp-' + id.replace( /wp-admin-bar-my-account-/, '' ) + '-nav' );
                    if ( $target.find( '.count' ).length == 0 ) {
                        $target.find( 'a' ).append( '<span class="count">' + $count.html() + '</span>' );
                    }
                }
            } );
        }

        setCounters();

        /*--------------------------------------------------------------------------------------------------------
         3.20 - Post activity
         --------------------------------------------------------------------------------------------------------*/
        var $whats_form = $( '#whats-new-form' );

        $( '#whats-new-header-content' ).click( function () {
            $whats_form.toggleClass();
            if ( !$whats_form.hasClass( 'isCollapsed' ) ) {
                var content = $( '#whats-new' ).val();
                content = content.trim();

                $( '#whats-new' ).val( content ).focus();
            }
        } );

        if ( $( '#whats-new' ).size() > 0 ) {
            var whats_content = $( '#whats-new' ).val();
            whats_content = whats_content.trim();

            if ( whats_content !== '' ) {
                setTimeout( function () {
                    $( '#whats-new-header-content' ).trigger( 'click' );
                }, 600 );
            }
        }

        $( '#aw-whats-new-submit' ).on( 'click', function () {
            $( '#whats-new' ).attr( 'placeholder', '' );
            $( '.boss-insert-video' ).show();
        } );

        $( '#whats-new-close' ).click( function () {
            $whats_form.addClass( 'isCollapsed' );
            $( '#whats-new-form' ).removeClass( 'boss-show-buttons' );
        } );

        $( '.boss-author-info' ).on( 'click', function () {
            $( this ).parents( '.boss-create-post-wrapper' ).toggleClass( 'isCollapsed' );
        } );

        $( '.boss-close-create-post' ).on( 'click', function ( e ) {
            e.preventDefault();
            $( '.boss-create-post-wrapper' ).removeClass( 'isCollapsed' );
        } );

        $( document ).keyup( function ( e ) {
            if ( e.keyCode === 27 ) {
                // escape key maps to keycode `27`
                if ( ( '.boss-close-create-post' ).length ) {
                    $( '.boss-close-create-post' ).trigger( 'click' );
                }

                $whats_form.addClass( 'isCollapsed' );
                $( '#whats-new-form' ).removeClass( 'boss-show-buttons' );
            }
        } );

        $( document ).on( 'mouseup', '.boss-create-post-wrapper', function ( e ) {
            var container = $( ".boss-create-post-wrapper" );

            /* if the target of the click isn't the container */
            /* Nor a descendant of the container */

            if ( !container.is( e.target ) && container.has( e.target ).length === 0 ) {
                container.removeClass( 'isCollapsed' );
            }
        } );

        /*------------------------------------------------------------------------------------------------------
         3.21 - Post activity buttons and selects
         --------------------------------------------------------------------------------------------------------*/

        $( '#buddyboss-media-add-photo' ).insertAfter( '#whats-new-close' );
        $( '#whats-new-selects' ).prepend( $( '#activity-visibility' ) );

        /*--------------------------------------------------------------------------------------------------------
         3.22 - Group Join button clip text
         --------------------------------------------------------------------------------------------------------*/

        $( '.inner-avatar-wrap' ).find( 'a.group-button' ).each( function () {
            var oldText = $( this ).text();
            $( this ).text( oldText.substring( 0, oldText.indexOf( " " ) ) );
        } );

        /*--------------------------------------------------------------------------------------------------------
         3.25 - Better Radios and Checkboxes Styling
         --------------------------------------------------------------------------------------------------------*/
        function initCheckboxes() {
            if ( !inputsEnabled ) {
                //only few buddypress and bbpress related fields
                $( '#frm_buddyboss-media-tag-friends input[type="checkbox"], #buddypress table.notifications input, #send_message_form input[type="checkbox"], #profile-edit-form input[type="checkbox"],  #profile-edit-form input[type="radio"], #message-threads input, #settings-form input[type="radio"], #create-group-form input[type="radio"], #create-group-form input[type="checkbox"], #invite-list input[type="checkbox"], #group-settings-form input[type="radio"], #group-settings-form input[type="checkbox"], #new-post input[type="checkbox"], .bbp-form input[type="checkbox"], .bbp-form .input[type="radio"], .register-section .input[type="radio"], .register-section input[type="checkbox"], .message-check, #select-all-messages' ).each( function () {
                    var $this = $( this );
                    $this.addClass( 'styled' );
                    if ( $this.next( "label" ).length == 0 && $this.next( "strong" ).length == 0 ) {
                        $this.after( '<strong></strong>' );
                    }
                } );
            } else {
                //all fields
                $( 'input[type="checkbox"], input[type="radio"]' ).each( function () {
                    var $this = $( this );
                    if ( $this.val() == 'gf_other_choice' ) {
                        $this.addClass( 'styled' );
                        $this.next().wrap( '<strong class="other-option"></strong>' );
                    } else {
                        if ( !$this.parents( '#bp-group-documents-form' ).length ) {
                            $this.addClass( 'styled' );
                            if ( $this.next( "label" ).length == 0 && $this.next( "strong" ).length == 0 ) {
                                $this.after( '<strong></strong>' );
                            }
                        }
                    }
                } );
            }
        }

        initCheckboxes();

        $( document ).ajaxSuccess( function () {
            initCheckboxes();
        } );

//        $('#buddypress table.notification-settings td input').after('<label></label>');
        $( '#buddypress table.notifications input' ).after( '<strong></strong>' );

        if ( $( '#groupblog-member-options' ).length ) {
            $( '#groupblog-member-options > input[type="radio"]' ).each( function () {
                $( this ).next( 'span' ).andSelf().wrapAll( '<div class="member-options-wrap"/>' );
            } );
        }

        $( ".header-notifications .pending-count" ).html( '<b>' + jQuery( ".header-notifications .pending-count" ).html() + '</b>' );

        /*--------------------------------------------------------------------------------------------------------
         3.27 - Account Menu PopUp On Touch For Tablets
         --------------------------------------------------------------------------------------------------------*/
        $( '.tablet .header-account-login' ).on( "click touch", function ( e ) {
            $( this ).find( '.pop' ).toggleClass( 'hover' );
        } );

        $( '.tablet .header-account-login > a' ).on( "click touch", function ( e ) {
            e.preventDefault();
        } );
        /*--------------------------------------------------------------------------------------------------------
         3.28 - BuddyPress Group Email Subscription
         --------------------------------------------------------------------------------------------------------*/

        $( '#item-meta .group-subscription-options-link' ).on( "click", function () {
            stheid = $( this ).attr( 'id' ).split( '-' );
            group_id = stheid[1];
            $( '.group-subscription-options' ).slideToggle();
        } );

        $( '#item-meta .group-subscription-close' ).on( "click", function () {
            stheid = $( this ).attr( 'id' ).split( '-' );
            group_id = stheid[1];
            $( '.group-subscription-options' ).slideToggle();
        } );

        /*--------------------------------------------------------------------------------------------------------
         3.29 - Cart Dropdown
         --------------------------------------------------------------------------------------------------------*/

        $( document ).on( 'change', '#calc_shipping_country', function () {
            var $field = $( '#calc_shipping_state_field' );
            if ( $field.find( 'input' ).length > 0 ) {
                $field.addClass( 'plain-input' );
            } else {
                $field.removeClass( 'plain-input' );
            }
        } );

        /*------------------------------------------------------------------------------------------------------
         Heartbeat functions
         --------------------------------------------------------------------------------------------------------*/

        //Notifications related updates
        $( document ).on( 'heartbeat-tick.bb_notification_count', function ( event, data ) {
            setCounters();

            if ( data.hasOwnProperty( 'bb_notification_count' ) ) {
                data = data['bb_notification_count'];
                /********notification type**********/
                if ( data.notification > 0 ) { //has count
                    jQuery( "#ab-pending-notifications" ).html( '<b>' + data.notification + '</b>' ).removeClass( "no-alert" );
                    jQuery( "#ab-pending-notifications-mobile" ).html( '<b>' + data.notification + '</b>' ).removeClass( "no-alert" );
                    jQuery( ".ab-item[href*='/notifications/']" ).each( function () {
                        jQuery( this ).append( "<span class='count'><b>" + data.notification + "</b></span>" );
                        if ( jQuery( this ).find( ".count" ).length > 1 ) {
                            jQuery( this ).find( ".count" ).first().remove(); //remove the old one.
                        }
                    } );
                } else {
                    jQuery( "#ab-pending-notifications" ).html( '<b>' + data.notification + '</b>' ).addClass( "no-alert" );
                    jQuery( "#ab-pending-notifications-mobile" ).html( '<b>' + data.notification + '</b>' ).addClass( "no-alert" );
                    jQuery( ".ab-item[href*='/notifications/']" ).each( function () {
                        jQuery( this ).find( ".count" ).remove();
                    } );
                }
                //remove from read ..
                jQuery( ".mobile #wp-admin-bar-my-account-notifications-read, #adminbar-links #wp-admin-bar-my-account-notifications-read" ).each( function () {
                    $( this ).find( "a" ).find( ".count" ).remove();
                } );
                /**********messages type************/
                if ( data.unread_message > 0 ) { //has count
                    jQuery( "#user-messages" ).find( "span" ).html( '<b>' + data.unread_message + '</b>' ).removeClass( "no-alert" );
                    jQuery( ".ab-item[href*='/messages/']" ).each( function () {
                        jQuery( this ).append( "<span class='count'><b>" + data.unread_message + "</b></span>" );
                        if ( jQuery( this ).find( ".count" ).length > 1 ) {
                            jQuery( this ).find( ".count" ).first().remove(); //remove the old one.
                        }
                    } );
                } else {
                    jQuery( "#user-messages" ).find( "span" ).html( '<b>' + data.unread_message + '</b>' ).addClass( "no-alert" );
                    jQuery( ".ab-item[href*='/messages/']" ).each( function () {
                        jQuery( this ).find( ".count" ).remove();
                    } );
                }
                //remove from unwanted place ..
                jQuery( ".mobile #wp-admin-bar-my-account-messages-default, #adminbar-links #wp-admin-bar-my-account-messages-default" ).find( "li:not('#wp-admin-bar-my-account-messages-inbox')" ).each( function () {
                    jQuery( this ).find( "span" ).remove();
                } );
                /**********messages type************/
                if ( data.friend_request > 0 ) { //has count
                    jQuery( ".ab-item[href*='/friends/']" ).each( function () {
                        jQuery( this ).append( "<span class='count'><b>" + data.friend_request + "</b></span>" );
                        if ( jQuery( this ).find( ".count" ).length > 1 ) {
                            jQuery( this ).find( ".count" ).first().remove(); //remove the old one.
                        }
                    } );
                } else {
                    jQuery( ".ab-item[href*='/friends/']" ).each( function () {
                        jQuery( this ).find( ".count" ).remove();
                    } );
                }
                //remove from unwanted place ..
                jQuery( ".mobile #wp-admin-bar-my-account-friends-default, #adminbar-links #wp-admin-bar-my-account-friends-default" ).find( "li:not('#wp-admin-bar-my-account-friends-requests')" ).each( function () {
                    jQuery( this ).find( "span" ).remove();
                } );

                //notification content
                jQuery( "#all-notificatios .pop" ).html( data.notification_content );
            }
        } );


    }

    /*================================================================================================
     ** Cover Photo Functions **
     ==================================================================================================*/

    buddyboss_cover_photo = function ( option ) {

        $bb_cover_photo = $( "#page .bb-cover-photo:last" );
        object = $bb_cover_photo.data( "obj" ); // user or group
        object_id = $bb_cover_photo.data( "objid" ); // id of user or group
        nonce = $bb_cover_photo.data( "nonce" );
        $refresh_button = $( "#refresh-cover-photo-btn" );

        rebind_refresh_cover_events = function () {
            $refresh_button.click( function () {
                $( '.bb-cover-photo #growls' ).remove();
                $( "#update-cover-photo-btn" ).prop( "disabled", true ).removeClass( 'uploaded' ).addClass( 'disabled' ).find( "i" ).fadeIn();
                $refresh_button.prop( "disabled", true ).removeClass( 'uploaded' ).addClass( 'disabled' ).find( "i" ).fadeIn();

                $.ajax( {
                    type: "POST",
                    url: ajaxurl,
                    data: {
                        'action': 'buddyboss_cover_photo_refresh',
                        'object': object,
                        'object_id': object_id,
                        'nonce': option.nonce,
                        'routine': $refresh_button.data( 'routine' )
                    },
                    success: function ( response ) {
                        var responseJSON = $.parseJSON( response );

                        $( "#update-cover-photo-btn" ).prop( "disabled", false ).removeClass( 'disabled' ).addClass( 'uploaded' ).find( "i.fa-spin" ).fadeOut();
                        $refresh_button.prop( "disabled", false ).removeClass( 'disabled' ).addClass( 'uploaded' ).find( "i.fa-spin" ).fadeOut();

                        if ( !responseJSON ) {
                            $.growl.error( { title: "", message: BuddyBossOptions.bb_cover_photo_failed_refresh } );
                        }

                        if ( responseJSON.error ) {
                            $.growl.error( { title: "", message: responseJSON.error } );
                        } else {
                            $bb_cover_photo.find( ".holder" ).remove();

                            image = responseJSON.image;
                            $bb_cover_photo.append( '<div class="holder"></div>' );
                            $bb_cover_photo.find( ".holder" ).css( "background-image", 'url(' + image + ')' );

                            if ( 'refresh' == $refresh_button.data( 'routine' ) ) {
                                $refresh_button.parent().toggleClass( 'no-photo' );
                                $refresh_button.find( '.fa-refresh' ).removeClass( 'fa-refresh' ).addClass( 'fa-times' );
                                $refresh_button.find( '>div' ).html( BuddyBossOptions.bb_cover_photo_remove_title + '<i class="fa fa-spinner fa-spin" style="display: none;"></i>' );
                                $refresh_button.attr( 'title', BuddyBossOptions.bb_cover_photo_remove_title );
                                $refresh_button.data( 'routine', 'remove' );
                            } else {
                                $refresh_button.parent().toggleClass( 'no-photo' );
                                $refresh_button.find( '.fa-times' ).removeClass( 'fa-times' ).addClass( 'fa-refresh' );
                                $refresh_button.find( '>div' ).html( BuddyBossOptions.bb_cover_photo_refresh_title + '<i class="fa fa-spinner fa-spin" style="display: none;"></i>' );
                                $refresh_button.attr( 'title', BuddyBossOptions.bb_cover_photo_refresh_title );
                                $refresh_button.data( 'routine', 'refresh' );
                            }
                            $.growl.notice( { title: "", message: responseJSON.success } );
                        }
                    },
                    error: function ( ) {
                        $bb_cover_photo.find( ".progress" ).hide().find( "span" ).css( "width", '0%' );

                        $.growl.error( { message: 'Error' } );
                    }
                } );
            } );
        };

        if ( $refresh_button.length > 0 ) {
            rebind_refresh_cover_events();
        }
    }

    /** --------------------------------------------------------------- */

    /**
     * BuddyPress Legacy Support
     */

    // Initialize
    BP_Legacy.init = function () {
        BP_Legacy.injected = false;
        _l.$document.ready( BP_Legacy.domReady );
    }

    // On dom ready we'll check if we need legacy BP support
    BP_Legacy.domReady = function () {
        BP_Legacy.check();
    }

    // Check for legacy support
    BP_Legacy.check = function () {
        if ( !BP_Legacy.injected && _l.body.hasClass( 'buddypress' ) && _l.$buddypress.length == 0 ) {
            BP_Legacy.inject();
        }
    }

    // Inject the right code depending on what kind of legacy support
    // we deduce we need
    BP_Legacy.inject = function () {
        BP_Legacy.injected = true;

        var $secondary = $( '#secondary' ),
            do_legacy = false;

        var $content = $( '#content' ),
            $padder = $content.find( '.padder' ).first(),
            do_legacy = false;

        var $article = $content.children( 'article' ).first();

        var $legacy_page_title,
            $legacy_item_header;

        // Check if we're using the #secondary widget area and add .bp-legacy inside that
        if ( $secondary.length ) {
            $secondary.prop( 'id', 'secondary' ).addClass( 'bp-legacy' );

            do_legacy = true;
        }

        // Check if the plugin is using the #content wrapper and add #buddypress inside that
        if ( $padder.length ) {
            $padder.prop( 'id', 'buddypress' ).addClass( 'bp-legacy entry-content' );

            do_legacy = true;

            // console.log( 'Buddypress.js #buddypress fix: Adding #buddypress to .padder' );
        }
        else if ( $content.length ) {
            //$content.wrapInner( '<div class="bp-legacy entry-content" id="buddypress"/>' );

            do_legacy = true;

            // console.log( 'Buddypress.js #buddypress fix: Dynamically wrapping with #buddypresss' );
        }

        // Apply legacy styles if needed
        if ( do_legacy ) {

            _l.$buddypress = $( '#buddypress' );

            $legacy_page_title = $( '.buddyboss-bp-legacy.page-title' );
            $legacy_item_header = $( '.buddyboss-bp-legacy.item-header' );

            // Article Element
            if ( $article.length === 0 ) {
                $content.wrapInner( '<article/>' );
                $article = $( $content.find( 'article' ).first() );
            }

            // Page Title
            if ( $content.find( '.entry-header' ).length === 0 || $content.find( '.entry-title' ).length === 0 ) {
                $legacy_page_title.prependTo( $article ).show();
                $legacy_page_title.children().unwrap();
            }

            // Item Header
            if ( $content.find( '#item-header-avatar' ).length === 0 && _l.$buddypress.find( '#item-header' ).length ) {
                $legacy_item_header.prependTo( _l.$buddypress.find( '#item-header' ) ).show();
                $legacy_item_header.children().unwrap();
            }
        }
    }

    // Boot er' up
    jQuery( document ).ready( function () {
        App.init();
    } );

}( jQuery, window ) );


/**
 * 3. Inline Plugins
 * ====================================================================
 * Inline Plugins
 */


/**
 * jRMenuMore to allow menu to have a More option for responsiveness
 * Credit to http://blog.sodhanalibrary.com/2014/02/jrmenumore-jquery-plugin-for-responsive.html
 *
 * uses resize.js for better resizing
 *
 **/
( function ( $ ) {
    $.fn.jRMenuMore = function ( widthfix ) {
        $( this ).each( function () {
            $( this ).addClass( "horizontal-responsive-menu" );
            alignMenu( this );
            var robj = this;

            $( '#main-wrap' ).resize( function () {
                $( robj ).append( $( $( $( robj ).children( "li.hideshow" ) ).children( "ul" ) ).html() );
                $( robj ).children( "li.hideshow" ).remove();
                alignMenu( robj );
            } );

            function alignMenu( obj ) {
                var w = 0;
                var mw = $( obj ).width() - widthfix;
                var i = -1;
                var menuhtml = '';
                jQuery.each( $( obj ).children(), function () {
                    i++;
                    w += $( this ).outerWidth( true );
                    if ( mw < w ) {
                        menuhtml += $( '<div>' ).append( $( this ).clone() ).html();
                        $( this ).remove();
                    }
                } );

                $( obj ).append(
                    '<li class="hideshow">' +
                    '<a class="bb-menu-button" href="#"><i class="fa"></i></a><ul>' +
                    menuhtml + '</ul></li>' );
                $( obj ).children( "li.hideshow ul" ).css( "top",
                    $( obj ).children( "li.hideshow" ).outerHeight( true ) + "px" );

                $( obj ).find( "li.hideshow > a" ).click( function ( e ) {
                    e.preventDefault();
                    $( this ).parent( 'li.hideshow' ).children( "ul" ).toggle();
                    $( this ).parent( 'li.hideshow' ).parent( "ul" ).toggleClass( 'open' );
                } );

                $( document ).mouseup( function ( e ) {
                    var container = $( 'li.hideshow' );

                    if ( !container.is( e.target ) && container.has( e.target ).length === 0 ) {
                        container.children( "ul" ).hide();
                        container.parent( "ul" ).removeClass( 'open' );
                    }
                } );

                if ( $( obj ).find( "li.hideshow" ).find( "li" ).length > 0 ) {
                    $( obj ).find( "li.hideshow" ).show();
                } else {
                    $( obj ).find( "li.hideshow" ).hide();
                }
            }

        } );

    }

}( jQuery ) );

/*------------------------------------------------------------------------------------------------------
 Inline Plugins
 --------------------------------------------------------------------------------------------------------*/

/*
 * jQuery Mobile Plugin: jQuery.Event.Special.Fastclick
 * http://nischenspringer.de/jquery/fastclick
 *
 * Copyright 2013 Tobias Plaputta
 * Released under the MIT license.
 * http://nischenspringer.de/license
 *
 */
;
( function ( e ) {
    var t = e( [ ] ), n = 800, r = 30, i = 10, s = [ ], o = { };
    var u = function ( e ) {
        var t, n;
        for ( t = 0, n = s.length; t < n; t++ ) {
            if ( Math.abs( e.pageX - s[t].x ) < r && Math.abs( e.pageY - s[t].y ) < r ) {
                e.stopImmediatePropagation();
                e.stopPropagation();
                e.preventDefault()
            }
        }
    };
    var a = true;
    if ( Modernizr && Modernizr.hasOwnProperty( "touch" ) ) {
        a = Modernizr.touch
    }
    var f = function () {
        s.splice( 0, 1 )
    };
    e.event.special.fastclick = { touchstart: function ( t ) {
            o.startX = t.originalEvent.touches[0].pageX;
            o.startY = t.originalEvent.touches[0].pageY;
            o.hasMoved = false;
            e( this ).on( "touchmove", e.event.special.fastclick.touchmove )
        }, touchmove: function ( t ) {
            if ( Math.abs( t.originalEvent.touches[0].pageX - o.startX ) > i || Math.abs( t.originalEvent.touches[0].pageX - o.startY ) > i ) {
                o.hasMoved = true;
                e( this ).off( "touchmove", e.event.special.fastclick.touchmove )
            }
        }, add: function ( t ) {
            if ( !a ) {
                return
            }
            var r = e( this );
            r.data( "objHandlers" )[t.guid] = t;
            var i = t.handler;
            t.handler = function ( t ) {
                r.off( "touchmove", e.event.special.fastclick.touchmove );
                if ( !o.hasMoved ) {
                    s.push( { x: o.startX, y: o.startY } );
                    window.setTimeout( f, n );
                    var u = this;
                    var a = e( [ ] );
                    var l = arguments;
                    e.each( r.data( "objHandlers" ), function () {
                        if ( !this.selector ) {
                            if ( r[0] == t.target || r.has( t.target ).length > 0 )
                                i.apply( r, l )
                        } else {
                            e( this.selector, r ).each( function () {
                                if ( this == t.target || e( this ).has( t.target ).length > 0 )
                                    i.apply( this, l )
                            } )
                        }
                    } )
                }
            }
        }, setup: function ( n, r, i ) {
            var s = e( this );
            if ( !a ) {
                s.on( "click", e.event.special.fastclick.handler );
                return
            }
            t = t.add( s );
            if ( !s.data( "objHandlers" ) ) {
                s.data( "objHandlers", { } );
                s.on( "touchstart", e.event.special.fastclick.touchstart );
                s.on( "touchend touchcancel", e.event.special.fastclick.handler )
            }
            if ( !o.ghostbuster ) {
                e( document ).on( "click vclick", u );
                o.ghostbuster = true
            }
        }, teardown: function ( n ) {
            var r = e( this );
            if ( !a ) {
                r.off( "click", e.event.special.fastclick.handler );
                return
            }
            t = t.not( r );
            r.off( "touchstart", e.event.special.fastclick.touchstart );
            r.off( "touchmove", e.event.special.fastclick.touchmove );
            r.off( "touchend touchcancel", e.event.special.fastclick.handler );
            if ( t.length == 0 ) {
                e( document ).off( "click vclick", u );
                o.ghostbuster = false
            }
        }, remove: function ( t ) {
            if ( !a ) {
                return
            }
            var n = e( this );
            delete n.data( "objHandlers" )[t.guid]
        }, handler: function ( t ) {
            var n = t.type;
            t.type = "fastclick";
            e.event.trigger.call( this, t, { }, this, true );
            t.type = n
        } }
} )( jQuery )
