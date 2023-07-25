<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class CodersAdda
	{
		private $CI;
		
		public function __construct()
		{
			$this->CI =& get_instance();
			
			$this->appZipCode='226007';
			
			$this->appGoogleMapKey='AIzaSyDode58s3GL_r9Nusl71PXS3o5IkbFtXLY';
			
			$this->appPlayStoreLink='https://play.google.com/store/apps/details?id=digi.coders.codersadda';
			
			$this->TempleteIDForOTP='1307162021550108081';
			
			$this->TempleteIDForSMS='1307162021550108081';
			
		}
		
        function SendSMS($mobile,$message)
		{   
            
            // set app name as you required
            $app_name="Karmasu";
            
            // DLT Approved OTP SMS Template ID
            $template_id="1307164706435757762";
            // never change this sms template
            // Your OTP Code is 123456. Do not share it with anyone. From AppNameHere . #TeamDigiCoders 
            $message_template="Your OTP Code is ".$message.". Do not share it with anyone. From ".$app_name." . #TeamDigiCoders";
        
            $authkey="366681Awg6xzno2du6241ae44P1";
            $mobile="91".$mobile;
            $final_message=urlencode($message_template);
            $sender="DIGICO";
            $route="4";
            $country="91";
            
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://sms.digicoders.in/api/sendhttp.php?authkey=$authkey&mobiles=$mobile&message=$final_message&sender=$sender&route=$route&country=$country&unicode=1&response=json&DLT_TE_ID=".$template_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST =>"GET"
            ));
        
            $response = curl_exec($curl);
            curl_close($curl);
        
            $result=json_decode($response);
            if($result->type=="success") {
                return true;
            }
            else {
                return false;
            }
            

		}
		
		function SendSMS2($mobile,$message)
		{   
            
            // set app name as you required
            $app_name="Karmasu";
            
            // DLT Approved OTP SMS Template ID
            $template_id="1307164706435757762";
            // never change this sms template
            // Your OTP Code is 123456. Do not share it with anyone. From AppNameHere . #TeamDigiCoders 
            $message_template="Your OTP Code is ".$message.". Do not share it with anyone. From ".$app_name." . #TeamDigiCoders";
        
            $authkey="366681Awg6xzno2du6241ae44P1";
            $mobile="91".$mobile;
            $final_message=urlencode($message_template);
            $sender="DIGICO";
            $route="4";
            $country="91";
            
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => "http://sms.digicoders.in/api/sendhttp.php?authkey=$authkey&mobiles=$mobile&message=$final_message&sender=$sender&route=$route&country=$country&unicode=1&response=json&DLT_TE_ID=".$template_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST =>"GET"
            ));
        
            $response = curl_exec($curl);
            curl_close($curl);
        
            $result=json_decode($response);
            if($result->type=="success") {
                return true;
            }
            else {
                return false;
            }
            

		}
		
		function SendSMS1($mobile,$msg, $DLT_TE_ID)
		{
			$authKey = "316846AIn4LVLh7ibW6090030bP1";
			
			$mobileNumber = '91'.$mobile;
			
			$senderId = "DIGICO";
			$unicode=1;
			
			$message = urlencode($msg);
			
			$route =4;
			
			$postData = array(
			'authkey' => $authKey,
			'mobiles' => $mobileNumber,
			'message' => $message,
			'sender' => $senderId,
			'route' => $route,
			'unicode' => $unicode
			);
			//'DLT_TE_ID' => $DLT_TE_ID
			
			$url="http://sms.digicoders.in/api/sendhttp.php";
			
			$ch = curl_init();
			curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $postData
			));
			
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			
			$output = curl_exec($ch);
			
			if(curl_errno($ch))
			{
				//return 'error:' . curl_error($ch);
				return false;
			}
			
			curl_close($ch);
			
			return true;
		}
		
		public function DiscountPercent($value)
		{
			if(empty($value)){
				$amount='0% Off';
			}
			else{
				if(explode(' ',$value)){
					$valueArr=explode('%',$value);
					if(!empty($valueArr[0])){
						$valueOrg=$valueArr[0];
						$valueOrg=round($valueOrg);
						$amount=$valueOrg.'% Off';
					}
					else{
						$amount='0% Off';
					}
				}
				else{
					$amount='0% Off';
				}
			}
			return $amount;
		}
		
		public function humanTiming ($time)
		{
			$time = time() - $time; 
			$time = ($time<1)? 1 : $time;
			$tokens = array (
			31536000 => 'year',
			2592000 => 'month',
			604800 => 'week',
			86400 => 'day',
			3600 => 'hour',
			60 => 'minute',
			1 => 'second'
			);
			foreach ($tokens as $unit => $text) {
				if ($time < $unit) continue;
				$numberOfUnits = floor($time / $unit);
				return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'').' ago';
			}
		}
		
		public function calculateDistance($shipping_zip_code)
		{
			$pick_up_point_zip_code = $this->appZipCode;
			$shipping_zip_code = $shipping_zip_code;
			
			$pick_up_lat_lng = $this->getLatLng($pick_up_point_zip_code);
			$shipping_lat_lng = $this->getLatLng($shipping_zip_code);
			$unit = 'km';
			
			$theta = ($pick_up_lat_lng->longitude)-($shipping_lat_lng->longitude);
			$dist = sin(deg2rad((double)$pick_up_lat_lng->latitude)) * sin(deg2rad((double)$shipping_lat_lng->latitude)) + cos(deg2rad((double)$pick_up_lat_lng->latitude)) * cos(deg2rad((double)$shipping_lat_lng->latitude)) * cos(deg2rad((double)$theta));
			$dist = acos($dist);
			$dist = rad2deg($dist);
			$distance = round($dist * 60 * 1.1515 * 1.609344);
			
			$response = (object) [
			'latitude' => $shipping_lat_lng->latitude,
			'longitude' => $shipping_lat_lng->longitude,
			'address' => $shipping_lat_lng->address,
			'pincode' => $shipping_zip_code,
			'distance' => $distance
			];
			
			return $response;
		}
		
		public function getLatLng($zip_code)
		{
			$url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$zip_code."&sensor=false&key=".$this->appGoogleMapKey."";
			$curl=curl_init($url);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, '');
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_TIMEOUT, 30);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			
			$json=curl_exec($curl);
			$decode=json_decode($json, true);
			
			$response = (object) [
			'latitude' => $decode['results'][0]['geometry']['location']['lat'],
			'longitude' => $decode['results'][0]['geometry']['location']['lng'],
			'address' => $decode['results'][0]['formatted_address']
			];
			
			return $response;
		}
		
		function hidemobile($mobile)
		{
			if(strlen($mobile)==10)
			{
				$mob1=substr($mobile,0,2);
				$mob2=substr($mobile,6);
				$mob3=$mob1."XXXX".$mob2;
				return $mob3;
			}
			else
			{ 
				return $mobile;
			}
		}
		
		function send_notification_multiple($message, $title, $alltokendata,$image,$click_action,$id,$type)
		{
			$API_ACCESS_KEY='AAAAImJReSk:APA91bHaDLSmC9BLVTrUqton-osgElvbdfDUPalmYtmC7jdlgd3AJxkNCIntkzI2ackrR0HQ3ALAnFikgVuurVjEmu3nzUI5iy4njnOVN_yEcRBpiY2PO7lZmlwTyfpacHbi8KfHJQQT';
			//$API_ACCESS_KEY=$alltokendata;
		    $msg = array(
			'body'   => $message,
			'title'   => $title,
			'image' =>$image,
			// 'click_action'=>$click_action
			);
			$data = array(
			'id'   =>$id,
			'type'   =>$type
			);
// 			define('API_ACCESS_KEY', $API_ACCESS_KEY);
			$fields = array(
			'registration_ids' => $alltokendata,
			'notification' => $msg,
			'data'=>$data
			);
			$headers = array(
			'Authorization: key='.$API_ACCESS_KEY,
			'Content-Type: application/json'
			);
			#Send Reponse To FireBase Server	
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
			$result = curl_exec($ch);
			curl_close($ch);
			sleep(1);
			return $result;
		}
		
		
		function send_notification_single($message, $title, $token,$image,$click_action,$id,$type)
		{
			$API_ACCESS_KEY='AAAAImJReSk:APA91bHaDLSmC9BLVTrUqton-osgElvbdfDUPalmYtmC7jdlgd3AJxkNCIntkzI2ackrR0HQ3ALAnFikgVuurVjEmu3nzUI5iy4njnOVN_yEcRBpiY2PO7lZmlwTyfpacHbi8KfHJQQT';
			$msg = array(
			'body'   => $message,
			'title'   => $title,
		    'image' =>$image,
// 			'click_action'=>$click_action
			);
			$data = array(
			'id'   =>$id,
			'type'   =>$type
			);
// 			define('API_ACCESS_KEY', $API_ACCESS_KEY);
			$fields = array(
			'to' => $token,
			'notification' => $msg,
			'data'=>$data
			);
			$headers = array(
			'Authorization: key='.$API_ACCESS_KEY,
			'Content-Type: application/json'
			);
			#Send Reponse To FireBase Server	
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
			$result = curl_exec($ch);
			curl_close($ch);
			sleep(1);
			return $result;
		}
		
	}