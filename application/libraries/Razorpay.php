<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'third_party/razorpay-php/Razorpay.php';
use Razorpay\Api\Api;
	
class Razorpay
{
	private $CI;
	
	public $rzp_api_key, $rzp_api_secret, $rzp_env;
	
    public function __construct()
    {
        $this->CI =& get_instance();
		
		$this->rzp_env="LIVE";  # TEST/LIVE
		
		
		if($this->rzp_env=="TEST")
		{
			$this->rzp_api_key="rzp_test_6kz5nGEzi8uXRw";
		}
		else if($this->rzp_env=="LIVE")
		{
			//$this->rzp_api_key="rzp_live_egHyq1IZUB25Ut";
			$this->rzp_api_key="rzp_live_RRPv86W1EWPQ6D";
		}
		
		
		if($this->rzp_env=="TEST")
		{
			$this->rzp_api_secret="SMtig3JkAqFP7nIMpODyyuAL";
		}
		else if($this->rzp_env=="LIVE")
		{
			//$this->rzp_api_secret="maMPWjkE6UPsm1gntqp7gYrN";
			$this->rzp_api_secret="ANmRSIv5rdJL0WA5LcUOi5Gy";
		}
			
    }
	
	# Rezorpay Order ID Generator
		
	function getRazorpayOrderID($oid, $amount)
	{
	
		$api = new Api($this->rzp_api_key, $this->rzp_api_secret);
		
		$orderData  = $api->order->create([
			'receipt'         => $oid,
			'amount'          => (double)$amount*100.0, // IN Paisa
			'currency'        => 'INR',
			'payment_capture' =>  1
		]);
		
		return $orderData->id;
	
	}
	
	function getRazorpayOrder($oid)
	{
	
		$api = new Api($this->rzp_api_key, $this->rzp_api_secret);
		
		$orderData  = $api->order->fetch($oid);
		
		return $orderData;
	
	}
	
	function getRazorpayOrderPayment($oid)
	{
	
		$api = new Api($this->rzp_api_key, $this->rzp_api_secret);
		
		$orderData  = $api->order->fetch($oid)->payments();
		
		return $orderData;
	
	}
	
}