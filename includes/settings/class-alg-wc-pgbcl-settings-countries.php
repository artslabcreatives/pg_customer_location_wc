<?php
/**
 * PGs by Customer Location from Artslab Creatives for WooCommerce - Countries Section Settings
 *
 * @version 1.4.0
 * @since   1.1.0
 *
 * @author  Algoritmika Ltd.
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'ALC_PGs_by_Customer_Location_Settings_Countries' ) ) :

class ALC_PGs_by_Customer_Location_Settings_Countries extends ALC_PGs_by_Customer_Location_Settings_Section {

	/**
	 * Constructor.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 */
	function __construct() {
		$this->id   = 'countries';
		$this->desc = __( 'Countries', 'payment-gateways-by-customer-location-for-woocommerce' );
		parent::__construct();
	}

	/**
	 * get_settings.
	 *
	 * @version 1.4.0
	 * @since   1.1.0
	 */
	function get_settings() {
		$settings = array(
			array(
				'title'    => $this->desc,
				'type'     => 'title',
				'id'       => 'alc_pg_by_location_wc_country_section_options',
			),
			array(
				'title'    => __( 'Gateways by country', 'payment-gateways-by-customer-location-for-woocommerce' ),
				'desc'     => '<strong>' . __( 'Enable section', 'payment-gateways-by-customer-location-for-woocommerce' ) . '</strong>',
				'type'     => 'checkbox',
				'id'       => 'alc_pg_by_location_wc_country_section_enabled',
				'default'  => 'yes',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alc_pg_by_location_wc_country_section_options',
			),
		);
		$countries = alc_pg_by_location_wc_get_countries();
		$gateways  = WC()->payment_gateways->payment_gateways();
		foreach ( $gateways as $key => $gateway ) {
			$settings = array_merge( $settings, array(
				array(
					'title'    => $gateway->method_title,
					'type'     => 'title',
					'id'       => "alc_pg_by_location_wc_country_options[{$key}]",
					'desc'     => (in_array( $key, array('' ) ) ? apply_filters( 'alc_pg_by_location_wc_settings',
						sprintf( 'You will need %s plugin to set options for the "%s" gateway.',
							'<a target="_blank" href="https://wpfactory.com/item/payment-gateways-by-customer-location-for-woocommerce/">' .
								'PGs by Customer Location from Artslab Creatives for WooCommerce Pro' . '</a>', $gateway->method_title ) ) : '' ),
				),
				array(
					'title'    => __( 'Include countries', 'payment-gateways-by-customer-location-for-woocommerce' ),
					'desc_tip' => __( 'Payment gateway will be available ONLY if customer is from selected countries.', 'payment-gateways-by-customer-location-for-woocommerce' ) . ' ' .
						__( 'If set empty - option is ignored.', 'payment-gateways-by-customer-location-for-woocommerce' ),
					'id'       => "alc_pg_by_location_wc_country_include[{$key}]",
					'default'  => array(),
					'type'     => 'multiselect',
					'class'    => 'chosen_select',
					'options'  => $countries,
					'custom_attributes' => array_merge( array( 'data-placeholder' => __( 'Select countries', 'payment-gateways-by-customer-location-for-woocommerce' ) ),
						(in_array( $key, array('' ) ) ?
							apply_filters( 'alc_pg_by_location_wc_settings', array( 'disabled' => 'disabled' ), 'array' ) : array() ) ),
				),
				array(
					'title'    => __( 'Exclude countries', 'payment-gateways-by-customer-location-for-woocommerce' ),
					'desc_tip' => __( 'Payment gateway will NOT be available if customer is from selected countries.', 'payment-gateways-by-customer-location-for-woocommerce' ) . ' ' .
						__( 'If set empty - option is ignored.', 'payment-gateways-by-customer-location-for-woocommerce' ),
					'id'       => "alc_pg_by_location_wc_country_exclude[{$key}]",
					'default'  => array(),
					'type'     => 'multiselect',
					'class'    => 'chosen_select',
					'options'  => $countries,
					'custom_attributes' => array_merge( array( 'data-placeholder' => __( 'Select countries', 'payment-gateways-by-customer-location-for-woocommerce' ) ),
						( in_array( $key, array( '' )) ?
							apply_filters( 'alc_pg_by_location_wc_settings', array( 'disabled' => 'disabled' ), 'array' ) : array() ) ),
				),
				array(
					'type'     => 'sectionend',
					'id'       => "alc_pg_by_location_wc_country_options[{$key}]",
				),
			) );
		}
		return $settings;
	}

}

endif;

return new ALC_PGs_by_Customer_Location_Settings_Countries();
