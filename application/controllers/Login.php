<?php


// $2y$10$i83pEJuJ/uX6.eGJXkitX.pKy9BQ3KKpePKfGV2KgBYISCHBBB0WO
// testadmin
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Login extends User_Controller
{
    public function __construct()
    {
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
    }

    public function index()
    {
        $data['title'] = 'Login';
        $this->load->view('login', $data);
    }

    function dologin()
		{
  			if ($this->userlogin->loggedin())
  			{
  				redirect('dashboard','location');
  			}
  			else
  			{
  				if (!($this->input->post('submit') == 'submit'))
  				{
  					$data['title'] = "Login";
  					$this->load->view('login', $data);
  				}
  				else
  				{
            $rules = $this->userlogin->rules;
            $this->form_validation->set_rules($rules);

            if ($this->form_validation->run() == true) {
              $username = $this->input->post('user_name');
    					$password = $this->input->post('password');
             
    					if ($this->userlogin->login($username, $password))
    					{
                $this->session->set_flashdata('success_notification', 'Login Successful. Redirecting...');
    						redirect('dashboard','location');
    					}
    					else
    					{
    						$this->session->set_flashdata('error_notification', 'Username o Password errate. Riprova.');
    						redirect('login');
    					}
            }
            else {
                $this->session->set_flashdata('error_notification', 'Username o Password errate. Riprova.');
                redirect('login');
            }
  				}
  			}
		}

		function logout()
		{
			$this->userlogin->logout();
			redirect('login');
		}

    function forgotpassword()
    {
      if ($this->input->post('submit'))
      {
        //$_POST['user_email'] = 'info@untangled-life.com';
        $rsUser = $this->userlogin->IsValidUser($_POST['user_email']);

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
          redirect('login');
        }
        else
        {
          $this->session->set_flashdata('error_notification', 'User not found.');
          redirect('login');
        }
      }
    }    
}
