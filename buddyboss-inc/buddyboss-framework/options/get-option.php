<?php

/**
 * Get OneSocial theme options
 *
 * @param string $id Option ID.
 * @param string $param Option type.
 *
 * @return $output False on failure, Option.
 */
if ( !function_exists( 'onesocial_get_option' ) ) {

	function onesocial_get_option( $id, $param = null ) {

		global $onesocial_options;

		/* Check if options are set */
		if ( !isset( $onesocial_options ) ) {
			return false;
		}

		/* Check if array subscript exist in options */
		if ( empty( $onesocial_options[ $id ] ) ) {
			return false;
		}

		/**
		 * If $param exists,  then
		 * 1. It should be 'string'.
		 * 2. '$onesocial_options[ $id ]' should be array.
		 * 3. '$param' array key exists.
		 */
		if ( !empty( $param ) && is_string( $param ) && (!is_array( $onesocial_options[ $id ] ) || !array_key_exists( $param, $onesocial_options[ $id ] ) ) ) {
			return false;
		}

		return empty( $param ) ? $onesocial_options[ $id ] : $onesocial_options[ $id ][ $param ];
	}

}