<?php
/**
 * PGs by Customer Location from Artslab Creatives for WooCommerce - Postcodes Section Settings
 *
 * @version 1.5.0
 * @since   1.1.0
 *
 * @author  Algoritmika Ltd.
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'ALC_PGs_by_Customer_Location_Settings_Postcodes' ) ) :

class ALC_PGs_by_Customer_Location_Settings_Postcodes extends ALC_PGs_by_Customer_Location_Settings_Section {

	/**
	 * Constructor.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 */
	function __construct() {
		$this->id   = 'postcodes';
		$this->desc = __( 'Postcodes', 'payment-gateways-by-customer-location-for-woocommerce' );
		parent::__construct();
	}

	/**
	 * get_settings.
	 *
	 * @version 1.5.0
	 * @since   1.1.0
	 */
	function get_settings() {
		$settings = array(
			array(
				'title'    => $this->desc,
				'type'     => 'title',
				'id'       => 'alc_pg_by_location_wc_postcode_section_options',
			),
			array(
				'title'    => __( 'Gateways by postcode', 'payment-gateways-by-customer-location-for-woocommerce' ),
				'desc'     => '<strong>' . __( 'Enable section', 'payment-gateways-by-customer-location-for-woocommerce' ) . '</strong>',
				'type'     => 'checkbox',
				'id'       => 'alc_pg_by_location_wc_postcode_section_enabled',
				'default'  => 'yes',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alc_pg_by_location_wc_postcode_section_options',
			),
		);
		$gateways  = WC()->payment_gateways->payment_gateways();
		foreach ( $gateways as $key => $gateway ) {
			$settings = array_merge( $settings, array(
				array(
					'title'    => $gateway->method_title,
					'type'     => 'title',
					'id'       => "alc_pg_by_location_wc_postcode_options[{$key}]",
					'desc'     => __( 'One per line.', 'payment-gateways-by-customer-location-for-woocommerce' ) . ' ' .
						__( 'Postcodes containing wildcards (e.g. <code>CB23*</code>) and fully numeric ranges (e.g. <code>90210...99000</code>) are also supported.', 'payment-gateways-by-customer-location-for-woocommerce' ) .
						( ! in_array( $key, array( 'bacs', 'cheque', 'paypal', 'cod' ) ) ? apply_filters( 'alc_pg_by_location_wc_settings',
							'<br>' . sprintf( 'You will need %s plugin to set options for the "%s" gateway.',
								'<a target="_blank" href="https://wpfactory.com/item/payment-gateways-by-customer-location-for-woocommerce/">' .
									'PGs by Customer Location from Artslab Creatives for WooCommerce Pro' . '</a>', $gateway->method_title ) ) : '' ),
				),
				array(
					'title'    => __( 'Include postcodes', 'payment-gateways-by-customer-location-for-woocommerce' ),
					'desc_tip' => __( 'Payment gateway will be available ONLY if customer is from selected postcodes.', 'payment-gateways-by-customer-location-for-woocommerce' ) . ' ' .
						__( 'If set empty - option is ignored.', 'payment-gateways-by-customer-location-for-woocommerce' ),
					'id'       => "alc_pg_by_location_wc_postcode_include[{$key}]",
					'default'  => '',
					'type'     => 'textarea',
					'css'      => 'height:200px;',
					'custom_attributes' => ( ! in_array( $key, array( 'bacs', 'cheque', 'paypal', 'cod' ) ) ?
						apply_filters( 'alc_pg_by_location_wc_settings', array( 'readonly' => 'readonly' ), 'array' ) : array() ),
				),
				array(
					'title'    => __( 'Exclude postcodes', 'payment-gateways-by-customer-location-for-woocommerce' ),
					'desc_tip' => __( 'Payment gateway will NOT be available if customer is from selected postcodes.', 'payment-gateways-by-customer-location-for-woocommerce' ) . ' ' .
						__( 'If set empty - option is ignored.', 'payment-gateways-by-customer-location-for-woocommerce' ),
					'id'       => "alc_pg_by_location_wc_postcode_exclude[{$key}]",
					'default'  => '',
					'type'     => 'textarea',
					'css'      => 'height:200px;',
					'custom_attributes' => ( ! in_array( $key, array( 'bacs', 'cheque', 'paypal', 'cod' ) ) ?
						apply_filters( 'alc_pg_by_location_wc_settings', array( 'readonly' => 'readonly' ), 'array' ) : array() ),
				),
				array(
					'type'     => 'sectionend',
					'id'       => "alc_pg_by_location_wc_postcode_options[{$key}]",
				),
			) );
		}
		return $settings;
	}

}

endif;

return new ALC_PGs_by_Customer_Location_Settings_Postcodes();
