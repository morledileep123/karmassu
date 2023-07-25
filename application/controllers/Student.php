<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
    class Student extends CI_Controller
    {
        private $date,$time;
		public function __construct()
		{
			parent::__construct();
			
			date_default_timezone_set("Asia/Kolkata");
			$this->date=date("d-m-Y");
			$this->dateY=date("Y-m-d");
			$this->time=date("h:i:sa");
			
			$this->load->library('CodersAdda');
			$this->load->library('Razorpay');
			$this->load->library('form_validation');
			
			if(empty($this->session->get_userdata()['StudentData']))
            {
				redirect(base_url("Home/"));
			}
			else{
				$this->userid=$this->session->get_userdata()['StudentData']->id;
                $query=$this->db->where(['id'=>$this->userid,'otp_status'=>'true','status'=>'true'])->get('tbl_registration');
                if($query->num_rows()){
                    $this->StudentData=$query->row();
				}
                else{
                    $this->Logout();
					
				}
				
				$this->notificationCount=$this->db->where(['status'=>'true'])->get('tbl_notification')->num_rows();
			}
			
		}
        
        public function index()
        {
            $this->Dashboard();
		}
        
		# Profile Management
        
        public function Profile()
        {
			$table='tbl_registration';
            
			$data["profile"] = $this->StudentData;
			$data["live_session"] =$this->db->where(['mobile'=>$this->StudentData->number])->get('tbl_live_join')->num_rows();
			$data["courses"]=$this->db->where(['userid'=>$this->StudentData->id,'itemtype'=>'Course','paymentstatus'=>'success'])->get('tbl_enroll')->num_rows();
			$data["books"]=$this->db->where(['userid'=>$this->StudentData->id,'itemtype'=>'Ebook','paymentstatus'=>'success'])->get('tbl_enroll')->num_rows();
			$data["certificates"]=$this->db->where(['userid'=>$data["profile"]->id,'itemtype'=>'Course','certificate'=>'true'])->get('tbl_enroll')->num_rows();
			
			
			if ($this->uri->segment(3) == TRUE) 
            {
                $action = $this->uri->segment(3);
                if ($this->uri->segment(4) == TRUE){
                    redirect(base_url('Student/Profile'));
				}
                else 
                {
                    if($action=='Update')
                    {
                        if (isset($_POST["updateaction"])) 
                        {  
                            if($this->form_validation->run('updateProfile') == FALSE)
                            {
                                $this->load->view("StudentPanel/Profile", $data);
							} 
                            else
                            {
                                $userid=$this->input->post('userid');
								$wheredata=['id'=>$userid];
								$result=$this->db->where($wheredata)->get($table);
								if($result->num_rows())
								{
									$updateData=[
									'name'=>$this->input->post('name'),
									'email'=>$this->input->post('email'),
									'course'=>$this->input->post('education'),
									'address'=>$this->input->post('address'),
									];
									
									
									$upresult=$this->db->where($wheredata)->update($table,$updateData);
									if($upresult){
										if(!empty($_FILES["profile_photo"]["name"])) {
											$ext = pathinfo($_FILES["profile_photo"]["name"], PATHINFO_EXTENSION);
											$filename = time() . "_profile_photo." . $ext;
											
											$upresult=$this->db->where($wheredata)->update($table,['profile_photo'=>$filename]);
											
											$config['upload_path']   = './uploads/profile_photo/';
											$config['allowed_types'] = 'gif|jpg|png|jpeg';
											$config['max_size']      = 5000; 
											$config['file_name']     = $filename;
											$this->load->library('upload', $config);
											$this->upload->do_upload('profile_photo');
											
										}
										$this->session->set_flashdata(array('res'=>'success','msg'=>'Profile Updated'));
										redirect(base_url('Student/Profile'));	
									}
									else{
										$this->session->set_flashdata(array('res'=>'error','msg'=>'Updation Failed !'));
										redirect(base_url('Student/Profile'));	
									}
								}
								else
								{
									$this->session->set_flashdata(array('res'=>'error','msg'=>'Invalid User ID'));
									redirect(base_url('Student/Profile'));
								}
							}
						}
                        else{
                            redirect(base_url('Student/Profile'));
						}
					}
				}
			}
            else 
            {
                $this->load->view("StudentPanel/Profile", $data);
			}
		}
		
        # Logout
        
        public function Logout()
        {
			$this->db->where(['id'=>$this->userid])->update('tbl_registration',['LastLogoutDate'=>$this->date,'LastLogoutTime'=>$this->time,'CurrentStatus'=>'false']);
			
            $this->session->unset_userdata('StudentData');
			
            redirect(base_url("Home/"));
		}
		
		# Dashboard
        public function Dashboard()
        {
			
			$result=$this->db->where(['type'=>'App','status'=>'true'])->order_by("id", "DESC")->get('tbl_slider');
			$data['sliderList']=$result->result();
			
			//Categories
			$result=$this->db->where(['status'=>'true'])->order_by("title", "ASC")->get('tbl_category');
			$data['categoryList']=$result->result();
			
			$EnrolledItems=$this->EnrolledItems('Course',$this->userid);
			
			// Trending Courses
			$result=$this->db->where(['apprstatus'=>'true'])->where_not_in('id',$EnrolledItems)->where_not_in('trending',['Trending','trending'])->order_by("trending", "ASC")->limit(4)->get('tbl_course');
			$i=0;
			$return=[];
			foreach($result->result() as $item)
			{
				$AverageReview=$this->AverageReview('Course',$item->id);
				$return[$i]=$item;	
				$return[$i]->author=$this->db->where('id',$item->author)->get('tbl_tutor')->row();	
				$return[$i]->discountpercent=$this->codersadda->DiscountPercent($item->discountpercent);	
				$return[$i]->rating=$AverageReview['rating'];		
				$return[$i]->totalrating=$AverageReview['ratingcount'];		
				$i++;
			}
			$data['trendingCourseList']=$return;
			
			//Top Courses
			$result=$this->db->where(['apprstatus'=>'true'])->where_not_in('id',$EnrolledItems)->order_by("name", "ASC")->limit(4)->get('tbl_course');
			$i=0;
			$return=[];
			foreach($result->result() as $item)
			{
				$AverageReview=$this->AverageReview('Course',$item->id);
				$return[$i]=$item;	
				$return[$i]->author=$this->db->where('id',$item->author)->get('tbl_tutor')->row();	
				$return[$i]->discountpercent=$this->codersadda->DiscountPercent($item->discountpercent);	
				$return[$i]->rating=$AverageReview['rating'];		
				$return[$i]->totalrating=$AverageReview['ratingcount'];		
				$i++;
			}
			$data['topCourseList']=$return;
			
			
			//Latest Courses
			$result=$this->db->where(['apprstatus'=>'true'])->where_not_in('id',$EnrolledItems)->order_by("id", "DESC")->limit(4)->get('tbl_course');
			$i=0;
			$return=[];
			foreach($result->result() as $item)
			{
				$AverageReview=$this->AverageReview('Course',$item->id);
				$return[$i]=$item;		
				$return[$i]->author=$this->db->where('id',$item->author)->get('tbl_tutor')->row();	
				$return[$i]->discountpercent=$this->codersadda->DiscountPercent($item->discountpercent);	
				$return[$i]->rating=$AverageReview['rating'];		
				$return[$i]->totalrating=$AverageReview['ratingcount'];		
				$i++;
			}
			$data['latestCourseList']=$return;
			
			$EnrolledItems=$this->EnrolledItems('Ebook',$this->userid);
			//Latest Ebooks
			$result=$this->db->where(['apprstatus'=>'true'])->where_not_in('id',$EnrolledItems)->order_by("id", "DESC")->limit(4)->get('tbl_ebook');
			$i=0;
			$return=[];
			foreach($result->result() as $item)
			{
				$AverageReview=$this->AverageReview('Ebook',$item->id);
				$return[$i]=$item;		
				$return[$i]->author=$this->db->where('id',$item->author)->get('tbl_tutor')->row();	
				$return[$i]->discountpercent=$this->codersadda->DiscountPercent($item->discountpercent);	
				$return[$i]->rating=$AverageReview['rating'];		
				$return[$i]->totalrating=$AverageReview['ratingcount'];		
				$i++;
			}
			$data['latestEbookList']=$return;
			
			
			//Recommended Videos
			$result = $this->db->where(['status'=>'true','type'=>'RecommendedVideos'])->order_by("id", "DESC")->limit(4)->get('tbl_recommended_videos');
			
			
			$return=[];
			$i=0;
			
			foreach ($result->result() as $item){
				$return[$i]=$item;
				$return[$i]->author=$this->db->where('id',$item->author)->get('tbl_tutor')->row();
				$return[$i]->subject=$this->db->where('id',$item->subject)->get('tbl_subject')->row();
				$return[$i]->video=$this->db->where('id',$item->video)->get('tbl_video')->row();
				$i++;
			}
			$data['recommendedList']=$return;
			
            $this->load->view("StudentPanel/Dashboard.php",$data);
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
		
		// Courses
		
		public function Courses()
        {
            $table='tbl_course';
            
			$whereData=['apprstatus'=>'true'];
            if ($this->uri->segment(3) == TRUE) {
				
                $action = $this->uri->segment(3);
                if($this->uri->segment(4) == TRUE) {
					
                    $id = $this->uri->segment(4);
					if($action=='Category'){
						$whereData['category']=$id;
					}
				}
			}
			
			$EnrolledItems=$this->EnrolledItems('Course',$this->userid);
			
			$result=$this->db->where($whereData)->where_not_in('id',$EnrolledItems)->order_by("id", "DESC")->get($table);
			
			$i=0;
			$return=[];
			foreach($result->result() as $item)
			{
				$AverageReview=$this->AverageReview('Course',$item->id);
				$return[$i]=$item;	
				$return[$i]->author=$this->db->where('id',$item->author)->get('tbl_tutor')->row();	
				$return[$i]->discountpercent=$this->codersadda->DiscountPercent($item->discountpercent);	
				$return[$i]->rating=$AverageReview['rating'];		
				$return[$i]->totalrating=$AverageReview['ratingcount'];		
				$i++;
			}
			$data['courseList']=$return;
			$this->load->view("StudentPanel/Courses.php",$data);
		}
		
		public function CourseDescription()
        {
            $table='tbl_course';
			
            if($this->uri->segment(3) == TRUE) {
				
                $id = $this->uri->segment(3);
                $query = $this->db->where('id', $id)->get($table);
                if ($query->num_rows()) 
                {
                    $data["list"] = $query->result();
					$data["list"][0]->discountpercent=$this->codersadda->DiscountPercent( $data["list"][0]->discountpercent);	
					$AverageReview=$this->AverageReview('Course',$data["list"][0]->id);
					
					$data["rating"] =$AverageReview['rating'];
					$data["ratingcount"] =$AverageReview['ratingcount'];
					
                    $data['author']=$this->db->where('id',$data["list"][0]->author)->get('tbl_tutor')->result();
					
                    $data['category']=$this->db->where('id',$data["list"][0]->category)->get('tbl_category')->result();
					
                    $data['videolist']=$this->db->where('status','true')->get('tbl_video')->result();
					
                    $data['subjectlist']=$this->db->where('status','true')->get('tbl_subject')->result();
					
                    $query=$this->db->where('course',$data["list"][0]->id)->order_by('lecture_no','ASC')->get('tbl_lecture');
                    if($query->num_rows()){
                        $data['lecture']=$query->result();
                        $return=[];
                        foreach ($data['lecture'] as $video){
                            $return[$video->id]=$video;
                            $videoResult=$this->db->where('id',$video->video)->get('tbl_video')->result();
                            $return[$video->id]->video=$videoResult;
                            $return[$video->id]->subject=$this->db->where('id',$videoResult[0]->subject)->get('tbl_subject')->result();
						}
                        $data["lecture"]=$return;
					}
                    else{
                        $data["lecture"]=array();
					}
					
					// Find and Add Reviews 
					$reviewResult=$this->db->where(['itemtype'=>'Course','itemid'=>$data["list"][0]->id])->get("tbl_review");
					
					$reviewData=[];
					foreach($reviewResult->result() as $review)
					{
						$userResult=$this->db->where(['id'=>$review->userid])->get("tbl_registration");
						if($userResult->num_rows()){
							$userValues=$userResult->row();
							$reviewData[]=['name'=>$userValues->name,'mobile'=>$userValues->number,'profile_photo'=>$userValues->profile_photo,'rating'=>$review->rating,'review'=>$review->review,'date'=>$review->date,'time'=>$review->time];		
						}	
					}
					$data["review"]=$reviewData;
					
					$enrollResult=$this->db->where(['itemid'=>$id,'itemtype'=>'Course','userid'=>$this->userid])->get('tbl_enroll');
					
					$data["enrollcount"]=$enrollResult->num_rows();
					if($enrollResult->num_rows())
					{
						$data["enroll"]=$enrollResult->row();
						
						$certificateResult=$this->db->where(['itemtype'=>'Course','itemid'=>$id,'userid'=>$this->userid])->get("tbl_certificate");
						if($certificateResult->num_rows())
						{
							$certificateData=$certificateResult->row();
							$data["enroll"]->certificatedata=$certificateData; 
							$certificatestatus=$certificateData->status;
						}
						else{
							$mark_as_completed=count(explode(',',$data["enroll"]->mark_as_completed))-1;
							if($mark_as_completed<0){ $mark_as_completed=0; }
							$lecture=$this->db->where('course',$data["enroll"]->itemid)->get('tbl_lecture')->num_rows();
							$progress=((100*$mark_as_completed)/$lecture);
							if($progress>=100){
								$certificatestatus='request';
							}
							else{
								$certificatestatus='false';
							}
						}
						
						
						$data["enroll"]->certificatestatus=$certificatestatus; 
					}
					else{
						$data["enroll"]=[];
					}
					
                    $this->load->view("StudentPanel/CourseDescription", $data);
				}
                else
                {
                    redirect(base_url('Student/Courses'));
				}
			}
		    else{
				redirect(base_url('Student/Courses'));
			}
		}
		
		
		// EBooks
		
		public function EBooks()
        {
            $table='tbl_ebook';
            
			$whereData=['apprstatus'=>'true'];
            if ($this->uri->segment(3) == TRUE) {
				
                $action = $this->uri->segment(3);
                if($this->uri->segment(4) == TRUE) {
					
                    $id = $this->uri->segment(4);
					if($action=='Category'){
						$whereData['category']=$id;
					}
				}
			}
			
			$EnrolledItems=$this->EnrolledItems('Ebook',$this->userid);
			
			$result=$this->db->where($whereData)->where_not_in('id',$EnrolledItems)->order_by("id", "DESC")->get($table);
			
			$i=0;
			$return=[];
			foreach($result->result() as $item)
			{
				$AverageReview=$this->AverageReview('Ebook',$item->id);
				$return[$i]=$item;		
				$return[$i]->author=$this->db->where('id',$item->author)->get('tbl_tutor')->row();	
				$return[$i]->discountpercent=$this->codersadda->DiscountPercent($item->discountpercent);	
				$return[$i]->rating=$AverageReview['rating'];		
				$return[$i]->totalrating=$AverageReview['ratingcount'];		
				$i++;
			}
			$data['ebookList']=$return;
			
			$this->load->view("StudentPanel/EBooks.php",$data);
		}
		
		public function EBookDescription()
        {
            $table='tbl_ebook';
			
            if($this->uri->segment(3) == TRUE) {
				
                $id = $this->uri->segment(3);
                $query = $this->db->where('id', $id)->get($table);
                if ($query->num_rows()) 
                {
                    $data["list"] = $query->result();
                    $data["list"][0]->discountpercent=$this->codersadda->DiscountPercent( $data["list"][0]->discountpercent);	
					$AverageReview=$this->AverageReview('Course',$data["list"][0]->id);
					
					$data["rating"] =$AverageReview['rating'];
					$data["ratingcount"] =$AverageReview['ratingcount'];
					
					
                    $data['author']=$this->db->where('id',$data["list"][0]->author)->get('tbl_tutor')->result();
                    $data['category']=$this->db->where('id',$data["list"][0]->category)->get('tbl_category')->result();
					
					// Find and Add Reviews 
					$reviewResult=$this->db->where(['itemtype'=>'Ebook','itemid'=>$data["list"][0]->id])->get("tbl_review");
					
					$reviewData=[];
					foreach($reviewResult->result() as $review)
					{
						$userResult=$this->db->where(['id'=>$review->userid])->get("tbl_registration");
						if($userResult->num_rows()){
							$userValues=$userResult->row();
							$reviewData[]=['name'=>$userValues->name,'mobile'=>$userValues->number,'profile_photo'=>$userValues->profile_photo,'rating'=>$review->rating,'review'=>$review->review,'date'=>$review->date,'time'=>$review->time];		
						}	
					}
					$data["review"]=$reviewData;
					
					$enrollResult=$this->db->where(['itemid'=>$id,'itemtype'=>'Ebook','userid'=>$this->userid])->get('tbl_enroll');
					
					$data["enrollcount"]=$enrollResult->num_rows();
					if($enrollResult->num_rows()){
						$data["enroll"]=$enrollResult->row();
						
					}
					else{
						$data["enroll"]=[];
					}
					
                    $this->load->view("StudentPanel/EBookDescription", $data);
				}
                else
                {
                    redirect(base_url('Student/EBooks'));
				}
			}
		    else{
				redirect(base_url('Student/EBooks'));
			}
		}
		
		public function MyCourses()
        {
            $table='tbl_course';
			$whereData=[
			'userid'=>$this->userid,
			'itemtype'=>'Course',
			'paymentstatus'=>'success',
			];
			$result=$this->db->where($whereData)->order_by("id", "DESC")->get('tbl_enroll');
			
			$return=[];
			$i=0;
			
			foreach ($result->result() as $enroll)
			{
				$return[$i]=$enroll;
				$return[$i]->item=$this->db->where('id',$enroll->itemid)->get($table)->row();
				$return[$i]->item->author=$this->db->where('id',$return[$i]->item->author)->get('tbl_tutor')->row();
				
				$AverageReview=$this->AverageReview('Course',$enroll->itemid);	
				$return[$i]->rating=$AverageReview['rating'];		
				$return[$i]->totalrating=$AverageReview['ratingcount'];	
				
				$mark_as_completed=count(explode(',',$enroll->mark_as_completed))-1;
				if($mark_as_completed<0){ $mark_as_completed=0; }
				$lecture=$this->db->where('course',$enroll->itemid)->get('tbl_lecture')->num_rows();
				$progress=((100*$mark_as_completed)/$lecture).'%';
				$return[$i]->progress=$progress;	
				
				$i++;
			}
			
			$data['courseList']=$return;
			$this->load->view("StudentPanel/MyCourses.php",$data);
		}
		
		public function MyEBooks()
        {
            $table='tbl_ebook';
            
			$whereData=[
			'userid'=>$this->userid,
			'itemtype'=>'Ebook',
			'paymentstatus'=>'success',
			];
			$result=$this->db->where($whereData)->order_by("id", "DESC")->get('tbl_enroll');
			
			$return=[];
			$i=0;
			
			foreach ($result->result() as $enroll)
			{
				$return[$i]=$enroll;
				$return[$i]->item=$this->db->where('id',$enroll->itemid)->get($table)->row();
				$return[$i]->item->author=$this->db->where('id',$return[$i]->item->author)->get('tbl_tutor')->row();
				
				$AverageReview=$this->AverageReview('Ebook',$enroll->itemid);	
				$return[$i]->rating=$AverageReview['rating'];		
				$return[$i]->totalrating=$AverageReview['ratingcount'];		
				$return[$i]->progress=rand(0,100).'%';		
				$i++;
			}
			$data['ebookList']=$return;
			
			$this->load->view("StudentPanel/MyEBooks.php",$data);
		}
		
		
		
		# Notification
		
		public function Notification()
        {
			
			$result=$this->db->where(['status'=>'true'])->order_by("id", "DESC")->get('tbl_notification');
			
			$i=0;
			$return=[];
			foreach($result->result() as $notification){
				$return[$i]=$notification;
				$return[$i]->since=$this->codersadda->humanTiming (strtotime($notification->date.' '.$notification->time));
				$i++;
			}
			$data['notificationList']=$return;
			$data['notificationCount']=$result->num_rows();
			
            $this->load->view("StudentPanel/Notification.php",$data);
		}
		
        
		
		# Live Sessions
		
		public function LiveSessions()
		{
			$table="tbl_live_video";
			
			if($this->uri->segment(3)){
				
				$action=$this->uri->segment(3);
				if($action=='List'){
					
					$orderBy= "'id','DESC'";
					$result=$this->db->where(['status'=>'true'])->order_by($orderBy)->get($table);
					$count=$result->num_rows();
					$return=[];
					if($count){
						
						$i=0;
						foreach($result->result() as $live)
						{
							$return[$i]=$live;
							$return[$i]->author=$this->db->where(['id'=>$live->author])->get('tbl_tutor')->row();
							
							$jresult=$this->db->where(['liveid'=>$live->id,'mobile'=>$this->StudentData->number])->get('tbl_live_join');
							if($jresult->num_rows()){
								$joined='true';
							}
							else{
								$joined='false';
							}
							
							$return[$i]->joined=$joined;
							$i++;
						}
						
					}
					$data['list']=$return;
					$this->load->view("StudentPanel/LiveSessions.php", $data);
				}
				else if($action=='Join'){
					if($this->uri->segment(4) == TRUE){
						$liveid=$this->uri->segment(4);
						
						$whereData=[
						"liveid" => $liveid,
						"mobile" => $this->StudentData->number,
						];
						
						$result=$this->db->where($whereData)->get('tbl_live_join');
						if($result->num_rows()){
							
							$this->session->set_flashdata(array('res'=>'error','msg'=>'Already joined this live session.'));
							redirect(base_url('Student/LiveSessions/List'));
						}
						else{
							
							$data_to_insert = array(
							"liveid" => $liveid,
							"userid" => $this->userid,
							"name" => $this->StudentData->name,
							"email" => $this->StudentData->email,
							"mobile" => $this->StudentData->number,
							"date" => $this->date,
							"time" => $this->time,
							);
							$this->db->insert('tbl_live_join',$data_to_insert);	
							
							$this->session->set_flashdata(array('res'=>'success','msg'=>'Successfully joined this live session.'));
							redirect(base_url('Student/LiveSessions/List'));
						}
					}
					else{
						redirect(base_url('Student/LiveSessions/List'));
					}
					
				}
			}
			else{
				redirect(base_url('Student/LiveSessions/List'));
			}
			
		}
		
		public function Search()
        {
			if($this->uri->segment(3) == TRUE){
				$action = $this->uri->segment(3);
				$data['action']=$action;
				if($action=='SearchItems'){
					$data['action']=$action;
					if($this->input->post('keyword')){
						$keyword=$this->input->post('keyword');
						
						$EnrolledItems=$this->EnrolledItems('Course',$this->userid);
						
						$result=$this->db->where('apprstatus','true')->where_not_in('id',$EnrolledItems)->like('name',$keyword)->get('tbl_course');
						$list=array();
						if($result->num_rows()){
							
							foreach($result->result() as $item)
							{
								$AverageReview=$this->AverageReview('Course',$item->id);
								$listData=[
								'itemtype'	=>	'Course',
								'itemid'	=>	$item->id,
								'author'	=>	$this->db->where('id',$item->author)->get('tbl_tutor')->row(),
								'name'	=>	$item->name,
								'logo'	=>	$item->banner,
								'type'	=>	$item->type,
								'price'	=>	$item->price,
								'offerprice'	=>	$item->offerprice,
								'discountpercent'	=>	$this->codersadda->DiscountPercent($item->discountpercent),
								'rating'	=>	$AverageReview['rating'],
								'totalrating'	=>	$AverageReview['ratingcount']
								];
								$list[]=(object) $listData;
							}
						}
						$EnrolledItems=$this->EnrolledItems('Ebook',$this->userid);
						$result=$this->db->where('apprstatus','true')->where_not_in('id',$EnrolledItems)->like('name',$keyword)->get('tbl_ebook');
						
						if($result->num_rows()){
							
							foreach($result->result() as $item)
							{
								$AverageReview=$this->AverageReview('Course',$item->id);
								
								$listData=[
								'itemtype'	=>	'Ebook',
								'itemid'	=>	$item->id,
								'author'	=>	$this->db->where('id',$item->author)->get('tbl_tutor')->row(),
								'name'	=>	$item->name,
								'logo'	=>	$item->banner,
								'type'	=>	$item->type,
								'price'	=>	$item->price,
								'offerprice'	=>	$item->offerprice,
								'discountpercent'	=>	$this->codersadda->DiscountPercent($item->discountpercent),
								'rating'	=>	$AverageReview['rating'],
								'totalrating'	=>	$AverageReview['ratingcount']
								];
								$list[]=(object) $listData;
							}
						}
						
						$data['list']=$list;
						$this->load->view("StudentPanel/LoadData", $data);
					}
				}
			}
			else{
				$this->load->view("StudentPanel/Search.php");
			}  
		}
		
		# Checkout
		public function Checkout()
        {			
            if(($this->uri->segment(3) == TRUE) and ($this->uri->segment(4) == TRUE))
			{
				$itemtype = $this->uri->segment(3);
				$itemid = $this->uri->segment(4);
				
				if(in_array($itemtype,['Course','Ebook'])){
					
					if($itemtype=='Course'){
						
						$item_table='tbl_course';
					}
					else{
						$item_table='tbl_ebook';
						
					}
					
					$whereData=[ 'id'=>$itemid ];
					$result=$this->db->where($whereData)->get($item_table);
					
					if($result->num_rows()){
						
						$results=$result->row();
						$data['list']=$results;
						
						$data['itemtype']=$itemtype;
						$data['itemid']=$itemid;
						
						$this->load->view("StudentPanel/Checkout.php",$data);
						
					}
					else{
						redirect(base_url('Student/Dashboard'));
					}
				}
				else{
					redirect(base_url('Student/Dashboard'));
				}
				
			}
		    else{
				redirect(base_url('Student/Dashboard'));
			}
		}
		
		# Coupon Validation
		public function CouponValidation()
		{
			$table='tbl_offer';
			$this->session->unset_userdata('CouponData');
			if(!empty($_POST) and ($this->form_validation->run('coupon'))) 
			{
				$couponcode=$this->input->post('couponcode');
				
				$result=$this->db->where("coupon",$couponcode)->get($table);
				if($result->num_rows())
				{
					if(strtotime($result->result()[0]->expiry_date)>=strtotime(date('Y-m-d'))){
						$enrollResult=$this->db->where(['userid'=>$this->userid,'paymentstatus'=>'success','couponcode'=>$couponcode])->get('tbl_enroll');
						if($enrollResult->num_rows()){
							$this->session->set_flashdata('response',['res'=>'error','msg'=>'Coupon Code Already Used.']);
						}
						else{
							if(($result->result()[0]->no_of_coupon)>($result->result()[0]->used_coupon)){
								
								$couponData=array("itemtype"=>$this->uri->segment(3),"itemid"=>$this->uri->segment(4),"discount"=>$result->result()[0]->discount,"discount_type"=>$result->result()[0]->discount_type,"upto"=>$result->result()[0]->upto,"coupon"=>$result->result()[0]->coupon);
								$couponData=(object) $couponData;
								$this->session->set_userdata('CouponData',$couponData);
								
								$this->session->set_flashdata('response',['res'=>'success','msg'=>$result->result()[0]->coupon.' Coupon Applied.']);
								
								
							}
							else{
								$this->session->set_flashdata('response',['res'=>'error','msg'=>'Coupon Code Expired.']);
							}	
						}
						
					}
					else{
						$this->session->set_flashdata('response',['res'=>'error','msg'=>'Coupon Code Expired.']);
					}
					
				}
				else{
					$this->session->set_flashdata('response',['res'=>'error','msg'=>'Coupon Code Invalid.']);
				}	
			}
			else {
				$this->session->set_flashdata('response',['res'=>'error','msg'=>'Enter Coupon']);
			}
			redirect(base_url('Student/Checkout/'.$this->uri->segment(3).'/'.$this->uri->segment(4)));
		}
		
		#Enroll Student
		public function EnrollStudent()
		{
			$table="tbl_enroll";
			$output['res']='error';
			$output['msg']='error';
			if(!empty($_POST) and $this->form_validation->run('enrollcourse')) 
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
					else{
						$item_table='tbl_ebook';
					}
				}
				$itemid=$this->input->post('courseid');
				$whereData=[
				'id'=>$this->input->post('courseid')
				];
				$results=$this->db->where($whereData)->get($item_table)->result();
				if(empty($results)){
					$output['msg']='Item is invalid';
				}
				else{
					$EnrolledItems=$this->EnrolledItems($itemtype,$this->userid);
					if(in_array($this->input->post('courseid'),$EnrolledItems))
					{
						$output['msg']='You have already enrolled this item.';
					}
					else{
						
						
						if(!empty($this->session->get_userdata()['CouponData']) and ($this->session->get_userdata()['CouponData'])->itemtype==$itemtype and ($this->session->get_userdata()['CouponData'])->itemid==$itemid)
						{
							$CouponData=$this->session->get_userdata()['CouponData'];
							if($CouponData->discount_type=='Amount'){
								$coupondiscount=($results[0]->offerprice)-($CouponData->discount);
								if($coupondiscount>$CouponData->upto){
									$coupondiscount=$CouponData->upto;
								}
								$totalprice=($results[0]->offerprice)-($coupondiscount);
							}
							else{
								$coupondiscount=(($results[0]->offerprice)*$CouponData->discount)/100;
								if($coupondiscount>$CouponData->upto){
									$coupondiscount=$CouponData->upto;
								}
								$totalprice=($results[0]->offerprice)-($coupondiscount);
							}
							
							$couponcode=$CouponData->coupon;
							
						}
						else{
							$totalprice=$results[0]->offerprice;
							$couponcode='';
						}
						
						$type=$results[0]->type;
						$itemprice=$totalprice;
						
						
						if($type=='Paid' and $itemprice>0){
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
						"userid" => $this->userid,
						"mobile" => $this->input->post('mobile'),
						"firstname" => $this->input->post('firstname'),
						"lastname" => $this->input->post('lastname'),
						"email" => $this->input->post('emailid'),
						"qualification" => $this->input->post('qualification'),
						"itemid" => $this->input->post('courseid'),
						"itemtype" => $itemtype,
						"couponcode" => $couponcode,
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
							$data['baseUrl']=base_url();
							if($type=='Paid' and $itemprice>0){
								
								$rzpOrderData=$this->razorpay->getRazorpayOrder($rzp_orderid);
								
								if($rzpOrderData){
									
									$data['rzp_api_key']=$this->razorpay->rzp_api_key;
									$data['rzp_api_secret']=$this->razorpay->rzp_api_secret;
									$data['rzpAmount']=$rzpOrderData->amount;
									$data['rzpOrderId']=$rzpOrderData->id;
									$data['enrollData']=(object) $data_to_insert;
									$data['product']=$results[0]->name;
									$data['description']="Payment For ".$results[0]->name." at CodersAdda.com";
									$data['logo']=base_url("image/karmasulogonew.png");
									
									$output['res']='pay';
									$output['msg']='Please Pay';
									$output['data']=$data;
								}
								else{
									$output['msg']='Invalid Order.';
								}
							}
							else{
								$output['res']='free';
								$output['msg']='Update Status';
								$data['rzpOrderId']=$rzp_orderid;
								$output['data']=$data;
								
							}
						}
						else
						{
							$output['msg']='Try again !';
							
						}	
					}
				}	
			}
			else{
				$output['msg']=validation_errors();
			}
			
			echo json_encode([$output]);
			
		}
		
		public function OrderHistory()
		{
			$result=$this->db->where(['userid'=>$this->userid])->order_by("id", "DESC")->get('tbl_enroll');
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
				$return[$i]->item=$this->db->where('id',$enroll->itemid)->get($table)->row();;
				$i++;
			}
			$data['list']=$return;
			$this->load->view("StudentPanel/OrderHistory.php",$data);
		}
		
		public function PaymentStatusUpdate()
		{
			
			$table='tbl_enroll';
			$this->session->unset_userdata('CouponData');
			if(!empty($this->uri->segment(3)) and !empty($this->uri->segment(4))){
				
				$orderid=$this->uri->segment(3);
				$paymentid=$this->uri->segment(4);
				
				$rzp_order=$this->razorpay->getRazorpayOrder($orderid);
				if($rzp_order){
					$enrollResult=$this->db->where(['rzp_orderid'=>$orderid])->get($table);
					if($enrollResult->num_rows()){
						
						$enrollData=$enrollResult->row();
						
						if($rzp_order->status=='paid'){
							$status='success';
							
							if(empty($enrollData->couponcode)){
								
							}
							else{
								$couponcode=$enrollData->couponcode;
								$couponData=$this->db->where('coupon', $couponcode)->order_by("id", "DESC")->limit(1)->get('tbl_offer')->result();
								$used_coupon=$couponData[0]->used_coupon;
								$no_of_coupon=$couponData[0]->no_of_coupon;
								$data_to_update=array(
								"used_coupon" => $used_coupon+1,
								"no_of_coupon" => $no_of_coupon-1
								);
								$query=$this->db->where('coupon',$couponcode)->update('tbl_offer',$data_to_update);
							}
						}
						else{
							$status='failed';
						}
						$updatedata=['paymentstatus'=>$status,'paymentid'=>$paymentid];
						
						if($this->db->where(['rzp_orderid'=>$orderid])->update($table,$updatedata))
						{
							redirect(base_url('Student/Receipt/'.$enrollData->id));
							
						}
						else{
							redirect(base_url('Student/OrderHistory'));
						}
					}
					else{
						redirect(base_url('Student/Dashboard'));
					}
					
				}
				else{
					redirect(base_url('Student/Dashboard'));
				}
			}
			else{
				redirect(base_url('Student/Dashboard'));
			}
		}
		
		public function FreePaymentStatusUpdate()
		{
			
			$table='tbl_enroll';
			$this->session->unset_userdata('CouponData');
			if(!empty($this->uri->segment(3))){
				
				$orderid=$this->uri->segment(3);
				$paymentid='Free';
				
				$enrollResult=$this->db->where(['rzp_orderid'=>$orderid,'orderid'=>$orderid])->get($table);
				if($enrollResult->num_rows()){
					
					$enrollData=$enrollResult->row();
					
					$updatedata=['paymentstatus'=>'success','paymentid'=>$paymentid];
					
					if($this->db->where(['rzp_orderid'=>$orderid,'orderid'=>$orderid])->update($table,$updatedata))
					{
						redirect(base_url('Student/Receipt/'.$enrollData->id));	
					}
					else{
						redirect(base_url('Student/OrderHistory'));
					}
				}
				else{
					redirect(base_url('Student/Dashboard'));
				}
			}
			else{
				redirect(base_url('Student/Dashboard'));
			}
		}
		
		public function Receipt()
        {	
			$table='tbl_enroll';
            if($this->uri->segment(3) == TRUE)
			{
				$enrollid = $this->uri->segment(3);
				
				$result=$this->db->where(['id'=>$enrollid,'userid'=>$this->userid])->get($table);
				if($result->num_rows()){
					$results=$result->row();
					$itemtype=$results->itemtype;
					$itemid=$results->itemid;
					if($itemtype=='Course'){
						$item_table='tbl_course';
					}
					else{
						$item_table='tbl_ebook';
					}
					
					$result=$this->db->where(['id'=>$itemid])->get($item_table);
					
					if($result->num_rows()){
						
						$itemresults=$result->row();
						$data['enroll']=$results;
						$data['item']=$itemresults;
						
						$data['itemtype']=$itemtype;
						$data['itemid']=$itemid;
						
						$this->load->view("StudentPanel/Receipt.php",$data);
						
					}
					else{
						redirect(base_url('Student/Dashboard'));
					}
				}
				else{
					redirect(base_url('Student/Dashboard'));	
				}
			}
		    else{
				redirect(base_url('Student/Dashboard'));
			}
		}
		
		
		
		#Video Playlist
		
		public function VideoPlaylist()
		{
			if(($this->uri->segment(3) == TRUE) and $this->uri->segment(4) == TRUE) 
			{
				$courseid=$this->uri->segment(3);
				$videoid=$this->uri->segment(4);
				
				$result=$this->db->where(['id'=>$courseid])->get('tbl_course');
				if($result->num_rows())
				{
					$enrollResult=$this->db->where(['itemid'=>$courseid,'itemtype'=>'Course','userid'=>$this->userid])->get('tbl_enroll');
					if($enrollResult->num_rows())
					{
						$result=$this->db->where(['course'=>$courseid,'video'=>$videoid])->get('tbl_lecture');
						if($result->num_rows())
						{
							
							$enrollData=$enrollResult->row();
							
							$mark_as_completed=$enrollData->mark_as_completed;
							$mark_as_completed=explode(',',$enrollData->mark_as_completed);
							if(in_array($videoid, $mark_as_completed)){
								$completed='true';
							}
							else{
								$completed='false';
							}
							
							$return=[];
							$i=0;
							foreach($result->result() as $item)
							{ 
								$return[$i]=$item;
								$return[$i]->enroll = $enrollData;
								$return[$i]->course = $this->db->where(['id'=>$courseid])->get('tbl_course')->row();
								$return[$i]->course->author = $this->db->where(['id'=>$return[$i]->course->author])->get('tbl_tutor')->row();
								$return[$i]->video = $this->db->where(['id'=>$videoid])->get('tbl_video')->row();
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
								$i++;
							}
							
							$data['list']=$return;
							
							$query=$this->db->where('course',$courseid)->order_by('lecture_no','ASC')->get('tbl_lecture');
							if($query->num_rows()){
								$data['lecture']=$query->result();
								$return=[];
								foreach ($data['lecture'] as $video){
									$return[$video->id]=$video;
									$videoResult=$this->db->where('id',$video->video)->get('tbl_video')->result();
									$return[$video->id]->video=$videoResult;
									$return[$video->id]->subject=$this->db->where('id',$videoResult[0]->subject)->get('tbl_subject')->result();
								}
								$data["lecture"]=$return;
							}
							else{
								$data["lecture"]=array();
							}
							
							
							$this->load->view("StudentPanel/VideoPlaylist.php",$data);
						}
						else{
							redirect(base_url('Student/CourseDescription/'.$courseid));
						}
						
					}
					else{
						redirect(base_url('Student/CourseDescription/'.$courseid));
					}
				}
				else{
					redirect(base_url('Student/Dashboard'));
				}	
			}
			else{
				redirect(base_url('Student/Dashboard'));
			}
		}
		
		#Assignment
		
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
			redirect(base_url('Student/VideoPlaylist/'.$this->uri->segment(4).'/'.$this->uri->segment(5)));
		}
		
		# Video Question
		
		public function VideoQuestion()
		{
			$output['res']="error";
            $output['msg']="error";
            $output['data']="";
			
			if($this->uri->segment(3)){
				$action=$this->uri->segment(3);
				
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
		
		# Offers
		
		public function Offers()
        {
			
			$result=$this->db->where(['status'=>'true'])->order_by("id", "DESC")->get('tbl_offer');
			$data['offersList']=$result->result();
			
            $this->load->view("StudentPanel/Offers.php",$data);
		}
		
		# Reviews 
		
		public function Review()
		{
			$table="tbl_review";
			
			$output['res']="error";
            $output['msg']="error";
            $output['data']="";
			
			if($this->uri->segment(3)){
				
				$action=$this->uri->segment(3);
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
		
		# Recommended Videos + Free + Short Tips
		public function Videos()
        {
            $table='tbl_recommended_videos';
			
            if($this->uri->segment(4) == TRUE) {
				
                $id = $this->uri->segment(4);
                $query = $this->db->where('id', $id)->get($table);
                if ($query->num_rows()) 
                {
					
					$return=[];
					$i=0;
					
					foreach ($query->result() as $item){
						$return[$i]=$item;
						$return[$i]->author=$this->db->where('id',$item->author)->get('tbl_tutor')->row();
						$return[$i]->subject=$this->db->where('id',$item->subject)->get('tbl_subject')->row();
						$return[$i]->video=$this->db->where('id',$item->video)->get('tbl_video')->row();
						$i++;
					}
					$data["list"]=$return;
					$data["action"]='RecommendedVideosDescription';
					$this->load->view("StudentPanel/RecommendedVideos.php", $data);
				}
				else{
					redirect(base_url('Student/RecommendedVideos'));
				}
			}
			else{
				
				if(empty($this->uri->segment(3))){
					$type='RecommendedVideos';
				}
				else{
					$type=$this->uri->segment(3);	
				}
				$query = $this->db->where(['status'=>'true','type'=>$type])->order_by("id", "DESC")->get($table);
				
				$return=[];
                $i=0;
				
                foreach ($query->result() as $item){
                    $return[$i]=$item;
					$return[$i]->author=$this->db->where('id',$item->author)->get('tbl_tutor')->row();
                    $return[$i]->subject=$this->db->where('id',$item->subject)->get('tbl_subject')->row();
                    $return[$i]->video=$this->db->where('id',$item->video)->get('tbl_video')->row();
                    $i++;
				}
				$data["list"]=$return;
				$data["action"]='RecommendedVideos';
				$data["type"]=$type;
				$this->load->view("StudentPanel/RecommendedVideos.php", $data);
				
			}
			
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
		
		public function MyCertificates()
        {
			$table='tbl_certificate';
			if($this->uri->segment(3)==TRUE)
			{
				$result=$this->db->where(['userid'=>$this->userid,'status'=>'true','refno'=>$this->uri->segment(3)])->order_by("id", "DESC")->get($table);
				if($result->num_rows()==0){
					redirect(base_url('Student/MyCertificates'));
				}
				$data['action']='My Certificates Description';
			}
			else{
				$result=$this->db->where(['userid'=>$this->userid,'status'=>'true'])->order_by("id", "DESC")->get($table);
				$data['action']='My Certificates';
			}
			
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
				$return[$i]->order=$this->db->where(['refno'=>$value->refno])->order_by("id", "DESC")->get('tbl_certificate_order')->result();
				$i++;
			}
			
			$data['certificateList']=$return;
			
			
			$this->load->view("StudentPanel/MyCertificates.php",$data);
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
			
			if($this->uri->segment(3) == TRUE)
			{
				
				$action=$this->uri->segment(3);
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
							$rzpOrderData=$this->razorpay->getRazorpayOrder($rzp_orderid);
							
							if($rzpOrderData)
							{
								
								$data['rzp_api_key']=$this->razorpay->rzp_api_key;
								$data['rzp_api_secret']=$this->razorpay->rzp_api_secret;
								$data['rzpAmount']=$rzpOrderData->amount;
								$data['rzpOrderId']=$rzpOrderData->id;
								$data['orderData']=(object) $insertData;
								$data['product']='Certificate Hard Copy Order';
								$data['description']="Payment For Certificate Hard Copy Order at CodersAdda.com";
								$data['logo']=base_url("image/karmasulogonew.png");
								$data['baseUrl']=base_url();
								    
								$output['res']='success';
								$output['msg']='Please Pay';
								$output['data']=$data;
							}
							else{
								$output['msg']='Invalid Order.';
							}
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
					echo json_encode([$output], JSON_UNESCAPED_UNICODE);
				}
				else if($action=='UpdateStatus')
				{
					if(!empty($this->uri->segment(4)) and !empty($this->uri->segment(5))) 
					{
						$orderid=$this->uri->segment(4);
						$paymentid=$this->uri->segment(5);
						
						$rzp_order=$this->razorpay->getRazorpayOrder($orderid);
						if($rzp_order)
						{
							$Result=$this->db->where(['rzp_orderid'=>$orderid])->get($table);
							if($Result->num_rows())
							{
								
								$orderData=$Result->row();
								
								if($rzp_order->status=='paid')
								{
									$status='success';
								}
								else{
									$status='failed';
								}
								$updateData=['status'=>$status,'paymentid'=>$paymentid,'order_status'=>'Order Placed'];
								
								if($this->db->where(['rzp_orderid'=>$orderid])->update($table,$updateData))
								{
									redirect(base_url('Student/MyCertificates/'.$orderData->refno));
									
								}
								else{
									redirect(base_url('Student/MyCertificates/'.$orderData->refno));
								}
							}
							else{
								redirect(base_url('Student/Dashboard'));
							}
							
						}
						else{
							redirect(base_url('Student/Dashboard'));
						} 
					}
					else
					{
						redirect(base_url('Student/Dashboard'));
					}
				}
				else
				{
					$refno=$this->uri->segment(3);
					$certificateResult=$this->db->where(['refno'=>$refno])->order_by("id", "DESC")->get('tbl_certificate');
					if($certificateResult->num_rows())
					{
						$certificateData=$certificateResult->row();
						$pincode=$this->uri->segment(4);
						if(strlen($pincode)==6 and is_numeric($pincode))
						{
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
							
							$response=$this->codersadda->calculateDistance($pincode);
							
							$certificate_charge=$itemData->certificate_charge;
							$km_charge=$itemData->km_charge;
							
							$amount=$certificate_charge+($km_charge*$response->distance);
							$response->certificate_charge=$certificate_charge;
							$response->km_charge=$km_charge;
							$response->amount=$amount;
							
							$data['certificateData']=$certificateData;
							$data['itemData']=$itemData;
							$data['calculateCharge']=$response;
							$this->load->view("StudentPanel/CertificateOrder",$data);
						}
						else
						{
							redirect($_SERVER['HTTP_REFERER']);
						}
					}
					else{
						redirect($_SERVER['HTTP_REFERER']);
					}
					
				}
			}
			else{
				redirect($_SERVER['HTTP_REFERER']);
			} 
			
		}
		
	}        												