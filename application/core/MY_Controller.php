<?php
    class MY_Controller extends CI_Controller 
    {
        function __construct()
        {
            parent::__construct();
            date_default_timezone_set("asia/kolkata");
            $this->data = (object) [
			'appName' => 'Karmasu',
            'appLink' => base_url(),
            'appEmail' => 'contact@karmasu.com',
            'appMobileNo' => '9129388891',
			'appAddress' => 'Lucknow,India',
			'copyrightName' => '#TeamDigiCoders',
			'copyrightLink' => 'https://digicoders.in/',
			'controller' => $this->router->fetch_class(),
			'method' => $this->router->fetch_method(),
			'timestamp' => date('Y-m-d H:i:s'),
			'date' => date("Y-m-d"),
			'time' => date("h:i:s A"),
			'day' => date("l"),
			'otp' => '1234',//rand(1000,9999),
			'password' => '123456789',//time(),
			'reference_no' =>'KARMASU'
            ];
			
			$this->data->title=preg_replace('/(?<!\ )[A-Z]/', ' $0', $this->data->controller);
			$this->data->subTitle=preg_replace('/(?<!\ )[A-Z]/', ' $0', $this->data->method);
		} 
	}
?>