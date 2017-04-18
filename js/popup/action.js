( function ( $ ) {

    /* DOM Ready */
    $( 'document' ).ready( function () {
        siteInitLogin();
        siteInitRegister();
        lostPassword();
    } );

    /* Login popup */
    function siteInitLogin() {

        /* Initialize Popup */
        onesocialModalPopup( '.onesocial-login-popup-link', '.mfp-content .LoginBox' );

        /* This will open popup on each link of login page */
        $( '.login.header-button' ).click( function ( e ) {
            e.preventDefault();
            $( '.onesocial-login-popup-link' ).trigger( 'click' );
        } );

        $( '#login_button' ).on( 'click', function () {

            var ele_this = $( this );

            /* Show Spinner */
            ele_this.prop( 'disabled', true ).find( '.fa-spin' ).show();

            var dologin = $.post( transport.eh_url_path + "/?ajax-login",
                {
                    'ajax-login-security': $( "#ajax-login-security" ).val(),
                    'username': $( "#login_username" ).val(),
                    "password": $( "#login_password" ).val(),
                    "rememberme": $( "#login_rememberme" ).val()
                }
            );

            /* Login Done Event */
            dologin.done( function ( d ) {
                ele_this.prop( 'disabled', false ).find( '.fa-spin' ).hide();
                $.globalEval( d );
            } );

        } );

        /* Open Register Form */
        $( '.joinbutton' ).on( 'click', function ( e ) {
            e.preventDefault();

            setTimeout( function () {
                $( '.onesocial-register-popup-link' ).trigger( 'click' );
                oneSocialTinyMceFix();
            }, 90 );

            setTimeout( function () {
                $( 'body' ).find( '.mfp-content .RegisterBox' ).addClass( 'go' );
            }, 300 );

        } );

        /* On Enter tirggerd submit login form */
        $( '#siteLoginBox' ).find( 'input' ).keypress( function ( event ) {
            if ( event.which === 13 ) {
                event.preventDefault();
                $( '#login_button' ).click();
            }
        } );
    }

    /* Register popup */
    function siteInitRegister() {

        /* Initialize Popup */
        onesocialModalPopup( '.onesocial-register-popup-link', '.mfp-content .RegisterBox' );

        /* This will open popup on each link of login page */
        $( '.register.header-button' ).click( function ( e ) {
            e.preventDefault();

            setTimeout( function () {
                $( '.onesocial-register-popup-link' ).trigger( 'click' );
                oneSocialTinyMceFix();
            }, 90 );

        } );

        /*$( '#register_button' ).click( function () {

         var ele_this = $( this );

         // Show Spinner
         ele_this.prop( 'disabled', true ).find( '.fa-spin' ).show();

         var $to_send = {
         'ajax-register-security': $( "#ajax-register-security" ).val(),
         'email': $( "#register_email" ).val(),
         'username': $( "#register_username" ).val(),
         "password": $( "#register_password" ).val()
         };

         if($("#as_vendor").length && $("#as_vendor").attr("checked")) {
         $to_send['as_vendor'] = 'true';
         } else {
         $to_send['as_vendor'] = 'false';
         }

         var dologin = $.post( "?ajax-register", $to_send);

         // Login Done Event
         dologin.done( function ( d ) {
         ele_this.prop( 'disabled', false ).find( '.fa-spin' ).hide();
         $.globalEval( d );
         } );

         } );*/

        $( '#register_okay' ).click( function () {
            location.reload();
        } );

        /* Open Login Form */
        $( '.siginbutton' ).click( function ( e ) {
            e.preventDefault();

            setTimeout( function () {
                $( '.onesocial-login-popup-link' ).trigger( 'click' );
            }, 90 );

            setTimeout( function () {
                $( 'body' ).find( '.mfp-content .LoginBox' ).addClass( 'go' );
            }, 300 );

        } );

        /*$( '#register_password, #register_email, #register_username' ).bind( "enterKey", function ( e ) {
         $( "#register_button" ).trigger( 'click' );
         } );

         $( '#register_password, #register_email, #register_username' ).keyup( function ( e ) {
         if ( e.keyCode === 13 ) {
         $( this ).trigger( "enterKey" );
         }
         } );*/

        var frm_siteRegister_ajaxform_options = {
            dataType: 'json',
            currentform: false,
            beforeSubmit: function ( arr, $form, options ) {
                currentform = $form;

                $form.find( '.field_erorr' ).remove();
                /* Show spinner */
                $form.find( '[type="submit"] .fa-spin' ).show();
                $( '#ajax_register_messages' ).html( '' );
            },
            success: function ( response ) {
                /**
                 show success/error message
                 hide loading animation
                 check if success
                 - replace content
                 execute javascript
                 */
                if ( response.message ) {
                    var cssclass = 'ctmessage updated';
                    if ( !response.success ) {
                        cssclass = 'ctmessage error';
                    }

                    $( '#ajax_register_messages' ).html( "<p class='" + cssclass + "'>" + response.message + "</p>" );
                }

                currentform.find( '[type="submit"] .fa-spin' ).hide();
                if ( response.success ) {
                    currentform.find( '.boxcontent' ).html( response.template );
                }

                if ( response.js ) {
                    $.globalEval( response.js );
                }

            },
            error: function ( jqXHR, textStatus, errorThrown ) {
                $( '#ajax_register_messages' ).html( "<p class='alert alert-error'>Error!</p>" );
            }
        };

        $( '#frm_siteRegisterBox' ).ajaxForm( frm_siteRegister_ajaxform_options );

    }

    /* For Lost Password */
    function lostPassword() {

        /* Initialize Popup */
        onesocialModalPopup( '.onesocial-lost-password-popup-link', '.mfp-content .LostPasswordBox' );

        /* This will open popup on each link of login page */
        $( document ).on( 'click', '.boss-modal-form .forgetme, #ajax_login_messages a[href$="lost-password/"]', function ( e ) {
            e.preventDefault();
            $( '.onesocial-lost-password-popup-link' ).trigger( 'click' );

            setTimeout( function () {
                $( 'body' ).find( '.mfp-content .LostPasswordBox' ).addClass( 'go' );
            }, 300 );
        } );

        $( '#lost-pass-button' ).on( 'click', function ( e ) {
            e.preventDefault();

            var message = $( '#siteLostPassword #message' ),
                contents = {
                    action: 'lost_pass',
                    nonce: $( '#rs_user_lost_password_nonce' ).val(),
                    user_login: $( '#user_login' ).val()
                };

            // disable button onsubmit to avoid double submision
            $( this ).attr( 'disabled', 'disabled' ).addClass( 'disabled' );

            // Display our pre-loading
            $( this ).find( '.fa' ).fadeIn();

            $.post( ajaxurl, contents, function ( data ) {
                $( '#lost-pass-button' ).removeAttr( 'disabled' ).removeClass( 'disabled' );

                // hide pre-loader
                $( '#lost-pass-button' ).find( '.fa' ).fadeOut();

                // display return data
                message.html( data );
            } );

            return false;
        } );
    }

    /* Initialize Modal Popup */
    function onesocialModalPopup( elem, modal ) {
        $( elem ).magnificPopup( {
            type: 'inline',
            closeOnBgClick: false,
            closeMarkup: '<button title="%title%" class="mfp-close bb-icon-close"></button>',
            //removalDelay: 400, //delay removal by X to allow out-animation
            callbacks: {
                beforeOpen: function () {
                    this.st.mainClass = 'onesocial-popup';
                },
                open: function () {
                    $( 'body' ).addClass( 'popup-open' );
                    setTimeout( function () {
                        $( 'body' ).find( modal ).addClass( 'go' );
                    }, 300 );
                },
                close: function () {
                    $( 'body' ).removeClass( 'popup-open' );
                    oneSocialTinyMceFix();
                }
            }
        } );
    }

    //Fix: WP_EDITOR on Frontend in modal doesn't work properly
    function oneSocialTinyMceFix() {
        if ( typeof tinyMCE == 'undefined' )
            return;

        try {
            $( '.field_type_textarea' ).each( function () {
                var id = $( this ).find( 'textarea' ).attr( 'id' );
                tinymce.remove( '#' + id );
                tinyMCE.execCommand( 'mceToggleEditor', false, id );
            });
        } catch (e) {

        }

    }

}( jQuery ) );