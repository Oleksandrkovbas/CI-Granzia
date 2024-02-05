<?php

	class Printconfig extends MY_Controller {

		function __construct()
		{
			parent::__construct();
			$this->load->model('Print_model', 'print');

			$this->parameters = [
				'p_surety_no' => 'Atto di Fidejussione N°',
				'contractor_name_1' => 'Denominazione Contraente [1 Contraente]',
				'contractor_addr_1' => 'Indirizzo Contraente [1 Contraente]',
				'contractor_vat_1' => 'P.IVA Contraente [1 Contraente]',
				'contractor_name_2' => 'Denominazione Contraente [2 Contraente]',
				'contractor_addr_2' => 'Indirizzo Contraente [2 Contraente]',
				'contractor_vat_2' => 'P.IVA Contraente [2 Contraente]',
				'contractor_name_3' => 'Denominazione Contraente [3 Contraente]',
				'contractor_addr_3' => 'Indirizzo Contraente [3 Contraente]',
				'contractor_vat_3' => 'P.IVA Contraente [3 Contraente]',
				'contractor_name_4' => 'Denominazione Contraente [4 Contraente]',
				'contractor_addr_4' => 'Indirizzo Contraente [4 Contraente]',
				'contractor_vat_4' => 'P.IVA Contraente [4 Contraente]',
				'beneficiary_name_1' => 'Denominazione Beneficiario [1 Beneficiario]',
				'beneficiary_addr_1' => 'Indirizzo Beneficiario [1 Beneficiario]',
				'beneficiary_vat_1' => 'P.IVA Beneficiario [1 Beneficiario]',
				'beneficiary_name_2' => 'Denominazione Beneficiario [2 Beneficiario]',
				'beneficiary_addr_2' => 'Indirizzo Beneficiario [2 Beneficiario]',
				'beneficiary_vat_2' => 'P.IVA Beneficiario [2 Beneficiario]',
				'beneficiary_name_3' => 'Denominazione Beneficiario [3 Beneficiario]',
				'beneficiary_addr_3' => 'Indirizzo Beneficiario [3 Beneficiario]',
				'beneficiary_vat_3' => 'P.IVA Beneficiario [3 Beneficiario]',
				'beneficiary_name_4' => 'Denominazione Beneficiario [4 Beneficiario]',
				'beneficiary_addr_4' => 'Indirizzo Beneficiario [4 Beneficiario]',
				'beneficiary_vat_4' => 'P.IVA Beneficiario [4 Beneficiario]',
				'p_surety_object' => 'A Garanzia: Oggetto della Fidejussione',
				'guaranteed_amount_details' => 'Importo garantito',
				'from_date' => 'Durata dal',
				'to_date' => 'al',
				'release_date' => 'Emessa il',
				'receipt_amount_details' => 'Per quietanza',
			];

			//$this->output->enable_profiler(TRUE);
		}

		function index()
		{
			$data['title'] = "Modello Stampa";

			$data['params'] = $this->parameters;

			$data['view'] = config_item('view_path')."/printconfig" ;
			$this->load->view(config_item('view_path').'/main', $data);
		}

		function update()
		{
			$data['title'] = "Modello Stampa";

			if ($this->input->post('submit') == "Update")
			{
				$settings_arr = array("reminder_days");

				$i = 0;
				
				foreach($this->parameters as $key => $val)
				{
					$print_data = array(
						'font_size' =>  $_POST['font_size'][$i],
						'font_type' =>  $_POST['font_type'][$i],
						'width' =>  $_POST['width'][$i],
						'x_coordinate' =>  $_POST['x_coordinate'][$i],
						'y_coordinate' =>  $_POST['y_coordinate'][$i],
					);
					
					$this->db->where('parameter', $key);
					$this->db->update('print_config', $print_data);

					$i++;
				}

				$this->session->set_flashdata('success_notification', 'Modello stampa agguirnato.');
			}
			else {
				$this->session->set_flashdata('error_notification', 'Print config could not be updated.');
			}

			redirect(config_item('admin_url').'/printconfig');
		}
	}
?>