<?php
	defined("BASEPATH") or exit("No direct scripts allowed here");
	class Home extends MY_Controller
	{
		
		private $date,$time;
		public function __construct()
		{
			parent::__construct();
			
			date_default_timezone_set("Asia/Kolkata");
			$this->date=date("d-m-Y");
			$this->time=date("h:i:sa");
			$this->dateY=date("Y-m-d");
			
			$this->load->model('Auth_model');
			$this->load->library('CodersAdda');
			$this->load->library('form_validation');
			
			// $this->load->library('facebooklogin');
			// $this->load->library('googlelogin');
			
			$query=$this->db->order_by('id','ASC')->limit(9,0)->get('tbl_category');
			$this->categorylist=$query->result();
			
			if(empty($this->session->get_userdata()['StudentData'])){
				$this->userid=0;
			}
			else{
				$this->userid=$this->session->get_userdata()['StudentData']->id;
			}
			
		} 
		
		public function Blog() 
		{
			$this->load->view("Website/Blog");    
		}
		
		public function BlogDetails()  
		{
			$this->load->view("Website/BlogDetails");    
		}
		
		
		public function Test() 
		{  
// 			$result=$this->db->query("SELECT * FROM `tbl_recommended_videos`");
// 			foreach($result->result() as $item)
// 			{
// 			    var_dump($item);
// 			    $video_id=$item->video;
// 			    $vresult=$this->db->query("SELECT * FROM `tbl_video` WHERE `id`='$video_id'");
// 			    $title=$vresult->row()->title;
// 			    $this->db->where('video',$video_id)->update('tbl_recommended_videos',['title'=>$title]);
// 			} 
			
			// $this->codersadda->calculateDistance('226007'); 
			// mkdir('./uploads/amit', 0777, TRUE);
// 			phpinfo();
			
		}
		
		public function index1()
		{
		    redirect('https://karmasu.in');
		}
		
		public function index()
		{
			$query=$this->db->where(['status'=>'true','type'=>'Website'])->order_by('id','ASC')->get('tbl_slider');
			$data["sliderlist"]=$query->result();   
			
			$EnrolledItems=$this->EnrolledItems('Course',$this->userid);
			$result=$this->db->where(['apprstatus'=>'true'])->where_not_in('id',$EnrolledItems)->order_by("trending", "ASC")->limit(6)->get('tbl_course');
			
			$i=0;
			$return=[];
			foreach($result->result() as $item)
			{
				$AverageReview=$this->AverageReview('Course',$item->id);
				$return[$i]=$item;	
				$return[$i]->author=$this->db->where('id',$return[$i]->author)->get('tbl_tutor')->row();
				$return[$i]->rating=$AverageReview['rating'];		
				$return[$i]->totalrating=$AverageReview['ratingcount'];		
				$i++;
			}
			$data["courselist"]=$return; 
			
			$query=$this->db->where(['status'=>'true'])->order_by('id','ASC')->get('tbl_testimonial');
			$data["testilist"]=$query->result();
			
			$query=$this->db->where(['status'=>'true'])->order_by('position','ASC')->limit(4)->get('tbl_tutor');
			$data["tutorlist"]=$query->result();  
			
			$query=$this->db->where(['status'=>'true'])->order_by('id','DESC')->limit('3')->get('tbl_blog');
			
			$i=0;
			$return=[];
			foreach($query->result() as $item){
				$return[$i]=$item;
				$return[$i]->author=$this->db->where(['id'=>$item->author])->get('tbl_tutor')->row();
				$return[$i]->category=$this->db->where(['id'=>$item->category])->get('tbl_category')->row();
				$i++;
			}
			$data["bloglist"]=$return;
			
			$this->load->view("Website/index",$data);    
		}
		
		public function ControlPanelLogin()
		{
			if(isset($_POST["adminlogin"]))
			{		
				if ($this->form_validation->run('adminlogin') == FALSE) 
				{
					$this->load->view("Website/AdminLogin.php");
				}
				else
				{
					# Fetch Posted form data and Apply XSS Clean to protect from Cross Site Scripting
					$data=$this->input->post();
					$data = $this->security->xss_clean($data);
					
					# Get Cleaned Data
					$email=$data["username"];
					$password=$data["password"];
					
					# Login Login Library and get all the system details
					$this->load->library('LoginDetails');
					$ip=$this->logindetails->get_ip();
					$mac=$this->logindetails->get_mac();
					$os=$this->logindetails->get_os();
					$useragent=$this->logindetails->get_useragent();
					$username=$this->logindetails->get_username();
					
					# Validate Email id and password from database
					$query1=$this->db->where(['Email'=>$email,'Password'=>$password])->get('tbl_adminlogin');
					if($query1->num_rows()>0)
					{	
						# Fetch User data to be login			
						$data_fetch1=$query1->result_array();
						if($data_fetch1[0]["Status"]=="true")
						{
							
							# Create array for login details insertion
							$logindetails_data=array(
							"LoginID"=>$data_fetch1[0]["id"],
							"IP"=>$ip,
							"MAC"=>$mac,
							"UserName"=>$username,
							"BrowserName"=>$useragent,
							"OSName"=>$os,
							"Date"=>$this->dateY,
							"Time"=>$this->time
							);
							# Save login details
							$this->db->insert("tbl_adminlogindetails",$logindetails_data);
							
							# Update Last Login
							$this->db->where(['id'=>$data_fetch1[0]["id"]])->update('tbl_adminlogin',['LastLoginDate'=>$this->date,'LastLoginTime'=>$this->time]);
							
							# Send Login Alert email
							$this->load->library('email');
							$this->email->clear();
							$this->email->set_newline("\r\n");
							
							$config = array();
							$config['protocol'] = 'smtp';
							$config['smtp_host'] = 'smtpout.secureserver.net';
							$config['smtp_user'] = 'info@codersadda.com';
							$config['smtp_pass'] = 'digi#coders#123';
							$config['smtp_from_name'] = 'CodersAdda';
							$config['smtp_port'] = 465;
							$config['smtp_crypto'] = "ssl";
							$config['mailtype'] = "html";
							$config['wordwrap'] = TRUE;
							$this->email->initialize($config);
							
							$from_email="info@codersadda.com";
							$to_email=$email;
							$cc_email="digicoderstech@gmail.com";
							
							$this->email->from($from_email, 'CodersAdda');
							$this->email->to($to_email);
							$this->email->cc($cc_email);
							$this->email->subject('Login Alert in CoderdAdda Admin Account at '.$this->date.' '.$this->time);
							
							$msgbody="Hello ".$data_fetch1[0]["Name"]." (".$email."), <br/> We have detected an login alert in your CodersAdda Admin Account using ".$email." Email Address with Following details <br/><br/> <table cellpadding='10' border='1' style='border-collapse:collapse;' > <tr> <th>Login ID</th> <td> ".$data_fetch1[0]["id"]." </td> </tr> <tr> <th>IP Address</th> <td> ".$ip."</td> </tr> <tr> <th>MAC Address</th> <td>".$mac."</td> </tr> <tr> <th>User Name</th> <td>".$username."</td> </tr> <tr> <th>Browser Name ID</th>  <td>".$useragent."</td> </tr> <tr> <th>OS Name</th> <td>".$os."</td> </tr> <tr> <th>Date</th> <td>".$this->date."</td> </tr> <tr> <th>Time</th> 	<td>".$this->time."</td> </tr> </table> <br/> <br/> If this was not you, then please change your password immidialty. ";
							
							$this->email->message($msgbody);
							
							# Send mail
							# $emailStatus=$this->email->send();
							$emailStatus=true;
							
							if($emailStatus==true)
							{
								# Create Admin Login Session
								$this->session->set_userdata("AdminEmailSession",$email);
								$this->session->set_userdata("AdminIDSession",$data_fetch1[0]["id"]);
								redirect(base_url("AdminPanel/Dashboard"));
							}
							else
							{
								$this->session->set_flashdata("status","error");
								$this->load->view("Website/AdminLogin.php");
							}
						}
						else
						{
							$this->session->set_flashdata("status","blocked");
							$this->load->view("Website/AdminLogin.php");
						}
						
					}
					else
					{
						$this->session->set_flashdata("status","invalidemailorpassword");
						$this->load->view("Website/AdminLogin.php");
					}
					
				}
				
			}
			else
			{
				$this->load->view("Website/AdminLogin.php");
			}
			
		}
		
		public function EducatorLogin()
		{
			if(isset($_POST["educatorlogin"]))
			{		
				if ($this->form_validation->run('educatorlogin') == FALSE) 
				{
					$this->load->view("Website/EducatorLogin.php");
				}
				else
				{
					# Fetch Posted form data and Apply XSS Clean to protect from Cross Site Scripting
					$data=$this->input->post();
					$data = $this->security->xss_clean($data);
					
					# Get Cleaned Data
					$email=$data["username"];
					$password=$data["password"];
					
					# Login Login Library and get all the system details
					$this->load->library('LoginDetails');
					$ip=$this->logindetails->get_ip();
					$mac=$this->logindetails->get_mac();
					$os=$this->logindetails->get_os();
					$useragent=$this->logindetails->get_useragent();
					$username=$this->logindetails->get_username();
					
					# Validate Email id and password from database
					$query1=$this->db->where("(`mobile`='$email' OR `email`='$email') AND `password`='$password'")->get('tbl_tutor');
					if($query1->num_rows()>0)
					{	
						# Fetch User data to be login			
						$data_fetch1=$query1->result_array();
						if($data_fetch1[0]["status"]=="true")
						{
							
							# Create array for login details insertion
							$logindetails_data=array(
							"LoginID"=>$data_fetch1[0]["id"],
							"IP"=>$ip,
							"MAC"=>$mac,
							"UserName"=>$username,
							"BrowserName"=>$useragent,
							"OSName"=>$os,
							"Date"=>$this->dateY,
							"Time"=>$this->time
							);
							# Save login details
							$this->db->insert("tbl_educatorlogindetails",$logindetails_data);
							
							# Update Last Login
							$result=$this->db->where(['id'=>$data_fetch1[0]["id"]])->update('tbl_tutor',['LastLoginDate'=>$this->date,'LastLoginTime'=>$this->time]);
							
							$this->session->set_userdata("EducatorEmailSession",$email);
							$this->session->set_userdata("EducatorIDSession",$data_fetch1[0]["id"]);
							redirect(base_url("Educator/Dashboard"));
						}
						else
						{
							$this->session->set_flashdata("status","blocked");
							$this->load->view("Website/EducatorLogin.php");
						}
						
					}
					else
					{
						$this->session->set_flashdata("status","invalidemailorpassword");
						$this->load->view("Website/EducatorLogin.php");
					}
					
				}
				
			}
			else
			{
				$this->load->view("Website/EducatorLogin.php");
			}
			
		}
		
		public function GetLinkOnMobile()
		{
			$mobile=$this->input->post("mobile");
			if(strlen($mobile)==10)
			{
				$fp = fopen('./uploads/mobilenumbers_getapplink.txt', 'a'); #opens file in append mode  
				fwrite($fp, $mobile."\n"); 
				fclose($fp);
				$msg="Want to learn Coding from Experts, Download CodersAdda App now from Google Play Store, and start your coding journey from beginner to expert from today. Also get certified. Click on the link below to get the latest app from google play store. ".$this->codersadda->appPlayStoreLink."  Any Query, visit: https://www.codersadda.com/ Call: 8081347355, 8081329320, 9198483820";
				
				
				$this->codersadda->SendSMS($mobile,$msg,$this->codersadda->TempleteIDForSMS);
				
				$this->session->set_flashdata("status","mobilelinksuccess");
				redirect(base_url("Home/index"));
			}
			else
			{
				$this->session->set_flashdata("status","mobilevalidationfailed");
				redirect(base_url("Home/index"));
			}
		}
		
		public function Aboutcodersadda()
		{
			$this->load->view("Website/aboutcodersadda");
			
		}
		
		public function team()
		{
			$query=$this->db->where(['status'=>'true'])->order_by('position','ASC')->get('tbl_team');
			$data["teamlist"]=$query->result(); 
			
			$this->load->view("Website/team",$data);  
			
		}
		
		public function tutors()
		{
			$query=$this->db->where(['status'=>'true'])->order_by('position','ASC')->get('tbl_tutor');
			$data["tutorlist"]=$query->result(); 
			
			$this->load->view("Website/tutors",$data);  
			
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
			$rating=ceil($rating);
			return ['rating'=>$rating,'ratingcount'=>$ratingcount];
		}
		
		# Enrolled Items 
		
		public function EnrolledItems($itemtype,$userid)
		{
			$enrolledResult=$this->db->where(['itemtype'=>$itemtype,'userid'=>$userid])->get("tbl_enroll");
			$enrolledValues=$enrolledResult->result();
			$EnrolledItems=[0];
			foreach($enrolledValues as $enroll){
				$EnrolledItems[]=$enroll->itemid;
			}
			
			return $EnrolledItems;
		}
		public function courses()
		{
			$EnrolledItems=$this->EnrolledItems('Course',$this->userid);
			$result=$this->db->where(['apprstatus'=>'true'])->where_not_in('id',$EnrolledItems)->order_by("trending", "ASC")->get('tbl_course');
			
			$i=0;
			$return=[];
			foreach($result->result() as $item)
			{
				$AverageReview=$this->AverageReview('Course',$item->id);
				$return[$i]=$item;	
				$return[$i]->author=$this->db->where('id',$return[$i]->author)->get('tbl_tutor')->row();
				$return[$i]->rating=$AverageReview['rating'];		
				$return[$i]->totalrating=$AverageReview['ratingcount'];		
				$i++;
			}
			$data["courselist"]=$return; 
			
			$this->load->view("Website/courses",$data);       
		}
		
		public function blogs()
		{
			$query=$this->db->where(['status'=>'true'])->order_by('id','DESC')->get('tbl_blog');
			
			$i=0;
			$return=[];
			foreach($query->result() as $item){
				$return[$i]=$item;
				$return[$i]->author=$this->db->where(['id'=>$item->author])->get('tbl_tutor')->row();
				$return[$i]->category=$this->db->where(['id'=>$item->category])->get('tbl_category')->row();
				$i++;
			}
			$data["bloglist"]=$return;   
			
			$this->load->view("Website/blogs",$data);          
		}
		
		public function BlogDescription()
		{
			
			if($this->uri->segment(3)==FALSE){
			}
			else{
				$id=$this->uri->segment(3);
				
				$query=$this->db->where(['status'=>'true','id'=>$id])->get('tbl_blog');
				if($query->num_rows()){
					
					$item=$query->row();
					$item->author=$this->db->where(['id'=>$item->author])->get('tbl_tutor')->row();
					$item->category=$this->db->where(['id'=>$item->category])->get('tbl_category')->row();
					
					$data["bloglist"]=$item;  
					$this->load->view("Website/BlogDescription",$data);  
					
				}
				
			}       
		}
		
		
		public function GoogleProfile()
		{
			print_r($this->session->userdata("GuserProfile"));
		}
		
		public function FacebookProfile()
		{
			print_r($this->session->userdata("FuserProfile"));
			//echo "<a href='".$this->facebooklogin->logout_url() ."'>Logout</a>";
		}
		
		public function flogout()
		{
			//$this->facebooklogin->destroy_session();
			redirect(base_url('Home/login'));
		}
		
		
		public function ForgotPassword()
		{
			$this->load->view("Website/forgotpassword");       
		}
		
		public function ForgotPasswordVerify()
		{
			$option=$this->input->post("option");
			if($option=="Mobile")
			{
				$mobile=$this->input->post("mobile");
				if(strlen($mobile)==10)
				{
					$query1=$this->db->where(['number'=>$mobile])->get('tbl_registration');
					if($query1->num_rows()>0)
					{
						$data=$query1->result();
						$token="CA_".date("dmY")."_".date("His")."_".$data[0]->id;
						$status="true";
						$otp=rand(100000,999999);
						
						$query=$this->db->where(['id'=>$data[0]->id])->update('tbl_registration',['fp_token'=>$token,'fp_token_status'=>'status','fp_otp'=>$otp,'fp_type'=>'mobile']);
						
						if($query)
						{
							$msg="$otp is Your OTP to recover your password on CodersAdda. TeamDigiCoders";
							$this->codersadda->SendSMS($mobile,$msg,$this->codersadda->TempleteIDForOTP);
							
							$this->session->set_flashdata("status","success");
							$this->session->set_userdata("type","mobile");
							$this->session->set_userdata("token",$token);
							redirect(base_url("Home/ForgotPasswordVerifyOTP"));
						}
						else
						{ 
							$this->session->set_flashdata("status","error");
							redirect(base_url("Home/ForgotPassword"));
						}
					}
					else
					{
						$this->session->set_flashdata("status","incorrectmobile");
						redirect(base_url("Home/ForgotPassword"));
					}
				}
				else
				{
					$this->session->set_flashdata("status","invalidmobile");
					redirect(base_url("Home/ForgotPassword"));
				}
				
			}
			else if($option=="Email")
			{
				# Send Reset Password Link to Email
				
				$email=$this->input->post("email");
				$query1=$this->db->where(['email'=>$email])->get('tbl_registration');
				if($query1->num_rows()>0)
				{
					$data=$query1->result();
					$token="CA_".date("dmY")."_".date("His")."_".$data[0]->id;
					$status="true";
					$otp=rand(100000,999999);
					
					$query=$this->db->where(['id'=>$data[0]->id])->update('tbl_registration',['fp_token'=>$token,'fp_token_status'=>'status','fp_otp'=>$otp,'fp_type'=>'email']);
					if($query)
					{
						$this->load->library('email');
						
						$config = array();
						// $config['protocol'] = 'smtp';
						// $config['smtp_host'] = 'smtpout.secureserver.net';
						// $config['smtp_user'] = 'info@codersadda.com';
						// $config['smtp_pass'] = 'digi#coders#123';
						// $config['smtp_port'] = 465;
						$config['mailtype'] = "html";
						$this->email->initialize($config);
						$this->email->set_newline("\r\n");
						
						$from_email="info@codersadda.com";
						$to_email=$email;
						
						$this->email->from($from_email, 'CodersAdda');
						$this->email->to($to_email);
						$this->email->subject('Password Reset Link from CodersAdda');
						
						$link=base_url()."Home/ResetPassword/$token";
						$msgbody="Hello ".$data[0]->name.", Reset Your CodersAdda Password using following link <a href='".$link."' target='_blank'>Click here to Reset</a> ";
						
						$this->email->message($msgbody);
						
						//Send mail
						if($this->email->send())
						
						
						$this->session->set_flashdata("status","success");
						$this->session->set_userdata("type","email");
						$this->session->set_userdata("token",$token);
						redirect(base_url("Home/ForgotPassword"));
					}
					else
					{ 
						$this->session->set_flashdata("status","error");
						redirect(base_url("Home/ForgotPassword"));
					}
				}
				else
				{
					$this->session->set_flashdata("status","incorrectemail");
					redirect(base_url("Home/ForgotPassword"));
				}
				
				
			}
			else
			{
				$this->session->set_flashdata("status","optionrequired");
				redirect(base_url("Home/ForgotPassword"));
			}
		}
		
		public function ForgotPasswordVerifyOTP()
		{
			if($this->session->userdata("type")=="mobile" && $this->session->userdata("token")!="")
			{
				$token=$this->session->userdata("token");
				$query1=$this->db->where(['fp_token'=>$token])->get('tbl_registration');
				$data["userdata"]=$query1->result();
				$this->load->view("Website/ForgotPasswordVerifyOTP",$data);
			}
			else
			{
				redirect(base_url("Home/ForgotPassword"));
			}
		}
		public function ForgotPasswordOTPResend()
		{
			if($this->session->userdata("type")=="mobile" && $this->session->userdata("token")!="")
			{
				$token=$this->session->userdata("token");
				$query1=$this->db->where(['fp_token'=>$token])->get('tbl_registration');
				
				$data1=$query1->result();
				$data["userdata"]=$data1;
				
				$otp=$data1[0]->fp_otp;
				$mobile=$data1[0]->number;
				
				$msg="$otp is Your OTP to recover your password on CodersAdda. TeamDigiCoders";
				$this->codersadda->SendSMS($mobile,$msg,$this->codersadda->TempleteIDForOTP);
				
				redirect(base_url()."Home/ForgotPasswordVerifyOTP");
			}
			else
			{
				redirect(base_url("Home/ForgotPassword"));
			}
		}
		
		public function ForgotPasswordVerifyOTPCheck()
		{
			$otp=$this->input->post("otp");
			if(strlen($otp)==6)
			{
				if($this->session->userdata("type")=="mobile" && $this->session->userdata("token")!="")
				{
					$token=$this->session->userdata("token");
					$query1=$this->db->where(['fp_token'=>$token])->get('tbl_registration');
					$data1=$query1->result(); 
					if($data1[0]->fp_otp==$otp)
					{
						$this->session->set_userdata("otpstatus","verified");
						redirect(base_url("Home/ResetPassword/$token"));
					}
					else
					{
						$this->session->set_flashdata("status","incorrectotp");
						redirect(base_url("Home/ForgotPasswordVerifyOTP"));
					}
				}
				else
				{
					redirect(base_url("Home/ForgotPassword"));
				}
			}
			else
			{
				$this->session->set_flashdata("status","invalidotp");
				redirect(base_url("Home/ForgotPasswordVerifyOTP"));
			}
			
		}
		
		public function ResetPassword()
		{
			$token=$this->uri->segment(3);
			if($token!="" || $token!=null)
			{
				$query1=$this->db->where(['fp_token'=>$token])->get('tbl_registration');
				if($query1->num_rows()>0)
				{
					$data1=$query1->result();
					if($data1[0]->fp_type=="mobile")
					{
						if($this->session->userdata("otpstatus")=="verified")
						{
							$data["userdata"]=$data1;
							$this->load->view("Website/ResetPassword",$data);
						}
						else
						{
							$this->session->set_flashdata("status","otpnotverify");
							redirect(base_url("Home/ForgotPassword"));
						}
					}
					else if($data1[0]->fp_type=="email")
					{
						$this->session->set_userdata("type","email");
						$data["userdata"]=$data1;
						$this->load->view("Website/ResetPassword",$data);
					}
				}
				else
				{
					$this->session->set_flashdata("status","invalidtoken");
					redirect(base_url("Home/ForgotPassword"));
				}
			}
			else
			{
				$this->session->set_flashdata("status","invalidtoken");
				redirect(base_url("Home/ForgotPassword"));
			}
		}
		
		public function ResetPasswordVerify()
		{
			$password=$this->input->post("password");
			$cnfpassword=$this->input->post("cnfpassword");
			$type=$this->input->post("type");
			$token=$this->input->post("token");
			
			if($password==$cnfpassword)
			{
				
				$query1=$this->db->where(['fp_token'=>$token])->get('tbl_registration');
				if($query1->num_rows()>0)
				{
					$data1=$query1->result();
					if($data1[0]->fp_type=="mobile")
					{
						if($this->session->userdata("otpstatus")=="verified")
						{
							# If Reset Password Using Mobile
							$query2=$this->db->where(['id'=>$data[0]->id])->update('tbl_registration',['password'=>$password,'fp_token'=>'','fp_token_status'=>'','fp_otp'=>'']);
							if($query2)
							{
								$this->session->unset_userdata("type");
								$this->session->unset_userdata("token");
								$this->session->unset_userdata("otpstatus");
								
								$this->session->set_flashdata("status","passwordreset");
								redirect(base_url("Home/Login"));
							}
							else
							{
								$this->session->set_flashdata("status","error");
								redirect(base_url("Home/ResetPassword/$token"));
							}
							
						}
						else
						{
							$this->session->set_flashdata("status","otpnotverify");
							redirect(base_url("Home/ForgotPassword"));
						}
					}
					else if($data1[0]->fp_type=="email")
					{
						# If Reset Password Using Email				
						
						$query2=$this->db->where(['id'=>$data[0]->id])->update('tbl_registration',['password'=>$password,'fp_token'=>'','fp_token_status'=>'','fp_otp'=>'']);
						if($query2)
						{
							$this->session->unset_userdata("type");
							$this->session->unset_userdata("token");
							$this->session->unset_userdata("otpstatus");
							
							
							$this->session->set_flashdata("status","passwordreset");
							redirect(base_url("Home/Login"));
						}
						else
						{
							$this->session->set_flashdata("status","error");
							redirect(base_url("Home/ResetPassword/$token"));
						}
						
					}
				}
				else
				{
					$this->session->set_flashdata("status","invalidtoken");
					redirect(base_url("Home/ForgotPassword"));
				}
			}
			else
			{
				$this->session->set_flashdata("status","passwordnotmatched");
				redirect(base_url("Home/ResetPassword/$token"));
			}
			
		}
		
		public function faq()
		{	
			$query=$this->db->where(['status'=>'true'])->order_by('id','ASC')->get('tbl_faq');
			$data["list"]=$query->result(); 
			
			$this->load->view("Website/faq",$data);      
		}
		
		public function contact()
		{
			$this->load->view("Website/contact");       
		}
		
		public function PrivacyPolicies()
		{
			$this->load->view("Website/PrivacyPolicies");       
		}
		
		public function TermsandConditions()
		{
			$this->load->view("Website/TermsConditions");       
		}
		
		public function refundandcancelation()
		{
			$this->load->view("Website/refundandcancelation");       
		}
		
		# Student Registration
		public function SaveRegistration()
		{
			$email=$this->input->post("email");
			$data=array(
            "name"=>$this->input->post("name"),
            "college"=>$this->input->post("collegename"),
            "email"=>$this->input->post("email"),
            "password"=>$this->input->post("password"),
            "course"=>$this->input->post("course"),
            "number"=>$this->input->post("mobile"),
            "status"=>"true",
            "date"=>date("d-m-Y h:i:sa")
			);
			
			$mobile=$this->input->post("mobile");
			$email=$this->input->post("email");
			
			$query1=$this->db->where(['email'=>$email])->or_where(['mobile'=>$mobile])->get('tbl_registration');
			$data1=$query1->result_array();
			
			if(count($data1)>0)
			{
				$this->session->set_flashdata("status","exists");
				redirect(base_url("Home/registration"));
			}
			else
			{
				if($this->db->insert("tbl_registration",$data))
				{
					// $this->session->set_flashdata("status","success");
					// redirect(base_url("Home/registration"));
					
					$this->session->set_flashdata("status","success");
					$this->session->set_userdata("studentemail",$email);
					redirect(base_url("Student/Studentdashboard"));
					
				}
				else
				{
					$this->session->set_flashdata("status","error");
					redirect(base_url("Home/registration"));
				}
			}
		}
		
		# Contact Query Form Save
		
		public function SaveContact()
		{
			$data=array(
			"name"=>$this->input->post("name"),
			"email"=>$this->input->post("email"),
			"subject"=>$this->input->post("sub"),
			"number"=>$this->input->post("number"),
			"msg"=>$this->input->post("msg")   
			);
			
			if($this->db->insert("tbl_contact",$data))
			{
				$this->session->set_flashdata("status","success");
				redirect(base_url("Home/contact"));
			}
			else
			{
				$this->session->set_flashdata("status","error");
				redirect(base_url("Home/contact"));
			}
		}
		
		# Student login
		
		public function registration()
		{
			redirect(base_url("Home/login"));     
		}
		
		
		public function login()
		{	
			if(empty($this->session->get_userdata()['StudentData']))
			{
				if($this->uri->segment(3)==TRUE){
				}
				else{
					
					$this->load->view("Website/login"); 
				}
				
			}
			else{
				redirect(base_url("Student/Dashboard"));
			}
		}
		
		
		public function Studentlogin()
		{
			if(!empty($_POST) and $this->form_validation->run('login')) 
			{
				$table='tbl_registration';
				
				$mobile=$this->input->post('mobile');
				$otp='1234';//rand(1000,9999);
				
				$this->session->set_flashdata('mobile',$mobile);
				
				$whereData=['number'=>$mobile];
				$result=$this->db->where($whereData)->get($table);
				if($result->num_rows())
				{
					$values=$result->row();
					if($values->status=='true')
					{
						$upresult=$this->db->where($whereData)->update($table,['otp'=>$otp]);
						$this->session->set_userdata("StudentOTPVerification",['mobile'=>$mobile]);
						
						$msg="OTP for CodersAdda is ".$otp.", Do not share this with anyone, Team CodersAdda (DigiCoders), https://codersadda.com";
						
						$this->codersadda->SendSMS1($mobile,$msg,$this->codersadda->TempleteIDForOTP);
						
						
						$this->session->set_flashdata('response',['res'=>'success','msg'=>'OTP sent to '.$mobile]);
						redirect(base_url("Home/OTPVerification"));
					}
					else{
						$this->session->set_flashdata('response',['res'=>'error','msg'=>'Your account has been blocked.']);
						redirect(base_url("Home/login"));
					}
					
				}
				else
				{
					$datetime=$this->date.' '.$this->time;
					$insertData=['name'=>'New User','number'=>$mobile,'otp'=>$otp,'status'=>'true','date'=>$datetime,'dateY'=>$this->dateY];
					if($this->db->insert($table,$insertData))
					{
						$this->session->set_userdata("StudentOTPVerification",['mobile'=>$mobile]);
						
						$msg="OTP for CodersAdda is ".$otp.", Do not share this with anyone, Team CodersAdda (DigiCoders), https://codersadda.com";
						
						$this->codersadda->SendSMS1($mobile,$msg,$this->codersadda->TempleteIDForOTP);
						
						
						$this->session->set_flashdata('response',['res'=>'success','msg'=>'OTP sent to '.$mobile]);
						redirect(base_url("Home/OTPVerification"));
					}
					else{
						$this->session->set_flashdata('response',['res'=>'error','msg'=>'Registration Failed !']);
						redirect(base_url("Home/login"));
					}
				}
			}
			else
			{
				$this->session->set_flashdata('response',['res'=>'error','msg'=>validation_errors()]);
				redirect(base_url("Home/login")); 
				
			}
		}
		
		#Resend OTP
		
		public function ResendOTP()
		{
			if(empty($this->session->get_userdata()['StudentOTPVerification']['mobile'])){
				
			}
			else{
				$this->session->set_flashdata("mobile",$this->session->get_userdata()['StudentOTPVerification']['mobile']);
			}
			redirect(base_url("Home/login"));
		}
		
		#OTP Verification
		public function OTPVerification()
		{
			if(!empty($this->session->get_userdata()['StudentOTPVerification']['mobile'])){
				if(!empty($_POST)) 
				{
					if($this->form_validation->run('otp_verification')) 
					{
						$table='tbl_registration';
						
						$mobile=$this->session->get_userdata()['StudentOTPVerification']['mobile'];
						$otp=$this->input->post('otp');
						
						$whereData=['number'=>$mobile];
						$result=$this->db->where($whereData)->get($table);
						if($result->num_rows())
						{
							$values=$result->row();
							if($values->otp==$otp)
							{
								$upresult=$this->db->where($whereData)->update($table,['otp_status'=>'true','CurrentStatus'=>'true']);
								$values=$this->db->where($whereData)->get($table)->row();
								
								$this->session->set_userdata('StudentData',$values);
								$this->session->unset_userdata('StudentOTPVerification');
								
								$this->session->set_flashdata('response',['res'=>'success','msg'=>'You have been successfully logged in.']);
								redirect(base_url("Student/Dashboard"));
							}
							else
							{
								$this->session->set_flashdata('response',['res'=>'error','msg'=>'Enter valid OTP.']);
								redirect(base_url("Home/OTPVerification"));
							}
						}
						else
						{
							$this->session->set_flashdata('response',['res'=>'error','msg'=>'Please register this mobile no.']);
							$this->session->set_flashdata("mobile",$mobile);
							redirect(base_url("Home/login"));
						}
					}
					else{
						$this->session->set_flashdata('response',['res'=>'error','msg'=>validation_errors()]);
						$this->load->view("Website/OTPVerification"); 
					}
				}
				else
				{
					$this->load->view("Website/OTPVerification"); 
					
				}
			}
			else{
				
				redirect(base_url("Home/login")); 
			}
		}
		
		
		public function Certificate()
		{	
			$table='tbl_certificate';
            if ($this->uri->segment(3) == TRUE) 
            {
                $refno = $this->uri->segment(3);
                $certificateResult = $this->db->where(['refno'=>$refno,'status'=>'true'])->get('tbl_certificate');
				if($certificateResult->num_rows())
				{
					$data["certificateList"] = $certificateResult->result();
					
					if($data["certificateList"][0]->itemtype=='Course')
					{
						$cquery = $this->db->where('id',$data["certificateList"][0]->itemid)->get('tbl_course');
						$data["itemList"] = $cquery->result();
						$data['technology']=$data["itemList"][0]->name;
					}
					if($data["certificateList"][0]->itemtype=='LiveSession'){
						$cquery = $this->db->where('id',$data["certificateList"][0]->itemid)->get('tbl_live_video');
						$data["itemList"] = $cquery->result();
						$data['technology']=$data["itemList"][0]->title;
					}
					$data["author"]=$this->db->where('id',$data["itemList"][0]->author)->get('tbl_tutor')->row();
					$data['name']=strtoupper($data["certificateList"][0]->name);
					$data['grade']=$data["certificateList"][0]->grade;
					$data['duration']=$data["certificateList"][0]->duration;
					$data['from']=date('d-M-Y',strtotime($data["certificateList"][0]->from_date));
					$data['to']=date('d-M-Y',strtotime($data["certificateList"][0]->to_date));
					$data['refno']=$data["certificateList"][0]->refno;
					$data['issuedon']=date('d-M-Y',strtotime($data["certificateList"][0]->issuedon));
					
					$this->load->view("Certificate/".$data["itemList"][0]->certificate, $data);
				}
				else{
					redirect(base_url('Home/'));
				}
			}
			else{
				redirect(base_url('Home/'));
			}
		}
		
		
		
		public function VerifyCertificate()
		{
			if(!empty($_POST)) 
			{
				if(!empty($this->input->post('refno'))) 
				{
					$table='tbl_certificate';
					$refno=$this->input->post('refno');
					$certificateResult = $this->db->where(['refno'=>$refno,'status'=>'true'])->get($table);
					if($certificateResult->num_rows())
					{
						redirect(base_url('Home/Certificate/'.$refno));
					}
					else{
						$this->session->set_flashdata('response',['res'=>'error','msg'=>'Invalid Reference No.']);
						$this->load->view("Website/VerifyCertificate"); 
					}
				}
				else{
					$this->session->set_flashdata('response',['res'=>'error','msg'=>'Enter Reference No.']);
					$this->load->view("Website/VerifyCertificate"); 
				}
			}
			else
			{
				$this->load->view("Website/VerifyCertificate"); 
				
			}
		}
		
		public function Assignment()
		{
			if($this->uri->segment(3)){
				$action=$this->uri->segment(3);
				
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
							$this->session->set_flashdata(array('res'=>'error','msg'=>'This assignment is already uploaded.'));
						}
						else
						{
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
										
										$this->session->set_flashdata(array('res'=>'success','msg'=>'Assignment Uploaded'));
									}
									else{
										$this->session->set_flashdata(array('res'=>'error','msg'=>'Upload Failed !'));
									}
								}
								else{
									$this->session->set_flashdata(array('res'=>'error','msg'=>'Choose document in pdf format.'));
								}	
							}
							else{
								$this->session->set_flashdata(array('res'=>'error','msg'=>'Choose video assignment answer.'));
							}
						}
					}
					else{
						$this->session->set_flashdata(array('res'=>'error','msg'=>'Validation Failed'));
					}
				}
			}
			redirect(base_url('Home/UploadAssignment/'.$courseid.'/'.$videoid.'/'.$assignmentid.'/'.$userid));
		}
		
		
		public function UploadAssignment()
		{
			if(($this->uri->segment(3) == TRUE) and $this->uri->segment(4) == TRUE and $this->uri->segment(5) == TRUE and $this->uri->segment(6) == TRUE) 
			{
				$courseid=$this->uri->segment(3);
				$videoid=$this->uri->segment(4);
				$assignmentid=$this->uri->segment(5);
				$userid=$this->uri->segment(6);
				
				$result=$this->db->where(['id'=>$courseid])->get('tbl_course');
				if($result->num_rows())
				{
					$enrollResult=$this->db->where(['itemid'=>$courseid,'itemtype'=>'Course','userid'=>$userid])->get('tbl_enroll');
					if($enrollResult->num_rows())
					{
						$result=$this->db->where(['course'=>$courseid,'video'=>$videoid])->get('tbl_lecture');
						if($result->num_rows())
						{
							$return=[];
							$i=0;
							foreach($result->result() as $item)
							{
								$return[$i]=$item;
								$return[$i]->course = $this->db->where(['id'=>$courseid])->get('tbl_course')->row();
								$return[$i]->video = $this->db->where(['id'=>$videoid])->get('tbl_video')->row();
								$return[$i]->video->subjectdetails = $this->db->where(['id'=>$return[$i]->video->subject])->get('tbl_subject')->row();
								$return[$i]->assignment = $this->db->where(['video'=>$videoid,'id'=>$assignmentid])->get('tbl_video_assignment')->result();
								
								$assignments=[];
								$j=0;
								foreach($return[$i]->assignment as $assignment){
									$result1 = $this->db->where(['course'=>$courseid,'video'=>$videoid,'userid'=>$userid,'assignment'=>$assignment->id])->get('tbl_video_assignment_upload');
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
									$assignments[$j]->answer=$answer;
									
									$j++;
								}
								
								$return[$i]->assignment=$assignments;
								$i++;
							}
							
							$data['list']=$return;
							$data['userid']=$userid;
							
							
							$this->load->view("StudentPanel/UploadAssignment.php",$data);
						}
						else{
							redirect(base_url('Home/login'));
						}
						
					}
					else{
						redirect(base_url('Home/login'));
					}
				}
				else{
					redirect(base_url('Home/login'));
				}	
			}
			else{
				redirect(base_url('Home/login'));
			}
		}
		
		public function Invoice()
		{
			$table='tbl_enroll';
			
			if($this->uri->segment(3)==TRUE)
			{
				$enrollid=$this->uri->segment(3);
				$enrollResult=$this->db->where(['id'=>$enrollid])->get($table);
				
				if($enrollResult->num_rows())
				{
					$results=$enrollResult->row();
					$itemtype=$results->itemtype;
					$itemid=$results->itemid;
					if($itemtype=='Course'){
						$item_table='tbl_course';
						$data['item_image']=base_url('uploads/course/');
					}
					else{
						$item_table='tbl_ebook';
						$data['item_image']=base_url('uploads/ebook/');
					}
					
					$result=$this->db->where(['id'=>$itemid])->get($item_table);
					
					if($result->num_rows()){
						
						$itemresults=$result->row();
						$data['enroll']=$results;
						$data['item']=$itemresults;
						
						$data['user']=$this->db->where(['id'=>$results->userid])->get('tbl_registration')->row();
						
						$data['itemtype']=$itemtype;
						$data['itemid']=$itemid;
						$data['item_image']=$data['item_image'].$itemresults->logo;
						
						$this->load->view('AdminPanel/Invoice',$data);
					}
					else{
						redirect(base_url('Home/'));	
					}
				}
				else{
					redirect(base_url('Home/'));	
				}
				
			}
			else{
				redirect(base_url('Home/'));
			}
		}
		
		
		public function EducatorRegistration()
		{
			$otp=rand(1000,9999);
			if(isset($_POST["EducatorRegistration"]))
			{
				if($this->form_validation->run('EducatorRegistration') == FALSE)
				{
					$this->load->view("Website/EducatorRegistration.php");
				}
				else
				{
					$postData=$this->input->post();
					$postData = $this->security->xss_clean($postData);
					
					$mobile=$postData["mobile"];
					$email=$postData["email"];
					
					$saveData=[
					"name" => $this->input->post("name"),
					"mobile" => $this->input->post("mobile"),
					"email" => $this->input->post("email"),
					"password" => $this->input->post("password"),
					"about" => $this->input->post("about"),
					"photo" => 'logo.png',
					"otp" => $otp,
					"otp_status" => "false",
					"status" => "false",
					"date" => $this->date,
					"time" => $this->time
					];
					
					$result=$this->db->where("(`email`='$email' OR `mobile`='$mobile')")->get('tbl_tutor');
					if($result->num_rows())
					{			
						$userData=$result->row();
						if($userData->otp_status=='false')
						{
							$this->db->where(['id'=>$userData->id])->update('tbl_tutor',$saveData);
							$this->session->set_userdata("EducatorRegistrationOTPVerification",$userData->id);
							
							$msg='OTP Verification Code is '.$otp.'';
							$this->codersadda->SendSMS($mobile,$msg);
							
							$this->session->set_flashdata('response',['res'=>'success','msg'=>'OTP sent on your mobile no.']);
							$this->load->view("Website/EducatorRegistrationOTPVerification.php");
						}
						else
						{
							$this->session->set_flashdata('response',['res'=>'error','msg'=>'Mobile No or Email already registered.']);
							$this->load->view("Website/EducatorRegistration.php");
						}
					}
					else
					{
						if ($this->db->insert('tbl_tutor', $saveData)) 
						{
							
							$insert_id = $this->db->insert_id();
							$username=strtolower($this->input->post("name"));
							$username=preg_replace('/\s+/', ' ', $username).$insert_id;
							
							$this->db->where('id',$insert_id)->update('tbl_tutor', ['username'=>$username]);
							
							$this->session->set_userdata("EducatorRegistrationOTPVerification",$insert_id);
							
							$this->session->set_flashdata('response',['res'=>'success','msg'=>'OTP sent on your mobile no.']);
							$this->load->view("Website/EducatorRegistrationOTPVerification.php");
						}
						else 
						{
							$this->session->set_flashdata('response',['res'=>'error','msg'=>'Registration Failed !']);
							$this->load->view("Website/EducatorRegistration.php");
						}
					}
				}
			}
			else if(isset($_POST["OTPVerification"]))
			{
				if($this->form_validation->run('OTPVerification') == FALSE)
				{
					$this->load->view("Website/EducatorRegistrationOTPVerification.php");
				}
				else if(empty($this->session->get_userdata()['EducatorRegistrationOTPVerification']))
				{
					$this->load->view("Website/EducatorRegistration.php");
				}
				else
				{
					$postData=$this->input->post();
					$postData = $this->security->xss_clean($postData);
					$otp=$postData["otp"];
					$id=$this->session->get_userdata()['EducatorRegistrationOTPVerification'];
					$result=$this->db->where('id',$id)->get('tbl_tutor');
					if($result->num_rows())
					{			
						$userData=$result->row();
						if($userData->otp==$otp)
						{
							$this->db->where('id',$id)->update('tbl_tutor', ['otp_status'=>'true']);
							$this->session->unset_userdata("EducatorRegistrationOTPVerification");
							$this->session->set_flashdata('response',['res'=>'success','msg'=>'OTP verified successfully.']);
							$this->load->view("Website/EducatorRegistrationInformation.php");
						}
						else
						{
							$this->session->set_flashdata('response',['res'=>'error','msg'=>'OTP is invalid.']);
							$this->load->view("Website/EducatorRegistrationOTPVerification.php");
						}
					}
					else
					{
						$this->session->set_flashdata('response',['res'=>'error','msg'=>'Educator is not registered.']);
						$this->load->view("Website/EducatorRegistration.php");
					}
				}
			}
			else
			{
				$this->load->view("Website/EducatorRegistration.php");
			}
		}
		
		public function databaseexport()
		{
			// Load the DB utility class
			$this->load->dbutil();
			
			// Backup your entire database and assign it to a variable
			$backup = $this->dbutil->backup();
			
			// Load the file helper and write the file to your server
			$this->load->helper('file');
			write_file('./uploads/mybackup.gz', $backup);
			
			// Load the download helper and send the file to your desktop
			$this->load->helper('download');
			force_download('mybackup.gz', $backup);
			
			
        }
		
		
	}
	
?>