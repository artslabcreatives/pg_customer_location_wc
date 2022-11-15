<?php
/**
 * Plugin Name: Payment Gateways by Customer Location for WooCommerce
 * Plugin URI: https://plugins.artslabcreatives.com/ipg-by-location-for-woocommerce
 * Description: Set countries, states, cities or postcodes to include/exclude for WooCommerce payment gateways to show up
 * Version: 1.2.0
 * Requires at least: 6.1
 * Requires PHP: 7.4
 * Author: Artslab Creatives
 * Author URI: https://plugin.artslabcreatives.com/miyuru
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI: https://plugin.artslabcreatives.com/updater
 * Text Domain: payment-gateways-by-customer-location-for-woocommerce
 * WC tested up to: 7.0
 * Domain Path: localization
 *
 */

/*
Bulk Currency Editor for CURCY - Multi Currency for WooCommerce is free
software: you can redistribute it and/or modify it under the terms of
the GNU General Public License as published by the Free Software Foundation,
either version 2 of the License, or any later version.
Bulk Currency Editor for CURCY - Multi Currency for WooCommerce is
distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
without even the implied warranty of MERCHANTABILITY or FITNESS FOR
A PARTICULAR PURPOSE. See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with Bulk Currency Editor for CURCY - Multi Currency for WooCommerce.
If not, see https://www.gnu.org/licenses/gpl-2.0.html
*/

defined( 'ABSPATH' ) || exit;

if ( 'payment-gateways-by-customer-location-for-woocommerce.php' === basename( __FILE__ ) ) {
	/**
	 * Check if Pro plugin version is activated.
	 *
	 * @version 1.4.0
	 * @since   1.4.0
	 */
	$plugin = 'payment-gateways-by-customer-location-for-woocommerce-pro/payment-gateways-by-customer-location-for-woocommerce-pro.php';
	if (
		in_array( $plugin, (array) get_option( 'active_plugins', array() ), true ) ||
		( is_multisite() && array_key_exists( $plugin, (array) get_site_option( 'active_sitewide_plugins', array() ) ) )
	) {
		return;
	}
}

defined( 'ALG_WC_PGBCL_VERSION' ) || define( 'ALG_WC_PGBCL_VERSION', '1.5.1' );

defined( 'ALG_WC_PGBCL_FILE' ) || define( 'ALG_WC_PGBCL_FILE', __FILE__ );

require_once( 'includes/class-alg-wc-pgbcl.php' );

if ( ! function_exists( 'alc_pg_by_location_wc' ) ) {
	/**
	 * Returns the main instance of ALC_PGs_by_Customer_Location to prevent the need to use globals.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function alc_pg_by_location_wc() {
		return ALC_PGs_by_Customer_Location::instance();
	}
}

add_action( 'plugins_loaded', 'alc_pg_by_location_wc' );


require_once __DIR__ . '/updater.php';
new ALBUpdater();