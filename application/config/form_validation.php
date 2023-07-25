<?php
	$config = array(
	
	# Login 
	
	'login' => array(
	
	array(
	
	'field' => 'mobile',
	
	'label' => 'Mobile Number',
	
	'rules' => 'required|min_length[10]|max_length[10]|trim'
	
	)
	
	),
	
	# New Login 
	
	'newlogin' => array(
	
	array(
	
	'field' => 'mobile',
	
	'label' => 'Mobile Number',
	
	'rules' => 'required|min_length[10]|max_length[10]|trim'
	
	),
	array(
	
	'field' => 'password',
	
	'label' => 'Password',
	
	'rules' => 'required|trim'
	
	)
	
	),
	
	# Reset Password 
	
	'resetpassword' => array(
	
	array(
	
	'field' => 'mobile',
	
	'label' => 'Mobile Number',
	
	'rules' => 'required|min_length[10]|max_length[10]|trim'
	
	),
	array(
	
	'field' => 'newpassword',
	
	'label' => 'Password',
	
	'rules' => 'required|trim'
	
	),
	array(
	
	'field' => 'fp_token',
	
	'label' => 'Token',
	
	'rules' => 'required|trim'
	
	)
	
	
	),
	
	# Registration 
	
	'newregistration' => array(
	
	array(
	
	'field' => 'name',
	
	'label' => 'Name',
	
	'rules' => 'required|trim'
	
	),
	array(
	
	'field' => 'email',
	
	'label' => 'Email ID',
	
	'rules' => 'required|valid_email|trim'
	
	),
	array(
	
	'field' => 'mobile',
	
	'label' => 'Mobile Number',
	
	'rules' => 'required|min_length[10]|max_length[10]|trim'
	
	),
	array(
	
	'field' => 'password',
	
	'label' => 'Password',
	
	'rules' => 'required|trim'
	
	)
	
	),
	
	# OTP Verification
	
	'otp_verification' => array(
	
	array(
	
	'field' => 'mobile',
	
	'label' => 'Mobile Number',
	
	'rules' => 'required|min_length[10]|max_length[10]|trim'
	
	),
	array(
	
	'field' => 'otp',
	
	'label' => 'OTP',
	
	'rules' => 'required|min_length[4]|max_length[4]|trim'
	
	)
	
	),
	
	#Profile
	
	
	'profile' => array(
	
	array(
	
	'field' => 'userid',
	
	'label' => 'User ID',
	
	'rules' => 'required|trim'
	
	)
	
	),
	
	# Update Profile
	
	'updateProfile' => array(
	array(
	'field' => 'userid',
	'label' => 'User ID',
	'rules' => 'required|trim'
	),
	array(
	'field' => 'name',
	'label' => 'Name',
	'rules' => 'required|trim'
	),
	array(
	'field' => 'email',
	'label' => 'Email ID',
	'rules' => 'required|valid_email|trim'
	),
	array(
	'field' => 'education',
	'label' => 'Education',
	'rules' => 'required|trim'
	),
	array(
	'field' => 'address',
	'label' => 'Address',
	'rules' => 'required|trim'
	)
	),
	
	# Category 
	
	'category' => array(
	array(
	'field' => 'categoryid',
	
	'label' => 'Category ID',
	
	'rules' => 'required|trim'
	)
	),
	
	
	# educator 
	
	'educator' => array(
	array(
	'field' => 'educatorid',
	
	'label' => 'Educator ID',
	
	'rules' => 'required|trim'
	)
	),
	
	
	# Course 
	
	'course' => array(
	array(
	'field' => 'courseid',
	
	'label' => 'Course ID',
	
	'rules' => 'required|trim'
	)
	),
	
	#enrolledCourse
	
	'enrolledCourse' => array(
	array(
	'field' => 'courseid',
	
	'label' => 'Course ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'userid',
	
	'label' => 'User ID',
	
	'rules' => 'required|trim'
	)
	),
	
	#enrolledEbook
	
	'enrolledEbook' => array(
	array(
	'field' => 'ebookid',
	
	'label' => 'Ebook ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'userid',
	
	'label' => 'User ID',
	
	'rules' => 'required|trim'
	)
	),
	
	# videoPlaylist
	'videoPlaylist' => array(
	array(
	'field' => 'courseid',
	
	'label' => 'Course ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'userid',
	
	'label' => 'User ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'videoid',
	
	'label' => 'Video ID',
	
	'rules' => 'required|trim'
	)
	),
	
	# upload Assignment
	
	'uploadAssignment' => array(
	array(
	'field' => 'courseid',
	
	'label' => 'Course ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'videoid',
	
	'label' => 'Video ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'userid',
	
	'label' => 'User ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'assignmentid',
	
	'label' => 'Assignment ID',
	
	'rules' => 'required|trim'
	)
	),
	
	# video Question
	
	'videoQuestion' => array(
	array(
	'field' => 'courseid',
	
	'label' => 'Course ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'videoid',
	
	'label' => 'Video ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'userid',
	
	'label' => 'User ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'message',
	
	'label' => 'Message',
	
	'rules' => 'required|trim'
	)
	),
	
	'liveQuestion' => array(
	array(
	'field' => 'liveid',
	
	'label' => 'Live ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'userid',
	
	'label' => 'User ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'message',
	
	'label' => 'Message',
	
	'rules' => 'required|trim'
	)
	),
	
	'videoReply' => array(
	array(
	'field' => 'courseid',
	
	'label' => 'Course ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'videoid',
	
	'label' => 'Video ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'userid',
	
	'label' => 'User ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'usertype',
	
	'label' => 'User Type',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'questionid',
	
	'label' => 'Question ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'message',
	
	'label' => 'Message',
	
	'rules' => 'required|trim'
	)
	),
	
	
	'liveReply' => array(
	array(
	'field' => 'liveid',
	
	'label' => 'Live ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'userid',
	
	'label' => 'User ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'usertype',
	
	'label' => 'User Type',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'questionid',
	
	'label' => 'Question ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'message',
	
	'label' => 'Message',
	
	'rules' => 'required|trim'
	)
	),
	# Coupon 
	
	'coupon' => array(
	array(
	'field' => 'couponcode',
	
	'label' => 'Coupon Code',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'userid',
	
	'label' => 'User ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'itemtype',
	
	'label' => 'Item Type',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'itemid',
	
	'label' => 'Item ID',
	
	'rules' => 'required|trim'
	)
	),
	
	# Enroll Course
	
	'enrollcourse' => array(
	array(
	'field' => 'userid',
	'label' => 'User ID',
	'rules' => 'required|trim'
	),
	array(
	'field' => 'mobile',
	'label' => 'Mobile Number',
	'rules' => 'required|min_length[10]|max_length[10]|trim'
	),
	array(
	'field' => 'firstname',
	'label' => 'First Name',
	'rules' => 'required|trim'
	),
	array(
	'field' => 'lastname',
	'label' => 'Last Name',
	'rules' => 'required|trim'
	),
	array(
	'field' => 'emailid',
	'label' => 'Email ID',
	'rules' => 'required|trim'
	),
// 	array(
// 	'field' => 'qualification',
// 	'label' => 'Highest Qualification',
// 	'rules' => 'required|trim'
// 	),
	array(
	'field' => 'courseid',
	'label' => 'Course ID',
	'rules' => 'required|trim'
	),
	array(
	'field' => 'price',
	'label' => 'Price',
	'rules' => 'required|trim'
	)
	),
	
	# Payment Status Update 
	
	'paymentstatus' => array(
	array(
	'field' => 'orderid',
	
	'label' => 'Order ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'mobile',
	
	'label' => 'Mobile Number',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'status',
	
	'label' => 'Payment Status',
	
	'rules' => 'required|trim'
	)
	),
	'freepaymentstatus' => array(
	array(
	'field' => 'orderid',
	
	'label' => 'Order ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'mobile',
	
	'label' => 'Mobile Number',
	
	'rules' => 'required|trim'
	),
	),
	# Wishlist
	'addWishlist' => array(
	array(
	'field' => 'userid',
	
	'label' => 'User ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'itemid',
	
	'label' => 'Item ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'itemtype',
	
	'label' => 'Item Type',
	
	'rules' => 'required|trim'
	)
	),
	
	'listWishlist' => array(
	array(
	'field' => 'userid',
	
	'label' => 'User ID',
	
	'rules' => 'required|trim'
	)
	),
	'removeWishlist' => array(
	array(
	'field' => 'id',
	
	'label' => 'Wishlist ID',
	
	'rules' => 'required|trim'
	)
	),
	'ebookFullDetails' => array(
	array(
	'field' => 'ebookid',
	
	'label' => 'Ebook ID',
	
	'rules' => 'required|trim'
	)
	),
	'abookFullDetails' => array(
	array(
	'field' => 'abookid',
	
	'label' => 'Abook ID',
	
	'rules' => 'required|trim'
	)
	),
	
	'myItem' => array(
	array(
	'field' => 'userid',
	
	'label' => 'User ID',
	
	'rules' => 'required|trim'
	)
	),
	'review' => array(
	array(
	'field' => 'userid',
	
	'label' => 'User ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'itemid',
	
	'label' => 'Item ID',
	
	'rules' => 'required|trim'
	),
	array(	
	'field' => 'itemtype',
	
	'label' => 'Item Type',
	
	'rules' => 'required|trim'
	),
	array(	
	'field' => 'rating',
	
	'label' => 'Rating',
	
	'rules' => 'required|trim'
	),
	array(	
	'field' => 'review',
	
	'label' => 'Review',
	
	'rules' => 'required|trim'
	)
	
	),
	
	'token' => array(
	array(
	'field' => 'token',
	
	'label' => 'Token',
	
	'rules' => 'required|trim'
	)
	),
	
	
	'orderHistory' => array(
	array(
	'field' => 'userid',
	
	'label' => 'User ID',
	
	'rules' => 'required|trim'
	)
	),
	
	'liveJoin' => array(
	array(
	'field' => 'liveid',
	'label' => 'Live ID',
	'rules' => 'required|trim'
	),
	array(
	'field' => 'userid',
	'label' => 'User ID',
	'rules' => 'required|trim'
	),
	array(
	'field' => 'name',
	'label' => 'Name',
	'rules' => 'required|trim'
	),
	array(
	'field' => 'mobile',
	'label' => 'Mobile Number',
	'rules' => 'required|min_length[10]|max_length[10]|trim'
	),
	
	array(
	'field' => 'email',
	'label' => 'Email',
	'rules' => 'required|valid_email|trim'
	)
	),
	
	'MarkAsCompleted' => array(
	array(
	'field' => 'enrollid',
	
	'label' => 'Enroll ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'videoid',
	
	'label' => 'Video ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'userid',
	
	'label' => 'User ID',
	
	'rules' => 'required|trim'
	)
	),
	
	'certificate' => array(
	array(
	'field' => 'userid',
	
	'label' => 'User ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'enrollid',
	
	'label' => 'Enroll ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'name',
	
	'label' => 'Name',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'mobile',
	
	'label' => 'Mobile No',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'email',
	
	'label' => 'Email',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'issuedon',
	
	'label' => 'Issue Date',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'grade',
	
	'label' => 'Grade',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'duration',
	
	'label' => 'Duration',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'from_date',
	
	'label' => 'From Date',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'to_date',
	
	'label' => 'To Date',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'itemid',
	
	'label' => 'Item ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'itemtype',
	
	'label' => 'Item Type',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'status',
	
	'label' => 'Status',
	
	'rules' => 'required|trim'
	)
	),
	
	'RequestCertificate' => array(
	array(
	'field' => 'enrollid',
	
	'label' => 'Enroll ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'userid',
	
	'label' => 'User ID',
	
	'rules' => 'required|trim'
	)
	), 
	
	'CalculateCharge' => array(
	array(
	'field' => 'userid',
	
	'label' => 'User ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'itemtype',
	
	'label' => 'Item Type',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'itemid',
	
	'label' => 'Item ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'pincode',
	
	'label' => 'Pincode',
	
	'rules' => 'required|min_length[6]|max_length[6]|trim'
	)
	),
	'CertificateOrderCreate' => array(
	array(
	'field' => 'userid',
	
	'label' => 'User ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'refno',
	
	'label' => 'Reference No',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'name',
	
	'label' => 'Name',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'mobile',
	
	'label' => 'Mobile',
	
	'rules' => 'required|min_length[10]|max_length[10]|trim'
	),
	array(
	'field' => 'email',
	
	'label' => 'Email',
	
	'rules' => 'required|valid_email|trim'
	),
	array(
	'field' => 'address',
	
	'label' => 'Address',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'pincode',
	
	'label' => 'Pincode',
	
	'rules' => 'required|min_length[6]|max_length[6]|trim'
	),
	array(
	'field' => 'state',
	
	'label' => 'State',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'country',
	
	'label' => 'Country',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'latitude',
	
	'label' => 'Latitude',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'longitude',
	
	'label' => 'Longitude',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'distance',
	
	'label' => 'Distance',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'certificate_charge',
	
	'label' => 'Certificate Charge',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'km_charge',
	
	'label' => 'Per KM Charge',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'amount',
	
	'label' => 'Amount',
	
	'rules' => 'required|trim'
	)
	),
	'CertificateOrderUpdateStatus' => array(
	array(
	'field' => 'userid',
	
	'label' => 'User ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'orderid',
	
	'label' => 'Order ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'status',
	
	'label' => 'Payment Status',
	
	'rules' => 'required|trim'
	)
	),
	'CertificateOrderHistory' => array(
	array(
	'field' => 'userid',
	
	'label' => 'User ID',
	
	'rules' => 'required|trim'
	),
	array(
	'field' => 'refno',
	
	'label' => 'Reference No',
	
	'rules' => 'required|trim'
	)
	),
	'educatorlogin' => array(
	array(
	'field' => 'username',
	'label' => 'Username',
	'rules' => 'required|trim'
	),
	array(
	'field' => 'password',
	'label' => 'Password',
	'rules' => 'required|trim'
	)
	),
	
	/* Home and Student */
	
	'adminlogin' => array(
	array(
	'field' => 'username',
	'label' => 'Email ID',
	'rules' => 'required|valid_email|trim'
	),
	array(
	'field' => 'password',
	'label' => 'Password',
	'rules' => 'required|trim'
	)
	),
	'Questions' => array(
	array(
	'field' => 'subject_id',
	'label' => 'Subject',
	'rules' => 'required|trim'
	),
	array(
	'field' => 'question',
	'label' => 'Question',
	'rules' => 'required|trim'
	),
	// array(
	// 'field' => 'a',
	// 'label' => 'Option A',
	// 'rules' => 'required|trim'
	// ),
	// array(
	// 'field' => 'b',
	// 'label' => 'Option B',
	// 'rules' => 'required|trim'
	// ),
	// array(
	// 'field' => 'c',
	// 'label' => 'Option C',
	// 'rules' => 'required|trim'
	// ),
	// array(
	// 'field' => 'd',
	// 'label' => 'Option D',
	// 'rules' => 'required|trim'
	// ),
	array(
	'field' => 'answer',
	'label' => 'answer',
	'rules' => 'required|trim'
	)
	),
	'Quiz' => array(
	array(
	'field' => 'name',
	'label' => 'Quiz Name',
	'rules' => 'required|trim'
	),
	array(
	'field' => 'per_question_no',
	'label' => 'Per Question Marks',
	'rules' => 'required|trim'
	),
	array(
	'field' => 'timing',
	'label' => 'Quiz Timing (In Minutes)',
	'rules' => 'required|trim'
	),
	array(
	'field' => 'description',
	'label' => 'Description',
	'rules' => 'required|trim'
	)
	),
	'OTPVerification' => array(
	
	array(
	
	'field' => 'otp',
	
	'label' => 'OTP',
	
	'rules' => 'required|min_length[4]|max_length[4]|trim'
	
	)
	
	),
	'EducatorRegistration' => array(
	
	array(
	
	'field' => 'name',
	
	'label' => 'Name',
	
	'rules' => 'required|trim'
	
	),
	array(
	
	'field' => 'email',
	
	'label' => 'Email ID',
	
	'rules' => 'required|valid_email|trim'
	
	),
	array(
	
	'field' => 'mobile',
	
	'label' => 'Mobile Number',
	
	'rules' => 'required|min_length[10]|max_length[10]|trim'
	
	),
	array(
	
	'field' => 'password',
	
	'label' => 'Password',
	
	'rules' => 'required|trim'
	
	),
	array(
	
	'field' => 'about',
	
	'label' => 'About',
	
	'rules' => 'required|trim'
	
	),
	
	)
	
	
);