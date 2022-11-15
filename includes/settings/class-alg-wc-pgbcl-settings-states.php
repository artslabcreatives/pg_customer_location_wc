<?php
/**
 * PGs by Customer Location from Artslab Creatives for WooCommerce - States Section Settings
 *
 * @version 1.4.0
 * @since   1.1.0
 *
 * @author  Algoritmika Ltd.
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'ALC_PGs_by_Customer_Location_Settings_States' ) ) :

class ALC_PGs_by_Customer_Location_Settings_States extends ALC_PGs_by_Customer_Location_Settings_Section {

	/**
	 * Constructor.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 */
	function __construct() {
		$this->id   = 'states';
		$this->desc = __( 'States', 'payment-gateways-by-customer-location-for-woocommerce' );
		parent::__construct();
	}

	/**
	 * get_settings.
	 *
	 * @version 1.4.0
	 * @since   1.1.0
	 *
	 * @todo    [later] states: not only "base country"
	 */
	function get_settings() {
		$settings = array(
			array(
				'title'    => $this->desc,
				'type'     => 'title',
				'id'       => 'alc_pg_by_location_wc_state_section_options',
			),
			array(
				'title'    => __( 'Gateways by state', 'payment-gateways-by-customer-location-for-woocommerce' ),
				'desc'     => '<strong>' . __( 'Enable section', 'payment-gateways-by-customer-location-for-woocommerce' ) . '</strong>',
				'type'     => 'checkbox',
				'id'       => 'alc_pg_by_location_wc_state_section_enabled',
				'default'  => 'yes',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alc_pg_by_location_wc_state_section_options',
			),
		);
		$states    = alc_pg_by_location_wc_get_states();
		$gateways  = WC()->payment_gateways->payment_gateways();
		foreach ( $gateways as $key => $gateway ) {
			$settings = array_merge( $settings, array(
				array(
					'title'    => $gateway->method_title,
					'type'     => 'title',
					'id'       => "alc_pg_by_location_wc_state_options[{$key}]",
					'desc'     => __( 'Base country states only.', 'payment-gateways-by-customer-location-for-woocommerce' ) .
						'<br>' . ( ! in_array( $key, array( 'bacs', 'cheque', 'paypal', 'cod' ) ) ? apply_filters( 'alc_pg_by_location_wc_settings',
							sprintf( 'You will need %s plugin to set options for the "%s" gateway.',
								'<a target="_blank" href="https://wpfactory.com/item/payment-gateways-by-customer-location-for-woocommerce/">' .
									'PGs by Customer Location from Artslab Creatives for WooCommerce Pro' . '</a>', $gateway->method_title ) ) : '' ),
				),
				array(
					'title'    => __( 'Include states', 'payment-gateways-by-customer-location-for-woocommerce' ),
					'desc_tip' => __( 'Payment gateway will be available ONLY if customer is from selected states.', 'payment-gateways-by-customer-location-for-woocommerce' ) . ' ' .
						__( 'If set empty - option is ignored.', 'payment-gateways-by-customer-location-for-woocommerce' ),
					'id'       => "alc_pg_by_location_wc_state_include[{$key}]",
					'default'  => array(),
					'type'     => 'multiselect',
					'class'    => 'chosen_select',
					'options'  => $states,
					'custom_attributes' => array_merge( array( 'data-placeholder' => __( 'Select states', 'payment-gateways-by-customer-location-for-woocommerce' ) ),
						( ! in_array( $key, array( 'bacs', 'cheque', 'paypal', 'cod' ) ) ?
							apply_filters( 'alc_pg_by_location_wc_settings', array( 'disabled' => 'disabled' ), 'array' ) : array() ) ),
				),
				array(
					'title'    => __( 'Exclude states', 'payment-gateways-by-customer-location-for-woocommerce' ),
					'desc_tip' => __( 'Payment gateway will NOT be available if customer is from selected states.', 'payment-gateways-by-customer-location-for-woocommerce' ) . ' ' .
						__( 'If set empty - option is ignored.', 'payment-gateways-by-customer-location-for-woocommerce' ),
					'id'       => "alc_pg_by_location_wc_state_exclude[{$key}]",
					'default'  => array(),
					'type'     => 'multiselect',
					'class'    => 'chosen_select',
					'options'  => $states,
					'custom_attributes' => array_merge( array( 'data-placeholder' => __( 'Select states', 'payment-gateways-by-customer-location-for-woocommerce' ) ),
						( ! in_array( $key, array( 'bacs', 'cheque', 'paypal', 'cod' ) ) ?
							apply_filters( 'alc_pg_by_location_wc_settings', array( 'disabled' => 'disabled' ), 'array' ) : array() ) ),
				),
				array(
					'type'     => 'sectionend',
					'id'       => "alc_pg_by_location_wc_state_options[{$key}]",
				),
			) );
		}
		return $settings;
	}

}

endif;

return new ALC_PGs_by_Customer_Location_Settings_States();
