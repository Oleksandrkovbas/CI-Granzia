<?php

	class Profile extends MY_Controller {

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
			$data['title'] = "Modifica Profilo Admin";

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
				
				redirect(config_item('admin_url').'/profile');
			}

			$data['user'] = $this->user->GetInfoById($this->session->userdata('id'));
			$data['view'] = config_item('view_path')."/edit_profile" ;
			$this->load->view(config_item('view_path').'/main', $data);
		}
	}
?>