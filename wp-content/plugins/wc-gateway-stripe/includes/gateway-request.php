<?php
if(!class_exists("Stripe")){
	require_once(dirname(__FILE__) ."/Stripe.php");
}

/**
* Gateway API request class - sends given POST data to Gateway server
**/
class stripe_request {
	
	var $_payment;
	
	/** constructor */
	public function __construct( $config=array()) {
		if(!empty($config)){
			Stripe::setApiKey($config['secret_key']);
		}
	}
	
	/**
     * Create and send the request
	 * 
     * @param array $options array of options to be send in POST request
	 * @return gateway_response response object
	 * 
     */
	public function send($options, $type = '') {
		$result = '';
		try {
			if($type=='subscription') {
				$result = Stripe_Customer::create($options);
			} elseif($type=='plan'){
				$result = Stripe_Plan::create($options);
			} elseif($type=='retrieve'){
				$result = Stripe_Plan::retrieve($options);
			} elseif($type=='customer'){
				$result = Stripe_Customer::create($options);
			} elseif($type=='invoice') {
				$result = Stripe_InvoiceItem::create($options);
				// Stripe_Customer::invoiceItems($options);
			} elseif($type=='cancel') {
				$cu = Stripe_Customer::retrieve($options['customer']);
				$result = $cu->cancelSubscription();
			} else {
				$result = Stripe_Charge::create($options);
			}		
		} catch(Exception $ex) {
			$result = $ex;
		}

		$response = new stripe_response($result);
		return $response;
	}
}
?>