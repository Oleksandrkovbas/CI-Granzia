<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MY_Controller extends CI_Controller
{
    public $asset = array(
      'SD_YesNo'    => array('Yes' 	=> 'Yes', 'No' 	=> 'No'),
      'SD_YesNoInt'    => array('Yes' 	=> '1', 'No' 	=> '0'),
      'SD_Active'   => array('Active'	=> '1', 'Inactive'	=> '0'),
      'SD_Status'   => array('0'   => 'Bozza', '1'  => 'Emessa'),
      'SD_Language'   => array('Italiano'   => 'it', 'English'  => 'uk'),
      'SD_LanguageFlag'   => array('it'   => '&#127470;&#127481;', 'uk'  => '&#127468;&#127463;'),
      'SD_FontType'  => array('N' => 'Normal', 'B' => 'Bold', 'I' => 'Italic','BI' => 'Bold Italic'),
    );

    public function __construct()
    {
        parent::__construct();

        $this->load->model('login_model');
        $this->load->model('practice_model', 'practice');
        $this->load->model('user_model', 'user');
        $this->load->library('form_validation');
        $this->load->helper('form');

        // Login check
        $exception_uris = array(
            config_item('admin_url').'/login',
            config_item('admin_url').'/login/dologin',
            config_item('admin_url').'/login/logout',
            config_item('admin_url').'/login/forgotpassword',
        );

        $ajax_exeception_uris = [];

        if ((in_array(uri_string(), $exception_uris) == false) && (in_array(uri_string(), $ajax_exeception_uris) == false)) {
            if ($this->login_model->loggedin() == false) {
                redirect(config_item('admin_url').'/login');
            }
        }
    }
}

class User_Controller extends CI_Controller
{
    public $asset = array(
      'SD_YesNo'    => array('Yes'  => 'Yes', 'No'  => 'No'),
      'SD_YesNoInt'    => array('Yes'   => '1', 'No'    => '0'),
      'SD_Active'   => array('Active'   => '1', 'Inactive'  => '0'),
      'SD_Status'   => array('0'   => 'Bozza', '1'  => 'Emessa'),
      'SD_Language'   => array('Italiano'   => 'it', 'English'  => 'uk'),
      'SD_LanguageFlag'   => array('it'   => '&#127470;&#127481;', 'uk'  => '&#127468;&#127463;'),
    );

    public function __construct()
    {
        parent::__construct();

        $this->load->model('UserLogin_model', 'userlogin');
        $this->load->model('practice_model', 'practice');
        $this->load->library('form_validation');
        $this->load->helper('form');

        // Login check
        $exception_uris = array(
            'login',
            'login/dologin',
            'login/logout',
            'login/forgotpassword',
        );

        $ajax_exeception_uris = [];

        if ((in_array(uri_string(), $exception_uris) == false) && (in_array(uri_string(), $ajax_exeception_uris) == false)) {
            if ($this->userlogin->loggedin() == false) {
                redirect('login');
            }
        }
    }
}