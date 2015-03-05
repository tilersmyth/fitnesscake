<?php
/*
Plugin Name: WC Stripe Gateway
Plugin URI: http://codecanyon.net/item/stripe-payment-gateway-for-woocommerce/2973176
Description: The Stripe payment gateway plugin for WooCommerce, Therefore an SSL certificate is required to ensure your customer credit card details are safe.
Version: 2.2.3
Author: Buif.Dw <support@browsepress.com>
Author URI: http://codecanyon.net/user/browsepress/portfolio
*/

add_action('plugins_loaded', 'woocommerce_stripe_init', 0);

function woocommerce_stripe_init() {

	if ( ! class_exists( 'Woocommerce' ) ) { return; }
	
	/**
 	 * Localication
	 */
	load_textdomain( 'woocommerce', 'langs/simplepay4u-'.get_locale().'.mo' );
	
	if(!defined('STRIPE_SDK')) {
		define('STRIPE_SDK', 1);
		require_once('wc-gateway-stripe.php');
	}
	
	require_once('includes/gateway-request.php');
	require_once('includes/gateway-response.php');
	
	/**
 	* Add the Gateway to WooCommerce
 	**/
	function add_stripe_gateway($methods) {
		$methods[] = 'WC_Gateway_Stripe';
		return $methods;
	}
	
	add_filter('woocommerce_payment_gateways', 'add_stripe_gateway' );
} 
