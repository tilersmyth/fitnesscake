<?php
/**
 * WooCommerce Stripe Payment
 * By Buif.Dw <support@wp-art.com>
 * 
 * Uninstall - removes all options from DB when user deletes the plugin via WordPress backend.
 * @since 0.1
 * 
 **/
 
if ( !defined('WP_UNINSTALL_PLUGIN') ) {
    exit();
}

delete_option( 'woocommerce_stripe_settings' );		
