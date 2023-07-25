<?php 
	
    class Auth_model extends CI_Model 
    {
        public function getData($table,$id)
        {
            $query = $this->db->where('id',$id)->get($table);
            if($query->num_rows())
            {
                $result = $query->row();
                return $result;
			} 
            else
            { 
				return false;
			}
		}
		
		public function getYoutubeLinkData($link)
        {
            $baseUrl='https://www.youtube.com/';
            $baseEmbedUrl='https://www.youtube.com/embed/';
            $baseWatchUrl='https://www.youtube.com/watch';
            $baseVideoUrl='https://youtu';
            
            $embedLinkArr=explode('embed/',$link);
            $watchLinkArr=explode('?v=',$link);
            $videoLinkArr=explode('.be/',$link);
            
            if($baseWatchUrl==$watchLinkArr[0])
            {
                $youtube_id=end($watchLinkArr);
			}
            else if($baseVideoUrl==$videoLinkArr[0])
            {
                $youtube_id=end($videoLinkArr);
			}
            else if($baseUrl==$embedLinkArr[0])
            {
                $youtube_id=end($embedLinkArr);
			}
            else
            {
                $youtube_id=0;
			}
            
            $embedUrl=$baseEmbedUrl.$youtube_id;
            $watchUrl=$baseWatchUrl.'?v='.$youtube_id;
            $videoUrl=$baseVideoUrl.'.be/'.$youtube_id;
            $thumbnailUrl='https://img.youtube.com/vi/'.$youtube_id.'/sddefault.jpg';
            
            $response= (object) ['baseUrl'=>$baseUrl,'id'=>$youtube_id,'embedUrl'=>$embedUrl,'watchUrl'=>$watchUrl,'videoUrl'=>$videoUrl,'thumbnailUrl'=>$thumbnailUrl];
            return $response;
		}
		
		
		public function checkEnrollments($userid)
        {
            $query = $this->db->where(['userid'=>$userid,'paymentstatus'=>'success'])->get('tbl_enroll');
            if($query->num_rows())
            {
                $result = $query->row();
                return 'Yes';
			} 
            else
            { 
				return 'No';
			}
		}
		
		public function educatorCourses($id)
        {
			$educatorCourses=[0];
            $query = $this->db->where(['author'=>$id])->get('tbl_course');
            
			$results=$query->result();
			foreach($results as $item)
			{
				array_push($educatorCourses,$item->id);
			}
			
			return $educatorCourses;
		}
		
		public function educatorEBooks($id)
        {
			$educatorEBooks=[0];
            $query = $this->db->where(['author'=>$id])->get('tbl_ebook');
            
			$results=$query->result();
			foreach($results as $item)
			{
				array_push($educatorEBooks,$item->id);
			}
			
			return $educatorEBooks;
		}
		
		public function educatorABooks($id)
        {
			$educatorABooks=[0];
            $query = $this->db->where(['author'=>$id])->get('tbl_abook');
            
			$results=$query->result();
			foreach($results as $item)
			{
				array_push($educatorABooks,$item->id);
			}
			
			return $educatorABooks;
		}
		
		public function getEducator($itemtype,$itemid)
        {
			$itemTypes=(object) ['Course'=>'tbl_course','Ebook'=>'tbl_ebook','Abook'=>'tbl_abook'];
            $query=$this->db->where('id',$itemid)->get($itemTypes->$itemtype);
			$results=$query->row();
			$authorData=$this->getData('tbl_tutor',$results->author?? 'Unknown');
			return $authorData;
		}
		
		public function studentsCourses($student_id)
        {
			$studentsCourses=[0];
            $query = $this->db->where(['userid'=>$student_id,'itemtype'=>'Course','paymentstatus'=>'success'])->get('tbl_enroll');
            
			$results=$query->result();
			foreach($results as $item)
			{
				array_push($studentsCourses,$item->itemid);
			}
			
			return $studentsCourses;
		}
		
		public function getRevenue($educator_id,$coupon)
        {
			if(empty($coupon))
			{
				$revenue=40;
			}
			else{
				$query=$this->db->where(['educator_id'=>$educator_id,'type'=>'Educator','coupon'=>$coupon])->get('tbl_offer');
				if($query->num_rows())
				{
					$revenue=60;
				}
				else
				{
					$revenue=40;
				}
			}
			
			return $revenue;
		}
		
// 		public function getRank($schedule_id,$student_id)
//         {
// 			$result=$this->db->query("SELECT score, FIND_IN_SET( score, ( SELECT GROUP_CONCAT( score ORDER BY score DESC ) FROM tbl_quiz_attended ) ) AS rank FROM tbl_quiz_attended WHERE schedule_id = '".$schedule_id."' AND student_id = '".$student_id."'");
// 			if($result->num_rows())
// 			{
// 				$values=$result->row();
// 				$rank=$values->rank;
// 			}
// 			else{ 
// 				$rank=0;
// 			}
// 			return $rank;
// 		} 

        public function getRank($schedule_id,$student_id)
        {
			$result=$this->db->query("SELECT * FROM tbl_quiz_attended WHERE schedule_id = '".$schedule_id."' ORDER BY `id` DESC");
			$scores=[0];
			if($result->num_rows())
			{
				foreach($result->result() as $item)
				{
					array_push($scores,$item->score);
				}
			}
			rsort($scores);
			
			$uResult=$this->db->query("SELECT * FROM tbl_quiz_attended WHERE schedule_id = '".$schedule_id."' AND `student_id`='".$student_id."' ORDER BY `id` DESC");
			$uData=$uResult->row();
			$score=$uData->score;
			$rank=array_search($score, $scores);
			
			return $rank+1;
		}
		
	}   
    
?>