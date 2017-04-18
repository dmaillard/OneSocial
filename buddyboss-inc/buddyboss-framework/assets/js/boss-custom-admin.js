( function ( $ ) {

    "use strict";

    window.onesocialAdmin = {
        init: function () {
            this.managePlugins();
            this.importExportInfo();
            this.headers();
        },
        managePlugins: function () {

            // Make full width content
            $( '.boss-manage-plugin, .boss-support-area' ).parents( '.form-table' ).find( 'th' ).css( { 'padding': '0', 'width': '0' } );

            var elemItem = $( '.boss-manage-plugin  a.boss-manage-plugin-action' );

            elemItem.click( function ( e ) {

                var elem = $( this ),
                    plugin_action = elem.data( 'action' ),
                    plugin_title = elem.data( 'plugin-title' );

                if ( plugin_action === 'purchase' ) {
                    return true;
                } else {
                    e.preventDefault();
                }

                if ( elem.hasClass( 'delete' ) && !confirm( 'Are you sure you want to delete "' + plugin_title + '" plugin' ) ) {
                    return false;
                }

                // Add Loading
                elem.after( '<div class="boss-ajax-loder"></div>' );

                $.ajax( {
                    url: ajaxurl,
                    type: 'post',
                    data: {
                        'action': 'boss_plugin_manage',
                        'plugin_action': $( this ).data( 'action' ),
                        'plugin': $( this ).data( 'plugin' ),
                        'nonce': $( this ).data( 'nonce' )
                    },
                    success: function ( data ) {
                        if ( data.success === false ) {
                            data = ((typeof data.data != "string" || data.data == "0")?"You don't have permission to install plugin.":data.data);
                            alert(data);
                            elem.next().remove();
                        } else {
                            location.reload();
                            $( '.boss-ajax-loder' ).remove();
                        }
                    }
                } );
            } );
        },
        importExportInfo: function () {
            $( '#redux-import-code-button' ).parent().before( '<p class="bb-description">Please click "Reset All" at the top, before doing an import in order for your changes to take effect.</p>' );
        },
        headers: function () {
            jQuery( '#onesocial_options-boss_header li' ).each( function () {
                var curr_el = jQuery( this );
                var scheme_val = jQuery( curr_el ).find( 'input' ).val();
                //console.log(BuddyBossReduxOptions.boss_header);
                if ( scheme_val === BuddyBossReduxOptions.boss_header ) {
                    jQuery( this ).find( 'label' ).addClass( 'redux-image-select-selected' );
                }
            } );
        },
        colorPreset: function () {
            //workaround for redux colorscheme bug
            $( '#onesocial_options-onesocial_scheme_select li' ).each( function () {
                var curr_el = $( this );
                var scheme_val = $( curr_el ).find( 'input' ).val();
                if ( scheme_val === BuddyBossReduxOptions.color_scheme ) {
                    $( this ).find( 'label' ).addClass( 'redux-image-select-selected' );
                }
            } );
        }
    };

    $( document ).on( 'ready', function () {
        onesocialAdmin.init();
    } );

} )( jQuery );