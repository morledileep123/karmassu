<?php
require 'getAPIKey.php';

require 'razorpay-php/Razorpay.php';
use Razorpay\Api\Api;

// API Response
$output["res"]='';
$output["msg"]='';
$output["data"]=array();
// API Response

// Receive  Data from App
$id=mysqli_real_escape_string($conn,$_POST['id']);
$paymentstatus=mysqli_real_escape_string($conn,$_POST['paymentstatus']);
// Receive  Data from App
if(empty($id) || empty($paymentstatus))
{
	$output["res"]='error';
	$output["msg"]='Validation Failed';
}
else
{
	//Details
	$orderid=rand(1000,9999)."_hewf_".$id;
	$amount=51*100; // in Paisa

	$api = new Api($api_key, $api_secret);
	$orderData  = $api->order->create([
		'receipt'         => $orderid,
		'amount'          => $amount, // IN Paisa
		'currency'        => 'INR',
		'payment_capture' =>  1
	]);
	
	$query="update surveyform set paymentmethod='$paymentstatus', amount='50', orderid='$orderid', paymentstatus='Started' where id='$id'";;
	if(mysqli_query($conn,$query))
	{
		$output["res"]='success';
		$output["msg"]='Data Success';

		$orderDataSet=array("raz_orderid"=>$orderData->id, "amount"=>$orderData->amount, "orderid"=>$orderid );

		array_push($output["data"],$orderDataSet);
	}
	else
	{
		$output["res"]='error';
		$output["msg"]='Error in Updating Data !';
	}
	
}
header('Content-Type: application/json');
echo json_encode([$output],JSON_UNESCAPED_SLASHES);
?>