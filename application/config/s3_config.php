<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['s3_access_key'] = 'AKIATUN7JQ3WAP2YJAG6';
$config['s3_secret_key'] = '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';
$config['s3_region'] = 'ap-south-1';

require_once APPPATH . 'third_party\aws-sdk\aws-autoloader.php';
use Aws\S3\S3Client;

$client = S3Client::factory(array(
    'credentials' => array(
        'key'    => $config['s3_access_key'],
        'secret' => $config['s3_secret_key'],
    ),
    'region' => $config['s3_region'],
    'version' => 'latest',
    'signatureVersion' => 'v4'
));

