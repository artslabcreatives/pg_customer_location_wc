<?php
/**
 * PGs by Customer Location from Artslab Creatives for WooCommerce - Functions - Frontend
 *
 * @version 1.5.0
 * @since   1.0.0
 *
 * @author  Algoritmika Ltd.
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'alc_pg_by_location_wc_get_location' ) ) {
	/**
	 * alc_pg_by_location_wc_get_location.
	 *
	 * @version 1.5.0
	 * @since   1.0.0
	 *
	 * @todo    [next] (dev) code refactoring: merge `city` and `postcode`?
	 * @todo    [maybe] (WC version < 3.0.0) recheck if `get_shipping_country()` and `get_shipping_state()` work correctly
	 */
	function alc_pg_by_location_wc_get_location( $type ) {
		$result = false;
		switch ( $type ) {
			case 'country':
				$country_type = get_option( 'alc_pg_by_location_wc_country_type', 'billing' );
				$result = ( 'by_ip' === $country_type ?
					alc_pg_by_location_wc_get_country_by_ip() :
					( isset( WC()->customer ) ? ( 'billing' === $country_type ?
						alc_pg_by_location_wc_customer_get_country() : WC()->customer->get_shipping_country() ) : '' ) );
				break;
			case 'state':
				$result = ( isset( WC()->customer ) ?
					( 'billing' === get_option( 'alc_pg_by_location_wc_state_type', 'billing' ) ?
						alc_pg_by_location_wc_customer_get_state() : WC()->customer->get_shipping_state() ) :
					'' );
				break;
			case 'city':
				$city = '';
				$keys = ( 'billing' === get_option( 'alc_pg_by_location_wc_cities_type', 'billing' ) ?
					array( 'city', 'billing_city' ) : array( 's_city', 'shipping_city' ) );
				foreach ( $keys as $key ) {
					if ( isset( $_REQUEST[ $key ] ) && '' !== $_REQUEST[ $key ] ) {
						$city = $_REQUEST[ $key ];
						break;
					}
				}
				if ( '' === $city ) {
					$city = WC()->countries->get_base_city();
				}
				$result = strtoupper( $city );
				break;
			case 'postcode':
				$postcode = '';
				$keys = ( 'billing' === get_option( 'alc_pg_by_location_wc_postcodes_type', 'billing' ) ?
					array( 'postcode', 'billing_postcode' ) : array( 's_postcode', 'shipping_postcode' ) );
				foreach ( $keys as $key ) {
					if ( isset( $_REQUEST[ $key ] ) && '' !== $_REQUEST[ $key ] ) {
						$postcode = $_REQUEST[ $key ];
						break;
					}
				}
				if ( '' === $postcode ) {
					$postcode = WC()->countries->get_base_postcode();
				}
				$result = strtoupper( $postcode );
				break;
		}
		return apply_filters( 'alc_pg_by_location_wc_get_location', $result, $type );
	}
}

if ( ! function_exists( 'alc_pg_by_location_wc_range_match' ) ) {
	/**
	 * alc_pg_by_location_wc_range_match.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function alc_pg_by_location_wc_range_match( $postcode_range, $postcode_to_check ) {
		$postcode_range = explode( '...', $postcode_range );
		return ( 2 === count( $postcode_range ) && $postcode_to_check >= $postcode_range[0] && $postcode_to_check <= $postcode_range[1] );
	}
}

if ( ! function_exists( 'alc_pg_by_location_wc_check_postcode' ) ) {
	/**
	 * alc_pg_by_location_wc_check_postcode.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function alc_pg_by_location_wc_check_postcode( $postcode_to_check, $postcodes ) {
		foreach ( $postcodes as $postcode ) {
			if (
				( $postcode === $postcode_to_check ) ||
				( false !== strpos( $postcode, '*' )   && fnmatch( $postcode, $postcode_to_check ) ) ||
				( false !== strpos( $postcode, '...' ) && alc_pg_by_location_wc_range_match( $postcode, $postcode_to_check ) )
			) {
				return true;
			}
		}
		return false;
	}
}

if ( ! function_exists( 'alc_pg_by_location_wc_get_country_by_ip' ) ) {
	/**
	 * alc_pg_by_location_wc_get_country_by_ip.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function alc_pg_by_location_wc_get_country_by_ip() {
		// Get the country by IP
		$location = ( class_exists( 'WC_Geolocation' ) ? WC_Geolocation::geolocate_ip() : array( 'country' => '' ) );
		// Base fallback
		if ( empty( $location['country'] ) ) {
			$location = wc_format_country_state_string( apply_filters( 'woocommerce_customer_default_location', get_option( 'woocommerce_default_country' ) ) );
		}
		return ( isset( $location['country'] ) ) ? $location['country'] : '';
	}
}

if ( ! function_exists( 'alc_pg_by_location_wc_customer_get_country' ) ) {
	/**
	 * alc_pg_by_location_wc_customer_get_country.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @todo    [maybe] (WC version < 3.0.0) `WC()->customer->get_country()`
	 */
	function alc_pg_by_location_wc_customer_get_country() {
		return WC()->customer->get_billing_country();
	}
}

if ( ! function_exists( 'alc_pg_by_location_wc_customer_get_state' ) ) {
	/**
	 * alc_pg_by_location_wc_customer_get_state.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @todo    [maybe] (WC version < 3.0.0) `WC()->customer->get_state()`
	 */
	function alc_pg_by_location_wc_customer_get_state() {
		return WC()->customer->get_billing_state();
	}
}

if ( ! function_exists( 'alc_pg_by_location_wc_maybe_add_european_union_countries' ) ) {
	/**
	 * alc_pg_by_location_wc_maybe_add_european_union_countries.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function alc_pg_by_location_wc_maybe_add_european_union_countries( $countries ) {
		if ( ! empty( $countries ) && in_array( 'EU', $countries ) ) {
			$countries = array_merge( $countries, array(
				'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GB', 'GR', 'HU', 'HR', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PL', 'PT', 'RO', 'SE', 'SI', 'SK'
			) );
		}
		return $countries;
	}
}
