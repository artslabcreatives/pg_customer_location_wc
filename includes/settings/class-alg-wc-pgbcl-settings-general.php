<?php
/**
 * PGs by Customer Location from Artslab Creatives for WooCommerce - General Section Settings
 *
 * @version 1.5.0
 * @since   1.0.0
 *
 * @author  Algoritmika Ltd.
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'ALC_PGs_by_Customer_Location_Settings_General' ) ) :

class ALC_PGs_by_Customer_Location_Settings_General extends ALC_PGs_by_Customer_Location_Settings_Section {

	/**
	 * Constructor.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function __construct() {
		$this->id   = '';
		$this->desc = __( 'General', 'payment-gateways-by-customer-location-for-woocommerce' );
		parent::__construct();
	}

	/**
	 * get_settings.
	 *
	 * @version 1.5.0
	 * @since   1.0.0
	 *
	 * @todo    [later] Force JavaScript checkout update: `billing_country`, `shipping_country`
	 * @todo    [maybe] remove "Enable plugin" option
	 */
	function get_settings() {

		$main_settings = array(
			array(
				'title'    => __( 'PGs by Customer Location from Artslab Creatives Options', 'payment-gateways-by-customer-location-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alc_pg_by_location_wc_plugin_options',
			),
			array(
				'title'    => __( 'PGs by Customer Location from Artslab Creatives', 'payment-gateways-by-customer-location-for-woocommerce' ),
				'desc'     => '<strong>' . __( 'Enable plugin', 'payment-gateways-by-customer-location-for-woocommerce' ) . '</strong>',
				'desc_tip' => __( 'Set countries, states, cities or postcodes to include/exclude for WooCommerce payment gateways to show up.', 'payment-gateways-by-customer-location-for-woocommerce' ),
				'id'       => 'alc_pg_by_location_wc_plugin_enabled',
				'default'  => 'yes',
				'type'     => 'checkbox',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alc_pg_by_location_wc_plugin_options',
			),
		);

		$general_settings = array(
			array(
				'title'    => __( 'General Options', 'payment-gateways-by-customer-location-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alc_pg_by_location_wc_general_options',
			),
			array(
				'title'    => __( 'Detect country by', 'payment-gateways-by-customer-location-for-woocommerce' ),
				'desc'     => sprintf( __( 'If you are going to select "%s" option here, please make sure that %s in WooCommerce is available.', 'payment-gateways-by-customer-location-for-woocommerce' ),
					__( 'Country by IP', 'payment-gateways-by-customer-location-for-woocommerce' ),
					'<a href="' . admin_url( 'admin.php?page=wc-settings&tab=integration&section=maxmind_geolocation' ) . '">' .
						__( 'Geolocation', 'payment-gateways-by-customer-location-for-woocommerce' ) . '</a>' ),
				'id'       => 'alc_pg_by_location_wc_country_type',
				'type'     => 'select',
				'class'    => 'wc-enhanced-select',
				'default'  => 'billing',
				'options'  => array(
					'billing'  => __( 'Billing country', 'payment-gateways-by-customer-location-for-woocommerce' ),
					'shipping' => __( 'Shipping country', 'payment-gateways-by-customer-location-for-woocommerce' ),
					'by_ip'    => __( 'Country by IP', 'payment-gateways-by-customer-location-for-woocommerce' ),
				),
			),
			array(
				'title'    => __( 'Detect state by', 'payment-gateways-by-customer-location-for-woocommerce' ),
				'id'       => 'alc_pg_by_location_wc_state_type',
				'type'     => 'select',
				'class'    => 'wc-enhanced-select',
				'default'  => 'billing',
				'options'  => array(
					'billing'  => __( 'Billing state', 'payment-gateways-by-customer-location-for-woocommerce' ),
					'shipping' => __( 'Shipping state', 'payment-gateways-by-customer-location-for-woocommerce' ),
				),
			),
			array(
				'title'    => __( 'Detect city by', 'payment-gateways-by-customer-location-for-woocommerce' ),
				'id'       => 'alc_pg_by_location_wc_cities_type',
				'type'     => 'select',
				'class'    => 'wc-enhanced-select',
				'default'  => 'billing',
				'options'  => array(
					'billing'  => __( 'Billing city', 'payment-gateways-by-customer-location-for-woocommerce' ),
					'shipping' => __( 'Shipping city', 'payment-gateways-by-customer-location-for-woocommerce' ),
				),
			),
			array(
				'title'    => __( 'Detect postcode by', 'payment-gateways-by-customer-location-for-woocommerce' ),
				'id'       => 'alc_pg_by_location_wc_postcodes_type',
				'type'     => 'select',
				'class'    => 'wc-enhanced-select',
				'default'  => 'billing',
				'options'  => array(
					'billing'  => __( 'Billing postcode', 'payment-gateways-by-customer-location-for-woocommerce' ),
					'shipping' => __( 'Shipping postcode', 'payment-gateways-by-customer-location-for-woocommerce' ),
				),
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alc_pg_by_location_wc_general_options',
			),
		);

		$advanced_settings = array(
			array(
				'title'    => __( 'Advanced Options', 'payment-gateways-by-customer-location-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alc_pg_by_location_wc_advanced_options',
			),
			array(
				'title'    => __( 'Force JavaScript checkout update', 'payment-gateways-by-customer-location-for-woocommerce' ),
				'desc_tip' => __( 'If payment gateways section on the checkout page is not updated automatically when customer changes state, city or postcode, select fields to force the update.', 'payment-gateways-by-customer-location-for-woocommerce' ),
				'id'       => 'alc_pg_by_location_wc_force_js_checkout_update',
				'type'     => 'multiselect',
				'class'    => 'chosen_select',
				'default'  => array(),
				'options'  => array(
					'billing_state'     => __( 'Billing state', 'payment-gateways-by-customer-location-for-woocommerce' ),
					'shipping_state'    => __( 'Shipping state', 'payment-gateways-by-customer-location-for-woocommerce' ),
					'billing_city'      => __( 'Billing city', 'payment-gateways-by-customer-location-for-woocommerce' ),
					'shipping_city'     => __( 'Shipping city', 'payment-gateways-by-customer-location-for-woocommerce' ),
					'billing_postcode'  => __( 'Billing postcode', 'payment-gateways-by-customer-location-for-woocommerce' ),
					'shipping_postcode' => __( 'Shipping postcode', 'payment-gateways-by-customer-location-for-woocommerce' ),
				),
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alc_pg_by_location_wc_advanced_options',
			),
		);

		return array_merge( $main_settings, $general_settings, $advanced_settings );
	}

}

endif;

return new ALC_PGs_by_Customer_Location_Settings_General();
