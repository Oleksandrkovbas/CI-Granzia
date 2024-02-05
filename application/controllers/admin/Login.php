<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Login extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
    }

    public function index()
    {
        $data['title'] = 'Admin Login';
        $this->load->view(config_item('view_path').'/login', $data);
    }

    function dologin()
		{
  			if ($this->login_model->loggedin())
  			{
  				redirect(config_item('admin_url').'/dashboard','location');
  			}
  			else
  			{
  				if (!($this->input->post('submit') == 'submit'))
  				{
  					$data['title'] = "Admin Login";
  					$this->load->view(config_item('view_path').'/login', $data);
  				}
  				else
  				{
            $rules = $this->login_model->rules;
            $this->form_validation->set_rules($rules);

            if ($this->form_validation->run() == true) {
              $username = $this->input->post('user_name');
    					$password = $this->input->post('password');

    					if ($this->login_model->login($username, $password))
    					{
                $this->session->set_flashdata('success_notification', 'Login Successful. Redirecting...');
    						redirect(config_item('admin_url').'/dashboard','location');
    					}
    					else
    					{
    						$this->session->set_flashdata('error_notification', 'Username o Password errate. Riprova.');
    						redirect(config_item('admin_url').'/login');
    					}
            }
            else {
                $this->session->set_flashdata('error_notification', 'Username o Password errate. Riprova.');
                redirect(config_item('admin_url').'/login');
            }
  				}
  			}
		}

		function logout()
		{
			$this->login_model->logout();
			redirect(config_item('admin_url').'/login');
		}

    function forgotpassword()
    {
      if ($this->input->post('submit'))
      {
        //$_POST['user_email'] = 'info@untangled-life.com';
        $rsUser = $this->login_model->IsValidUser($_POST['user_email']);

        if($rsUser)
        {
          $this->load->library('email');
          $this->email->set_newline("\r\n");

          $config['protocol'] = 'mail';
          $config['wordwrap'] = FALSE;
          $config['mailtype'] = 'html';
          $config['charset'] = 'utf-8';
          $config['crlf'] = "\r\n";
          $config['newline'] = "\r\n";

          $this->email->initialize($config);

          $data['name'] = $rsUser['user_name'];
          $data['password'] = $this->functions->GenerateRandomString();
//$data['password'] = 'Gestionale#123';
          $upd_rec = array(
              'user_password'   => password_hash($data['password'].config_item('encryption_key'), PASSWORD_DEFAULT),
          );
          $this->db->where('user_email', $_POST['user_email']);
          $this->db->update('users', $upd_rec);
//print_r($data); die;
          // compose message to send
          $emailbody = $this->load->view("email/forgotpassword", $data, true);
          //print $emailbody;die;

          $this->email->from($this->system->company_email, $this->system->site_name);
          $this->email->to($rsUser['user_email']);
          $this->email->subject('Reset Password'.' - '.$this->system->site_name);
          $this->email->message($emailbody);
          $this->email->send();

          $this->session->set_flashdata('success_notification', 'Email with reset password has been sent.');
          redirect(config_item('admin_url').'/login');
        }
        else
        {
          $this->session->set_flashdata('error_notification', 'User not found.');
          redirect(config_item('admin_url').'/login');
        }
      }
    }    
}
