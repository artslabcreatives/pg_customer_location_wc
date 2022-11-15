<?php
/**
 * PGs by Customer Location from Artslab Creatives for WooCommerce - Core Class
 *
 * @version 1.5.0
 * @since   1.0.0
 *
 * @author  Algoritmika Ltd.
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'ALC_PGs_by_Customer_Location_Core' ) ) :

class ALC_PGs_by_Customer_Location_Core {

	/**
	 * Constructor.
	 *
	 * @version 1.1.0
	 * @since   1.0.0
	 *
	 * @todo    [maybe] rename classes `ALC_PGs_by_Customer_Location_Core` to `Alg_WC_PGBCL_Core` etc.
	 */
	function __construct() {
		if ( 'yes' === get_option( 'alc_pg_by_location_wc_plugin_enabled', 'yes' ) ) {
			$this->force_js_checkout_update = get_option( 'alc_pg_by_location_wc_force_js_checkout_update', array() );
			if ( ! empty( $this->force_js_checkout_update ) ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			}
			add_filter( 'woocommerce_available_payment_gateways', array( $this, 'available_payment_gateways' ), PHP_INT_MAX, 1 );
		}
	}

	/**
	 * enqueue_scripts.
	 *
	 * @version 1.2.0
	 * @since   1.1.0
	 */
	function enqueue_scripts() {
		wp_enqueue_script( 'alg-wc-pgbcl-js',
			alc_pg_by_location_wc()->plugin_url() . '/includes/js/alg-wc-pgbcl' . ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ? '' : '.min' ) . '.js',
			array( 'jquery' ),
			alc_pg_by_location_wc()->version,
			true
		);
		wp_localize_script( 'alg-wc-pgbcl-js',
			'alg_wc_pgbcl',
			$this->force_js_checkout_update
		);
	}

	/**
	 * check_data.
	 *
	 * @version 1.5.0
	 * @since   1.1.0
	 */
	function check_data( $type, $needle, $haystack ) {
		switch ( $type ) {
			case 'country':
			case 'state':
			case 'city':
				return in_array( $needle, $haystack );
			case 'postcode':
				return alc_pg_by_location_wc_check_postcode( $needle, $haystack );
		}
	}

	/**
	 * clean_values.
	 *
	 * @version 1.5.0
	 * @since   1.1.0
	 */
	function clean_values( $value ) {
		return array_filter( array_map( 'strtoupper', array_map( 'wc_clean', explode( PHP_EOL, $value ) ) ) );
	}

	/**
	 * available_payment_gateways.
	 *
	 * @version 1.5.0
	 * @since   1.0.0
	 *
	 * @todo    [maybe] apply `alc_pg_by_location_wc` filter
	 * @todo    [maybe] add option to detect customer's country and state by current `$_REQUEST` (as it is now done with postcodes)
	 * @todo    [maybe] (feature) add more locations options (e.g. "... by city")
	 */
	function available_payment_gateways( $available_gateways ) {
		// Prepare options data
		if ( ! isset( $this->options_data ) ) {
			$this->options_data = array();
			foreach ( array( 'country', 'state', 'city', 'postcode' ) as $type ) {
				if ( 'no' === get_option( 'alc_pg_by_location_wc_' . $type . '_' . 'section_enabled', 'yes' ) ) {
					continue;
				}
				foreach ( array( 'include', 'exclude' ) as $incl_or_excl ) {
					$value = get_option( 'alc_pg_by_location_wc_' . $type . '_' . $incl_or_excl, array() );
					if ( ! empty( $value ) ) {
						if ( 'country' === $type ) {
							$value = array_map( 'alc_pg_by_location_wc_maybe_add_european_union_countries', $value );
						} elseif ( in_array( $type, array( 'city', 'postcode' ) ) ) {
							$value = array_map( array( $this, 'clean_values' ), $value );
						}
					}
					$this->options_data[ $type ][ $incl_or_excl ] = $value;
				}
			}
		}
		// Prepare customer data
		foreach ( array( 'country', 'state', 'city', 'postcode' ) as $type ) {
			if ( 'no' === get_option( 'alc_pg_by_location_wc_' . $type . '_' . 'section_enabled', 'yes' ) ) {
				continue;
			}
			$customer_data[ $type ] = alc_pg_by_location_wc_get_location( $type );
		}
		// Check gateways
		foreach ( $available_gateways as $key => $gateway ) {
			foreach ( array( 'country', 'state', 'city', 'postcode' ) as $type ) {
				if ( 'no' === get_option( 'alc_pg_by_location_wc_' . $type . '_' . 'section_enabled', 'yes' ) ) {
					continue;
				}
				if ( '' != $customer_data[ $type ] ) {
					if (
						( ! empty( $this->options_data[ $type ]['include'][ $key ] ) &&
							! $this->check_data( $type, $customer_data[ $type ], $this->options_data[ $type ]['include'][ $key ] ) ) ||
						( ! empty( $this->options_data[ $type ]['exclude'][ $key ] ) &&
							  $this->check_data( $type, $customer_data[ $type ], $this->options_data[ $type ]['exclude'][ $key ] ) )
					) {
						unset( $available_gateways[ $key ] );
					}
				}
			}
		}
		// Return result
		return $available_gateways;
	}

}

endif;

return new ALC_PGs_by_Customer_Location_Core();
