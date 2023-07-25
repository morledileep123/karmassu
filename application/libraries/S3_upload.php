<?php
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class S3_upload
{
    private $ci;
    private $s3;

    public function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->config('s3_config');

        // Set up S3 client
        $this->s3 = new S3Client([
            'version' => 'latest',
            'region' => $this->ci->config->item('s3_region'),
            'credentials' => [
                'key' => $this->ci->config->item('s3_access_key'),
                'secret' => $this->ci->config->item('s3_secret_key'),
            ],
        ]);
    }

    public function upload($file, $bucket, $destination)
    {
    //    echo "<pre>"; 
    //    print_r($file);
    //    $filename = time().$destination;
        try {
            // Upload the file to S3
            //echo file_get_contents($file['tmp_name']);die;
           // echo file_get_contents($file['tmp_name']);die;

            $result = $this->s3->putObject([
                'Bucket' => $bucket,
                'Body'   => file_get_contents($file['tmp_name']),
                'Key' => 'ebook/'.$destination,
                'ContentType'=>'application/pdf',
                'ACL' => 'public-read',
            ]);
            //  print_r($result);die;
            // Return the URL of the uploaded file
            return $result['ObjectURL'];
        } catch (S3Exception $e) {
            // Handle the exception
            return false;
        }
    }
}