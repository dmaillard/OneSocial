/*------------------------------------------------------------------------------------------------------
 Responsive Dropdowns
 --------------------------------------------------------------------------------------------------------*/

var Selects = {
    $: jQuery,
    $selects: false,
    // On mobile, we add a better select box. This function
    // populates data from the <select> element to it's
    // <label> element which is positioned over the select box.
    populate_select_label: function ( is_mobile ) {
        // Abort when no select elements are found
        if ( !this.$selects || !this.$selects.length ) {
            return;
        }

        // Handle small screens
        //				if ( is_mobile ) {

        this.$selects.each( function ( idx, val ) {
            var $select = $( this ),
                data = $select.data( 'buddyboss-select-info' ),
                $label;

            if ( !data || !data.$label && $select.data( 'state' ) !== 'pass' ) {
                return;
            }

            $label = data.$label;

            if ( $label && $label.length ) {

                $select.data( 'state', 'mobile' );

                $label.text( $select.find( 'option:selected' ).text() ).show();
            }
        } );

    }, // end populate_select_label();


    // On page load we'll go through each select element and make sure
    // we have a label element to accompany it. If not, we'll generate
    // one and add it dynamically.

    // On page load we'll go through each select element and make sure
    // we have a label element to accompany it. If not, we'll generate
    // one and add it dynamically.
    init_select: function ( is_mobile, mode ) {
        var current = 0,
            that = this;

        if ( !mode ) {
            //only few buddypress and bbpress related fields
            this.$selects = $( '.item-list-tabs select, #whats-new-form select, .editfield select, #notifications-bulk-management select, #messages-bulk-management select, .field-visibility select, .register-section select, .bbp-form select, #bp-group-course, #bbp_group_forum_id' );
        } else {
            //all fields
            this.$selects = $( '#page select:not([multiple]):not(#bbwall-privacy-selectbox):not(.bp-ap-selectbox)' ).filter( function () {
                return ( !$( this ).closest( '.frm_form_field' ).length );
            } );
        }

        this.$selects.each( function () {
            var $select = $( this ),
                $wrap, id, $span, $label, dynamic = false, state = 'pass';

            if ( !( $select.data( 'state' ) && $select.data( 'state' ) === 'mobile' ) ) {

                if ( this.style.display === 'none' ) {
                    return;
                }

                $wrap = $( '<div class="buddyboss-select"></div>' );

                if ( $( this ).hasClass( 'large' ) ) {
                    $wrap.addClass( 'large' );
                }

                if ( $( this ).hasClass( 'small' ) ) {
                    $wrap.addClass( 'small' );
                }

                if ( $( this ).hasClass( 'medium' ) ) {
                    $wrap.addClass( 'medium' );
                }

                id = this.getAttribute( 'id' ) || 'buddyboss-select-' + current;
                $span = $select.prev( 'span' );
                $label = $select.prev( 'label' );

                $inner_wrap = $( '<div class="buddyboss-select-inner"></div>' );

                if ( !$span.length ) {
                    $span = $( '<span></span>' ).hide();
                    dynamic = true;
                }

                if ( !$( this ).parent().hasClass( 'buddyboss-select-inner' ) ) {
                    $select.wrap( $wrap );
                    $label.insertBefore( $select );
                    $select.wrap( $inner_wrap );
                    $span.insertBefore( $select );
                }

                // Set data on select element to use later
                $select.data( 'buddyboss-select-info', {
                    dynamic: dynamic,
                    $wrap: $wrap,
                    $label: $span,
                    orig_text: $span.text()
                } );

                state = 'init';
            }

            $select.data( 'state', state );

            // On select change, repopulate label
            $select.on( 'change', function ( e ) {
                that.populate_select_label( is_mobile );
            } );
        } );
    }
};