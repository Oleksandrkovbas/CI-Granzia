<?php
	class Users extends MY_Controller {

		function __construct()
		{
			parent::__construct();
			$this->load->model('user_model', 'users');
			$this->load->library('image_lib');
			$this->load->library('upload');

			$this->title = 'Utenti';
			$this->list_title = 'User List';
			$this->view_title = 'User Details';
			$this->no_records = 'No record found.';
			$this->action_url = config_item('admin_url').'/users';
			$this->add_url = config_item('admin_url').'/users/insert';
			$this->edit_url = config_item('admin_url').'/users/edit';
			$this->manage_view = config_item('view_path').'/user_manage';
			$this->addedit_view = config_item('view_path').'/user_addedit';
			$this->redirect_url = config_item('admin_url').'/users/index';
			$this->model = 'users';

			//$this->output->enable_profiler(TRUE);
		}

		function index($id = '0')
		{
			$data['title'] = "Utenti";
			$data['js'] = array("common.js");

			$data['query'] = $this->users->ViewAll();

			$data['view'] = $this->manage_view;
			$this->load->view(config_item('view_path').'/main', $data);
		}

		function insert()
		{
			$data['title'] = "Utenti";
			$data['Action'] = "Add";
			$data['js'] = array("common.js");

			if ($this->input->post('submit'))
			{
				$rules = $this->users->add_rules;
				$this->form_validation->set_rules($rules);

				if ($this->form_validation->run() == true) {
					if($result = $this->users->Insert())
					{
						$this->session->set_flashdata('success_notification', 'Utente creato con successo.');
						redirect($this->redirect_url);
					}
				}
				else
				{
					$this->session->set_flashdata('error_notification', 'Duplicate username.');
					redirect($this->redirect_url);
				}
			}
			elseif ($this->input->post('cancel'))
			{
				redirect($this->redirect_url);
			}
			else
			{
				$data['view'] = $this->addedit_view;
				$this->load->view(config_item('view_path').'/main', $data);
			}
		}

		function edit()
		{
			$data['title'] = "Utenti";
			$data['Action'] = "Edit";
			$data['js'] = array("common.js");

			if ($this->input->post('submit'))
			{
				$rules = $this->users->edit_rules;
				$this->form_validation->set_rules($rules);

				if ($this->form_validation->run() == true) {
					if($result = $this->users->Update())
					{
						$this->session->set_flashdata('success_notification', 'Modifiche aggiornate correttamente.');
						redirect($this->redirect_url);
					}
				}
				else
				{
					$this->session->set_flashdata('error_notification', 'Duplicate username.');
					redirect($this->redirect_url);
				}
			}
			elseif ($this->input->post('cancel'))
			{
				redirect($this->redirect_url);
			}
			else
			{
				$data['entry'] = $this->users->GetInfoById($this->uri->segment(4));
				$data['view'] = $this->addedit_view;
				$this->load->view(config_item('view_path').'/main', $data);
			}
		}

		function delete()
		{
			if($result = $this->users->Delete())
			{
				$this->session->set_flashdata('success_notification', 'User information has been deleted successfully.');
				redirect($this->redirect_url);
			}
			else
			{
				$this->session->set_flashdata('error_notification', 'User information cannot be deleted.');
				redirect($this->redirect_url);
			}
		}

		function changestatus()
		{
			if($result = $this->users->ChangeStatus())
			{
				$this->session->set_flashdata('success_notification', 'User status has been changed successfully.');
				redirect($this->redirect_url);
			}
			else
			{
				$this->session->set_flashdata('error_notification', 'Status update failed.');
				redirect($this->redirect_url);
			}
		}
	}
?>
