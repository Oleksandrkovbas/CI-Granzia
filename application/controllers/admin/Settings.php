<?php

	class Settings extends MY_Controller {

		function __construct()
		{
			parent::__construct();
			//$this->output->enable_profiler(TRUE);
		}

		function index()
		{
			$data['title'] = "Configurazione";

			$data['view'] = config_item('view_path')."/settings" ;
			$this->load->view(config_item('view_path').'/main', $data);
		}

		function update()
		{
			$data['title'] = "Configurazione";

			if ($this->input->post('submit') == "Update")
			{
				$settings_arr = array("reminder_days", "protect_pdf","editor_api_key");

				for($i=0; $i < count($settings_arr); $i++)
				{
					$this->db->where('config_name', $settings_arr[$i]);
					$dd = $this->db->get('web_config');

					if($dd->num_rows()){
						$settings_data = array('config_value' =>  $this->input->post($settings_arr[$i]));
						$this->db->where('config_name', $settings_arr[$i]);
						$this->db->update('web_config', $settings_data);
					}
					else
					{
						$settings_data = array('config_name' => $settings_arr[$i],'config_value' =>  $this->input->post($settings_arr[$i]));
						$this->db->insert('web_config', $settings_data);
					}
				}

				$this->session->set_flashdata('success_notification', 'Modifiche aggiornate correttamente.');
			}
			else {
				$this->session->set_flashdata('error_notification', 'Settings update failed.');
			}
			redirect(config_item('admin_url').'/settings');
		}
	}
?>