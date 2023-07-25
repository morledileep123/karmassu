<?php
	defined("BASEPATH") or exit("No direct scripts allowed here");
	
	class V2 extends CI_Controller
	{
		private $date, $time;
		
		public function __construct()
		{
			parent::__construct();
			date_default_timezone_set("Asia/Kolkata");
			$this->date = date("d-m-Y");
			$this->dateY = date("Y-m-d");
			$this->time = date("h:i:s A");
			
			$this->load->library('CodersAdda');
			$this->load->library('Razorpay');
			$this->load->library('form_validation');
			$this->load->model('Auth_model');
			
			if(empty($this->input->post('userid'))) {
				$this->userid=0;
			}
			else {
				$this->userid=$this->input->post('userid');
			}
			
			
		}
		
		public function index(){
			
			$output['res']="error";
            $output['msg']="Invalid Parameters";
            
			$output['data']=array();
			
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		public function SplashScreen()
        {
			$result=$this->db->where(['status'=>'true'])->get('tbl_splash_screen');
			if($result->num_rows())
			{
				$output['res']="success"; 
           		$output['msg']="Screen Data";
				$values=$result->row();
				$values->screen=base_url('uploads/splash_screen/'.$values->screen);
				$output['data']=$values;
			}
			else
			{
				$output['res']="error"; 
            	$output['msg']="No Screen Found";	
			}
            echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		
		public function AppDetails()
        {
			$results=$this->db->get('tbl_adminlogin')->row();
			$appData= (object) [
			'help_mobile'=>$results->help_mobile,
			'help_email'=>$results->help_email,
			'mobile'=>'9129388891',
			'alt_mobile'=>'9129388891',
			'email'=>'contact@karmasu.com',
			'address'=>'Lucknow,India',
			'facebook_url'=>'https://www.facebook.com/',
			'twitter_url'=>'https://www.twitter.com/',
			'instagram_url'=>'https://www.instagram.com/',
			'linkedin_url'=>'www.linkedin.com/',
			'youtube_url'=>'https://www.youtube.com/',
			'pinterest_url'=>'https://in.pinterest.com/',
			];
			
			$output['res']="success"; 
            $output['msg']="App Details";
			$output['data']=$appData;
			
            echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		
		# New Registration API
		
		public function NewRegistration()
		{
			$output['res']="error";
            $output['msg']="error";
            $output['data']="";
			if(empty($_POST))
			{
				$output['msg']='Something Went Wrong. Try Again !';
			}
			else
			{
				if($this->form_validation->run('newregistration')) 
				{
					$name=$this->input->post('name');
					$email=$this->input->post('email');
					$mobile=$this->input->post('mobile');
					$password=$this->input->post('password');
					
					$otp=rand(1000,9999);
					
					$wheredata=array('number'=>$mobile);
					$result=$this->db->where($wheredata)->get('tbl_registration');
					if($result->num_rows())
					{
						$values=$result->row();
						if($values->otp_status=='true')
						    {
						        $output['res']='error';
						        $output['msg']="This Mobile No is already registered.";
    						}
    						else
    						{
    						    $datetime=$this->date.' '.$this->time;
        				    	$this->db->where(['id'=>$values->id])->update('tbl_registration',['name'=>$name,'number'=>$mobile,'otp'=>$otp,'status'=>'true','date'=>$datetime,'dateY'=>$this->dateY,"email"=>$email,"password"=>$password]);
        						$msg=$otp;
        						$this->codersadda->SendSMS2($mobile,$msg);
        							
        						$output['res']='success';
        						$output['msg']='OTP sent to '.$mobile;
    						}
						
					}
					else
					{
						$datetime=$this->date.' '.$this->time;
						
						$insertData=['name'=>$name,'number'=>$mobile,'otp'=>$otp,'status'=>'true','date'=>$datetime,'dateY'=>$this->dateY,"email"=>$email,"password"=>$password];
						
						if($this->db->insert('tbl_registration',$insertData))
						{
							$msg=$otp;
							$this->codersadda->SendSMS2($mobile,$msg);
							
							$output['res']='success';
							$output['msg']='OTP sent to '.$mobile;
						}
						else
						{
							$output['msg']='Something Went Wrong. Try Again !';
						}
					}
				}
				else
				{
					$msg=explode('</p>',validation_errors());
					$output['msg']=str_ireplace('<p>','', $msg[0]);
				}
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		# Login
		
		public function Login()
		{
			$output['res']="error";
            $output['msg']="error";
            $output['data']="";
			if(empty($_POST))
			{
				$output['msg']='Something Went Wrong. Try Again !';
			}
			else
			{
				if($this->form_validation->run('newlogin')) 
				{
					$mobile=$this->input->post('mobile');
					$password=$this->input->post('password');
					
					
					$wheredata=array('number'=>$mobile,'otp_status'=>'true');
					
					$result=$this->db->where($wheredata)->get('tbl_registration');
					if($result->num_rows())
					{
						
						$values=$result->row();
						
						if($values->status=='true')
						{
						    if($values->password==$password)
    						{
    							
    							$output['res']='success';
    							$output['msg']="Login Success";
    							$output['data']=array($values);
    							
    						}
    						else
    						{
    							$output['res']='error';
    							$output['msg']="Incorrect Password Entered.";
    						}
						}
						else{
						    $output['msg']="Your account is inactive.";
						}
						
					}
					else
					{
						
						$output['res']='error';
						$output['msg']="Mobile number not registered.";
						
					}
				}
				else
				{
					$msg=explode('</p>',validation_errors());
					$output['msg']=str_ireplace('<p>','', $msg[0]);
				}
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		
		#Logout
		public function Logout()
		{
			$output['res']="error";
            $output['msg']="error";
            $output['data']="";
			if(empty($_POST))
			{
				$output['msg']='Something Went Wrong. Try Again !';
			}
			else
			{
				if($this->form_validation->run('profile')) 
				{
					$userid=$this->input->post('userid');
					
					$wheredata=array('id'=>$userid);
					$result=$this->db->where($wheredata)->get('tbl_registration');
					if($result->num_rows())
					{
						$this->db->where(['id'=>$userid])->update('tbl_registration',['LastLogoutDate'=>$this->date,'LastLogoutTime'=>$this->time,'CurrentStatus'=>'false']);
						
						$output['res']='success';
						$output['msg']='Logout Successfully';
						
					}
					else
					{
						$output['msg']='Invalid User ID';
					}
				}
				else
				{
					$msg=explode('</p>',validation_errors());
					$output['msg']=str_ireplace('<p>','', $msg[0]);
				}
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		#Profile
		
		
		public function Profile()
		{
			$output['res']="error";
            $output['msg']="error";
            $output['data']="";
			if(empty($_POST))
			{
				$output['msg']='Something Went Wrong. Try Again !';
			}
			else
			{
				if($this->form_validation->run('profile')) 
				{
					$userid=$this->input->post('userid');
					$wheredata=array('id'=>$userid);
					$result=$this->db->where($wheredata)->get('tbl_registration');
					if($result->num_rows())
					{
						$values=$result->row();
						#Extera Keys
						$values->live_session=$this->db->where(['mobile'=>$values->number])->get('tbl_live_join')->num_rows();
						$values->courses=$this->db->where(['userid'=>$values->id,'itemtype'=>'Course','paymentstatus'=>'success'])->get('tbl_enroll')->num_rows();
						$values->books=$this->db->where(['userid'=>$values->id,'itemtype'=>'Ebook','paymentstatus'=>'success'])->get('tbl_enroll')->num_rows();
						$values->certificates=$this->db->where(['userid'=>$this->userid,'status'=>'true'])->get('tbl_certificate')->num_rows();
				// 		$values->watch_minutes=0;
				// 		$values->watch_no=0;
						$values->test_completed=$this->db->where(['student_id'=>$values->id,'status'=>'true'])->get('tbl_quiz_attended')->num_rows();
						$values->quiz_attempted=$this->db->where(['student_id'=>$values->id,'status'=>'true'])->get('tbl_quiz_attended')->num_rows();
						
						$output['res']='success';
						$output['msg']='Profile Data';
						$output['data']=$values;
						
					}
					else
					{
						$output['msg']='Invalid User ID';
					}
					
				}
				else
				{
					$msg=explode('</p>',validation_errors());
					$output['msg']=str_ireplace('<p>','', $msg[0]);
				}
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		public function CheckUser()
		{
			$output['res']="error";
            $output['msg']="error";
            $output['data']="";
			if(!empty($_POST) and $this->form_validation->run('profile')) 
			{
				$userid=$this->input->post('userid');
				$wheredata=['id'=>$userid];
				$result=$this->db->where($wheredata)->get('tbl_registration');
				if($result->num_rows()){
					$values=$result->row();	
					#Extera Keys
					$values->live_session=$this->db->where(['mobile'=>$values->number])->get('tbl_live_join')->num_rows();
					$values->courses=$this->db->where(['userid'=>$values->id,'itemtype'=>'Course','paymentstatus'=>'success'])->get('tbl_enroll')->num_rows();
					$values->books=$this->db->where(['userid'=>$values->id,'itemtype'=>'Ebook','paymentstatus'=>'success'])->get('tbl_enroll')->num_rows();
					$values->certificates=$this->db->where(['userid'=>$this->userid,'status'=>'true'])->get('tbl_certificate')->num_rows();
					
				// 	$values->watch_minutes=0;
				// 	$values->watch_no=0;
					$values->test_completed=$this->db->where(['student_id'=>$values->id,'status'=>'true'])->get('tbl_quiz_attended')->num_rows();
					$values->quiz_attempted=$this->db->where(['student_id'=>$values->id,'status'=>'true'])->get('tbl_quiz_attended')->num_rows();
					
					$output['res']='success';
					$output['msg']='Profile Data';
					$output['data']=$values;
				}
				else{
					$output['msg']='Invalid User ID';
				}	
			}
			else{
				$msg=explode('</p>',validation_errors());
				$output['msg']=str_ireplace('<p>','', $msg[0]);
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		
		public function UpdateProfile()
		{
			$output['res']="error";
            $output['msg']="error";
            $output['data']="";
			if(empty($_POST))
			{
				$output['msg']='Something Went Wrong. Try Again !';
			}
			else
			{
				if($this->form_validation->run('updateProfile')) 
				{
					$userid=$this->input->post('userid');
					$wheredata=array('id'=>$userid);
					$result=$this->db->where($wheredata)->get('tbl_registration');
					if($result->num_rows())
					{
						$updateData=[
						'name'=>$this->input->post('name'),
						'email'=>$this->input->post('email'),
						'course'=>$this->input->post('education'),
						'address'=>$this->input->post('address'),
						];
						
						
						$upresult=$this->db->where($wheredata)->update('tbl_registration',$updateData);
						if($upresult){
							if(!empty($_FILES["profile_photo"]["name"])) {
                                $ext = pathinfo($_FILES["profile_photo"]["name"], PATHINFO_EXTENSION);
                                $filename = time() . "_profile_photo." . $ext;
								
								$upresult=$this->db->where($wheredata)->update('tbl_registration',array('profile_photo'=>$filename));
								
								$config['upload_path']   = './uploads/profile_photo/';
                                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                $config['max_size']      = 5000; // In KB
                                $config['file_name']     = $filename;
                                $this->load->library('upload', $config);
                                $this->upload->do_upload('profile_photo');
								
							}
							$values=$this->db->where($wheredata)->get('tbl_registration')->row();
							$output['res']='success';
							$output['msg']='Profile Updated';
							$output['data']=$values;
						}
						else{
							$output['msg']='Updation Failed';	
						}
					}
					else
					{
						$output['msg']='Invalid User ID';
					}
				}
				else
				{
					$msg=explode('</p>',validation_errors());
					$output['msg']=str_ireplace('<p>','', $msg[0]);
				}
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		
		# OTP Verification
		
		public function OTPVerification()
		{
			$output['res']="error";
            $output['msg']="error";
            $output['data']="";
			
			if(empty($_POST))
			{
				$output['msg']='Something Went Wrong. Try Again!';
			}
			else
			{
				if($this->form_validation->run('otp_verification')) 
				{
					$mobile=$this->input->post('mobile');
					$otp=$this->input->post('otp');
					
					$wheredata=array('number'=>$mobile);
					$result=$this->db->where($wheredata)->get('tbl_registration');
					if($result->num_rows())
					{
						$values=$result->row();
						if($values->otp==$otp)
						{
							$upresult=$this->db->where($wheredata)->update('tbl_registration',['otp_status'=>'true','CurrentStatus'=>'true']);
							
							$output['res']='success';
							$output['msg']='You have been successfully registered.';
							$output['data']=array($values);
						}
						else
						{
							$output['msg']='OTP is invalid';
						}
					}
					else
					{
						$output['msg']='Please registered this mobile no.';
					}
				}
				else
				{
					$msg=explode('</p>',validation_errors());
					$output['msg']=str_ireplace('<p>','', $msg[0]);
				}
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		# Resend OTP
		
		public function ResendOTP()
		{
			$output['res']="error";
            $output['msg']="error";
            $output['data']="";
			
			if(empty($_POST))
			{
				$output['msg']='Something Went Wrong. Try Again!';
			}
			else
			{
				if($this->form_validation->run('login')) 
				{
					$mobile=$this->input->post('mobile');
					
					$wheredata=array('number'=>$mobile);
					
					$result=$this->db->where($wheredata)->get('tbl_registration');
					if($result->num_rows())
					{
						$values=$result->row();
						
						$otp=$values->otp;
						
						$msg=$otp;
						$this->codersadda->SendSMS2($mobile,$msg);
						
						$output['res']='success';
						$output['msg']='OTP Resend Successfully.';
						
					}
					else
					{
						$output['msg']='Please registered this mobile no.';
					}
				}
				else
				{
					$msg=explode('</p>',validation_errors());
					$output['msg']=str_ireplace('<p>','', $msg[0]);
				}
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		
		# Forgot Password
		
		public function ForgotPassword()
		{
			$output['res']="error";
            $output['msg']="error";
            $output['data']="";
			
			if(empty($_POST))
			{
				$output['msg']='Something Went Wrong. Try Again!';
			}
			else
			{
				if($this->form_validation->run('login')) 
				{
					$mobile=$this->input->post('mobile');
					
					$wheredata=array('number'=>$mobile);
					
					$result=$this->db->where($wheredata)->get('tbl_registration');
					
					if($result->num_rows())
					{
						$values=$result->row();
						
						$otp=rand(1000,9999);
						
						$msg=$otp;
						$this->codersadda->SendSMS2($mobile,$msg);
						
						$token=rand(100000,999999);
						
						$this->db->where($wheredata)->update("tbl_registration", array("fp_otp"=>$otp,"fp_token"=>$token));
						
						$output['res']='success';
						$output['msg']='OTP Send on '.$mobile;
						
						
					}
					else
					{
						$output['msg']='Please registered this mobile no.';
					}
				}
				else
				{
					$msg=explode('</p>',validation_errors());
					$output['msg']=str_ireplace('<p>','', $msg[0]);
				}
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		# Forgot Password OTP Verification
		
		public function FpOTPVerification()
		{
			$output['res']="error";
            $output['msg']="error";
            $output['data']="";
			
			if(empty($_POST))
			{
				$output['msg']='Something Went Wrong. Try Again!';
			}
			else
			{
				if($this->form_validation->run('otp_verification')) 
				{
					$mobile=$this->input->post('mobile');
					$otp=$this->input->post('otp');
					
					$wheredata=array('number'=>$mobile);
					$result=$this->db->where($wheredata)->get('tbl_registration');
					if($result->num_rows())
					{
						$values=$result->row();
						if($values->fp_otp==$otp)
						{							
							$output['res']='success';
							$output['msg']='OTP Verification Success.';
							$output["data"]=array("fp_token"=>$values->fp_token);
							
						}
						else
						{
							$output['msg']='OTP is invalid';
						}
					}
					else
					{
						$output['msg']='Please registered this mobile no.';
					}
				}
				else
				{
					$msg=explode('</p>',validation_errors());
					$output['msg']=str_ireplace('<p>','', $msg[0]);
				}
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		# ForgotPassword Resend OTP
		
		public function FpResendOTP()
		{
			$output['res']="error";
            $output['msg']="error";
            $output['data']="";
			
			if(empty($_POST))
			{
				$output['msg']='Something Went Wrong. Try Again!';
			}
			else
			{
				if($this->form_validation->run('login')) 
				{
					$mobile=$this->input->post('mobile');
					
					$wheredata=array('number'=>$mobile);
					
					$result=$this->db->where($wheredata)->get('tbl_registration');
					if($result->num_rows())
					{
						$values=$result->row();
						
						$otp=$values->fp_otp;
						
						$msg=$otp;
						$this->codersadda->SendSMS2($mobile,$msg);
						
						$output['res']='success';
						$output['msg']='OTP Resend Successfully.';
						
					}
					else
					{
						$output['msg']='Please registered this mobile no.';
					}
				}
				else
				{
					$msg=explode('</p>',validation_errors());
					$output['msg']=str_ireplace('<p>','', $msg[0]);
				}
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		# Reset Password
		
		public function ResetPassword()
		{
			$output['res']="error";
            $output['msg']="error";
            $output['data']="";
			
			if(empty($_POST))
			{
				$output['msg']='Something Went Wrong. Try Again!';
			}
			else
			{
				if($this->form_validation->run('resetpassword')) 
				{
					$mobile=$this->input->post('mobile');
					$fp_token=$this->input->post('fp_token');
					$newpassword=$this->input->post('newpassword');
					
					$wheredata=array('number'=>$mobile);
					
					$result=$this->db->where($wheredata)->get('tbl_registration');
					if($result->num_rows())
					{
						$values=$result->row();
						
						
						if($values->fp_token==$fp_token)
						{
							$this->db->where($wheredata)->update("tbl_registration", array("password"=>$newpassword));
							
							$output['res']='success';
							$output['msg']='Password Reset Successfully.';
							
						}
						else
						{
							$output['res']='error';
							$output['msg']='Invalid Token.';
							
						}
					}
					else
					{
						$output['msg']='Please registered this mobile no.';
					}
				}
				else
				{
					$msg=explode('</p>',validation_errors());
					$output['msg']=str_ireplace('<p>','', $msg[0]);
				}
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		
		
		# Slider
		
		public function Slider()
		{
			$output['res']="error";
            $output['msg']="error";
            $output['data']="";
			
			$result=$this->db->where(['type'=>'App','status'=>'true'])->order_by("id", "DESC")->get('tbl_slider');
			$count=$result->num_rows();
			if($count)
			{
				$output['res']='success';
				$output['msg']=$count.' Slider Found';
				
				
				$i=0;
				$return=[];
				foreach($result->result() as $item)
				{
					
					$return[$i]=$item;
					if($item->parameter=='Course' or $item->parameter=='Ebook' or  $item->parameter=='Abook')
					{
					    $presult=$this->db->where(['itemid'=>$item->link,'itemtype'=>$item->parameter,'userid'=>$this->userid])->get("tbl_enroll");
					    if($presult->num_rows()){
					        $purchase='true';
					    }
					    else{
					        $purchase='false';
					    }
					    $return[$i]->purchase=$purchase;
					}
					
					
					
					$i++;
				}
				$output['data']=$return;
			}
			else{
				$output['msg']="No Record Found";
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		public function Offers()
		{
			$output['res']="error";
            $output['msg']="error";
            $output['data']="";
			
			$result=$this->db->where(['status'=>'true'])->order_by("id", "DESC")->get('tbl_offer');
			$count=$result->num_rows();
			if($count)
			{
				$output['res']='success';
				$output['msg']=$count.' Offer Found';
				
				
				$i=0;
				$return=[];
				foreach($result->result() as $item){
					
					$return[$i]=$item;
					$i++;
				}
				$output['data']=$return;
			}
			else{
				$output['msg']="No Record Found";
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		
		
		# AverageReview
		
		public function AverageReview($itemtype,$itemid)
		{
			$reviewResult=$this->db->where(['itemtype'=>$itemtype,'itemid'=>$itemid])->get("tbl_review");
			$reviewValues=$reviewResult->row();
			
			$sumOfRating=0;
			$rating=0;
			$ratingcount=$reviewResult->num_rows();
			if($ratingcount)
			{				
				foreach($reviewResult->result() as $review)
				{
					$sumOfRating+=$review->rating;
				}
				$rating=($sumOfRating/$ratingcount);
			}
			
			if($rating==0){
				$rating=rand(3.5,5);
			}
			if($ratingcount==0){
				$ratingcount=rand(1,10);
			}
			$rating=ceil($rating);
			return ['rating'=>$rating,'ratingcount'=>$ratingcount];
		}
		
		# Enrolled Items 
		
		public function EnrolledItems($itemtype,$userid)
		{
			$enrolledResult=$this->db->where(['itemtype'=>$itemtype,'userid'=>$userid,'paymentstatus'=>'success'])->get("tbl_enroll");
			$enrolledValues=$enrolledResult->result();
			$EnrolledItems=[0];
			foreach($enrolledValues as $enroll){
				$EnrolledItems[]=$enroll->itemid;
			}
			
			return $EnrolledItems;
		}
		
		
		#Notification
		
		public function Notification()
		{
			$output['res']="error";
            $output['msg']="error";
            $output['data']="";
			$whereData=[
			'status'=>'true'
			];
			$result=$this->db->where(['status'=>'true','for_user'=>'Student'])->where("FIND_IN_SET('".$this->userid."',users)!=",0)->order_by("id", "DESC")->get('tbl_notification');
			$count=$result->num_rows();
			if($count)
			{
				$output['res']='success';
				$output['msg']=$count.' Notification Found';
				$i=0;
				$return=[];
				foreach($result->result() as $notification){
					$return[$i]=$notification;
					$return[$i]->since=$this->codersadda->humanTiming (strtotime($notification->date.' '.$notification->time));
					$i++;
				}
				$output['data']=$return;
			}
			else{
				$output['msg']="No Record Found";
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		
		# Categories
		
		public function Categories()
		{
			$output['res']="error";
            $output['msg']="error";
            $output['data']="";
			$EnrolledItemsC=$this->EnrolledItems('Course',$this->userid);
			$EnrolledItemsE=$this->EnrolledItems('Ebook',$this->userid);
			$result=$this->db->where(['status'=>'true'])->order_by("title", "ASC")->get('tbl_category');
			$count=$result->num_rows();
			if($count)
			{
				$output['res']='success';
				$output['msg']=$count.' Record Found';
				
				$i=0; $return=[];
				foreach($result->result() as $item)
				{
					$return[$i]=$item;
					$return[$i]->courses=$this->db->where(['category'=>$item->id,'apprstatus'=>'true'])->where_not_in('id',$EnrolledItemsC)->order_by("id", "DESC")->get('tbl_course')->num_rows();
					$return[$i]->ebooks=$this->db->where(['category'=>$item->id,'apprstatus'=>'true'])->where_not_in('id',$EnrolledItemsE)->order_by("id", "DESC")->get('tbl_ebook')->num_rows();
					$i++;
				}
				$output['data']=$return;
			}
			else{
				$output['msg']="No Record Found";
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		# Educators
		
		public function Educators()
		{
			$output['res']="error";
            $output['msg']="error";
            $output['data']="";
			
			$result=$this->db->where(['status'=>'true'])->order_by("name", "ASC")->get('tbl_tutor');
			$count=$result->num_rows();
			if($count)
			{
				$output['tutorimagepath']=base_url()."uploads/tutor/";
				$output['res']='success';
				$output['msg']=$count.' Record Found';				
				$output['data']=$result->result();
			}
			else{
				$output['msg']="No Record Found";
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		# Educators wise Courses
		
		public function CourseByEducators()
		{
			$output['res']="error";
            $output['msg']="error";
            $output['data']="";
			if(empty($_POST))
			{
				$output['msg']='Something Went Wrong. Try Again !';
			}
			else
			{
				if($this->form_validation->run('educator')) 
				{
					$educatorid=$this->input->post('educatorid');
					
					$EnrolledItems=$this->EnrolledItems('Course',$this->userid);
					
					$result=$this->db->where(['author'=>$educatorid,'apprstatus'=>'true'])->where_not_in('id',$EnrolledItems)->order_by("id", "DESC")->get('tbl_course');
					$count=$result->num_rows();
					if($count)
					{
						$output['res']='success';
						$output['msg']=$count.' Record Found';
						$i=0;
						$return=[];
						foreach($result->result() as $item)
						{
							$AverageReview=$this->AverageReview('Course',$item->id);
							$return[$i]=$item;		
							$return[$i]->rating=$AverageReview['rating'];		
							$return[$i]->totalrating=$AverageReview['ratingcount'];		
							$i++;
						}
						
						$output['data']=$return;
					}
					else{
						$output['msg']="No Record Found";
					}
					
				}
				else
				{
					$msg=explode('</p>',validation_errors());
					$output['msg']=str_ireplace('<p>','', $msg[0]);
				}
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
			
			
		}
		
		# All Courses
		public function AllCourses()
		{
			$output['res']="error";
            $output['msg']="error";
            $output['data']="";
			
			$EnrolledItems=$this->EnrolledItems('Course',$this->userid);
			if(empty($this->input->post('type'))){
			    $whereData=['apprstatus'=>'true'];
			}
			else{
			    $whereData=['apprstatus'=>'true','type'=>$this->input->post('type')];
			}
			$result=$this->db->where($whereData)->where_not_in('id',$EnrolledItems)->order_by("id", "DESC")->get('tbl_course'); 
			$count=$result->num_rows();
			if($count)
			{
				$output['res']='success';
				$output['msg']=$count.' Record Found';
				
				$i=0;
				$return=[];
				foreach($result->result() as $item)
				{
					$AverageReview=$this->AverageReview('Course',$item->id);
					$return[$i]=$item;	
					$return[$i]->discountpercent=$this->codersadda->DiscountPercent($item->discountpercent);	
					$return[$i]->rating=$AverageReview['rating'];		
					$return[$i]->totalrating=$AverageReview['ratingcount'];		
					$i++;
				}
				$output['data']=$return;
			}
			else{
				$output['msg']="No Record Found";
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		# Trending Courses
		
		public function TrendingCourses()
		{
			$output['res']="error";
            $output['msg']="error";
            $output['data']="";
			
			$EnrolledItems=$this->EnrolledItems('Course',$this->userid);
			
			$result=$this->db->where(['apprstatus'=>'true'])->where_not_in('id',$EnrolledItems)->where_not_in('trending',['Trending','trending'])->order_by("trending", "ASC")->get('tbl_course');
			$count=$result->num_rows();
			if($count)
			{
				$output['res']='success';
				$output['msg']=$count.' Record Found';
				
				$i=0;
				$return=[];
				foreach($result->result() as $item)
				{
					$AverageReview=$this->AverageReview('Course',$item->id);
					$return[$i]=$item;	
					$return[$i]->discountpercent=$this->codersadda->DiscountPercent($item->discountpercent);	
					$return[$i]->rating=$AverageReview['rating'];		
					$return[$i]->totalrating=$AverageReview['ratingcount'];		
					$i++;
				}
				$output['data']=$return;
			}
			else{
				$output['msg']="No Record Found";
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		# Top Courses
		
		public function TopCourses()
		{
			$output['res']="error";
            $output['msg']="error";
            $output['data']="";
			
			$EnrolledItems=$this->EnrolledItems('Course',$this->userid);
			$result=$this->db->where(['apprstatus'=>'true'])->where_not_in('id',$EnrolledItems)->where_not_in('top',['Top','top'])->order_by("top", "ASC")->get('tbl_course');
			$count=$result->num_rows();
			if($count)
			{
				$output['res']='success';
				$output['msg']=$count.' Record Found';
				
				$i=0;
				$return=[];
				foreach($result->result() as $item)
				{
					$AverageReview=$this->AverageReview('Course',$item->id);
					$return[$i]=$item;	
					$return[$i]->discountpercent=$this->codersadda->DiscountPercent($item->discountpercent);	
					$return[$i]->rating=$AverageReview['rating'];		
					$return[$i]->totalrating=$AverageReview['ratingcount'];		
					$i++;
				}
				
				$output['data']=$return;
			}
			else{
				$output['msg']="No Record Found";
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		# Latest Courses
		
		public function LatestCourses()
		{
			$output['res']="error";
            $output['msg']="error";
            $output['data']="";
			
			$EnrolledItems=$this->EnrolledItems('Course',$this->userid);
			$result=$this->db->where(['apprstatus'=>'true'])->where_not_in('id',$EnrolledItems)->order_by("id", "DESC")->get('tbl_course');
			$count=$result->num_rows();
			if($count)
			{
				$output['res']='success';
				$output['msg']=$count.' Record Found';
				$i=0;
				$return=[];
				foreach($result->result() as $item)
				{
					$AverageReview=$this->AverageReview('Course',$item->id);
					$return[$i]=$item;	
					$return[$i]->discountpercent=$this->codersadda->DiscountPercent($item->discountpercent);	
					$return[$i]->rating=$AverageReview['rating'];		
					$return[$i]->totalrating=$AverageReview['ratingcount'];		
					$i++;
				}
				
				$output['data']=$return;
			}
			else
			{
				$output['msg']="No Record Found";
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		public function LatestEBook()
		{
			$output['res']="error";
            $output['msg']="error";
            $output['data']="";
			
			$EnrolledItems=$this->EnrolledItems('Ebook',$this->userid);
			$result=$this->db->where(['apprstatus'=>'true'])->where_not_in('id',$EnrolledItems)->order_by("id", "DESC")->get('tbl_ebook');
			$count=$result->num_rows();
			if($count)
			{
				$output['res']='success';
				$output['msg']=$count.' Record Found';
				$i=0;
				$return=[];
				foreach($result->result() as $item)
				{
					$AverageReview=$this->AverageReview('Ebook',$item->id);
					$return[$i]=$item;	
					$return[$i]->discountpercent=$this->codersadda->DiscountPercent($item->discountpercent);	
					$return[$i]->rating=$AverageReview['rating'];		
					$return[$i]->totalrating=$AverageReview['ratingcount'];		
					$i++;
				}
				
				$output['data']=$return;
			}
			else
			{
				$output['msg']="No Record Found";
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		public function LatestABook()
		{
			$output['res']="error";
            $output['msg']="error";
            $output['data']="";
			
			$EnrolledItems=$this->EnrolledItems('Abook',$this->userid);
			$result=$this->db->where(['apprstatus'=>'true'])->where_not_in('id',$EnrolledItems)->order_by("id", "DESC")->get('tbl_abook');
			$count=$result->num_rows();
			if($count)
			{
				$output['res']='success';
				$output['msg']=$count.' Record Found';
				$i=0;
				$return=[];
				foreach($result->result() as $item)
				{
					$AverageReview=$this->AverageReview('Abook',$item->id);
					$return[$i]=$item;	
					$return[$i]->discountpercent=$this->codersadda->DiscountPercent($item->discountpercent);	
					$return[$i]->rating=$AverageReview['rating'];		
					$return[$i]->totalrating=$AverageReview['ratingcount'];		
					$i++;
				}
				
				$output['data']=$return;
			}
			else
			{
				$output['msg']="No Record Found";
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		# Category wise Courses
		
		public function CourseByCategory()
		{
			$output['res']="error";
            $output['msg']="error";
            $output['data']="";
			if(empty($_POST))
			{
				$output['msg']='Something Went Wrong. Try Again !';
			}
			else
			{
				if($this->form_validation->run('category')) 
				{
					$categoryid=$this->input->post('categoryid');
					$EnrolledItems=$this->EnrolledItems('Course',$this->userid);
					$result=$this->db->where(['category'=>$categoryid,'apprstatus'=>'true'])->where_not_in('id',$EnrolledItems)->order_by("id", "DESC")->get('tbl_course');
					$count=$result->num_rows();
					if($count)
					{
						$output['res']='success';
						$output['msg']=$count.' Record Found';
						$i=0;
						$return=[];
						foreach($result->result() as $item)
						{
							$AverageReview=$this->AverageReview('Course',$item->id);
							$return[$i]=$item;		
							$return[$i]->rating=$AverageReview['rating'];		
							$return[$i]->totalrating=$AverageReview['ratingcount'];		
							$i++;
						}
						
						$output['data']=$return;
					}
					else{
						$output['msg']="No Record Found";
					}
					
				}
				else
				{
					$msg=explode('</p>',validation_errors());
					$output['msg']=str_ireplace('<p>','', $msg[0]);
				}
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
			
			
		}
		
		# Course Full Details
		
		
		public function CourseFullDetails()
		{
			$output['res']="error";
            $output['msg']="error";
            $output['data']="";
            
			if(empty($_POST))
			{
				$output['msg']='Something Went Wrong. Try Again !';
			}
			else
			{
				if($this->form_validation->run('course')) 
				{
					$courseid=$this->input->post('courseid');
					
					$result=$this->db->where("id",$courseid)->get('tbl_course');
					$count=$result->num_rows();
					if($count)
					{
						$output['res']='success';
						$output['msg']=$count.' Record Found';
						
						// Hold Data in Data Variable
						$data=$result->result();
						
						$data[0]->discountpercent=$this->codersadda->DiscountPercent($data[0]->discountpercent);
						$getYoutubeLinkData=$this->Auth_model->getYoutubeLinkData($data[0]->demovedio);
                        $data[0]->YoutubeId=$getYoutubeLinkData->id;
						// Find Author Details
						$author=$data[0]->author;					
						$result1=$this->db->where("id",$author)->get("tbl_tutor");
						$data[0]->authordetails=$result1->result()[0];
						
						// Find Play List
						$result2=$this->db->where("course",$courseid)->get("tbl_lecture");
						$data1=array();
						foreach($result2->result() as $video)
						{
							$vid=$video->video;
							$result3=$this->db->where("id",$vid)->get("tbl_video");
							$data2=$result3->result()[0];
							
							// Find and Add Subject Details
							$subid=$result3->result()[0]->subject;
							$result4=$this->db->where("id",$subid)->get("tbl_subject");
							$data2->subjectdetails=$result4->result()[0];
							
							$data1[]=$data2;
							
						}
						$data[0]->videoplaylist=$data1;
						
						
						// Find Category Details
						$category=$data[0]->category;					
						$result5=$this->db->where("id",$category)->get("tbl_category");
						$data[0]->categorydetails=$result5->result()[0];
						
						
						// Find and Add Reviews 
						$reviewResult=$this->db->where(['itemtype'=>'Course','itemid'=>$courseid])->get("tbl_review");
						$reviewValues=$reviewResult->row();
						
						$reviewData=array();
						$sumOfRating=0;
						$average=0;
						$ratingcount=$reviewResult->num_rows();
						if($reviewResult->num_rows()){
							
							foreach($reviewResult->result() as $review)
							{
								$userResult=$this->db->where(['id'=>$review->userid])->get("tbl_registration");
								
								if($userResult->num_rows()){
									$userValues=$userResult->row();
									$reviewData[]=['name'=>$userValues->name,'profile_photo'=>$userValues->profile_photo,'rating'=>$review->rating,'review'=>$review->review,'date'=>$review->date,'time'=>$review->time];
									
								}
								$sumOfRating+=$review->rating;
								
							}
							$average=($sumOfRating/$reviewResult->num_rows());
						}
						
						
						if($average==0){
							$average=rand(3.5,5);
						}
						if($ratingcount==0){
							$ratingcount=rand(1,10);
						}
						$average=ceil($average);
						
						$data[0]->reviewdetails=['list'=>$reviewData,'count'=>$ratingcount,'average'=>$average]; 
						
						$wishlistResult=$this->db->where(['itemtype'=>'Course','itemid'=>$courseid,'status'=>'true','userid'=>$this->userid])->get("tbl_wishlist");	
						if($wishlistResult->num_rows()){
							$wishliststatus='true';
						}
						else{
							$wishliststatus='false';	
						}
						
						$data[0]->wishliststatus=$wishliststatus;
						
						if(strtotime($data[0]->timing)>=time()){
						   $upcoming='true'; 
						}
						else{
						    $upcoming='false';
						}
						$data[0]->upcoming=$upcoming; 
						$output['data']=$data;
						
						
					}
					else{
						$output['msg']="No Record Found";
					}
					
				}
				else
				{
					$msg=explode('</p>',validation_errors());
					$output['msg']=str_ireplace('<p>','', $msg[0]);
				}
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
			
			
			
		}
		
		
		# Coupon Code Validation
		
		
		public function CouponValidation()
		{
			$output['res']="error";
            $output['msg']="error";
            $output['data']="";
			if(empty($_POST))
			{
				$output['msg']='Something Went Wrong. Try Again !';
			}
			else
			{
				if($this->form_validation->run('coupon')) 
				{
					$couponcode=$this->input->post('couponcode');
					
					$result=$this->db->where("coupon",$couponcode)->get('tbl_offer');
					$count=$result->num_rows();
					
					if($count)
					{
						$couponData=$result->row();
						if(!empty($this->input->post('type'))){
							if($this->input->post('type')=='OrderHistory'){
								$output['res']='success';
								$output['msg']='Coupon Data';
								
								$output['data']=array("discount"=>$result->result()[0]->discount,"discount_type"=>$result->result()[0]->discount_type,"upto"=>$result->result()[0]->upto);
							}
							else{
								$output['msg']="Type Error";
							}
						}
						else{
							if(strtotime($result->result()[0]->expiry_date)>=strtotime(date('Y-m-d')))
							{
								
								$enrollResult=$this->db->where(['userid'=>$this->userid,'paymentstatus'=>'success','couponcode'=>$couponcode])->get('tbl_enroll');
								if($enrollResult->num_rows()){
									$output['msg']="Coupon Code Already Used";
								}
								else{
									if(($result->result()[0]->no_of_coupon)>($result->result()[0]->used_coupon))
									{
										$valid=false;
										if($couponData->type=='Educator')
										{
											$itemtype=$this->input->post('itemtype');
											$itemid=$this->input->post('itemid');
											if($itemtype=='Abook'){
												$table_name='tbl_abook';
											}
											else if($itemtype=='Ebook'){
												$table_name='tbl_ebook';
											}
											else{
												$table_name='tbl_course';
											} 
											
											
											$itemResult=$this->db->where(['author'=>$couponData->educator_id])->get($table_name);
											if($itemResult->num_rows())
											{
												$valid=true;
											}
											else{
												$valid=false;
											}
										} 
										else{
											$valid=true;
										}
										
										if($valid==true)
										{
											$output['res']='success';
											$output['msg']='Coupon Code Valid';
											
											$output['data']=array("discount"=>$result->result()[0]->discount,"discount_type"=>$result->result()[0]->discount_type,"upto"=>$result->result()[0]->upto);
										}
										else{
											$output['msg']="Coupon Code Invalid";
										}
										
									}
									else{
										$output['msg']="Coupon Code Expired";
									}
								}
							}
							else{
								$output['msg']="Coupon Code Expired";
							}
						}
						
					} 
					else{
						$output['msg']="Coupon Code Invalid";
					}
					
				}
				else
				{
					$msg=explode('</p>',validation_errors());
					$output['msg']=str_ireplace('<p>','', $msg[0]);
				}
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
			
			
		}
		
		# Enroll Student in Course
		
		
		public function EnrollStudent()
		{
			$table="tbl_enroll";
			
			$output['res']="error";
			$output['msg']="error";
			$output['data']="";
			if(empty($_POST))
			{
				$output['msg']='Something Went Wrong. Try Again !';
			}
			else
			{
				if($this->form_validation->run('enrollcourse')) 
				{
					$result=$this->db->order_by("id", "DESC")->limit(1)->get($table);
					if($result->num_rows()>0)
					{
						$lastid=$result->result()[0]->id;
						$lastid=(int)$lastid+1;
						$orderid="CA_Order_".$lastid."_".date("dmYhis");
					}
					else
					{
						$orderid="CA_Order_1_".date("dmYhis");
					}
					
					if(empty($this->input->post('itemtype'))){
						$itemtype='Course';
						$item_table='tbl_course';
					}
					else{
						$itemtype=$this->input->post('itemtype');
						if($itemtype=='Course'){
							$item_table='tbl_course';
						}
						else if($itemtype=='Ebook'){
							$item_table='tbl_ebook';
						}
						else{
							$item_table='tbl_abook';
						}
					}
					$whereData=[
					'id'=>$this->input->post('courseid')
					];
					$results=$this->db->where($whereData)->get($item_table)->result();
					if(empty($results)){
						$output['msg']="Item is invalid";
					}
					else{
						$EnrolledItems=$this->EnrolledItems($itemtype,$this->userid);
						if(in_array($this->input->post('courseid'),$EnrolledItems))
						{
							$output['msg']="You have already enrolled this item.";
						}
						else{
							$type=$results[0]->type;
							$itemprice=$this->input->post('price');
							if($type=='Paid'){
								$rzp_orderid=$this->razorpay->getRazorpayOrderID($orderid,$itemprice);
								$paymentid='Pending';
								$paymentstatus='Pending';
							}
							else{
								$rzp_orderid=$orderid;
								$paymentid='Free';
								$paymentstatus='success';
							}
							
							$data_to_insert = array(
							"author" => $results[0]->author,
							"userid" => $this->input->post('userid'),
							"mobile" => $this->input->post('mobile'),
							"firstname" => $this->input->post('firstname'),
							"lastname" => $this->input->post('lastname'),
							"email" => $this->input->post('emailid'),
							"qualification" => $this->input->post('qualification'),
							"itemid" => $this->input->post('courseid'),
							"itemtype" => $itemtype,
							"couponcode" => $this->input->post('couponcode'),
							"price" => $itemprice,
							"orderid" => $orderid,
							"rzp_orderid" => $rzp_orderid,
							"paymentid" => $paymentid,
							"paymentstatus" => $paymentstatus,
							"date" => $this->dateY,
							"time" => $this->time,
							);
							
							$data_to_insert = $this->security->xss_clean($data_to_insert);
							
							if($this->db->insert($table,$data_to_insert))
							{
								$output['res']="success";
								$output['msg']="Order Created";
								$output['data']=array("OrderId"=>$rzp_orderid,'ApiKey'=>$this->razorpay->rzp_api_key);
							}
							else
							{
								$output['msg']="Something Went Wrong";
							}	
						}
					}
					
					
				}
				else
				{
					$msg=explode('</p>',validation_errors());
					$output['msg']=str_ireplace('<p>','', $msg[0]);
				}
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
			
		}
		
		# Payment API Key Razorpay
		
		public function RazorPayAPIKey()
		{
			$output['res']="error";
			$output['msg']="error";
			$output['data']="";
			
			if(true)
			{
				$output['res']='success';
				$output['msg']='Key Found';
				
				$output['data']=array("razorpay_key"=>$this->razorpay->rzp_api_key);
				
			}
			else{
				$output['msg']="No Data Found";
			}
			
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		
		# Update Payment Status
		
		
		public function PaymentStatusUpdate()
		{
			$table="tbl_enroll";
			
			$output['res']="error";
			$output['msg']="error";
			$output['data']="";
			if(empty($_POST))
			{
				$output['msg']='Something Went Wrong. Try Again !';
			}
			else
			{
				if($this->form_validation->run('paymentstatus')) 
				{
					$orderid=$this->input->post('orderid');
					$paymentid=$this->input->post('paymentid');
					$mobile=$this->input->post('mobile');
					$status=$this->input->post('status');
					$rzp_order=$this->razorpay->getRazorpayOrder($orderid);
					if($rzp_order->status=='paid'){
						$status='success';
					}
					else{
						$status='failed';
					}
					$wheredata="rzp_orderid='$orderid' and mobile='$mobile'";
					# Coupon Code Used entry for success transaction
					if($status=='success'){
						$enrollData=$this->db->where($wheredata)->order_by("id", "DESC")->limit(1)->get($table)->result();
						if(empty($enrollData[0]->couponcode)){
							
						}
						else{
							$couponcode=$enrollData[0]->couponcode;
							$couponData=$this->db->where('coupon', $couponcode)->order_by("id", "DESC")->limit(1)->get('tbl_offer')->result();
							$used_coupon=$couponData[0]->used_coupon;
							$no_of_coupon=$couponData[0]->no_of_coupon;
							$data_to_update=array(
							"used_coupon" => $used_coupon+1,
							"no_of_coupon" => $no_of_coupon-1
							);
							$query=$this->db->where('coupon',$couponcode)
							->update('tbl_offer',$data_to_update);
						}
					}
					
					$updatedata=array("paymentstatus"=>$status, "paymentid"=>$paymentid);
					if($this->db->where($wheredata)->update($table,$updatedata))
					{
						$result=$this->db->where("rzp_orderid",$orderid)->get($table);
						$count=$result->num_rows();
						if($count)
						{
							$data=$result->result();
							$itemtype=$data[0]->itemtype;
							
							// Find Item Details
							
							if($itemtype=="Course")
							{
								$itemid=$data[0]->itemid;
								$result1=$this->db->where("id",$itemid)->get("tbl_course");
								$data[0]->coursedetails=$result1->result()[0];
							}
							else if($itemtype=="Ebook")
							{
								$itemid=$data[0]->itemid;
								$result1=$this->db->where("id",$itemid)->get("tbl_ebook");
								$data[0]->ebookdetails=$result1->result()[0];
							}
							else if($itemtype=="Abook")
							{
								$itemid=$data[0]->itemid;
								$result1=$this->db->where("id",$itemid)->get("tbl_abook");
								$data[0]->abookdetails=$result1->result()[0];
							}
							
							$output['res']="success";
							$output['msg']="Payment Status Updated";
							$output['data']=$data;
							
						}
						else
						{
							$output['msg']="Data Not Found";
						}
						
						
					}
					else
					{
						$output['msg']="Something Went Wrong";
					}
				}
				else
				{
					$msg=explode('</p>',validation_errors());
					$output['msg']=str_ireplace('<p>','', $msg[0]);
				}
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
			
		}
		
		# Free Payment Status Update
		
		public function FreePaymentStatusUpdate()
		{
			$table="tbl_enroll";
			
			$output['res']="error";
			$output['msg']="error";
			$output['data']="";
			if(empty($_POST))
			{
				$output['msg']='Something Went Wrong. Try Again !';
			}
			else
			{
				if($this->form_validation->run('freepaymentstatus')) 
				{
					$orderid=$this->input->post('orderid');
					$paymentid='Free';
					$mobile=$this->input->post('mobile');
					$status='success';
					$wheredata="rzp_orderid='$orderid' and mobile='$mobile'";
					# Coupon Code Used entry for success transaction
					if($status=='success'){
						$enrollData=$this->db->where($wheredata)->order_by("id", "DESC")->limit(1)->get($table)->result();
						if(empty($enrollData[0]->couponcode)){
							
						}
						else{
							$couponcode=$enrollData[0]->couponcode;
							$couponData=$this->db->where('coupon', $couponcode)->order_by("id", "DESC")->limit(1)->get('tbl_offer')->result();
							$used_coupon=$couponData[0]->used_coupon;
							$data_to_update=array(
							"used_coupon" => $used_coupon+1
							);
							$query=$this->db->where('coupon',$couponcode)
							->update('tbl_offer',$data_to_update);
						}
					}
					
					$updatedata=array("paymentstatus"=>$status, "paymentid"=>$paymentid);
					if($this->db->where($wheredata)->update($table,$updatedata))
					{
						$result=$this->db->where("rzp_orderid",$orderid)->get($table);
						$count=$result->num_rows();
						if($count)
						{
							$data=$result->result();
							$itemtype=$data[0]->itemtype;
							
							// Find Item Details
							
							if($itemtype=="Course")
							{
								$itemid=$data[0]->itemid;
								$result1=$this->db->where("id",$itemid)->get("tbl_course");
								$data[0]->coursedetails=$result1->result()[0];
							}
							else if($itemtype=="Ebook")
							{
								$itemid=$data[0]->itemid;
								$result1=$this->db->where("id",$itemid)->get("tbl_ebook");
								$data[0]->ebookdetails=$result1->result()[0];
							}
							else if($itemtype=="Abook")
							{
								$itemid=$data[0]->itemid;
								$result1=$this->db->where("id",$itemid)->get("tbl_abook");
								$data[0]->abookdetails=$result1->result()[0];
							}
							
							$output['res']="success";
							$output['msg']="Payment Status Updated";
							$output['data']=$data;
							
						}
						else
						{
							$output['msg']="Data Not Found";
						}
						
						
					}
					else
					{
						$output['msg']="Something Went Wrong";
					}
				}
				else
				{
					$msg=explode('</p>',validation_errors());
					$output['msg']=str_ireplace('<p>','', $msg[0]);
				}
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		#Wishlist
		
		public function Wishlist()
		{
			$table="tbl_wishlist";
			
			$output['res']="error";
			$output['msg']="error";
			$output['data']="";
			
			if($this->uri->segment(4)){
				
				$action=$this->uri->segment(4);
				if(empty($_POST))
				{
					$output['msg']='Something Went Wrong. Try Again !';
				}
				else{
					if($action=='Add'){
						if($this->form_validation->run('addWishlist')) 
						{
							$whereData=[
							'userid'=>$this->input->post('userid'),
							"itemid" => $this->input->post('itemid'),
							'itemtype'=>$this->input->post('itemtype'),
							];
							$result=$this->db->where($whereData)->get($table);
							$count=$result->num_rows();
							if($count)
							{
								$output['msg']="Item already added to your wishlist";
							}
							else{ 
								$data_to_insert = array(
								"userid" => $this->input->post('userid'),
								"itemid" => $this->input->post('itemid'),
								"itemtype" => $this->input->post('itemtype'),
								"status" => "true",
								"date" => $this->date,
								"time" => $this->time,
								);
								
								$data_to_insert = $this->security->xss_clean($data_to_insert);
								
								if($this->db->insert($table,$data_to_insert))
								{
									$output['res']="success";
									$output['msg']="Item added to your wishlist";
								}
								else
								{
									$output['msg']="Try !again";
								}
							}
						}
						else{
							$msg=explode('</p>',validation_errors());
							$output['msg']=str_ireplace('<p>','', $msg[0]);
						}
					}
					else if($action=='Remove'){
						if($this->form_validation->run('removeWishlist')) 
						{
							$whereData=[
							'id'=>$this->input->post('id'),
							];
							$result=$this->db->where($whereData)->delete($table);
							if($result)
							{
								$output['res']="success";
								$output['msg']="Item removed to your wishlist";
							}
							else
							{
								$output['msg']="Try !again";
							}
							
						}
						else{
							$msg=explode('</p>',validation_errors());
							$output['msg']=str_ireplace('<p>','', $msg[0]);
						}
					}
					else if($action=='List'){
						if($this->form_validation->run('listWishlist')) 
						{
							if(empty($this->input->post('itemtype'))){
								$whereData=[
								'userid'=>$this->input->post('userid'),
								];
							}
							else{
								$whereData=[
								'userid'=>$this->input->post('userid'),
								'itemtype'=>$this->input->post('itemtype'),
								];
								
							}
							if($this->input->post('itemtype')=='Ebook'){
								$itemtype_table='tbl_ebook';
							}
							else if($this->input->post('itemtype')=='Abook'){
								$itemtype_table='tbl_abook';
							}
							else if($this->input->post('itemtype')=='Course'){
								$itemtype_table='tbl_course';
							}
							else{
								$itemtype_table='tbl_course';
							}
							$result=$this->db->where($whereData)->order_by("id", "ASC")->get($table);
							$count=$result->num_rows();
							if($count)
							{
								$i=0;
								$return=[];
								foreach ($result->result() as $wishlist){
									$enrollResult=$this->db->where(['itemtype'=>$this->input->post('itemtype'),'itemid'=>$wishlist->itemid,'userid'=>$this->userid,'paymentstatus'=>'success'])->get("tbl_enroll");
									if($enrollResult->num_rows()){
										$puchase_status='true';
									}
									else{
										$puchase_status='false';
									}
									
									$itemResult=$this->db->where('id',$wishlist->itemid)->get($itemtype_table);
									if($itemResult->num_rows()){
										$itemValues=$itemResult->row();
										$return[$i]=$wishlist;
										$return[$i]->item=$itemValues;
										$return[$i]->item->puchase_status=$puchase_status;
										$return[$i]->item->author=$this->db->where('id',$itemValues->author)->get('tbl_tutor')->row();
										$i++;
									}
								}
								
								$output['res']='success';
								$output['msg']=$count.' Record Found';
								$output['data']=$return;
							}
							else{
								$output['msg']="No Record Found";
							}
							
							
						}
						else{
							$msg=explode('</p>',validation_errors());
							$output['msg']=str_ireplace('<p>','', $msg[0]);
						}
					}
				}
				
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
			
		}
		
		#Ebook
		
		public function Ebook()
		{
			$table="tbl_ebook";
			
			$output['res']="error";
			$output['msg']="error";
			$output['data']="";
			
			$EnrolledItems=$this->EnrolledItems('Ebook',$this->userid);
			
			if($this->uri->segment(4)){
				
				$action=$this->uri->segment(4);
				if($action=='List'){
					
					if($this->uri->segment(5)){
						
						$subAction=$this->uri->segment(5);
						if($subAction=='Trending'){
							$orderByColumn= "offerprice";
							$orderByValue= "ASC";
						}
						else if($subAction=='Top'){
							$orderByColumn= "name";
						    $orderByValue= "ASC";
						}
						else if($subAction=='Latest'){
							$orderByColumn= "id";
						    $orderByValue= "DESC";
						}
						else{
							$orderByColumn= "id";
						    $orderByValue= "DESC";
						}
					}
					else{
						$orderByColumn= "id";
						$orderByValue= "DESC";
					}
					
					if(empty($this->input->post('type'))){
					    $whereData=['apprstatus'=>'true'];
					}
					else{
					    $whereData=['apprstatus'=>'true','type'=>$this->input->post('type')];
					}
					
					$result=$this->db->where($whereData)->where_not_in('id',$EnrolledItems)->order_by($orderByColumn,$orderByValue)->get($table);
					$count=$result->num_rows();
					if($count){
						
						$output['res']='success';
						$output['msg']=$count.' Record Found';
						$i=0;
						$return=[];
						foreach($result->result() as $item)
						{
							$AverageReview=$this->AverageReview('Ebook',$item->id);
							$return[$i]=$item;
							$return[$i]->discountpercent=$this->codersadda->DiscountPercent($item->discountpercent);	
							$return[$i]->rating=$AverageReview['rating'];		
							$return[$i]->totalrating=$AverageReview['ratingcount'];	
							$return[$i]->topic_length=$this->db->where('itemid',$item->id)->where('itemtype','Ebook')->order_by('topic_no','ASC')->get('tbl_topic')->num_rows();
							$return[$i]->topicList=$this->db->where('itemid',$item->id)->where('itemtype','Ebook')->order_by('topic_no','ASC')->get('tbl_topic')->result();
							$i++;
						}
						
						$output['data']=$return;
					}
					else{
						$output['msg']="No Record Found";
					}
				}
				else if($action=='ByCategory' and !empty($_POST)){
					
					if($this->form_validation->run('category')) 
					{
						$categoryid=$this->input->post('categoryid');
						
						$result=$this->db->where(['category'=>$categoryid,'apprstatus'=>'true'])->where_not_in('id',$EnrolledItems)->order_by("id", "DESC")->get($table);
						$count=$result->num_rows();
						if($count)
						{
							$output['res']='success';
							$output['msg']=$count.' Record Found';
							
							$i=0;
							$return=[];
							foreach($result->result() as $item)
							{
								$AverageReview=$this->AverageReview('Ebook',$item->id);
								$return[$i]=$item;	
								$return[$i]->discountpercent=$this->codersadda->DiscountPercent($item->discountpercent);	
								$return[$i]->rating=$AverageReview['rating'];		
								$return[$i]->totalrating=$AverageReview['ratingcount'];		
								$i++;
							}
							
							$output['data']=$return;
						}
						else{
							$output['msg']="No Record Found";
						}
					}
					else
					{
						$msg=explode('</p>',validation_errors());
						$output['msg']=str_ireplace('<p>','', $msg[0]);
					}
					
				}
				else if($action=='FullDetails' and !empty($_POST)){
					
					if($this->form_validation->run('ebookFullDetails')) 
					{
						$ebookid=$this->input->post('ebookid');
						
						$result=$this->db->where("id",$ebookid)->order_by("id", "DESC")->get($table);
						$count=$result->num_rows();
						if($count)
						{
							$output['res']='success';
							$output['msg']=$count.' Record Found';
							
							# Hold Data in Data Variable
							$data=$result->result();
							$data[0]->discountpercent=$this->codersadda->DiscountPercent($data[0]->discountpercent);	
							
							# Find Author Details
							$author=$data[0]->author;					
							$result1=$this->db->where("id",$author)->get("tbl_tutor");
							$data[0]->authordetails=$result1->result()[0];
							
							# Find Category Details
							$category=$data[0]->category;					
							$result5=$this->db->where("id",$category)->get("tbl_category");
							$data[0]->categorydetails=$result5->result()[0];
							
							# Find and Add Reviews 
							$reviewResult=$this->db->where(['itemtype'=>'Ebook','itemid'=>$ebookid])->get("tbl_review");
							$reviewValues=$reviewResult->row();
							
							$reviewData=array();
							$sumOfRating=0;
							$average=0;
							$ratingcount=$reviewResult->num_rows();
							
							if($reviewResult->num_rows()){
								
								foreach($reviewResult->result() as $review)
								{
									$userResult=$this->db->where(['id'=>$review->userid])->get("tbl_registration");
									
									if($userResult->num_rows()){
										$userValues=$userResult->row();
										$reviewData[]=['name'=>$userValues->name,'profile_photo'=>$userValues->profile_photo,'rating'=>$review->rating,'review'=>$review->review,'date'=>$review->date,'time'=>$review->time];
										
									}
									$sumOfRating+=$review->rating;
									
								}
								$average=($sumOfRating/$reviewResult->num_rows());
							}
							
							if($average==0){
								$average=rand(3.5,5);
							}
							if($ratingcount==0){
								$ratingcount=rand(1,10);
							}
							$average=ceil($average);
							
							$data[0]->reviewdetails=['list'=>$reviewData,'count'=>$ratingcount,'average'=>$average]; 
							
							$wishlistResult=$this->db->where(['itemtype'=>'Ebook','itemid'=>$ebookid,'userid'=>$this->userid,'status'=>'true'])->get("tbl_wishlist");	
							if($wishlistResult->num_rows()){
								$wishliststatus='true';
							}
							else{
								$wishliststatus='false';	
							}
							
							$data[0]->wishliststatus=$wishliststatus; 
							
							$result=$this->db->where('itemid',$ebookid)->where('itemtype','Ebook')->order_by('topic_no','ASC')->get('tbl_topic');
							$data[0]->topicList=$result->result();
							
							$output['data']=$data;
						}
						else{
							$output['msg']="No Record Found";
						}
					}
					else
					{
						$msg=explode('</p>',validation_errors());
						$output['msg']=str_ireplace('<p>','', $msg[0]);
					}
					
				}
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
			
		}
		
		#Audio book
		
		public function Abook()
		{
			
			$table="tbl_abook";
			
			$output['res']="error";
			$output['msg']="error";
			$output['data']="";
			
			$EnrolledItems=$this->EnrolledItems('Abook',$this->userid);
			
			if($this->uri->segment(4)){
				
				$action=$this->uri->segment(4);
				if($action=='List'){
					
					if($this->uri->segment(5)){
						
						$subAction=$this->uri->segment(5);
						if($subAction=='Trending'){
							$orderByColumn= "offerprice";
							$orderByValue= "ASC";
						}
						else if($subAction=='Top'){
							$orderByColumn= "name";
						    $orderByValue= "ASC";
						}
						else if($subAction=='Latest'){
							$orderByColumn= "id";
						    $orderByValue= "DESC";
						}
						else{
							$orderByColumn= "id";
						    $orderByValue= "DESC";
						}
					}
					else{
						$orderByColumn= "id";
						$orderByValue= "DESC";
					}
					
					if(empty($this->input->post('type'))){
					    $whereData=['apprstatus'=>'true'];
					}
					else{
					    $whereData=['apprstatus'=>'true','type'=>$this->input->post('type')];
					}
					
					$result=$this->db->where($whereData)->where_not_in('id',$EnrolledItems)->order_by($orderByColumn,$orderByValue)->get($table);
					$count=$result->num_rows();
					if($count){
						
						$output['res']='success';
						$output['msg']=$count.' Record Found';
						$i=0;
						$return=[];
						foreach($result->result() as $item)
						{
						    $item->description=strip_tags($item->description);
							$AverageReview=$this->AverageReview('Abook',$item->id);
							$return[$i]=$item;
							$return[$i]->discountpercent=$this->codersadda->DiscountPercent($item->discountpercent);	
							$return[$i]->rating=$AverageReview['rating'];		
							$return[$i]->totalrating=$AverageReview['ratingcount'];	
							$return[$i]->topic_length=$this->db->where('itemid',$item->id)->where('itemtype','Abook')->order_by('topic_no','ASC')->get('tbl_topic')->num_rows();
							$return[$i]->topicList=$this->db->where('itemid',$item->id)->where('itemtype','Abook')->order_by('topic_no','ASC')->get('tbl_topic')->result();
							$i++;
						}
						
						$output['data']=$return;
					}
					else{
						$output['msg']="No Record Found";
					}
				}
				else if($action=='ByCategory' and !empty($_POST)){
					
					if($this->form_validation->run('category')) 
					{
						$categoryid=$this->input->post('categoryid');
						
						$result=$this->db->where(['category'=>$categoryid,'apprstatus'=>'true'])->where_not_in('id',$EnrolledItems)->order_by("id", "DESC")->get($table);
						$count=$result->num_rows();
						if($count)
						{
							$output['res']='success';
							$output['msg']=$count.' Record Found';
							
							$i=0;
							$return=[];
							foreach($result->result() as $item)
							{
							    $item->description=strip_tags($item->description);
								$AverageReview=$this->AverageReview('Abook',$item->id);
								$return[$i]=$item;	
								$return[$i]->discountpercent=$this->codersadda->DiscountPercent($item->discountpercent);	
								$return[$i]->rating=$AverageReview['rating'];		
								$return[$i]->totalrating=$AverageReview['ratingcount'];		
								$i++;
							}
							
							$output['data']=$return;
						}
						else{
							$output['msg']="No Record Found";
						}
					}
					else
					{
						$msg=explode('</p>',validation_errors());
						$output['msg']=str_ireplace('<p>','', $msg[0]);
					}
					
				}
				else if($action=='FullDetails' and !empty($_POST)){
					
					if($this->form_validation->run('abookFullDetails')) 
					{
						$abookid=$this->input->post('abookid');
						
						$result=$this->db->where("id",$abookid)->order_by("id", "DESC")->get($table);
						$count=$result->num_rows();
						if($count)
						{
							$output['res']='success';
							$output['msg']=$count.' Record Found';
							
							# Hold Data in Data Variable
							$data=$result->result();
							$data[0]->description=strip_tags($data[0]->description);
							$data[0]->discountpercent=$this->codersadda->DiscountPercent($data[0]->discountpercent);	
							
							# Find Author Details
							$author=$data[0]->author;					
							$result1=$this->db->where("id",$author)->get("tbl_tutor");
							$data[0]->authordetails=$result1->result()[0];
							
							# Find Category Details
							$category=$data[0]->category;					
							$result5=$this->db->where("id",$category)->get("tbl_category");
							$data[0]->categorydetails=$result5->result()[0];
							
							# Find and Add Reviews 
							$reviewResult=$this->db->where(['itemtype'=>'Abook','itemid'=>$abookid])->get("tbl_review");
							$reviewValues=$reviewResult->row();
							
							$reviewData=array();
							$sumOfRating=0;
							$average=0;
							$ratingcount=$reviewResult->num_rows();
							
							if($reviewResult->num_rows()){
								
								foreach($reviewResult->result() as $review)
								{
									$userResult=$this->db->where(['id'=>$review->userid])->get("tbl_registration");
									
									if($userResult->num_rows()){
										$userValues=$userResult->row();
										$reviewData[]=['name'=>$userValues->name,'profile_photo'=>$userValues->profile_photo,'rating'=>$review->rating,'review'=>$review->review,'date'=>$review->date,'time'=>$review->time];
										
									}
									$sumOfRating+=$review->rating;
									
								}
								$average=($sumOfRating/$reviewResult->num_rows());
							}
							
							if($average==0){
								$average=rand(3.5,5);
							}
							if($ratingcount==0){
								$ratingcount=rand(1,10);
							}
							$average=ceil($average);
							
							$data[0]->reviewdetails=['list'=>$reviewData,'count'=>$ratingcount,'average'=>$average]; 
							
							$wishlistResult=$this->db->where(['itemtype'=>'Abook','itemid'=>$abookid,'userid'=>$this->userid,'status'=>'true'])->get("tbl_wishlist");	
							if($wishlistResult->num_rows()){
								$wishliststatus='true';
							}
							else{
								$wishliststatus='false';	
							}
							
							$data[0]->wishliststatus=$wishliststatus; 
							
							$result=$this->db->where('itemid',$abookid)->where('itemtype','Abook')->order_by('topic_no','ASC')->get('tbl_topic');
							$data[0]->topicList=$result->result();
							
							$output['data']=$data;
						}
						else{
							$output['msg']="No Record Found";
						}
					}
					else
					{
						$msg=explode('</p>',validation_errors());
						$output['msg']=str_ireplace('<p>','', $msg[0]);
					}
					
				}
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
			
		}
		
		# My Items
		public function MyItem()
		{
			
			$output['res']="error";
			$output['msg']="error";
			$output['data']="";
			
			if($this->uri->segment(4)){
				
				$action=$this->uri->segment(4);
				if($action=='Ebook'){
					$table="tbl_ebook";
				}
				else if($action=='Abook'){
					$table="tbl_abook";
				}
				else if($action=='Course'){
					$table="tbl_course";
				}
				else{
					$table="tbl_course";
				}
				if(!empty($_POST))
				{
					if($this->form_validation->run('myItem')) 
					{
						$whereData=[
						'userid'=>$this->input->post('userid'),
						'itemtype'=>$action,
						'paymentstatus'=>'success',
						];
						$result=$this->db->where($whereData)->order_by("id", "DESC")->get('tbl_enroll');
						$count=$result->num_rows();
						if($count)
						{
							$output['res']='success';
							$output['msg']=$count.' Record Found';
							$i=0;
							$return=[];
							foreach ($result->result() as $enroll){
								
								$return[$i]=$enroll;
								$return[$i]->item=$this->db->where('id',$enroll->itemid)->get($table)->row();
								$return[$i]->item->author=$this->db->where('id',$return[$i]->item->author)->get('tbl_tutor')->row();
								
								$AverageReview=$this->AverageReview($action,$enroll->itemid);	
								$return[$i]->rating=$AverageReview['rating'];		
								$return[$i]->totalrating=$AverageReview['ratingcount'];	
								$return[$i]->progress=rand(0,100).'%';
								$return[$i]->topic_length=$this->db->where('itemid',$enroll->itemid)->where('itemtype',$action)->order_by('topic_no','ASC')->get('tbl_topic')->num_rows();
								$return[$i]->topicList=$this->db->where('itemid',$enroll->itemid)->where('itemtype',$action)->order_by('topic_no','ASC')->get('tbl_topic')->result();
								// if($action=='Ebook'){
								// $return[$i]->progress=rand(0,100).'%';	
								// }
								// else{
								// $mark_as_completed=count(explode(',',$enroll->mark_as_completed))-1;
								// if($mark_as_completed<0){ $mark_as_completed=0; }
								// $lecture=$this->db->where('course',$enroll->itemid)->get('tbl_lecture')->num_rows();
								// $progress=((100*$mark_as_completed)/$lecture).'%';
								// $return[$i]->progress=$progress;
								// }
								
								$i++;
							}
							$output['data']=$return;
						}
						else{
							$output['msg']="No Record Found";
						}
					}
					else
					{
						$msg=explode('</p>',validation_errors());
						$output['msg']=str_ireplace('<p>','', $msg[0]);
					}
				}
				else{
					$output['msg']="Try ! Again";
				}
				
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
			
		}
		
		
		# Reviews 
		
		public function Review()
		{
			$table="tbl_review";
			
			$output['res']="error";
			$output['msg']="error";
			$output['data']="";
			
			if($this->uri->segment(4)){
				
				$action=$this->uri->segment(4);
				if(empty($_POST))
				{
					$output['msg']='Something Went Wrong. Try Again !';
				}
				else{
					if($action=='Add'){
						if($this->form_validation->run('review')) 
						{
							$whereData=[
							'userid'=>$this->input->post('userid'),
							"itemid" => $this->input->post('itemid'),
							'itemtype'=>$this->input->post('itemtype'),
							];
							$result=$this->db->where($whereData)->get($table);
							$count=$result->num_rows();
							if($count)
							{
								$data_to_update = array(
								"rating" => $this->input->post('rating'),
								"review" => $this->input->post('review'),
								);
								
								$data_to_update = $this->security->xss_clean($data_to_update);
								
								$query=$this->db->where($whereData)->update($table,$data_to_update);
							}
							else{
								$data_to_insert = array(
								"userid" => $this->input->post('userid'),
								"itemid" => $this->input->post('itemid'),
								"itemtype" => $this->input->post('itemtype'),
								"rating" => $this->input->post('rating'),
								"review" => $this->input->post('review'),
								"date" => $this->date,
								"time" => $this->time,
								);
								
								$data_to_insert = $this->security->xss_clean($data_to_insert);
								
								$query=$this->db->insert($table,$data_to_insert);	
							}
							if($query){
								$output['res']="success";
								$output['msg']="Thank you for reviewing.";
							}
							else{
								$output['msg']="Try !again";
							}
						}
						else{
							$msg=explode('</p>',validation_errors());
							$output['msg']=str_ireplace('<p>','', $msg[0]);
						}
					}
				}
				
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
			
		}
		
		# APP Token
		
		public function Token()
		{
			$table="tbl_apptoken";
			
			$output['res']="error";
			$output['msg']="error";
			$output['data']="";
			
			if($this->uri->segment(4)){
				
				$action=$this->uri->segment(4);
				if(empty($_POST))
				{
					$output['msg']='Something Went Wrong. Try Again !';
				}
				else{
					if($action=='Save'){
						if($this->form_validation->run('token')) 
						{
							if(empty($this->input->post('userid'))){
								$_POST['userid']=0;
							}
							$whereData=[
							"token" => $this->input->post('token'),
							];
							$result=$this->db->where($whereData)->get($table);
							$count=$result->num_rows();
							if($count)
							{
								$data_to_update = array(
								"userid" => $this->input->post('userid'),
								"token" => $this->input->post('token'),
								);
								
								
								$query=$this->db->where($whereData)->update($table,$data_to_update);
							}
							else{
								$data_to_insert = array(
								"userid" => $this->input->post('userid'),
								"token" => $this->input->post('token'),
								"date" => $this->date,
								"time" => $this->time,
								);
								
								$query=$this->db->insert($table,$data_to_insert);	
							}
							if($query){
								$output['res']="success";
								$output['msg']="Token Saved.";
							}
							else{
								$output['msg']="Try !again";
							}
						}
						else{
							$msg=explode('</p>',validation_errors());
							$output['msg']=str_ireplace('<p>','', $msg[0]);
						}
					}
				}
				
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
			
		}
		
		# Order History
		
		public function OrderHistory()
		{
			
			$output['res']="error";
			$output['msg']="error";
			$output['data']="";
			
			if(!empty($_POST))
			{
				if($this->form_validation->run('orderHistory')) 
				{
					$whereData=[
					'userid'=>$this->input->post('userid')
					];
					if(!empty($this->input->post('itemtype'))){
						$whereData['itemtype']=$this->input->post('itemtype');
					}
					$result=$this->db->where($whereData)->order_by("id", "DESC")->get('tbl_enroll');
					$count=$result->num_rows();
					if($count)
					{
						$output['res']='success';
						$output['msg']=$count.' Record Found';
						
						$i=0;
						$return=[];
						foreach ($result->result() as $enroll){
							
							if($enroll->itemtype=='Course'){
								$table='tbl_course';
							}
							else{
								$table='tbl_ebook';
							}
							$return[$i]=$enroll;
							$paymentid=explode(',',$enroll->paymentid);
							if(substr($paymentid[0],0,3)=='pay'){
								$return[$i]->paymentid = $paymentid[0].' ('.end($paymentid).') ';
							}
							else{
								$return[$i]->paymentid = end($paymentid);
							}
							$return[$i]=$enroll;
							$itemResult=$this->db->where('id',$enroll->itemid)->get($table)->row();
							$return[$i]->item=$itemResult;
							if($itemResult){
								$return[$i]->item->author=$this->db->where('id',$itemResult->author)->get('tbl_tutor')->row();
							}
							
							$AverageReview=$this->AverageReview($enroll->itemtype,$enroll->itemid);	
							$return[$i]->rating=$AverageReview['rating'];		
							$return[$i]->totalrating=$AverageReview['ratingcount'];	
							
							// if($enroll->itemtype=='Ebook'){
							// $return[$i]->progress=rand(0,100).'%';	
							// }
							// else{
							// $mark_as_completed=count(explode(',',$enroll->mark_as_completed))-1;
							// if($mark_as_completed<0){ $mark_as_completed=0; }
							// $lecture=$this->db->where('course',$enroll->itemid)->get('tbl_lecture')->num_rows();
							// $progress=((100*$mark_as_completed)/$lecture).'%';
							// $return[$i]->progress=$progress;
							// }
							
							$return[$i]->progress=rand(0,100).'%';
							
							$i++;
						}
						$output['data']=$return;
						
					}
					else{
						$output['msg']="No Record Found";
					}
				}
				else
				{
					$msg=explode('</p>',validation_errors());
					$output['msg']=str_ireplace('<p>','', $msg[0]);
				}
			}
			else{
				$output['msg']="Try ! Again";
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		# Live Sessions
		
		public function LiveSessions()
		{
			$table="tbl_live_video";
			
			$output['res']="error";
			$output['msg']="error";
			$output['data']="";
			if($this->uri->segment(4)){
				$action=$this->uri->segment(4);
				if($action=='List'){
					
					$orderBy= "'id','DESC'";
					$result=$this->db->where(['status'=>'true'])->order_by('timing','DESC')->get($table);
					$count=$result->num_rows();
					if($count){
						
						$output['res']='success';
						$output['msg']=$count.' Record Found';
						
						$i=0;
						$return=[];
						foreach($result->result() as $live)
						{
							$return[$i]=$live;
							$getYoutubeLinkData=$this->Auth_model->getYoutubeLinkData($live->link);
                            $return[$i]->YoutubeId=$getYoutubeLinkData->id;
							$return[$i]->author=$this->db->where(['id'=>$live->author])->get('tbl_tutor')->row();
							$result1=$this->db->where(['liveid'=>$live->id,'userid'=>$this->userid])->get('tbl_live_join');
							if($result1->num_rows()){
								$joined='true';
							}
							else{
								$joined='false';
							}
							$return[$i]->joined=$joined;
							$no_of_students=$this->db->where(['liveid'=>$live->id])->get('tbl_live_join')->num_rows();
							$return[$i]->no_of_students=$no_of_students;
							
							$remaining_time=$this->diff_dates($live->timing, "minutes");
							$return[$i]->remaining_time=$remaining_time;
							$i++;
						}
						$output['data']=$return;
					}
					else{
						$output['msg']="No Record Found";
					}
				}
				else if($action=='Join' and !empty($_POST))
				{
					
					if($this->form_validation->run('liveJoin')) 
					{
						$id=$this->input->post('liveid');
						$whereData=[
						"userid" => $this->input->post('userid'),
						"liveid" => $this->input->post('liveid'),
						];
						$liveResult=$this->db->where(['id'=>$id])->get($table)->result();
						$liveResult[0]->author=$this->db->where(['id'=>$liveResult[0]->author])->get('tbl_tutor')->row();
						
						$remaining_time=$this->diff_dates($liveResult[0]->timing, "minutes");
						$liveResult[0]->remaining_time=$remaining_time;
						
						$result=$this->db->where($whereData)->get('tbl_live_join');
						$count=$result->num_rows();
						if($count)
						{
							$output['res']="success";
							$output['msg']="Already joined this live session.";
							$output['data']=$liveResult;
						}
						else{
							$data_to_insert = array(
							"userid" => $this->input->post('userid'),
							"liveid" => $this->input->post('liveid'),
							"name" => $this->input->post('name'),
							"email" => $this->input->post('email'),
							"mobile" => $this->input->post('mobile'),
							"date" => $this->date,
							"time" => $this->time,
							);
							
							$query=$this->db->insert('tbl_live_join',$data_to_insert);	
							if($query){
								$output['res']="success";
								$output['msg']="Successfully joined this live session.";
								$output['data']=$liveResult;
							}
							else{
								$output['msg']="Try !again";
							}
						}
						
					}
					else
					{
						$msg=explode('</p>',validation_errors());
						$output['msg']=str_ireplace('<p>','', $msg[0]);
					}
					
				}
				else if($action=='JoinWithoutInformation' and !empty($_POST))
				{
					
					if(!empty($this->input->post('liveid')) and !empty($this->input->post('userid'))) 
					{
						$id=$this->input->post('liveid');
						$whereData=[
						"userid" => $this->input->post('userid'),
						"liveid" => $this->input->post('liveid'),
						];
						$liveResult=$this->db->where(['id'=>$id])->get($table)->result();
						$liveResult[0]->author=$this->db->where(['id'=>$liveResult[0]->author])->get('tbl_tutor')->row();
						
						$remaining_time=$this->diff_dates($liveResult[0]->timing, "minutes");
						$liveResult[0]->remaining_time=$remaining_time; 
						
						$result=$this->db->where($whereData)->get('tbl_live_join');
						$count=$result->num_rows();
						if($count)
						{
							$output['res']="success";
							$output['msg']="Already joined this live session.";
							$output['data']=$liveResult;
						}
						else{
							$userResult=$this->db->where(['id'=>$this->userid])->get('tbl_registration')->row();
							$data_to_insert = array(
							"userid" => $this->input->post('userid'),
							"liveid" => $this->input->post('liveid'),
							"name" => $userResult->name,
							"email" => $userResult->email,
							"mobile" => $userResult->number,
							"date" => $this->date,
							"time" => $this->time,
							);
							
							$query=$this->db->insert('tbl_live_join',$data_to_insert);	
							if($query){
								$output['res']="success";
								$output['msg']="Successfully joined this live session.";
								$output['data']=$liveResult;
							}
							else{
								$output['msg']="Try !again";
							}
						}
						
					}
					else
					{
						$output['msg']="Live ID and User ID is empty.";
					}
					
				}
				else if($action=='FullDetails' and !empty($_POST)){
					
					if(!empty($this->input->post('liveid'))) 
					{
						$id=$this->input->post('liveid');
						
						$result=$this->db->where("id",$id)->order_by("id", "DESC")->get($table);
						$count=$result->num_rows();
						if($count)
						{
							$output['res']='success';
							$output['msg']=$count.' Record Found';
							
							$data=$result->result();
							
							$author=$data[0]->author;					
							$result1=$this->db->where("id",$author)->get("tbl_tutor");
							$data[0]->author=$result1->result()[0];
							
							$getYoutubeLinkData=$this->Auth_model->getYoutubeLinkData($data[0]->link);
                            $data[0]->YoutubeId=$getYoutubeLinkData->id;
                            
							$result=$this->db->where(['liveid'=>$id,'userid'=>$this->userid])->get('tbl_live_join');
							if($result->num_rows()){
								$joined='true';
							}
							else{
								$joined='false';
							}
							
							$data[0]->joined=$joined;
							$no_of_students=$this->db->where(['liveid'=>$id])->get('tbl_live_join')->num_rows();
							$data[0]->no_of_students=$no_of_students;
							
							$remaining_time=$this->diff_dates($data[0]->timing, "minutes");
							$data[0]->remaining_time=$remaining_time; 
							
							$result2=$this->db->where(['liveid'=>$id,'status'=>'true'])->get('tbl_live_question');
								$questions=[];
								if($result2->num_rows()){
									
									
									$k=0;
									foreach($result2->result() as $question){
										
										$result3 = $this->db->where(['questionid'=>$question->id,'status'=>'true'])->get('tbl_live_reply');
										if($result3->num_rows()){
											$reply_status='true';
											
											$l=0;
											$reply=[];
											foreach($result3->result() as $rep){
												$reply[$l]=$rep;
												if($rep->usertype=='Admin'){
													$name='Karmasu Admin';
													$profile_photo='logo.png';
												}
												else{
													$name='Karmasu Educator';
													$profile_photo='logo.png';
												}
												$user=['name'=>$name,'profile_photo'=>$profile_photo];
												$reply[$l]->user= (object) $user;
												$l++;
											}
										}
										else{
											$reply_status='false';
											$reply=[];
										}
										$questions[$k]=$question;
										$questions[$k]->user=$this->db->where(['id'=>$question->userid])->get('tbl_registration')->row();
										$questions[$k]->reply_status=$reply_status;
										$questions[$k]->reply=$reply;
										
										$k++;
									}
								}
								$data[0]->question=$questions;
							$output['data']=$data;
						}
						else{
							$output['msg']="No Record Found";
						}
					}
					else
					{
						$output['msg']="Live Sessions  ID is required.";
					}
					
				}
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
			
		}
		
		public function diff_dates($date = null, $diff = "minutes") 
		{
			$start_date = new DateTime($date);
			$since_start = $start_date->diff(new DateTime( date('Y-m-d H:i:s') )); // date now
			// print_r($since_start);
			switch ($diff) {
				case 'seconds':
				return $since_start->s;
				break;
				case 'minutes':
				return $since_start->i.':'.$since_start->s;
				break;
				case 'hours':
				return $since_start->h;
				break;
				case 'days':
				return $since_start->d;
				break;      
				default:
				# code...
				break;
			}
		}
		
		# Search 
		
		public function Search()
		{
			
			$output['res']="error";
			$output['msg']="No Record Found.";
			$output['data']="";
			if(empty($_POST)){
			}
			else{
				if(empty($this->input->post('keyword'))){
					$output['msg']="Enter Keyword";
				}
				else if(empty($this->input->post('userid'))){
					$output['msg']="Enter User ID";
				}
				else{
					$keyword=$this->input->post('keyword');
					
					$EnrolledItems=$this->EnrolledItems('Course',$this->userid);
					
					$result=$this->db->where('apprstatus','true')->where_not_in('id',$EnrolledItems)->like('name',$keyword)->get('tbl_course');
					$data=array();
					if($result->num_rows()){
						$output['res']="success";
						$output['msg']="Data Found";
						
						foreach($result->result() as $item)
						{
							$AverageReview=$this->AverageReview('Course',$item->id);
							$data[]=[
							'itemtype'	=>	'Course',
							'itemid'	=>	$item->id,
							'name'	=>	$item->name,
							'logo'	=>	$item->banner,
							'type'	=>	$item->type,
							'price'	=>	$item->price,
							'offerprice'	=>	$item->offerprice,
							'discountpercent'	=>	$this->codersadda->DiscountPercent($item->discountpercent),
							'rating'	=>	$AverageReview['rating'],
							'totalrating'	=>	$AverageReview['ratingcount']
							];
						}
					}
					$EnrolledItems=$this->EnrolledItems('Ebook',$this->userid);
					$result=$this->db->where('apprstatus','true')->where_not_in('id',$EnrolledItems)->like('name',$keyword)->get('tbl_ebook');
					
					if($result->num_rows()){
						$output['res']="success";
						$output['msg']="Data Found";
						foreach($result->result() as $item)
						{
							$AverageReview=$this->AverageReview('Course',$item->id);
							
							$topic_length=$this->db->where('itemid',$item->id)->where('itemtype','Ebook')->order_by('topic_no','ASC')->get('tbl_topic')->num_rows();
							$topic_list=$this->db->where('itemid',$item->id)->where('itemtype','Ebook')->order_by('topic_no','ASC')->get('tbl_topic')->result();
							
							$data[]=[
							'itemtype'	=>	'Ebook',
							'itemid'	=>	$item->id,
							'name'	=>	$item->name,
							'logo'	=>	$item->banner,
							'type'	=>	$item->type,
							'price'	=>	$item->price,
							'offerprice'	=>	$item->offerprice,
							'discountpercent'	=>	$this->codersadda->DiscountPercent($item->discountpercent),
							'rating'	=>	$AverageReview['rating'],
							'totalrating'	=>	$AverageReview['ratingcount'],
							'topic_length' => $topic_length,
							'topicList' => $topic_list
							];
						}
					}
					
					$EnrolledItems=$this->EnrolledItems('Abook',$this->userid);
					
					$result=$this->db->where('apprstatus','true')->where_not_in('id',$EnrolledItems)->like('name',$keyword)->get('tbl_abook');
					
					if($result->num_rows()){
						$output['res']="success";
						$output['msg']="Data Found";
						foreach($result->result() as $item)
						{
							$AverageReview=$this->AverageReview('Abook',$item->id);
							$topic_length=$this->db->where('itemid',$item->id)->where('itemtype','Abook')->order_by('topic_no','ASC')->get('tbl_topic')->num_rows();
							$topic_list=$this->db->where('itemid',$item->id)->where('itemtype','Abook')->order_by('topic_no','ASC')->get('tbl_topic')->result();
							$data[]=[
							'itemtype'	=>	'Abook',
							'itemid'	=>	$item->id,
							'name'	=>	$item->name,
							'logo'	=>	$item->banner,
							'type'	=>	$item->type,
							'price'	=>	$item->price,
							'offerprice'	=>	$item->offerprice,
							'discountpercent'	=>	$this->codersadda->DiscountPercent($item->discountpercent),
							'rating'	=>	$AverageReview['rating'],
							'totalrating'	=>	$AverageReview['ratingcount'],
							'topic_length' => $topic_length,
							'topicList' => $topic_list
							];
						}
					}
					
					$result = $this->db->where(['status'=>'true','type'=>'RecommendedVideos'])->where("(`for_user`='Both' OR `for_user`='Student')")->like('title',$keyword)->order_by("id", "DESC")->get('tbl_recommended_videos');
					if($result->num_rows())
					{
						$output['res']="success";
						$output['msg']="Data Found";
						foreach($result->result() as $item)
						{
							$vlist=$this->db->where('id',$item->video)->get('tbl_video')->row();
						    $getYoutubeLinkData=$this->Auth_model->getYoutubeLinkData($vlist->link);
							$data[]=[
							'itemtype'	=>	'FreeVideo',
							'itemid'	=>	$item->id,
							'name'	=>	$vlist->title,
							'logo'	=>	$vlist->thumbnail,
							'YoutubeId'=>$getYoutubeLinkData->id,
							'video_type'=>$vlist->type,
							'video_url'=>$vlist->link,
							'description'=>$item->description,
							'type'	=>	'Free',
							'price'	=>	0,
							'offerprice'	=>	0,
							'discountpercent'	=>	0,
							'rating'	=>	rand(1,5),
							'totalrating'	=>	rand(1,100),
							'topicList' => []
							];
						}
					}
					
					$result = $this->db->where(['status'=>'true'])->like('title',$keyword)->order_by("id", "DESC")->get('tbl_live_video');
					if($result->num_rows())
					{
						$output['res']="success";
						$output['msg']="Data Found";
						foreach($result->result() as $item)
						{
							$data[]=[
							'itemtype'	=>	'LiveSession',
							'itemid'	=>	$item->id,
							'name'	=>	$item->title,
							'logo'	=>	$item->thumbnail,
							'type'	=>	'Free',
							'price'	=>	0,
							'offerprice'	=>	0,
							'discountpercent'	=>	0,
							'rating'	=>	rand(1,5),
							'totalrating'	=>	rand(1,100),
							'topicList' => []
							];
						}
					}
					
					$output['data']=$data;
				}
			}
			
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
			
		}
		
		# Enrolled Course
		
		
		public function EnrolledCourse()
		{
			$output['res']="error";
			$output['msg']="error";
			$output['data']="";
			if(empty($_POST))
			{
				$output['msg']='Something Went Wrong. Try Again !';
			}
			else
			{
				if($this->form_validation->run('enrolledCourse')) 
				{
					$courseid=$this->input->post('courseid');
					
					$result=$this->db->where(['id'=>$courseid])->get('tbl_course');
					$count=$result->num_rows();
					if($count)
					{
						$enrollResult=$this->db->where(['itemid'=>$courseid,'itemtype'=>'Course','userid'=>$this->userid])->get('tbl_enroll');
						if($enrollResult->num_rows())
						{
							$output['res']='success';
							$output['msg']=$count.' Record Found';
							
							# Hold Data in Data Variable
							$data=$result->result();
							$enrollData=$enrollResult->result();
							$data[0]->enroll=$enrollData[0];
							
							
							
							# Find Author Details
							$author=$data[0]->author;					
							$result1=$this->db->where("id",$author)->get("tbl_tutor");
							$data[0]->authordetails=$result1->result()[0];
							
							# Find Play List
							$result2=$this->db->where("course",$courseid)->get("tbl_lecture");
							$data1=array();
							foreach($result2->result() as $video)
							{
								$vid=$video->video;
								$result3=$this->db->where("id",$vid)->get("tbl_video");
								$data2=$result3->result()[0];
								
								# Find and Add Subject Details
								$subid=$result3->result()[0]->subject;
								$result4=$this->db->where("id",$subid)->get("tbl_subject");
								$data2->subjectdetails=$result4->result()[0];
								
								$data1[]=$data2;
								
							}
							$data[0]->videoplaylist=$data1;
							
							
							# Find Category Details
							$category=$data[0]->category;					
							$result5=$this->db->where("id",$category)->get("tbl_category");
							$data[0]->categorydetails=$result5->result()[0];
							
							
							# Find and Add Reviews 
							$reviewResult=$this->db->where(['itemtype'=>'Course','itemid'=>$courseid])->get("tbl_review");
							$reviewValues=$reviewResult->row();
							
							$reviewData=array();
							$sumOfRating=0;
							$average=0;
							if($reviewResult->num_rows()){
								
								foreach($reviewResult->result() as $review)
								{
									$userResult=$this->db->where(['id'=>$review->userid])->get("tbl_registration");
									
									if($userResult->num_rows()){
										$userValues=$userResult->row();
										$reviewData[]=['name'=>$userValues->name,'profile_photo'=>$userValues->profile_photo,'rating'=>$review->rating,'review'=>$review->review,'date'=>$review->date,'time'=>$review->time];
										
									}
									$sumOfRating+=$review->rating;
									
								}
								$average=($sumOfRating/$reviewResult->num_rows());
							}
							
							$average=ceil($average);
							$data[0]->reviewdetails=['list'=>$reviewData,'count'=>$reviewResult->num_rows(),'average'=>$average]; 
							
							$wishlistResult=$this->db->where(['itemtype'=>'Course','itemid'=>$courseid,'status'=>'true'])->get("tbl_wishlist");	
							if($wishlistResult->num_rows()){
								$wishliststatus='true';
							}
							else{
								$wishliststatus='false';	
							}
							
							$data[0]->wishliststatus=$wishliststatus; 
							$certificateResult=$this->db->where(['itemtype'=>'Course','itemid'=>$courseid,'userid'=>$this->userid])->get("tbl_certificate");
							if($certificateResult->num_rows())
							{
								$certificateData=$certificateResult->row();
								
								if($certificateData->itemtype=='Course'){
									$itemtable='tbl_course';
								}
								else if($certificateData->itemtype=='LiveSession'){
									$itemtable='tbl_live_video';
								}
								else{
									$itemtable='tbl_course';
								}
								
								$query = $this->db->where(['id'=>$certificateData->itemid])->get($itemtable);
								$itemData=$query->row();
								
								$itemData->author=$this->db->where(['id'=>$itemData->author])->get('tbl_tutor')->row();
								$certificateData->item=$itemData;
								
								$data[0]->certificatedata=$certificateData; 
								$certificatestatus=$certificateData->status;
							}
							else{
								// $mark_as_completed=count(explode(',',$data[0]->enroll->mark_as_completed))-1;
								// if($mark_as_completed<0){ $mark_as_completed=0; }
								// $lecture=$this->db->where('course',$data[0]->enroll->itemid)->get('tbl_lecture')->num_rows();
								// $progress=((100*$mark_as_completed)/$lecture);
								// if($progress>=100){
									// $certificatestatus='request';
								// }
								// else{
									// $certificatestatus='false';
								// }
								$certificatestatus='false';
							}
							
							$data[0]->certificatestatus=$certificatestatus; 
							
							
							$reviewResult=$this->db->where(['itemtype'=>'Course','userid'=>$this->userid,'itemid'=>$courseid])->get("tbl_review");	
							if($reviewResult->num_rows()){
								$reviewstatus='true';
							}
							else{
								$reviewstatus='false';	
							}
							$data[0]->reviewstatus=$reviewstatus;
							
							$output['data']=$data;
							
							
						}
						else{
							$output['msg']="You are not enrolled this course.";
						}
					}
					else{
						$output['msg']="No Record Found";
					}
					
				}
				else
				{
					$msg=explode('</p>',validation_errors());
					$output['msg']=str_ireplace('<p>','', $msg[0]);
				}
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
			
		}
		
		# Enrolled Ebook
		
		public function EnrolledEbook()
		{
			$output['res']="error";
			$output['msg']="error";
			$output['data']="";
// 			$_POST['ebookid']='8';
			if(empty($_POST))
			{
				$output['msg']='Something Went Wrong. Try Again !';
			}
			else
			{
				if($this->form_validation->run('enrolledEbook')) 
				{
					$ebookid=$this->input->post('ebookid');
					
					$result=$this->db->where("id",$ebookid)->order_by("id", "DESC")->get('tbl_ebook');
					$count=$result->num_rows();
					if($count)
					{
						$output['res']='success';
						$output['msg']=$count.' Record Found';
						
						# Hold Data in Data Variable
						$data=$result->result();
						
						
						# Find Author Details
						$author=$data[0]->author;					
						$result1=$this->db->where("id",$author)->get("tbl_tutor");
						$data[0]->authordetails=$result1->result()[0];
						
						# Find Category Details
						$category=$data[0]->category;					
						$result5=$this->db->where("id",$category)->get("tbl_category");
						$data[0]->categorydetails=$result5->result()[0];
						
						# Find and Add Reviews 
						$reviewResult=$this->db->where(['itemtype'=>'Ebook','itemid'=>$ebookid])->get("tbl_review");
						$reviewValues=$reviewResult->row();
						
						$reviewData=array();
						$sumOfRating=0;
						$average=0;
						if($reviewResult->num_rows()){
							
							foreach($reviewResult->result() as $review)
							{
								$userResult=$this->db->where(['id'=>$review->userid])->get("tbl_registration");
								
								if($userResult->num_rows()){
									$userValues=$userResult->row();
									$reviewData[]=['name'=>$userValues->name,'profile_photo'=>$userValues->profile_photo,'rating'=>$review->rating,'review'=>$review->review,'date'=>$review->date,'time'=>$review->time];
									
								}
								$sumOfRating+=$review->rating;
								
							}
							$average=($sumOfRating/$reviewResult->num_rows());
						}
						
						$average=ceil($average);
						$data[0]->reviewdetails=['list'=>$reviewData,'count'=>$reviewResult->num_rows(),'average'=>$average]; 
						
						$wishlistResult=$this->db->where(['itemtype'=>'Ebook','itemid'=>$ebookid,'status'=>'true'])->get("tbl_wishlist");	
						if($wishlistResult->num_rows()){
							$wishliststatus='true';
						}
						else{
							$wishliststatus='false';	
						}
						
						$data[0]->wishliststatus=$wishliststatus; 
						$data[0]->certificatestatus='false'; 
						
						$reviewResult=$this->db->where(['itemtype'=>'Ebook','userid'=>$this->userid,'itemid'=>$ebookid])->get("tbl_review");	
						if($reviewResult->num_rows()){
							$reviewstatus='true';
						}
						else{
							$reviewstatus='false';	
						}
						$data[0]->reviewstatus=$reviewstatus;
						$result=$this->db->where('itemid',$ebookid)->where('itemtype','Ebook')->order_by('topic_no','ASC')->get('tbl_topic');
						$data[0]->topicList=$result->result();
						$output['data']=$data;
					}
					else{
						$output['msg']="No Record Found";
					}
					
				}
				else
				{
					$msg=explode('</p>',validation_errors());
					$output['msg']=str_ireplace('<p>','', $msg[0]);
				}
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
			
		}
		
		public function EnrolledAbook()
		{
			$output['res']="error";
			$output['msg']="error";
			$output['data']="";
			if(empty($_POST))
			{
				$output['msg']='Something Went Wrong. Try Again !';
			}
			else
			{
				if($this->form_validation->run('enrolledEbook')) 
				{
					$ebookid=$this->input->post('ebookid');
					
					$result=$this->db->where("id",$ebookid)->order_by("id", "DESC")->get('tbl_abook');
					$count=$result->num_rows();
					if($count)
					{
						$output['res']='success';
						$output['msg']=$count.' Record Found';
						
						# Hold Data in Data Variable
						$data=$result->result();
						$data[0]->description=strip_tags($data[0]->description); 
						
						# Find Author Details
						$author=$data[0]->author;					
						$result1=$this->db->where("id",$author)->get("tbl_tutor");
						$data[0]->authordetails=$result1->result()[0];
						
						# Find Category Details
						$category=$data[0]->category;					
						$result5=$this->db->where("id",$category)->get("tbl_category");
						$data[0]->categorydetails=$result5->result()[0];
						
						# Find and Add Reviews 
						$reviewResult=$this->db->where(['itemtype'=>'Abook','itemid'=>$ebookid])->get("tbl_review");
						$reviewValues=$reviewResult->row();
						
						$reviewData=array();
						$sumOfRating=0;
						$average=0;
						if($reviewResult->num_rows()){
							
							foreach($reviewResult->result() as $review)
							{
								$userResult=$this->db->where(['id'=>$review->userid])->get("tbl_registration");
								
								if($userResult->num_rows()){
									$userValues=$userResult->row();
									$reviewData[]=['name'=>$userValues->name,'profile_photo'=>$userValues->profile_photo,'rating'=>$review->rating,'review'=>$review->review,'date'=>$review->date,'time'=>$review->time];
									
								}
								$sumOfRating+=$review->rating;
								
							}
							$average=($sumOfRating/$reviewResult->num_rows());
						}
						
						$average=ceil($average);
						$data[0]->reviewdetails=['list'=>$reviewData,'count'=>$reviewResult->num_rows(),'average'=>$average]; 
						
						$wishlistResult=$this->db->where(['itemtype'=>'Ebook','itemid'=>$ebookid,'status'=>'true'])->get("tbl_wishlist");	
						if($wishlistResult->num_rows()){
							$wishliststatus='true';
						}
						else{
							$wishliststatus='false';	
						}
						
						$data[0]->wishliststatus=$wishliststatus; 
						$data[0]->certificatestatus='false'; 
						
						$reviewResult=$this->db->where(['itemtype'=>'Abook','userid'=>$this->userid,'itemid'=>$ebookid])->get("tbl_review");	
						if($reviewResult->num_rows()){
							$reviewstatus='true';
						}
						else{
							$reviewstatus='false';	
						}
						$data[0]->reviewstatus=$reviewstatus;
						
						$result=$this->db->where('itemid',$ebookid)->where('itemtype','Abook')->order_by('topic_no','ASC')->get('tbl_topic');
						$data[0]->topicList=$result->result();
						
						$output['data']=$data;
					}
					else{
						$output['msg']="No Record Found";
					}
					 
				}
				else
				{
					$msg=explode('</p>',validation_errors());
					$output['msg']=str_ireplace('<p>','', $msg[0]);
				}
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
			
		}
		
		#Video Playlist
		
		public function VideoPlaylist()
		{
			$output['res']="error";
			$output['msg']="error";
			$output['data']="";
			
			if(!empty($_POST) and $this->form_validation->run('videoPlaylist')) 
			{
				$courseid=$this->input->post('courseid');
				$videoid=$this->input->post('videoid');
				
				$result=$this->db->where(['id'=>$courseid])->get('tbl_course');
				if($result->num_rows())
				{
					$enrollResult=$this->db->where(['itemid'=>$courseid,'itemtype'=>'Course','userid'=>$this->userid])->get('tbl_enroll');
					if($enrollResult->num_rows())
					{
						$result=$this->db->where(['course'=>$courseid,'video'=>$videoid])->get('tbl_lecture');
						if($result->num_rows())
						{
						    $UserData=$this->db->where(['id'=>$this->userid])->get('tbl_registration')->row();
						    $watch_no=($UserData->watch_no)+1;
						    $watch_minutes=($UserData->watch_minutes)+rand(1,15);
							$this->db->where(['id'=>$this->userid])->update('tbl_registration',['watch_no'=>$watch_no,'watch_minutes'=>$watch_minutes]);
							
							$enrollData=$enrollResult->row();
							
							$mark_as_completed=$enrollData->mark_as_completed;
							$mark_as_completed=explode(',',$enrollData->mark_as_completed);
							if(in_array($videoid, $mark_as_completed)){
								$completed='true';
							}
							else{
								$completed='false';
							}
							
							$output['res']="success";
							$output['msg']="Data Found";
							
							$return=[];
							$i=0;
							foreach($result->result() as $item)
							{
								$return[$i]=$item;
								$return[$i]->enroll = $enrollData;
								$return[$i]->course = $this->db->where(['id'=>$courseid])->get('tbl_course')->row();
								$return[$i]->video = $this->db->where(['id'=>$videoid])->get('tbl_video')->row();
								$return[$i]->video->author = $this->db->where(['id'=>$return[$i]->video->author])->get('tbl_tutor')->row();
								$getYoutubeLinkData=$this->Auth_model->getYoutubeLinkData($return[$i]->video->link);
                                $return[$i]->video->YoutubeId=$getYoutubeLinkData->id;
								$return[$i]->video->completed = $completed;
								$return[$i]->video->subjectdetails = $this->db->where(['id'=>$return[$i]->video->subject])->get('tbl_subject')->row();
								$return[$i]->assignment = $this->db->where(['video'=>$videoid])->get('tbl_video_assignment')->result();
								
								$assignments=[];
								$j=0;
								foreach($return[$i]->assignment as $assignment){
									$result1 = $this->db->where(['course'=>$courseid,'video'=>$videoid,'userid'=>$this->userid,'assignment'=>$assignment->id])->get('tbl_video_assignment_upload');
									if($result1->num_rows()){
										$upload_status='true';
										$answer=$result1->row();
									}
									else{
										$upload_status='false';
										$answer=(object) [];
									}
									$assignments[$j]=$assignment;
									$assignments[$j]->upload_status=$upload_status;
									$assignments[$j]->upload_link=base_url('Home/UploadAssignment/'.$courseid.'/'.$videoid.'/'.$assignment->id.'/'.$this->userid);
									$assignments[$j]->answer=$answer;
									
									$j++;
								}
								
								$return[$i]->assignment=$assignments;
								
								$result2=$this->db->where(['courseid'=>$courseid,'videoid'=>$videoid,'status'=>'true'])->get('tbl_video_question');
								$questions=[];
								if($result2->num_rows()){
									
									
									$k=0;
									foreach($result2->result() as $question){
										
										$result3 = $this->db->where(['questionid'=>$question->id,'status'=>'true'])->get('tbl_video_reply');
										if($result3->num_rows()){
											$reply_status='true';
											
											$l=0;
											$reply=[];
											foreach($result3->result() as $rep){
												$reply[$l]=$rep;
												if($rep->usertype=='Admin'){
													$name='CodersAdda';
													$profile_photo='codersadda.png';
												}
												else{
													$name='CodersAdda';
													$profile_photo='codersadda.png';
												}
												$user=['name'=>$name,'profile_photo'=>$profile_photo];
												$reply[$l]->user= (object) $user;
												$l++;
											}
										}
										else{
											$reply_status='false';
											$reply=[];
										}
										$questions[$k]=$question;
										$questions[$k]->user=$this->db->where(['id'=>$question->userid])->get('tbl_registration')->row();
										$questions[$k]->reply_status=$reply_status;
										$questions[$k]->reply=$reply;
										
										$k++;
									}
								}
								$return[$i]->question=$questions;
								
								$lectureResult=$this->db->where(["course"=>$courseid,'id>'=>$item->id])->get("tbl_lecture");
								$data1=array();
								foreach($lectureResult->result() as $video)
								{
									$vid=$video->video;
									$result3=$this->db->where("id",$vid)->get("tbl_video");
									$data2=$result3->result()[0];
									
									# Find and Add Subject Details
									$subid=$result3->result()[0]->subject;
									$result4=$this->db->where("id",$subid)->get("tbl_subject");
									$data2->subjectdetails=$result4->result()[0];
									
									$data1[]=$data2;
									
								}
								$return[$i]->upcommingList=$data1;
								
								$lectureResult=$this->db->where(["course"=>$courseid,'id<'=>$item->id])->get("tbl_lecture");
								$data1=array(); 
								foreach($lectureResult->result() as $video)
								{
									$vid=$video->video;
									$result3=$this->db->where("id",$vid)->get("tbl_video");
									$data2=$result3->result()[0];
									
									# Find and Add Subject Details
									$subid=$result3->result()[0]->subject;
									$result4=$this->db->where("id",$subid)->get("tbl_subject");
									$data2->subjectdetails=$result4->result()[0];
									
									$data1[]=$data2;
									
								}
								$return[$i]->watchAgainList=$data1;
								 
								$i++;
							}
							$output['data']=$return;
						}
						else{
							$output['msg']="Invalid Video";
						}
						
					}
					else{
						$output['msg']="You are not enrolled this course.";
					}
				}
				else{
					$output['msg']="No Record Found";
				}	
			}
			else{
				$msg=explode('</p>',validation_errors());
				$output['msg']=str_ireplace('<p>','', $msg[0]);
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		#Assignment
		
		public function Assignment()
		{
			$output['res']="error";
			$output['msg']="error";
			$output['data']="";
			
			if($this->uri->segment(4)){
				$action=$this->uri->segment(4);
				
				if($action=='Upload')
				{
					if(!empty($_POST) and $this->form_validation->run('uploadAssignment')) 
					{
						$userid=$this->input->post('userid');
						$courseid=$this->input->post('courseid');
						$videoid=$this->input->post('videoid');
						$assignmentid=$this->input->post('assignmentid');
						
						$wheredata=['course'=>$courseid,'video'=>$videoid,'userid'=>$userid,'assignment'=>$assignmentid];
						$result=$this->db->where($wheredata)->get('tbl_video_assignment_upload');
						if($result->num_rows())
						{
							$output['msg']="This assignment is already uploaded.";
						}
						else
						{
						    /*
						    $answer=$this->input->post('answer');
						    
				            if(!empty($answer)) 
							{
							    
							    $filename = time().rand(100000,999999).'.pdf';
    				            $binary1 = base64_decode($answer);
    				            header('Content-Type: bitmap; charset=utf-8');
    				            $file1 = fopen('./uploads/answer/'.$filename, 'wb');
    				            fwrite($file1, $binary1);
    				            fclose($file1);
    				            $insertData=['course'=>$courseid,'video'=>$videoid,'assignment'=>$assignmentid,'userid'=>$userid,'answer'=>$filename,'status'=>'true','date'=>$this->date,'time'=>$this->time];
								    if($this->db->insert('tbl_video_assignment_upload',$insertData))
								    {
										$output['res']="success";
										$output['msg']="Assignment Uploaded";
									}
									else{
										$output['msg']="Upload Failed !";
									}
									
							}
							else{
								$output['msg']="Choose video assignment answer.";
							}
							*/
							
							if(!empty($_FILES["answer"]["name"])) 
							{
								$ext = pathinfo($_FILES["answer"]["name"], PATHINFO_EXTENSION);
								$filename = time().rand(100000,999999).'.'.$ext;
								
								
								$config['upload_path']   = './uploads/answer/';
								$config['allowed_types'] = 'pdf';
								$config['max_size']      = 5000; 
								$config['file_name']     = $filename;
								$this->load->library('upload', $config);
								if($this->upload->do_upload('answer')){
									
									$insertData=['course'=>$courseid,'video'=>$videoid,'assignment'=>$assignmentid,'userid'=>$userid,'answer'=>$filename,'status'=>'true','date'=>$this->date,'time'=>$this->time];
									if($this->db->insert('tbl_video_assignment_upload',$insertData)){
										
										$output['res']="success";
										$output['msg']="Assignment Uploaded";
									}
									else{
										$output['msg']="Upload Failed !";
									}
								}
								else{
									$output['msg']="Choose document in pdf format.";
								}	
							}
							else{
								$output['msg']="Choose video assignment answer.";
							}
							
						}
					}
					else{
						$msg=explode('</p>',validation_errors());
						$output['msg']=str_ireplace('<p>','', $msg[0]);
					}
				}
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		# Video Question
		
		public function VideoQuestion()
		{
			$output['res']="error";
			$output['msg']="error";
			$output['data']="";
			
			if($this->uri->segment(4)){
				$action=$this->uri->segment(4);
				
				if($action=='Add')
				{
					if(!empty($_POST) and $this->form_validation->run('videoQuestion')) 
					{
						$insertData=[
						'courseid'=>$this->input->post('courseid'),
						'videoid'=>$this->input->post('videoid'),
						'userid'=>$this->input->post('userid'),
						'message'=>$this->input->post('message'),
						'status'=>'true',
						'date'=>$this->date,
						'time'=>$this->time
						];
						
						
						if(empty($this->input->post('questionid'))){
							$table='tbl_video_question';
							$key='Question';
						}
						else{
							$insertData['questionid']=$this->input->post('questionid');
							$table='tbl_video_reply';
							$key='Reply';
						}
						if($this->db->insert($table,$insertData)){
							
							$output['res']="success";
							$output['msg']=$key." Posted";
						}
						else{
							$output['msg']="Failed !";
						}
					}
					else{
						$msg=explode('</p>',validation_errors());
						$output['msg']=str_ireplace('<p>','', $msg[0]);
						
					}
				}
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		# Live Question
		
		public function LiveQuestion()
		{
			$output['res']="error";
			$output['msg']="error";
			$output['data']="";
			
			if($this->uri->segment(4)){
				$action=$this->uri->segment(4);
				
				if($action=='Add')
				{
					if(!empty($_POST) and $this->form_validation->run('liveQuestion')) 
					{
						$insertData=[
						'liveid'=>$this->input->post('liveid'),
						'userid'=>$this->input->post('userid'),
						'message'=>$this->input->post('message'),
						'status'=>'true',
						'date'=>$this->date,
						'time'=>$this->time
						];
						
						
						if(empty($this->input->post('questionid'))){
							$table='tbl_live_question';
							$key='Question';
						}
						else{
							$insertData['questionid']=$this->input->post('questionid');
							$table='tbl_live_reply';
							$key='Reply';
						}
						if($this->db->insert($table,$insertData)){
							
							$output['res']="success";
							$output['msg']=$key." Posted";
						}
						else{
							$output['msg']="Failed !";
						}
					}
					else{
						$msg=explode('</p>',validation_errors());
						$output['msg']=str_ireplace('<p>','', $msg[0]);
						
					}
				}
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		
		# Recommended Videos
		public function RecommendedVideos()
		{
			$output['res']="error";
			$output['msg']="error";
			$output['data']="";
			
			$table='tbl_recommended_videos';
			
			if($this->uri->segment(4) == TRUE) {
				
				$id = $this->uri->segment(4);
				$query = $this->db->where(['id'=>$id,'type'=>'RecommendedVideos'])->where("(`for_user`='Both' OR `for_user`='Student')")->get($table);
				if ($query->num_rows()) 
				{
					$output['res']='success';
					$output['msg']=$query->num_rows().' Record Found';
					
					$return=[];
					$i=0;
					
					foreach ($query->result() as $item){
						$return[$i]=$item;
						$return[$i]->author=$this->db->where('id',$item->author)->get('tbl_tutor')->row();
						$return[$i]->subject=$this->db->where('id',$item->subject)->get('tbl_subject')->row();
						$return[$i]->video=$this->db->where('id',$item->video)->get('tbl_video')->row();
						
						$getYoutubeLinkData=$this->Auth_model->getYoutubeLinkData($return[$i]->video->link);
                        $return[$i]->video->YoutubeId=$getYoutubeLinkData->id;
						$i++;
					}
					$output['data']=$return;
				}
				else{
					$output['msg']='No Record Found';
				} 
			}
			else{
				
				$query = $this->db->where(['status'=>'true','type'=>'RecommendedVideos'])->where("(`for_user`='Both' OR `for_user`='Student')")->order_by("id", "DESC")->get($table);
				
				$return=[];
				$i=0;
				if($query->num_rows()){
					
					$output['res']='success';
					$output['msg']=$query->num_rows().' Record Found';
					
					foreach ($query->result() as $item){
						$return[$i]=$item;
						$return[$i]->author=$this->db->where('id',$item->author)->get('tbl_tutor')->row();
						$return[$i]->subject=$this->db->where('id',$item->subject)->get('tbl_subject')->row();
						$return[$i]->video=$this->db->where('id',$item->video)->get('tbl_video')->row();
						
						$getYoutubeLinkData=$this->Auth_model->getYoutubeLinkData($return[$i]->video->link);
                        $return[$i]->video->YoutubeId=$getYoutubeLinkData->id;
						$i++;
					}
					$output['data']=$return; 
				}
				else{
					$output['msg']='No Record Found';
				}
				
				
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
			
		}
		
		# Free Videos
		public function FreeVideos()
		{
			$output['res']="error";
			$output['msg']="error";
			$output['data']="";
			
			$table='tbl_recommended_videos';
			
			if($this->uri->segment(4) == TRUE) {
				
				$id = $this->uri->segment(4);
				$query = $this->db->where(['id'=>$id,'type'=>'FreeVideos'])->where("(`for_user`='Both' OR `for_user`='Student')")->get($table);
				if ($query->num_rows()) 
				{
					$output['res']='success';
					$output['msg']=$query->num_rows().' Record Found';
					
					$return=[];
					$i=0;
					
				    foreach ($query->result() as $item){
						$return[$i]=$item;
						$return[$i]->author=$this->db->where('id',$item->author)->get('tbl_tutor')->row();
						$return[$i]->subject=$this->db->where('id',$item->subject)->get('tbl_subject')->row();
						$return[$i]->video=$this->db->where('id',$item->video)->get('tbl_video')->row();
						
						$getYoutubeLinkData=$this->Auth_model->getYoutubeLinkData($return[$i]->video->link);
                        $return[$i]->video->YoutubeId=$getYoutubeLinkData->id;
						$i++;
					}
					$output['data']=$return;
				}
				else{
					$output['msg']='No Record Found';
				} 
			}
			else{
				
				$query = $this->db->where(['status'=>'true','type'=>'FreeVideos'])->where("(`for_user`='Both' OR `for_user`='Student')")->order_by("id", "DESC")->get($table);
				
				$return=[];
				$i=0;
				if($query->num_rows()){
					
					$output['res']='success';
					$output['msg']=$query->num_rows().' Record Found';
					
					foreach ($query->result() as $item){
						$return[$i]=$item;
						$return[$i]->author=$this->db->where('id',$item->author)->get('tbl_tutor')->row();
						$return[$i]->subject=$this->db->where('id',$item->subject)->get('tbl_subject')->row();
						$return[$i]->video=$this->db->where('id',$item->video)->get('tbl_video')->row();
						
						$getYoutubeLinkData=$this->Auth_model->getYoutubeLinkData($return[$i]->video->link);
                        $return[$i]->video->YoutubeId=$getYoutubeLinkData->id;
						$i++;
					}
					$output['data']=$return; 
				}
				else{
					$output['msg']='No Record Found';
				}
				
				
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
			
		}
		
		# Short Tricks
		public function ShortTricks()
		{
			$output['res']="error";
			$output['msg']="error";
			$output['data']="";
			
			$table='tbl_recommended_videos';
			
			if($this->uri->segment(4) == TRUE) {
				
				$id = $this->uri->segment(4);
				$query = $this->db->where(['id'=>$id,'type'=>'ShortTricks'])->where("(`for_user`='Both' OR `for_user`='Student')")->get($table);
				if ($query->num_rows()) 
				{
					$output['res']='success';
					$output['msg']=$query->num_rows().' Record Found';
					
					$return=[];
					$i=0;
					
					foreach ($query->result() as $item){
						$return[$i]=$item;
						$return[$i]->author=$this->db->where('id',$item->author)->get('tbl_tutor')->row();
						$return[$i]->subject=$this->db->where('id',$item->subject)->get('tbl_subject')->row();
						$return[$i]->video=$this->db->where('id',$item->video)->get('tbl_video')->row();
						
						$getYoutubeLinkData=$this->Auth_model->getYoutubeLinkData($return[$i]->video->link);
                        $return[$i]->video->YoutubeId=$getYoutubeLinkData->id;
						$i++;
					}
					$output['data']=$return;
				}
				else{
					$output['msg']='No Record Found';
				} 
			}
			else{
				
				$query = $this->db->where(['status'=>'true','type'=>'ShortTricks'])->where("(`for_user`='Both' OR `for_user`='Student')")->order_by("id", "DESC")->get($table);
				
				$return=[];
				$i=0;
				if($query->num_rows()){
					
					$output['res']='success';
					$output['msg']=$query->num_rows().' Record Found';
					
					foreach ($query->result() as $item){
						$return[$i]=$item;
						$return[$i]->author=$this->db->where('id',$item->author)->get('tbl_tutor')->row();
						$return[$i]->subject=$this->db->where('id',$item->subject)->get('tbl_subject')->row();
						$return[$i]->video=$this->db->where('id',$item->video)->get('tbl_video')->row();
						
						$getYoutubeLinkData=$this->Auth_model->getYoutubeLinkData($return[$i]->video->link);
                        $return[$i]->video->YoutubeId=$getYoutubeLinkData->id;
						$i++;
					}
					$output['data']=$return; 
				}
				else{
					$output['msg']='No Record Found';
				}
				
				
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
			
		}
		
		public function MyCertificates()
		{
			
			$output['res']="error";
			$output['msg']="error";
			$output['data']="";
			
			if(!empty($_POST) and $this->form_validation->run('myItem')) 
			{
				$result=$this->db->where(['userid'=>$this->userid,'status'=>'true'])->order_by("id", "DESC")->get('tbl_certificate');
				if($result->num_rows()){
					
					
					$output['res']='success';
					$output['msg']=$result->num_rows().' Record Found';
					$return=[];
					$i=0;
					
					foreach ($result->result() as $value)
					{
						$return[$i]=$value;
						if($value->itemtype=='Course'){
							$return[$i]->item=$this->db->where('id',$value->itemid)->get('tbl_course')->row();
						}
						if($value->itemtype=='LiveSession'){
							$return[$i]->item=$this->db->where('id',$value->itemid)->get('tbl_live_video')->row();
						}
						$return[$i]->item->author=$this->db->where('id',$return[$i]->item->author)->get('tbl_tutor')->row();
						
						$i++;
					}
					
					$output['data']=$return;
				}
				else{
					$output['msg']='No Record Found';
				}
			}
			else{
				$msg=explode('</p>',validation_errors());
				$output['msg']=str_ireplace('<p>','', $msg[0]);
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
			
		}
		
		public function Testimonial()
		{
			$output['res']="error";
			$output['msg']="error";
			$output['data']="";
			
			$result=$this->db->where(['status'=>'true'])->order_by("id", "ASC")->get('tbl_testimonial');
			$count=$result->num_rows();
			if($count)
			{
				$output['res']='success';
				$output['msg']=$count.' Testimonial Found';
				
				
				$i=0;
				$return=[];
				foreach($result->result() as $item){
					
					$return[$i]=$item;
					
					$i++;
				}
				$output['data']=$return;
			}
			else{
				$output['msg']="No Record Found";
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		public function Team()
		{
			$output['res']="error";
			$output['msg']="error";
			$output['data']="";
			
			$result=$this->db->where(['status'=>'true'])->order_by("position", "ASC")->get('tbl_team');
			$count=$result->num_rows();
			if($count)
			{
				$output['res']='success';
				$output['msg']=$count.' Team Member Found';
				
				
				$i=0;
				$return=[];
				foreach($result->result() as $item){
					
					$return[$i]=$item;
					
					$i++;
				}
				$output['data']=$return;
			}
			else{
				$output['msg']="No Record Found";
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		public function MarkAsCompleted()
		{
			$table='tbl_enroll';
			
			$output['res']="error";
			$output['msg']="error";
			$output['data']="";
			
			if(!empty($_POST) and $this->form_validation->run('MarkAsCompleted')) 
			{
				$enrollid=$this->input->post('enrollid');
				$videoid=$this->input->post('videoid');
				$query = $this->db->where('id', $enrollid)->get($table);
				if($query->num_rows()){
					
					$enrollData=$query->row();
					$mark_as_completed=$enrollData->mark_as_completed;
					$mark_as_completed=explode(',',$enrollData->mark_as_completed);
					if(in_array($videoid, $mark_as_completed)){
						$output['msg']="Lecture Already Mark As Completed.";
					}
					else{
						array_push($mark_as_completed,$videoid);
						$mark_as_completed=implode(',',$mark_as_completed);
						
						$this->db->where(['id'=>$enrollid])->update($table,['mark_as_completed'=>$mark_as_completed]);
						
						$output['res']="success";
						$output['msg']="Lecture Mark As Completed.";
					}
				}
				else{
					$output['msg']="Invalid Enroll ID";
				}
			}
			else{
				$msg=explode('</p>',validation_errors());
				$output['msg']=str_ireplace('<p>','', $msg[0]);
				
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		public function RequestCertificate()
		{
			$table='tbl_enroll';
			$output['res']="error";
			$output['msg']="error";
			$output['data']="";
			
			if(!empty($_POST) and $this->form_validation->run('RequestCertificate')) 
			{
				$enrollid=$this->input->post('enrollid');
				$query = $this->db->where(['id'=>$enrollid,'paymentstatus'=>'success'])->get($table);
				if($query->num_rows())
				{
					
					$enrollData=$query->row();
					
					$courseData = $this->db->where(['id'=>$enrollData->itemid])->get('tbl_course')->row();
					
					$cresult = $this->db->where(['userid'=>$this->userid,'enrollid'=>$enrollData->id])->get('tbl_certificate');
					if($cresult->num_rows())
					{
						$this->db->where(['userid'=>$this->userid,'enrollid'=>$enrollData->id])->update('tbl_certificate',['status'=>'requested']);
						
					}
					else{
						$insertData=[
						'userid' => $enrollData->userid,
						'enrollid' => $enrollData->id,
						'name' => $enrollData->firstname.' '.$enrollData->lastname,
						'mobile' => $enrollData->mobile,
						'email' => $enrollData->email,
						'issuedon' => $this->dateY,
						'grade' =>'A+',
						'duration' =>$courseData->daystofinish.' Days',
						'from_date' => date('Y-m-d',strtotime($enrollData->date)),
						'to_date' => date('Y-m-d',strtotime('+'.$courseData->daystofinish.' days',strtotime($enrollData->date))),
						'itemid' => $enrollData->itemid,
						'itemtype' => $enrollData->itemtype,
						'status' => 'requested',
						'date'=>$this->dateY,
						'time'=>$this->time
						];
						$this->db->insert('tbl_certificate',$insertData);
						
						$insert_id = $this->db->insert_id();
						
						$refno='DCT'.date('Y').'0'.$insert_id;
						
						$this->db->where(['userid' => $this->userid,'id' => $enrollData->id,])->update('tbl_enroll',['issuedon'=>$this->dateY,'refno'=>$refno,'certificate'=>'false']);
						
						$this->db->where(['id'=>$insert_id])->update('tbl_certificate',['refno'=>$refno]);
					}
					$output['res']="success";
					$output['msg']="Cerificate Requested";
					
				}
				else{
					$output['msg']="Invalid Enroll ID";
				}
			}
			else{
				$msg=explode('</p>',validation_errors());
				$output['msg']=str_ireplace('<p>','', $msg[0]);
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
			
		}
		
		public function CalculateCharge()
		{
			$table='tbl_enroll';
			$output['res']="error";
			$output['msg']="error";
			$output['data']="";
			
			if(!empty($_POST) and $this->form_validation->run('CalculateCharge')) 
			{
				$itemtype=$this->input->post('itemtype');
				$itemid=$this->input->post('itemid');
				$pincode=$this->input->post('pincode');
				
				if($itemtype=='Course'){
					$table='tbl_course';
				}
				else if($itemtype=='LiveSession'){
					$table='tbl_live_video';
				}
				else{
					$table='tbl_course';
				}
				
				$query = $this->db->where(['id'=>$itemid])->get($table);
				if($query->num_rows())
				{
					
					$itemData=$query->row();
					$response=$this->codersadda->calculateDistance($pincode);
					
					$certificate_charge=$itemData->certificate_charge;
					$km_charge=$itemData->km_charge;
					
					$amount=$certificate_charge+($km_charge*$response->distance);
					$response->certificate_charge=$certificate_charge;
					$response->km_charge=$km_charge;
					$response->amount=$amount;
					
					$output['res']="success";
					$output['msg']="Certificate Charge Calculated";
					$output['data']=$response;
				}
				else{
					$output['msg']="Invalid Item ";
				}
			}
			else{
				$msg=explode('</p>',validation_errors());
				$output['msg']=str_ireplace('<p>','', $msg[0]);
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
			
		}
		
		public function CertificateOrder()
		{
			$table="tbl_certificate_order";
			
			$output['res']="error";
			$output['msg']="error";
			$output['data']="";
			
			if($this->uri->segment(4) == TRUE)
			{
				
				$action=$this->uri->segment(4);
				if($action=='Create')
				{
					if(!empty($_POST) and $this->form_validation->run('CertificateOrderCreate')) 
					{
						$result=$this->db->order_by("id", "DESC")->limit(1)->get($table);
						if($result->num_rows()>0)
						{
							$lastid=$result->result()[0]->id;
							$lastid=(int)$lastid+1;
							$orderid="CA_CHP_Order_".$lastid."_".date("dmYhis");
						}
						else
						{
							$orderid="CA_CHP_Order_1_".date("dmYhis");
						}
						
						$amount=$this->input->post('amount');
						$rzp_orderid=$this->razorpay->getRazorpayOrderID($orderid,$amount);
						$paymentid='Pending';
						$status='Pending';
						
						$insertData = array(
						"userid" => $this->input->post('userid'),
						"refno" => $this->input->post('refno'),
						"name" => $this->input->post('name'),
						"mobile" => $this->input->post('mobile'),
						"alt_mobile" => $this->input->post('alt_mobile'),
						"email" => $this->input->post('email'),
						"address" => $this->input->post('address'),
						"pincode" => $this->input->post('pincode'),
						"state" => $this->input->post('state'),
						"country" => $this->input->post('country'),
						"latitude" => $this->input->post('latitude'),
						"longitude" => $this->input->post('longitude'),
						"distance" => $this->input->post('distance'),
						"certificate_charge" => $this->input->post('certificate_charge'),
						"km_charge" => $this->input->post('km_charge'),
						"amount" => $amount,
						"orderid" => $orderid,
						"rzp_orderid" => $rzp_orderid,
						"paymentid" => $paymentid,
						"status" => $status,
						"order_status" => 'Order Pending',
						"expected_date" =>'Updating In Progress..',
						"delivery_date" =>'',
						"date" => $this->dateY,
						"time" => $this->time,
						);
						
						$insertData = $this->security->xss_clean($insertData);
						
						if($this->db->insert($table,$insertData))
						{
							$output['res']="success";
							$output['msg']="Order Created";
							$output['data']=array("OrderId"=>$rzp_orderid);
						}
						else
						{
							$output['msg']="Try Again";
						}
					}
					else
					{
						$msg=explode('</p>',validation_errors());
						$output['msg']=str_ireplace('<p>','', $msg[0]);
					}
				}
				else if($action=='UpdateStatus')
				{
					if(!empty($_POST) and $this->form_validation->run('CertificateOrderUpdateStatus')) 
					{
						$orderid=$this->input->post('orderid');
						$paymentid=$this->input->post('paymentid');
						$status=$this->input->post('status');
						
						$rzp_order=$this->razorpay->getRazorpayOrder($orderid);
						if($rzp_order->status=='paid'){
							$status='success';
						}
						else{
							$status='failed';
						}
						
						if($this->db->where(['rzp_orderid'=>$orderid])->update($table,['paymentid'=>$paymentid,'status'=>$status,'order_status'=>'Order Placed']))
						{
							$output['res']="success";
							$output['msg']="Payment Status Updated";
							
							$data=$this->db->where(['rzp_orderid'=>$orderid])->get($table)->row();
							
							$output['data']=$data;
						}
						else{
							$output['msg']="Failed !";	
						}
					}
					else
					{
						$msg=explode('</p>',validation_errors());
						$output['msg']=str_ireplace('<p>','', $msg[0]);
					}
				}
				else if($action=='History')
				{
					if(!empty($_POST) and $this->form_validation->run('CertificateOrderHistory')) 
					{
						$refno=$this->input->post('refno');
						
						$result=$this->db->where(['refno'=>$refno])->order_by("id", "DESC")->get($table);
						$count=$result->num_rows();
						if($count)
						{
							$output['res']='success';
							$output['msg']=$count.' Record Found';
							$output['data']=$result->result();
						}
						else{
							$output['msg']="No Record Found";
						}
					}
					else
					{
						$msg=explode('</p>',validation_errors());
						$output['msg']=str_ireplace('<p>','', $msg[0]);
					}
				}
				else{
					$output['msg']="Action Invalid.";	
				}
			}
			else{
				$output['msg']="Action Required.";
			} 
			
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
			
		}
		
		# EducatorData
		public function EducatorData()
		{
			$output['res']="error";
			$output['msg']="error";
			$output['data']="";
			
			if(!empty($_POST) and !empty($this->input->post('educator_id'))) 
			{
				$result=$this->db->where('id',$this->input->post('educator_id'))->get('tbl_tutor');
				if($result->num_rows())
				{
					$values=$result->row();
					
					$values->courses=$this->db->where(['author'=>$values->id,'apprstatus'=>'true'])->order_by('id','DESC')->get('tbl_course')->result();
					$values->ebooks=$this->db->where(['author'=>$values->id,'apprstatus'=>'true'])->order_by('id','DESC')->get('tbl_ebook')->result();
					$values->abooks=$this->db->where(['author'=>$values->id,'apprstatus'=>'true'])->order_by('id','DESC')->get('tbl_abook')->result();
					$values->live_sessions=$this->db->where(['author'=>$values->id,'status'=>'true'])->order_by('id','DESC')->get('tbl_live_video')->result();
					
					$i=0; $return=[];
					foreach($values->live_sessions as $live)
					{
						$return[$i]=$live;
						$return[$i]->author=$this->db->where(['id'=>$live->author])->get('tbl_tutor')->row();
						$result1=$this->db->where(['liveid'=>$live->id,'userid'=>$this->userid])->get('tbl_live_join');
						if($result1->num_rows())
						{
							$joined='true';
						}
						else{
							$joined='false';
						}
						$return[$i]->joined=$joined;
						$i++;
					}
					$values->live_sessions=$return;
					
					
					$query = $this->db->where('status','true')->where('teacher_id',$this->input->post('educator_id'))->order_by("id", "DESC")->get('tbl_quiz_scheduled');
					$quizList=[]; $j=0; 
					foreach($query->result() as $item)
					{	
						$item->quiz=$this->Auth_model->getData('tbl_quiz',$item->quiz_id);
						$item->course=$this->Auth_model->getData('tbl_course',$item->course_id);
						$item->teacher=$this->Auth_model->getData('tbl_tutor',$item->teacher_id);
						$result=$this->db->where(['schedule_id'=>$item->id,'student_id'=>$this->userid])->order_by("id", "DESC")->get('tbl_quiz_attended');
						if($result->num_rows())
						{
							$item->resultList=$result->row();
							$ansBook=$item->resultList->ansBook;
							
							$item->resultList->rank=$this->Auth_model->getRank($item->id,$item->resultList->student_id);       
							$item->resultList->out_of_rank=$this->db->where(['schedule_id'=>$item->id])->get('tbl_quiz_attended')->num_rows();     
							$item->resultList->ansBook=[];      
							if($ansBook){ 
								$ansBook=json_decode($ansBook);
								$i=0;$return=[];
								foreach($ansBook as $itemvalue)
								{
									$return[$i]=$itemvalue;
									$return[$i]->questionData=$this->db->where(['id'=>$itemvalue->questionId])->get('tbl_questions')->row();
									$i++;
								} 
								$item->resultList->ansBook=$return;
							}
						}
						$quizList[$j]=$item;
						$j++;
					} 
					$values->quizList=$quizList;
					
					$output['res']='success';
					$output['msg']='Educator Data';
					$output['data']=$values;
					
				}
				else
				{
					$output['msg']='Educator ID is invalid.';
				}
				
			}
			else
			{
				$output['msg']='Educator ID is required.';
			}
			
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		# Quiz 
		public function MyQuiz()
		{
			
			$output['res']="error";
			$output['msg']="error";
			$output['data']="";
			if($this->uri->segment(4)==TRUE) 
			{
				$action=$this->uri->segment(4);
				if($action=='Quiz')
				{
					$query = $this->db->where('status','true')->order_by("id", "DESC")->get('tbl_quiz_scheduled');
					if($query->num_rows())
					{
						$upcommingList=[];
						$completedList=[];
						$inprogressList=[];
						foreach($query->result() as $item)
						{
							$item->quiz=$this->Auth_model->getData('tbl_quiz',$item->quiz_id);
							$item->course=$this->Auth_model->getData('tbl_course',$item->course_id);
							$item->teacher=$this->Auth_model->getData('tbl_tutor',$item->teacher_id);
							$result=$this->db->where(['schedule_id'=>$item->id,'student_id'=>$this->userid])->order_by('id','DESC')->get('tbl_quiz_attended');
							if($result->num_rows()){
								$completedList[]=$item;
								$item->resultList=$result->row();
								$ansBook=$item->resultList->ansBook;
								
								$item->resultList->rank=$this->Auth_model->getRank($item->id,$item->resultList->student_id);  
								$item->resultList->out_of_rank=$this->db->where(['schedule_id'=>$item->id])->get('tbl_quiz_attended')->num_rows();     
								$item->resultList->ansBook=[];      
								if($ansBook){ 
									$ansBook=json_decode($ansBook);
									$i=0;$return=[];
									foreach($ansBook as $itemvalue)
									{
										$return[$i]=$itemvalue;
										$return[$i]->questionData=$this->db->where(['id'=>$itemvalue->questionId])->get('tbl_questions')->row();
										$i++; 
									}
									$item->resultList->ansBook=$return;
								}
							}
							else{
								if(strtotime($item->timing)<strtotime(date('Y-m-d H:i:s'))){
									$inprogressList[]=$item;
								}
								else{
									$upcommingList[]=$item;
								}
								 
							}
						}
						 
						$data['inprogressList']=$inprogressList; 
						$data['upcommingList']=$upcommingList; 
						$data['unattemptedList']=$upcommingList+$inprogressList; 
						$data['completedList']=$completedList;
						
						$output['res']="success";
						$output['msg']="Quiz";
						$output['data']=$data;
					}
					else{
						$output['msg']="No Quiz Available.";
					}
					  
				}  
				else if($action=='Attend')
				{  
					$query = $this->db->where(['id'=>$this->uri->segment(5),'status'=>'true'])->order_by("id", "DESC")->get('tbl_quiz_scheduled');
					if($query->num_rows())
					{
						$data['action']='Attend';
						$data['list']=$query->result();
						
						if(strtotime($data['list'][0]->timing)>strtotime(date('Y-m-d H:i:s'))){
							// redirect('Student/MyQuiz');
						}
						$result = $this->db->where('id', $data["list"][0]->quiz_id)->get('tbl_quiz');
						$data['quizData']=$result->result();
						
						$return=[];
						$questions=explode(',',$data['quizData'][0]->questions);
						for($i=0;$i<count($questions);$i++)
						{
							$return[$i]=$this->db->where('id',$questions[$i])->get('tbl_questions')->row();
						}
						$data["questionslist"]=$return; 
						
				// 		$result=$this->db->where(['schedule_id'=>$data["list"][0]->id,'student_id'=>$this->userid])->get('tbl_quiz_attended');
				// 		if($result->num_rows()){
				// 		    $data["resultList"]=$result->row();
				// 		}
				// 		else{
				// 		    $data["resultList"]=[];
				// 		    $result=$this->db->where(['schedule_id'=>$data["list"][0]->id,'student_id'=>$this->userid])->get('tbl_quiz_attended');
				// 		}
						 
						
						$output['res']="success";
						$output['msg']="Quiz!";
						$output['data']=$data;
					}
					else
					{
						$output['msg']="Invalid Quiz ID";	
					}
				}
				else if($action=='Submit')
				{
					$query = $this->db->where(['id'=>$this->uri->segment(5),'status'=>'true'])->order_by("id", "DESC")->get('tbl_quiz_scheduled');
					if($query->num_rows())
					{
						$data['action']='Attend';
						$data['list']=$query->result();
						
						if(strtotime($data['list'][0]->timing)>strtotime(date('Y-m-d H:i:s'))){
							// redirect('Student/MyQuiz');
						}
						$result = $this->db->where('id', $data["list"][0]->quiz_id)->get('tbl_quiz');
						$data['quizData']=$result->result();
						
						$return=[];
						$questions=explode(',',$data['quizData'][0]->questions);
						for($i=0;$i<count($questions);$i++)
						{
							$return[$i]=$this->db->where('id',$questions[$i])->get('tbl_questions')->row();
						}
						$data["questionslist"]=$return; 
						
						$result=$this->db->where(['schedule_id'=>$data["list"][0]->id,'student_id'=>$this->userid])->get('tbl_quiz_attended');
						$data["resultList"]=$result->row(); 
						
				// 		if($result->num_rows())
				// 		{
				// 			$output['res']="success";
				// 			$output['msg']="Quiz Already Submitted!";
				// 		}
				// 		else
				// 		{
							if(!empty($this->input->post()))
							{
								$right=$this->input->post('right');
								$wrong=$this->input->post('wrong');
								$score=$this->input->post('score');
								$ansBook=$this->input->post('ansBook');
								
								$insertData= [
								'franchise_id'=>0,
								'teacher_id'=>$data['list'][0]->teacher_id,
								'student_id'=>$this->userid,
								'schedule_id'=>$data['list'][0]->id,
								'quiz_id'=>$data['list'][0]->quiz_id,
								'right'=>$right,
								'wrong'=>$wrong,
								'score'=>$score,
								'ansBook'=>$ansBook,
								'timing'=>$data['quizData'][0]->timing,
								'status'=>'true',
								'date'=>$this->dateY,
								'time'=>$this->time
								];
								$insertData = $this->security->xss_clean($insertData);
								$this->db->insert('tbl_quiz_attended', $insertData);
								
								$insert_id=$this->db->insert_id();
								
								$results=$this->db->where(['id'=>$insert_id])->get('tbl_quiz_attended')->row();
								
								$results_1=$this->db->where(['id'=>$results->quiz_id])->get('tbl_quiz')->row();
								$ansBook=$results->ansBook;
								
								$results->no_of_questions=$results_1->no_of_questions;
								$results->per_question_no=$results_1->per_question_no;
								
								$results->rank=$this->Auth_model->getRank($results->schedule_id,$results->student_id);  
								$results->out_of_rank=$this->db->where(['schedule_id'=>$results->schedule_id])->get('tbl_quiz_attended')->num_rows();     
								$results->ansBook=[];      
								if($ansBook){ 
									$ansBook=json_decode($ansBook);
									$i=0;$return=[];
									foreach($ansBook as $itemvalue)
									{
										$return[$i]=$itemvalue;
										$return[$i]->questionData=$this->db->where(['id'=>$itemvalue->questionId])->get('tbl_questions')->row();
										$i++; 
									}
									$results->ansBook=$return;
								}
								
								$output['res']="success";
								$output['msg']="Quiz Submitted!";
								$output['data']=$results;
							}
							else{
								$output['msg']="error";
							}
				// 		}
						
					}
					else
					{
						$output['msg']="Invalid Quiz ID";	
					}
				}
				else{
					$output['msg']="Action is invalid.";
				}
			}
			else{
				$output['msg']="Action is required.";	
			}
			echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
		public function Banners()
        {
            $result=$this->db->where(['banner_1'=>'true'])->get('tbl_slider');
            if($result->num_rows()){
                $values=$result->row();
                $banner_1=base_url('uploads/slider/').$values->image;
                $banner_1_parameter=$values->parameter;
                $banner_1_link=$values->link;
            }
            else{
                $banner_1='';
                $banner_1_parameter='';
                $banner_1_link='';
            }
            
            $result=$this->db->where(['banner_2'=>'true'])->get('tbl_slider');
            if($result->num_rows()){
                $values=$result->row();
                $banner_2=base_url('uploads/slider/').$values->image;
                $banner_2_parameter=$values->parameter;
                $banner_2_link=$values->link;
            }
            else{
                $banner_2='';
                $banner_2_parameter='';
                $banner_2_link='';
            }
			$data= (object) [
			'banner_1'=>$banner_1,
			'banner_1_parameter'=>$banner_1_parameter,
			'banner_1_link'=>$banner_1_link,
			'banner_2'=>$banner_2,
			'banner_2_parameter'=>$banner_2_parameter,
			'banner_2_link'=>$banner_2_link,
			];
			
			$output['res']="success"; 
            $output['msg']="Banners";
			$output['data']=$data;
			
            echo json_encode([$output], JSON_UNESCAPED_UNICODE);
		}
		
	}
	
?>