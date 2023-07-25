<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
    ini_set('memory_limit','-1');
    error_reporting(E_ALL);
   /*  require '/application/aws-sdk/autoload.php';
    
    use Aws\S3\S3Client;

    $region = 'us-west-2'; // Replace with your desired AWS region
    $version = 'latest';   // Replace with the desired AWS SDK version

    $s3 = new S3Client([
        'region' => $region,
        'version' => $version
    ]);

    $bucketName = 'YOUR_BUCKET_NAME'; // Replace with your bucket name */
    use Aws\S3\S3Client;
    use Aws\S3\Exception\S3Exception;
    include(APPPATH.'\third_party\aws-sdk\aws-autoloader.php');
    class AdminPanel extends MY_Controller
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
            $this->load->library('s3_upload');
            $this->load->library('form_validation');
            $this->load->model('Auth_model');
            
            if ($this->ValidateAdminUser()) {
                if (empty($this->session->userdata("AdminLoginData"))) {
                    $this->fetchUserData();
                    
                }
                } else {
               redirect(base_url("Home/"));
            }
            $this->notificationCount=$this->db->get('tbl_notification')->num_rows();
            $this->enrollCount=$this->db->get('tbl_enroll')->num_rows();
            
            $this->certificateTheme=['Ist Theme'=>'IstTheme.php','IInd Theme'=>'IIndTheme.php','IIIrd Theme'=>'IIIrdTheme.php'];
            $this->franchise=0;
            
            $this->firebaseActivities=[
                'None'=>'digi.coders.karmasu_TARGET_NOTIFICATION',
                'Category'=>'digi.coders.karmasu_TARGET_CATEGORY_COURSES_ACTIVITY',
                'Course'=>'digi.coders.karmasu_TARGET_COURSE_DETAIL',
                'Ebook'=>'digi.coders.karmasu_TARGET_EBOOK_DETAIL',
                'Abook'=>'digi.coders.karmasu_TARGET_AUDIO_BOOK_DETAIL',
                'Quiz'=>'digi.coders.karmasu_TARGET_PLAY_QUIZ',
                'LiveSession'=>'digi.coders.karmasu_TARGET_LIVE_VIDEO_PLAY',
                'FreeVideo'=>'digi.coders.karmasu_TARGET_CATEGORY_COURSES_ACTIVITY',
                'Offer'=>'digi.coders.karmasu_TARGET_OFFER',
                'External'=>'digi.coders.karmasu_TARGET_NOTIFICATION',
            ];
        } 
        
        # To unset all sessions created for admin
        
        private function unsetAdminSession()
        {
            $this->session->unset_userdata("AdminIDSession");
            $this->session->unset_userdata("AdminEmailSession");
            $this->session->unset_userdata("AdminLoginData");
        }
        
        # To fetch admin details of current login
        
        private function fetchUserData()
        {
            $adminid = $this->session->userdata("AdminIDSession");
            $query1  = $this->db->get_where('tbl_adminlogin', array(
            'id' => $adminid
            ));
            if ($query1->num_rows() > 0) {
                $this->session->set_userdata("AdminLoginData", $query1->result_array());
                } else {
                $this->unsetAdminSession();
            }
        }
        
        # To check admin is a valid user or not
        
        private function ValidateAdminUser()
        {
            $loginStatus = true;
            if (empty($this->session->userdata("AdminEmailSession")) || empty($this->session->userdata("AdminIDSession"))) {
                $loginStatus = false;
                $this->unsetAdminSession();
                } else {
                $adminEmail = $this->session->userdata("AdminEmailSession");
                $adminId    = $this->session->userdata("AdminIDSession");
                $query1     = $this->db->query("select * from tbl_adminlogin where Email='" . $adminEmail . "' and id='" . $adminId . "' ");
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
            $adminid = $this->session->userdata("AdminIDSession");
            $this->db->where(['id'=>$adminid])->update('tbl_adminlogin',['LastLogoutDate'=>$this->date,'LastLogoutTime'=>$this->time,'CurrentStatus'=>'false']);
            $this->unsetAdminSession();
            redirect(base_url("Home/"));
        }
        
        public function TransactionPassword()
        {
            $adminid = $this->session->userdata("AdminIDSession");
            $password=$this->uri->segment(3);
            $results=$this->db->where(['id'=>$adminid])->get('tbl_adminlogin')->row();
            if($results->TransactionPassword==$password)
            {
                $results=(object)['res'=>'success'];
            }
            else{
                $results=(object)['res'=>'error'];
            }
            echo json_encode($results, JSON_UNESCAPED_UNICODE);
            
        }
        
        # Dashboard
        
        public function Dashboard()
        {
            
            if ($this->uri->segment(3) == TRUE) 
            {
                $data['action'] = $this->uri->segment(3);
                if($data['action']=='Common'){
                    
                    $data['studentCount']=$this->db->get('tbl_registration')->num_rows();
                    $data['tutorCount']=$this->db->get('tbl_tutor')->num_rows();
                    $data['courseCount']=$this->db->get('tbl_course')->num_rows();
                    $data['ebookCount']=$this->db->get('tbl_ebook')->num_rows();
                    $data['categoryCount']=$this->db->get('tbl_category')->num_rows();
                    $data['videoCount']=$this->db->get('tbl_video')->num_rows();
                    $data['liveCount']=$this->db->get('tbl_live_video')->num_rows();
                    $data['recommendedCount']=$this->db->get('tbl_recommended_videos')->num_rows();
                    $data['offerCount']=$this->db->get('tbl_offer')->num_rows();
                    $data['notificationCount']=$this->db->get('tbl_notification')->num_rows();
                    $data['contactCount']=$this->db->get('tbl_contact')->num_rows();
                    $data['teamCount']=$this->db->get('tbl_team')->num_rows();
                    
                    
                    
                }
                else if($data['action']=='Sales'){
                    
                    $CountSales=[];
                    $query = $this->db->where(['date'=>$this->dateY])->get('tbl_enroll');
                    $CountSales['TodaySales']=$this->db->where(['date'=>$this->dateY,'paymentstatus'=>'success'])->order_by('id','DESC')->get('tbl_enroll')->num_rows();
                    $data["TodaySalesList"] = $query->result();
                    $data["TodaySalesSum"]=$this->db->select_sum('price')->where(['date'=>$this->dateY,'paymentstatus'=>'success'])->order_by('id','DESC')->get('tbl_enroll')->row();
                    
                    $yesterday=date('Y-m-d', strtotime('-1 day', strtotime($this->dateY)));
                    $query = $this->db->where(['date'=>$yesterday])->order_by('id','DESC')->get('tbl_enroll');
                    $CountSales['YesterdaySales']=$this->db->where(['date'=>$yesterday,'paymentstatus'=>'success'])->order_by('id','DESC')->get('tbl_enroll')->num_rows();
                    $data["YesterdaySalesList"] = $query->result();
                    $data["YesterdaySalesSum"]=$this->db->select_sum('price')->where(['date'=>$yesterday,'paymentstatus'=>'success'])->order_by('id','DESC')->get('tbl_enroll')->row();
                    
                    
                    $w_day = date('w');
                    $week_start = date('Y-m-d', strtotime('-'.$w_day.' days'));
                    $week_end =date('Y-m-d', strtotime('+'.(6-$w_day).' days'));
                    $query = $this->db->where('date BETWEEN "'.$week_start. '" and "'.$week_end.'"')->get('tbl_enroll');
                    $CountSales['WeekSales']=$this->db->where('paymentstatus="success" AND date BETWEEN "'.$week_start. '" and "'.$week_end.'"')->order_by('id','DESC')->get('tbl_enroll')->num_rows();
                    $data["WeekSalesList"] = $query->result();
                    $data["WeekSalesSum"]=$this->db->select_sum('price')->where('paymentstatus="success" AND date BETWEEN "'.$week_start. '" and "'.$week_end.'"')->order_by('id','DESC')->get('tbl_enroll')->row();
                    
                    $month_start = date('Y-m-d',strtotime('first day of this month', time()));
                    $month_end = date('Y-m-d',strtotime('last day of this month', time()));
                    $query = $this->db->where('date BETWEEN "'.$month_start. '" and "'.$month_end.'"')->get('tbl_enroll');
                    $CountSales['MonthSales']=$this->db->where('paymentstatus="success" AND date BETWEEN "'.$month_start. '" and "'.$month_end.'"')->order_by('id','DESC')->get('tbl_enroll')->num_rows();
                    $data["MonthSalesList"] = $query->result();
                    $data["MonthSalesSum"]=$this->db->select_sum('price')->where('paymentstatus="success" AND date BETWEEN "'.$month_start. '" and "'.$month_end.'"')->order_by('id','DESC')->get('tbl_enroll')->row();
                    
                    $data['CountSales']=(object) $CountSales;
                }
                else if($data['action']=='Student'){
                    
                    $CountStudent=[];
                    $query = $this->db->where(['CurrentStatus'=>'true'])->order_by('id','DESC')->get('tbl_registration');
                    $CountStudent['ActiveStudent']=$query->num_rows();
                    $data["ActiveStudentList"] = $query->result();
                    
                    
                    $query = $this->db->where(['dateY'=>$this->dateY])->order_by('id','DESC')->get('tbl_registration');
                    $CountStudent['TodayStudent']=$query->num_rows();
                    $data["TodayStudentList"] = $query->result();
                    
                    $yesterday=date('Y-m-d', strtotime('-1 day', strtotime($this->dateY)));
                    $query = $this->db->where(['dateY'=>$yesterday])->order_by('id','DESC')->get('tbl_registration');
                    $CountStudent['YesterdayStudent']=$query->num_rows();
                    $data["YesterdayStudentList"] = $query->result();
                    
                    $w_day = date('w');
                    $week_start = date('Y-m-d', strtotime('-'.$w_day.' days'));
                    $week_end =date('Y-m-d', strtotime('+'.(6-$w_day).' days'));
                    
                    $query = $this->db->where('dateY BETWEEN "'.$week_start. '" and "'.$week_end.'"')->order_by('id','DESC')->get('tbl_registration');
                    $CountStudent['WeekStudent']=$query->num_rows();
                    $data["WeekStudentList"] = $query->result();
                    
                    $month_start = date('Y-m-d',strtotime('first day of this month', time()));
                    $month_end = date('Y-m-d',strtotime('last day of this month', time()));
                    $query = $this->db->where('dateY BETWEEN "'.$month_start. '" and "'.$month_end.'"')->order_by('id','DESC')->get('tbl_registration');
                    $CountStudent['MonthStudent']=$query->num_rows();
                    $data["MonthStudentList"] = $query->result();
                    
                    $data['CountStudent']=(object) $CountStudent;
                    
                }
                else if($data['action']=='Course'){
                    
                    $CountCourse=[];
                    $query = $this->db->where(['itemtype'=>'Course'])->order_by('id','DESC')->get('tbl_enroll');
                    $CountCourse['PurchasedCourse']=$this->db->where(['itemtype'=>'Course','paymentstatus'=>'success'])->order_by('id','DESC')->get('tbl_enroll')->num_rows();
                    $data["PurchasedCourseList"] = $query->result();
                    
                    $return=[];
					$i=0;
					foreach ($data["PurchasedCourseList"] as $item){
						$return[$i]=$item;
						$return[$i]->item=$this->db->where('id',$item->itemid)->order_by('id','DESC')->get('tbl_course')->row();
						$i++;
                    }
					$data["PurchasedCourseList"]=$return;
                    
                    
                    
                    $query = $this->db->where_not_in('trending',array('Trending'))->order_by("trending", "ASC")->get('tbl_course');
                    $CountCourse['TrendingCourse']=$query->num_rows();
                    $data["TrendingCourseList"] = $query->result();
                    
                    $query = $this->db->where(['itemtype'=>'Course','status'=>'true'])->order_by('id','DESC')->get('tbl_review');
                    $CountCourse['ActiveReview']=$query->num_rows();
                    $data["ActiveReviewList"] = $query->result();
                    
                    $return=[];
					$i=0;
					foreach ($data["ActiveReviewList"] as $item){
						
                        $itemValues=$this->db->where('id',$item->itemid)->get('tbl_course')->row();
                        $userValues=$this->db->where('id',$item->userid)->get('tbl_registration')->row();
                        if($itemValues){
                            if($userValues){
                                $return[$i]=$item;
                                $return[$i]->item=$itemValues;
                                $return[$i]->user=$userValues;
                                $i++;
                            }
                        }	
                    }
					$data["ActiveReviewList"]=$return;
                    
                    $query = $this->db->where(['itemtype'=>'Course','status'=>'false'])->order_by('id','DESC')->get('tbl_review');
                    $CountCourse['InactiveReview']=$query->num_rows();
                    $data["InactiveReviewList"] = $query->result();
                    
                    $return=[];
					$i=0;
					foreach ($data["InactiveReviewList"] as $item){
						
                        $itemValues=$this->db->where('id',$item->itemid)->get('tbl_course')->row();
                        $userValues=$this->db->where('id',$item->userid)->get('tbl_registration')->row();
                        if($itemValues){
                            if($userValues){
                                $return[$i]=$item;
                                $return[$i]->item=$itemValues;
                                $return[$i]->user=$userValues;
                                $i++;
                            }
                        }	
                    }
					$data["InactiveReviewList"]=$return;
                    
                    
                    $data['CountCourse']=(object) $CountCourse;
                    
                    
                }
                else if($data['action']=='Ebook'){
                    
                    $CountEbook=[];
                    $query = $this->db->where(['itemtype'=>'Ebook'])->order_by('id','DESC')->get('tbl_enroll');
                    $CountEbook['PurchasedEbook']=$this->db->where(['itemtype'=>'Ebook','paymentstatus'=>'success'])->order_by('id','DESC')->get('tbl_enroll')->num_rows();
                    $data["PurchasedEbookList"] = $query->result();
                    
                    $return=[];
					$i=0;
					foreach ($data["PurchasedEbookList"] as $item){
                        $itemValues=$this->db->where('id',$item->itemid)->get('tbl_ebook')->row();
                        if($itemValues){
                            $return[$i]=$item;
                            $return[$i]->item=$itemValues;
                            $i++;
                        }
                    }
					$data["PurchasedEbookList"]=$return;
                    
                    $query = $this->db->order_by('id','DESC')->get('tbl_ebook');
                    $CountEbook['TotalEbook']=$query->num_rows();
                    $data["EbookList"] = $query->result();
                    
                    $query = $this->db->where(['itemtype'=>'Ebook','status'=>'true'])->order_by('id','DESC')->get('tbl_review');
                    $CountEbook['ActiveReview']=$query->num_rows();
                    $data["ActiveReviewList"] = $query->result();
                    
                    $return=[];
					$i=0;
					foreach ($data["ActiveReviewList"] as $item){
						
                        $itemValues=$this->db->where('id',$item->itemid)->get('tbl_ebook')->row();
                        $userValues=$this->db->where('id',$item->userid)->get('tbl_registration')->row();
                        if($itemValues){
                            if($userValues){
                                $return[$i]=$item;
                                $return[$i]->item=$itemValues;
                                $return[$i]->user=$userValues;
                                $i++;
                            }
                        }	
                    }
					$data["ActiveReviewList"]=$return;
                    
                    $query = $this->db->where(['itemtype'=>'Ebook','status'=>'false'])->order_by('id','DESC')->get('tbl_review');
                    $CountEbook['InactiveReview']=$query->num_rows();
                    $data["InactiveReviewList"] = $query->result();
                    
                    $return=[];
					$i=0;
					foreach ($data["InactiveReviewList"] as $item){
						
                        $itemValues=$this->db->where('id',$item->itemid)->get('tbl_ebook')->row();
                        $userValues=$this->db->where('id',$item->userid)->get('tbl_registration')->row();
                        if($itemValues){
                            if($userValues){
                                $return[$i]=$item;
                                $return[$i]->item=$itemValues;
                                $return[$i]->user=$userValues;
                                $i++;
                            }
                        }	
                    }
					$data["InactiveReviewList"]=$return;
                    
                    $data['CountEbook']=(object) $CountEbook;
                    
                }
                
            }
            else{
                redirect(base_url('AdminPanel/Dashboard/Common')); 
            }
            $this->load->view("AdminPanel/Dashboard.php",$data);
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
                        $message='Mark Success by Admin';
                    }
                    else{
                        $message='Mark Failed by Admin';
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
                            unlink('./uploads/' . $unlink_folder . '/' . $resdata[0][$unlink_column_name]);
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
                    $query = $this->db->where('id', $id)->get($table);
                    if ($query->num_rows()) 
                    {
                        $data["lists"] = $query->result();
                        $data['author']=$this->db->where('id',$data["list"][0]->author)->get('tbl_tutor')->result();
                        
                        $data['category']=$this->db->where('id',$data["list"][0]->category)->get('tbl_category')->result();
                        
                        $data['videolist']=$this->db->where('status','true')->where('author',$data["list"][0]->author)->get('tbl_video')->result();
                        
                        $data['subjectlist']=$this->db->where('status','true')->get('tbl_subject')->result();
                        
                        if($action=='Edit')
                        {
                            $this->load->view("AdminPanel/UpdateCourse", $data);
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
                            
                            $this->load->view("AdminPanel/CourseFullDetails", $data);
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
                                // echo 1;
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
                                        $config['max_size'] = 10000000; // In KB
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
                                        $config['max_size'] = 1000000000; // In KB
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
                            redirect(base_url('AdminPanel/ManageCourses/Details/'.$id));  
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
                            redirect(base_url('AdminPanel/ManageCourses/Details/'.$id));
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
                            redirect(base_url('AdminPanel/ManageCourses'));     
                        }
                    }
                    else
                    {
                        redirect(base_url('AdminPanel/ManageCourses')); 
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
                                $this->form_validation->set_rules('courselogo', 'Course Logo/image', 'required');
                            }
                            if (empty($_FILES["coursebanner"]["name"])) {
                                $this->form_validation->set_rules('coursebanner', 'Course Banner', 'required');
                            }
                            $this->form_validation->set_rules('coursedemovideo', 'Course Demo Video', 'required');
                            $this->form_validation->set_rules('certificationcheck', 'Certification', 'required');
                            
                            if ($this->form_validation->run() == FALSE){
                                redirect(base_url('AdminPanel/ManageCourses/Add')); 
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
                                    $config['max_size']      = 10000000; // In KB
                                    $config['file_name']     = $logo_filename;
                                    $this->load->library('upload', $config);
                                    if (!$this->upload->do_upload('courselogo')) {
                                        array_push($upload_errors, array(
										'error_upload_logo' => $this->upload->display_errors()
                                        ));
                                    }
                                    
                                    $config['upload_path']   = './uploads/course/';
                                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                    $config['max_size']      = 10000000; // In KB
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
                                        redirect(base_url('AdminPanel/ManageCourses/Add'));
                                    } 
                                    else 
                                    {
                                        $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
                                        redirect(base_url('AdminPanel/ManageCourses/Add'));
                                    }
                                }
                                else
                                {
                                    $this->session->set_flashdata(array('res'=>'error','msg'=>'Something went wrong in Data Shaving.'));
                                    redirect(base_url('AdminPanel/ManageCourses/Add'));
                                }
                            }
                        }
                        else
                        {
                            $this->load->view("AdminPanel/AddCourse.php",$data);
                        }
                    }
                    else if($action=='Update')
                    {
                        if (isset($_POST["updateaction"])) 
                        {  
                            if(empty($this->input->post("id")))
                            {
                                $this->session->set_flashdata(array('res'=>'error','msg'=>'ID is required.'));
                                redirect(base_url('AdminPanel/ManageCourses/Edit/'.$id));
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
                                        redirect(base_url('AdminPanel/ManageCourses/Edit/'.$id));
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
                                                $config['max_size'] = 10000000; // In KB
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
                                                $config['max_size'] = 10000000; // In KB
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
                                                redirect(base_url('AdminPanel/ManageCourses'));
                                            }
                                            else
                                            {
                                                $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
                                                $data['upload_errors']=$upload_errors;
                                                redirect(base_url('AdminPanel/ManageCourses/Edit/'.$id));
                                            }
                                        }
                                        else
                                        {
                                            
                                            $this->session->set_flashdata(array('res'=>'error','msg'=>'Something went wrong in Data Shaving.'));
                                            redirect(base_url('AdminPanel/ManageCourses/Edit/'.$id));
                                        }
                                    }
                                }
                                else{
                                    redirect(base_url('AdminPanel/ManageCourses'));
                                }
                            }
                        }
                        else{
                            redirect(base_url('AdminPanel/ManageCourses'));
                        }
                    }
                    
                }
                
            }
            else 
            {
                if(!empty($_REQUEST['author'])){
                    $query = $this->db->where('author',$_REQUEST['author'])->order_by("id", "DESC")->get($table);
                }
                else{
                    $query = $this->db->order_by("id", "DESC")->get($table);
                }
                
                $data["list"] = $query->result();
                $i=0;$return=[];
                foreach( $data["list"] as $item)
                {
                    $return[$i]=$item;
                    $return[$i]->author=$this->db->where('id',$item->author)->get('tbl_tutor')->row();
                    $i++;
                }
                $this->load->view("AdminPanel/ManageCourses", $data);
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
                    $query = $this->db->where('id', $id)->get($table);
                    if ($query->num_rows()) 
                    {
                        $data["list"] = $query->result();
                        
                        $data['author']=$this->db->where('id',$data["list"][0]->author)->get('tbl_tutor')->result();
                        $data['category']=$this->db->where('id',$data["list"][0]->category)->get('tbl_category')->result();
                        if($action=='Edit')
                        {
                            $this->load->view("AdminPanel/UpdateEBook", $data);
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
                            
                            $this->load->view("AdminPanel/EBookFullDetails", $data);
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
                                        $config['max_size'] = 100000000; // In KB
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
                            redirect(base_url('AdminPanel/ManageEBooks/Details/'.$id));  
                        }
                        else
                        {
                            redirect(base_url('AdminPanel/ManageEBooks'));
                        }
                    }
                    else
                    {
                        redirect(base_url('AdminPanel/ManageEBooks'));
                    }
                }
                else 
                {
                    if($action=='Add'){
                        

                        if (isset($_POST["addaction"])) 
                        {    

                            $this->form_validation->set_rules('ebookname', 'EBook Name', 'required', array(
                            'required' => '%s is Required Field'
                            ));
                            $this->form_validation->set_rules('category', 'Category', 'required');
                            $this->form_validation->set_rules('author', 'Author', 'required');
                            $this->form_validation->set_rules('ebooktype', 'EBook Type', 'required');
                            $this->form_validation->set_rules('ebookprice', 'EBook Price', 'required');
                            $this->form_validation->set_rules('ebookshortdescription', 'Short Description', 'required');
                            $this->form_validation->set_rules('noofpages', 'No of Pages', 'required');
                            $this->form_validation->set_rules('daystofinish', 'Days to Dinish', 'required');
                            if (empty($_FILES["ebooklogo"]["name"])) {
                                $this->form_validation->set_rules('ebooklogo', 'EBook Logo/image', 'required');
                            }
                            if (empty($_FILES["ebookbanner"]["name"])) {
                                $this->form_validation->set_rules('ebookbanner', 'EBook Banner', 'required');
                            }
                            // if (empty($_FILES["ebooksample"]["name"])) {
                            //     //$this->form_validation->set_rules('ebooksample', 'EBook Sample', 'required');
                            // }
                            // if (empty($_FILES["ebook"]["name"])) {
                            //     // $this->form_validation->set_rules('ebook', 'EBook PDF File', 'required');
                            // }
                            if ($this->form_validation->run() == FALSE){
                                $msg=explode('</p>',validation_errors());
                                $msg=str_ireplace('<p>','', $msg[0]);
                                $this->session->set_flashdata(array('res'=>'error','msg'=>$msg));
                                redirect(base_url('AdminPanel/ManageEBooks/Add'));
                            } 
                            else 
                            {
                                $logo_ext      = pathinfo($_FILES["ebooklogo"]["name"], PATHINFO_EXTENSION);
                                $logo_filename = time() . "_ebook_logo." . $logo_ext;
                                
                                $banner_ext      = pathinfo($_FILES["ebookbanner"]["name"], PATHINFO_EXTENSION);
                                $banner_filename = time() . "_ebook_banner." . $banner_ext;
                                
                                // $sample_ext      = pathinfo($_FILES["ebooksample"]["name"], PATHINFO_EXTENSION);
                                // $sample_filename = time() . "_ebook_sample." . $sample_ext;

                                $ebook_ext      = pathinfo($_FILES["ebook"]["name"], PATHINFO_EXTENSION);
                                // $ebook_filename = $_FILES["ebook"]["name"];
                                 $ebook_filename = time(). '.' . $ebook_ext;
                                //  print_r($ebook_filename); 
                                $data_to_insert                = array(
                                "category" => $this->input->post("category"),
                                "author" => $this->input->post("author"),
                                "name" => $this->input->post("ebookname"),
                                "logo" => $logo_filename,
                                "banner" => $banner_filename,
                               // "sample" => $sample_filename,
                                "ebook" => $ebook_filename,
                                "type" => $this->input->post("ebooktype"),
                                "price" => $this->input->post("ebookprice"),
                                "offerprice" => $this->input->post("ebookofferprice"),
                                "shortdesc" => $this->input->post("ebookshortdescription"),
                                "noofpages" => $this->input->post("noofpages"),
                                "daystofinish" => $this->input->post("daystofinish"),
                                "offer_text" => $this->input->post("offer_text"),
                                "apprstatus" => "true",
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
                                    $config['max_size']      = 10000000; // In KB
                                    $config['file_name']     = $logo_filename;
                                    $this->load->library('upload', $config);
                                    if (!$this->upload->do_upload('ebooklogo')) {
                                        array_push($upload_errors, array(
                                        'error_upload_logo' => $this->upload->display_errors()
                                        ));
                                    }
                                    
                                    $config['upload_path']   = './uploads/ebook/';
                                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                    $config['max_size']      = 10000000; // In KB
                                    $config['file_name']     = $banner_filename;
                                    $this->upload->initialize($config);
                                    if (!$this->upload->do_upload('ebookbanner')) {
                                        array_push($upload_errors, array(
                                        'error_upload_logo' => $this->upload->display_errors()
                                        ));
                                    }
                                    
                                    // $config['upload_path']   = './uploads/ebook/';
                                    // $config['allowed_types'] = 'pdf';
                                    // $config['max_size']      = 10000000; // In KB
                                    // $config['file_name']     = $sample_filename;
                                    // $this->upload->initialize($config);
                                    // if (!$this->upload->do_upload('ebooksample')) {
                                    //     array_push($upload_errors, array(
                                    //     'error_upload_logo' => $this->upload->display_errors()
                                    //     ));
                                    // }
                                    
                                    if (!empty($_FILES["ebook"]["name"])) {
                                        
                                        $file['file_name'] = $_FILES['file']['name']     = $_FILES['ebook']['name'];
                                        $file['type'] =  $_FILES['file']['type']     = $_FILES['ebook']['type'];
                                        $file['tmp_name']  =  $_FILES['file']['tmp_name'] = $_FILES['ebook']['tmp_name'];
                                        $file['error']  =  $_FILES['file']['error']    = $_FILES['ebook']['error'];
                                        $file['size'] =   $_FILES['file']['size']     = $_FILES['ebook']['size'];
                                            //print_r($_FILES);
                                            // $file['tmp_name'] = $_FILES['ebook']['tmp_name'];
                                            $bucket = 'ebook-karmasu';
                                            // $destinationPath = 'ebook/'.$file['file_name'];
                                            $dir = dirname($file['tmp_name']);
                                            $destination = time().'.'.pathinfo($_FILES['ebook']['name'],PATHINFO_EXTENSION);
                                            // rename($_FILES["file"]["tmp_name"], $destination);
                                            // print_r($destination);
                                            
                                            $upload = $this->s3_upload->upload($_FILES["ebook"], $bucket, $destination);
                                            
                                        // print_r($result);die;
                                        if ($upload) {
                                            // Image uploaded successfully
                                            echo 'Image URL: ' . $upload;
                                        } else {
                                            // Failed to upload image
                                            echo 'Failed to upload image.';
                                        }
                                    }
                                    
                                    
                                    if (count($upload_errors) == 0) 
                                    {
                                        $this->session->set_flashdata(array('res'=>'success','msg'=>'EBook Added Successfully.'));
                                        redirect(base_url('AdminPanel/ManageEBooks/Add'));
                                    } 
                                    else 
                                    {
                                        $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
                                        redirect(base_url('AdminPanel/ManageEBooks/Add'));
                                    }
                                }
                                else
                                {
                                    $this->session->set_flashdata(array('res'=>'error','msg'=>'Something went wrong in Data Shaving.'));
                                    redirect(base_url('AdminPanel/ManageEBooks/Add'));
                                }
                            }
                        }
                        else
                        {
                            $this->load->view("AdminPanel/AddEBook.php",$data);
                        }
                    }
                    else if($action=='Update')
                    {
                        if (isset($_POST["updateaction"])) 
                        {  
                            if(empty($this->input->post("id")))
                            {
                                $this->session->set_flashdata(array('res'=>'error','msg'=>'ID is required.'));
                                redirect(base_url('AdminPanel/ManageEBooks/Edit/'.$id));
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
                                    $this->form_validation->set_rules('link', 'EBook Link', 'required');
                                    
                                    // $this->form_validation->set_rules('description', 'Description', 'required');
                                    // $this->form_validation->set_rules('requirement', 'Requirements', 'required');
                                    // $this->form_validation->set_rules('ebook_include', 'What this ebook include ?', 'required');
                                    // $this->form_validation->set_rules('will_learn', 'What you will learn ?', 'required');
                                    if ($this->form_validation->run() == FALSE)
                                    {
                                        $msg=explode('</p>',validation_errors());
                                        $msg=str_ireplace('<p>','', $msg[0]);
                                        $this->session->set_flashdata(array('res'=>'error','msg'=>$msg));
                                        redirect(base_url('AdminPanel/ManageEBooks/Edit/'.$id));
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
                                        // "link" => $this->input->post("link"),
                                        "banner" => $banner_filename,
                                        // "sample" => $sample_filename,
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
                                                $config['max_size'] = 10000000; // In KB
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
                                                $config['max_size'] = 10000000; // In KB
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
                                                $config['max_size'] = 10000000; // In KB
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
                                                redirect(base_url('AdminPanel/ManageEBooks'));
                                            }
                                            else
                                            {
                                                $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
                                                $data['upload_errors']=$upload_errors;
                                                redirect(base_url('AdminPanel/ManageEBooks/Edit/'.$id));
                                            }
                                        }
                                        else
                                        {
                                            
                                            $this->session->set_flashdata(array('res'=>'error','msg'=>'Something went wrong in Data Shaving.'));
                                            redirect(base_url('AdminPanel/ManageEBooks/Edit/'.$id));
                                        }
                                    }
                                }
                                else{
                                    redirect(base_url('AdminPanel/ManageEBooks'));
                                }
                            }
                        }
                        else{
                            redirect(base_url('AdminPanel/ManageEBooks'));
                        }
                    }
                    
                }
                
            }
            else 
            {
                if(!empty($_REQUEST['author'])){
                    $query = $this->db->where('author',$_REQUEST['author'])->order_by('apprstatus','ASC')->order_by("order_by", "DESC")->get($table);
                }
                else{
                    $query = $this->db->order_by('apprstatus','ASC')->order_by("order_by", "DESC")->get($table);
                }
                $data["list"] = $query->result();
                $this->load->view("AdminPanel/ManageEBooks", $data);
            }
        }
        public function EbookChangeOrder()
        {
            if ($this->input->post()) {
                $data = $this->input->post();
                $id = $data['id'];
                $order_by = $data['order_by'];
                
                $result = $this->db->update("tbl_ebook",['order_by'=>$order_by], ['id'=>$id]);
                // print_r($result);die;
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
                echo false;
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
                    $query = $this->db->where('id', $id)->get($table);
                    if ($query->num_rows()) 
                    {
                        $data["list"] = $query->result();
                        
                        $data['author']=$this->db->where('id',$data["list"][0]->author)->get('tbl_tutor')->result();
                        $data['category']=$this->db->where('id',$data["list"][0]->category)->get('tbl_category')->result();
                        if($action=='Edit')
                        {
                            $this->load->view("AdminPanel/UpdateAudioBook", $data);
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
                            $this->load->view("AdminPanel/AudioBookFullDetails", $data);
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
                                "topic_link" => $this->input->post("topic_link"),
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
                                        $config['max_size'] = 100000000; // In KB
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
                            redirect(base_url('AdminPanel/ManageAudioBooks/Details/'.$id));  
                        }
                        else
                        {
                            redirect(base_url('AdminPanel/ManageAudioBooks'));
                        }
                    }
                    else
                    {
                        redirect(base_url('AdminPanel/ManageAudioBooks'));
                    }
                }
                else 
                {
                    if($action=='Add'){
                        if (isset($_POST["addaction"])) 
                        {    
                            $this->form_validation->set_rules('abookname', 'abook Name', 'required', array(
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
                                $this->form_validation->set_rules('abooklogo', 'abook Logo/image', 'required');
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
                                $msg=explode('</p>',validation_errors());
                                $msg=str_ireplace('<p>','', $msg[0]);
                                $this->session->set_flashdata(array('res'=>'error','msg'=>$msg));
                                redirect(base_url('AdminPanel/ManageAudioBooks/Add'));
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
                                    $config['max_size']      = 10000000; // In KB
                                    $config['file_name']     = $logo_filename;
                                    $this->load->library('upload', $config);
                                    if (!$this->upload->do_upload('abooklogo')) {
                                        array_push($upload_errors, array(
                                        'error_upload_logo' => $this->upload->display_errors()
                                        ));
                                    }
                                    
                                    $config['upload_path']   = './uploads/abook/';
                                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                    $config['max_size']      = 10000000; // In KB
                                    $config['file_name']     = $banner_filename;
                                    $this->upload->initialize($config);
                                    if (!$this->upload->do_upload('abookbanner')) {
                                        array_push($upload_errors, array(
                                        'error_upload_logo' => $this->upload->display_errors()
                                        ));
                                    }
                                    
                                    // $config['upload_path']   = './uploads/abook/';
                                    // $config['allowed_types'] = 'pdf';
                                    // $config['max_size']      = 10000000; // In KB
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
                                        redirect(base_url('AdminPanel/ManageAudioBooks/Add'));
                                    } 
                                    else 
                                    {
                                        $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
                                        redirect(base_url('AdminPanel/ManageAudioBooks/Add'));
                                    }
                                }
                                else
                                {
                                    $this->session->set_flashdata(array('res'=>'error','msg'=>'Something went wrong in Data Shaving.'));
                                    redirect(base_url('AdminPanel/ManageAudioBooks/Add'));
                                }
                            }
                        }
                        else
                        {
                            $this->load->view("AdminPanel/AddAudioBook.php",$data);
                        }
                    }
                    else if($action=='Update')
                    {
                        if (isset($_POST["updateaction"])) 
                        {  
                            if(empty($this->input->post("id")))
                            {
                                $this->session->set_flashdata(array('res'=>'error','msg'=>'ID is required.'));
                                redirect(base_url('AdminPanel/ManageAudioBooks/Edit/'.$id));
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
                                        $msg=explode('</p>',validation_errors());
                                $msg=str_ireplace('<p>','', $msg[0]);
                                $this->session->set_flashdata(array('res'=>'error','msg'=>$msg));
                                        redirect(base_url('AdminPanel/ManageAudioBooks/Edit/'.$id));
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
                                                $config['max_size'] = 10000000; // In KB
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
                                                $config['max_size'] = 10000000; // In KB
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
                                            // $config['max_size'] = 10000000; // In KB
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
                                                redirect(base_url('AdminPanel/ManageAudioBooks'));
                                            }
                                            else
                                            {
                                                $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
                                                $data['upload_errors']=$upload_errors;
                                                redirect(base_url('AdminPanel/ManageAudioBooks/Edit/'.$id));
                                            }
                                        }
                                        else
                                        {
                                            
                                            $this->session->set_flashdata(array('res'=>'error','msg'=>'Something went wrong in Data Shaving.'));
                                            redirect(base_url('AdminPanel/ManageAudioBooks/Edit/'.$id));
                                        }
                                    }
                                }
                                else{
                                    redirect(base_url('AdminPanel/ManageAudioBooks'));
                                }
                            }
                        }
                        else{
                            redirect(base_url('AdminPanel/ManageAudioBooks'));
                        }
                    }
                    
                }
                
            }
            else 
            {
                if(!empty($_REQUEST['author'])){
                    $query = $this->db->where('author',$_REQUEST['author'])->order_by("id", "DESC")->get($table);
                }
                else{
                    $query = $this->db->order_by("id", "DESC")->get($table);
                }
                $data["list"] = $query->result();
                $this->load->view("AdminPanel/ManageAudioBooks", $data);
            }
        }
        
        # Subject Management
        
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
                            $this->load->view("AdminPanel/Modal", $data);
                        }
                        else if($action=='VideosList'){
                            $data["action"]="VideosList";
                            $data["videoslist"] =$this->db->where('subject', $id)->get('tbl_video')->result();
                            $this->load->view("AdminPanel/Modal", $data);
                        }
                        else
                        {
                            redirect(base_url('AdminPanel/ManageSubjects'));
                        }
                    }
                    else
                    {
                        redirect(base_url('AdminPanel/ManageSubjects')); 
                    }
                }
                else 
                {
                    if($action=='Add'){
                        if (isset($_POST["addaction"])) 
                        {    
                            $this->form_validation->set_rules('name', 'Subject Name', 'required|is_unique[tbl_subject.name]', array(
							'required' => '%s is Required Field',
							'is_unique' => '%s is Already Exists'
                            ));
                            if ($this->form_validation->run() == FALSE){
                            } 
                            else 
                            {
                                $data_to_insert= array(
								"name" => $this->input->post("name"),
								"videos" =>'0',
								"status" => "true",
								"date" => $this->date,
								"time" => $this->time
                                );
                                $data_to_insert = $this->security->xss_clean($data_to_insert);
                                
                                if ($this->db->insert($table, $data_to_insert)) {
                                    $this->session->set_flashdata(array('res'=>'success','msg'=>'Subject Added Successfully.'));
                                }
                                else 
                                {
                                    $this->session->set_flashdata(array('res'=>'error','msg'=>'Something went wrong in Data Shaving.'));
                                }
                            }
                        }
                        
                        redirect(base_url('AdminPanel/ManageSubjects'));
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
                                    
                                    $this->form_validation->set_rules('name', 'Subject Name', 'required', array('required' => '%s is Required Field'));
                                    if ($this->form_validation->run() == FALSE){
                                    } 
                                    else 
                                    { 
                                        $data_to_update= array(
                                        "name" => $this->input->post("name")
                                        );
                                        $data_to_update = $this->security->xss_clean($data_to_update);
                                        $result=$this->db->where('id',$data['list'][0]->id)
                                        ->update($table,$data_to_update);
                                        
                                        if($result) 
                                        {
                                            $this->session->set_flashdata(array('res'=>'success','msg'=>'Subject Updated Successfully.')); 
                                        }
                                        else 
                                        {
                                            $this->session->set_flashdata(array('res'=>'error','msg'=>'Something went wrong in Data Shaving.'));
                                        }
                                    }
                                }
                            }
                        }
                        
                        redirect(base_url('AdminPanel/ManageSubjects'));
                    }
                    else if($action=='QuestionsList')
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
            else 
            {
                $query = $this->db->order_by("id", "DESC")->get($table);
                $i=0;
                $return=[];
                foreach($query->result() as $item){
                    $return[$i]=$item;
                    $return[$i]->videos=$this->db->where(['subject'=>$item->id])->get('tbl_video')->num_rows();
                    $i++;
                }
                $data["list"] =$return;
                $this->load->view("AdminPanel/ManageSubjects", $data);
            }
        }
        
        # Sliders Management
        
        public function ManageSliders()
        {
            $table='tbl_slider';
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
                            $data["action"]="EditSlider";
                            $this->load->view("AdminPanel/Modal", $data);
                        }
                        else
                        {
                            redirect(base_url('AdminPanel/ManageSliders'));
                        }
                    }
                    else
                    {
                        redirect(base_url('AdminPanel/ManageSliders'));
                    }
                }
                else 
                {
                    if($action=='Add'){
                        if (isset($_POST["addaction"])) 
                        {    
                            $this->form_validation->set_rules('title', 'Slider Title', 'required', array('required' => '%s is Required Field'));
                            //$this->form_validation->set_rules('slidertype', 'Slider Type', 'required', array('required' => '%s is Required Field'));
                            // $this->form_validation->set_rules('link', 'Slider Link', 'required', array('required' => '%s is Required Field'));
                            
                            if (empty($_FILES["image"]["name"])) {
                                $this->form_validation->set_rules('image', 'Slider Image', 'required');
                            }
                            else{
                                $ext      = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                                $filename = time().rand(). "." . $ext;
                            }
                            
                            if ($this->form_validation->run() == FALSE){
                            } 
                            else 
                            {
                                $data_to_insert= array(
                                "image" => $filename,
                                "title" => $this->input->post("title"),
                                "link" => $this->input->post("link"),
                                "type" => $this->input->post("slidertype"),
                                "status" => "true",
                                "date" => $this->date,
                                "time" => $this->time
                                );
                                
                                $data_to_insert = $this->security->xss_clean($data_to_insert);
                                
                                if ($this->db->insert($table, $data_to_insert)) {
                                    $upload_errors           = array();
                                    $config['upload_path']   = './uploads/slider/';
                                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                    $config['max_size']      = 10000000;
                                    $config['file_name']     = $filename;
                                    $this->load->library('upload', $config);
                                    if (!$this->upload->do_upload('image')) {
                                        array_push($upload_errors, array(
                                        'error_upload_logo' => $this->upload->display_errors()
                                        ));
                                        $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
                                        
                                    }
                                    else{
                                        $this->session->set_flashdata(array('res'=>'success','msg'=>'Slider Added Successfully.'));
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
                                    
                                    $this->form_validation->set_rules('title', 'Slider Title', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('link', 'Slider Link', 'required', array('required' => '%s is Required Field'));
                                    if ($this->form_validation->run() == FALSE){
                                    } 
                                    else 
                                    {
                                        $old_filename=$data['list'][0]->image;
                                        $filename=$old_filename;
                                        if (!empty($_FILES["image"]["name"])) {
                                            $ext      = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                                            $filename = time().rand(). "." . $ext;
                                        }  
                                        $data_to_update= array(
                                        "image" => $filename,
                                        "title" => $this->input->post("title"),
                                        "link" => $this->input->post("link")
                                        );
                                        $data_to_update = $this->security->xss_clean($data_to_update);
                                        $result=$this->db->where('id',$data['list'][0]->id)
                                        ->update($table,$data_to_update);
                                        
                                        if($result) 
                                        {
                                            $this->session->set_flashdata(array('res'=>'success','msg'=>'Slider Updated Successfully.')); 
                                            if (!empty($_FILES["image"]["name"])) {
                                                $upload_errors           = array();
                                                $config['upload_path']   = './uploads/slider/';
                                                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                                $config['max_size']      = 10000000;
                                                $config['file_name']     = $filename;
                                                $this->load->library('upload', $config);
                                                if (!$this->upload->do_upload('image')) {
                                                    array_push($upload_errors, array(
                                                    'error_upload_logo' => $this->upload->display_errors()
                                                    ));
                                                    $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
                                                }
                                                unlink('./uploads/slider/'.$old_filename);
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
                    redirect(base_url('AdminPanel/ManageSliders'));
                }
            }
            else 
            {
                $query = $this->db->where("type","Website")->order_by("id", "DESC")->get($table);
                $data["list"] = $query->result();
                $this->load->view("AdminPanel/ManageSliders", $data);
            }
        }
        
        # Categories Management
        
        public function ManageCategories()
        {
            $table='tbl_category';
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
                            $data["action"]="EditCategory";
                            $this->load->view("AdminPanel/Modal", $data);
                        }
                        else
                        {
                            redirect(base_url('AdminPanel/ManageCategories'));
                        }
                    }
                    else
                    {
                        redirect(base_url('AdminPanel/ManageCategories'));
                    }
                }
                else 
                {
                    if($action=='Add')
                    {
                        if (isset($_POST["addaction"])) 
                        {    
                            $this->form_validation->set_rules('title', 'Category Title', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('description', 'Category Description', 'required', array('required' => '%s is Required Field'));
                            // $this->form_validation->set_rules('color', 'Color Code', 'required', array('required' => '%s is Required Field'));
                            if (empty($_FILES["icon"]["name"])) {
                                $this->form_validation->set_rules('icon', 'Category image', 'required');
                            }
                            else{
                                $ext      = pathinfo($_FILES["icon"]["name"], PATHINFO_EXTENSION);
                                $filename = time().rand(). "." . $ext;
                            }
                            if ($this->form_validation->run() == FALSE){
                            } 
                            else 
                            {
                                $data_to_insert= array(
                                "title" => $this->input->post("title"),
                                "description" => $this->input->post("description"),
                                "icon" =>$filename,
                                // "color" => $this->input->post("color"),
                                "status" => "true",
                                "date" => $this->date,
                                "time" => $this->time
                                );
                                $data_to_insert = $this->security->xss_clean($data_to_insert);
                                if ($this->db->insert($table, $data_to_insert)) {
                                    $upload_errors           = array();
                                    $config['upload_path']   = './uploads/category/';
                                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                    $config['max_size']      = 10000000;
                                    $config['file_name']     = $filename;
                                    $this->load->library('upload', $config);
                                    if (!$this->upload->do_upload('icon')) {
                                        array_push($upload_errors, array(
                                        'error_upload_logo' => $this->upload->display_errors()
                                        ));
                                        $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
                                    }
                                    else{
                                        $this->session->set_flashdata(array('res'=>'success','msg'=>'Category Added Successfully.'));
                                    }
                                }
                                else 
                                {
                                    $this->session->set_flashdata(array('res'=>'error','msg'=>'Something went wrong in Data Shaving.'));
                                }
                            }
                        }
                    }
                    
                    else if($action=='Update')
                    {
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
                                    
                                    $this->form_validation->set_rules('title', 'Category Title', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('description', 'Category Description', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('color', 'Color Code', 'required', array('required' => '%s is Required Field'));
                                    if ($this->form_validation->run() == FALSE){
                                    } 
                                    else 
                                    {
                                        $old_filename=$data['list'][0]->image;
                                        $filename=$old_filename;
                                        if (!empty($_FILES["icon"]["name"])) {
                                            $ext      = pathinfo($_FILES["icon"]["name"], PATHINFO_EXTENSION);
                                            $filename = time().rand(). "." . $ext;
                                        }  
                                        $data_to_update= array(
                                        "title" => $this->input->post("title"),
                                        "description" => $this->input->post("description"),
                                        "icon" =>$filename,
                                        // "color" => $this->input->post("color")
                                        );
                                        $data_to_update = $this->security->xss_clean($data_to_update);
                                        $result=$this->db->where('id',$data['list'][0]->id)
                                        ->update($table,$data_to_update);
                                        
                                        if($result) 
                                        {
                                            $this->session->set_flashdata(array('res'=>'success','msg'=>'Category Updated Successfully.')); 
                                            if (!empty($_FILES["icon"]["name"])) {
                                                $upload_errors           = array();
                                                $config['upload_path']   = './uploads/category/';
                                                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                                $config['max_size']      = 10000000;
                                                $config['file_name']     = $filename;
                                                $this->load->library('upload', $config);
                                                if (!$this->upload->do_upload('icon')) {
                                                    array_push($upload_errors, array(
                                                    'error_upload_logo' => $this->upload->display_errors()
                                                    ));
                                                    $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
                                                }
                                                unlink('./uploads/category/'.$old_filename);
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
                    redirect(base_url('AdminPanel/ManageCategories'));
                }
                
            }
            else 
            {
                $query = $this->db->order_by("id", "DESC")->get($table);
                $data["list"] = $query->result();
                $this->load->view("AdminPanel/ManageCategories", $data);
            }
        }

         # Shop Categories
        
         public function ShopCategories()
         {
             $table='tbl_shop_categories';
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
                             $data["action"]="EditShopCategory";
                             $this->load->view("AdminPanel/Modal", $data);
                         }
                         else
                         {
                             redirect(base_url('AdminPanel/ShopCategories'));
                         }
                     }
                     else
                     {
                         redirect(base_url('AdminPanel/ShopCategories'));
                     }
                 }
                 else 
                 {
                     if($action=='Add')
                     {
                         if (isset($_POST["addaction"])) 
                         {    
                             $this->form_validation->set_rules('title', 'Shop Category Title', 'required', array('required' => '%s is Required Field'));
                             $this->form_validation->set_rules('url', 'Shop Category Url', 'required', array('required' => '%s is Required Field'));
                            //  $this->form_validation->set_rules('image_url', 'Shop Category Image Url', 'required', array('required' => '%s is Required Field'));
                             
                             if (empty($_FILES["image"]["name"])) {
                                 $this->form_validation->set_rules('image', 'Shop Category image', 'required');
                             }
                             else{
                                $ext      = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                                $filename = time().rand(). "." . $ext;
                                $data_to_insert= array(
                                    "title" => $this->input->post("title"),
                                    "image" => $filename,
                                    "url" => $this->input->post("url"),
                                    'image_url' => base_url() . 'uploads/shopcategory/' . $filename,
                                    // "status" => "true",
                                    // "date" => $this->date,
                                    // "time" => $this->time
                                );
                                $data_to_insert = $this->security->xss_clean($data_to_insert);
                                
                                if ($this->db->insert($table, $data_to_insert)) {
                                    $upload_errors           = array();
                                    $config['upload_path']   = './uploads/shopcategory/';
                                    $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
                                    $config['max_size']      = 10000000;
                                    $config['file_name']     = $filename;
                                    $this->load->library('upload', $config);
                                    // print_r($config);die;
                                    if (!$this->upload->do_upload('image')) {
                                        array_push($upload_errors, array(
                                        'error_upload_logo' => $this->upload->display_errors()
                                        ));
                                        $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
                                    }
                                    else{
                                        $this->session->set_flashdata(array('res'=>'success','msg'=>'Spirituality image Added Successfully.'));
                                    }
                                }
                                else 
                                {
                                    $this->session->set_flashdata(array('res'=>'error','msg'=>'Something went wrong in Data Shaving.'));
                                }
                             }
                         }
                     }
                     
                     else if($action=='Update')
                     {
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
                                   $row=$query->row();
                                   $old_filename= $row->image;
                                   $filename="";
                                   if (!empty($_FILES["image"]["name"])) {
                                       $ext      = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                                       $filename = time().rand(). "." . $ext;
                                   }  
                                   $data_to_update= array(
                                    "title" => $this->input->post("title"),
                                    "image" => $filename,
                                    "url" => $this->input->post("url"),
                                    'image_url' => base_url() . 'uploads/shopcategory/' . $filename,
                                   );
                                   $data_to_update = $this->security->xss_clean($data_to_update);
                                   $result=$this->db->where('id', $row->id)
                                   ->update($table,$data_to_update);
                                   
                                   if($result) 
                                   {
                                       $this->session->set_flashdata(array('res'=>'success','msg'=>'Spirituality Image Updated Successfully.')); 
                                       if (!empty($_FILES["image"]["name"])) {
                                           $upload_errors           = array();
                                           $config['upload_path']   = './uploads/shopcategory/';
                                           $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                           $config['max_size']      = 10000000;
                                           $config['file_name']     = $filename;
                                           $this->load->library('upload', $config);
                                           if ($this->upload->do_upload('image')) {
                                                 
                                               @unlink('./uploads/shopcategory/'.$old_filename);
                                           }
                                           
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
                     redirect(base_url('AdminPanel/ShopCategories'));
                 }
                 
             }
             else 
             {
                 $query = $this->db->order_by("id", "DESC")->get($table);
                 $data["list"] = $query->result();
                 $this->load->view("AdminPanel/ShopCategories", $data);
             }
         }
        
           public function ManageSpirituality()
         {
             $table='tbl_spirituality';
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
                             $data["action"]="EditSpirituality";
                             $this->load->view("AdminPanel/Modal", $data);
                         }
                         else
                         {
                             redirect(base_url('AdminPanel/ManageSpirituality'));
                         }
                     }
                     else
                     {
                         redirect(base_url('AdminPanel/ManageSpirituality'));
                     }
                 }
                 else 
                 {
                     if($action=='Add')
                     {
                         if (isset($_POST["addaction"])==true) 
                         {    
                              $this->form_validation->set_rules('link', 'Spirituality Link', 'required', array('required' => '%s is Required Field'));
                             //  $this->form_validation->set_rules('description', 'Category Description', 'required', array('required' => '%s is Required Field'));
                             // $this->form_validation->set_rules('color', 'Color Code', 'required', array('required' => '%s is Required Field'));
                             if (empty($_FILES["image"]["name"])) {
                                 $this->form_validation->set_rules('image', 'Spirituality Image', 'required');
                                }
                                else{
                                    $ext      = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                                    $filename = time().rand(). "." . $ext;
                                    $data_to_insert= array(
                                        "image" => $filename,
                                        'image_path' => base_url() . 'uploads/spirituality/' . $filename,
                                        "link" => $this->input->post("link"),
                                        "status" => "true",
                                        "date" => $this->date,
                                        "time" => $this->time
                                    );
                                    $data_to_insert = $this->security->xss_clean($data_to_insert);
                                    
                                    if ($this->db->insert($table, $data_to_insert)) {
                                        $upload_errors           = array();
                                        $config['upload_path']   = './uploads/spirituality/';
                                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                        $config['max_size']      = 10000000;
                                        $config['file_name']     = $filename;
                                        $this->load->library('upload', $config);
                                        // print_r($config);die;
                                        if (!$this->upload->do_upload('image')) {
                                            array_push($upload_errors, array(
                                            'error_upload_logo' => $this->upload->display_errors()
                                            ));
                                            $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
                                        }
                                        else{
                                            $this->session->set_flashdata(array('res'=>'success','msg'=>'Spirituality image Added Successfully.'));
                                        }
                                    }
                                    else 
                                    {
                                        $this->session->set_flashdata(array('res'=>'error','msg'=>'Something went wrong in Data Shaving.'));
                                    }
                                    
                                }
                         }
                     }
                     
                     else if($action=='Update')
                    {
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
                                    $row=$query->row();
                                    $old_filename= $row->image;
                                   $filename="";
                                    if (!empty($_FILES["image"]["name"])) {
                                        $ext      = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                                        $filename = time().rand(). "." . $ext;
                                    }  
                                    $data_to_update= array(
                                        "image" =>$filename,
                                        "link" => $this->input->post("link"),
                                    );
                                    $data_to_update = $this->security->xss_clean($data_to_update);
                                    $result=$this->db->where('id', $row->id)
                                    ->update($table,$data_to_update);
                                    
                                    if($result) 
                                    {
                                        $this->session->set_flashdata(array('res'=>'success','msg'=>'Spirituality Image Updated Successfully.')); 
                                        if (!empty($_FILES["image"]["name"])) {
                                            $upload_errors           = array();
                                            $config['upload_path']   = './uploads/spirituality/';
                                            $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                            $config['max_size']      = 10000000;
                                            $config['file_name']     = $filename;
                                            $this->load->library('upload', $config);
                                            if ($this->upload->do_upload('image')) {
                                                  
                                                @unlink('./uploads/spirituality/'.$old_filename);
                                            }
                                            
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
                    redirect(base_url('AdminPanel/ManageSpirituality'));
                }
                 
            }
            else 
            {
                 $query = $this->db->order_by("id", "DESC")->get($table);
                 $data["list"] = $query->result();
                 $this->load->view("AdminPanel/ManageSpirituality", $data);
            }
        }
        # Testimonials Management
        
        public function ManageTestimonials()
        {
            $table='tbl_testimonial';
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
                            $data["action"]="EditTestimonial";
                            $this->load->view("AdminPanel/Modal", $data);
                        }
                        else
                        {
                            redirect(base_url('AdminPanel/ManageTestimonials'));
                        }
                    }
                    else
                    {
                        redirect(base_url('AdminPanel/ManageTestimonials'));
                    }
                }
                else 
                {
                    if($action=='Add')
                    {
                        if (isset($_POST["addaction"])) 
                        {    
                            $this->form_validation->set_rules('name', 'Name', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('designation', 'Designation', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('review', 'Review', 'required', array('required' => '%s is Required Field'));
                            if (empty($_FILES["photo"]["name"])) {
                                $this->form_validation->set_rules('photo', 'Photo', 'required');
                            }
                            else{
                                $ext      = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
                                $filename = time().rand() . "." . $ext;
                            }
                            if ($this->form_validation->run() == FALSE){
                            } 
                            else 
                            {
                                $data_to_insert= array(
                                "name" => $this->input->post("name"),
                                "designation" => $this->input->post("designation"),
                                "review" => $this->input->post("review"),
                                "photo" => $filename,
                                "status" => "true",
                                "date" => $this->date,
                                "time" => $this->time
                                );
                                $data_to_insert = $this->security->xss_clean($data_to_insert);
                                
                                if ($this->db->insert($table, $data_to_insert)) {
                                    $upload_errors           = array();
                                    $config['upload_path']   = './uploads/testimonial/';
                                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                    $config['max_size']      = 10000000;
                                    $config['file_name']     = $filename;
                                    $this->load->library('upload', $config);
                                    if (!$this->upload->do_upload('photo')) {
                                        array_push($upload_errors, array(
                                        'error_upload_logo' => $this->upload->display_errors()
                                        ));
                                        $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
                                    }
                                    else{
                                        $this->session->set_flashdata(array('res'=>'success','msg'=>'Testimonial Added Successfully.'));
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
                                $query = $this->db->where('id', $this->input->post("id"))->get('tbl_testimonial');
                                if ($query->num_rows()) 
                                {
                                    $data['list']=$query->result();
                                    
                                    $this->form_validation->set_rules('name', 'Name', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('designation', 'Designation', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('review', 'Review', 'required', array('required' => '%s is Required Field'));
                                    if ($this->form_validation->run() == FALSE){
                                    } 
                                    else 
                                    {
                                        $old_filename=$data['list'][0]->photo;
                                        $filename=$old_filename;
                                        if (!empty($_FILES["photo"]["name"])) {
                                            $ext      = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
                                            $filename = time().rand(). "." . $ext;
                                        }  
                                        $data_to_update= array(
                                        "photo" => $filename,
                                        "name" => $this->input->post("name"),
                                        "designation" => $this->input->post("designation"),
                                        "review" => $this->input->post("review")
                                        );
                                        $data_to_update = $this->security->xss_clean($data_to_update);
                                        $result=$this->db->where('id',$data['list'][0]->id)
                                        ->update($table,$data_to_update);
                                        
                                        if($result) 
                                        {
                                            $this->session->set_flashdata(array('res'=>'success','msg'=>'Testimonial Updated Successfully.')); 
                                            if (!empty($_FILES["photo"]["name"])) {
                                                $upload_errors           = array();
                                                $config['upload_path']   = './uploads/testimonial/';
                                                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                                $config['max_size']      = 10000000;
                                                $config['file_name']     = $filename;
                                                $this->load->library('upload', $config);
                                                if (!$this->upload->do_upload('photo')) {
                                                    array_push($upload_errors, array(
                                                    'error_upload_logo' => $this->upload->display_errors()
                                                    ));
                                                    $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
                                                }
                                                unlink('./uploads/testimonial/'.$old_filename);
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
                    redirect(base_url('AdminPanel/ManageTestimonials'));
                }
            }
            else 
            {
                $query = $this->db->order_by("id", "DESC")->get($table);
                $data["list"] = $query->result();
                $this->load->view("AdminPanel/ManageTestimonials", $data);
            }
        }

        
        
        # Tutors Management
        
        public function ManageTutors()
        {
            $table='tbl_tutor';
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
                            $data["action"]="EditTutor";
                            $this->load->view("AdminPanel/Modal", $data);
                        }
                        else if($action=='LoginDataLoad'){
                            $data["action"]="LoginData";
                            $this->load->view("AdminPanel/Modal", $data);
                        }
                        else if($action=='Access')
                        {
                            $output['res']='success';
                            $output['msg']='Accessed';
                            $this->session->set_userdata("EducatorEmailSession",$data["list"][0]->email);
							$this->session->set_userdata("EducatorIDSession",$data["list"][0]->id);
                            $output['redirect']=base_url('Educator/Dashboard');
                            
                            echo json_encode([$output]);
                        }
                        else
                        {
                            redirect(base_url('AdminPanel/ManageTutors'));
                        }
                    }
                    else
                    {
                        redirect(base_url('AdminPanel/ManageTutors'));
                    }
                }
                else 
                {
                    if($action=='Add')
                    {
                        if (isset($_POST["addaction"])) 
                        {    
                            $this->form_validation->set_rules('name', 'Name', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('designation', 'Designation', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('about', 'About', 'required', array('required' => '%s is Required Field'));
                            // $this->form_validation->set_rules('social_link', 'Social Link', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('position', 'Enter Position', 'required', array('required' => '%s is Required Field'));
                            if (empty($_FILES["photo"]["name"])) {
                                $this->form_validation->set_rules('photo', 'Photo', 'required');
                            }
                            else{
                                $ext      = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
                                $filename = time().rand(). "." . $ext;
                            }
                            if ($this->form_validation->run() == FALSE){
                            } 
                            else 
                            {
                                $data_to_insert= array(
                                "name" => $this->input->post("name"),
                                "designation" => $this->input->post("designation"),
                                "about" => $this->input->post("about"),
                                "social_link" => $this->input->post("social_link"),
                                "position" => $this->input->post("position"),
                                "photo" => $filename,
                                "status" => "true",
                                "date" => $this->date,
                                "time" => $this->time
                                );
                                $data_to_insert = $this->security->xss_clean($data_to_insert);
                                
                                if ($this->db->insert($table, $data_to_insert)) {
                                    
                                    $insert_id = $this->db->insert_id();
                                    $username=strtolower($this->input->post("name"));
                                    $username=preg_replace('/\s+/', ' ', $username).$insert_id;
                                    
                                    $this->db->where('id',$insert_id)->update($table, ['username'=>$username]);
                                    
                                    // if(!is_dir('./uploads/thumbnail/'.$username)) { mkdir('./uploads/thumbnail/' . $username, 0777, TRUE); }
                                    // if(!is_dir('./uploads/video/'.$username)) {  mkdir('./uploads/video/' . $username, 0777, TRUE); }
                                    
                                    $upload_errors           = array();
                                    $config['upload_path']   = './uploads/tutor/';
                                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                    $config['max_size']      = 10000000;
                                    $config['file_name']     = $filename;
                                    $this->load->library('upload', $config);
                                    if (!$this->upload->do_upload('photo')) {
                                        array_push($upload_errors, array(
                                        'error_upload_logo' => $this->upload->display_errors()
                                        ));
                                        $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
                                    }
                                    else{
                                        $this->session->set_flashdata(array('res'=>'success','msg'=>'Tutor Added Successfully.'));
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
                                    
                                    $this->form_validation->set_rules('name', 'Name', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('designation', 'Designation', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('about', 'About', 'required', array('required' => '%s is Required Field'));
                                    // $this->form_validation->set_rules('social_link', 'Social Link', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('position', 'Enter Position', 'required', array('required' => '%s is Required Field'));
                                    if ($this->form_validation->run() == FALSE){
                                    } 
                                    else 
                                    {
                                        $old_filename=$data['list'][0]->photo;
                                        $filename=$old_filename;
                                        if (!empty($_FILES["photo"]["name"])) {
                                            $ext      = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
                                            $filename = time().rand(). "." . $ext;
                                        }  
                                        $data_to_update= array(
                                        "name" => $this->input->post("name"),
                                        "designation" => $this->input->post("designation"),
                                        "about" => $this->input->post("about"),
                                        "social_link" => $this->input->post("social_link"),
                                        "position" => $this->input->post("position"),
                                        "photo" => $filename,
                                        );
                                        $data_to_update = $this->security->xss_clean($data_to_update);
                                        $result=$this->db->where('id',$data['list'][0]->id)
                                        ->update($table,$data_to_update);
                                        
                                        if($result) 
                                        {
                                            $this->session->set_flashdata(array('res'=>'success','msg'=>'Educator Updated Successfully.')); 
                                            if (!empty($_FILES["photo"]["name"])) {
                                                $upload_errors           = array();
                                                $config['upload_path']   = './uploads/tutor/';
                                                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                                $config['max_size']      = 10000000;
                                                $config['file_name']     = $filename;
                                                $this->load->library('upload', $config);
                                                if (!$this->upload->do_upload('photo')) {
                                                    array_push($upload_errors, array(
                                                    'error_upload_logo' => $this->upload->display_errors()
                                                    ));
                                                    $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
                                                }
                                                unlink('./uploads/tutor/'.$old_filename);
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
                    else if($action=='LoginData'){
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
                                    $id=$data['list'][0]->id;
                                    $this->form_validation->set_rules('mobile', 'mobile', 'required|min_length[10]|max_length[10]|trim');
                                    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
                                    $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
                                    
                                    if ($this->form_validation->run() == FALSE){
                                        
                                        $msg=explode('</p>',validation_errors());
                                        $msg=str_ireplace('<p>','', $msg[0]);
                                        $this->session->set_flashdata(array('res'=>'error','msg'=>$msg));
                                    } 
                                    else 
                                    {
                                        $mobile=$this->input->post("mobile");
                                        $email=$this->input->post("email");
                                        
                                        $results=$this->db->where("(`mobile`='".$mobile."' OR `email`='".$email."') AND `id`!='".$id."'")->get($table);  
                                        
                                        if($results->num_rows())
                                        {
                                            $resultData=$results->row();
                                            if($resultData->mobile==$mobile)
                                            {
                                                $this->session->set_flashdata(array('res'=>'error','msg'=>'Mobile No is already registered.'));
                                            }
                                            else
                                            {
                                                $this->session->set_flashdata(array('res'=>'error','msg'=>'Mobile No is already registered.'));
                                            }
                                        }
                                        else
                                        {
                                            $data_to_update= array(
                                            "mobile" => $this->input->post("mobile"),
                                            "email" => $this->input->post("email"),
                                            "password" => $this->input->post("password")
                                            );
                                            $data_to_update = $this->security->xss_clean($data_to_update);
                                            $result=$this->db->where('id',$data['list'][0]->id)->update($table,$data_to_update);
                                            
                                            if($result) 
                                            {
                                                $this->session->set_flashdata(array('res'=>'success','msg'=>'Tutor Login Data Updated Successfully.')); 
                                                
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
                    }
                    redirect(base_url('AdminPanel/ManageTutors'));
                }
            }
            else 
            {
                $query = $this->db->order_by("position", "ASC")->get($table);
                $data["list"] = $query->result();
                $this->load->view("AdminPanel/ManageTutors", $data);
            }
        }
        
        # Team Management
        
        public function ManageTeam()
        {
            $table='tbl_team';
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
                            $data["action"]="EditTeam";
                            $this->load->view("AdminPanel/Modal", $data);
                        }
                        else
                        {
                            redirect(base_url('AdminPanel/ManageTeam'));
                        }
                    }
                    else
                    {
                        redirect(base_url('AdminPanel/ManageTeam'));
                    }
                }
                else 
                {
                    if($action=='Add')
                    {
                        if (isset($_POST["addaction"])) 
                        {   
                            $this->form_validation->set_rules('name', 'Name', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('designation', 'Designation', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('position', 'Enter Position', 'required', array('required' => '%s is Required Field'));
                            if (empty($_FILES["photo"]["name"])) {
                                $this->form_validation->set_rules('photo', 'Photo', 'required');
                            }
                            else{
                                $ext      = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
                                $filename = time().rand(). "." . $ext;
                            }
                            if ($this->form_validation->run() == FALSE){
                            } 
                            else 
                            {
                                $data_to_insert= array(
                                "name" => $this->input->post("name"),
                                "designation" => $this->input->post("designation"),
                                "position" => $this->input->post("position"),
                                "photo" => $filename,
                                "status" => "true",
                                "date" => $this->date,
                                "time" => $this->time
                                );
                                $data_to_insert = $this->security->xss_clean($data_to_insert);
                                
                                if ($this->db->insert($table, $data_to_insert)) {
                                    $upload_errors           = array();
                                    $config['upload_path']   = './uploads/team/';
                                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                    $config['max_size']      = 10000000;
                                    $config['file_name']     = $filename;
                                    $this->load->library('upload', $config);
                                    if (!$this->upload->do_upload('photo')) {
                                        array_push($upload_errors, array(
                                        'error_upload_logo' => $this->upload->display_errors()
                                        ));
                                        $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
                                    }
                                    else{
                                        $this->session->set_flashdata(array('res'=>'success','msg'=>'Team Added Successfully.'));
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
                                    
                                    $this->form_validation->set_rules('name', 'Name', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('designation', 'Designation', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('position', 'Enter Position', 'required', array('required' => '%s is Required Field'));
                                    if ($this->form_validation->run() == FALSE){
                                    } 
                                    else 
                                    {
                                        $old_filename=$data['list'][0]->photo;
                                        $filename=$old_filename;
                                        if (!empty($_FILES["photo"]["name"])) {
                                            $ext      = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
                                            $filename = time().rand(). "." . $ext;
                                        }  
                                        $data_to_update= array(
                                        "name" => $this->input->post("name"),
                                        "designation" => $this->input->post("designation"),
                                        "position" => $this->input->post("position"),
                                        "photo" => $filename,
                                        );
                                        $data_to_update = $this->security->xss_clean($data_to_update);
                                        $result=$this->db->where('id',$data['list'][0]->id)
                                        ->update($table,$data_to_update);
                                        
                                        if($result) 
                                        {
                                            $this->session->set_flashdata(array('res'=>'success','msg'=>'Team Updated Successfully.')); 
                                            if (!empty($_FILES["photo"]["name"])) {
                                                $upload_errors           = array();
                                                $config['upload_path']   = './uploads/team/';
                                                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                                $config['max_size']      = 10000000;
                                                $config['file_name']     = $filename;
                                                $this->load->library('upload', $config);
                                                if (!$this->upload->do_upload('photo')) {
                                                    array_push($upload_errors, array(
                                                    'error_upload_logo' => $this->upload->display_errors()
                                                    ));
                                                    $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
                                                }
                                                unlink('./uploads/team/'.$old_filename);
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
                    redirect(base_url('AdminPanel/ManageTeam'));
                }
                
            }
            else 
            {
                $query = $this->db->order_by("position", "ASC")->get($table);
                $data["list"] = $query->result();
                $this->load->view("AdminPanel/ManageTeam", $data);
            }
        }
        
        # Blog Management 
        
        public function ManageBlog()
        {
            $table='tbl_blog';
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
                        $data["authorlist"] = $this->db->order_by("id", "DESC")->get('tbl_tutor')->result();
                        $data["categorylist"] = $this->db->order_by("id", "DESC")->get('tbl_category')->result();
                        if($action=='Edit'){
                            $data["action"]="EditBlog";
                            $this->load->view("AdminPanel/Modal", $data);
                        }
                        else
                        {
                            redirect(base_url('AdminPanel/ManageBlog'));
                        }
                    }
                    else
                    {
                        redirect(base_url('AdminPanel/ManageBlog'));
                    }
                }
                else 
                {
                    if($action=='Add'){
                        if (isset($_POST["addaction"])) 
                        {   
                            $this->form_validation->set_rules('author', 'Author', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('category', 'Category', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('title', 'Title', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('tags', 'Tags', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('summary', 'Summary', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('description', 'Description', 'required', array('required' => '%s is Required Field'));
                            if (empty($_FILES["photo"]["name"])) {
                                $this->form_validation->set_rules('photo', 'Photo', 'required');
                            }
                            else{
                                $ext      = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
                                $filename = time().rand(). "." . $ext;
                            }
                            if ($this->form_validation->run() == FALSE){
                            } 
                            else 
                            {
                                $data_to_insert= array(
                                "author" => $this->input->post("author"),
                                "category" => $this->input->post("category"),
                                "title" => $this->input->post("title"),
                                "tags" => $this->input->post("tags"),
                                "summary" => $this->input->post("summary"),
                                "description" => $this->input->post("description"),
                                "photo" => $filename,
                                "status" => "true",
                                "date" => $this->date,
                                "time" => $this->time
                                );
                                
                                if ($this->db->insert($table, $data_to_insert)) {
                                    $upload_errors           = array();
                                    $config['upload_path']   = './uploads/blog/';
                                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                    $config['max_size']      = 10000000;
                                    $config['file_name']     = $filename;
                                    $this->load->library('upload', $config);
                                    if (!$this->upload->do_upload('photo')) {
                                        array_push($upload_errors, array(
                                        'error_upload_logo' => $this->upload->display_errors()
                                        ));
                                        $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
                                    }
                                    else{
                                        $this->session->set_flashdata(array('res'=>'success','msg'=>'Blog Added Successfully.'));
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
                                    
                                    $this->form_validation->set_rules('author', 'Author', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('category', 'Category', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('title', 'Title', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('tags', 'Tags', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('summary', 'Summary', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('description', 'Description', 'required', array('required' => '%s is Required Field'));
                                    if ($this->form_validation->run() == FALSE){
                                    } 
                                    else 
                                    {
                                        $old_filename=$data['list'][0]->photo;
                                        $filename=$old_filename;
                                        if (!empty($_FILES["photo"]["name"])) {
                                            $ext      = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
                                            $filename = time().rand(). "." . $ext;
                                        }  
                                        $data_to_update= array(
                                        "author" => $this->input->post("author"),
                                        "category" => $this->input->post("category"),
                                        "title" => $this->input->post("title"),
                                        "tags" => $this->input->post("tags"),
                                        "summary" => $this->input->post("summary"),
                                        "description" => $this->input->post("description"),
                                        "photo" => $filename,
                                        );
                                        $result=$this->db->where('id',$data['list'][0]->id)
                                        ->update($table,$data_to_update);
                                        
                                        if($result) 
                                        {
                                            $this->session->set_flashdata(array('res'=>'success','msg'=>'Blog Updated Successfully.')); 
                                            if (!empty($_FILES["photo"]["name"])) {
                                                $upload_errors           = array();
                                                $config['upload_path']   = './uploads/blog/';
                                                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                                $config['max_size']      = 10000000;
                                                $config['file_name']     = $filename;
                                                $this->load->library('upload', $config);
                                                if (!$this->upload->do_upload('photo')) {
                                                    array_push($upload_errors, array(
                                                    'error_upload_logo' => $this->upload->display_errors()
                                                    ));
                                                    $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
                                                }
                                                unlink('./uploads/blog/'.$old_filename);
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
                    redirect(base_url('AdminPanel/ManageBlog'));
                }
            }
            else 
            {
                $query = $this->db->order_by("id", "DESC")->get($table);
                
                $i=0;
                $return=[];
                foreach($query->result() as $item){
                    $return[$i]=$item;
                    $return[$i]->author=$this->db->where(['id'=>$item->author])->get('tbl_tutor')->row();
                    $return[$i]->category=$this->db->where(['id'=>$item->category])->get('tbl_category')->row();
                    $i++;
                }
                
                $data["list"] =$return;
                $data["authorlist"] = $this->db->order_by("id", "DESC")->get('tbl_tutor')->result();
                $data["categorylist"] = $this->db->order_by("id", "DESC")->get('tbl_category')->result();
                $this->load->view("AdminPanel/ManageBlog", $data);
            }
        }
        
        # Manage FAQ
        
        public function ManageFAQ()
        {
            $table='tbl_faq';
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
                            $data["action"]="EditFAQ";
                            $this->load->view("AdminPanel/Modal", $data);
                        }
                        else
                        {
                            redirect(base_url('AdminPanel/ManageBlog'));
                        }
                    }
                    else
                    {
                        redirect(base_url('AdminPanel/ManageBlog'));
                    }
                }
                else 
                {
                    if($action=='Add'){
                        if (isset($_POST["addaction"])) 
                        {   
                            $this->form_validation->set_rules('title', 'Title', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('description', 'Description', 'required', array('required' => '%s is Required Field'));
                            if ($this->form_validation->run() == FALSE){
                            } 
                            else 
                            {
                                $data_to_insert= array(
                                "title" => $this->input->post("title"),
                                "description" => $this->input->post("description"),
                                "status" => "true",
                                "date" => $this->date,
                                "time" => $this->time
                                );
                                
                                if ($this->db->insert($table, $data_to_insert)) {
                                    $this->session->set_flashdata(array('res'=>'success','msg'=>'FAQ Added Successfully.'));
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
                                    
                                    $this->form_validation->set_rules('title', 'Title', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('description', 'Description', 'required', array('required' => '%s is Required Field'));
                                    if ($this->form_validation->run() == FALSE){
                                    } 
                                    else 
                                    {
                                        
                                        $data_to_update= array(
                                        "title" => $this->input->post("title"),
                                        "description" => $this->input->post("description"),
                                        );
                                        $result=$this->db->where('id',$data['list'][0]->id)
                                        ->update($table,$data_to_update);
                                        
                                        if($result) 
                                        {
                                            $this->session->set_flashdata(array('res'=>'success','msg'=>'FAQ Updated Successfully.')); 
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
                    redirect(base_url('AdminPanel/ManageFAQ'));
                }
            }
            else 
            {
                $query = $this->db->order_by("id", "ASC")->get($table);
                $data["list"]=$query->result();
                $this->load->view("AdminPanel/ManageFAQ", $data);
            }
        }
        
        #Manage Offer
        
        public function ManageOffers()
        {
            $table='tbl_offer';
            $data["authorlist"] = $this->db->order_by("id", "DESC")->get('tbl_tutor')->result();
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
                            $data["action"]="EditOffer";
                            $this->load->view("AdminPanel/Modal", $data);
                        }
                        else if($action=='UsedCouponHistory'){
                            $data["action"]="UsedCouponHistory";
                            $data['history']=$this->db->where(['couponcode'=>$data["list"][0]->coupon,'paymentstatus'=>'success'])->get('tbl_enroll')->result();
                            $this->load->view("AdminPanel/UsedCouponHistory", $data);
                        }
                        else
                        {
                            redirect(base_url('AdminPanel/ManageOffers'));
                        }
                    }
                    else
                    {
                        redirect(base_url('AdminPanel/ManageOffers'));
                    }
                }
                else 
                {
                    if($action=='Add')
                    {
                        if (isset($_POST["addaction"])) 
                        {    
                            $this->form_validation->set_rules('coupon', 'Coupon', 'required|is_unique[tbl_offer.coupon]', array('required' => '%s is Required Field','is_unique' => 'This %s is already exists'));
                            $this->form_validation->set_rules('discount', 'Discount', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('discount_type', 'Discount Type', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('upto', 'Upto ', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('expiry_date', 'Expiry Date', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('no_of_coupon', 'No Of Coupon', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('description', 'Description', 'required', array('required' => '%s is Required Field'));
                            
                            if (empty($_FILES["banner"]["name"])) {
                                $this->form_validation->set_rules('banner', 'Banner', 'required');
                            }
                            else{
                                $ext      = pathinfo($_FILES["banner"]["name"], PATHINFO_EXTENSION);
                                $filename = time().rand(). "." . $ext;
                            }
                            
                            if ($this->form_validation->run() == FALSE){
                                $msg=explode('</p>',validation_errors());
                                $msg=str_ireplace('<p>','', $msg[0]);
                                $this->session->set_flashdata(array('res'=>'error','msg'=>$msg));
                            } 
                            else 
                            {
                                
                                if(empty($this->input->post("type")))
                                {
                                    $_POST['type']='Student';
                                }
                                
                                if($this->input->post("type")=='Student'){
                                    $_POST['educator_id']='0';
                                }
                                
                                if(empty($this->input->post("educator_id")))
                                {
                                    $_POST['educator_id']='0';
                                }
                                
                                $data_to_insert= array(
                                "banner" => $filename,
                                "coupon" => strtoupper($this->input->post("coupon")),
                                "discount" => $this->input->post("discount"),
                                "discount_type" => $this->input->post("discount_type"),
                                "upto" => $this->input->post("upto"),
                                "expiry_date" => $this->input->post("expiry_date"),
                                "no_of_coupon" => $this->input->post("no_of_coupon"),
                                "used_coupon" => "0",
                                "status" => "true",
                                "description" => $this->input->post("description"),
                                "type" => $this->input->post("type"),
                                "educator_id" => $this->input->post("educator_id"),
                                "date" => $this->date,
                                "time" => $this->time
                                );
                                
                                
                                $data_to_insert = $this->security->xss_clean($data_to_insert);
                                
                                if ($this->db->insert($table, $data_to_insert)) {
                                    $upload_errors           = array();
                                    $config['upload_path']   = './uploads/offer/';
                                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                    $config['max_size']      = 10000000;
                                    $config['file_name']     = $filename;
                                    $this->load->library('upload', $config);
                                    if (!$this->upload->do_upload('banner')) {
                                        array_push($upload_errors, array(
                                        'error_upload_logo' => $this->upload->display_errors()
                                        ));
                                        $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
                                    }
                                    else{
                                        $this->session->set_flashdata(array('res'=>'success','msg'=>'Offer Added Successfully.'));
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
                                    
                                    $this->form_validation->set_rules('coupon', 'Coupon', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('discount', 'Discount', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('discount_type', 'Discount Type', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('upto', 'Upto ', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('expiry_date', 'Expiry Date', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('no_of_coupon', 'No Of Coupon', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('description', 'Description', 'required', array('required' => '%s is Required Field'));
                                    
                                    if ($this->form_validation->run() == FALSE){
                                    } 
                                    else 
                                    {
                                        $old_filename=$data['list'][0]->banner;
                                        $filename=$old_filename;
                                        if (!empty($_FILES["banner"]["name"])) {
                                            $ext      = pathinfo($_FILES["banner"]["name"], PATHINFO_EXTENSION);
                                            $filename = time().rand(). "." . $ext;
                                        }  
                                        $data_to_update= array(
                                        "banner" => $filename,
                                        "coupon" => strtoupper($this->input->post("coupon")),
                                        "discount" => $this->input->post("discount"),
                                        "discount_type" => $this->input->post("discount_type"),
                                        "upto" => $this->input->post("upto"),
                                        "expiry_date" => $this->input->post("expiry_date"),
                                        "no_of_coupon" => $this->input->post("no_of_coupon"),
                                        "description" => $this->input->post("description"),
                                        );
                                        $data_to_update = $this->security->xss_clean($data_to_update);
                                        $result=$this->db->where('id',$data['list'][0]->id)
                                        ->update($table,$data_to_update);
                                        
                                        if($result) 
                                        {
                                            $this->session->set_flashdata(array('res'=>'success','msg'=>'Offer Updated Successfully.')); 
                                            if (!empty($_FILES["banner"]["name"])) {
                                                $upload_errors           = array();
                                                $config['upload_path']   = './uploads/offer/';
                                                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                                $config['max_size']      = 10000000;
                                                $config['file_name']     = $filename;
                                                $this->load->library('upload', $config);
                                                if (!$this->upload->do_upload('banner')) {
                                                    array_push($upload_errors, array(
                                                    'error_upload_logo' => $this->upload->display_errors()
                                                    ));
                                                    $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
                                                }
                                                unlink('./uploads/offer/'.$old_filename);
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
                    redirect(base_url('AdminPanel/ManageOffers'));
                }
            }
            else 
            {
                $query = $this->db->order_by("id", "DESC")->get($table);
                $data["list"] = $query->result();
                $this->load->view("AdminPanel/ManageOffers", $data);
            }
        }
        
        # Notification Management
        
        public function ManageNotification()
        {
            $table='tbl_notification';
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
                            $data["action"]="EditNotification";
                            $this->load->view("AdminPanel/Modal", $data);
                        }
                        else
                        {
                            redirect(base_url('AdminPanel/ManageNotification'));
                        }
                    }
                    else
                    {
                        redirect(base_url('AdminPanel/ManageNotification')); 
                    }
                }
                else 
                {
                    if($action=='Add'){
                        if (isset($_POST["addaction"])) 
                        {    
                            
                            $this->form_validation->set_rules('title', 'Title', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('message', 'Message', 'required', array('required' => '%s is Required Field'));
                            if ($this->form_validation->run() == FALSE){
                            } 
                            else 
                            {
                                if (empty($_FILES["image"]["name"])) {
                                    $image='';
                                    $image_url=base_url('uploads/logo.png');
                                }
                                else{
                                    $ext      = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                                    $image = time().rand(). "." . $ext;
                                    $image_url=base_url('uploads/notification/'.$image);
                                }
                                var_dump($_POST);
                                if($this->input->post("for_user")=='AllEducator'){
                                    $_POST['for_user']='Educator';
                                    $usersData=$this->db->where('status','true')->get('tbl_tutor')->result();
                                    $users=array();
                                    foreach($usersData as $user){
                                        array_push($users,$user->id);
                                    }
                                }
                                elseif($this->input->post("for_user")=='AllStudent'){
                                    $_POST['for_user']='Student';
                                    $usersData=$this->db->where('status','true')->get('tbl_registration')->result();
                                    $users=array();
                                    foreach($usersData as $user){
                                        array_push($users,$user->id);
                                    }
                                }
                                else{
                                    $users=$this->input->post("users");
                                }
                                
                                $data_to_insert= array(
								"title" => $this->input->post("title"),
								"message" =>$this->input->post("message"),
								"link" =>$this->input->post("link"),
								"image" =>$image,
                                "parameter" =>$this->input->post("parameter"),
                                "data" =>$this->input->post("data"),
                                "for_user" =>$this->input->post("for_user"),
                                "users" =>implode(',',$users),
								"status" => "true",
								"date" => $this->date,
								"time" => $this->time 
                            );
                                
                                $data_to_insert = $this->security->xss_clean($data_to_insert);
                                
                                
                                $message=$this->input->post("message");
                                $title=$this->input->post("title");
                                if ($this->db->insert($table, $data_to_insert))
                                {
                                    
                                    if (!empty($_FILES["image"]["name"])) {
                                        $config['upload_path']   = './uploads/notification/';
                                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                        $config['max_size']      = 100000000;
                                        $config['file_name']     = $image;
                                        $this->load->library('upload', $config);
                                        $this->upload->do_upload('image');
                                    }
                                    #Send Notification 
                                    
                                    $id=$this->input->post("data");
                                    
                                    $type=$this->input->post("parameter");
                                    if($type=='Quiz'){
                                        $results=$this->db->where('quiz_id',$id)->get('tbl_quiz_scheduled');
                                        if($results->num_rows()){
                                            $results=$results->row();
                                            $id=$results->id;
                                        }
                                        else{
                                            $type='None';
                                            $id='';
                                        }
                                    }elseif($type=='Course'){
                                      $results=$this->db->where('course_id',$id)->get('tbl_quiz_scheduled');
                                        if($results->num_rows()){
                                            $results=$results->row();
                                            $id=$results->id;
                                        }
                                        else{
                                            $type='None';
                                            $id='';
                                        }
                                    
                                    }else{
                                       echo "notification not send";
                                    }
                                    $click_action=$this->firebaseActivities[$type];
                                    if($this->input->post("for_user")=='Student')
                                    {
                                      
                                        $uresult=$this->db->where_in('userid',$users)->get('tbl_apptoken');
                                        if($uresult->num_rows())
                                        {
                                            if($uresult->num_rows()>1)
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
                                                    
                                                    $return=$this->codersadda->send_notification_multiple($message,$title,$sendtoken,$image_url,$click_action,$id,$type);
                                                    $start=$start+999;
                                                }
                                                $user_id=implode(',',$alluser);
                                            }
                                            else
                                            { 
                                                 $uvalues=$uresult->row();
                                                $return=$this->codersadda->send_notification_single($message,$title,$uvalues->token,$image_url,$click_action,$id,$type);
                                                 $user_id=implode(',',$users);
                                            }
                                           
                                            
                                        }
                                    }
                                    $this->session->set_flashdata(array('res'=>'success','msg'=>'Notification Added Successfully.'));
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
                                    
                                    $this->form_validation->set_rules('title', 'Title', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('message', 'Message', 'required', array('required' => '%s is Required Field'));
                                    if ($this->form_validation->run() == FALSE){
                                    } 
                                    else 
                                    { 
                                        
                                        if (empty($_FILES["image"]["name"])) {
                                            $image=$data['list'][0]->image;
                                        }
                                        else{
                                            $ext      = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                                            $image = time().rand(). "." . $ext;
                                        }
                                        if(empty($this->input->post("data"))){
                                            $_POST['data']=$data['list'][0]->data;  
                                        }
                                        $data_to_update= array(
                                        "title" => $this->input->post("title"),
                                        "message" =>$this->input->post("message"),
                                        "link" =>$this->input->post("link"),
                                        "image" =>$image,
                                        "parameter" =>$this->input->post("parameter"),
                                        "data" =>$this->input->post("data"),
                                        );
                                        $data_to_update = $this->security->xss_clean($data_to_update);
                                        $result=$this->db->where('id',$data['list'][0]->id)
                                        ->update($table,$data_to_update);
                                        
                                        if($result) 
                                        {
                                            if (!empty($_FILES["image"]["name"])) {
                                                $config['upload_path']   = './uploads/notification/';
                                                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                                $config['max_size']      = 100000000;
                                                $config['file_name']     = $image;
                                                $this->load->library('upload', $config);
                                                $this->upload->do_upload('image');
                                            }
                                            $this->session->set_flashdata(array('res'=>'success','msg'=>'Notification Updated Successfully.')); 
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
                    redirect(base_url('AdminPanel/ManageNotification'));
                }
            }
            else 
            {
                $query = $this->db->order_by("id", "DESC")->get($table);
                $data["list"] = $query->result();
                $this->load->view("AdminPanel/ManageNotification", $data);
            }
        }
        
        # Video Management
        
        
        public function ManageVideos()
        {
            $data['authorlist']=$this->db->where('status','true')->get('tbl_tutor')->result();
            $table='tbl_video';
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
                        $data['subject']=$this->db->where('status','true')->get('tbl_subject')->result();
                        if($action=='Edit'){
                            $data["action"]="EditVideo";
                            $this->load->view("AdminPanel/Modal", $data);
                        }
                        else
                        {
                            redirect(base_url('AdminPanel/ManageVideos'));
                        }
                    }
                    else
                    {
                        redirect(base_url('AdminPanel/ManageVideos'));
                    }
                }
                else 
                {
                    if($action=='Add')
                    {
                        if (isset($_POST["addaction"])) 
                        {    
                            $this->form_validation->set_rules('subject', 'Subject', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('title', 'Title', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('description', 'Description', 'required', array('required' => '%s is Required Field'));
                            
                            $this->form_validation->set_rules('thumbnail', 'Thumbnail', 'required', array('required' => '%s is Required Field'));
                            if($this->input->post("type")=='External'){
                                $this->form_validation->set_rules('link', 'Video Link', 'required', array('required' => '%s is Required Field'));
                            }
                            else{
                                
                                $this->form_validation->set_rules('video', 'Video ', 'required', array('required' => '%s is Required Field'));
                            }
                            
                            
                            $this->form_validation->set_rules('duration', 'Duration', 'required', array('required' => '%s is Required Field'));
                            if ($this->form_validation->run() == FALSE){
                            } 
                            else 
                            { 
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
                                "thumbnail" => $this->input->post("thumbnail"),
                                "video" => $this->input->post("video"),
                                "duration" => $this->input->post("duration"),
                                "type" => $this->input->post("type"),
                                "link" => $this->input->post("link"),
                                "notes" => $filename,
                                "status" => "true",
                                "date" => $this->date,
                                "time" => $this->time
                                );
                                
                                $data_to_insert = $this->security->xss_clean($data_to_insert);
                                if ($this->db->insert($table, $data_to_insert)) {
                                    
                                    $videos=$this->db->where(['id'=>$this->input->post("subject")])->get('tbl_subject')->row()->videos;
                                    $this->db->where(['id'=>$this->input->post("subject")])->update('tbl_subject',['videos'=>$videos+1]);
                                    
                                    $upload_errors=array();
                                    if(!empty($_FILES["notes"]["name"]))
                                    {
                                        $config['upload_path'] = './uploads/notes/';
                                        $config['allowed_types'] = 'pdf';
                                        $config['max_size'] = 50000; 
                                        $config['file_name'] = $filename;
                                        $this->load->library('upload', $config);  
                                        if(!$this->upload->do_upload('notes'))
                                        {
                                            array_push($upload_errors,array('error_upload' => $this->upload->display_errors()));
                                        }
                                    }
                                    
                                    $this->session->set_flashdata(array('res'=>'success','msg'=>'Video Added Successfully.'));
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
                                    
                                    $this->form_validation->set_rules('subject', 'Subject', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('title', 'Title', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('description', 'Description', 'required', array('required' => '%s is Required Field'));
                                    
                                    $this->form_validation->set_rules('thumbnail', 'Thumbnail', 'required', array('required' => '%s is Required Field'));
                                    if($this->input->post("type")=='External'){
                                        $this->form_validation->set_rules('link', 'Video Link', 'required', array('required' => '%s is Required Field'));
                                    }
                                    else{
                                        
                                        $this->form_validation->set_rules('video', 'Video ', 'required', array('required' => '%s is Required Field'));
                                    }
                                    
                                    $this->form_validation->set_rules('duration', 'Duration', 'required', array('required' => '%s is Required Field'));
                                    if ($this->form_validation->run() == FALSE){
                                    } 
                                    else 
                                    {
                                        $old_filename=$data['list'][0]->notes;
                                        $filename=$old_filename;
                                        
                                        if(!empty($_FILES["notes"]["name"]))
                                        {
                                            $ext=pathinfo($_FILES["notes"]["name"],PATHINFO_EXTENSION);
                                            $filename=time()."_video_note.".$ext;
                                        }
                                        
                                        
                                        $data_to_update= array(
                                        "author" => $this->input->post("author"),
                                        "subject" =>strtoupper($this->input->post("subject")),
                                        "title" => $this->input->post("title"),
                                        "description" => $this->input->post("description"),
                                        "thumbnail" => $this->input->post("thumbnail"),
                                        "video" => $this->input->post("video"),
                                        "duration" => $this->input->post("duration"),
                                        "type" => $this->input->post("type"),
                                        "link" => $this->input->post("link"),
                                        "notes" => $filename
                                        );
                                        $data_to_update = $this->security->xss_clean($data_to_update);
                                        $result=$this->db->where('id',$data['list'][0]->id)->update($table,$data_to_update);
                                        
                                        if($result) 
                                        {
                                            $upload_errors=array();
                                            if(!empty($_FILES["notes"]["name"]))
                                            {
                                                $config['upload_path'] = './uploads/notes/';
                                                $config['allowed_types'] = 'pdf';
                                                $config['max_size'] = 50000; 
                                                $config['file_name'] = $filename;
                                                $this->load->library('upload', $config);  
                                                if(!$this->upload->do_upload('notes'))
                                                {
                                                    array_push($upload_errors,array('error_upload' => $this->upload->display_errors()));
                                                }
                                                unlink('./uploads/notes/'.$old_filename);
                                            }
                                            $this->session->set_flashdata(array('res'=>'success','msg'=>'Video Updated Successfully.')); 
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
                    redirect(base_url('AdminPanel/ManageVideos')); 
                }
            }
            else 
            {
                $query = $this->db->order_by("id", "DESC")->get($table);
                $data["list"] = $query->result();
                $data['subjectlist']=$this->db->where('status','true')->get('tbl_subject')->result();
                if($query->num_rows()){
                    $return=[];
                    foreach ($data["list"] as $subject){
                        $return[$subject->id]=$subject;
                        $return[$subject->id]->subject=$this->db->where('id',$subject->subject)->get('tbl_subject')->result();
                        $return[$subject->id]->author=$this->db->where('id',$subject->author)->get('tbl_tutor')->row();
                    }
					$data["list"]=$return;
                }
				$this->load->view("AdminPanel/ManageVideos", $data);
            }
        }
        
        # Video Assignments
        
        public function ManageVideoAssignments()
        {
            $table='tbl_video_assignment';
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
                        $data['video']=$this->db->where('status','true')->get('tbl_video')->result();
                        $data['subjectlist']=$this->db->where('status','true')->get('tbl_subject')->result();
                        if($action=='Edit'){
                            $data["action"]="EditVideoAssignment";
                            $this->load->view("AdminPanel/Modal", $data);
                        }
                        else
                        {
                            redirect(base_url('AdminPanel/ManageVideoAssignments'));
                        }
                    }
                    else
                    {
                        redirect(base_url('AdminPanel/ManageVideoAssignments'));
                    }
                }
                else 
                {
                    if($action=='Add')
                    {
                        if (isset($_POST["addaction"])) 
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
                                if ($this->db->insert($table, $data_to_insert)) {
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
                                        $this->session->set_flashdata(array('res'=>'success','msg'=>'Video Assignment Added Successfully.'));
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
                                    $this->form_validation->set_rules('video', 'Video ID', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('description', 'Description', 'required', array('required' => '%s is Required Field'));
                                    if ($this->form_validation->run() == FALSE){
                                    } 
                                    else 
                                    {
                                        $old_filename=$data['list'][0]->assignment;
                                        $filename=$old_filename;
                                        if (!empty($_FILES["assignment"]["name"])) {
                                            $ext      = pathinfo($_FILES["assignment"]["name"], PATHINFO_EXTENSION);
                                            $filename = time().rand(). "." . $ext;
                                        }  
                                        $data_to_update= array(
                                        "assignment" => $filename,
                                        "video" => $this->input->post("video"),
                                        );
                                        $data_to_update = $this->security->xss_clean($data_to_update);
                                        $data_to_update['description']=$this->input->post("description");
                                        $result=$this->db->where('id',$data['list'][0]->id)
                                        ->update($table,$data_to_update);
                                        
                                        if($result) 
                                        {
                                            $this->session->set_flashdata(array('res'=>'success','msg'=>'Video Assignment Updated Successfully.')); 
                                            if (!empty($_FILES["assignment"]["name"])) {
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
                                                unlink('./uploads/assignment/'.$old_filename);
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
                    redirect(base_url('AdminPanel/ManageVideoAssignments')); 
                }
            }
            else 
            {
                $query = $this->db->where('author',0)->order_by("id", "DESC")->get($table);
                $data["list"] = $query->result();
                $data['subjectlist']=$this->db->where('status','true')->get('tbl_subject')->result();
                $data['videolist']=$this->db->where('status','true')->get('tbl_video')->result();
                if($query->num_rows()){
                    $return=[];
                    foreach ($data["list"] as $video){
                        $return[$video->id]=$video;
                        $videoResult=$this->db->where('id',$video->video)->get('tbl_video')->result();
                        $return[$video->id]->video=$videoResult;
                        $return[$video->id]->subject=$this->db->where('id',$videoResult[0]->subject)->get('tbl_subject')->result();
                    }
					$data["list"]=$return;
                }
				$this->load->view("AdminPanel/ManageVideoAssignments", $data);
            }
        }
        
        # App Slider Management
        
        
        public function ManageAppSliders()
        {
            $table='tbl_slider';
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
                            $data["action"]="EditAppSlider";
                            $this->load->view("AdminPanel/Modal", $data);
                        }
                        else
                        {
                            redirect(base_url('AdminPanel/ManageAppSliders'));
                        }
                    }
                    else
                    {
                        redirect(base_url('AdminPanel/ManageAppSliders'));
                    }
                }
                else 
                {
                    if($action=='Add'){
                        if (isset($_POST["addaction"])) 
                        {    
                            $this->form_validation->set_rules('parameter', 'Slider Parameter', 'required', array('required' => '%s is Required Field'));
                            
                            // $this->form_validation->set_rules('link', 'Slider Link', 'required', array('required' => '%s is Required Field'));
                            if (empty($_FILES["image"]["name"])) {
                                $this->form_validation->set_rules('image', 'Slider Image', 'required');
                            }
                            else{
                                $ext      = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                                $filename = time().rand(). "." . $ext;
                            }
                            if ($this->form_validation->run() == FALSE){
                                
                            } 
                            else 
                            {
                                $data_to_insert= array(
                                "image" => $filename,
                                "title" => $this->input->post("title"),
                                "tagline" => $this->input->post("tagline"),
                                "button" => $this->input->post("button"),
                                "parameter" => $this->input->post("parameter"),
                                "link" => $this->input->post("data"),
                                "type" => "App",
                                "status" => "true",
                                "date" => $this->date,
                                "time" => $this->time
                                );
                                $data_to_insert = $this->security->xss_clean($data_to_insert);
                                
                                if ($this->db->insert($table, $data_to_insert)) {
                                    $upload_errors           = array();
                                    $config['upload_path']   = './uploads/slider/';
                                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                    $config['max_size']      = 10000000;
                                    $config['file_name']     = $filename;
                                    $this->load->library('upload', $config);
                                    if (!$this->upload->do_upload('image')) {
                                        array_push($upload_errors, array(
                                        'error_upload_logo' => $this->upload->display_errors()
                                        ));
                                        $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
                                        
                                    }
                                    else{
                                        $this->session->set_flashdata(array('res'=>'success','msg'=>'Slider Added Successfully.'));
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
                                    
                                    $this->form_validation->set_rules('parameter', 'Slider Parameter', 'required', array('required' => '%s is Required Field'));
                                    // $this->form_validation->set_rules('link', 'Slider Link', 'required', array('required' => '%s is Required Field'));
                                    if ($this->form_validation->run() == FALSE){
                                    } 
                                    else 
                                    {
                                        $old_filename=$data['list'][0]->image;
                                        $filename=$old_filename;
                                        if (!empty($_FILES["image"]["name"])) {
                                            $ext      = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                                            $filename = time().rand(). "." . $ext;
                                        }  
                                        if(empty($this->input->post("data"))){
                                            $_POST['data']=$data['list'][0]->link;  
                                        }
                                        $data_to_update= array(
                                        "image" => $filename,
                                        "title" => $this->input->post("title"),
                                        "tagline" => $this->input->post("tagline"),
                                        "button" => $this->input->post("button"),
                                        "parameter" => $this->input->post("parameter"),
                                        "link" => $this->input->post("data")
                                        );
                                        $data_to_update = $this->security->xss_clean($data_to_update);
                                        $result=$this->db->where('id',$data['list'][0]->id)
                                        ->update($table,$data_to_update);
                                        
                                        if($result) 
                                        {
                                            $this->session->set_flashdata(array('res'=>'success','msg'=>'Slider Updated Successfully.')); 
                                            if (!empty($_FILES["image"]["name"])) {
                                                $upload_errors           = array();
                                                $config['upload_path']   = './uploads/slider/';
                                                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                                $config['max_size']      = 10000000;
                                                $config['file_name']     = $filename;
                                                $this->load->library('upload', $config);
                                                if (!$this->upload->do_upload('image')) {
                                                    array_push($upload_errors, array(
                                                    'error_upload_logo' => $this->upload->display_errors()
                                                    ));
                                                    $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
                                                }
                                                unlink('./uploads/slider/'.$old_filename);
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
                    redirect(base_url('AdminPanel/ManageAppSliders'));
                }
            }
            else 
            {
                $query = $this->db->where('type','App')->order_by("id", "DESC")->get($table);
                $data["list"] = $query->result();
                $this->load->view("AdminPanel/ManageAppSliders", $data);
            }
        }
        
        # App Trending Courses
        
        public function TrendingAppCourses()
        {
            $table='tbl_course';
            if ($this->uri->segment(3) == TRUE) 
            {
                $action = $this->uri->segment(3);
                
                if($action=='Add')
                {
                    if (isset($_POST["addaction"])) 
                    {    
                        $course_id=$this->input->post("course_id");
                        if(empty($course_id)){
                            
                        }
                        else{
                            // array_reverse($course_id);
                            for($i=0;$i<count($course_id);$i++){
                                $this->db->where_in('id',$course_id[$i])->update($table,array('trending'=>$i+1));
                            }
                            $result = $this->db->where_not_in('id',$course_id)->update($table,array('trending'=>'Trending'));
                        }
                    }
                }
                redirect(base_url('AdminPanel/TrendingAppCourses'));
            }
            else 
            {
                $query = $this->db->where_not_in('trending',array('Trending'))->order_by("trending", "ASC")->get($table);
                $data["list"] = $query->result();
                
                $query = $this->db->where('apprstatus','true')->order_by("id", "DESC")->get($table);
                $data["courselist"] = $query->result();
                
                $this->load->view("AdminPanel/TrendingAppCourses", $data);
            }
        }
        
        # App Trending Courses
        
        public function TopAppCourses()
        {
            $table='tbl_course';
            if ($this->uri->segment(3) == TRUE) 
            {
                $action = $this->uri->segment(3);
                
                if($action=='Add')
                {
                    if (isset($_POST["addaction"])) 
                    {    
                        $course_id=$this->input->post("course_id");
                        if(empty($course_id)){
                            
                        }
                        else{
                            // array_reverse($course_id);
                            for($i=0;$i<count($course_id);$i++){
                                $this->db->where_in('id',$course_id[$i])->update($table,array('top'=>$i+1));
                            }
                            $result = $this->db->where_not_in('id',$course_id)->update($table,array('top'=>'Top'));
                        }
                    }
                }
                redirect(base_url('AdminPanel/TopAppCourses'));
            }
            else 
            {
                $query = $this->db->where_not_in('top',array('Top'))->order_by("top", "ASC")->get($table);
                $data["list"] = $query->result();
                
                $query = $this->db->where('apprstatus','true')->order_by("id", "DESC")->get($table);
                $data["courselist"] = $query->result();
                
                $this->load->view("AdminPanel/TopAppCourses", $data);
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
                    $query = $this->db->where('id', $id)->get($table);  
                    if ($query->num_rows()) 
                    {
                        $data["list"] = $query->result();
                        $data['author']=$this->db->where('status','true')->get('tbl_tutor')->result();
                        if($action=='Edit'){
                            $data["action"]="EditLiveVideo";
                            $this->load->view("AdminPanel/Modal", $data);
                        }
                        else if($action=='StartLiveSession'){
                            $data["action"]="StartLiveSession";
                            $this->load->view("AdminPanel/Modal", $data);
                        }
                        else if($action=='EndLiveSession'){
                            $data["action"]="EndLiveSession";
                            $this->load->view("AdminPanel/Modal", $data);
                        }
                        else if($action=='Joined'){
                            $data["action"]="Joined";
                            $data['liveJoined']=$this->db->where('liveid',$data["list"][0]->id)->get('tbl_live_join')->result();
                            $this->load->view("AdminPanel/ManageLiveVideo", $data);
                        }
                        else if($action=='Questions'){
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
                            $this->load->view("AdminPanel/ManageLiveVideo", $data);
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
                            redirect(base_url('AdminPanel/ManageLiveVideo'));
                        }
                    }
                    else
                    {
                        redirect(base_url('AdminPanel/ManageLiveVideo'));
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
                           
                            if ($this->form_validation->run() == FALSE){
                            } 
                            else 
                            {
                               if (empty($_FILES["thumbnail"]["name"])) {
                                $this->form_validation->set_rules('thumbnail', 'Thumbnail', 'required');
                                }
                                else{
                                    if (empty($_FILES["thumbnail"]["name"])) {
                                        $image='';
                                        $image_url=base_url('uploads/logo.png');
                                    }
                                    else{
                                        $ext      = pathinfo($_FILES["thumbnail"]["name"], PATHINFO_EXTENSION);
                                        $image = time().rand(). "." . $ext;
                                        $image_url=base_url('uploads/live_video/'.$image);
                                    }
                                }
                                var_dump($_POST);
                                if($this->input->post("for_user")=='AllEducator'){
                                    $_POST['for_user']='Educator';
                                    $usersData=$this->db->where('status','true')->get('tbl_tutor')->result();
                                    $users=array();
                                    foreach($usersData as $user){
                                        array_push($users,$user->id);
                                    }
                                }
                                elseif($this->input->post("for_user")=='AllStudent'){
                                    $_POST['for_user']='Student';
                                    $usersData=$this->db->where('status','true')->get('tbl_registration')->result();
                                   
                                    $users=array();
                                   
                                    foreach($usersData as $user){
                                        array_push($users,$user->id);
                                    }
                                }
                                else{
                                 
                                    $users=$this->input->post("users");
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

                                $data_to_insert= array(
                                "thumbnail" => $image,
                                "subject" =>strtoupper($this->input->post("subject")),
                                "tags" =>strtoupper($this->input->post("tags")),
                                "title" => $this->input->post("title"),
                                "author" => $this->input->post("author"),
                                "link" => $this->input->post("link"),
                                "timing" => $this->input->post("timing"),
                                "duration" => $this->input->post("duration"),
                                "course" => $this->input->post("course"),
                                "session_type" => $this->input->post("session_type"),
                                "password" => $this->input->post("password"),
                                "certification" => $this->input->post("certificationcheck"),
								"certificate" => $certificate,
								"certificate_charge" => $certificate_charge,
								"km_charge" => $km_charge,
                                "description" => $this->input->post("description"),
                                "status" => "true",
                                "date" => $this->date,
                                "time" => $this->time
                                );
                                
                                $data_to_insert = $this->security->xss_clean($data_to_insert);
                                $message=$this->input->post("description");
                                $title=$this->input->post("title");
                               
                                if ($this->db->insert($table, $data_to_insert)) {
                                    $upload_errors           = array();
                                    $config['upload_path']   = './uploads/live_video/';
                                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                    $config['max_size']      = 10000000;
                                    $config['file_name']     = $image;
                                    $this->load->library('upload', $config);
                                    $this->upload->do_upload('thumbnail');
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
                                        "course" => $this->input->post("course"),
                                        "session_type" => $this->input->post("session_type"),
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
                                                $config['max_size']      = 10000000;
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
                                        $query = $this->db->where('id', $this->input->post("id"))->get($table);
                                        
                                        $data_to_update= array(
                                        "link" => $this->input->post("link"),
                                        "notification_title" => $this->input->post("notification_title"),
                                        "notification_message" => $this->input->post("notification_message"),
                                        "parameter" =>$this->input->post("parameter"),
                                        "for_user" => $this->input->post("for_user"),
                                        "users" =>implode(',',$users),
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
                                            $id=$this->input->post("data");
                                            $type=$this->input->post("parameter");
                                            if($type=='Quiz'){
                                                $results=$this->db->where('quiz_id',$id)->get('tbl_quiz_scheduled');
                                                if($results->num_rows()){
                                                    $results=$results->row();
                                                    $id=$results->id;
                                                }
                                                else{
                                                    $type='None';
                                                    $id='';
                                                }
                                              }
                                            $click_action=$this->firebaseActivities[$type];
                                            if($this->input->post("for_user")=='Student')
                                            {
                                              $jquery = $this->db->where('liveid', $this->input->post("id"))->get('tbl_live_join');

                                              foreach($jquery->result() as $user) 
                                              {
                                                  $uresult=$this->db->where('userid',$user->userid)->get('tbl_apptoken');
                                                    if($uresult->num_rows())
                                                    {
                                                      if($uresult->num_rows()>1)
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
                                                  else
                                                  { 
                                                    $uvalues=$uresult->row();
                                                    $return=$this->codersadda->send_notification_single($message,$title,$uvalues->token,$image_url,$click_action,$id,$type);
                                                    $user_id=implode(',',$users);
                                                  }
                                              }
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
                    redirect(base_url('AdminPanel/ManageLiveVideo')); 
                }
            }
            else 
            {
                
                if(!empty($_REQUEST['author'])){
                    $query = $this->db->where('session_status',$_REQUEST['author'])->order_by("id", "DESC")->get($table);
                }
                else{
                    $query = $this->db->order_by("id", "DESC")->get($table);
                }
               
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
                  
                $courseresult = $this->db->order_by("id", "desc")->get('tbl_course');
                $data["courselist"] = $courseresult->result();
                
				$this->load->view("AdminPanel/ManageLiveVideo", $data);
            }
        }
        public function getDataByType()
        {
            $courseId = $this->input->post('option');
            $query = $this->db->select('id, type')->from('tbl_course')->where('id', $courseId)->get();
            $data = $query->result();
            echo json_encode($data);
        }
        # Contact Management
        
        public function ManageContacts()
        {
            $query = $this->db->order_by("id", "DESC")->get('tbl_contact');
            $data["contactlist"] = $query->result();
            $this->load->view("AdminPanel/ManageContacts", $data);
        }
        
        # Profile Management
        
        public function Profile()
        {
            $admin_id=$this->session->userdata("AdminLoginData")[0]["id"];
            $query = $this->db->where('id',$admin_id)->order_by("id", "DESC")->get('tbl_adminlogin');
            $data["profile"] = $query->row();
            
            $w_day = date('w');
            $week_start = date('Y-m-d', strtotime('-'.$w_day.' days'));
            $week_end =date('Y-m-d', strtotime('+'.(6-$w_day).' days'));
            $query1 = $this->db->where('LoginID="'.$admin_id.'" AND date BETWEEN "'.$week_start. '" AND "'.$week_end.'"')->order_by("LoginDetailsID ", "DESC")->get('tbl_adminlogindetails');
            $data["login_details"] = $query1->result();
            
            $query1 = $this->db->where('LoginID',$admin_id)->order_by("LoginDetailsID ", "DESC")->get('tbl_adminlogindetails');
            $data["login_activities"] = $query1->result();
            
            if($this->uri->segment(3)==TRUE and $this->uri->segment(3)=='LoginActivities'){
                $this->load->view("AdminPanel/LoginActivities", $data);
            }
            else{
                $this->load->view("AdminPanel/Profile", $data);
            }
        }
        
        
        # Settings
        
        public function Settings()
        {
            $admin_id=$this->session->userdata("AdminLoginData")[0]["id"];
            
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
                            $result=$this->db->where('id',$admin_id)->get('tbl_adminlogin');
                            $values=$result->row();
                            if($values->Password==$opass)
                            {
                                if($npass==$cpass)
                                {
                                    $result=$this->db->where('id',$admin_id)->update('tbl_adminlogin',array('Password'=>$npass));
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
                    redirect(base_url('AdminPanel/Settings'));
                }
                else if($action=='TransactionPassword')
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
                            $result=$this->db->where('id',$admin_id)->get('tbl_adminlogin');
                            $values=$result->row();
                            if($values->TransactionPassword==$opass)
                            {
                                if($npass==$cpass)
                                {
                                    $result=$this->db->where('id',$admin_id)->update('tbl_adminlogin',array('TransactionPassword'=>$npass));
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
                    redirect(base_url('AdminPanel/Settings'));
                }
                else if($action=='NeedHelp')
                {
                    if (isset($_POST["addaction"])) 
                    {    
                        $this->form_validation->set_rules('help_mobile', 'Help Mobile No', 'required');
                        $this->form_validation->set_rules('help_email', 'Help Email Address', 'required');
                        if ($this->form_validation->run() == TRUE)
                        {
                            $result=$this->db->where('id',$admin_id)->update('tbl_adminlogin',array('help_mobile'=>$this->input->post('help_mobile'),'help_email'=>$this->input->post('help_email')));
                            if($result){
                                $this->session->set_flashdata(array('res'=>'success','msg'=>'Need Help Details Updated.'));
                            }
                            else{
                                $this->session->set_flashdata(array('res'=>'erorr','msg'=>'Failed'));
                            }
                        }
                    }
                    redirect(base_url('AdminPanel/Settings'));
                }
                else
                {
                    redirect(base_url('AdminPanel/Settings'));
                }
                
            }
            else
            {
                $query = $this->db->where('id',$admin_id)->order_by("id", "DESC")->get('tbl_adminlogin');
                $data["profile"] = $query->row();
                
                $query1 = $this->db->where('LoginID',$admin_id)->order_by("LoginDetailsID ", "DESC")->get('tbl_adminlogindetails');
                $data["login_details"] = $query1->result();
                
                $this->load->view("AdminPanel/Settings", $data);
            }
            
        }
        
        # Course Enrollment
        public function CourseEnrollments()
        {
            $table='tbl_enroll';
            $data['authorlist']=$this->db->get('tbl_tutor')->result();
            if ($this->uri->segment(3) == TRUE) 
            {
                $action = $this->uri->segment(3);
                if(!empty($_REQUEST['author']))
                {
                    $educatorCourses=$this->Auth_model->educatorCourses($_REQUEST['author']);
                    $query = $this->db->where(['paymentstatus'=>$action,'itemtype'=>'Course'])->where_in('itemid',$educatorCourses)->get($table);
                }
                else{
                    $query = $this->db->where(['paymentstatus'=>$action,'itemtype'=>'Course'])->get($table);
                }
                
                $data["list"] = $query->result();
                $i=0;
                foreach ($data["list"] as $enroll)
                {
                    $return[$i]=$enroll;
                    $return[$i]->item=$this->db->where('id',$enroll->itemid)->get('tbl_course')->row();	
                    $i++;
                }
                $this->load->view("AdminPanel/CourseEnrollments", $data);
            }
            else{
                redirect(base_url('AdminPanel/CourseEnrollments/success'));
            }
        }
        
        #Ebook Enrollment
        
        public function EBookEnrollments()
        {
            $table='tbl_enroll';
            $data['authorlist']=$this->db->get('tbl_tutor')->result();
            if ($this->uri->segment(3) == TRUE) 
            {
                $action = $this->uri->segment(3);
                if(!empty($_REQUEST['author']))
                {
                    $educatorEBooks=$this->Auth_model->educatorEBooks($_REQUEST['author']);
                    $query = $this->db->where(['paymentstatus'=>$action,'itemtype'=>'Ebook'])->where_in('itemid',$educatorEBooks)->get($table);
                }
                else{
                    $query = $this->db->where(['paymentstatus'=>$action,'itemtype'=>'Ebook'])->get($table);
                }
                
                $data["list"] = $query->result();
                $this->load->view("AdminPanel/EBookEnrollments", $data);
            }
            else{
                redirect(base_url('AdminPanel/EBookEnrollments/success'));
            }
        }
        
        #Abook Enrollment
        
        public function ABookEnrollments()
        {
            $table='tbl_enroll';
            $data['authorlist']=$this->db->get('tbl_tutor')->result();
            if ($this->uri->segment(3) == TRUE) 
            {
                $action = $this->uri->segment(3);
                if(!empty($_REQUEST['author']))
                {
                    $educatorABooks=$this->Auth_model->educatorABooks($_REQUEST['author']);
                    $query = $this->db->where(['paymentstatus'=>$action,'itemtype'=>'Abook'])->where_in('itemid',$educatorABooks)->get($table);
                }
                else{
                    $query = $this->db->where(['paymentstatus'=>$action,'itemtype'=>'Abook'])->get($table);
                }
                $data["list"] = $query->result();
                $this->load->view("AdminPanel/ABookEnrollments", $data);
            }
            else{
                redirect(base_url('AdminPanel/ABookEnrollments/success'));
            }
        }
        
        # Manage Students
        
        public function ManageStudents()
        {
            $table='tbl_registration';
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
                        $data["profile"] = $data["list"][0];
                        $data["live_session"] =$this->db->where(['mobile'=>$data["profile"]->number])->get('tbl_live_join')->num_rows();
                        $data["courses"]=$this->db->where(['userid'=>$data["profile"]->id,'itemtype'=>'Course'])->get('tbl_enroll')->num_rows();
                        $data["books"]=$this->db->where(['userid'=>$data["profile"]->id,'itemtype'=>'Ebook'])->get('tbl_enroll')->num_rows();
                        $data["certificates"]=$this->db->where(['userid'=>$data["profile"]->id,'itemtype'=>'Course','certificate'=>'true'])->get('tbl_enroll')->num_rows();
                        
                        if($action=='Profile'){
                            
                            $table='tbl_course';
                            $whereData=[
                            'userid'=>$data["profile"]->id,
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
                                
                                // $mark_as_completed=count(explode(',',$enroll->mark_as_completed))-1;
                                // if($mark_as_completed<0){ $mark_as_completed=0; }
                                // $lecture=$this->db->where('course',$enroll->itemid)->get('tbl_lecture')->num_rows();
                                // $progress=((100*$mark_as_completed)/$lecture).'%';
                                $progress=rand(0,100).'%';
                                $return[$i]->progress=$progress;		
                                $i++;
                            }
                            
                            $data['courseList']=$return;
                            
                            $table='tbl_ebook';
                            
                            $whereData=[
                            'userid'=>$data["profile"]->id,
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
                            
                            $result=$this->db->where(['userid'=>$data["profile"]->id])->order_by("id", "DESC")->get('tbl_enroll');
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
                            $data['orderlist']=$return;
                            
                            
                            $result=$this->db->where(['mobile'=>$data["profile"]->number])->order_by("id", "DESC")->get('tbl_live_join');
                            $i=0;
                            $return=[];
                            foreach ($result->result() as $attend){
                                
                                $return[$i]=$attend;
                                $return[$i]->item=$this->db->where('id',$attend->liveid)->get('tbl_live_video')->row();;
                                $i++;
                            }
                            $data['livesessionlist']=$return;
                            
                            $this->load->view("AdminPanel/StudentProfile.php", $data);
                        }
                        else if($action=='Update')
                        {
                            if (isset($_POST["updateaction"])) 
                            {  
                                if($this->form_validation->run('updateProfile') == FALSE)
                                {
                                    $msg=explode('</p>',validation_errors());
                                    $msg=str_ireplace('<p>','', $msg[0]);
                                    
                                    $this->session->set_flashdata(array('res'=>'error','msg'=>$msg));
                                    redirect(base_url('AdminPanel/ManageStudents/Profile/'.$id));
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
                                            redirect(base_url('AdminPanel/ManageStudents/Profile/'.$id));
                                        }
                                        else{
                                            $this->session->set_flashdata(array('res'=>'error','msg'=>'Updation Failed !'));
                                            redirect(base_url('AdminPanel/ManageStudents/Profile/'.$id));
                                        }
                                    }
                                    else
                                    {
                                        $this->session->set_flashdata(array('res'=>'error','msg'=>'Invalid User ID'));
                                        redirect(base_url('AdminPanel/ManageStudents/Profile/'.$id));
                                    }
                                }
                            }
                            else{
                                redirect(base_url('AdminPanel/ManageStudents/Profile/'.$id));
                            }
                        }
                        else{
                            redirect(base_url('AdminPanel/ManageStudents/Profile/'.$id));
                        }
                        
                    }
                    else
                    {
                        redirect(base_url('AdminPanel/ManageStudents'));
                    }
                }
                else 
                {
                    redirect(base_url('AdminPanel/ManageStudents')); 
                }
            }
            else 
            {
                $query = $this->db->order_by("id", "DESC")->get($table);
                $data["list"] = $query->result();
				$this->load->view("AdminPanel/ManageStudents", $data);
            }
        }
        
        public function VerifyPayment()
        {
            if ($this->uri->segment(3) == TRUE) 
            {
                $rzp_order_id = $this->uri->segment(3);
                
                
                if($this->razorpay->getRazorpayOrder($rzp_order_id)){
                    $rzp_order=$this->razorpay->getRazorpayOrder($rzp_order_id);
                    echo '<pre>';
                    print_r($rzp_order);
                }
                else{
                    echo 'The id provided does not exist'; 
                }
                
                
                if($this->razorpay->getRazorpayOrderPayment($rzp_order_id)){
                    $rzp_order_payment=$this->razorpay->getRazorpayOrderPayment($rzp_order_id);
                    print_r($rzp_order_payment);
                }
                else{
                    echo 'The id provided does not exist'; 
                }
                
            }
        }
        
        public function RecommendedVideos()
        {
            $table='tbl_recommended_videos';
            $data['authorlist']=$this->db->where('status','true')->get('tbl_tutor')->result();
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
                        
                        $data['subjectlist']=$this->db->where('status','true')->get('tbl_subject')->result();
                        $data['videolist']=$this->db->where('status','true')->get('tbl_video')->result();
                        if($action=='Edit'){
                            $data["action"]="EditRecommendedVideo";
                            $this->load->view("AdminPanel/Modal", $data);
                        }
                        else
                        {
                            redirect(base_url('AdminPanel/RecommendedVideos'));
                        }
                    }
                    else
                    {
                        redirect(base_url('AdminPanel/RecommendedVideos'));
                    }
                }
                else 
                {
                    if($action=='Add')
                    {
                        if (isset($_POST["addaction"])) 
                        {    
                            $this->form_validation->set_rules('subject', 'Subject', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('title', 'Title', 'required');
                            $this->form_validation->set_rules('description', 'Description', 'required', array('required' => '%s is Required Field'));
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
                            
                            if ($this->form_validation->run() == FALSE)
                            {
                                $msg=explode('</p>',validation_errors());
                                $msg=str_ireplace('<p>','', $msg[0]);
                                $this->session->set_flashdata(array('res'=>'error','msg'=>$msg));
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
                                    $getYoutubeLinkData=$this->Auth_model->getYoutubeLinkData($this->input->post("link"));
                                    $_POST['link']=$getYoutubeLinkData->embedUrl;
                                    $video='';
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
                                        $config['max_size'] = 10000000; // In KB
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
                                        $config['max_size'] = 1000000000; // In KB
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
                                    "author" => $this->input->post("author"),
                                    "subject" =>strtoupper($this->input->post("subject")),
                                    "video" => $video_id,
                                    "title" => $this->input->post("title"),
                                    "description" => $this->input->post("description"),
                                    "for_user" => $this->input->post("for_user"),
                                    "status" => "true",
                                    "date" => $this->date,
                                    "time" => $this->time
                                    );
                                    $data_to_insert = $this->security->xss_clean($data_to_insert);
                                    
                                    if ($this->db->insert($table, $data_to_insert)) {
                                        $this->session->set_flashdata(array('res'=>'success','msg'=>'Video Added Successfully.'));
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
                                    
                                    $this->form_validation->set_rules('subject', 'Subject', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('video', 'Video', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('description', 'Description', 'required', array('required' => '%s is Required Field'));
                                    if ($this->form_validation->run() == FALSE){
                                        $msg=explode('</p>',validation_errors());
                                        $msg=str_ireplace('<p>','', $msg[0]);
                                        $this->session->set_flashdata(array('res'=>'error','msg'=>$msg));
                                    } 
                                    else 
                                    {
                                        $data_to_update= array(
                                        "author" => $this->input->post("author"),
                                        "subject" =>strtoupper($this->input->post("subject")),
                                        "video" => $this->input->post("video"),
                                        "title" => $this->input->post("title"),
                                        "description" => $this->input->post("description")
                                        );
                                        $data_to_update = $this->security->xss_clean($data_to_update);
                                        $result=$this->db->where('id',$data['list'][0]->id)->update($table,$data_to_update);
                                        
                                        if($result) 
                                        {
                                            $this->session->set_flashdata(array('res'=>'success','msg'=>'Recommended Video Updated Successfully.')); 
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
                    redirect(base_url('AdminPanel/RecommendedVideos')); 
                }
            }
            else 
            {
                
                $query = $this->db->where(['type'=>'RecommendedVideos'])->order_by("id", "DESC")->get($table);
                $data["list"] = $query->result();
                $data['authorlist']=$this->db->where('status','true')->get('tbl_tutor')->result();
                $data['subjectlist']=$this->db->where('status','true')->get('tbl_subject')->result();
                
                $data['videolist']=$this->db->where('status','true')->get('tbl_video')->result();
                
                if($query->num_rows()){
                    $return=[];
                    $i=0;
                    foreach ($data["list"] as $item){
                        $return[$i]=$item;
                        $return[$i]->author=$this->db->where('id',$item->author)->get('tbl_tutor')->row();
                        $return[$i]->subject=$this->db->where('id',$item->subject)->get('tbl_subject')->row();
                        $return[$i]->video=$this->db->where('id',$item->video)->get('tbl_video')->row();
                        $i++;
                    }
					$data["list"]=$return;
                }
				$this->load->view("AdminPanel/RecommendedVideos.php", $data);
            }
        }
        
        public function FreeAndShortVideos()
        {
            $table='tbl_recommended_videos';
            $data['authorlist']=$this->db->where('status','true')->get('tbl_tutor')->result();
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
                        
                        $data['subjectlist']=$this->db->where('status','true')->get('tbl_subject')->result();
                        $data['videolist']=$this->db->where('status','true')->get('tbl_video')->result();
                        if($action=='Edit'){
                            $data["action"]="EditFreeAndShortVideo";
                            $this->load->view("AdminPanel/Modal", $data);
                        }
                        else
                        {
                            redirect(base_url('AdminPanel/FreeAndShortVideos'));
                        }
                    }
                    else
                    {
                        redirect(base_url('AdminPanel/FreeAndShortVideos'));
                    }
                }
                else 
                {
                    if($action=='Add')
                    {
                        if (isset($_POST["addaction"])) 
                        {    
                            $this->form_validation->set_rules('subject', 'Subject', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('video', 'Video', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('description', 'Description', 'required', array('required' => '%s is Required Field'));
							$this->form_validation->set_rules('type', 'Type', 'required', array('required' => '%s is Required Field'));
                            if ($this->form_validation->run() == FALSE){
                                $msg=explode('</p>',validation_errors());
                                $msg=str_ireplace('<p>','', $msg[0]);
                                $this->session->set_flashdata(array('res'=>'error','msg'=>$msg));
                            } 
                            else 
                            {
                                $data_to_insert= array(
                                "author" => $this->input->post("author"),
                                "subject" =>strtoupper($this->input->post("subject")),
                                "video" => $this->input->post("video"),
                                "description" => $this->input->post("description"),
                                "type" => $this->input->post("type"),
                                "status" => "true",
                                "date" => $this->date,
                                "time" => $this->time
                                );
                                $data_to_insert = $this->security->xss_clean($data_to_insert);
                                if ($this->db->insert($table, $data_to_insert)) {
                                    
                                    $this->session->set_flashdata(array('res'=>'success','msg'=>'Added Successfully.'));
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
                                    
                                    $this->form_validation->set_rules('subject', 'Subject', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('video', 'Video', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('description', 'Description', 'required', array('required' => '%s is Required Field'));
									$this->form_validation->set_rules('type', 'Type', 'required', array('required' => '%s is Required Field'));
                                    if ($this->form_validation->run() == FALSE){
                                        $msg=explode('</p>',validation_errors());
                                        $msg=str_ireplace('<p>','', $msg[0]);
                                        $this->session->set_flashdata(array('res'=>'error','msg'=>$msg));
                                    } 
                                    else 
                                    {
                                        $data_to_update= array(
                                        "author" => $this->input->post("author"),
                                        "subject" =>strtoupper($this->input->post("subject")),
                                        "video" => $this->input->post("video"),
                                        "description" => $this->input->post("description"),
										"type" => $this->input->post("type")
                                        );
                                        $data_to_update = $this->security->xss_clean($data_to_update);
                                        $result=$this->db->where('id',$data['list'][0]->id)->update($table,$data_to_update);
                                        
                                        if($result) 
                                        {
                                            $this->session->set_flashdata(array('res'=>'success','msg'=>'Updated Successfully.')); 
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
                    redirect(base_url('AdminPanel/FreeAndShortVideos')); 
                }
            }
            else 
            {
                
                $query = $this->db->where(['type'=>'FreeVideos'])->or_where(['type'=>'ShortTricks'])->order_by("id", "DESC")->get($table);
                $data["list"] = $query->result();
                
                $data['subjectlist']=$this->db->where('status','true')->get('tbl_subject')->result();
                
                $data['videolist']=$this->db->where('status','true')->get('tbl_video')->result();
                
                if($query->num_rows()){
                    $return=[];
                    $i=0;
                    foreach ($data["list"] as $item){
                        $return[$i]=$item;
                        $return[$i]->author=$this->db->where('id',$item->author)->get('tbl_tutor')->row();
                        $return[$i]->subject=$this->db->where('id',$item->subject)->get('tbl_subject')->row();
                        $return[$i]->video=$this->db->where('id',$item->video)->get('tbl_video')->row();
                        $i++;
                    }
					$data["list"]=$return;
                }
				$this->load->view("AdminPanel/FreeAndShortVideos.php", $data);
            }
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
				
				$result=$this->db->where(['id'=>$courseid])->get('tbl_course');
                // print_r($result);die;
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
                        
                        $this->load->view("AdminPanel/VideoPlaylist.php",$data);
                    }
                    else{
                        redirect(base_url('AdminPanel/ManageCourses/Details/'.$courseid));
                    }
                }
				else{
					redirect(base_url('Student/ManageCourses'));
                }	
            }
			else{
				redirect(base_url('Student/ManageCourses'));
            }
        }
        
        public function CertificateStatus()
        { 
            $output['res']="error";
            $output['msg']="error";
            $output['data']="";
            
            $table='tbl_enroll';
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
                            if($this->uri->segment(5)=='true'){
                                $status='true';
                            }
                            else{
                                $status='false';
                            }
                            $data["action"]="EditCertificate";
                            $courseData = $this->db->where(['id'=>$data["list"][0]->itemid])->get('tbl_course')->row();
                            
                            $cresult = $this->db->where(['userid'=>$data["list"][0]->userid,'enrollid'=>$data["list"][0]->id,'itemtype'=>'Course'])->get('tbl_certificate');
                            if($cresult->num_rows()){
                                $certificateData=$cresult->row();
                                $data['certificateData'] = (object) [
                                'userid' => $certificateData->userid,
                                'enrollid' => $certificateData->enrollid,
                                'name' => $certificateData->name,
                                'mobile' => $certificateData->mobile,
                                'email' => $certificateData->email,
                                'issuedon' => $certificateData->issuedon,
                                'grade' =>$certificateData->grade,
                                'duration' =>$certificateData->duration,
                                'from_date' =>$certificateData->from_date,
                                'to_date' =>$certificateData->to_date,
                                'itemid' => $certificateData->itemid,
                                'itemtype' => $certificateData->itemtype,
                                'status' => $status
                                ];
                            }
                            else{
                                $data['certificateData'] = (object) [
                                'userid' => $data["list"][0]->userid,
                                'enrollid' => $data["list"][0]->id,
                                'name' => $data["list"][0]->firstname.' '.$data["list"][0]->lastname,
                                'mobile' => $data["list"][0]->mobile,
                                'email' => $data["list"][0]->email,
                                'issuedon' => date('Y-m-d'),
                                'grade' =>'A+',
                                'duration' =>$courseData->daystofinish.' Days',
                                'from_date' => date('Y-m-d',strtotime($data["list"][0]->date)),
                                'to_date' => date('Y-m-d',strtotime('+'.$courseData->daystofinish.' days',strtotime($data["list"][0]->date))),
                                'itemid' => $data["list"][0]->itemid,
                                'itemtype' => $data["list"][0]->itemtype,
                                'status' => $status
                                ];
                            }
                            
                            $this->load->view("AdminPanel/Modal", $data);
                        }
                    }
                }
                else
                {
                    if(!empty($_POST) and $this->form_validation->run('certificate')) 
					{
                        
                        if($this->input->post('status')=='true'){
                            $msg='Issued this Certificate.';
                        }
                        else{
                            $msg='Non-Issued this Certificate.'; 
                        }
                        
                        $cresult = $this->db->where(['userid'=>$this->input->post('userid'),'enrollid'=>$this->input->post('enrollid'),'itemtype'=>'Course'])->get('tbl_certificate');
                        if($cresult->num_rows())
                        {
                            $updateData=[
                            'name'=>$this->input->post('name'),
                            'mobile'=>$this->input->post('mobile'),
                            'email'=>$this->input->post('email'),
                            'issuedon'=>$this->input->post('issuedon'),
                            'grade'=>$this->input->post('grade'),
                            'duration'=>$this->input->post('duration'),
                            'from_date'=>$this->input->post('from_date'),
                            'to_date'=>$this->input->post('to_date'),
                            'itemid'=>$this->input->post('itemid'),
                            'itemtype'=>$this->input->post('itemtype'),
                            'status'=>$this->input->post('status'),
                            'date'=>$this->dateY,
                            'time'=>$this->time
                            ];
                            $result=$this->db->where(['userid'=>$this->input->post('userid'),'id'=>$this->input->post('enrollid')])->update('tbl_enroll',['issuedon'=>$this->input->post('issuedon'),'certificate'=>$this->input->post('status')]);
                            
                            $result=$this->db->where(['userid'=>$this->input->post('userid'),'enrollid'=>$this->input->post('enrollid'),'itemtype'=>'Course'])->update('tbl_certificate',$updateData);
                            if($result){
                                
                                $output['res']="success";
                                $output['msg']=$msg;
                            }
                            else{
                                $output['msg']="Failed !";
                            }
                        }
                        else{
                            
                            $insertData=[
                            'userid'=>$this->input->post('userid'),
                            'enrollid'=>$this->input->post('enrollid'),
                            'name'=>$this->input->post('name'),
                            'mobile'=>$this->input->post('mobile'),
                            'email'=>$this->input->post('email'),
                            'issuedon'=>$this->input->post('issuedon'),
                            'grade'=>$this->input->post('grade'),
                            'duration'=>$this->input->post('duration'),
                            'from_date'=>$this->input->post('from_date'),
                            'to_date'=>$this->input->post('to_date'),
                            'itemid'=>$this->input->post('itemid'),
                            'itemtype'=>$this->input->post('itemtype'),
                            'status'=>$this->input->post('status'),
                            'date'=>$this->dateY,
                            'time'=>$this->time
                            ];
                            
                            
                            if($this->db->insert('tbl_certificate',$insertData)){
                                $insert_id = $this->db->insert_id();
                                $refno='DCT'.date('Y').'0'.$insert_id;
                                $this->db->where(['userid'=>$this->input->post('userid'),'id'=>$this->input->post('enrollid')])->update('tbl_enroll',['issuedon'=>$this->input->post('issuedon'),'refno'=>$refno,'certificate'=>$this->input->post('status')]);
                                $this->db->where(['id'=>$insert_id])->update('tbl_certificate',['refno'=>$refno]);
                                
                                $output['res']="success";
                                $output['msg']=$msg;
                            }
                            else{
                                $output['msg']="Failed !";
                            } 
                        }
                    }
                    else{
                        $msg=explode('</p>',validation_errors());
                        $output['msg']=str_ireplace('<p>','', $msg[0]);
                    }
                    echo json_encode([$output], JSON_UNESCAPED_UNICODE);
                }
                
            }
            else 
            {
                $output['msg']="Empty Action";
                echo json_encode([$output], JSON_UNESCAPED_UNICODE);
            }
        }
        
        public function CertificateStatusLive()
        { 
            $output['res']="error";
            $output['msg']="error";
            $output['data']="";
            
            $table='tbl_live_join';
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
                            if($this->uri->segment(5)=='true'){
                                $status='true';
                            }
                            else{
                                $status='false';
                            }
                            $data["action"]="EditCertificate";
                            $courseData = $this->db->where(['id'=>$data["list"][0]->liveid])->get('tbl_live_video')->row();
                            
                            $cresult = $this->db->where(['userid'=>$data["list"][0]->userid,'enrollid'=>$data["list"][0]->id,'itemtype'=>'LiveSession'])->get('tbl_certificate');
                            if($cresult->num_rows()){
                                $certificateData=$cresult->row();
                                $data['certificateData'] = (object) [
                                'userid' => $certificateData->userid,
                                'enrollid' => $certificateData->enrollid,
                                'name' => $certificateData->name,
                                'mobile' => $certificateData->mobile,
                                'email' => $certificateData->email,
                                'issuedon' => $certificateData->issuedon,
                                'grade' =>$certificateData->grade,
                                'duration' =>$certificateData->duration,
                                'from_date' =>$certificateData->from_date,
                                'to_date' =>$certificateData->to_date,
                                'itemid' => $certificateData->itemid,
                                'itemtype' => $certificateData->itemtype,
                                'status' => $status
                                ];
                            }
                            else{
                                $data['certificateData'] = (object) [
                                'userid' => $data["list"][0]->userid,
                                'enrollid' => $data["list"][0]->id,
                                'name' => $data["list"][0]->name,
                                'mobile' => $data["list"][0]->mobile,
                                'email' => $data["list"][0]->email,
                                'issuedon' => date('Y-m-d'),
                                'grade' =>'A+',
                                'duration' =>$courseData->duration,
                                'from_date' => date('Y-m-d',strtotime($data["list"][0]->date)),
                                'to_date' => date('Y-m-d',strtotime($data["list"][0]->date)),
                                'itemid' => $data["list"][0]->liveid,
                                'itemtype' => 'LiveSession',
                                'status' => $status
                                ];
                            }
                            
                            $this->load->view("AdminPanel/Modal", $data);
                        }
                    }
                }
                else
                {
                    if(!empty($_POST) and $this->form_validation->run('certificate')) 
					{
                        
                        if($this->input->post('status')=='true'){
                            $msg='Issued this Certificate.';
                        }
                        else{
                            $msg='Non-Issued this Certificate.'; 
                        }
                        
                        $cresult = $this->db->where(['userid'=>$this->input->post('userid'),'enrollid'=>$this->input->post('enrollid'),'itemtype'=>'LiveSession'])->get('tbl_certificate');
                        if($cresult->num_rows())
                        {
                            $updateData=[
                            'name'=>$this->input->post('name'),
                            'mobile'=>$this->input->post('mobile'),
                            'email'=>$this->input->post('email'),
                            'issuedon'=>$this->input->post('issuedon'),
                            'grade'=>$this->input->post('grade'),
                            'duration'=>$this->input->post('duration'),
                            'from_date'=>$this->input->post('from_date'),
                            'to_date'=>$this->input->post('to_date'),
                            'itemid'=>$this->input->post('itemid'),
                            'itemtype'=>$this->input->post('itemtype'),
                            'status'=>$this->input->post('status'),
                            'date'=>$this->dateY,
                            'time'=>$this->time
                            ];
                            $result=$this->db->where(['userid'=>$this->input->post('userid'),'id'=>$this->input->post('enrollid')])->update('tbl_live_join',['issuedon'=>$this->input->post('issuedon'),'certificate'=>$this->input->post('status')]);
                            
                            $result=$this->db->where(['userid'=>$this->input->post('userid'),'enrollid'=>$this->input->post('enrollid'),'itemtype'=>'LiveSession'])->update('tbl_certificate',$updateData);
                            if($result){
                                
                                $output['res']="success";
                                $output['msg']=$msg;
                            }
                            else{
                                $output['msg']="Failed !";
                            }
                        }
                        else{
                            
                            $insertData=[
                            'userid'=>$this->input->post('userid'),
                            'enrollid'=>$this->input->post('enrollid'),
                            'name'=>$this->input->post('name'),
                            'mobile'=>$this->input->post('mobile'),
                            'email'=>$this->input->post('email'),
                            'issuedon'=>$this->input->post('issuedon'),
                            'grade'=>$this->input->post('grade'),
                            'duration'=>$this->input->post('duration'),
                            'from_date'=>$this->input->post('from_date'),
                            'to_date'=>$this->input->post('to_date'),
                            'itemid'=>$this->input->post('itemid'),
                            'itemtype'=>$this->input->post('itemtype'),
                            'status'=>$this->input->post('status'),
                            'date'=>$this->dateY,
                            'time'=>$this->time
                            ];
                            
                            
                            if($this->db->insert('tbl_certificate',$insertData)){
                                $insert_id = $this->db->insert_id();
                                $refno='DCT'.date('Y').'0'.$insert_id;
                                $this->db->where(['userid'=>$this->input->post('userid'),'id'=>$this->input->post('enrollid')])->update('tbl_live_join',['issuedon'=>$this->input->post('issuedon'),'refno'=>$refno,'certificate'=>$this->input->post('status')]);
                                $this->db->where(['id'=>$insert_id])->update('tbl_certificate',['refno'=>$refno]);
                                
                                $output['res']="success";
                                $output['msg']=$msg;
                            }
                            else{
                                $output['msg']="Failed !";
                            } 
                        }
                    }
                    else{
                        $msg=explode('</p>',validation_errors());
                        $output['msg']=str_ireplace('<p>','', $msg[0]);
                    }
                    echo json_encode([$output], JSON_UNESCAPED_UNICODE);
                }
                
            }
            else 
            {
                $output['msg']="Empty Action";
                echo json_encode([$output], JSON_UNESCAPED_UNICODE);
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
        
        
        public function ManageCertificates()
        {
            $table='tbl_certificate';
            if ($this->uri->segment(3) == TRUE) 
            {
                $action = $this->uri->segment(3);
                if($action=='Requested')
                {
                    $query = $this->db->where(['status'=>'requested'])->order_by("id", "DESC")->get($table);
                    $data["list"] = $query->result();
                    $this->load->view("AdminPanel/RequestedCertificates", $data);
                }
                else if($action=='Issued')
                {
                    $query = $this->db->where(['status'=>'true'])->order_by("id", "DESC")->get($table);
                    $data["list"] = $query->result();
                    $data['pageTitle']='Issued Certificates';
                    $this->load->view("AdminPanel/IssuedCertificates", $data);
                }
                else if($action=='NonIssued')
                {
                    $query = $this->db->where(['status'=>'false'])->order_by("id", "DESC")->get($table);
                    $data["list"] = $query->result();
                    $data['pageTitle']='Non-Issued Certificates';
                    $this->load->view("AdminPanel/IssuedCertificates", $data);
                }
                else if($action=='NewOrders')
                {
                    $table='tbl_certificate_order';
                    $query = $this->db->where(['order_status'=>'Order Placed'])->order_by("id", "DESC")->get($table);
                    $data["list"] = $query->result();
                    $data['pageTitle']='New Orders';
                    $this->load->view("AdminPanel/HardCopyOrders", $data);    
                }
                else if($action=='RunningOrders')
                {
                    $table='tbl_certificate_order';
                    $query = $this->db->where_not_in('order_status',['Order Placed','Order Delivered'])->order_by("id", "DESC")->get($table);
                    $data["list"] = $query->result();
                    $data['pageTitle']='Running Orders';
                    $this->load->view("AdminPanel/HardCopyOrders", $data);    
                }
                else if($action=='DeliveredOrders')
                {
                    $table='tbl_certificate_order';
                    $query = $this->db->where(['order_status'=>'Order Delivered'])->order_by("id", "DESC")->get($table);
                    $data["list"] = $query->result();
                    $data['pageTitle']='Delivered Orders';
                    $this->load->view("AdminPanel/HardCopyOrders", $data);    
                }
                else if($action=='PendingOrders')
                {
                    $table='tbl_certificate_order';
                    $query = $this->db->where(['status'=>'Pending'])->order_by("id", "DESC")->get($table);
                    $data["list"] = $query->result();
                    $data['pageTitle']='Pending Orders';
                    $this->load->view("AdminPanel/HardCopyOrders", $data);    
                }
                else if($action=='SuccessOrders')
                {
                    $table='tbl_certificate_order';
                    $query = $this->db->where(['status'=>'success'])->order_by("id", "DESC")->get($table);
                    $data["list"] = $query->result();
                    $data['pageTitle']='Success Orders';
                    $this->load->view("AdminPanel/HardCopyOrders", $data);    
                }
                else if($action=='FailedOrders')
                {
                    $table='tbl_certificate_order';
                    $query = $this->db->where(['status'=>'failed'])->order_by("id", "DESC")->get($table);
                    $data["list"] = $query->result();
                    $data['pageTitle']='Failed Orders';
                    $this->load->view("AdminPanel/HardCopyOrders", $data);    
                }
                else if($action=='UpdateOrders')
                {
                    $table='tbl_certificate_order';
                    if($this->uri->segment(4)==TRUE)
                    {
                        $id = $this->uri->segment(4);
                        $query = $this->db->where('id', $id)->get($table);
                        if ($query->num_rows()) 
                        {
                            $data["list"] = $query->result();
                            $data["action"]="TrackHDCOrder";
                            $this->load->view("AdminPanel/Modal", $data); 
                        }
                    }
                    else
                    {
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
                                    
                                    $updateData= array(
                                    "order_status" => $this->input->post("order_status"),
                                    "expected_date" => $this->input->post('expected_date'),
                                    "delivery_date" => $this->input->post("delivery_date"),
                                    );
                                    $result=$this->db->where('id',$data['list'][0]->id)->update($table,$updateData);
                                    $this->session->set_flashdata(array('res'=>'success','msg'=>'Updated Successfully.')); 
                                }
                                else{
                                    $this->session->set_flashdata(array('res'=>'error','msg'=>'ID is invalid.'));
                                }
                            }
                        }
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                }
                else{
                    redirect(base_url('AdminPanel/ManageCertificates/Issued'));
                }
            }
            else 
            {
                redirect(base_url('AdminPanel/ManageCertificates/Issued'));
            }
        }
        
        public function VideoPerformance()
        {
            $query = $this->db->where(['paymentstatus'=>'success','itemtype'=>'Course'])->get('tbl_enroll');
            $data["list"] = $query->result();
            $i=0;
            foreach ($data["list"] as $value)
            {
                $return[$i]=$value;
                $return[$i]->item=$this->db->where('id',$value->itemid)->get('tbl_course')->row();	
                
                // $mark_as_completed=count(explode(',',$enroll->mark_as_completed))-1;
                // if($mark_as_completed<0){ $mark_as_completed=0; }
                // $lecture=$this->db->where('course',$enroll->itemid)->get('tbl_lecture')->num_rows();
                // $progress=((100*$mark_as_completed)/$lecture).'%';
                $progress=rand(0,100).'%';
                $return[$i]->progress=$progress;	
                $i++;
            }
            $this->load->view("AdminPanel/VideoPerformance", $data);
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
							$this->load->view("AdminPanel/Modal", $data);
                        }
						else
						{
							redirect(base_url('AdminPanel/ManageQuestions'));
                        }
                    }
					else
					{
						redirect(base_url('AdminPanel/ManageQuestions'));
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
								'teacher_id'=>0,
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
										$config['max_size']      = 100000000;
										$config['file_name']     = $this->input->post('a');
										$this->load->library('upload', $config);
										$this->upload->do_upload('a');
										
										$config['upload_path']   = './uploads/question/';
										$config['allowed_types'] = 'gif|jpg|png|jpeg';
										$config['max_size']      = 100000000;
										$config['file_name']     = $this->input->post('b');
										$this->upload->initialize($config);
										$this->upload->do_upload('b');
										
										$config['upload_path']   = './uploads/question/';
										$config['allowed_types'] = 'gif|jpg|png|jpeg';
										$config['max_size']      = 100000000;
										$config['file_name']     = $this->input->post('c');
										$this->upload->initialize($config);
										$this->upload->do_upload('c');
										
										$config['upload_path']   = './uploads/question/';
										$config['allowed_types'] = 'gif|jpg|png|jpeg';
										$config['max_size']      = 100000000;
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
												$config['max_size']      = 100000000;
												$config['file_name']     = $this->input->post('a');
												$this->load->library('upload', $config);
												$this->upload->do_upload('a');
												$initialize=true;
                                            }
											
											if(!empty($_FILES["b"]["name"]))
											{
												$config['upload_path']   = './uploads/question/';
												$config['allowed_types'] = 'gif|jpg|png|jpeg';
												$config['max_size']      = 100000000;
												$config['file_name']     = $this->input->post('b');
												if($initialize==true){ $this->load->initialize($config); } else{ $this->load->library('upload', $config); }
												$this->upload->do_upload('b');
												$initialize=true;
                                            }
											
											if(!empty($_FILES["c"]["name"]))
											{
												$config['upload_path']   = './uploads/question/';
												$config['allowed_types'] = 'gif|jpg|png|jpeg';
												$config['max_size']      = 100000000;
												$config['file_name']     = $this->input->post('c');
												if($initialize==true){ $this->load->initialize($config); } else{ $this->load->library('upload', $config); }
												$this->upload->do_upload('c');
												$initialize=true;
                                            }
											
											if(!empty($_FILES["d"]["name"]))
											{
												$config['upload_path']   = './uploads/question/';
												$config['allowed_types'] = 'gif|jpg|png|jpeg';
												$config['max_size']      = 100000000;
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
								$config['max_size']=10000000000;
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
                                        'teacher_id'=>0,
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
                    else if($action=='Import')
					{
						if(!empty($this->input->post()))
						{
						    
						    $this->allowedFileType=[
                				'application/vnd.ms-excel'
                			];
			                
							if(empty($_FILES['excelfile']['name']))
							{
								$this->session->set_flashdata(array('res'=>'error','msg'=>'Choose Excel File.'));
                            }
                            else if(empty($_FILES['excelfile']['size'])>0)
							{
								$this->session->set_flashdata(array('res'=>'error','msg'=>'Choose Excel File.'));
                            }
							else if(!in_array($_FILES["excelfile"]["type"],$this->allowedFileType))
							{
								$this->session->set_flashdata(array('res'=>'error','msg'=>'Invalid Excel File.'));
                            }
							else
							{    
                                $insertData=[];
                                $handle = fopen($_FILES['excelfile']['tmp_name'], "r");
                        		$headers = fgetcsv($handle, 1000, ",");
                        		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
                        		{
                        			$srno=$data[0];
									$subject_id=$data[1];
									$question=$data[2];
									$a=$data[3];
									$b=$data[4];
									$c=$data[5];
									$d=$data[6];
									$answer=$data[7];
									$week=$data[8];
									
									$insertData[]=[
                                        'teacher_id'=>0,
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
					redirect(base_url('AdminPanel/ManageQuestions')); 
                }
            }
			else 
			{
				
				$query = $this->db->order_by("id", "DESC")->get($table);
				$data["list"] = $query->result();
				
				$i=0; $return=[];
				foreach ($data["list"] as $item) {
					$return[$i]=$item;
					$return[$i]->subject=$this->db->where('id',$item->subject_id)->get('tbl_subject')->row();
					$i++;
                }
				$this->load->view("AdminPanel/ManageQuestions.php", $data);
            }
        }
        
        
        #ManageQuiz
		public function ManageQuiz()
		{
			$table='tbl_quiz';
			
			$this->ansList=['a'=>'Option A','b'=>'Option B','c'=>'Option C','d'=>'Option D'];
			$data['subjectList']=$this->db->where('status','true')->get('tbl_subject')->result();
			
			$data['courselist']=$this->db->where('apprstatus','true')->get('tbl_course')->result();
			$data['weekList']=$this->db->select('week')->distinct('week')->where('status','true')->get('tbl_questions')->result();
			
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
							$this->load->view("AdminPanel/Modal", $data);
                        }
						else if($action=='Questions'){
							
							$return=[];
							$questions=explode(',',$data['list'][0]->questions);
							for($i=0;$i<count($questions);$i++)
							{
								$return[$i]=$this->db->where('id',$questions[$i])->get('tbl_questions')->row();
                            }
							$data["questionslist"]=$return; 
							$this->load->view("AdminPanel/QuizQuestions", $data);
                        }
						else
						{
							redirect(base_url('AdminPanel/ManageQuiz'));
                        }
                    }
					else
					{
						redirect(base_url('AdminPanel/ManageQuiz'));
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
								'teacher_id'=>0,
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
                                    "teacher_id"=>0,
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
					redirect(base_url('AdminPanel/ManageQuiz')); 
                }
            }
			else 
			{
				
				$query = $this->db->order_by("id", "DESC")->get($table);
				$data["list"] = $query->result();
				$this->load->view("AdminPanel/ManageQuiz.php", $data);
            }
        }
        
        # Schedule Quiz
        public function ScheduleQuiz()
		{
			$table='tbl_quiz_scheduled';
			$this->ansList=['a'=>'Option A','b'=>'Option B','c'=>'Option C','d'=>'Option D'];
			$data['quizlist']=$this->db->where('status','true')->get('tbl_quiz')->result();
			$data['courselist']=$this->db->where('apprstatus','true')->get('tbl_course')->result();
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
							$this->load->view("AdminPanel/Modal", $data);
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
							
                            $this->load->view("AdminPanel/ScheduleQuiz", $data);
                        }
						else if($action=='Attend')
						{
							$data["action"]="Attend";
							$result=$this->db->where(['schedule_id'=>$data["list"][0]->id])->get('tbl_quiz_attended');
							$data["resultList"]=$result->result(); 
							$this->load->view("AdminPanel/ScheduleQuiz", $data);
                        }
						else
						{
							redirect(base_url('AdminPanel/ScheduleQuiz'));
                        }
                    }
					else
					{
						redirect(base_url('AdminPanel/ScheduleQuiz'));
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
								"teacher_id"=>0,
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
					redirect(base_url('AdminPanel/ScheduleQuiz')); 
                }
            }
			else 
			{
				$query = $this->db->order_by("id", "DESC")->get($table);
				$data["list"] = $query->result();
				$this->load->view("AdminPanel/ScheduleQuiz", $data);
            }
        }
        
        public function Parameters()
		{
			if ($this->uri->segment(3) == TRUE) 
			{
				$Parameter = $this->uri->segment(3);
                $data['action']='Parameters';
                $data['Parameter']=$Parameter;
				$data['ParameterData']='';
				
				if($Parameter=='Category')
                {
                    $results=$this->db->where('status','true')->order_by("id", "DESC")->get('tbl_category');
                    $results=$results->result();
                    
                    $i=0;$return=[];
                    foreach($results as $item)
                    {
                        $return[$i]=$item;
                        $return[$i]->data= (object) ['id'=>$item->id,'name'=>$item->title];
						$i++;
                    }
                    $data['ParameterData']=$return;
                }
				else if($Parameter=='Course')
                {
                    $results=$this->db->where('apprstatus','true')->order_by("id", "DESC")->get('tbl_course');
                    $results=$results->result();
                    
                    $i=0;$return=[];
                    foreach($results as $item)
                    {
                        $return[$i]=$item;
                        $return[$i]->data= (object) ['id'=>$item->id,'name'=>$item->name];
						$i++;
                    }
                    $data['ParameterData']=$return;
                }
                else if($Parameter=='Ebook')
                {
                    $results=$this->db->where('apprstatus','true')->order_by("id", "DESC")->get('tbl_ebook');
                    $results=$results->result();
                    
                    $i=0;$return=[];
                    foreach($results as $item)
                    {
                        $return[$i]=$item;
                        $return[$i]->data= (object) ['id'=>$item->id,'name'=>$item->name];
						$i++;
                    }
                    $data['ParameterData']=$return;
                }
                else if($Parameter=='Abook')
                {
                    $results=$this->db->where('apprstatus','true')->order_by("id", "DESC")->get('tbl_abook');
                    $results=$results->result();
                    
                    $i=0;$return=[];
                    foreach($results as $item)
                    {
                        $return[$i]=$item;
                        $return[$i]->data= (object) ['id'=>$item->id,'name'=>$item->name];
						$i++;
                    }
                    $data['ParameterData']=$return;
                }
                else if($Parameter=='Quiz')
                {
                    $results=$this->db->where('status','true')->order_by("id", "DESC")->get('tbl_quiz');
                    $results=$results->result();
                    
                    $i=0;$return=[];
                    foreach($results as $item)
                    {
                        $return[$i]=$item;
                        $return[$i]->data= (object) ['id'=>$item->id,'name'=>$item->name];
						$i++;
                    }
                    $data['ParameterData']=$return;
                }
                else if($Parameter=='LiveSession')
                {
                    $results=$this->db->where('status','true')->order_by("id", "DESC")->get('tbl_live_video');
                    $results=$results->result();
                    
                    $i=0;$return=[];
                    foreach($results as $item)
                    {
                        $return[$i]=$item;
                        $return[$i]->data= (object) ['id'=>$item->id,'name'=>$item->title];
						$i++;
                    }
                    $data['ParameterData']=$return;
                }
                else if($Parameter=='FreeVideo')
                {
                    $results=$this->db->where('status','true')->where('type','RecommendedVideos')->order_by("id", "DESC")->get('tbl_recommended_videos');
                    $results=$results->result();
                    
                    $i=0;$return=[];
                    foreach($results as $item)
                    {
                        $return[$i]=$item;
                        $videoData=$this->db->where('id',$item->video)->order_by("id", "DESC")->get('tbl_video')->row();
                        $return[$i]->data= (object) ['id'=>$item->id,'name'=>$videoData->title];
						$i++;
                    }
                    $data['ParameterData']=$return;
                }
                else if($Parameter=='Offer')
                {
                    $results=$this->db->where('status','true')->order_by("id", "DESC")->get('tbl_offer');
                    $results=$results->result();
                    
                    $i=0;$return=[];
                    foreach($results as $item)
                    {
                        $return[$i]=$item;
                        $return[$i]->data= (object) ['id'=>$item->id,'name'=>$item->coupon.' (Discount: '.$item->discount.')'.' (Discount Type: '.$item->discount_type.')'];
						$i++;
                    }
                    $data['ParameterData']=$return;
                }
                
				
				if(!empty($data['ParameterData'])){
					$this->load->view('AdminPanel/Modal',$data);
                }
                // var_dump($data['ParameterData']);
            } 
        }
        
        public function GetUsers()
		{
			if ($this->uri->segment(3) == TRUE) 
			{
				$type = $this->uri->segment(3);
                $data['action']='GetUsers';
                $data['type']=$type;
				$data['userData']='';
				
				if($type=='Student')
                {
                    $results=$this->db->where('status','true')->order_by("id", "DESC")->get('tbl_registration');
                    $results=$results->result();
                    
                    $i=0;$return=[];
                    foreach($results as $item)
                    {
                        $return[$i]=$item;
                        $return[$i]->data= (object) ['id'=>$item->id,'name'=>$item->name,'mobile'=>$item->number];
						$i++;
                    }
                    $data['userData']=$return;
                }
				else if($type=='Educator')
                {
                    $results=$this->db->where('status','true')->order_by("id", "DESC")->get('tbl_tutor');
                    $results=$results->result();
                    
                    $i=0;$return=[];
                    foreach($results as $item)
                    {
                        $return[$i]=$item;
                        $return[$i]->data= (object) ['id'=>$item->id,'name'=>$item->name,'mobile'=>$item->username];
						$i++;
                    }
                    $data['userData']=$return;
                }
                else if($type=='Both')
                {
                    $results=$this->db->where('status','true')->order_by("id", "DESC")->get('tbl_registration');
                    $results=$results->result();
                    
                    $i=0;$return=[];
                    foreach($results as $item)
                    {
                        $return[$i]=$item;
                        $return[$i]->data= (object) ['id'=>$item->id,'name'=>$item->name,'mobile'=>$item->number];
						$i++;
                    }
                    
                    $results=$this->db->where('status','true')->order_by("id", "DESC")->get('tbl_tutor');
                    $results=$results->result();
                    
                    
                    foreach($results as $item)
                    {
                        $return[$i]=$item;
                        $return[$i]->data= (object) ['id'=>$item->id,'name'=>$item->name,'mobile'=>$item->username];
						$i++;
                    }
                    $data['userData']=$return;
                }
				if(!empty($data['userData'])){
					$this->load->view('AdminPanel/Modal',$data);
                }
            } 
        }
        
        public function AppSplashScreen()
        {
            $table='tbl_splash_screen';
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
                            $data["action"]="EditAppSplashScreen";
                            $this->load->view("AdminPanel/Modal", $data);
                        }
                        else
                        {
                            redirect(base_url('AdminPanel/AppSplashScreen'));
                        }
                    }
                    else
                    {
                        redirect(base_url('AdminPanel/AppSplashScreen'));
                    }
                }
                else 
                {
                    if($action=='Add')
                    {
                     // print_r(isset($_POST["addaction"]));//
                        if (isset($_POST["addaction"])) 
                        {    
                            $this->form_validation->set_rules('title', 'Title', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('subtitle', 'Subtitle', 'required', array('required' => '%s is Required Field'));
                            $this->form_validation->set_rules('type', 'Type', 'required', array('required' => '%s is Required Field'));
							
                            if (empty($_FILES["screen"]["name"])) {
                                $this->form_validation->set_rules('screen', 'Splash Screen', 'required');
                            }
                            else{
                                $ext      = pathinfo($_FILES["screen"]["name"], PATHINFO_EXTENSION);
                                $filename = time().rand(). "." . $ext;
                            }
                            if($this->form_validation->run() == FALSE)
                            {
                                $msg=explode('</p>',validation_errors());
								$msg=str_ireplace('<p>','', $msg[0]);
								$this->session->set_flashdata(array('res'=>'error','msg'=>$msg));
                            } 
                            else 
                            {
                                $result=$this->db->get($table)->num_rows();
                                if($result){
                                    $status='false';
                                }
                                else{
                                    $status='true';
                                }
                                $data_to_insert= array(
                                "screen" => $filename,
                                "screen_path" => base_url() . 'uploads/splash_screen/' . $filename,
                                "title" => $this->input->post("title"),
                                "subtitle" => $this->input->post("subtitle"),
                                "type" => $this->input->post("type"),
                                "status" => $status,
                                "date" => $this->date,
                                "time" => $this->time
                                );
                                $data_to_insert = $this->security->xss_clean($data_to_insert);
                                
                                if ($this->db->insert($table, $data_to_insert)) 
								{
                                    $upload_errors           = array();
                                    $config['upload_path']   = './uploads/splash_screen/';
                                    $config['allowed_types'] = 'gif|jpg|png|jpeg|mp4';
                                    $config['max_size']      = 10000000000;
                                    $config['file_name']     = $filename;
                                    $this->load->library('upload', $config);
                                    if (!$this->upload->do_upload('screen')) {
                                        array_push($upload_errors, array(
                                        'error_upload_logo' => $this->upload->display_errors()
                                        ));
                                        $this->session->set_flashdata(array('res'=>'upload_error','msg'=>'Data saved but error in file upload.'));
                                        
                                    }
                                    else{
                                        $this->session->set_flashdata(array('res'=>'success','msg'=>'Splash Screen Added Successfully.'));
                                    }
                                }
                                else 
                                {
                                    $this->session->set_flashdata(array('res'=>'error','msg'=>'Something went wrong in Data Shaving.'));
                                }
                            }
                        }
                        redirect(base_url('AdminPanel/AppSplashScreen'));
                    }
                    else if($action=='Update')
                    {
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
									
									$this->form_validation->set_rules('title', 'Title', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('subtitle', 'Subtitle', 'required', array('required' => '%s is Required Field'));
                                    $this->form_validation->set_rules('type', 'Type', 'required', array('required' => '%s is Required Field'));
									if ($this->form_validation->run() == FALSE)
									{
										$msg=explode('</p>',validation_errors());
										$msg=str_ireplace('<p>','', $msg[0]);
										$this->session->set_flashdata(array('res'=>'error','msg'=>$msg));
                                    } 
									else 
									{
                                        
                                        if (empty($_FILES["screen"]["name"])) {
                                            $filename=$data['list'][0]->screen;
                                        }
                                        else{
                                            $ext      = pathinfo($_FILES["screen"]["name"], PATHINFO_EXTENSION);
                                            $filename = time().rand(). "." . $ext;
                                        }
                                        
										$data_to_update= array(
                                        "screen" => $filename,
                                        "screen_path" => base_url() . 'uploads/splash_screen/' . $filename,
                                        "title" => $this->input->post("title"),
                                        "subtitle" => $this->input->post("subtitle"),
                                        "type" => $this->input->post("type"),
										);
										$data_to_update = $this->security->xss_clean($data_to_update);
										if ($this->db->where('id',$data['list'][0]->id)->update($table, $data_to_update)) 
                                        {
                                            if(!empty($_FILES["screen"]["name"])) 
                                            {
                                                $config['upload_path']   = './uploads/splash_screen/';
                                                $config['allowed_types'] = 'gif|jpg|png|jpeg|mp4';
                                                $config['max_size']      = 100000000;
                                                $config['file_name']     = $filename;
                                                $this->load->library('upload', $config);
                                                $this->upload->do_upload('screen');
                                            }
                                            
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
                        redirect(base_url('AdminPanel/AppSplashScreen'));
                    }
                    else if($action=='UpdateStatus')
                    {
                        $data = $this->input->post();
                        $result=$this->db->update($data['table'],array($data['column']=>'false'));
                        $result=$this->db->where($data['where_column'],$data['where_value'])->update($data['table'],array($data['column']=>$data['value']));
                        
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
            }
            else 
            {
                $query = $this->db->order_by("id", "DESC")->get($table);
                $data["list"] = $query->result();
                $this->load->view("AdminPanel/AppSplashScreen", $data);
            }
        }
        
        # Manage KYc
        public function ManageKYC()
        {
            $table='tbl_kyc';
            if ($this->uri->segment(3) == TRUE) 
            {
                $action = $this->uri->segment(3);
                $query = $this->db->where(['status'=>$action])->get($table);
                $data["list"] = $query->result();
                $this->load->view("AdminPanel/ManageKYC", $data);
            }
            else{
                redirect(base_url('AdminPanel/ManageKYC/Pending'));
            }
        }
        
        public function ManageAgreement()
        {
            $table='tbl_agreement';
            $query = $this->db->get($table);
            $data["list"] = $query->result();
            $this->load->view("AdminPanel/ManageAgreement", $data);
        }
        
        public function BannersStatus()
        {
            if ($this->input->post()) 
            {
                $data = $this->input->post();
                if($data['value']=='true')
                {
                    $result=$this->db->update($data['table'],array($data['column']=>'false'));
                }
                $result=$this->db->where('id',$data['id'])->update($data['table'],array($data['column']=>$data['value']));
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
                echo false;
            }
        }
        
        
        
        
    }                                                                                                                                                                                                                                                                                                        