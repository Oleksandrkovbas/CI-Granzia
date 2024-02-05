<?php

	class Profile extends User_Controller {

		function __construct()
		{
			parent::__construct();
			$this->load->model('User_model', 'user');
			$this->load->model('Dashboard_model', 'dashboard');
			$this->load->library('image_lib');
			$this->load->library('upload');
			//$this->output->enable_profiler(TRUE);
		}

		function index()
		{
			$data['title'] = "Profilo Utente";

			$data['user'] = $this->user->GetInfoById($this->session->userdata('id'));

			$data['view'] = "profile" ;
			$this->load->view('main', $data);
		}

		function edit()
		{
			$data['title'] = "Modifica Profilo Utente";

			if ($this->input->post('submit') == "Update")
			{
				if($result = $this->user->UpdateProfile())
				{
					$this->session->set_flashdata('success_notification', 'Modifiche aggiornate correttamente.');
				}
				else
				{
					$this->session->set_flashdata('error_notification', 'Profile information can\'t be updated.');
				}
				redirect('profile');
			}

			$data['user'] = $this->user->GetInfoById($this->session->userdata('id'));
			$data['view'] = "edit_profile" ;
			$this->load->view('main', $data);
		}
	}
?>