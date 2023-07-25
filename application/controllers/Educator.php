<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
    class Educator extends MY_Controller
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
            
            if ($this->ValidateEducatorUser()) {
                if (empty($this->session->userdata("EducatorLoginData"))) {
                    $this->fetchUserData();
                    
				}
                } else {
                redirect(base_url("Home/"));
			}
            $this->franchise=0;
            $this->author=$this->session->userdata("EducatorIDSession");
			$this->AuthorData=$this->db->where('id',$this->session->userdata("EducatorIDSession"))->get('tbl_tutor')->row();
			$this->firebaseActivities=[
                'None'=>'digi.coders.karmasu_TARGET_NOTIFICATION',
                'Category'=>'',
                'Course'=>'digi.coders.karmasu_TARGET_COURSE_DETAIL',
                'Ebook'=>'digi.coders.karmasu_TARGET_EBOOK_DETAIL',
                'Abook'=>'digi.coders.karmasu_TARGET_AUDIO_BOOK_DETAIL',
                'Quiz'=>'digi.coders.karmasu_TARGET_PLAY_QUIZ',
                'LiveSession'=>'digi.coders.karmasu_TARGET_LIVE_VIDEO_PLAY',
                'FreeVideo'=>'',
                'Offer'=>'digi.coders.karmasu_TARGET_OFFER',
                'External'=>'digi.coders.karmasu_TARGET_NOTIFICATION',
            ];
            
            $this->notificationCount=$this->db->where(['status'=>'true','for_user'=>'Educator'])->where("FIND_IN_SET('".$this->author."',users)!=",0)->order_by("id", "DESC")->get('tbl_notification')->num_rows();
            
		} 
        
        # To unset all sessions created for admin
        
        private function unsetEducatorSession()
        {
            $this->session->unset_userdata("EducatorIDSession");
            $this->session->unset_userdata("EducatorEmailSession");
            $this->session->unset_userdata("EducatorLoginData");
		}
        
        # To fetch admin details of current login
        
        private function fetchUserData()
        {
            $adminid = $this->session->userdata("EducatorIDSession");
            $query1  = $this->db->get_where('tbl_tutor', array(
            'id' => $adminid
            ));
            if ($query1->num_rows() > 0) {
                $this->session->set_userdata("EducatorLoginData", $query1->result_array());
                } else {
                $this->unsetEducatorSession();
			}
		}
        
        # To check admin is a valid user or not
        
        private function ValidateEducatorUser()
        {
            $loginStatus = true;
            if (empty($this->session->userdata("EducatorEmailSession")) || empty($this->session->userdata("EducatorIDSession"))) {
                $loginStatus = false;
                $this->unsetEducatorSession();
                } else {
                $adminEmail = $this->session->userdata("EducatorEmailSession");
                $adminId    = $this->session->userdata("EducatorIDSession");
                $query1     = $this->db->query("select * from tbl_tutor where (email='" . $adminEmail . "' or mobile='" . $adminEmail . "') and id='" . $adminId . "' ");
                if ($query1->num_rows() > 0) {
                    $loginStatus = true;
                    } else {
                    $loginStatus = false;
				}
			}
            return $loginStatus;
		}
        
        # To logout current admin login
        
        public function Logout()
        {
            $adminid = $this->session->userdata("EducatorIDSession");
            $this->db->where(['id'=>$adminid])->update('tbl_tutor',['LastLogoutDate'=>$this->date,'LastLogoutTime'=>$this->time,'CurrentStatus'=>'false']);
            $this->unsetEducatorSession();
            redirect(base_url("Home/"));
		}
        
        # Dashboard
        
        public function Dashboard()
        {
            
            if ($this->uri->segment(3) == TRUE) 
            {
                $data['action'] = $this->uri->segment(3);
                if($data['action']=='Common'){
                    
                    $data['courseCount']=$this->db->where('author',$this->author)->get('tbl_course')->num_rows();
                    $data['ebookCount']=$this->db->where('author',$this->author)->get('tbl_ebook')->num_rows();
                    $data['videoCount']=$this->db->where("(`for_user`='Both' OR `for_user`='Educator')")->get('tbl_recommended_videos')->num_rows();
                    $data['notificationCount']=$this->db->where(['status'=>'true','for_user'=>'Educator'])->where("FIND_IN_SET('".$this->author."',users)!=",0)->order_by("id", "DESC")->get('tbl_notification')->num_rows();
                    
					$data['revenueList']=$this->db->where(['author'=>$this->author,'price!='=>0,'educator_status'=>'true','paymentstatus'=>'success'])->get('tbl_enroll')->result();
					
					
					
					//Recommended Videos
					$result = $this->db->where(['status'=>'true','type'=>'RecommendedVideos'])->where("(`for_user`='Both' OR `for_user`='Educator')")->order_by("id", "DESC")->get('tbl_recommended_videos');
					
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
					// $data["TotalSalesSum"]=$this->db->select_sum('price')->where('franchise_id',0)->where('paymentstatus="success"')->get('tbl_enroll')->row();
					// $data["TotalSalesCount"]=$this->db->where('franchise_id',0)->where('paymentstatus="success"')->get('tbl_enroll')->num_rows();
        			$result=$this->db->where(['status'=>'true','for_user'=>'Educator'])->where("FIND_IN_SET('".$this->author."',users)!=",0)->order_by("id", "DESC")->get('tbl_notification');
        			$i=0;
        			$return=[];
        			foreach($result->result() as $notification){
        				$return[$i]=$notification;
        				$return[$i]->since=$this->codersadda->humanTiming (strtotime($notification->date.' '.$notification->time));
        				$i++;
        			}
        			$data['notificationList']=$return;
        			$data['notificationCount']=$result->num_rows();
				}
				else if($data['action']=='Sales'){
                    
                    $CountSales=[];
                    $query = $this->db->where('author',$this->author)->where(['date'=>$this->dateY])->get('tbl_enroll');
                    $CountSales['TodaySales']=$this->db->where('author',$this->author)->where(['date'=>$this->dateY,'paymentstatus'=>'success'])->order_by('id','DESC')->get('tbl_enroll')->num_rows();
                    $data["TodaySalesList"] = $query->result();
                    $data["TodaySalesSum"]=$this->db->select_sum('price')->where('author',$this->author)->where(['date'=>$this->dateY,'paymentstatus'=>'success'])->order_by('id','DESC')->get('tbl_enroll')->row();
                    
                    $yesterday=date('Y-m-d', strtotime('-1 day', strtotime($this->dateY)));
                    $query = $this->db->where('author',$this->author)->where(['date'=>$yesterday])->order_by('id','DESC')->get('tbl_enroll');
                    $CountSales['YesterdaySales']=$this->db->where('author',$this->author)->where(['date'=>$yesterday,'paymentstatus'=>'success'])->order_by('id','DESC')->get('tbl_enroll')->num_rows();
                    $data["YesterdaySalesList"] = $query->result();
                    $data["YesterdaySalesSum"]=$this->db->select_sum('price')->where('author',$this->author)->where(['date'=>$yesterday,'paymentstatus'=>'success'])->order_by('id','DESC')->get('tbl_enroll')->row();
                    
                    
                    $w_day = date('w');
                    $week_start = date('Y-m-d', strtotime('-'.$w_day.' days'));
                    $week_end =date('Y-m-d', strtotime('+'.(6-$w_day).' days'));
                    $query = $this->db->where('author',$this->author)->where('date BETWEEN "'.$week_start. '" and "'.$week_end.'"')->get('tbl_enroll');
                    $CountSales['WeekSales']=$this->db->where('author',$this->author)->where('paymentstatus="success" AND date BETWEEN "'.$week_start. '" and "'.$week_end.'"')->order_by('id','DESC')->get('tbl_enroll')->num_rows();
                    $data["WeekSalesList"] = $query->result();
                    $data["WeekSalesSum"]=$this->db->select_sum('price')->where('author',$this->author)->where('paymentstatus="success" AND date BETWEEN "'.$week_start. '" and "'.$week_end.'"')->order_by('id','DESC')->get('tbl_enroll')->row();
                    
                    $month_start = date('Y-m-d',strtotime('first day of this month', time()));
                    $month_end = date('Y-m-d',strtotime('last day of this month', time()));
                    $query = $this->db->where('author',$this->author)->where('date BETWEEN "'.$month_start. '" and "'.$month_end.'"')->get('tbl_enroll');
                    $CountSales['MonthSales']=$this->db->where('author',$this->author)->where('paymentstatus="success" AND date BETWEEN "'.$month_start. '" and "'.$month_end.'"')->order_by('id','DESC')->get('tbl_enroll')->num_rows();
                    $data["MonthSalesList"] = $query->result();
                    $data["MonthSalesSum"]=$this->db->select_sum('price')->where('author',$this->author)->where('paymentstatus="success" AND date BETWEEN "'.$month_start. '" and "'.$month_end.'"')->order_by('id','DESC')->get('tbl_enroll')->row();
                    
                    $data['CountSales']=(object) $CountSales;
                }
                
			} 
            else{
                redirect(base_url('Educator/Dashboard/Common')); 
			}
            $this->load->view("Educator/Dashboard.php",$data);
		}
        
        # Status Update
        
        public function UpdateStatus()
        {
            if ($this->input->post()) 
            {
                $data = $this->input->post();
                if($data['table']=='tbl_enroll' or $data['table']=='tbl_certificate_order')
                {
                    $results=$this->db->where($data['where_column'],$data['where_value'])->get($data['table'])->row();
                    if($data['value']=='success'){
                        $message='Mark Success by Educator';
					}
                    else{
                        $message='Mark Failed by Educator';
					}
                    $paymentid=$results->paymentid.','.$message;
                    $result=$this->db->where($data['where_column'],$data['where_value'])
                    ->update($data['table'],array($data['column']=>$data['value'],'paymentid'=>$paymentid));
                    if($result) 
                    {
                        echo true;
					} 
                    else 
                    {
                        echo false;
					}
				}
                else
                {
                    $result=$this->db->where($data['where_column'],$data['where_value'])
                    ->update($data['table'],array($data['column']=>$data['value']));
                    
                    if($result) 
                    {
                        echo true;
					} 
                    else 
                    {
                        echo false;
					}
				}
			} 
            else 
            {
                echo false;
			}
		}
        
        # Delete + included unlink 
        
        public function Delete()
        {
            if ($this->input->post()) {
                $data = $this->input->post();
                $unlink_folder = $data['unlink_folder'];
                $unlink_column = $data['unlink_column'];
                
                $result = $this->db->where($data['where_column'],$data['where_value'])
                ->get($data['table']);
                $resdata = $result->result_array();
                
                $result = $this->db->where($data['where_column'],$data['where_value'])
                ->delete($data['table']);
                if($result) 
                {
                    if(!empty($unlink_column)) 
                    {
                        $unlink_column_array = explode(',', $unlink_column);
                        for ($i = 0; $i < count($unlink_column_array); $i++) 
                        {
                            $unlink_column_name = $unlink_column_array[$i];
							if(($resdata[0][$unlink_column_name])!='logo.png')
							{
								unlink('./uploads/' . $unlink_folder . '/' . $resdata[0][$unlink_column_name]);
							}
							
						}
					}
                    echo true;
				} 
                else 
                {
                    echo false;
				}
			}
            else 
            {
                echo false;
			}
		}
        
        
        # Course Management
        
        public function ManageCourses()
        {
            $table='tbl_course';
            $categoryresult = $this->db->order_by("id", "ASC")->get('tbl_category');
            $data["categorylist"] = $categoryresult->result();
            
            $tutorresult = $this->db->order_by("id", "ASC")->get('tbl_tutor');
            $data["authorlist"] = $tutorresult->result();
            
            if ($this->uri->segment(3) == TRUE) 
            {
                $action = $this->uri->segment(3);
                if ($this->uri->segment(4) == TRUE) 
                {
                    $id = $this->uri->segment(4);
                    $query = $this->db->where('id', $id)->where('author',$this->author)->get($table);
                    if ($query->num_rows()) 
                    {
                        $data["list"] = $query->result();
                        $data['author']=$this->db->where('id',$data["list"][0]->author)->get('tbl_tutor')->result();
                        
                        $data['category']=$this->db->where('id',$data["list"][0]->category)->get('tbl_category')->result();
                        
                        $data['videolist']=$this->db->where('status','true')->where('author',$data["list"][0]->author)->get('tbl_video')->result();
                        
                        $data['subjectlist']=$this->db->where('status','true')->get('tbl_subject')->result();
                        
                        if($action=='Edit')
                        {
                            $this->load->view("Educator/UpdateCourse", $data);
						}
                        else if($action=='Details'){
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
                                    $reviewData[]=['id'=>$review->id,'status'=>$review->status,'name'=>$userValues->name,'mobile'=>$userValues->number,'profile_photo'=>$userValues->profile_photo,'rating'=>$review->rating,'review'=>$review->review,'date'=>$review->date,'time'=>$review->time];		
								}	
							}
                            $data["review"]=$reviewData;
                            
                            $this->load->view("Educator/CourseFullDetails", $data);
						}
                        else if($action=='AddLecture')
                        {
                            
                            $this->form_validation->set_rules('subject', 'Subject', 'required');
                            $this->form_validation->set_rules('title', 'Title', 'required');
                            $this->form_validation->set_rules('description', 'Description', 'required');
                            
                            if(empty($_FILES["thumbnail"]["name"]))
                            { 
                                $this->form_validation->set_rules('thumbnail', 'Thumbnail ', 'required');
							}
                            if($this->input->post("type")=='External'){
                                $this->form_validation->set_rules('link', 'Video Link', 'required');
							}
                            else
                            {
                                if(empty($_FILES["video"]["name"]))
                                { 
                                    $this->form_validation->set_rules('video', 'Video ', 'required');
								}
							}
                            $this->form_validation->set_rules('duration', 'Duration', 'required');
                            $this->form_validation->set_rules('lecture_no', 'Lecture No', 'required');
                            
                            if ($this->form_validation->run() == FALSE){
							} 
                            else 
                            {
                                
                                $ext=pathinfo($_FILES["thumbnail"]["name"],PATHINFO_EXTENSION);
                                $thumbnail=time()."_thumbnail.".$ext;
                                
                                if($this->input->post("type")=='Internal')
                                {
                                    $ext=pathinfo($_FILES["video"]["name"],PATHINFO_EXTENSION);
                                    $video=time()."_video.".$ext;
								}
                                else{
                                    $video='';
									$getYoutubeLinkData=$this->Auth_model->getYoutubeLinkData($this->input->post("link"));
                                    $_POST['link']=$getYoutubeLinkData->embedUrl;
								}
								
                                if(empty($_FILES["notes"]["name"]))
                                {
                                    $filename='';
								}
                                else{
                                    $ext=pathinfo($_FILES["notes"]["name"],PATHINFO_EXTENSION);
                                    $filename=time()."_video_note.".$ext;
								}
                                
                                $data_to_insert= array(
                                "author" => $this->input->post("author"),
                                "subject" =>strtoupper($this->input->post("subject")),
                                "title" => $this->input->post("title"),
                                "description" => $this->input->post("description"),
                                "thumbnail" => $thumbnail,
                                "video" => $video,
                                "duration" => $this->input->post("duration"),
                                "type" => $this->input->post("type"),
                                "link" => $this->input->post("link"),
                                "notes" => $filename,
                                "status" => "true",
                                "date" => $this->date,
                                "time" => $this->time
                                );
                                
                                $data_to_insert = $this->security->xss_clean($data_to_insert);
                                if ($this->db->insert('tbl_video', $data_to_insert)) 
                                {
                                    $video_id=$this->db->insert_id();
                                    $videos=$this->db->where(['id'=>$this->input->post("subject")])->get('tbl_subject')->row()->videos;
                                    $this->db->where(['id'=>$this->input->post("subject")])->update('tbl_subject',['videos'=>$videos+1]);
                                    
                                    $upload_errors=array();
                                    $initialize=false;
                                    
                                    
                                    if(!empty($_FILES["thumbnail"]["name"]))
                                    {
                                        $config['upload_path'] = './uploads/thumbnail/';
                                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                        $config['max_size'] = 100000; // In KB
                                        $config['file_name'] = $thumbnail;
                                        $this->load->library('upload', $config);  
                                        if(!$this->upload->do_upload('thumbnail'))
                                        {
                                            array_push($upload_errors,array('error_upload' => $this->upload->display_errors()));
										}
                                        $initialize=true;
									}
                                    
                                    if(!empty($_FILES["video"]["name"]))
                                    {
                                        $config['upload_path'] = './uploads/video/';
                                        $config['allowed_types'] = 'ogm|wmv|mpg|webm|ogv|mov|asx|mpeg|mp4|m4v|avi';
                                        $config['max_size'] = 10000000; // In KB
                                        $config['file_name'] = $video;
                                        if($initialize==true){
                                            $this->upload->initialize($config);
										}
                                        else{
                                            $this->load->library('upload', $config); 
										}
                                        if(!$this->upload->do_upload('video'))
                                        {
                                            array_push($upload_errors,array('error_upload' => $this->upload->display_errors()));
										}
                                        $initialize=true;
									}
                                    
                                    if(!empty($_FILES["notes"]["name"]))
                                    {
                                        $config['upload_path'] = './uploads/notes/';
                                        $config['allowed_types'] = 'pdf';
                                        $config['max_size'] = 50000; 
                                        $config['file_name'] = $filename;  
                                        if($initialize==true){
                                            $this->upload->initialize($config);
										}
                                        else{
                                            $this->load->library('upload', $config); 
										}
                                        if(!$this->upload->do_upload('notes'))
                                        {
                                            array_push($upload_errors,array('error_upload' => $this->upload->display_errors()));
										}
                                        
									}
                                    
                                    $data_to_insert= array(
                                    "course" => $id,
                                    "video" =>$video_id,
                                    "lecture_no" =>$this->input->post("lecture_no"),
                                    "status" => "true",
                                    "date" => $this->date,
                                    "time" => $this->time
                                    );
                                    $data_to_insert = $this->security->xss_clean($data_to_insert);
                                    
                                    if ($this->db->insert('tbl_lecture', $data_to_insert)) {
                                        $this->session->set_flashdata(array('res'=>'success','msg'=>'Lecture Added Successfully.'));
									}
                                    else 
                                    {
                                        $this->session->set_flashdata(array('res'=>'error','msg'=>'Try !Again'));
									}
								}
                                else 
                                {
                                    $this->session->set_flashdata(array('res'=>'error','msg'=>'Try !Again'));
								}
							}
                            redirect(base_url('Educator/ManageCourses/Details/'.$id));  
						}
                        else if($action=='AddAssignment')
                        {
                            $this->form_validation->set_rules('video', 'Video ID', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('description', 'Description', 'required', array('required' => '%s is Required Field'));
                            
                            if (empty($_FILES["assignment"]["name"])) {
                                $this->form_validation->set_rules('assignment', 'Assignment', 'required');
							}
                            else{
                                $ext      = pathinfo($_FILES["assignment"]["name"], PATHINFO_EXTENSION);
                                $filename = time().rand(). "." . $ext;
							}
							
                            if ($this->form_validation->run() == FALSE){
							} 
                            else 
                            {
                                $data_to_insert= array(
                                "assignment" => $filename,
                                "video" => $this->input->post("video"),
                                "status" => "true",
                                "date" => $this->date,
                                "time" => $this->time
                                );
                                $data_to_insert = $this->security->xss_clean($data_to_insert);
                                $data_to_insert['description']=$this->input->post("description");
                                if ($this->db->insert('tbl_video_assignment', $data_to_insert)) {
                                    $upload_errors           = array();
                                    $config['upload_path']   = './uploads/assignment/';
                                    $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
                                    $config['max_size']      = 50000;
                                    $config['file_name']     = $filename;
                                    $this->load->library('upload', $config);
                                    if (!$this->upload->do_upload('assignment')) {
                                        array_push($upload_errors, array(
                                        'error_upload_logo' => $this->upload->display_errors()
                                        ));
                                        $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
									}
                                    else{
                                        $this->session->set_flashdata(array('res'=>'success','msg'=>'Lecture Assignment Added Successfully.'));
									}
								}
                                else 
                                {
                                    $this->session->set_flashdata(array('res'=>'error','msg'=>'Try Again !'));
								}
							}
                            redirect(base_url('Educator/ManageCourses/Details/'.$id));
						}
                        else if($action=='Certificate')
                        {
                            $data['name']='Karmasu';
                            $data['training']='Karmasu';
                            $data['technology']='Karmasu';
                            $data['grade']='A++';
                            $data['duration']='45 Days';
                            $data['from']=$this->date;
                            $data['to']=$this->date;
                            $data['refno']='DCT2021';
                            $data['enroll_id']='DCT2021';
                            $data['issuedon']=$this->date;
                            $this->load->view("Certificate/".$data["list"][0]->certificate, $data);
                            
						}
                        else    
                        {
                            redirect(base_url('Educator/ManageCourses'));     
						}
					}
                    else
                    {
                        redirect(base_url('Educator/ManageCourses')); 
					}
				}
                else 
                {
                    if($action=='Add'){
                        if (isset($_POST["addaction"])) 
                        {    
                            $this->form_validation->set_rules('coursename', 'Course Name', 'required|is_unique[tbl_course.name]', array(
							'required' => '%s is Required Field',
							'is_unique' => '%s is Already Exists'
                            ));
                            $this->form_validation->set_rules('category', 'Category', 'required');
                            $this->form_validation->set_rules('author', 'Author', 'required');
                            $this->form_validation->set_rules('coursetype', 'Course Type', 'required');
                            $this->form_validation->set_rules('courseprice', 'Course Price', 'required');
                            $this->form_validation->set_rules('courseshortdescription', 'Short Description', 'required');
                            $this->form_validation->set_rules('noofvideos', 'No of Videos', 'required');
                            $this->form_validation->set_rules('daystofinish', 'Days to Dinish', 'required');
                            // $this->form_validation->set_rules('description', 'Description', 'required');
                            // $this->form_validation->set_rules('requirement', 'Requirements', 'required');
                            // $this->form_validation->set_rules('course_include', 'What this course include ?', 'required');
                            // $this->form_validation->set_rules('will_learn', 'What you will learn ?', 'required');
                            if (empty($_FILES["courselogo"]["name"])) {
                                $this->form_validation->set_rules('courselogo', 'Course Logo/Icon', 'required');
							}
                            if (empty($_FILES["coursebanner"]["name"])) {
                                $this->form_validation->set_rules('coursebanner', 'Course Banner', 'required');
							}
                            $this->form_validation->set_rules('coursedemovideo', 'Course Demo Video', 'required');
                            $this->form_validation->set_rules('certificationcheck', 'Certification', 'required');
                            
                            if ($this->form_validation->run() == FALSE){
                                redirect(base_url('Educator/ManageCourses/Add')); 
							} 
                            else 
                            {
								$getYoutubeLinkData=$this->Auth_model->getYoutubeLinkData($this->input->post("coursedemovideo"));
                                $_POST['coursedemovideo']=$getYoutubeLinkData->embedUrl;
								
                                $logo_ext      = pathinfo($_FILES["courselogo"]["name"], PATHINFO_EXTENSION);
                                $logo_filename = time() . "_course_logo." . $logo_ext;
                                
                                $banner_ext      = pathinfo($_FILES["coursebanner"]["name"], PATHINFO_EXTENSION);
                                $banner_filename = time() . "_course_banner." . $banner_ext;
                                
                                if($this->input->post("coursetype")=='Free'){
                                    $courseprice=0;
                                    $courseofferprice=0;
                                    $discountpercentage='0% Off';
								}
                                else{
                                    $courseprice=$this->input->post("courseprice");
                                    $courseofferprice=$this->input->post("courseofferprice");
                                    $discountpercentage=$this->input->post("discountpercentage");
								}
                                if($this->input->post("certificationcheck")=='No'){
                                    $certificate='';
                                    $certificate_charge='';
                                    $km_charge='';
								}
                                else{
                                    $certificate=$this->input->post("certificate");
                                    $certificate_charge=$this->input->post("certificate_charge");
                                    $km_charge=$this->input->post("km_charge");
								}
                                $data_to_insert                = array(
								"category" => $this->input->post("category"),
								"author" => $this->input->post("author"),
								"name" => $this->input->post("coursename"),
								"logo" => $logo_filename,
								"banner" => $banner_filename,
								"type" => $this->input->post("coursetype"),
								"price" => $courseprice,
								"offerprice" => $courseofferprice,
								"shortdesc" => $this->input->post("courseshortdescription"),
								"nooflecture" => $this->input->post("noofvideos"),
								"daystofinish" => $this->input->post("daystofinish"),
								"timing" => $this->input->post("timing"),
								"demovedio" => $this->input->post("coursedemovideo"),
								"apprstatus" => "false",
								"certification" => $this->input->post("certificationcheck"),
								"certificate" => $certificate,
								"certificate_charge" => $certificate_charge,
								"km_charge" => $km_charge,
								"discountpercent" => $discountpercentage,
								"date" => $this->date,
								"time" => $this->time
                                );
                                $data_to_insert                = $this->security->xss_clean($data_to_insert);
                                $data_to_insert["description"] = $this->input->post("description");
                                $data_to_insert["requirement"] = $this->input->post("requirement");
                                $data_to_insert["course_include"] = $this->input->post("course_include");
                                $data_to_insert["will_learn"] = $this->input->post("will_learn");
                                
                                if ($this->db->insert($table, $data_to_insert)) {
                                    $upload_errors           = array();
                                    #Upload Logo
                                    $config['upload_path']   = './uploads/course/';
                                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                    $config['max_size']      = 100000; // In KB
                                    $config['file_name']     = $logo_filename;
                                    $this->load->library('upload', $config);
                                    if (!$this->upload->do_upload('courselogo')) {
                                        array_push($upload_errors, array(
										'error_upload_logo' => $this->upload->display_errors()
                                        ));
									}
                                    
                                    $config['upload_path']   = './uploads/course/';
                                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                    $config['max_size']      = 100000; // In KB
                                    $config['file_name']     = $banner_filename;
                                    $this->upload->initialize($config);
                                    if (!$this->upload->do_upload('coursebanner')) {
                                        array_push($upload_errors, array(
										'error_upload_logo' => $this->upload->display_errors()
                                        ));
									}
                                    
                                    if (count($upload_errors) == 0) 
                                    {
                                        $this->session->set_flashdata(array('res'=>'success','msg'=>'Course Added Successfully.'));
                                        redirect(base_url('Educator/ManageCourses/Add'));
									} 
                                    else 
                                    {
                                        $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
                                        redirect(base_url('Educator/ManageCourses/Add'));
									}
								}
                                else
                                {
                                    $this->session->set_flashdata(array('res'=>'error','msg'=>'Something went wrong in Data Shaving.'));
                                    redirect(base_url('Educator/ManageCourses/Add'));
								}
							}
						}
                        else
                        {
                            $this->load->view("Educator/AddCourse.php",$data);
						}
					}
                    else if($action=='Update')
                    {
                        if (isset($_POST["updateaction"])) 
                        {  
                            if(empty($this->input->post("id")))
                            {
                                $this->session->set_flashdata(array('res'=>'error','msg'=>'ID is required.'));
                                redirect(base_url('Educator/ManageCourses/Edit/'.$id));
							} 
                            else
                            {
                                $query = $this->db->where('id', $this->input->post("id"))->get($table);
                                if ($query->num_rows()) 
                                {
                                    $data['list']=$query->result();
                                    $id=$data['list'][0]->id;
                                    $this->form_validation->set_rules('coursename', 'Course Name', 'required',array('required'=>'%s is Required Field'));
                                    $this->form_validation->set_rules('category', 'Category', 'required');
                                    $this->form_validation->set_rules('author', 'Author', 'required');
                                    $this->form_validation->set_rules('coursetype', 'Course Type', 'required');
                                    $this->form_validation->set_rules('courseprice', 'Course Price', 'required');
                                    $this->form_validation->set_rules('courseshortdescription', 'Short Description', 'required');
                                    $this->form_validation->set_rules('noofvideos', 'No of Videos', 'required');
                                    $this->form_validation->set_rules('daystofinish', 'Days to Dinish', 'required');
                                    // $this->form_validation->set_rules('description', 'Description', 'required');
                                    // $this->form_validation->set_rules('requirement', 'Requirements', 'required');
                                    // $this->form_validation->set_rules('course_include', 'What this course include ?', 'required');
                                    // $this->form_validation->set_rules('will_learn', 'What you will learn ?', 'required');
                                    if ($this->form_validation->run() == FALSE)
                                    {
                                        $this->session->set_flashdata(array('res'=>'error','msg'=>'ID is required.'));
                                        redirect(base_url('Educator/ManageCourses/Edit/'.$id));
									}
                                    else{
                                        if(empty($_FILES["courselogo"]["name"]))
                                        {
                                            $logo_filename=$data["list"][0]->logo;
										}
                                        else{
                                            $logo_ext=pathinfo($_FILES["courselogo"]["name"],PATHINFO_EXTENSION);
                                            $logo_filename=time()."_course_logo.".$logo_ext;
										}
                                        if(empty($_FILES["coursebanner"]["name"]))
                                        {
                                            $banner_filename=$data["list"][0]->banner;
										}
                                        else{
                                            $banner_ext=pathinfo($_FILES["coursebanner"]["name"],PATHINFO_EXTENSION);
                                            $banner_filename=time()."_course_banner.".$banner_ext;
										}
                                        if($this->input->post("coursetype")=='Free'){
                                            $courseprice=0;
                                            $courseofferprice=0;
                                            $discountpercentage='0% Off';
										}
                                        else{
                                            $courseprice=$this->input->post("courseprice");
                                            $courseofferprice=$this->input->post("courseofferprice");
                                            $discountpercentage=$this->input->post("discountpercentage");
										}
                                        if($this->input->post("certificationcheck")=='No'){
                                            $certificate='';
                                            $certificate_charge='';
                                            $km_charge='';
										}
                                        else{
                                            $certificate=$this->input->post("certificate");
                                            $certificate_charge=$this->input->post("certificate_charge");
                                            $km_charge=$this->input->post("km_charge");
										}
                                        
										$getYoutubeLinkData=$this->Auth_model->getYoutubeLinkData($this->input->post("coursedemovideo"));
										$_POST['coursedemovideo']=$getYoutubeLinkData->embedUrl;
										
                                        $data_to_update=array(
										"category"=> $this->input->post("category"),
										"author"=> $this->input->post("author"),
										"name"=> $this->input->post("coursename"),
										"logo"=> $logo_filename,
										"banner"=> $banner_filename,
										"type"=> $this->input->post("coursetype"),
										"price"=> $courseprice,
										"offerprice"=> $courseofferprice,
										"shortdesc"=> $this->input->post("courseshortdescription"),
										"nooflecture"=> $this->input->post("noofvideos"),
										"daystofinish"=> $this->input->post("daystofinish"),
                                        "timing" => $this->input->post("timing"),
										"demovedio"=> $this->input->post("coursedemovideo"),
										"discountpercent"=> $discountpercentage,
                                        "certification" => $this->input->post("certificationcheck"),
                                        "certificate" => $certificate,
                                        "certificate_charge" => $certificate_charge,
                                        "km_charge" => $km_charge,
                                        );
                                        $data_to_update = $this->security->xss_clean($data_to_update);
                                        $data_to_update["description"] = $this->input->post("description");
                                        $data_to_update["requirement"] = $this->input->post("requirement");
                                        $data_to_update["course_include"] = $this->input->post("course_include");
                                        $data_to_update["will_learn"] = $this->input->post("will_learn");
                                        $query=$this->db->where('id',$id)
                                        ->update($table,$data_to_update);
                                        if($query)
                                        {
                                            $upload_errors=array();
                                            $initialize=false;
                                            if(!empty($_FILES["courselogo"]["name"]))
                                            {
                                                $config['upload_path'] = './uploads/course/';
                                                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                                $config['max_size'] = 100000; // In KB
                                                $config['file_name'] = $logo_filename;
                                                $this->load->library('upload', $config);  
                                                if(!$this->upload->do_upload('courselogo'))
                                                {
                                                    array_push($upload_errors,array('error_upload_logo' => $this->upload->display_errors()));
												}
                                                $initialize=true;
											}
                                            
                                            if(!empty($_FILES["coursebanner"]["name"]))
                                            {
                                                $config['upload_path'] = './uploads/course/';
                                                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                                $config['max_size'] = 100000; // In KB
                                                $config['file_name'] = $banner_filename;
                                                if($initialize==true){
                                                    $this->upload->initialize($config);
												}
                                                else{
                                                    $this->load->library('upload', $config); 
												}
                                                if(!$this->upload->do_upload('coursebanner'))
                                                {
                                                    array_push($upload_errors,array('error_upload_logo' => $this->upload->display_errors()));
												}
											}
                                            if(count($upload_errors)==0)
                                            {
                                                $this->session->set_flashdata(array('res'=>'success','msg'=>'Course Updated Successfully.'));
                                                redirect(base_url('Educator/ManageCourses'));
											}
                                            else
                                            {
                                                $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
                                                $data['upload_errors']=$upload_errors;
                                                redirect(base_url('Educator/ManageCourses/Edit/'.$id));
											}
										}
                                        else
                                        {
                                            
                                            $this->session->set_flashdata(array('res'=>'error','msg'=>'Something went wrong in Data Shaving.'));
                                            redirect(base_url('Educator/ManageCourses/Edit/'.$id));
										}
									}
								}
                                else{
                                    redirect(base_url('Educator/ManageCourses'));
								}
							}
						}
                        else{
                            redirect(base_url('Educator/ManageCourses'));
						}
					}
                    
				}
                
			}
            else 
            {
                $query = $this->db->where('author',$this->author)->order_by("id", "DESC")->get($table);
                
                $data["list"] = $query->result();
                $i=0;$return=[];
                foreach( $data["list"] as $item)
                {
                    $return[$i]=$item;
                    $return[$i]->author=$this->db->where('id',$item->author)->get('tbl_tutor')->row();
                    $i++;
				}
                $this->load->view("Educator/ManageCourses", $data);
			}
		}
        
        # E-Book Management
        
        public function ManageEBooks()
        {
            $table='tbl_ebook';
            $categoryresult = $this->db->order_by("id", "ASC")->get('tbl_category');
            $data["categorylist"] = $categoryresult->result();
            
            $tutorresult = $this->db->order_by("id", "ASC")->get('tbl_tutor');
            $data["authorlist"] = $tutorresult->result();
            
            if ($this->uri->segment(3) == TRUE) 
            {
                $action = $this->uri->segment(3);
                if ($this->uri->segment(4) == TRUE) 
                {
                    $id = $this->uri->segment(4);
                    $query = $this->db->where('id', $id)->where('author',$this->author)->get($table);
                    if ($query->num_rows()) 
                    {
                        $data["list"] = $query->result();
                        
                        $data['author']=$this->db->where('id',$data["list"][0]->author)->get('tbl_tutor')->result();
                        $data['category']=$this->db->where('id',$data["list"][0]->category)->get('tbl_category')->result();
                        if($action=='Edit')
                        {
                            $this->load->view("Educator/UpdateEBook", $data);
						}
                        else if($action=='Details')
                        {
                            
                            // Find and Add Reviews 
                            $reviewResult=$this->db->where(['itemtype'=>'Ebook','itemid'=>$data["list"][0]->id])->get("tbl_review");
                            
                            $reviewData=[];
                            foreach($reviewResult->result() as $review)
                            {
                                $userResult=$this->db->where(['id'=>$review->userid])->get("tbl_registration");
                                if($userResult->num_rows()){
                                    $userValues=$userResult->row();
                                    $reviewData[]=['id'=>$review->id,'status'=>$review->status,'name'=>$userValues->name,'mobile'=>$userValues->number,'profile_photo'=>$userValues->profile_photo,'rating'=>$review->rating,'review'=>$review->review,'date'=>$review->date,'time'=>$review->time];
								}	
							}
                            $data["review"]=$reviewData;
							
							$result=$this->db->where('itemid',$id)->where('itemtype','Ebook')->order_by('topic_no','ASC')->get('tbl_topic');
                            $data['topicList']=$result->result();
							
                            $this->load->view("Educator/EBookFullDetails", $data);
						}
						else if($action=='AddTopic') 
                        { 
                            
                            $this->form_validation->set_rules('topic_no', 'Topic No', 'required');
                            $this->form_validation->set_rules('name', 'Topic Name', 'required');
                            $this->form_validation->set_rules('itemtype', 'Item Type', 'required');
                            $this->form_validation->set_rules('itemid', 'Item Id', 'required');
                            $this->form_validation->set_rules('type', 'Topic Type', 'required');
                            
                            
							
                            if($this->input->post("type")=='External'){
                                $this->form_validation->set_rules('topic', 'Topic Link', 'required');
							}
                            else
                            { 
                                if(empty($_FILES["topic"]["name"]))
                                { 
                                    $this->form_validation->set_rules('topic', 'Topic PDF ', 'required');
								}
							}
                            
                            if ($this->form_validation->run() == FALSE){
							} 
                            else 
                            {
                                
                                
                                if($this->input->post("type")=='Internal')
                                {
                                    $ext=pathinfo($_FILES["topic"]["name"],PATHINFO_EXTENSION);
                                    $topic=time()."_".$this->input->post("itemtype").".".$ext;
								}
                                else{
                                    $topic=$this->input->post("topic");
								}
                                
                                
                                $data_to_insert= array(
                                "itemid" => $this->input->post("itemid"),
                                "itemtype" => $this->input->post("itemtype"),
                                "topic_no" => $this->input->post("topic_no"),
                                "type" => $this->input->post("type"),
                                "name" => $this->input->post("name"),
                                "topic" => $topic,
                                "description" => $this->input->post("description"),
                                "status" => "true",
                                "date" => $this->date,
                                "time" => $this->time
                                );
                                
                                $data_to_insert = $this->security->xss_clean($data_to_insert);
                                if ($this->db->insert('tbl_topic', $data_to_insert)) 
                                {
                                    
									$this->session->set_flashdata(array('res'=>'success','msg'=>'Topic Added Successfully.'));
									if($this->input->post("type")=='Internal')
									{
										$config['upload_path'] = './uploads/topic/';
                                        $config['allowed_types'] = 'pdf';
                                        $config['max_size'] = 1000000; // In KB
                                        $config['file_name'] = $topic;
                                        $this->load->library('upload', $config);  
                                        $this->upload->do_upload('topic');
										$this->session->set_flashdata(array('res'=>'success','msg'=>'Topic added but error in file upload.'));
									}
								}
                                else 
                                {
                                    $this->session->set_flashdata(array('res'=>'error','msg'=>'Try !Again'));
								}
							}
                            redirect(base_url('Educator/ManageEBooks/Details/'.$id));  
						}
                        else
                        {
                            redirect(base_url('Educator/ManageEBooks'));
						}
					}
                    else
                    {
                        redirect(base_url('Educator/ManageEBooks'));
					}
				}
                else 
                {
                    if($action=='Add'){
                        if (isset($_POST["addaction"])) 
                        {    
                            $this->form_validation->set_rules('ebookname', 'EBook Name', 'required|is_unique[tbl_ebook.name]', array(
                            'required' => '%s is Required Field'
                            ));
                            $this->form_validation->set_rules('category', 'Category', 'required');
                            $this->form_validation->set_rules('author', 'Author', 'required');
                            $this->form_validation->set_rules('ebooktype', 'EBook Type', 'required');
                            $this->form_validation->set_rules('ebookprice', 'EBook Price', 'required');
                            $this->form_validation->set_rules('ebookshortdescription', 'Short Description', 'required');
                            $this->form_validation->set_rules('noofpages', 'No of Pages', 'required');
                            $this->form_validation->set_rules('daystofinish', 'Days to Dinish', 'required');
                            // $this->form_validation->set_rules('description', 'Description', 'required');
                            // $this->form_validation->set_rules('requirement', 'Requirements', 'required');
                            // $this->form_validation->set_rules('ebook_include', 'What this ebook include ?', 'required');
                            // $this->form_validation->set_rules('will_learn', 'What you will learn ?', 'required');
                            if (empty($_FILES["ebooklogo"]["name"])) {
                                $this->form_validation->set_rules('ebooklogo', 'EBook Logo/Icon', 'required');
							}
                            if (empty($_FILES["ebookbanner"]["name"])) {
                                $this->form_validation->set_rules('ebookbanner', 'EBook Banner', 'required');
							}
                            if (empty($_FILES["ebooksample"]["name"])) {
                                $this->form_validation->set_rules('ebooksample', 'EBook Sample', 'required');
							}
                            if (empty($_FILES["ebook"]["name"])) {
                                // $this->form_validation->set_rules('ebook', 'EBook PDF File', 'required');
							}
                            if ($this->form_validation->run() == FALSE){
                                redirect(base_url('Educator/ManageEBooks/Add'));
							} 
                            else 
                            {
                                $logo_ext      = pathinfo($_FILES["ebooklogo"]["name"], PATHINFO_EXTENSION);
                                $logo_filename = time() . "_ebook_logo." . $logo_ext;
                                
                                $banner_ext      = pathinfo($_FILES["ebookbanner"]["name"], PATHINFO_EXTENSION);
                                $banner_filename = time() . "_ebook_banner." . $banner_ext;
                                
                                $sample_ext      = pathinfo($_FILES["ebooksample"]["name"], PATHINFO_EXTENSION);
                                $sample_filename = time() . "_ebook_sample." . $sample_ext;
                                
                                $ebook_ext      = pathinfo($_FILES["ebook"]["name"], PATHINFO_EXTENSION);
                                $ebook_filename = time() . "_ebook." . $ebook_ext;
                                
                                $data_to_insert                = array(
                                "category" => $this->input->post("category"),
                                "author" => $this->input->post("author"),
                                "name" => $this->input->post("ebookname"),
                                "logo" => $logo_filename,
                                "banner" => $banner_filename,
                                "sample" => $sample_filename,
                                "ebook" => $ebook_filename,
                                "type" => $this->input->post("ebooktype"),
                                "price" => $this->input->post("ebookprice"),
                                "offerprice" => $this->input->post("ebookofferprice"),
                                "shortdesc" => $this->input->post("ebookshortdescription"),
                                "noofpages" => $this->input->post("noofpages"),
                                "daystofinish" => $this->input->post("daystofinish"),
                                "offer_text" => $this->input->post("offer_text"),
                                "apprstatus" => "false",
                                "discountpercent" => $this->input->post("discountpercentage"),
                                "date" => $this->date,
                                "time" => $this->time
                                );
                                $data_to_insert                = $this->security->xss_clean($data_to_insert);
                                $data_to_insert["description"] = $this->input->post("description");
                                $data_to_insert["requirement"] = $this->input->post("requirement");
                                $data_to_insert["ebook_include"] = $this->input->post("ebook_include");
                                $data_to_insert["will_learn"] = $this->input->post("will_learn");
                                
                                if ($this->db->insert($table, $data_to_insert)) {
                                    $upload_errors           = array();
                                    #Upload Logo
                                    $config['upload_path']   = './uploads/ebook/';
                                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                    $config['max_size']      = 100000; // In KB
                                    $config['file_name']     = $logo_filename;
                                    $this->load->library('upload', $config);
                                    if (!$this->upload->do_upload('ebooklogo')) {
                                        array_push($upload_errors, array(
                                        'error_upload_logo' => $this->upload->display_errors()
                                        ));
									}
                                    
                                    $config['upload_path']   = './uploads/ebook/';
                                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                    $config['max_size']      = 100000; // In KB
                                    $config['file_name']     = $banner_filename;
                                    $this->upload->initialize($config);
                                    if (!$this->upload->do_upload('ebookbanner')) {
                                        array_push($upload_errors, array(
                                        'error_upload_logo' => $this->upload->display_errors()
                                        ));
									}
                                    
                                    $config['upload_path']   = './uploads/ebook/';
                                    $config['allowed_types'] = 'pdf';
                                    $config['max_size']      = 100000; // In KB
                                    $config['file_name']     = $sample_filename;
                                    $this->upload->initialize($config);
                                    if (!$this->upload->do_upload('ebooksample')) {
                                        array_push($upload_errors, array(
                                        'error_upload_logo' => $this->upload->display_errors()
                                        ));
									}
                                    if (!empty($_FILES["ebook"]["name"])) {
										$config['upload_path']   = './uploads/ebook/';
										$config['allowed_types'] = 'pdf';
										$config['max_size']      = 50000; // In KB
										$config['file_name']     = $ebook_filename;
										$this->upload->initialize($config);
										if (!$this->upload->do_upload('ebook')) {
											array_push($upload_errors, array(
											'error_upload_logo' => $this->upload->display_errors()
											));
										}
									}
                                    
                                    
                                    if (count($upload_errors) == 0) 
                                    {
                                        $this->session->set_flashdata(array('res'=>'success','msg'=>'EBook Added Successfully.'));
                                        redirect(base_url('Educator/ManageEBooks/Add'));
									} 
                                    else 
                                    {
                                        $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
                                        redirect(base_url('Educator/ManageEBooks/Add'));
									}
								}
                                else
                                {
                                    $this->session->set_flashdata(array('res'=>'error','msg'=>'Something went wrong in Data Shaving.'));
                                    redirect(base_url('Educator/ManageEBooks/Add'));
								}
							}
						}
                        else
                        {
                            $this->load->view("Educator/AddEBook.php",$data);
						}
					}
                    else if($action=='Update')
                    {
                        if (isset($_POST["updateaction"])) 
                        {  
                            if(empty($this->input->post("id")))
                            {
                                $this->session->set_flashdata(array('res'=>'error','msg'=>'ID is required.'));
                                redirect(base_url('Educator/ManageEBooks/Edit/'.$id));
							} 
                            else
                            {
                                $query = $this->db->where('id', $this->input->post("id"))->get($table);
                                if ($query->num_rows()) 
                                {
                                    $data['list']=$query->result();
                                    $id=$data['list'][0]->id;
                                    $this->form_validation->set_rules('ebookname', 'EBook Name', 'required',array('required'=>'%s is Required Field'));
                                    $this->form_validation->set_rules('category', 'Category', 'required');
                                    $this->form_validation->set_rules('author', 'Author', 'required');
                                    $this->form_validation->set_rules('ebooktype', 'EBook Type', 'required');
                                    $this->form_validation->set_rules('ebookprice', 'EBook Price', 'required');
                                    $this->form_validation->set_rules('ebookshortdescription', 'Short Description', 'required');
                                    $this->form_validation->set_rules('noofpages', 'No of Pages', 'required');
                                    $this->form_validation->set_rules('daystofinish', 'Days to Dinish', 'required');
                                    // $this->form_validation->set_rules('description', 'Description', 'required');
                                    // $this->form_validation->set_rules('requirement', 'Requirements', 'required');
                                    // $this->form_validation->set_rules('ebook_include', 'What this ebook include ?', 'required');
                                    // $this->form_validation->set_rules('will_learn', 'What you will learn ?', 'required');
                                    if ($this->form_validation->run() == FALSE)
                                    {
                                        $this->session->set_flashdata(array('res'=>'error','msg'=>'ID is required.'));
                                        redirect(base_url('Educator/ManageEBooks/Edit/'.$id));
									}
                                    else{
                                        if(empty($_FILES["ebooklogo"]["name"]))
                                        {
                                            $logo_filename=$data["list"][0]->logo;
										}
                                        else{
                                            $logo_ext=pathinfo($_FILES["ebooklogo"]["name"],PATHINFO_EXTENSION);
                                            $logo_filename=time()."_ebook_logo.".$logo_ext;
										}
                                        if(empty($_FILES["ebookbanner"]["name"]))
                                        {
                                            $banner_filename=$data["list"][0]->banner;
										}
                                        else{
                                            $banner_ext=pathinfo($_FILES["ebookbanner"]["name"],PATHINFO_EXTENSION);
                                            $banner_filename=time()."_ebook_banner.".$banner_ext;
										}
                                        if(empty($_FILES["ebooksample"]["name"]))
                                        {
                                            $sample_filename=$data["list"][0]->sample;
										}
                                        else{
                                            $sample_ext=pathinfo($_FILES["ebooksample"]["name"],PATHINFO_EXTENSION);
                                            $sample_filename=time()."_ebook_sample.".$sample_ext;
										}
                                        if(empty($_FILES["ebook"]["name"]))
                                        {
                                            $ebook_filename=$data["list"][0]->ebook;
										}
                                        else{
                                            $ebook_ext=pathinfo($_FILES["ebook"]["name"],PATHINFO_EXTENSION);
                                            $ebook_filename=time()."_ebook.".$ebook_ext;
										}
                                        $data_to_update=array(
                                        "category" => $this->input->post("category"),
                                        "author" => $this->input->post("author"),
                                        "name" => $this->input->post("ebookname"),
                                        "logo" => $logo_filename,
                                        "banner" => $banner_filename,
                                        "sample" => $sample_filename,
                                        "ebook" => $ebook_filename,
                                        "type" => $this->input->post("ebooktype"),
                                        "price" => $this->input->post("ebookprice"),
                                        "offerprice" => $this->input->post("ebookofferprice"),
                                        "shortdesc" => $this->input->post("ebookshortdescription"),
                                        "noofpages" => $this->input->post("noofpages"),
                                        "daystofinish" => $this->input->post("daystofinish"),
                                        "discountpercent" => $this->input->post("discountpercentage"),
                                        "offer_text" => $this->input->post("offer_text")
                                        );
                                        $data_to_update = $this->security->xss_clean($data_to_update);
                                        $data_to_update["description"] = $this->input->post("description");
                                        $data_to_update["requirement"] = $this->input->post("requirement");
                                        $data_to_update["ebook_include"] = $this->input->post("ebook_include");
                                        $data_to_update["will_learn"] = $this->input->post("will_learn");
                                        $query=$this->db->where('id',$id)
                                        ->update($table,$data_to_update);
                                        if($query)
                                        {
                                            $upload_errors=array();
                                            $initialize=false;
                                            if(!empty($_FILES["ebooklogo"]["name"]))
                                            {
                                                $config['upload_path'] = './uploads/ebook/';
                                                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                                $config['max_size'] = 100000; // In KB
                                                $config['file_name'] = $logo_filename;
                                                $this->load->library('upload', $config);  
                                                
                                                if(!$this->upload->do_upload('ebooklogo'))
                                                {
                                                    array_push($upload_errors,array('error_upload_logo' => $this->upload->display_errors()));
												}
                                                $initialize=true;
                                                
											}
                                            
                                            if(!empty($_FILES["ebookbanner"]["name"]))
                                            {
                                                $config['upload_path'] = './uploads/ebook/';
                                                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                                $config['max_size'] = 100000; // In KB
                                                $config['file_name'] = $banner_filename;
                                                
                                                if($initialize==true){
                                                    $this->upload->initialize($config);
												}
                                                else{
                                                    $this->load->library('upload', $config); 
												}
                                                
                                                if(!$this->upload->do_upload('ebookbanner'))
                                                {
                                                    array_push($upload_errors,array('error_upload_logo' => $this->upload->display_errors()));
												}
                                                $initialize=true;
											}
                                            if(!empty($_FILES["ebooksample"]["name"]))
                                            {
                                                $config['upload_path'] = './uploads/ebook/';
                                                $config['allowed_types'] = 'pdf';
                                                $config['max_size'] = 100000; // In KB
                                                $config['file_name'] = $sample_filename;
                                                
                                                if($initialize==true){
                                                    $this->upload->initialize($config);
												}
                                                else{
                                                    $this->load->library('upload', $config); 
												}
                                                if(!$this->upload->do_upload('ebooksample'))
                                                {
                                                    array_push($upload_errors,array('error_upload_logo' => $this->upload->display_errors()));
												}
                                                $initialize=true;
											}
                                            
                                            if(!empty($_FILES["ebook"]["name"]))
                                            {
                                                $config['upload_path'] = './uploads/ebook/';
                                                $config['allowed_types'] = 'pdf';
                                                $config['max_size'] = 50000; // In KB
                                                $config['file_name'] = $ebook_filename;
                                                if($initialize==true){
                                                    $this->upload->initialize($config);
												}
                                                else{
                                                    $this->load->library('upload', $config); 
												}
                                                if(!$this->upload->do_upload('ebook'))
                                                {
                                                    array_push($upload_errors,array('error_upload_logo' => $this->upload->display_errors()));
												}
                                                $initialize=true;
											}
                                            
                                            if(count($upload_errors)==0)
                                            {
                                                $this->session->set_flashdata(array('res'=>'success','msg'=>'EBook Updated Successfully.'));
                                                redirect(base_url('Educator/ManageEBooks'));
											}
                                            else
                                            {
                                                $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
                                                $data['upload_errors']=$upload_errors;
                                                redirect(base_url('Educator/ManageEBooks/Edit/'.$id));
											}
										}
                                        else
                                        {
                                            
                                            $this->session->set_flashdata(array('res'=>'error','msg'=>'Something went wrong in Data Shaving.'));
                                            redirect(base_url('Educator/ManageEBooks/Edit/'.$id));
										}
									}
								}
                                else{
                                    redirect(base_url('Educator/ManageEBooks'));
								}
							}
						}
                        else{
                            redirect(base_url('Educator/ManageEBooks'));
						}
					}
                    
				}
                
			}
            else 
            {
                $query = $this->db->where('author',$this->author)->order_by("id", "DESC")->get($table);
                $data["list"] = $query->result();
                $this->load->view("Educator/ManageEBooks", $data);
			}
		}
        
        # Audio-Book Management
        
        public function ManageAudioBooks()
        {
            $table='tbl_abook';
            $categoryresult = $this->db->order_by("id", "ASC")->get('tbl_category');
            $data["categorylist"] = $categoryresult->result();
            
            $tutorresult = $this->db->order_by("id", "ASC")->get('tbl_tutor');
            $data["authorlist"] = $tutorresult->result();
            
            if ($this->uri->segment(3) == TRUE) 
            {
                $action = $this->uri->segment(3);
                if ($this->uri->segment(4) == TRUE) 
                {
                    $id = $this->uri->segment(4);
                    $query = $this->db->where('id', $id)->where('author',$this->author)->get($table);
                    if ($query->num_rows()) 
                    {
                        $data["list"] = $query->result();
                        
                        $data['author']=$this->db->where('id',$data["list"][0]->author)->get('tbl_tutor')->result();
                        $data['category']=$this->db->where('id',$data["list"][0]->category)->get('tbl_category')->result();
                        if($action=='Edit')
                        {
                            $this->load->view("Educator/UpdateAudioBook", $data);
						}
                        else if($action=='Details')
                        {
                            
                            // Find and Add Reviews 
                            $reviewResult=$this->db->where(['itemtype'=>'Abook','itemid'=>$data["list"][0]->id])->get("tbl_review");
                            
                            $reviewData=[];
                            foreach($reviewResult->result() as $review)
                            {
                                $userResult=$this->db->where(['id'=>$review->userid])->get("tbl_registration");
                                if($userResult->num_rows()){
                                    $userValues=$userResult->row();
                                    $reviewData[]=['id'=>$review->id,'status'=>$review->status,'name'=>$userValues->name,'mobile'=>$userValues->number,'profile_photo'=>$userValues->profile_photo,'rating'=>$review->rating,'review'=>$review->review,'date'=>$review->date,'time'=>$review->time];
								}	
							}
                            $data["review"]=$reviewData;
							
							$result=$this->db->where('itemid',$id)->where('itemtype','Abook')->order_by('topic_no','ASC')->get('tbl_topic');
                            $data['topicList']=$result->result();
							
                            $this->load->view("Educator/AudioBookFullDetails", $data);
						}
						else if($action=='AddTopic') 
                        { 
                            
                            $this->form_validation->set_rules('topic_no', 'Topic No', 'required');
                            $this->form_validation->set_rules('name', 'Topic Name', 'required');
                            $this->form_validation->set_rules('itemtype', 'Item Type', 'required');
                            $this->form_validation->set_rules('itemid', 'Item Id', 'required');
                            $this->form_validation->set_rules('type', 'Topic Type', 'required');
                            
                            
							
                            if($this->input->post("type")=='External'){
                                $this->form_validation->set_rules('topic', 'Topic Link', 'required');
							}
                            else
                            { 
                                if(empty($_FILES["topic"]["name"]))
                                { 
                                    $this->form_validation->set_rules('topic', 'Topic PDF ', 'required');
								}
							}
                            
                            if ($this->form_validation->run() == FALSE){
							} 
                            else 
                            {
                                
                                
                                if($this->input->post("type")=='Internal')
                                {
                                    $ext=pathinfo($_FILES["topic"]["name"],PATHINFO_EXTENSION);
                                    $topic=time()."_".$this->input->post("itemtype").".".$ext;
								}
                                else{
                                    $topic=$this->input->post("topic");
								}
                                
                                
                                $data_to_insert= array(
                                "itemid" => $this->input->post("itemid"),
                                "itemtype" => $this->input->post("itemtype"),
                                "topic_no" => $this->input->post("topic_no"),
                                "type" => $this->input->post("type"),
                                "name" => $this->input->post("name"),
                                "topic" => $topic,
                                "description" => $this->input->post("description"),
                                "status" => "true",
                                "date" => $this->date,
                                "time" => $this->time
                                );
                                
                                $data_to_insert = $this->security->xss_clean($data_to_insert);
                                if ($this->db->insert('tbl_topic', $data_to_insert)) 
                                {
                                    
									$this->session->set_flashdata(array('res'=>'success','msg'=>'Topic Added Successfully.'));
									if($this->input->post("type")=='Internal')
									{
										$config['upload_path'] = './uploads/topic/';
                                        $config['allowed_types'] = 'mp3';
                                        $config['max_size'] = 1000000; // In KB
                                        $config['file_name'] = $topic;
                                        $this->load->library('upload', $config);  
                                        $this->upload->do_upload('topic');
										$this->session->set_flashdata(array('res'=>'success','msg'=>'Topic added but error in file upload.'));
									}
								}
                                else 
                                {
                                    $this->session->set_flashdata(array('res'=>'error','msg'=>'Try !Again'));
								}
							}
                            redirect(base_url('Educator/ManageAudioBooks/Details/'.$id));  
						}
                        else
                        {
                            redirect(base_url('Educator/ManageAudioBooks'));
						}
					}
                    else
                    {
                        redirect(base_url('Educator/ManageAudioBooks'));
					}
				}
                else 
                {
                    if($action=='Add'){
                        if (isset($_POST["addaction"])) 
                        {    
                            $this->form_validation->set_rules('abookname', 'abook Name', 'required|is_unique[tbl_abook.name]', array(
                            'required' => '%s is Required Field'
                            ));
                            $this->form_validation->set_rules('category', 'Category', 'required');
                            $this->form_validation->set_rules('author', 'Author', 'required');
                            $this->form_validation->set_rules('abooktype', 'abook Type', 'required');
                            $this->form_validation->set_rules('abookprice', 'abook Price', 'required');
                            $this->form_validation->set_rules('abookshortdescription', 'Short Description', 'required');
                            // $this->form_validation->set_rules('noofpages', 'No of Pages', 'required');
                            // $this->form_validation->set_rules('daystofinish', 'Days to Dinish', 'required');
                            // $this->form_validation->set_rules('description', 'Description', 'required');
                            // $this->form_validation->set_rules('requirement', 'Requirements', 'required');
                            // $this->form_validation->set_rules('abook_include', 'What this abook include ?', 'required');
                            // $this->form_validation->set_rules('will_learn', 'What you will learn ?', 'required');
                            if (empty($_FILES["abooklogo"]["name"])) {
                                $this->form_validation->set_rules('abooklogo', 'abook Logo/Icon', 'required');
							}
                            if (empty($_FILES["abookbanner"]["name"])) {
                                $this->form_validation->set_rules('abookbanner', 'abook Banner', 'required');
							}
                            // if (empty($_FILES["abooksample"]["name"])) {
                            // $this->form_validation->set_rules('abooksample', 'abook Sample', 'required');
                            // }
                            if (empty($_FILES["abook"]["name"])) {
                                // $this->form_validation->set_rules('abook', 'Abook Audio File', 'required');
							}
                            if ($this->form_validation->run() == FALSE){
                                redirect(base_url('Educator/ManageAudioBooks/Add'));
							} 
                            else 
                            {
                                $logo_ext      = pathinfo($_FILES["abooklogo"]["name"], PATHINFO_EXTENSION);
                                $logo_filename = time() . "_abook_logo." . $logo_ext;
                                
                                $banner_ext      = pathinfo($_FILES["abookbanner"]["name"], PATHINFO_EXTENSION);
                                $banner_filename = time() . "_abook_banner." . $banner_ext;
                                
                                // $sample_ext      = pathinfo($_FILES["abooksample"]["name"], PATHINFO_EXTENSION);
                                // $sample_filename = time() . "_abook_sample." . $sample_ext;
                                
                                $abook_ext      = pathinfo($_FILES["abook"]["name"], PATHINFO_EXTENSION);
                                $abook_filename = time() . "_abook." . $abook_ext;
                                
                                $data_to_insert                = array(
                                "category" => $this->input->post("category"),
                                "author" => $this->input->post("author"),
                                "name" => $this->input->post("abookname"),
                                "logo" => $logo_filename,
                                "banner" => $banner_filename,
                                // "sample" => $sample_filename,
                                "abook" => $abook_filename,
                                "type" => $this->input->post("abooktype"),
                                "price" => $this->input->post("abookprice"),
                                "offerprice" => $this->input->post("abookofferprice"),
                                "shortdesc" => $this->input->post("abookshortdescription"),
                                // "noofpages" => $this->input->post("noofpages"),
                                // "daystofinish" => $this->input->post("daystofinish"),
                                "offer_text" => $this->input->post("offer_text"),
                                "apprstatus" => "false",
                                "discountpercent" => $this->input->post("discountpercentage"),
                                "date" => $this->date,
                                "time" => $this->time
                                );
                                $data_to_insert                = $this->security->xss_clean($data_to_insert);
                                $data_to_insert["description"] = $this->input->post("description");
                                // $data_to_insert["requirement"] = $this->input->post("requirement");
                                // $data_to_insert["abook_include"] = $this->input->post("abook_include");
                                // $data_to_insert["will_learn"] = $this->input->post("will_learn");
                                
                                if ($this->db->insert($table, $data_to_insert)) {
                                    $upload_errors           = array();
                                    #Upload Logo
                                    $config['upload_path']   = './uploads/abook/';
                                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                    $config['max_size']      = 100000; // In KB
                                    $config['file_name']     = $logo_filename;
                                    $this->load->library('upload', $config);
                                    if (!$this->upload->do_upload('abooklogo')) {
                                        array_push($upload_errors, array(
                                        'error_upload_logo' => $this->upload->display_errors()
                                        ));
									}
                                    
                                    $config['upload_path']   = './uploads/abook/';
                                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                    $config['max_size']      = 100000; // In KB
                                    $config['file_name']     = $banner_filename;
                                    $this->upload->initialize($config);
                                    if (!$this->upload->do_upload('abookbanner')) {
                                        array_push($upload_errors, array(
                                        'error_upload_logo' => $this->upload->display_errors()
                                        ));
									}
                                    
                                    // $config['upload_path']   = './uploads/abook/';
                                    // $config['allowed_types'] = 'pdf';
                                    // $config['max_size']      = 100000; // In KB
                                    // $config['file_name']     = $sample_filename;
                                    // $this->upload->initialize($config);
                                    // if (!$this->upload->do_upload('abooksample')) {
                                    // array_push($upload_errors, array(
                                    // 'error_upload_logo' => $this->upload->display_errors()
                                    // ));
                                    // }
                                    if (!empty($_FILES["abook"]["name"])) {
										$config['upload_path']   = './uploads/abook/';
										$config['allowed_types'] = 'mp3';
										$config['max_size']      = 50000; // In KB
										$config['file_name']     = $abook_filename;
										$this->upload->initialize($config);
										if (!$this->upload->do_upload('abook')) {
											array_push($upload_errors, array(
											'error_upload_logo' => $this->upload->display_errors()
											));
										}
									}
                                    
                                    
                                    if (count($upload_errors) == 0) 
                                    {
                                        $this->session->set_flashdata(array('res'=>'success','msg'=>'Audio Book Added Successfully.'));
                                        redirect(base_url('Educator/ManageAudioBooks/Add'));
									} 
                                    else 
                                    {
                                        $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
                                        redirect(base_url('Educator/ManageAudioBooks/Add'));
									}
								}
                                else
                                {
                                    $this->session->set_flashdata(array('res'=>'error','msg'=>'Something went wrong in Data Shaving.'));
                                    redirect(base_url('Educator/ManageAudioBooks/Add'));
								}
							}
						}
                        else
                        {
                            $this->load->view("Educator/AddAudioBook.php",$data);
						}
					}
                    else if($action=='Update')
                    {
                        if (isset($_POST["updateaction"])) 
                        {  
                            if(empty($this->input->post("id")))
                            {
                                $this->session->set_flashdata(array('res'=>'error','msg'=>'ID is required.'));
                                redirect(base_url('Educator/ManageAudioBooks/Edit/'.$id));
							} 
                            else
                            {
                                $query = $this->db->where('id', $this->input->post("id"))->get($table);
                                if ($query->num_rows()) 
                                {
                                    $data['list']=$query->result();
                                    $id=$data['list'][0]->id;
                                    $this->form_validation->set_rules('abookname', 'abook Name', 'required',array('required'=>'%s is Required Field'));
                                    $this->form_validation->set_rules('category', 'Category', 'required');
                                    $this->form_validation->set_rules('author', 'Author', 'required');
                                    $this->form_validation->set_rules('abooktype', 'abook Type', 'required');
                                    $this->form_validation->set_rules('abookprice', 'abook Price', 'required');
                                    $this->form_validation->set_rules('abookshortdescription', 'Short Description', 'required');
                                    // $this->form_validation->set_rules('noofpages', 'No of Pages', 'required');
                                    // $this->form_validation->set_rules('daystofinish', 'Days to Dinish', 'required');
                                    // $this->form_validation->set_rules('description', 'Description', 'required');
                                    // $this->form_validation->set_rules('requirement', 'Requirements', 'required');
                                    // $this->form_validation->set_rules('abook_include', 'What this abook include ?', 'required');
                                    // $this->form_validation->set_rules('will_learn', 'What you will learn ?', 'required');
                                    if ($this->form_validation->run() == FALSE)
                                    {
                                        $this->session->set_flashdata(array('res'=>'error','msg'=>'ID is required.'));
                                        redirect(base_url('Educator/ManageAudioBooks/Edit/'.$id));
									}
                                    else{
                                        if(empty($_FILES["abooklogo"]["name"]))
                                        {
                                            $logo_filename=$data["list"][0]->logo;
										}
                                        else{
                                            $logo_ext=pathinfo($_FILES["abooklogo"]["name"],PATHINFO_EXTENSION);
                                            $logo_filename=time()."_abook_logo.".$logo_ext;
										}
                                        if(empty($_FILES["abookbanner"]["name"]))
                                        {
                                            $banner_filename=$data["list"][0]->banner;
										}
                                        else{
                                            $banner_ext=pathinfo($_FILES["abookbanner"]["name"],PATHINFO_EXTENSION);
                                            $banner_filename=time()."_abook_banner.".$banner_ext;
										}
                                        // if(empty($_FILES["abooksample"]["name"]))
                                        // {
                                        // $sample_filename=$data["list"][0]->sample;
                                        // }
                                        // else{
                                        // $sample_ext=pathinfo($_FILES["abooksample"]["name"],PATHINFO_EXTENSION);
                                        // $sample_filename=time()."_abook_sample.".$sample_ext;
                                        // }
                                        if(empty($_FILES["abook"]["name"]))
                                        {
                                            $abook_filename=$data["list"][0]->abook;
										}
                                        else{
                                            $abook_ext=pathinfo($_FILES["abook"]["name"],PATHINFO_EXTENSION);
                                            $abook_filename=time()."_abook.".$abook_ext;
										}
                                        $data_to_update=array(
                                        "category" => $this->input->post("category"),
                                        "author" => $this->input->post("author"),
                                        "name" => $this->input->post("abookname"),
                                        "logo" => $logo_filename,
                                        "banner" => $banner_filename,
                                        // "sample" => $sample_filename,
                                        "abook" => $abook_filename,
                                        "type" => $this->input->post("abooktype"),
                                        "price" => $this->input->post("abookprice"),
                                        "offerprice" => $this->input->post("abookofferprice"),
                                        "shortdesc" => $this->input->post("abookshortdescription"),
                                        // "noofpages" => $this->input->post("noofpages"),
                                        // "daystofinish" => $this->input->post("daystofinish"),
                                        "discountpercent" => $this->input->post("discountpercentage"),
                                        "offer_text" => $this->input->post("offer_text")
                                        );
                                        $data_to_update = $this->security->xss_clean($data_to_update);
                                        $data_to_update["description"] = $this->input->post("description");
                                        // $data_to_update["requirement"] = $this->input->post("requirement");
                                        // $data_to_update["abook_include"] = $this->input->post("abook_include");
                                        // $data_to_update["will_learn"] = $this->input->post("will_learn");
                                        $query=$this->db->where('id',$id)
                                        ->update($table,$data_to_update);
                                        if($query)
                                        {
                                            $upload_errors=array();
                                            $initialize=false;
                                            if(!empty($_FILES["abooklogo"]["name"]))
                                            {
                                                $config['upload_path'] = './uploads/abook/';
                                                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                                $config['max_size'] = 100000; // In KB
                                                $config['file_name'] = $logo_filename;
                                                $this->load->library('upload', $config);  
                                                
                                                if(!$this->upload->do_upload('abooklogo'))
                                                {
                                                    array_push($upload_errors,array('error_upload_logo' => $this->upload->display_errors()));
												}
                                                $initialize=true;
                                                
											}
                                            
                                            if(!empty($_FILES["abookbanner"]["name"]))
                                            {
                                                $config['upload_path'] = './uploads/abook/';
                                                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                                $config['max_size'] = 100000; // In KB
                                                $config['file_name'] = $banner_filename;
                                                
                                                if($initialize==true){
                                                    $this->upload->initialize($config);
												}
                                                else{
                                                    $this->load->library('upload', $config); 
												}
                                                
                                                if(!$this->upload->do_upload('abookbanner'))
                                                {
                                                    array_push($upload_errors,array('error_upload_logo' => $this->upload->display_errors()));
												}
                                                $initialize=true;
											}
                                            // if(!empty($_FILES["abooksample"]["name"]))
                                            // {
                                            // $config['upload_path'] = './uploads/abook/';
                                            // $config['allowed_types'] = 'pdf';
                                            // $config['max_size'] = 100000; // In KB
                                            // $config['file_name'] = $sample_filename;
                                            
                                            // if($initialize==true){
                                            // $this->upload->initialize($config);
                                            // }
                                            // else{
                                            // $this->load->library('upload', $config); 
                                            // }
                                            // if(!$this->upload->do_upload('abooksample'))
                                            // {
                                            // array_push($upload_errors,array('error_upload_logo' => $this->upload->display_errors()));
                                            // }
                                            // $initialize=true;
                                            // }
                                            
                                            if(!empty($_FILES["abook"]["name"]))
                                            {
                                                $config['upload_path'] = './uploads/abook/';
                                                $config['allowed_types'] = 'mp3';
                                                $config['max_size'] = 50000; // In KB
                                                $config['file_name'] = $abook_filename;
                                                if($initialize==true){
                                                    $this->upload->initialize($config);
												}
                                                else{
                                                    $this->load->library('upload', $config); 
												}
                                                if(!$this->upload->do_upload('abook'))
                                                {
                                                    array_push($upload_errors,array('error_upload_logo' => $this->upload->display_errors()));
												}
                                                $initialize=true;
											}
                                            
                                            if(count($upload_errors)==0)
                                            {
                                                $this->session->set_flashdata(array('res'=>'success','msg'=>'Audio Book Updated Successfully.'));
                                                redirect(base_url('Educator/ManageAudioBooks'));
											}
                                            else
                                            {
                                                $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
                                                $data['upload_errors']=$upload_errors;
                                                redirect(base_url('Educator/ManageAudioBooks/Edit/'.$id));
											}
										}
                                        else
                                        {
                                            
                                            $this->session->set_flashdata(array('res'=>'error','msg'=>'Something went wrong in Data Shaving.'));
                                            redirect(base_url('Educator/ManageAudioBooks/Edit/'.$id));
										}
									}
								}
                                else{
                                    redirect(base_url('Educator/ManageAudioBooks'));
								}
							}
						}
                        else{
                            redirect(base_url('Educator/ManageAudioBooks'));
						}
					}
                    
				}
                
			}
            else 
            {
                $query = $this->db->where('author',$this->author)->order_by("id", "DESC")->get($table);
                $data["list"] = $query->result();
                $this->load->view("Educator/ManageAudioBooks", $data);
			}
		}
        
        
        # App Live Video
        
        public function ManageLiveVideo()
        {
            $table='tbl_live_video';
            
            if ($this->uri->segment(3) == TRUE) 
            {
                $action = $this->uri->segment(3);
                if ($this->uri->segment(4) == TRUE) 
                {
                    $id = $this->uri->segment(4);
                    $query = $this->db->where('id', $id)->where('author',$this->author)->get($table);
                    if ($query->num_rows()) 
                    {
                        $data["list"] = $query->result();
                        $data['author']=$this->db->where('status','true')->get('tbl_tutor')->result();
                        if($action=='Edit'){
                            $data["action"]="EditLiveVideo";
                            $this->load->view("Educator/Modal", $data);
						}
                        else if($action=='StartLiveSession'){
                            $data["action"]="StartLiveSession";
                            $this->load->view("Educator/Modal", $data);
						}
                        else if($action=='EndLiveSession'){
                            $data["action"]="EndLiveSession";
                            $this->load->view("Educator/Modal", $data);
						}
                        else if($action=='Joined'){
                            $data["action"]="Joined";
                            $data['liveJoined']=$this->db->where('liveid',$data["list"][0]->id)->get('tbl_live_join')->result();
                            $this->load->view("Educator/ManageLiveVideo", $data);
						}
						else if($action=='Questions')
                        {
                            $data["action"]="Questions";
                            
                            $result2=$this->db->where(['liveid'=>$id])->get('tbl_live_question');
                            $questions=[];
                            if($result2->num_rows()){
                                
                                
                                $k=0;
                                foreach($result2->result() as $question){
                                    
                                    $result3 = $this->db->where(['questionid'=>$question->id])->get('tbl_live_reply');
                                    if($result3->num_rows()){
                                        $reply_status='true';
                                        
                                        $l=0;
                                        $reply=[];
                                        foreach($result3->result() as $rep){
                                            $reply[$l]=$rep;
                                            if($rep->usertype=='Admin'){
                                                $name='Karmasu';
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
                            
                            $data['questions']=$questions;
                            $this->load->view("Educator/ManageLiveVideo", $data);
                        }
                        else if($action=='Certificate')
                        {
                            $data['name']='Karmasu';
                            $data['training']='Karmasu';
                            $data['technology']='Karmasu';
                            $data['grade']='A++';
                            $data['duration']='45 Days';
                            $data['from']=$this->date;
                            $data['to']=$this->date;
                            $data['refno']='DCT2021';
                            $data['enroll_id']='DCT2021';
                            $data['issuedon']=$this->date;
                            $this->load->view("Certificate/".$data["list"][0]->certificate, $data);
                            
						}
                        else
                        {
                            redirect(base_url('Educator/ManageLiveVideo'));
						}
					}
                    else
                    {
                        redirect(base_url('Educator/ManageLiveVideo'));
					}
				}
                else 
                {
                    if($action=='Add')
                    {
                        if (isset($_POST["addaction"])) 
                        {    
                            $this->form_validation->set_rules('tags', 'Tags', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('subject', 'Subject', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('title', 'Title', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('author', 'Author', 'required', array('required' => '%s is Required Field'));
                            // $this->form_validation->set_rules('link', 'Link ', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('timing', 'Timing', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('duration', 'Duration', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('description', 'Description', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('certificationcheck', 'Certification', 'required');
                            if (empty($_FILES["thumbnail"]["name"])) {
                                $this->form_validation->set_rules('thumbnail', 'Thumbnail', 'required');
							}
                            else{
                                $ext      = pathinfo($_FILES["thumbnail"]["name"], PATHINFO_EXTENSION);
                                $filename = time().rand(). "." . $ext;
							}
                            
                            if ($this->form_validation->run() == FALSE){
							} 
                            else 
                            {
                                if($this->input->post("certificationcheck")=='No'){
                                    $certificate='';
                                    $certificate_charge='';
                                    $km_charge='';
								}
                                else{
                                    $certificate=$this->input->post("certificate");
                                    $certificate_charge=$this->input->post("certificate_charge");
                                    $km_charge=$this->input->post("km_charge");
								}
                                $data_to_insert= array(
                                "thumbnail" => $filename,
                                "subject" =>strtoupper($this->input->post("subject")),
                                "tags" =>strtoupper($this->input->post("tags")),
                                "title" => $this->input->post("title"),
                                "author" => $this->input->post("author"),
                                "link" => $this->input->post("link"),
                                "timing" => $this->input->post("timing"),
                                "duration" => $this->input->post("duration"),
                                "userid" => $this->input->post("userid"),
                                "password" => $this->input->post("password"),
                                "certification" => $this->input->post("certificationcheck"),
								"certificate" => $certificate,
								"certificate_charge" => $certificate_charge,
								"km_charge" => $km_charge,
                                "description" => $this->input->post("description"),
                                "status" => "false",
                                "date" => $this->date,
                                "time" => $this->time
                                );
                                $data_to_insert = $this->security->xss_clean($data_to_insert);
                                if ($this->db->insert($table, $data_to_insert)) {
                                    $upload_errors           = array();
                                    $config['upload_path']   = './uploads/live_video/';
                                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                    $config['max_size']      = 100000;
                                    $config['file_name']     = $filename;
                                    $this->load->library('upload', $config);
                                    if (!$this->upload->do_upload('thumbnail')) {
                                        array_push($upload_errors, array(
                                        'error_upload_logo' => $this->upload->display_errors()
                                        ));
                                        $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
									}
                                    else{
                                        $this->session->set_flashdata(array('res'=>'success','msg'=>'Live Session Added Successfully.'));
									}
								}
                                else 
                                {
                                    $this->session->set_flashdata(array('res'=>'error','msg'=>'Something went wrong in Data Shaving.'));
								}
							}
						}
					}
                    else if($action=='Update'){
                        if (isset($_POST["updateaction"])) 
                        {  
                            if(empty($this->input->post("id")))
                            {
                                $this->session->set_flashdata(array('res'=>'error','msg'=>'ID is required.'));
							} 
                            else
                            {
                                $query = $this->db->where('id', $this->input->post("id"))->get($table);
                                if ($query->num_rows()) 
                                {
                                    $data['list']=$query->result();
                                    
                                    $this->form_validation->set_rules('tags', 'Tags', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('subject', 'Subject', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('title', 'Title', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('author', 'Author', 'required', array('required' => '%s is Required Field'));
                                    // $this->form_validation->set_rules('link', 'Link ', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('timing', 'Timing', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('duration', 'Duration', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('description', 'Description', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('certificationcheck', 'Certification', 'required');
                                    if ($this->form_validation->run() == FALSE){
									} 
                                    else 
                                    {
                                        $old_filename=$data['list'][0]->thumbnail;
                                        $filename=$old_filename;
                                        if (!empty($_FILES["thumbnail"]["name"])) {
                                            $ext      = pathinfo($_FILES["thumbnail"]["name"], PATHINFO_EXTENSION);
                                            $filename = time().rand(). "." . $ext;
										}  
                                        if($this->input->post("certificationcheck")=='No'){
                                            $certificate='';
                                            $certificate_charge='';
                                            $km_charge='';
										}
                                        else{
                                            $certificate=$this->input->post("certificate");
                                            $certificate_charge=$this->input->post("certificate_charge");
                                            $km_charge=$this->input->post("km_charge");
										}
                                        $data_to_update= array(
                                        "thumbnail" => $filename,
                                        "tags" =>strtoupper($this->input->post("tags")),
                                        "subject" =>strtoupper($this->input->post("subject")),
                                        "title" => $this->input->post("title"),
                                        "author" => $this->input->post("author"),
                                        "link" => $this->input->post("link"),
                                        "timing" => $this->input->post("timing"),
                                        "duration" => $this->input->post("duration"),
                                        "userid" => $this->input->post("userid"),
                                        "password" => $this->input->post("password"),
                                        "certification" => $this->input->post("certificationcheck"),
                                        "certificate" => $certificate,
                                        "certificate_charge" => $certificate_charge,
                                        "km_charge" => $km_charge,
                                        "description" => $this->input->post("description"),
                                        );
                                        $data_to_update = $this->security->xss_clean($data_to_update);
                                        $result=$this->db->where('id',$data['list'][0]->id)
                                        ->update($table,$data_to_update);
                                        
                                        if($result) 
                                        {
                                            $this->session->set_flashdata(array('res'=>'success','msg'=>'Live Session Updated Successfully.')); 
                                            if (!empty($_FILES["thumbnail"]["name"])) {
                                                $upload_errors           = array();
                                                $config['upload_path']   = './uploads/live_video/';
                                                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                                $config['max_size']      = 100000;
                                                $config['file_name']     = $filename;
                                                $this->load->library('upload', $config);
                                                if (!$this->upload->do_upload('thumbnail')) {
                                                    array_push($upload_errors, array(
                                                    'error_upload_logo' => $this->upload->display_errors()
                                                    ));
                                                    $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
												}
                                                unlink('./uploads/live_video/'.$old_filename);
											}
										}
                                        else 
                                        {
                                            $this->session->set_flashdata(array('res'=>'error','msg'=>'Something went wrong in Data Shaving.'));
										}
									}
								}
							}
						}
					}
                    else if($action=='StartLiveSession')
                    {
                        if (isset($_POST["updateaction1"])) 
                        {  
                            if(empty($this->input->post("id")))
                            {
                                $this->session->set_flashdata(array('res'=>'error','msg'=>'ID is required.'));
							} 
                            else
                            {
                                $query = $this->db->where('id', $this->input->post("id"))->get($table);
                                if ($query->num_rows()) 
                                {
                                    $data['list']=$query->result();
                                    
                                    $this->form_validation->set_rules('link', 'Link ', 'required', array('required' => '%s is Required Field'));
                                    if ($this->form_validation->run() == FALSE){
									} 
                                    else 
                                    {
                                        $getYoutubeLinkData=$this->Auth_model->getYoutubeLinkData($this->input->post("link"));
                                        $_POST['link']=$getYoutubeLinkData->embedUrl;
                                        
                                        $data_to_update= array(
                                        "link" => $this->input->post("link"),
                                        "userid" => $this->input->post("userid"),
                                        "password" => $this->input->post("password"),
                                        "notification_title" => $this->input->post("notification_title"),
                                        "notification_message" => $this->input->post("notification_message"),
                                        "session_status" => 'Started',
                                        "started_at" => $this->data->timestamp
                                        );
                                        $data_to_update = $this->security->xss_clean($data_to_update);
                                        $result=$this->db->where('id',$data['list'][0]->id)
                                        ->update($table,$data_to_update);
                                        
                                        if($result) 
                                        {
                                            $image_url=base_url('uploads/live_video/'.$data['list'][0]->thumbnail);
                                            $id=$this->input->post("id");
                                            $type='LiveSession';
                                            $click_action=$this->firebaseActivities[$type];
                                            
                                            #Send Notification 
                                            $jquery = $this->db->where('liveid', $this->input->post("id"))->get('tbl_live_join');
                                            
                                            foreach($jquery->result() as $user)
                                            {
                                                $uresult=$this->db->where('userid',$user->userid)->get('tbl_apptoken');
                                                if($uresult->num_rows())
                                                {
                                                    
                                                    $alltoken=array();
                                                    $alluser=array();
                                                    
                                                    foreach($uresult->result() as $item)
                                                    {
                                                        $alltoken[]=$item->token;
                                                        $alluser[]=$item->userid;
													}
                                                    
                                                    $start=0;
                                                    while($start<count($alltoken))
                                                    {
                                                        $sendtoken=array_slice($alltoken,$start,$start+999);
                                                        
                                                        $return=$this->codersadda->send_notification_multiple($this->input->post("notification_message"),$this->input->post("notification_title"),$sendtoken,$image_url,$click_action,$id,$type);
                                                        $start=$start+999;
													}
                                                    $user_id=implode(',',$alluser);
												}
											}
                                            
                                            $this->session->set_flashdata(array('res'=>'success','msg'=>'Live Session Started.')); 
										}
                                        else 
                                        {
                                            $this->session->set_flashdata(array('res'=>'error','msg'=>'Try ! Again.'));
										}
									}
								}
							}
						}
					}
                    else if($action=='EndLiveSession')
                    {
                        if (isset($_POST["updateaction2"])) 
                        {  
                            if(empty($this->input->post("id")))
                            {
                                $this->session->set_flashdata(array('res'=>'error','msg'=>'ID is required.'));
							} 
                            else
                            {
                                $query = $this->db->where('id', $this->input->post("id"))->get($table);
                                if ($query->num_rows()) 
                                {
                                    $data['list']=$query->result();
                                    
                                    $data_to_update= array(
                                    "remarks" => $this->input->post("remarks"),
                                    "session_status" => 'Ended',
                                    "ended_at" => $this->data->timestamp
                                    );
                                    $data_to_update = $this->security->xss_clean($data_to_update);
                                    $result=$this->db->where('id',$data['list'][0]->id)
                                    ->update($table,$data_to_update);
                                    
                                    if($result) 
                                    {
                                        $this->session->set_flashdata(array('res'=>'success','msg'=>'Live Session Ended.')); 
									}
                                    else 
                                    {
                                        $this->session->set_flashdata(array('res'=>'error','msg'=>'Try ! Again.'));
									}
								}
							}
						}
					}
                    redirect(base_url('Educator/ManageLiveVideo')); 
				}
			}
            else 
            {
				$query = $this->db->where('author',$this->author)->order_by("id", "DESC")->get($table);
                $data["list"] = $query->result();
                $data['authorlist']=$this->db->where('status','true')->get('tbl_tutor')->result();
                if($query->num_rows()){
                    $return=[];
                    foreach ($data["list"] as $live_video){
                        $return[$live_video->id]=$live_video;
                        $return[$live_video->id]->author=$this->db->where('id',$live_video->author)->get('tbl_tutor')->result();
					}
					$data["list"]=$return;
				}
				$this->load->view("Educator/ManageLiveVideo", $data);
			}
		}
        
        public function ManageSubjects()
        {
            $table='tbl_subject';
            if ($this->uri->segment(3) == TRUE) 
            {
                $action = $this->uri->segment(3);
                if ($this->uri->segment(4) == TRUE) 
                {
                    $id = $this->uri->segment(4);
                    $query = $this->db->where('id', $id)->get($table);
                    if ($query->num_rows()) 
                    {
                        $data["list"] = $query->result();
                        if($action=='Edit'){
                            $data["action"]="EditSubject";
                            $this->load->view("Educator/Modal", $data);
						}
                        else if($action=='VideosList'){
                            $data["action"]="VideosList";
                            $data["videoslist"] =$this->db->where('subject', $id)->get('tbl_video')->result();
                            $this->load->view("Educator/Modal", $data);
						}
                        else
                        {
                            redirect(base_url('Educator/ManageSubjects'));
						}
					}
                    else
                    {
                        redirect(base_url('Educator/ManageSubjects')); 
					}
				}
                else 
                {
                    
                    if($action=='QuestionsList')
					{
						$output['res']='error';
						$output['msg']='error';
						if(!empty($this->input->post('ids'))){
							$ids=$this->input->post('ids');
							if(!empty($this->input->post('weeks')))
							{
								$weeks=$this->input->post('weeks');
								$data["action"]="QuestionsList";
								$query=$this->db->where('status','true')->where_in('subject_id',$ids)->where_in('week',$weeks)->get('tbl_questions');
								if($query->num_rows()){
									$output['res']='success';
									$output["data"]=$query->result();
								}
								else{
									$output['msg']='No Questions Found.';
								}
							}
							else{
								$output['msg']='Please Choose Week Bucket.';
							}
						}
						else{
							$output['msg']='Please Choose Subjects.';
						}
						echo json_encode([$output]);
					}
				}
			}
		}
		
        # Profile Management
        
        public function Profile()
        {
            $admin_id=$this->author;
            $query = $this->db->where('id',$admin_id)->order_by("id", "DESC")->get('tbl_tutor');
            $data["profile"] = $query->row();
            
            $w_day = date('w');
            $week_start = date('Y-m-d', strtotime('-'.$w_day.' days'));
            $week_end =date('Y-m-d', strtotime('+'.(6-$w_day).' days'));
            $query1 = $this->db->where('LoginID="'.$admin_id.'" AND date BETWEEN "'.$week_start. '" AND "'.$week_end.'"')->order_by("LoginDetailsID ", "DESC")->get('tbl_educatorlogindetails');
            $data["login_details"] = $query1->result();
            
            $query1 = $this->db->where('LoginID',$admin_id)->order_by("LoginDetailsID ", "DESC")->get('tbl_educatorlogindetails');
            $data["login_activities"] = $query1->result();
            
            if($this->uri->segment(3)==TRUE and $this->uri->segment(3)=='LoginActivities'){
                $this->load->view("Educator/LoginActivities", $data);
			}
            else{
                $this->load->view("Educator/Profile", $data);
			}
		}
        
        
        # Settings
        
        public function Settings()
        {
            $admin_id=$this->author;
            
            if ($this->uri->segment(3) == TRUE) 
            {
                $action = $this->uri->segment(3);
                if($action=='ChangePassword')
                {
                    if (isset($_POST["addaction"])) 
                    {    
                        $this->form_validation->set_rules('opass', 'Current Password', 'required');
                        $this->form_validation->set_rules('npass', 'New Password', 'required');
                        $this->form_validation->set_rules('cpass', 'Confirm Password', 'required');
                        if ($this->form_validation->run() == TRUE){
                            $opass=$this->input->post('opass');
                            $npass=$this->input->post('npass');
                            $cpass=$this->input->post('cpass');
                            $result=$this->db->where('id',$admin_id)->get('tbl_tutor');
                            $values=$result->row();
                            if($values->password==$opass)
                            {
                                if($npass==$cpass)
                                {
                                    $result=$this->db->where('id',$admin_id)->update('tbl_tutor',array('password'=>$npass));
                                    if($result){
                                        $this->session->set_flashdata(array('res'=>'success','msg'=>'Password Changed.'));
									}
                                    else{
                                        $this->session->set_flashdata(array('res'=>'erorr','msg'=>'Failed'));
									}
								}
                                else
                                {
                                    $this->session->set_flashdata(array('res'=>'error','msg'=>'New and Confirm Password are not match.'));
								}
							}
                            else
                            {
                                $this->session->set_flashdata(array('res'=>'error','msg'=>'Invalid Current Password'));
							}
						}
					}
                    redirect(base_url('Educator/Settings'));
				}
				else if($action=='UpdateProfile')
                {
                    // $this->form_validation->set_rules('about', 'About Bio', 'required');
                    // $this->form_validation->set_rules('studied_at', 'Studied At', 'required');
                    // $this->form_validation->set_rules('award', 'Certifications', 'required');
                    // $this->form_validation->set_rules('lives_in', 'Lives In', 'required');
                    // $this->form_validation->set_rules('birthday', 'Birthday', 'required');
                    // $this->form_validation->set_rules('language_known', 'Language Known', 'required');
                    // $this->form_validation->set_rules('skills', 'Skills', 'required');
					
					if ($this->form_validation->run() == FALSE)
					{
						if(empty($_FILES["photo"]["name"]))
						{
							$filename=$this->AuthorData->photo;
						}
						else{
							$ext=pathinfo($_FILES["photo"]["name"],PATHINFO_EXTENSION);
							$filename=time()."_abook.".$ext;
						}
						
						$updateData=[
						'photo'=>$filename,
						'about'=>$this->input->post('about'),
						'studied_at'=>$this->input->post('studied_at'),
						'award'=>$this->input->post('award'),
						'lives_in'=>$this->input->post('lives_in'),
						'birthday'=>$this->input->post('birthday'),
						'language_known'=>$this->input->post('language_known'),
						'skills'=>$this->input->post('skills')
						];
						
						$result=$this->db->where('id',$this->AuthorData->id)->update('tbl_tutor',$updateData);
						if($result){
							$this->session->set_flashdata(array('res'=>'success','msg'=>'Profile Updated'));
							if (!empty($_FILES["photo"]["name"])) {
								$upload_errors           = array();
								$config['upload_path']   = './uploads/tutor/';
								$config['allowed_types'] = 'gif|jpg|png|jpeg';
								$config['max_size']      = 10000;
								$config['file_name']     = $filename;
								$this->load->library('upload', $config);
								if (!$this->upload->do_upload('photo')) {
									array_push($upload_errors, array(
									'error_logo' => $this->upload->display_errors()
									));
									$this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
								}
							}
						}
						else{
							$this->session->set_flashdata(array('res'=>'error','msg'=>'Failed'));
						}
						
					}
					
                    redirect(base_url('Educator/Settings'));
				}
                else
                {
                    redirect(base_url('Educator/Settings'));
				}
                
			}
            else
            {
                $query = $this->db->where('id',$admin_id)->order_by("id", "DESC")->get('tbl_tutor');
                $data["profile"] = $query->row();
                
                $query1 = $this->db->where('LoginID',$admin_id)->order_by("LoginDetailsID ", "DESC")->get('tbl_educatorlogindetails');
                $data["login_details"] = $query1->result();
                
                $this->load->view("Educator/Settings", $data);
			}
            
		}
        
        # Course Enrollment
        public function CourseEnrollments()
        {
            $table='tbl_enroll';
			$educatorCourses=$this->Auth_model->educatorCourses($this->author);
			$query = $this->db->where(['paymentstatus'=>'success','itemtype'=>'Course','educator_status'=>'true'])->where_in('itemid',$educatorCourses)->get($table);
			$data["list"] = $query->result();
			$i=0;
			foreach ($data["list"] as $enroll)
			{
				$return[$i]=$enroll;
				$return[$i]->item=$this->db->where('id',$enroll->itemid)->get('tbl_course')->row();	
				$i++;
			}  
			$this->load->view("Educator/CourseEnrollments", $data);
		}
        
        #Ebook Enrollment
        
        public function EBookEnrollments()
        {
            $table='tbl_enroll';
			$educatorEBooks=$this->Auth_model->educatorEBooks($this->author);
			$query = $this->db->where(['paymentstatus'=>'success','itemtype'=>'Ebook','educator_status'=>'true'])->where_in('itemid',$educatorEBooks)->get($table);
			$data["list"] = $query->result();
			$this->load->view("Educator/EBookEnrollments", $data);
		}
        
        #Abook Enrollment
        
        public function ABookEnrollments() 
        {
			$table='tbl_enroll';
			$educatorABooks=$this->Auth_model->educatorABooks($this->author);
			$query = $this->db->where(['paymentstatus'=>'success','itemtype'=>'Ebook','educator_status'=>'true'])->where_in('itemid',$educatorABooks)->get($table);
			$data["list"] = $query->result();
			$this->load->view("Educator/ABookEnrollments", $data);
		}
        
        
        
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
        
        #Video Playlist
		
		public function VideoPlaylist()
		{
			if(($this->uri->segment(3) == TRUE) and $this->uri->segment(4) == TRUE) 
			{
				$courseid=$this->uri->segment(3);
				$videoid=$this->uri->segment(4);
				
				$result=$this->db->where(['id'=>$courseid])->where(['author'=>$this->author])->get('tbl_course');
				if($result->num_rows())
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
                            $return[$i]->course->author = $this->db->where(['id'=>$return[$i]->course->author])->get('tbl_tutor')->row();
                            $return[$i]->video = $this->db->where(['id'=>$videoid])->get('tbl_video')->row();
                            $return[$i]->video->subjectdetails = $this->db->where(['id'=>$return[$i]->video->subject])->get('tbl_subject')->row();
                            $return[$i]->assignment = $this->db->where(['video'=>$videoid])->get('tbl_video_assignment')->result();
                            
                            $assignments=[];
                            $j=0;
                            foreach($return[$i]->assignment as $assignment){
                                $result1 = $this->db->where(['course'=>$courseid,'video'=>$videoid,'assignment'=>$assignment->id])->get('tbl_video_assignment_upload');
                                
                                $answers=[];
                                $k=0;
                                foreach($result1->result() as $answer)
                                {
                                    $answers[$k]=$answer;
                                    $answers[$k]->user=$this->db->where(['id'=>$answer->userid])->get('tbl_registration')->row();
                                    $k++;
								}
                                $assignments[$j]=$assignment;
                                $assignments[$j]->answer=$answers;
                                
                                $j++;
							}
                            
                            $return[$i]->assignment=$assignments;
                            
                            $result2=$this->db->where(['courseid'=>$courseid,'videoid'=>$videoid])->get('tbl_video_question');
                            $questions=[];
                            if($result2->num_rows()){
                                
                                
                                $k=0;
                                foreach($result2->result() as $question){
                                    
                                    $result3 = $this->db->where(['questionid'=>$question->id])->get('tbl_video_reply');
                                    if($result3->num_rows()){
                                        $reply_status='true';
                                        
                                        $l=0;
                                        $reply=[];
                                        foreach($result3->result() as $rep){
                                            $reply[$l]=$rep;
                                            if($rep->usertype=='Educator'){
                                                $name='Karmasu';
                                                $profile_photo='codersadda.png';
											}
                                            else{
                                                $name='Karmasu';
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
                        // echo '<pre>';
                        // var_dump($data);
                        
                        $this->load->view("Educator/VideoPlaylist.php",$data);
					}
                    else{
                        redirect(base_url('Educator/ManageCourses/Details/'.$courseid));
					}
				}
				else{
					redirect(base_url('Educator/ManageCourses'));
				}	
			}
			else{
				redirect(base_url('Educator/ManageCourses'));
			}
		}
        
        
        public function Certificates()
        {
            if ($this->uri->segment(3)==TRUE) 
            {
                if ($this->uri->segment(4)==TRUE) 
                {
                    if($this->uri->segment(3)=='Preview'){
                        $data["certificateList"] = [(object) ['itemtype'=>'Course']];
                        $data['name']='Karmasu';
                        $data['training']='Karmasu';
                        $data['technology']='Karmasu';
                        $data['grade']='A++';
                        $data['duration']='45 Days';
                        $data['from']=$this->date;
                        $data['to']=$this->date;
                        $data['refno']='DCT2021';
                        $data['enroll_id']='DCT2021';
                        $data['issuedon']=$this->date;
                        $this->load->view("Certificate/".$this->uri->segment(4), $data);
					}
				} 
			} 
		}
        
        public function VideoReply()
        {
            $output['res']="error";
            $output['msg']="error";
            $output['data']="";
            if($this->uri->segment(3)){
                $action=$this->uri->segment(3);
                
                if($action=='Add')
                {
                    if(!empty($_POST) and $this->form_validation->run('videoReply')) 
                    {
                        $insertData=[
                        'courseid'=>$this->input->post('courseid'),
                        'videoid'=>$this->input->post('videoid'),
                        'userid'=>$this->input->post('userid'),
                        'usertype'=>$this->input->post('usertype'),
                        'questionid'=>$this->input->post('questionid'),
                        'message'=>$this->input->post('message'),
                        'status'=>'true',
                        'date'=>$this->date,
                        'time'=>$this->time
                        ];
                        
                        if($this->db->insert('tbl_video_reply',$insertData)){
                            
                            $output['res']="success";
                            $output['msg']="Reply Posted";
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
		
		public function LiveReply()
        {
            $output['res']="error";
            $output['msg']="error";
            $output['data']="";
            if($this->uri->segment(3)){
                $action=$this->uri->segment(3);
                
                if($action=='Add')
                {
                    if(!empty($_POST) and $this->form_validation->run('liveReply')) 
                    {
                        $insertData=[
                        'liveid'=>$this->input->post('liveid'),
                        'userid'=>$this->input->post('userid'),
                        'usertype'=>$this->input->post('usertype'),
                        'questionid'=>$this->input->post('questionid'),
                        'message'=>$this->input->post('message'),
                        'status'=>'true',
                        'date'=>$this->date,
                        'time'=>$this->time
                        ];
                        
                        if($this->db->insert('tbl_live_reply',$insertData)){
                            
                            $output['res']="success";
                            $output['msg']="Reply Posted";
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
        
        #ManageQuestions
		
		public function ManageQuestions()
		{
			$table='tbl_questions';
			
			$data['subjectList']=$this->db->where('status','true')->get('tbl_subject')->result();
			
			$this->ansList=['a'=>'Option A','b'=>'Option B','c'=>'Option C','d'=>'Option D'];
			if ($this->uri->segment(3) == TRUE) 
			{
				$action = $this->uri->segment(3);
				if ($this->uri->segment(4) == TRUE) 
				{
					$id = $this->uri->segment(4);
					$query = $this->db->where('id', $id)->get($table);
					if ($query->num_rows()) 
					{
						$data["list"] = $query->result();
						
						if($action=='Edit'){
							$data["action"]="EditQuestion";
							$this->load->view("Educator/Modal", $data);
						}
						else
						{
							redirect(base_url('Educator/ManageQuestions'));
						}
					}
					else
					{
						redirect(base_url('Educator/ManageQuestions'));
					}
				}
				else 
				{
					if($action=='Add')
					{
						if (isset($_POST["addaction"])) 
						{    
							if ($this->form_validation->run('Questions') == FALSE)
							{
								$msg=explode('</p>',validation_errors());
								$msg=str_ireplace('<p>','', $msg[0]);
								$this->session->set_flashdata(array('res'=>'error','msg'=>$msg));
							} 
							else 
							{
								// $answer=$this->input->post('answer');
								// $_POST['answer']=$this->input->post($answer);
								if($this->input->post('answer_type')=='Photo'){
									$_POST['a']=time().rand().'.'.pathinfo($_FILES["a"]["name"], PATHINFO_EXTENSION);
									$_POST['b']=time().rand().'.'.pathinfo($_FILES["b"]["name"], PATHINFO_EXTENSION);
									$_POST['c']=time().rand().'.'.pathinfo($_FILES["c"]["name"], PATHINFO_EXTENSION);
									$_POST['d']=time().rand().'.'.pathinfo($_FILES["d"]["name"], PATHINFO_EXTENSION);
								}
								$insertData= [
								'teacher_id'=>$this->author,
								'subject_id'=>$this->input->post('subject_id'),
								'question'=>$this->input->post('question'),
								'a'=>$this->input->post('a'),
								'b'=>$this->input->post('b'),
								'c'=>$this->input->post('c'),
								'd'=>$this->input->post('d'),
								'answer'=>$this->input->post('answer'),
								'answer_type'=>$this->input->post('answer_type'),
								'week'=>$this->input->post('week'),
								'status'=>'true',
								'date'=>$this->date,
								'time'=>$this->time
								];
								$insertData = $this->security->xss_clean($insertData);
								if($this->db->insert($table, $insertData)) 
								{
									if($this->input->post('answer_type')=='Photo')
									{
										$config['upload_path']   = './uploads/question/';
										$config['allowed_types'] = 'gif|jpg|png|jpeg';
										$config['max_size']      = 1000000;
										$config['file_name']     = $this->input->post('a');
										$this->load->library('upload', $config);
										$this->upload->do_upload('a');
										
										$config['upload_path']   = './uploads/question/';
										$config['allowed_types'] = 'gif|jpg|png|jpeg';
										$config['max_size']      = 1000000;
										$config['file_name']     = $this->input->post('b');
										$this->upload->initialize($config);
										$this->upload->do_upload('b');
										
										$config['upload_path']   = './uploads/question/';
										$config['allowed_types'] = 'gif|jpg|png|jpeg';
										$config['max_size']      = 1000000;
										$config['file_name']     = $this->input->post('c');
										$this->upload->initialize($config);
										$this->upload->do_upload('c');
										
										$config['upload_path']   = './uploads/question/';
										$config['allowed_types'] = 'gif|jpg|png|jpeg';
										$config['max_size']      = 1000000;
										$config['file_name']     = $this->input->post('d');
										$this->upload->initialize($config);
										$this->upload->do_upload('d');
									}
									
									
									$this->session->set_flashdata(array('res'=>'success','msg'=>'Data Added Successfully.'));
								}
								else 
								{
									$this->session->set_flashdata(array('res'=>'error','msg'=>'Try ! Again'));
								}
							}
						}
					}
					else if($action=='Update'){
						if (isset($_POST["updateaction"])) 
						{  
							if(empty($this->input->post("id")))
							{
								$this->session->set_flashdata(array('res'=>'error','msg'=>'ID is required.'));
							} 
							else
							{
								$query = $this->db->where('id', $this->input->post("id"))->get($table);
								if ($query->num_rows()) 
								{
									$data['list']=$query->result();
									
									if ($this->form_validation->run('Questions') == FALSE){
										$msg=explode('</p>',validation_errors());
										$msg=str_ireplace('<p>','', $msg[0]);
										$this->session->set_flashdata(array('res'=>'error','msg'=>$msg));
									} 
									else 
									{
										if($this->input->post('answer_type')=='Photo')
										{
											if(empty($_FILES["a"]["name"])){ $_POST['a']=$data['list'][0]->a; } else { $_POST['a']=time().rand().'.'.pathinfo($_FILES["a"]["name"], PATHINFO_EXTENSION); }
											
											if(empty($_FILES["b"]["name"])){ $_POST['b']=$data['list'][0]->b; } else { $_POST['b']=time().rand().'.'.pathinfo($_FILES["b"]["name"], PATHINFO_EXTENSION); }
											
											if(empty($_FILES["c"]["name"])){ $_POST['c']=$data['list'][0]->c; } else { $_POST['c']=time().rand().'.'.pathinfo($_FILES["c"]["name"], PATHINFO_EXTENSION); }
											
											if(empty($_FILES["d"]["name"])){ $_POST['d']=$data['list'][0]->d; } else { $_POST['d']=time().rand().'.'.pathinfo($_FILES["d"]["name"], PATHINFO_EXTENSION); }
										}
										// $answer=$this->input->post('answer');
										// $_POST['answer']=$this->input->post($answer);
										$updateData= [
										'subject_id'=>$this->input->post('subject_id'),
										'question'=>$this->input->post('question'),
										'a'=>$this->input->post('a'),
										'b'=>$this->input->post('b'),
										'c'=>$this->input->post('c'),
										'd'=>$this->input->post('d'),
										'answer'=>$this->input->post('answer'),
										'answer_type'=>$this->input->post('answer_type'),
										'week'=>$this->input->post('week'),
										'date'=>$this->date,
										'time'=>$this->time
										];
										$updateData = $this->security->xss_clean($updateData);
										$result=$this->db->where('id',$data['list'][0]->id)->update($table,$updateData);  
										if ($result) 
										{
											$initialize=false;
											if(!empty($_FILES["a"]["name"]))
											{
												$config['upload_path']   = './uploads/question/';
												$config['allowed_types'] = 'gif|jpg|png|jpeg';
												$config['max_size']      = 1000000;
												$config['file_name']     = $this->input->post('a');
												$this->load->library('upload', $config);
												$this->upload->do_upload('a');
												$initialize=true;
											}
											
											if(!empty($_FILES["b"]["name"]))
											{
												$config['upload_path']   = './uploads/question/';
												$config['allowed_types'] = 'gif|jpg|png|jpeg';
												$config['max_size']      = 1000000;
												$config['file_name']     = $this->input->post('b');
												if($initialize==true){ $this->load->initialize($config); } else{ $this->load->library('upload', $config); }
												$this->upload->do_upload('b');
												$initialize=true;
											}
											
											if(!empty($_FILES["c"]["name"]))
											{
												$config['upload_path']   = './uploads/question/';
												$config['allowed_types'] = 'gif|jpg|png|jpeg';
												$config['max_size']      = 1000000;
												$config['file_name']     = $this->input->post('c');
												if($initialize==true){ $this->load->initialize($config); } else{ $this->load->library('upload', $config); }
												$this->upload->do_upload('c');
												$initialize=true;
											}
											
											if(!empty($_FILES["d"]["name"]))
											{
												$config['upload_path']   = './uploads/question/';
												$config['allowed_types'] = 'gif|jpg|png|jpeg';
												$config['max_size']      = 1000000;
												$config['file_name']     = $this->input->post('d');
												if($initialize==true){ $this->load->initialize($config); } else{ $this->load->library('upload', $config); }
												$this->upload->do_upload('d');
												$initialize=true;
											}
											
											
											$this->session->set_flashdata(array('res'=>'success','msg'=>'Data Updated Successfully.'));
										}
										else 
										{
											$this->session->set_flashdata(array('res'=>'error','msg'=>'Try Again !'));
										}
									}
								}
							}
						}
					}
					else if($action=='Upload')
					{
						if(!empty($this->input->post()))
						{
							$this->load->library('excel');
							if(empty($_FILES['excelfile']['name']))
							{
								$this->session->set_flashdata(array('res'=>'error','msg'=>'Choose Excel File.'));
							}
							else if(!in_array($_FILES["excelfile"]["type"],$this->excel->allowedFileType))
							{
								$this->session->set_flashdata(array('res'=>'error','msg'=>'Invalid Excel File.'));
							}
							else
							{
								$fileInfo=$_FILES["excelfile"]["name"];
								$newFileName="UploadQuestion-".time().rand(100,900).".".pathinfo($_FILES['excelfile']['name'], PATHINFO_EXTENSION);
								$fileDirectory="./uploads/excel/";
								$inputFileName=$fileDirectory.$newFileName;
								
								$config['upload_path']=$fileDirectory;
								$config['allowed_types']='xlsx|xls';
								$config['max_size']=100000000;
								$config['file_name']=$newFileName;
								
								$this->load->library('upload', $config);
								$this->upload->do_upload('excelfile');
								
								$inputFileType=PHPExcel_IOFactory::identify($inputFileName);
								$objReader=PHPExcel_IOFactory::createReader($inputFileType);      
								$objReader->setReadDataOnly(true);
								$objPHPExcel=$objReader->load($inputFileName);    
								$objWorksheet=$objPHPExcel->setActiveSheetIndex(0);
								$highestRow=$objWorksheet->getHighestRow();
								$highestColumn=$objWorksheet->getHighestColumn();
								$highestColumnIndex=PHPExcel_Cell::columnIndexFromString($highestColumn);
								if($highestRow<=1 or $highestColumnIndex<=0){
									$output['msg']='Empty Excel File.';
								}
								else
								{
									for($row=2;$row<=$highestRow;$row++){
										$srno=$objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
										$subject_id=$objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
										$question=$objWorksheet->getCellByColumnAndRow(2, $row)->getValue();
										$a=$objWorksheet->getCellByColumnAndRow(3, $row)->getValue();
										$b=$objWorksheet->getCellByColumnAndRow(4, $row)->getValue();
										$c=$objWorksheet->getCellByColumnAndRow(5, $row)->getValue();
										$d=$objWorksheet->getCellByColumnAndRow(6, $row)->getValue();
										$answer=strtolower($objWorksheet->getCellByColumnAndRow(7, $row)->getValue());
										$week=strtolower($objWorksheet->getCellByColumnAndRow(8, $row)->getValue());
										
										
										$insertData[]=[
                                        'teacher_id'=>$this->author,
										'subject_id'=>$subject_id,
										'question'=>$question,
										'a'=>$a,
										'b'=>$b,
										'c'=>$c,
										'd'=>$d,
										'answer'=>$answer,
										'week'=>ucfirst($week),
										'status'=>'true',
										'date'=>$this->date,
										'time'=>$this->time
										];
									}
									
									if(!empty($insertData))
									{
										
										if($this->db->insert_batch($table,$insertData))
										{
											$this->session->set_flashdata(array('res'=>'success','msg'=>'Uploaded Successfully'));
										}
										else
										{
											$this->session->set_flashdata(array('res'=>'error','msg'=>'Failed !'));
										}
									}
								}
							} 
						}
					}
					redirect(base_url('Educator/ManageQuestions')); 
				}
			}
			else 
			{
				
				$query = $this->db->where('teacher_id',$this->author)->order_by("id", "DESC")->get($table);
				$data["list"] = $query->result();
				
				$i=0; $return=[];
				foreach ($data["list"] as $item) {
					$return[$i]=$item;
					$return[$i]->subject=$this->db->where('id',$item->subject_id)->get('tbl_subject')->row();
					$i++;
				}
				$this->load->view("Educator/ManageQuestions.php", $data);
			}
		}
        
        
        #ManageQuiz
		public function ManageQuiz()
		{
			$table='tbl_quiz';
			
			$this->ansList=['a'=>'Option A','b'=>'Option B','c'=>'Option C','d'=>'Option D'];
			$data['subjectList']=$this->db->where('status','true')->get('tbl_subject')->result();
			$data['courselist']=$this->db->where('apprstatus','true')->where('author',$this->author)->get('tbl_course')->result();
			$data['weekList']=$this->db->select('week')->distinct('week')->where('status','true')->where('teacher_id',$this->author)->get('tbl_questions')->result();
			
			if ($this->uri->segment(3) == TRUE) 
			{
				$action = $this->uri->segment(3);
				if ($this->uri->segment(4) == TRUE) 
				{
					$id = $this->uri->segment(4);
					$query = $this->db->where('id', $id)->get($table);
					if ($query->num_rows()) 
					{
						$data["list"] = $query->result();
						
						if($action=='Edit'){
							$data["action"]="EditQuiz";
							$return=[];
							$questions=explode(',',$data['list'][0]->questions);
							for($i=0;$i<count($questions);$i++)
							{
								$return[$i]=$this->db->where('id',$questions[$i])->get('tbl_questions')->row();
							}
							$data["questionsList"]=$return; 
							$this->load->view("Educator/Modal", $data);
						}
						else if($action=='Questions'){
							
							$return=[];
							$questions=explode(',',$data['list'][0]->questions);
							for($i=0;$i<count($questions);$i++)
							{
								$return[$i]=$this->db->where('id',$questions[$i])->get('tbl_questions')->row();
							}
							$data["questionslist"]=$return; 
							$this->load->view("Educator/QuizQuestions", $data);
						}
						else
						{
							redirect(base_url('Educator/ManageQuiz'));
						}
					}
					else
					{
						redirect(base_url('Educator/ManageQuiz'));
					}
				}
				else 
				{
					if($action=='Add')	
					{
						if (isset($_POST["addaction"])) 
						{    
							
							$this->form_validation->set_rules('course_id', 'Course', 'required');
							if(empty($_POST['questions'])) {
								$this->form_validation->set_rules('questions', 'Questions', 'required');
							}
							if ($this->form_validation->run('Quiz') == FALSE)
							{
								$msg=explode('</p>',validation_errors());
								$msg=str_ireplace('<p>','', $msg[0]);
								$this->session->set_flashdata(array('res'=>'error','msg'=>$msg));
							} 
							else 
							{
								
								$insertData= [
								'teacher_id'=>$this->author,
								'name'=>$this->input->post('name'),
								'questions'=>implode(',',$this->input->post('questions')),
								'no_of_questions'=>count($this->input->post('questions')),
								'per_question_no'=>$this->input->post('per_question_no'),
								'timing'=>$this->input->post('timing'),
								'description'=>$this->input->post('description'),
								'solutions'=>$this->input->post('solutions'),
								'status'=>'true',
								'date'=>$this->date,
								'time'=>$this->time
								];
								$insertData = $this->security->xss_clean($insertData);
								if($this->db->insert($table, $insertData)) 
								{
									
									$quiz_id=$this->db->insert_id();
                                    $insertData= array(
                                    "franchise_id" =>0,
                                    "teacher_id"=>$this->author,
                                    "quiz_id" => $quiz_id,
                                    "course_id" => $this->input->post("course_id"),
                                    "timing" => date('Y-m-d H:i:s'),
                                    "status" => "true",
                                    "is_done" => "false",
                                    "date" => $this->date,
                                    "time" => $this->time
                                    );
                                    $insertData = $this->security->xss_clean($insertData);
                                    $this->db->insert('tbl_quiz_scheduled', $insertData);
									
									$this->session->set_flashdata(array('res'=>'success','msg'=>'Quiz Added Successfully.'));
								}
								else 
								{
									$this->session->set_flashdata(array('res'=>'error','msg'=>'Try ! Again'));
								}
							}
						}
					}
					else if($action=='Update'){
						if (isset($_POST["updateaction"])) 
						{  
							if(empty($this->input->post("id")))
							{
								$this->session->set_flashdata(array('res'=>'error','msg'=>'ID is required.'));
							} 
							else
							{
								$query = $this->db->where('id', $this->input->post("id"))->get($table);
								if ($query->num_rows()) 
								{
									$data['list']=$query->result();
									
									if(empty($_POST['questions'])) {
										$this->form_validation->set_rules('questions', 'Questions', 'required');
									}
									if ($this->form_validation->run('Quiz') == FALSE){
										$msg=explode('</p>',validation_errors());
										$msg=str_ireplace('<p>','', $msg[0]);
										$this->session->set_flashdata(array('res'=>'error','msg'=>$msg));
									} 
									else 
									{
										$updateData= [
										'name'=>$this->input->post('name'),
										'questions'=>implode(',',$this->input->post('questions')),
										'no_of_questions'=>count($this->input->post('questions')),
										'per_question_no'=>$this->input->post('per_question_no'),
										'timing'=>$this->input->post('timing'),
										'description'=>$this->input->post('description'),
										'solutions'=>$this->input->post('solutions'),
										'date'=>$this->date,
										'time'=>$this->time
										];
										$updateData = $this->security->xss_clean($updateData);
										$result=$this->db->where('id',$data['list'][0]->id)->update($table,$updateData);  
										if ($result) 
										{
											$this->session->set_flashdata(array('res'=>'success','msg'=>'Quiz Updated Successfully.'));
										}
										else 
										{
											$this->session->set_flashdata(array('res'=>'error','msg'=>'Try Again !'));
										}
									}
								}
							}
						}
					}
					redirect(base_url('Educator/ManageQuiz')); 
				}
			}
			else 
			{
				
				$query = $this->db->where('teacher_id',$this->author)->order_by("id", "DESC")->get($table);
				$data["list"] = $query->result();
				$this->load->view("Educator/ManageQuiz.php", $data);
			}
		}
        
        # Schedule Quiz
        public function ScheduleQuiz()
		{
			$table='tbl_quiz_scheduled';
			$this->ansList=['a'=>'Option A','b'=>'Option B','c'=>'Option C','d'=>'Option D'];
			
			$data['quizlist']=$this->db->where('status','true')->where('teacher_id',$this->author)->get('tbl_quiz')->result();
			$data['courselist']=$this->db->where('apprstatus','true')->where('author',$this->author)->get('tbl_course')->result();
			if ($this->uri->segment(3) == TRUE) 
			{
				$action = $this->uri->segment(3);
				if ($this->uri->segment(4) == TRUE) 
				{
					$id = $this->uri->segment(4);
					$query = $this->db->where('id', $id)->get($table);
					if ($query->num_rows()) 
					{
						$data["list"] = $query->result();
						$quiz_result = $this->db->where('id', $data["list"][0]->quiz_id)->get('tbl_quiz');
						$data['quizData']=$quiz_result->result();
						if($action=='Edit'){
							$data["action"]="EditScheduleQuiz";
							$this->load->view("Educator/Modal", $data);
						}
						else if($action=='Questions')
						{
							$data["action"]="Questions";
							
							
							
							$return=[];
							$questions=explode(',',$data['quizData'][0]->questions);
							for($i=0;$i<count($questions);$i++)
							{
								$return[$i]=$this->db->where('id',$questions[$i])->get('tbl_questions')->row();
							}
							$data["questionslist"]=$return; 
							
                            $this->load->view("Educator/ScheduleQuiz", $data);
						}
						else if($action=='Attend')
						{
							$data["action"]="Attend";
							$result=$this->db->where(['schedule_id'=>$data["list"][0]->id])->get('tbl_quiz_attended');
							$data["resultList"]=$result->result(); 
							$this->load->view("Educator/ScheduleQuiz", $data);
						}
						else
						{
							redirect(base_url('Educator/ScheduleQuiz'));
						}
					}
					else
					{
						redirect(base_url('Educator/ScheduleQuiz'));
					}
				}
				else 
				{
					if($action=='Add')
					{
						if (isset($_POST["addaction"])) 
						{    
							
							$this->form_validation->set_rules('quiz_id', 'Quiz', 'required', array('required' => '%s is Required Field'));
							$this->form_validation->set_rules('course_id', 'Course', 'required', array('required' => '%s is Required Field'));
							$this->form_validation->set_rules('timing', 'Timing', 'required', array('required' => '%s is Required Field'));
							if ($this->form_validation->run() == FALSE)
							{
                                $msg=explode('</p>',validation_errors());
								$msg=str_ireplace('<p>','', $msg[0]);
								$this->session->set_flashdata(array('res'=>'error','msg'=>$msg));
							} 
							else 
							{
								$data_to_insert= array(
								"franchise_id" =>0,
								"teacher_id"=>$this->author,
								"quiz_id" => $this->input->post("quiz_id"),
								"course_id" => $this->input->post("course_id"),
								"timing" => str_replace("T"," ",$this->input->post("timing")),
								"status" => "true",
								"is_done" => "false",
								"date" => $this->date,
								"time" => $this->time
								);
								$data_to_insert = $this->security->xss_clean($data_to_insert);
								if ($this->db->insert($table, $data_to_insert)) {
									$this->session->set_flashdata(array('res'=>'success','msg'=>'Quiz Scheduled.'));
								}
								else 
								{
									$this->session->set_flashdata(array('res'=>'error','msg'=>'Failed !'));
								}
							}
						}
					}
					else if($action=='Update'){
						if (isset($_POST["updateaction"])) 
						{  
							if(empty($this->input->post("id")))
							{
								$this->session->set_flashdata(array('res'=>'error','msg'=>'ID is required.'));
							} 
							else
							{
								$query = $this->db->where('id', $this->input->post("id"))->get($table);
								if ($query->num_rows()) 
								{
									$data['list']=$query->result();
									
									$this->form_validation->set_rules('quiz_id', 'Quiz', 'required', array('required' => '%s is Required Field'));
									$this->form_validation->set_rules('course_id', 'Course', 'required', array('required' => '%s is Required Field'));
									$this->form_validation->set_rules('timing', 'Timing', 'required', array('required' => '%s is Required Field'));
									if ($this->form_validation->run() == FALSE)
									{
										$msg=explode('</p>',validation_errors());
										$msg=str_ireplace('<p>','', $msg[0]);
										$this->session->set_flashdata(array('res'=>'error','msg'=>$msg));
									} 
									else 
									{
										$data_to_update= array(
										"quiz_id" => $this->input->post("quiz_id"),
										"course_id" => $this->input->post("course_id"),
										"timing" => str_replace("T"," ",$this->input->post("timing")),
										);
										$data_to_update = $this->security->xss_clean($data_to_update);
										if ($this->db->where('id',$data['list'][0]->id)->update($table, $data_to_update)) {
											$this->session->set_flashdata(array('res'=>'success','msg'=>'Updated.'));
										}
										else 
										{
											$this->session->set_flashdata(array('res'=>'error','msg'=>'Failed !'));
										}
									}
								}
							}
						}
					}
					redirect(base_url('Educator/ScheduleQuiz')); 
				}
			}
			else 
			{
				$query = $this->db->where('teacher_id',$this->author)->order_by("id", "DESC")->get($table);
				$data["list"] = $query->result();
				$this->load->view("Educator/ScheduleQuiz", $data);
			}
		}
		
		# Recommended Videos + Free + Short Tips
		public function Videos()
        {
            $table='tbl_recommended_videos';
            if($this->uri->segment(4) == TRUE) {
                $id = $this->uri->segment(4);
                $query = $this->db->where('id', $id)->where("(`for_user`='Both' OR `for_user`='Educator')")->get($table);
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
					$this->load->view("Educator/RecommendedVideos.php", $data);
				}
				else{
					redirect(base_url('Educator/RecommendedVideos'));
				}
			}
			else{
				if(empty($this->uri->segment(3))){
					$type='RecommendedVideos';
				}
				else{
					$type=$this->uri->segment(3);	
				}
				$query = $this->db->where(['status'=>'true','type'=>$type])->where("(`for_user`='Both' OR `for_user`='Educator')")->order_by("id", "DESC")->get($table);
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
				$this->load->view("Educator/RecommendedVideos.php", $data);
			}
		}
        # Notification
		public function Notification()
        {
			$result=$this->db->where(['status'=>'true','for_user'=>'Educator'])->where("FIND_IN_SET('".$this->author."',users)!=",0)->order_by("id", "DESC")->get('tbl_notification');
			$i=0;
			$return=[];
			foreach($result->result() as $notification){
				$return[$i]=$notification;
				$return[$i]->since=$this->codersadda->humanTiming (strtotime($notification->date.' '.$notification->time));
				$i++;
			}
			$data['notificationList']=$return;
			$data['notificationCount']=$result->num_rows();
            $this->load->view("Educator/Notification.php",$data);
		}
		
		public function UpdateKYC()
        {
			$data['action']='UpdateKYC';
			if(!empty($this->input->post()))
			{
				$this->form_validation->set_rules('bank', 'Bank', 'required', array('required' => '%s is Required Field'));
				$this->form_validation->set_rules('branch', 'Branch', 'required', array('required' => '%s is Required Field'));
				$this->form_validation->set_rules('ifsc', 'Ifsc Code', 'required', array('required' => '%s is Required Field'));
				$this->form_validation->set_rules('account_no', 'Ifsc Code', 'required', array('required' => '%s is Required Field'));
				$this->form_validation->set_rules('name', 'Ifsc Code', 'required', array('required' => '%s is Required Field'));
				$this->form_validation->set_rules('mobile', 'Ifsc Code', 'required', array('required' => '%s is Required Field'));
				$this->form_validation->set_rules('document_type', 'Document Type', 'required', array('required' => '%s is Required Field'));
				
				if(empty($_FILES["document_proof"]["name"]))
				{ 
					$this->form_validation->set_rules('document_proof', 'Document Proof ', 'required');
				}
				
				if ($this->form_validation->run() == FALSE)
				{
					$msg=explode('</p>',validation_errors());
					$msg=str_ireplace('<p>','', $msg[0]);
					$this->session->set_flashdata(array('res'=>'error','msg'=>$msg));
				} 
				else 
				{
					
					$ext=pathinfo($_FILES["document_proof"]["name"],PATHINFO_EXTENSION);
                    $document_proof=time()."_document_proof.".$ext;
					
					$saveData= array(
					"userid" =>$this->author,
					"name"=>$this->input->post("name"),
					"mobile" => $this->input->post("mobile"),
					"bank" => $this->input->post("bank"),
					"branch" => $this->input->post("branch"),
					"ifsc" => $this->input->post("ifsc"),
					"account_no" => $this->input->post("account_no"),
					"upi" => $this->input->post("upi"),
					"document_type" => $this->input->post("document_type"),
					"document_no" => $this->input->post("document_no"),
					"document_proof" => $document_proof,
					"status" => "Pending",
					"date" => $this->date,
					"time" => $this->time
					);
					$saveData = $this->security->xss_clean($saveData);
					
					$results=$this->db->where('userid',$this->author)->get('tbl_kyc');
					if($results->num_rows())
					{
						$result=$this->db->where('userid',$this->author)->update('tbl_kyc', $saveData);
					}
					else{
						$result=$this->db->insert('tbl_kyc', $saveData);
					}
					
					if ($result) 
					{
						if(!empty($_FILES["document_proof"]["name"]))
						{
							$config['upload_path'] = './uploads/kyc/';
							$config['allowed_types'] = 'gif|jpg|png|jpeg';
							$config['max_size'] = 100000; // In KB
							$config['file_name'] = $document_proof;
							$this->load->library('upload', $config);  
							$this->upload->do_upload('document_proof');
						}
						
						$this->session->set_flashdata(array('res'=>'success','msg'=>'Kyc Details Send'));
					}
					else 
					{
						$this->session->set_flashdata(array('res'=>'error','msg'=>'Failed !'));
					}
					
					redirect('Educator/UpdateKYC');
				}
			}
			else
			{
				$result=$this->db->where(['userid'=>$this->author])->order_by("id", "DESC")->get('tbl_kyc');
				$data['kycCount']=$result->num_rows();
				$data['kycData']=$result->row();
				$this->load->view("Educator/UpdateKYC.php",$data);
			}
			
		}
		
		# Promocode
        public function Promocode()
        {
            $table='tbl_offer';
			if ($this->uri->segment(3) == TRUE) 
            {
                $action = $this->uri->segment(3);
                if ($this->uri->segment(4) == TRUE) 
                {
                    $id = $this->uri->segment(4);
                    $query = $this->db->where('id', $id)->get($table);
                    if ($query->num_rows()) 
                    {
                        $data["list"] = $query->result();
                        if($action=='UsedCouponHistory')
						{
                            $data["action"]="UsedCouponHistory";
                            $data['history']=$this->db->where(['couponcode'=>$data["list"][0]->coupon,'paymentstatus'=>'success'])->get('tbl_enroll')->result();
                            $this->load->view("Educator/UsedCouponHistory", $data);
						}
                        else
                        {
                            redirect(base_url('Educator/Promocode'));
						}
					}
                    else
                    {
                        redirect(base_url('AdminPanel/Promocode'));
					}
				}
				else{
					redirect(base_url('AdminPanel/Promocode'));
				}
			}
			else{
				$query = $this->db->where(['status'=>'true','type'=>'Educator','educator_id'=>$this->author])->get($table);
				$data["list"] = $query->result();
				$this->load->view("Educator/Promocode", $data);
			}
			
		}
		
		public function Revenue()
        {
			
			$month_start = date('Y-m-d',strtotime('first day of this month', time()));
			$month_end = date('Y-m-d',strtotime('last day of this month', time()));
			if(!empty($_REQUEST['from_date']) and !empty($_REQUEST['to_date']))
			{
				$from_date=$_REQUEST['from_date'];
				$to_date=$_REQUEST['to_date'];
			}
			else{
				$from_date=$month_start;
				$to_date=$month_end;
			}
			$data['from_date']=$from_date;
			$data['to_date']=$to_date;
			
			$data['revenueList']=$this->db->where(['author'=>$this->author,'price!='=>0,'educator_status'=>'true','paymentstatus'=>'success'])->where('date BETWEEN "'.$month_start. '" and "'.$month_end.'"')->get('tbl_enroll')->result();
			$this->load->view("Educator/Revenue", $data);
		}
		
		public function CallAndSupport()
        {
			$data['NeedHelp']=$this->db->select('help_mobile,help_email')->get('tbl_adminlogin')->row();
			$this->load->view("Educator/CallAndSupport", $data);
		}
		
		public function Agreement()
        {
			$data['Agreement']='Agreement';
			if(empty($this->input->post()))
			{
				$data['agreement']=$this->db->where('userid',$this->author)->order_by('id','DESC')->get('tbl_agreement')->row();
				$this->load->view("Educator/Agreement", $data);
			}
			else
			{
				$this->form_validation->set_rules('agree', 'Accept Agreement', 'required', array('required' => '%s is Required Field'));
				
				if(empty($_FILES["signature"]["name"]))
				{ 
					$this->form_validation->set_rules('signature', 'Signature', 'required');
				}
				
				if ($this->form_validation->run() == FALSE)
				{
					$msg=explode('</p>',validation_errors());
					$msg=str_ireplace('<p>','', $msg[0]);
					$this->session->set_flashdata(array('res'=>'error','msg'=>$msg));
				} 
				else 
				{
					
                    $signature=time()."_signature.".pathinfo($_FILES["signature"]["name"],PATHINFO_EXTENSION);
                    $photo=time()."_photo.".pathinfo($_FILES["photo"]["name"],PATHINFO_EXTENSION);
					$proof=time()."_proof.".pathinfo($_FILES["proof"]["name"],PATHINFO_EXTENSION);
					
					$saveData= array(
					"userid" =>$this->author,
					"signature"=>$signature,
					"photo"=>$photo,
					"proof"=>$proof,
					"status" => "true",
					"date" => $this->date,
					"time" => $this->time
					);
					
					$result=$this->db->insert('tbl_agreement', $saveData);
					if ($result) 
					{
						if(!empty($_FILES["signature"]["name"]))
						{
							$config['upload_path'] = './uploads/agreement/';
							$config['allowed_types'] = 'gif|jpg|png|jpeg';
							$config['max_size'] = 100000; // In KB
							$config['file_name'] = $signature;
							$this->load->library('upload', $config);  
							$this->upload->do_upload('signature');
						}
						
						if(!empty($_FILES["photo"]["name"]))
						{
							$config['upload_path'] = './uploads/agreement/';
							$config['allowed_types'] = 'gif|jpg|png|jpeg';
							$config['max_size'] = 100000; // In KB
							$config['file_name'] = $photo;
							$this->upload->initialize($config);
							$this->upload->do_upload('photo');
						}
						
						if(!empty($_FILES["proof"]["name"]))
						{
							$config['upload_path'] = './uploads/agreement/';
							$config['allowed_types'] = 'gif|jpg|png|jpeg';
							$config['max_size'] = 100000; // In KB
							$config['file_name'] = $proof;
							$this->upload->initialize($config); 
							$this->upload->do_upload('photo');
						}
						
						$this->session->set_flashdata(array('res'=>'success','msg'=>'Signature Uploaded.'));
					}
					else 
					{
						$this->session->set_flashdata(array('res'=>'error','msg'=>'Failed !'));
					}
				}
				redirect('Educator/Agreement');
			}
		}
        
        
	}                                                                                                                                                                                                																			