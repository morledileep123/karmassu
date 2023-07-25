<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['facebook_app_id']                = '550241922320226';
$config['facebook_app_secret']            = 'a27953450544438158355d1e5291d5e4';
$config['facebook_login_redirect_url']    =  'Home/login';
$config['facebook_logout_redirect_url']   =  'Home/flogout';
$config['facebook_login_type']            = 'web';
$config['facebook_permissions']           = array('email');
$config['facebook_graph_version']         = 'v7.0';
$config['facebook_auth_on_load']          = TRUE;

?>