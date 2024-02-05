<?php
	class Practices extends MY_Controller {

		function __construct()
		{
			parent::__construct();
			$this->load->model('Practice_model', 'practice');
			$this->load->model('User_model', 'user');
			$this->load->library('pdf');
			//$this->output->enable_profiler(TRUE);

			$this->title = 'Pratiche';
			$this->list_title = 'Practice List';
			$this->view_title = 'Practice Details';
			$this->no_records = 'No record found.';
			$this->action_url = config_item('admin_url').'/practices';
			$this->add_url = config_item('admin_url').'/practices/insert';
			$this->edit_url = config_item('admin_url').'/practices/edit';
			$this->manage_view = config_item('view_path').'/practice_manage';
			$this->addedit_view = config_item('view_path').'/practice_addedit';
			$this->view_view = config_item('view_path').'/practice_view';
			$this->redirect_url = config_item('admin_url').'/practices/index';
			$this->model = 'practice';
			$this->insert_msg = 'Record inserted successfully.';
			$this->update_msg = 'Record updated successfully.';
			$this->delete_msg = 'Record deleted successfully.';
			$this->status_msg = 'Record status updated successfully.';
			$this->insert_error_msg = 'Insert failed. Please try again.';
			$this->update_error_msg = 'Update failed. Please try again.';
			$this->delete_error_msg = 'Delete failed. Please try again.';
			$this->status_error_msg = 'Status update failed. Please try again.';
		}

		function index($id = '0')
		{
			$data['title'] = $this->title;
			$data['js'] = array("common.js");

			$data['query'] = $this->{$this->model}->ViewAll();

			$data['view'] = $this->manage_view;
			$this->load->view(config_item('view_path').'/main', $data);
		}

		function insert()
		{
			$data['title'] = $this->title;
			$data['Action'] = "Add";
			$data['js'] = array("common.js");

			if ($this->input->post('submit'))
			{
				$rules = $this->{$this->model}->rules;
				$this->form_validation->set_rules($rules);

				if ($this->form_validation->run() == true) {
					if($result = $this->{$this->model}->Insert())
					{
						if($this->input->post('submit') == 'Draft')
							$this->session->set_flashdata('success_notification', 'Bozza creata correttamente.');
						else
							$this->session->set_flashdata('success_notification', 'Pratica creata con correttamente.');

						redirect($this->redirect_url);
					}
					else
					{
						$this->session->set_flashdata('error_notification', 'Numero pratica già esistente.');
						redirect($this->redirect_url);
					}
				}
				else
				{
					$this->session->set_flashdata('error_notification', $this->insert_error_msg);
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
			$data['title'] = $this->title;
			$data['Action'] = "Edit";
			$data['js'] = array("common.js");

			$rs = $this->{$this->model}->GetInfoById($this->uri->segment(4));

			if($rs['is_update_mode'] == 1 && $rs['is_update_mode_user'] != $this->session->userdata('id'))
			{
				$rsUpdateUser = $this->user->GetInfoById($rs['is_update_mode_user']);
				$update_user = $rsUpdateUser['user_firstname'].' '.$rsUpdateUser['user_lastname'];

				$this->session->set_flashdata('error_notification', "il file selizionato è già utilizzato dall'utente: ".$update_user." e non può essere aperto. Grazie.");
				redirect($this->redirect_url);
			}

			if ($this->input->post('submit'))
			{
				$rules = $this->{$this->model}->rules;
				$this->form_validation->set_rules($rules);

				if ($this->form_validation->run() == true) {
					if($result = $this->{$this->model}->Update())
					{
						$update_data = array(
							'is_update_mode' 						=>	'0',
							'is_update_mode_user' 			=>	'0',
						);

						$this->db->where('p_id', $this->input->post('pk_id'));
						$this->db->update('practices', $update_data);

						$this->session->set_flashdata('success_notification', 'Modifiche aggiornate correttamente.');
						redirect($this->redirect_url);
					}
					else
					{
						$this->session->set_flashdata('error_notification', 'Numero pratica già esistente.');
						redirect($this->redirect_url);
					}
				}
				else
				{
					$this->session->set_flashdata('error_notification', $this->update_error_msg);
					redirect($this->redirect_url);
				}
			}
			elseif ($this->input->post('cancel'))
			{
				$update_data = array(
					'is_update_mode' 						=>	'0',
					'is_update_mode_user' 			=>	'0',
				);

				$this->db->where('p_id', $this->input->post('pk_id'));
				$this->db->update('practices', $update_data);

				redirect($this->redirect_url);
			}
			else
			{
				$update_data = array(
					'is_update_mode' 						=>	'1',
					'is_update_mode_user' 			=>	$this->session->userdata('id'),
				);

				$this->db->where('p_id', $this->uri->segment(4));
				$this->db->update('practices', $update_data);

				$data['entry'] = $this->{$this->model}->GetInfoById($this->uri->segment(4));
				$data['contractors'] = $this->{$this->model}->GetContractors($this->uri->segment(4));
				$data['beneficiaries'] = $this->{$this->model}->GetBeneficiaries($this->uri->segment(4));
				$data['view'] = $this->addedit_view;
				$this->load->view(config_item('view_path').'/main', $data);
			}
		}

		function delete()
		{
			if($result = $this->{$this->model}->Delete())
			{
				$this->session->set_flashdata('success_notification', $this->delete_msg);
				redirect($this->redirect_url);
			}
			else
			{
				$this->session->set_flashdata('error_notification', $this->delete_error_msg);
				redirect($this->redirect_url);
			}
		}

		function view()
		{
			$data['title'] = $this->title;
			$data['Action'] = "View";
			$data['js'] = array("common.js");

			$data['entry'] = $this->{$this->model}->GetInfoById($this->uri->segment(4));
			$data['contractors'] = $this->{$this->model}->GetContractors($this->uri->segment(4));
			$data['beneficiaries'] = $this->{$this->model}->GetBeneficiaries($this->uri->segment(4));
			$data['view'] = $this->view_view;
			$this->load->view(config_item('view_path').'/main', $data);
		}

		function addbeneficiary($pid)
		{
			$data['rowno'] = $pid;
			echo $this->load->view(config_item('view_path').'/add-beneficiary-row', $data, true);
		}

		function addcontractor($pid)
		{
			$data['rowno'] = $pid;
			echo $this->load->view(config_item('view_path').'/add-contractor-row', $data, true);
		}

		function getcontractors()
		{
			$data['results'] = $this->{$this->model}->GetContractorsForSearch($_POST['search']);
			echo json_encode($data['results']);
		}

		function getbeneficiaries()
		{
			$data['results'] = $this->{$this->model}->GetBeneficiariesForSearch($_POST['search']);
			echo json_encode($data['results']);
		}

		// function download($pid)
		// {
		// 	$rsPractice = $this->{$this->model}->GetInfoById($pid);
		// 	$beneficiaries = $this->{$this->model}->GetBeneficiaries($pid);

		// 	$beneficiary_cnt = count($beneficiaries);

		// 	$m=0;
		// 	$beneficiary_name = '';
		// 	$beneficiary_addr = '';
		// 	$beneficiary_vat = '';

		// 	foreach($beneficiaries as $b)
		// 	{
    //     if($m == 0)
    //     {
    //       $beneficiary_name = $b['pb_beneficiary_name'];
    //       $beneficiary_addr = $b['pb_beneficiary_address'];
    //       $beneficiary_vat = $b['pb_beneficiary_vat_no'];
    //     }
    //     else
    //     {
    //       $beneficiary_name .= ' - '.$b['pb_beneficiary_name'];
    //       $beneficiary_addr .= ' - '.$b['pb_beneficiary_address'];
    //       $beneficiary_vat .= ' - '.$b['pb_beneficiary_vat_no'];
    //     }

    //     $m++;
		// 	}

		// 	$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
    // 	$pdf->setPrintHeader(false);
    
    // 	$pdf->startPageGroup();
    // 	$pdf->setPrintFooter(false);

    // 	$pdf->SetFontSize(9);

    // 	if($this->system->protect_pdf == 1)
    //   {
	  //     $pdf->SetProtection(array('modify', 'copy'), '', null, 0, null);
    //   }

    // 	$pdf->SetMargins(0, 0, 0, true);
    // 	$pdf->SetAutoPageBreak(false, 0);
    // 	$pdf->AddPage('P', 'A4');

    // 	if($rsPractice['p_language'] == 'it')
    //   {
    //     $img_file1 = 'https://gestionale.istitutoelveticodigaranzia.ch/uploads/resources/front-it.jpg';
    //     $img_file2 = 'https://gestionale.istitutoelveticodigaranzia.ch/uploads/resources/back-it.jpg';

    //     $pdf->Image($img_file1, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);

	  //     $pdf->SetFont('helvetica', 'BI', 12);
	  //     $pdf->SetTextColor(0, 0, 0);
	  //     $pdf->MultiCell(210, 10, ($rsPractice['p_surety_no']), '0', 'L', 0, 0, '129', '25.3', true);

	  //     $pdf->SetFont('helvetica', 'B', 8);
	  //     $pdf->MultiCell(210, 10, $rsPractice['p_contractor_name'], '0', 'C', 0, 0, '0', '42.3', true);

	  //     $pdf->SetFont('helvetica', 'B', 7.5);
	  //     $pdf->MultiCell(105, 10, $rsPractice['p_contractor_address'], '0', 'L', 0, 0, '28.5', '49.7', true);

	  //     $pdf->SetFont('helvetica', 'B', 8);
	  //     $pdf->MultiCell(105, 10, $rsPractice['p_contractor_vat_no'], '0', 'C', 0, 0, '100', '49.7', true);

	  //     if(count($beneficiaries) > 1)
	  //     {
		//       $pdf->SetFont('helvetica', 'B', 8);
		//       $pdf->MultiCell(210, 10, $beneficiary_name, '0', 'C', 0, 0, '0', '58', true);

		//       $pdf->SetFont('helvetica', 'B', 6);
		//       $pdf->MultiCell(105, 10, $beneficiary_addr, '0', 'L', 0, 0, '28.5', '65.6', true);

		//       $pdf->SetFont('helvetica', 'B', 6.7);
		//       $pdf->MultiCell(105, 10, $beneficiary_vat, '0', 'C', 0, 0, '100', '65.5', true);
	  //     }
	  //     else
	  //     {
		//       $pdf->SetFont('helvetica', 'B', 8);
		//       $pdf->MultiCell(210, 10, $beneficiary_name, '0', 'C', 0, 0, '0', '58', true);

		//       $pdf->SetFont('helvetica', 'B', 7.5);
		//       $pdf->MultiCell(105, 10, $beneficiary_addr, '0', 'L', 0, 0, '28.5', '65.3', true);

		//       $pdf->SetFont('helvetica', 'B', 8);
		//       $pdf->MultiCell(105, 10, $beneficiary_vat, '0', 'C', 0, 0, '100', '65.3', true);
	  //     }

	  //     $pdf->SetFont('helvetica', '', 6.7);
	  //     $pdf->writeHTMLCell(151, 210, '28.6', '74.5', $rsPractice['p_surety_object'], '0', '0', 0, true, '', true);

	  //     $pdf->SetFont('helvetica', 'B', 7.5);
	  //     $pdf->MultiCell(210, 10, $rsPractice['p_guaranteed_amount_currency'].' '.number_format($rsPractice['p_guaranteed_amount'], 2, ',', '.').' ('.$rsPractice['p_guaranteed_amount_words'].')', '0', 'L', 0, 0, '54', '149.2', true);

	  //     setlocale(LC_TIME, 'it_IT');
	  //     $from_date = strftime("%d %B %Y", strtotime($rsPractice['p_from_date']));
	  //     $to_date = strftime("%d %B %Y", strtotime($rsPractice['p_to_date']));
	  //     $release_date = strftime("%d %B %Y", strtotime($rsPractice['p_release_date']));

	  //     $pdf->SetFont('helvetica', 'B', 8);
	  //     $pdf->MultiCell(50, 10, $from_date, '0', 'L', 0, 0, '39', '154.9', true);
	  //     $pdf->MultiCell(50, 10, $to_date, '0', 'L', 0, 0, '77.8', '154.9', true);
	  //     $pdf->MultiCell(50, 10, $release_date, '0', 'L', 0, 0, '146.5', '154.9', true);

	  //     $pdf->SetFont('helvetica', 'B', 5.9);
	  //     $pdf->MultiCell(50, 10, $rsPractice['p_receipt_amount_currency'].' '.number_format($rsPractice['p_receipt_amount'], 2, ',', '.').' ('.$rsPractice['p_receipt_amount_words'].')', '0', 'L', 0, 0, '28.8', '221.4', true);
    //   }
    //   else
    //   {
    //   	$img_file1 = 'https://gestionale.istitutoelveticodigaranzia.ch/uploads/resources/front-en.jpg';
    //   	$img_file2 = 'https://gestionale.istitutoelveticodigaranzia.ch/uploads/resources/back-en.jpg';

    //   	$pdf->Image($img_file1, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);

	  //     $pdf->SetFont('helvetica', 'BI', 12);
	  //     $pdf->SetTextColor(0, 0, 0);
	  //     $pdf->MultiCell(210, 10, ($rsPractice['p_surety_no']), '0', 'L', 0, 0, '129', '25.3', true);

	  //     $pdf->SetFont('helvetica', 'B', 8);
	  //     $pdf->MultiCell(210, 10, $rsPractice['p_contractor_name'], '0', 'C', 0, 0, '0', '42.3', true);

	  //     $pdf->SetFont('helvetica', 'B', 7.5);
	  //     $pdf->MultiCell(105, 10, $rsPractice['p_contractor_address'], '0', 'L', 0, 0, '28.5', '49.7', true);

	  //     $pdf->SetFont('helvetica', 'B', 8);
	  //     $pdf->MultiCell(105, 10, $rsPractice['p_contractor_vat_no'], '0', 'C', 0, 0, '100', '49.7', true);

	  //     if(count($beneficiaries) > 1)
	  //     {
		//       $pdf->SetFont('helvetica', 'B', 8);
		//       $pdf->MultiCell(210, 10, $beneficiary_name, '0', 'C', 0, 0, '0', '58', true);

		//       $pdf->SetFont('helvetica', 'B', 6);
		//       $pdf->MultiCell(105, 10, $beneficiary_addr, '0', 'L', 0, 0, '28.5', '65.6', true);

		//       $pdf->SetFont('helvetica', 'B', 6.7);
		//       $pdf->MultiCell(105, 10, $beneficiary_vat, '0', 'C', 0, 0, '100', '65.5', true);
	  //     }
	  //     else
	  //     {
		//       $pdf->SetFont('helvetica', 'B', 8);
		//       $pdf->MultiCell(210, 10, $beneficiary_name, '0', 'C', 0, 0, '0', '58', true);

		//       $pdf->SetFont('helvetica', 'B', 7.5);
		//       $pdf->MultiCell(105, 10, $beneficiary_addr, '0', 'L', 0, 0, '28.5', '65.3', true);

		//       $pdf->SetFont('helvetica', 'B', 8);
		//       $pdf->MultiCell(105, 10, $beneficiary_vat, '0', 'C', 0, 0, '100', '65.3', true);
	  //     }

	  //     $pdf->SetFont('helvetica', '', 6.7);
	  //     $pdf->writeHTMLCell(151, 210, '28.6', '74.5', $rsPractice['p_surety_object'], '0', '0', 0, true, '', true);

	  //     $pdf->SetFont('helvetica', 'B', 7.5);
	  //     $pdf->MultiCell(210, 10, $rsPractice['p_guaranteed_amount_currency'].' '.number_format($rsPractice['p_guaranteed_amount'], 2, ',', '.').' ('.$rsPractice['p_guaranteed_amount_words'].')', '0', 'L', 0, 0, '54.7', '149.2', true);

	  //     setlocale(LC_TIME, 'it_IT');
	  //     $from_date = strftime("%d %B %Y", strtotime($rsPractice['p_from_date']));
	  //     $to_date = strftime("%d %B %Y", strtotime($rsPractice['p_to_date']));
	  //     $release_date = strftime("%d %B %Y", strtotime($rsPractice['p_release_date']));

	  //     $pdf->SetFont('helvetica', 'B', 8);
	  //     $pdf->MultiCell(50, 10, $from_date, '0', 'L', 0, 0, '42.3', '154.9', true);
	  //     $pdf->MultiCell(50, 10, $to_date, '0', 'L', 0, 0, '78.3', '154.9', true);
	  //     $pdf->MultiCell(50, 10, $release_date, '0', 'L', 0, 0, '149.4', '154.9', true);

	  //     $pdf->SetFont('helvetica', 'B', 5.9);
	  //     $pdf->MultiCell(50, 10, $rsPractice['p_receipt_amount_currency'].' '.number_format($rsPractice['p_receipt_amount'], 2, ',', '.').' ('.$rsPractice['p_receipt_amount_words'].')', '0', 'L', 0, 0, '29.5', '221.4', true);
    //   }

    // 	$pdf->SetTextColor(0, 0, 0);

    // 	$pdf->setPageMark();

    // 	$pdf->SetMargins(0, 0, 0, true);
    // 	$pdf->SetAutoPageBreak(false, 0);
    // 	$pdf->AddPage('P', 'A4');

    // 	$pdf->Image($img_file2, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);

    // 	//$pdf->Output(FCPATH.'uploads'.'/drafts/Draft - '.$this->input->post('pk_id').'.pdf', 'F');
    // 	$pdf->Output('Bozza-'.$rsPractice['p_contractor_name'].'.pdf', 'D');
    // 	exit;
		// }

		// function download($pid)
		// {
		// 	$rsPractice = $this->{$this->model}->GetInfoById($pid);
		// 	$contractors = $this->{$this->model}->GetContractors($pid);
		// 	$beneficiaries = $this->{$this->model}->GetBeneficiaries($pid);

		// 	$contractor_cnt = count($contractors);

		// 	$m=0;
		// 	$contractor_name = '';
		// 	$contractor_addr = '';
		// 	$contractor_vat = '';

		// 	foreach($contractors as $b)
		// 	{
    //     if($m == 0)
    //     {
    //       $contractor_name = $b['pc_contractor_name'];
    //       $contractor_addr = $b['pc_contractor_address'];
    //       $contractor_vat = $b['pc_contractor_vat_no'];
    //     }
    //     else
    //     {
    //       $contractor_name .= ' - '.$b['pc_contractor_name'];
    //       $contractor_addr .= ' - '.$b['pc_contractor_address'];
    //       $contractor_vat .= ' - '.$b['pc_contractor_vat_no'];
    //     }

    //     $m++;
		// 	}

		// 	$beneficiary_cnt = count($beneficiaries);

		// 	$m=0;
		// 	$beneficiary_name = '';
		// 	$beneficiary_addr = '';
		// 	$beneficiary_vat = '';

		// 	foreach($beneficiaries as $b)
		// 	{
    //     if($m == 0)
    //     {
    //       $beneficiary_name = $b['pb_beneficiary_name'];
    //       $beneficiary_addr = $b['pb_beneficiary_address'];
    //       $beneficiary_vat = $b['pb_beneficiary_vat_no'];
    //     }
    //     else
    //     {
    //       $beneficiary_name .= ' - '.$b['pb_beneficiary_name'];
    //       $beneficiary_addr .= ' - '.$b['pb_beneficiary_address'];
    //       $beneficiary_vat .= ' - '.$b['pb_beneficiary_vat_no'];
    //     }

    //     $m++;
		// 	}

		// 	$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
    //   $pdf->setPrintHeader(false);
      
    //   $pdf->startPageGroup();
    //   $pdf->setPrintFooter(false);

    //   $pdf->SetFontSize(9);

    //   if($this->system->protect_pdf == 1)
    //   {
	  //     $pdf->SetProtection(array('modify', 'copy'), '', null, 0, null);
    //   }

    //   $pdf->SetMargins(0, 0, 0, true);
    //   $pdf->SetAutoPageBreak(false, 0);
    //   $pdf->AddPage('P', 'A4');

    //   if($rsPractice['p_language'] == 'it')
    //   {
    //     $img_file1 = 'https://gestionale.istitutoelveticodigaranzia.ch/uploads/resources/front-it.jpg';
    //     $img_file2 = 'https://gestionale.istitutoelveticodigaranzia.ch/uploads/resources/back-it.jpg';

    //     $pdf->Image($img_file1, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);

	  //     $pdf->SetFont('helvetica', 'BI', 12);
	  //     $pdf->SetTextColor(0, 0, 0);
	  //     $pdf->MultiCell(210, 10, ($rsPractice['p_surety_no']), '0', 'L', 0, 0, '129', '25.3', true);

	  //     $pdf->SetFont('helvetica', 'B', $rsPractice['p_contractor_name_font_size']);
	  //     $pdf->MultiCell(210, 10, $contractor_name, '0', 'C', 0, 0, '0', $rsPractice['p_contractor_name_y_coordinate'], true);

	  //     $pdf->SetFont('helvetica', 'B', $rsPractice['p_contractor_addr_font_size']);
	  //     $pdf->MultiCell(95, 10, $contractor_addr, '0', 'L', 0, 0, '28.5', $rsPractice['p_contractor_addr_y_coordinate'], true);

	  //     $pdf->SetFont('helvetica', 'B', $rsPractice['p_contractor_vat_font_size']);
	  //     $pdf->MultiCell(105, 10, $contractor_vat, '0', 'C', 0, 0, '97', $rsPractice['p_contractor_vat_y_coordinate'], true);

	  //     // if(count($beneficiaries) > 1)
	  //     // {
		//     //   $pdf->SetFont('helvetica', 'B', 8);
		//     //   $pdf->MultiCell(210, 10, $beneficiary_name, '0', 'C', 0, 0, '0', '58', true);

		//     //   $pdf->SetFont('helvetica', 'B', 6);
		//     //   $pdf->MultiCell(105, 10, $beneficiary_addr, '0', 'L', 0, 0, '28.5', '65.6', true);

		//     //   $pdf->SetFont('helvetica', 'B', 6.7);
		//     //   $pdf->MultiCell(105, 10, $beneficiary_vat, '0', 'C', 0, 0, '100', '65.5', true);
	  //     // }
	  //     // else
	  //     {
		//       $pdf->SetFont('helvetica', 'B', $rsPractice['p_beneficiary_name_font_size']);
		//       $pdf->MultiCell(210, 10, $beneficiary_name, '0', 'C', 0, 0, '0', $rsPractice['p_beneficiary_name_y_coordinate'], true);

		//       $pdf->SetFont('helvetica', 'B', $rsPractice['p_beneficiary_addr_font_size']);
		//       $pdf->MultiCell(95, 10, $beneficiary_addr, '0', 'L', 0, 0, '28.5', $rsPractice['p_beneficiary_addr_y_coordinate'], true);

		//       $pdf->SetFont('helvetica', 'B', $rsPractice['p_beneficiary_vat_font_size']);
		//       $pdf->MultiCell(105, 10, $beneficiary_vat, '0', 'C', 0, 0, '97', $rsPractice['p_beneficiary_vat_y_coordinate'], true);
	  //     }

	  //     $pdf->SetFont('helvetica', '', 6.7);
	  //     $pdf->writeHTMLCell(151, 210, '28.6', '74.5', $rsPractice['p_surety_object'], '0', '0', 0, true, '', true);

	  //     $pdf->SetFont('helvetica', 'B', 7.5);
	  //     $pdf->MultiCell(210, 10, $rsPractice['p_guaranteed_amount_currency'].' '.number_format($rsPractice['p_guaranteed_amount'], 2, ',', '.').' ('.$rsPractice['p_guaranteed_amount_words'].')', '0', 'L', 0, 0, '54', '149.2', true);

	  //     setlocale(LC_TIME, 'it_IT');
	  //     $from_date = strftime("%d %B %Y", strtotime($rsPractice['p_from_date']));
	  //     $to_date = strftime("%d %B %Y", strtotime($rsPractice['p_to_date']));
	  //     $release_date = strftime("%d %B %Y", strtotime($rsPractice['p_release_date']));

	  //     $pdf->SetFont('helvetica', 'B', 8);
	  //     $pdf->MultiCell(50, 10, $from_date, '0', 'L', 0, 0, '39', '154.9', true);
	  //     $pdf->MultiCell(50, 10, $to_date, '0', 'L', 0, 0, '77.8', '154.9', true);
	  //     $pdf->MultiCell(50, 10, $release_date, '0', 'L', 0, 0, '146.5', '154.9', true);

	  //     $pdf->SetFont('helvetica', 'B', 5.9);
	  //     $pdf->MultiCell(50, 10, $rsPractice['p_receipt_amount_currency'].' '.number_format($rsPractice['p_receipt_amount'], 2, ',', '.').' ('.$rsPractice['p_receipt_amount_words'].')', '0', 'L', 0, 0, '28.8', '221.4', true);
    //   }
    //   else
    //   {
    //   	$img_file1 = 'https://gestionale.istitutoelveticodigaranzia.ch/uploads/resources/front-en.jpg';
    //   	$img_file2 = 'https://gestionale.istitutoelveticodigaranzia.ch/uploads/resources/back-en.jpg';

    //   	$pdf->Image($img_file1, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);

	  //     $pdf->SetFont('helvetica', 'BI', 12);
	  //     $pdf->SetTextColor(0, 0, 0);
	  //     $pdf->MultiCell(210, 10, ($rsPractice['p_surety_no']), '0', 'L', 0, 0, '129', '25.3', true);

	  //     $pdf->SetFont('helvetica', 'B', $rsPractice['p_contractor_name_font_size']);
	  //     $pdf->MultiCell(210, 10, $contractor_name, '0', 'C', 0, 0, '0', $rsPractice['p_contractor_name_y_coordinate'], true);

	  //     $pdf->SetFont('helvetica', 'B', $rsPractice['p_contractor_addr_font_size']);
	  //     $pdf->MultiCell(95, 10, $contractor_addr, '0', 'L', 0, 0, '28.5', $rsPractice['p_contractor_addr_y_coordinate'], true);

	  //     $pdf->SetFont('helvetica', 'B', $rsPractice['p_contractor_vat_font_size']);
	  //     $pdf->MultiCell(105, 10, $contractor_vat, '0', 'C', 0, 0, '97', $rsPractice['p_contractor_vat_y_coordinate'], true);

	  //     // if(count($beneficiaries) > 1)
	  //     // {
		//     //   $pdf->SetFont('helvetica', 'B', 8);
		//     //   $pdf->MultiCell(210, 10, $beneficiary_name, '0', 'C', 0, 0, '0', '58', true);

		//     //   $pdf->SetFont('helvetica', 'B', 6);
		//     //   $pdf->MultiCell(105, 10, $beneficiary_addr, '0', 'L', 0, 0, '28.5', '65.6', true);

		//     //   $pdf->SetFont('helvetica', 'B', 6.7);
		//     //   $pdf->MultiCell(105, 10, $beneficiary_vat, '0', 'C', 0, 0, '100', '65.5', true);
	  //     // }
	  //     // else
	  //     {
		//       $pdf->SetFont('helvetica', 'B', $rsPractice['p_beneficiary_name_font_size']);
		//       $pdf->MultiCell(210, 10, $beneficiary_name, '0', 'C', 0, 0, '0', $rsPractice['p_beneficiary_name_y_coordinate'], true);

		//       $pdf->SetFont('helvetica', 'B', $rsPractice['p_beneficiary_addr_font_size']);
		//       $pdf->MultiCell(95, 10, $beneficiary_addr, '0', 'L', 0, 0, '28.5', $rsPractice['p_beneficiary_addr_y_coordinate'], true);

		//       $pdf->SetFont('helvetica', 'B', $rsPractice['p_beneficiary_vat_font_size']);
		//       $pdf->MultiCell(105, 10, $beneficiary_vat, '0', 'C', 0, 0, '97', $rsPractice['p_beneficiary_vat_y_coordinate'], true);
	  //     }

	  //     $pdf->SetFont('helvetica', '', 6.7);
	  //     $pdf->writeHTMLCell(151, 210, '28.6', '74.5', $rsPractice['p_surety_object'], '0', '0', 0, true, '', true);

	  //     $pdf->SetFont('helvetica', 'B', 7.5);
	  //     $pdf->MultiCell(210, 10, $rsPractice['p_guaranteed_amount_currency'].' '.number_format($rsPractice['p_guaranteed_amount'], 2, ',', '.').' ('.$rsPractice['p_guaranteed_amount_words'].')', '0', 'L', 0, 0, '54.7', '149.2', true);

	  //     setlocale(LC_TIME, 'it_IT');
	  //     $from_date = strftime("%d %B %Y", strtotime($rsPractice['p_from_date']));
	  //     $to_date = strftime("%d %B %Y", strtotime($rsPractice['p_to_date']));
	  //     $release_date = strftime("%d %B %Y", strtotime($rsPractice['p_release_date']));

	  //     $pdf->SetFont('helvetica', 'B', 8);
	  //     $pdf->MultiCell(50, 10, $from_date, '0', 'L', 0, 0, '42.3', '154.9', true);
	  //     $pdf->MultiCell(50, 10, $to_date, '0', 'L', 0, 0, '78.3', '154.9', true);
	  //     $pdf->MultiCell(50, 10, $release_date, '0', 'L', 0, 0, '149.4', '154.9', true);

	  //     $pdf->SetFont('helvetica', 'B', 5.9);
	  //     $pdf->MultiCell(50, 10, $rsPractice['p_receipt_amount_currency'].' '.number_format($rsPractice['p_receipt_amount'], 2, ',', '.').' ('.$rsPractice['p_receipt_amount_words'].')', '0', 'L', 0, 0, '29.5', '221.4', true);
    //   }

    //   $pdf->SetTextColor(0, 0, 0);

    //   $pdf->setPageMark();

    //   $pdf->SetMargins(0, 0, 0, true);
    //   $pdf->SetAutoPageBreak(false, 0);
    //   $pdf->AddPage('P', 'A4');

    //   $pdf->Image($img_file2, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);

    //   //$pdf->Output(FCPATH.'uploads'.'/drafts/Draft - '.$this->input->post('pk_id').'.pdf', 'F');
    //   $pdf->Output('Bozza-'.$contractor_name.'.pdf', 'D');
    //   exit;
		// }

		function download($pid)
		{
			$rsPractice = $this->{$this->model}->GetInfoById($pid);
			$contractors = $this->{$this->model}->GetContractors($pid);
			$beneficiaries = $this->{$this->model}->GetBeneficiaries($pid);

			$contractor_cnt = count($contractors);

			$m=0;
			$contractor_name = '';
			$contractor_addr = '';
			$contractor_vat = '';

			foreach($contractors as $b)
			{
        if($m == 0)
        {
          $contractor_name = $b['pc_contractor_name'];
          $contractor_addr = $b['pc_contractor_address'];
          $contractor_vat = $b['pc_contractor_vat_no'];
        }
        else
        {
          $contractor_name .= ' - '.$b['pc_contractor_name'];
          $contractor_addr .= ' - '.$b['pc_contractor_address'];
          $contractor_vat .= ' - '.$b['pc_contractor_vat_no'];
        }

        $m++;
			}

			$beneficiary_cnt = count($beneficiaries);

			$m=0;
			$beneficiary_name = '';
			$beneficiary_addr = '';
			$beneficiary_vat = '';

			foreach($beneficiaries as $b)
			{
        if($m == 0)
        {
          $beneficiary_name = $b['pb_beneficiary_name'];
          $beneficiary_addr = $b['pb_beneficiary_address'];
          $beneficiary_vat = $b['pb_beneficiary_vat_no'];
        }
        else
        {
          $beneficiary_name .= ' - '.$b['pb_beneficiary_name'];
          $beneficiary_addr .= ' - '.$b['pb_beneficiary_address'];
          $beneficiary_vat .= ' - '.$b['pb_beneficiary_vat_no'];
        }

        $m++;
			}

			$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
      $pdf->setPrintHeader(false);
      
      $pdf->startPageGroup();
      $pdf->setPrintFooter(false);

      $pdf->SetFontSize(9);

      if($this->system->protect_pdf == 1)
      {
	      $pdf->SetProtection(array('modify', 'copy'), '', null, 0, null);
      }

      $pdf->SetMargins(0, 0, 0, true);
      $pdf->SetAutoPageBreak(false, 0);
      $pdf->AddPage('P', 'A4');

      if($rsPractice['p_language'] == 'it')
      {
        $img_file1 = 'https://gestionale.istitutoelveticodigaranzia.ch/uploads/resources/front-it.jpg';
        $img_file2 = 'https://gestionale.istitutoelveticodigaranzia.ch/uploads/resources/back-it.jpg';

        $pdf->Image($img_file1, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);

	      $pdf->SetFont('helvetica', 'BI', 12);
	      $pdf->SetTextColor(0, 0, 0);
	      $pdf->MultiCell(210, 10, ($rsPractice['p_surety_no']), '0', 'L', 0, 0, '129', '25.3', true);

	      if(count($contractors) == 1)
	      {
		      $pdf->SetFont('helvetica', 'B', 8);
		      $pdf->MultiCell(210, 10, $contractor_name, '0', 'C', 0, 0, '0', 42.3, true);

		      $pdf->SetFont('helvetica', 'B', 7.5);
		      $pdf->MultiCell(95, 10, $contractor_addr, '0', 'L', 0, 0, '28.5', 49.7, true);

		      $pdf->SetFont('helvetica', 'B', 8);
		      $pdf->MultiCell(105, 10, $contractor_vat, '0', 'C', 0, 0, '100', 49.7, true);
	      }
	      elseif(count($contractors) == 2)
	      {
	      	$pdf->SetFont('helvetica', 'B', 7.4);
		      $pdf->MultiCell(210, 10, $contractor_name, '0', 'C', 0, 0, '0', 42.3, true);

		      $pdf->SetFont('helvetica', 'B', 6.2);
		      $pdf->MultiCell(95, 10, $contractor_addr, '0', 'L', 0, 0, '28.5', 49.7, true);

		      $pdf->SetFont('helvetica', 'B', 6.4);
		      $pdf->MultiCell(105, 10, $contractor_vat, '0', 'C', 0, 0, '100', 49.7, true);
	      }
	      elseif(count($contractors) == 3)
	      {
	      	$pdf->SetFont('helvetica', 'B', 7);
		      $pdf->MultiCell(210, 10, $contractor_name, '0', 'C', 0, 0, '0', 42.3, true);

		      $pdf->SetFont('helvetica', 'B', 5.3);
		      $pdf->MultiCell(95, 10, $contractor_addr, '0', 'L', 0, 0, '28.5', 49.5, true);

		      $pdf->SetFont('helvetica', 'B', 5.5);
		      $pdf->MultiCell(105, 10, $contractor_vat, '0', 'C', 0, 0, '97', 49.7, true);
	      }
	      else
	      {
	      	$pdf->SetFont('helvetica', 'B', 5.4);
		      $pdf->MultiCell(210, 10, $contractor_name, '0', 'C', 0, 0, '0', 42.8, true);

		      $pdf->SetFont('helvetica', 'B', 5.2);
		      $pdf->MultiCell(95, 10, $contractor_addr, '0', 'L', 0, 0, '28.5', 49.6, true);

		      $pdf->SetFont('helvetica', 'B', 5.2);
		      $pdf->MultiCell(105, 10, $contractor_vat, '0', 'C', 0, 0, '97', 50.1, true);
	      }

	      if(count($beneficiaries) == 1)
	      {
		      $pdf->SetFont('helvetica', 'B', 8);
		      $pdf->MultiCell(210, 10, $beneficiary_name, '0', 'C', 0, 0, '0', '58', true);

		      $pdf->SetFont('helvetica', 'B', 7.5);
		      $pdf->MultiCell(95, 10, $beneficiary_addr, '0', 'L', 0, 0, '28.5', '65.3', true);

		      $pdf->SetFont('helvetica', 'B', 8);
		      $pdf->MultiCell(105, 10, $beneficiary_vat, '0', 'C', 0, 0, '100', '65.3', true);
	      }
	      elseif(count($beneficiaries) == 2)
	      {
		      $pdf->SetFont('helvetica', 'B', 7.4);
		      $pdf->MultiCell(210, 10, $beneficiary_name, '0', 'C', 0, 0, '0', '58', true);

		      $pdf->SetFont('helvetica', 'B', 6.2);
		      $pdf->MultiCell(95, 10, $beneficiary_addr, '0', 'L', 0, 0, '28.5', '65.6', true);

		      $pdf->SetFont('helvetica', 'B', 6.4);
		      $pdf->MultiCell(105, 10, $beneficiary_vat, '0', 'C', 0, 0, '100', '65.5', true);
	      }
	      elseif(count($beneficiaries) == 3)
	      {
		      $pdf->SetFont('helvetica', 'B', 7);
		      $pdf->MultiCell(210, 10, $beneficiary_name, '0', 'C', 0, 0, '0', '58', true);

		      $pdf->SetFont('helvetica', 'B', 5.3);
		      $pdf->MultiCell(95, 10, $beneficiary_addr, '0', 'L', 0, 0, '28.5', '65.4', true);

		      $pdf->SetFont('helvetica', 'B', 5.5);
		      $pdf->MultiCell(105, 10, $beneficiary_vat, '0', 'C', 0, 0, '97', '65.5', true);
	      }
	      else
	      {
		      $pdf->SetFont('helvetica', 'B', 5.4);
		      $pdf->MultiCell(210, 10, $beneficiary_name, '0', 'C', 0, 0, '0', 58, true);

		      $pdf->SetFont('helvetica', 'B', 5.2);
		      $pdf->MultiCell(95, 10, $beneficiary_addr, '0', 'L', 0, 0, '28.5', 65.2, true);

		      $pdf->SetFont('helvetica', 'B', 5.2);
		      $pdf->MultiCell(105, 10, $beneficiary_vat, '0', 'C', 0, 0, '97', 65.3, true);
	      }

	      $pdf->SetFont('helvetica', '', 6.7);
	      $pdf->writeHTMLCell(151, 210, '28.6', '74.5', $rsPractice['p_surety_object'], '0', '0', 0, true, '', true);

	      $pdf->SetFont('helvetica', 'B', 7.5);
	      $pdf->MultiCell(210, 10, $rsPractice['p_guaranteed_amount_currency'].' '.number_format($rsPractice['p_guaranteed_amount'], 2, ',', '.').' ('.$rsPractice['p_guaranteed_amount_words'].')', '0', 'L', 0, 0, '54', '149.2', true);

	      setlocale(LC_TIME, 'it_IT');
	      $from_date = strftime("%d %B %Y", strtotime($rsPractice['p_from_date']));
	      $to_date = strftime("%d %B %Y", strtotime($rsPractice['p_to_date']));
	      $release_date = strftime("%d %B %Y", strtotime($rsPractice['p_release_date']));

	      $pdf->SetFont('helvetica', 'B', 8);
	      $pdf->MultiCell(50, 10, $from_date, '0', 'L', 0, 0, '39', '154.9', true);
	      $pdf->MultiCell(50, 10, $to_date, '0', 'L', 0, 0, '77.8', '154.9', true);
	      $pdf->MultiCell(50, 10, $release_date, '0', 'L', 0, 0, '146.5', '154.9', true);

	      $pdf->SetFont('helvetica', 'B', 5.9);
	      $pdf->MultiCell(50, 10, $rsPractice['p_receipt_amount_currency'].' '.number_format($rsPractice['p_receipt_amount'], 2, ',', '.').' ('.$rsPractice['p_receipt_amount_words'].')', '0', 'L', 0, 0, '28.8', '221.4', true);
      }
      else
      {
      	$img_file1 = 'https://gestionale.istitutoelveticodigaranzia.ch/uploads/resources/front-en.jpg';
      	$img_file2 = 'https://gestionale.istitutoelveticodigaranzia.ch/uploads/resources/back-en.jpg';

      	$pdf->Image($img_file1, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);

	      $pdf->SetFont('helvetica', 'BI', 12);
	      $pdf->SetTextColor(0, 0, 0);
	      $pdf->MultiCell(210, 10, ($rsPractice['p_surety_no']), '0', 'L', 0, 0, '129', '25.3', true);

	      // $pdf->SetFont('helvetica', 'B', $rsPractice['p_contractor_name_font_size']);
	      // $pdf->MultiCell(210, 10, $contractor_name, '0', 'C', 0, 0, '0', $rsPractice['p_contractor_name_y_coordinate'], true);

	      // $pdf->SetFont('helvetica', 'B', $rsPractice['p_contractor_addr_font_size']);
	      // $pdf->MultiCell(95, 10, $contractor_addr, '0', 'L', 0, 0, '28.5', $rsPractice['p_contractor_addr_y_coordinate'], true);

	      // $pdf->SetFont('helvetica', 'B', $rsPractice['p_contractor_vat_font_size']);
	      // $pdf->MultiCell(105, 10, $contractor_vat, '0', 'C', 0, 0, '97', $rsPractice['p_contractor_vat_y_coordinate'], true);

	      // if(count($beneficiaries) > 1)
	      // {
		    //   $pdf->SetFont('helvetica', 'B', 8);
		    //   $pdf->MultiCell(210, 10, $beneficiary_name, '0', 'C', 0, 0, '0', '58', true);

		    //   $pdf->SetFont('helvetica', 'B', 6);
		    //   $pdf->MultiCell(105, 10, $beneficiary_addr, '0', 'L', 0, 0, '28.5', '65.6', true);

		    //   $pdf->SetFont('helvetica', 'B', 6.7);
		    //   $pdf->MultiCell(105, 10, $beneficiary_vat, '0', 'C', 0, 0, '100', '65.5', true);
	      // }
	      // else
	      // {
		    //   $pdf->SetFont('helvetica', 'B', $rsPractice['p_beneficiary_name_font_size']);
		    //   $pdf->MultiCell(210, 10, $beneficiary_name, '0', 'C', 0, 0, '0', $rsPractice['p_beneficiary_name_y_coordinate'], true);

		    //   $pdf->SetFont('helvetica', 'B', $rsPractice['p_beneficiary_addr_font_size']);
		    //   $pdf->MultiCell(95, 10, $beneficiary_addr, '0', 'L', 0, 0, '28.5', $rsPractice['p_beneficiary_addr_y_coordinate'], true);

		    //   $pdf->SetFont('helvetica', 'B', $rsPractice['p_beneficiary_vat_font_size']);
		    //   $pdf->MultiCell(105, 10, $beneficiary_vat, '0', 'C', 0, 0, '97', $rsPractice['p_beneficiary_vat_y_coordinate'], true);
	      // }

	      if(count($contractors) == 1)
	      {
		      $pdf->SetFont('helvetica', 'B', 8);
		      $pdf->MultiCell(210, 10, $contractor_name, '0', 'C', 0, 0, '0', 42.3, true);

		      $pdf->SetFont('helvetica', 'B', 7.5);
		      $pdf->MultiCell(95, 10, $contractor_addr, '0', 'L', 0, 0, '28.5', 49.7, true);

		      $pdf->SetFont('helvetica', 'B', 8);
		      $pdf->MultiCell(105, 10, $contractor_vat, '0', 'C', 0, 0, '100', 49.7, true);
	      }
	      elseif(count($contractors) == 2)
	      {
	      	$pdf->SetFont('helvetica', 'B', 7.4);
		      $pdf->MultiCell(210, 10, $contractor_name, '0', 'C', 0, 0, '0', 42.3, true);

		      $pdf->SetFont('helvetica', 'B', 6.2);
		      $pdf->MultiCell(95, 10, $contractor_addr, '0', 'L', 0, 0, '28.5', 49.7, true);

		      $pdf->SetFont('helvetica', 'B', 6.4);
		      $pdf->MultiCell(105, 10, $contractor_vat, '0', 'C', 0, 0, '100', 49.7, true);
	      }
	      elseif(count($contractors) == 3)
	      {
	      	$pdf->SetFont('helvetica', 'B', 7);
		      $pdf->MultiCell(210, 10, $contractor_name, '0', 'C', 0, 0, '0', 42.3, true);

		      $pdf->SetFont('helvetica', 'B', 5.3);
		      $pdf->MultiCell(95, 10, $contractor_addr, '0', 'L', 0, 0, '28.5', 49.5, true);

		      $pdf->SetFont('helvetica', 'B', 5.5);
		      $pdf->MultiCell(105, 10, $contractor_vat, '0', 'C', 0, 0, '97', 49.7, true);
	      }
	      else
	      {
	      	$pdf->SetFont('helvetica', 'B', 5.4);
		      $pdf->MultiCell(210, 10, $contractor_name, '0', 'C', 0, 0, '0', 42.8, true);

		      $pdf->SetFont('helvetica', 'B', 5.2);
		      $pdf->MultiCell(95, 10, $contractor_addr, '0', 'L', 0, 0, '28.5', 49.6, true);

		      $pdf->SetFont('helvetica', 'B', 5.2);
		      $pdf->MultiCell(105, 10, $contractor_vat, '0', 'C', 0, 0, '97', 50.1, true);
	      }

	      if(count($beneficiaries) == 1)
	      {
		      $pdf->SetFont('helvetica', 'B', 8);
		      $pdf->MultiCell(210, 10, $beneficiary_name, '0', 'C', 0, 0, '0', '58', true);

		      $pdf->SetFont('helvetica', 'B', 7.5);
		      $pdf->MultiCell(95, 10, $beneficiary_addr, '0', 'L', 0, 0, '28.5', '65.3', true);

		      $pdf->SetFont('helvetica', 'B', 8);
		      $pdf->MultiCell(105, 10, $beneficiary_vat, '0', 'C', 0, 0, '100', '65.3', true);
	      }
	      elseif(count($beneficiaries) == 2)
	      {
		      $pdf->SetFont('helvetica', 'B', 7.4);
		      $pdf->MultiCell(210, 10, $beneficiary_name, '0', 'C', 0, 0, '0', '58', true);

		      $pdf->SetFont('helvetica', 'B', 6.2);
		      $pdf->MultiCell(95, 10, $beneficiary_addr, '0', 'L', 0, 0, '28.5', '65.6', true);

		      $pdf->SetFont('helvetica', 'B', 6.4);
		      $pdf->MultiCell(105, 10, $beneficiary_vat, '0', 'C', 0, 0, '100', '65.5', true);
	      }
	      elseif(count($beneficiaries) == 3)
	      {
		      $pdf->SetFont('helvetica', 'B', 7);
		      $pdf->MultiCell(210, 10, $beneficiary_name, '0', 'C', 0, 0, '0', '58', true);

		      $pdf->SetFont('helvetica', 'B', 5.3);
		      $pdf->MultiCell(95, 10, $beneficiary_addr, '0', 'L', 0, 0, '28.5', '65.4', true);

		      $pdf->SetFont('helvetica', 'B', 5.5);
		      $pdf->MultiCell(105, 10, $beneficiary_vat, '0', 'C', 0, 0, '97', '65.5', true);
	      }
	      else
	      {
		      $pdf->SetFont('helvetica', 'B', 5.4);
		      $pdf->MultiCell(210, 10, $beneficiary_name, '0', 'C', 0, 0, '0', 58, true);

		      $pdf->SetFont('helvetica', 'B', 5.2);
		      $pdf->MultiCell(95, 10, $beneficiary_addr, '0', 'L', 0, 0, '28.5', 65.2, true);

		      $pdf->SetFont('helvetica', 'B', 5.2);
		      $pdf->MultiCell(105, 10, $beneficiary_vat, '0', 'C', 0, 0, '97', 65.3, true);
	      }

	      $pdf->SetFont('helvetica', '', 6.7);
	      $pdf->writeHTMLCell(151, 210, '28.6', '74.5', $rsPractice['p_surety_object'], '0', '0', 0, true, '', true);

	      $pdf->SetFont('helvetica', 'B', 7.5);
	      $pdf->MultiCell(210, 10, $rsPractice['p_guaranteed_amount_currency'].' '.number_format($rsPractice['p_guaranteed_amount'], 2, ',', '.').' ('.$rsPractice['p_guaranteed_amount_words'].')', '0', 'L', 0, 0, '54.7', '149.2', true);

	      setlocale(LC_TIME, 'it_IT');
	      $from_date = strftime("%d %B %Y", strtotime($rsPractice['p_from_date']));
	      $to_date = strftime("%d %B %Y", strtotime($rsPractice['p_to_date']));
	      $release_date = strftime("%d %B %Y", strtotime($rsPractice['p_release_date']));

	      $pdf->SetFont('helvetica', 'B', 8);
	      $pdf->MultiCell(50, 10, $from_date, '0', 'L', 0, 0, '42.3', '154.9', true);
	      $pdf->MultiCell(50, 10, $to_date, '0', 'L', 0, 0, '78.3', '154.9', true);
	      $pdf->MultiCell(50, 10, $release_date, '0', 'L', 0, 0, '149.4', '154.9', true);

	      $pdf->SetFont('helvetica', 'B', 5.9);
	      $pdf->MultiCell(50, 10, $rsPractice['p_receipt_amount_currency'].' '.number_format($rsPractice['p_receipt_amount'], 2, ',', '.').' ('.$rsPractice['p_receipt_amount_words'].')', '0', 'L', 0, 0, '29.5', '221.4', true);
      }

      $pdf->SetTextColor(0, 0, 0);

      $pdf->setPageMark();

      $pdf->SetMargins(0, 0, 0, true);
      $pdf->SetAutoPageBreak(false, 0);
      $pdf->AddPage('P', 'A4');

      $pdf->Image($img_file2, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);

      //$pdf->Output(FCPATH.'uploads'.'/drafts/Draft - '.$this->input->post('pk_id').'.pdf', 'F');
      $pdf->Output('Bozza-'.$contractor_name.'.pdf', 'D');
      exit;
		}

		// function print($pid)
		// {
		// 	$this->load->model('Print_model', 'print');

		// 	$rsPractice = $this->{$this->model}->GetInfoById($pid);
		// 	$beneficiaries = $this->{$this->model}->GetBeneficiaries($pid);

		// 	$beneficiary_cnt = count($beneficiaries);

		// 	$m=0;
		// 	$beneficiary_name = '';
		// 	$beneficiary_addr = '';
		// 	$beneficiary_vat = '';

		// 	foreach($beneficiaries as $b)
		// 	{
    //           if($m == 0)
    //           {
    //             $beneficiary_name = $b['pb_beneficiary_name'];
    //             $beneficiary_addr = $b['pb_beneficiary_address'];
    //             $beneficiary_vat = $b['pb_beneficiary_vat_no'];
    //           }
    //           else
    //           {
    //             $beneficiary_name .= ' - '.$b['pb_beneficiary_name'];
    //             $beneficiary_addr .= ' - '.$b['pb_beneficiary_address'];
    //             $beneficiary_vat .= ' - '.$b['pb_beneficiary_vat_no'];
    //           }

    //           $m++;
		// 	}

		// 	$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
    // 	$pdf->setPrintHeader(false);
    
    // 	$pdf->startPageGroup();
    // 	$pdf->setPrintFooter(false);

    // 	$pdf->SetFontSize(9);

    // 	$pdf->SetMargins(0, 0, 0, true);
    // 	$pdf->SetAutoPageBreak(false, 0);
    // 	$pdf->AddPage('P', 'A4');

    // 	$rs1 = $this->print->GetParamValues('p_surety_no');
    // 	$pdf->SetFont('helvetica', $rs1['font_type'], $rs1['font_size']);
    // 	$pdf->SetTextColor(0, 0, 0);
    // 	$pdf->MultiCell($rs1['width'], 10, ($rsPractice['p_surety_no']), '0', 'L', 0, 0, $rs1['x_coordinate'], $rs1['y_coordinate'], true);

    // 	$rs2 = $this->print->GetParamValues('p_contractor_name');
    // 	$pdf->SetFont('helvetica', $rs2['font_type'], $rs2['font_size']);
    // 	$pdf->MultiCell($rs2['width'], 10, $rsPractice['p_contractor_name'], '0', 'C', 0, 0, $rs2['x_coordinate'], $rs2['y_coordinate'], true);

		// 	$rs3 = $this->print->GetParamValues('p_contractor_address');
    // 	$pdf->SetFont('helvetica', $rs3['font_type'], $rs3['font_size']);
    // 	$pdf->MultiCell($rs3['width'], 10, $rsPractice['p_contractor_address'], '0', 'L', 0, 0, $rs3['x_coordinate'], $rs3['y_coordinate'], true);

    // 	$rs4 = $this->print->GetParamValues('p_contractor_vat_no');
    // 	$pdf->SetFont('helvetica', $rs4['font_type'], $rs4['font_size']);
    // 	$pdf->MultiCell($rs4['width'], 10, $rsPractice['p_contractor_vat_no'], '0', 'C', 0, 0, $rs4['x_coordinate'], $rs4['y_coordinate'], true);

    // 	$rs5 = $this->print->GetParamValues('beneficiary_name');
    // 	$pdf->SetFont('helvetica', $rs5['font_type'], $rs5['font_size']);
    // 	$pdf->MultiCell($rs5['width'], 10, $beneficiary_name, '0', 'C', 0, 0, $rs5['x_coordinate'], $rs5['y_coordinate'], true);

    // 	$rs6 = $this->print->GetParamValues('beneficiary_addr');
    // 	$pdf->SetFont('helvetica', $rs6['font_type'], $rs6['font_size']);
    // 	$pdf->MultiCell($rs6['width'], 10, $beneficiary_addr, '0', 'L', 0, 0, $rs6['x_coordinate'], $rs6['y_coordinate'], true);

    // 	$rs7 = $this->print->GetParamValues('beneficiary_vat');
    // 	$pdf->SetFont('helvetica', $rs7['font_type'], $rs7['font_size']);
    // 	$pdf->MultiCell($rs7['width'], 10, $beneficiary_vat, '0', 'C', 0, 0, $rs7['x_coordinate'], $rs7['y_coordinate'], true);

    // 	$rs8 = $this->print->GetParamValues('p_surety_object');
    // 	$pdf->SetFont('helvetica', $rs8['font_type'], $rs8['font_size']);
    // 	$pdf->writeHTMLCell($rs8['width'], 210, $rs8['x_coordinate'], $rs8['y_coordinate'], $rsPractice['p_surety_object'], '0', '0', 0, true, '', true);

    // 	$rs9 = $this->print->GetParamValues('guaranteed_amount_details');
    // 	$pdf->SetFont('helvetica', $rs9['font_type'], $rs9['font_size']);
    // 	$pdf->MultiCell($rs9['width'], 10, $rsPractice['p_guaranteed_amount_currency'].' '.number_format($rsPractice['p_guaranteed_amount'], 2, ',', '.').' ('.$rsPractice['p_guaranteed_amount_words'].')', '0', 'L', 0, 0, $rs9['x_coordinate'], $rs9['y_coordinate'], true);

    // 	setlocale(LC_TIME, 'it_IT');
    // 	$from_date = strftime("%d %B %Y", strtotime($rsPractice['p_from_date']));
    // 	$to_date = strftime("%d %B %Y", strtotime($rsPractice['p_to_date']));
    // 	$release_date = strftime("%d %B %Y", strtotime($rsPractice['p_release_date']));

    // 	$rs10 = $this->print->GetParamValues('from_date');
    // 	$pdf->SetFont('helvetica', $rs10['font_type'], $rs10['font_size']);
    // 	$pdf->MultiCell($rs10['width'], 10, $from_date, '0', 'L', 0, 0, $rs10['x_coordinate'], $rs10['y_coordinate'], true);

    // 	$rs11 = $this->print->GetParamValues('to_date');
    // 	$pdf->SetFont('helvetica', $rs11['font_type'], $rs11['font_size']);
    // 	$pdf->MultiCell($rs11['width'], 10, $to_date, '0', 'L', 0, 0, $rs11['x_coordinate'], $rs11['y_coordinate'], true);

    // 	$rs12 = $this->print->GetParamValues('release_date');
    // 	$pdf->SetFont('helvetica', $rs12['font_type'], $rs12['font_size']);
    // 	$pdf->MultiCell($rs12['width'], 10, $release_date, '0', 'L', 0, 0, $rs12['x_coordinate'], $rs12['y_coordinate'], true);

    // 	$rs13 = $this->print->GetParamValues('receipt_amount_details');
    // 	$pdf->SetFont('helvetica', $rs13['font_type'], $rs13['font_size']);
    // 	$pdf->MultiCell($rs13['width'], 10, $rsPractice['p_receipt_amount_currency'].' '.number_format($rsPractice['p_receipt_amount'], 2, ',', '.').' ('.$rsPractice['p_receipt_amount_words'].')', '0', 'L', 0, 0, $rs13['x_coordinate'], $rs13['y_coordinate'], true);

    // 	$pdf->Output('Stampa-'.$rsPractice['p_contractor_name'].'.pdf', 'D');
    // 	exit;
		// }

		function print($pid)
		{
			$this->load->model('Print_model', 'print');

			$rsPractice = $this->{$this->model}->GetInfoById($pid);
			$contractors = $this->{$this->model}->GetContractors($pid);
			$beneficiaries = $this->{$this->model}->GetBeneficiaries($pid);

			$contractor_cnt = count($contractors);

			$m=0;
			$contractor_name = '';
			$contractor_addr = '';
			$contractor_vat = '';

			foreach($contractors as $b)
			{
        if($m == 0)
        {
          $contractor_name = $b['pc_contractor_name'];
          $contractor_addr = $b['pc_contractor_address'];
          $contractor_vat = $b['pc_contractor_vat_no'];
        }
        else
        {
          $contractor_name .= ' - '.$b['pc_contractor_name'];
          $contractor_addr .= ' - '.$b['pc_contractor_address'];
          $contractor_vat .= ' - '.$b['pc_contractor_vat_no'];
        }

        $m++;
			}

			$beneficiary_cnt = count($beneficiaries);

			$m=0;
			$beneficiary_name = '';
			$beneficiary_addr = '';
			$beneficiary_vat = '';

			foreach($beneficiaries as $b)
			{
        if($m == 0)
        {
          $beneficiary_name = $b['pb_beneficiary_name'];
          $beneficiary_addr = $b['pb_beneficiary_address'];
          $beneficiary_vat = $b['pb_beneficiary_vat_no'];
        }
        else
        {
          $beneficiary_name .= ' - '.$b['pb_beneficiary_name'];
          $beneficiary_addr .= ' - '.$b['pb_beneficiary_address'];
          $beneficiary_vat .= ' - '.$b['pb_beneficiary_vat_no'];
        }

        $m++;
			}

			$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
      $pdf->setPrintHeader(false);
      
      $pdf->startPageGroup();
      $pdf->setPrintFooter(false);

      $pdf->SetFontSize(9);

      $pdf->SetMargins(0, 0, 0, true);
      $pdf->SetAutoPageBreak(false, 0);
      $pdf->AddPage('P', 'A4');

      $rs1 = $this->print->GetParamValues('p_surety_no');
      $pdf->SetFont('helvetica', $rs1['font_type'], $rs1['font_size']);
      $pdf->SetTextColor(0, 0, 0);
      $pdf->MultiCell($rs1['width'], 10, ($rsPractice['p_surety_no']), '0', 'L', 0, 0, $rs1['x_coordinate'], $rs1['y_coordinate'], true);

      if(count($contractors) == 1)
      {
	      $rs2 = $this->print->GetParamValues('contractor_name_1');
	      $pdf->SetFont('helvetica', $rs2['font_type'], $rs2['font_size']);
	      $pdf->MultiCell($rs2['width'], 10, $contractor_name, '0', 'C', 0, 0, $rs2['x_coordinate'], $rs2['y_coordinate'], true);

				$rs3 = $this->print->GetParamValues('contractor_addr_1');
	      $pdf->SetFont('helvetica', $rs3['font_type'], $rs3['font_size']);
	      $pdf->MultiCell($rs3['width'], 10, $contractor_addr, '0', 'L', 0, 0, $rs3['x_coordinate'], $rs3['y_coordinate'], true);

	      $rs4 = $this->print->GetParamValues('contractor_vat_1');
	      $pdf->SetFont('helvetica', $rs4['font_type'], $rs4['font_size']);
	      $pdf->MultiCell($rs4['width'], 10, $contractor_vat, '0', 'C', 0, 0, $rs4['x_coordinate'], $rs4['y_coordinate'], true);
      }
      elseif(count($contractors) == 2)
      {
	      $rs2 = $this->print->GetParamValues('contractor_name_2');
	      $pdf->SetFont('helvetica', $rs2['font_type'], $rs2['font_size']);
	      $pdf->MultiCell($rs2['width'], 10, $contractor_name, '0', 'C', 0, 0, $rs2['x_coordinate'], $rs2['y_coordinate'], true);

				$rs3 = $this->print->GetParamValues('contractor_addr_2');
	      $pdf->SetFont('helvetica', $rs3['font_type'], $rs3['font_size']);
	      $pdf->MultiCell($rs3['width'], 10, $contractor_addr, '0', 'L', 0, 0, $rs3['x_coordinate'], $rs3['y_coordinate'], true);

	      $rs4 = $this->print->GetParamValues('contractor_vat_2');
	      $pdf->SetFont('helvetica', $rs4['font_type'], $rs4['font_size']);
	      $pdf->MultiCell($rs4['width'], 10, $contractor_vat, '0', 'C', 0, 0, $rs4['x_coordinate'], $rs4['y_coordinate'], true);
      }
      elseif(count($contractors) == 3)
      {
	      $rs2 = $this->print->GetParamValues('contractor_name_3');
	      $pdf->SetFont('helvetica', $rs2['font_type'], $rs2['font_size']);
	      $pdf->MultiCell($rs2['width'], 10, $contractor_name, '0', 'C', 0, 0, $rs2['x_coordinate'], $rs2['y_coordinate'], true);

				$rs3 = $this->print->GetParamValues('contractor_addr_3');
	      $pdf->SetFont('helvetica', $rs3['font_type'], $rs3['font_size']);
	      $pdf->MultiCell($rs3['width'], 10, $contractor_addr, '0', 'L', 0, 0, $rs3['x_coordinate'], $rs3['y_coordinate'], true);

	      $rs4 = $this->print->GetParamValues('contractor_vat_3');
	      $pdf->SetFont('helvetica', $rs4['font_type'], $rs4['font_size']);
	      $pdf->MultiCell($rs4['width'], 10, $contractor_vat, '0', 'C', 0, 0, $rs4['x_coordinate'], $rs4['y_coordinate'], true);
      }
      else
      {
	      $rs2 = $this->print->GetParamValues('contractor_name_4');
	      $pdf->SetFont('helvetica', $rs2['font_type'], $rs2['font_size']);
	      $pdf->MultiCell($rs2['width'], 10, $contractor_name, '0', 'C', 0, 0, $rs2['x_coordinate'], $rs2['y_coordinate'], true);

				$rs3 = $this->print->GetParamValues('contractor_addr_4');
	      $pdf->SetFont('helvetica', $rs3['font_type'], $rs3['font_size']);
	      $pdf->MultiCell($rs3['width'], 10, $contractor_addr, '0', 'L', 0, 0, $rs3['x_coordinate'], $rs3['y_coordinate'], true);

	      $rs4 = $this->print->GetParamValues('contractor_vat_4');
	      $pdf->SetFont('helvetica', $rs4['font_type'], $rs4['font_size']);
	      $pdf->MultiCell($rs4['width'], 10, $contractor_vat, '0', 'C', 0, 0, $rs4['x_coordinate'], $rs4['y_coordinate'], true);
      }

      if(count($beneficiaries) == 1)
      {
      	$rs5 = $this->print->GetParamValues('beneficiary_name_1');
	      $pdf->SetFont('helvetica', $rs5['font_type'], $rs5['font_size']);
	      $pdf->MultiCell($rs5['width'], 10, $beneficiary_name, '0', 'C', 0, 0, $rs5['x_coordinate'], $rs5['y_coordinate'], true);

	      $rs6 = $this->print->GetParamValues('beneficiary_addr_1');
	      $pdf->SetFont('helvetica', $rs6['font_type'], $rs6['font_size']);
	      $pdf->MultiCell($rs6['width'], 10, $beneficiary_addr, '0', 'L', 0, 0, $rs6['x_coordinate'], $rs6['y_coordinate'], true);

	      $rs7 = $this->print->GetParamValues('beneficiary_vat_1');
	      $pdf->SetFont('helvetica', $rs7['font_type'], $rs7['font_size']);
	      $pdf->MultiCell($rs7['width'], 10, $beneficiary_vat, '0', 'C', 0, 0, $rs7['x_coordinate'], $rs7['y_coordinate'], true);
      }
      elseif(count($beneficiaries) == 2)
      {
      	$rs5 = $this->print->GetParamValues('beneficiary_name_2');
	      $pdf->SetFont('helvetica', $rs5['font_type'], $rs5['font_size']);
	      $pdf->MultiCell($rs5['width'], 10, $beneficiary_name, '0', 'C', 0, 0, $rs5['x_coordinate'], $rs5['y_coordinate'], true);

	      $rs6 = $this->print->GetParamValues('beneficiary_addr_2');
	      $pdf->SetFont('helvetica', $rs6['font_type'], $rs6['font_size']);
	      $pdf->MultiCell($rs6['width'], 10, $beneficiary_addr, '0', 'L', 0, 0, $rs6['x_coordinate'], $rs6['y_coordinate'], true);

	      $rs7 = $this->print->GetParamValues('beneficiary_vat_2');
	      $pdf->SetFont('helvetica', $rs7['font_type'], $rs7['font_size']);
	      $pdf->MultiCell($rs7['width'], 10, $beneficiary_vat, '0', 'C', 0, 0, $rs7['x_coordinate'], $rs7['y_coordinate'], true);
      }
      elseif(count($beneficiaries) == 3)
      {
      	$rs5 = $this->print->GetParamValues('beneficiary_name_3');
	      $pdf->SetFont('helvetica', $rs5['font_type'], $rs5['font_size']);
	      $pdf->MultiCell($rs5['width'], 10, $beneficiary_name, '0', 'C', 0, 0, $rs5['x_coordinate'], $rs5['y_coordinate'], true);

	      $rs6 = $this->print->GetParamValues('beneficiary_addr_3');
	      $pdf->SetFont('helvetica', $rs6['font_type'], $rs6['font_size']);
	      $pdf->MultiCell($rs6['width'], 10, $beneficiary_addr, '0', 'L', 0, 0, $rs6['x_coordinate'], $rs6['y_coordinate'], true);

	      $rs7 = $this->print->GetParamValues('beneficiary_vat_3');
	      $pdf->SetFont('helvetica', $rs7['font_type'], $rs7['font_size']);
	      $pdf->MultiCell($rs7['width'], 10, $beneficiary_vat, '0', 'C', 0, 0, $rs7['x_coordinate'], $rs7['y_coordinate'], true);
      }
      else
      {
      	$rs5 = $this->print->GetParamValues('beneficiary_name_4');
	      $pdf->SetFont('helvetica', $rs5['font_type'], $rs5['font_size']);
	      $pdf->MultiCell($rs5['width'], 10, $beneficiary_name, '0', 'C', 0, 0, $rs5['x_coordinate'], $rs5['y_coordinate'], true);

	      $rs6 = $this->print->GetParamValues('beneficiary_addr_4');
	      $pdf->SetFont('helvetica', $rs6['font_type'], $rs6['font_size']);
	      $pdf->MultiCell($rs6['width'], 10, $beneficiary_addr, '0', 'L', 0, 0, $rs6['x_coordinate'], $rs6['y_coordinate'], true);

	      $rs7 = $this->print->GetParamValues('beneficiary_vat_4');
	      $pdf->SetFont('helvetica', $rs7['font_type'], $rs7['font_size']);
	      $pdf->MultiCell($rs7['width'], 10, $beneficiary_vat, '0', 'C', 0, 0, $rs7['x_coordinate'], $rs7['y_coordinate'], true);
      }

      $rs8 = $this->print->GetParamValues('p_surety_object');
      $pdf->SetFont('helvetica', $rs8['font_type'], $rs8['font_size']);
      $pdf->writeHTMLCell($rs8['width'], 210, $rs8['x_coordinate'], $rs8['y_coordinate'], $rsPractice['p_surety_object'], '0', '0', 0, true, '', true);

      $rs9 = $this->print->GetParamValues('guaranteed_amount_details');
      $pdf->SetFont('helvetica', $rs9['font_type'], $rs9['font_size']);
      $pdf->MultiCell($rs9['width'], 10, $rsPractice['p_guaranteed_amount_currency'].' '.number_format($rsPractice['p_guaranteed_amount'], 2, ',', '.').' ('.$rsPractice['p_guaranteed_amount_words'].')', '0', 'L', 0, 0, $rs9['x_coordinate'], $rs9['y_coordinate'], true);

      setlocale(LC_TIME, 'it_IT');
      $from_date = strftime("%d %B %Y", strtotime($rsPractice['p_from_date']));
      $to_date = strftime("%d %B %Y", strtotime($rsPractice['p_to_date']));
      $release_date = strftime("%d %B %Y", strtotime($rsPractice['p_release_date']));

      $rs10 = $this->print->GetParamValues('from_date');
      $pdf->SetFont('helvetica', $rs10['font_type'], $rs10['font_size']);
      $pdf->MultiCell($rs10['width'], 10, $from_date, '0', 'L', 0, 0, $rs10['x_coordinate'], $rs10['y_coordinate'], true);

      $rs11 = $this->print->GetParamValues('to_date');
      $pdf->SetFont('helvetica', $rs11['font_type'], $rs11['font_size']);
      $pdf->MultiCell($rs11['width'], 10, $to_date, '0', 'L', 0, 0, $rs11['x_coordinate'], $rs11['y_coordinate'], true);

      $rs12 = $this->print->GetParamValues('release_date');
      $pdf->SetFont('helvetica', $rs12['font_type'], $rs12['font_size']);
      $pdf->MultiCell($rs12['width'], 10, $release_date, '0', 'L', 0, 0, $rs12['x_coordinate'], $rs12['y_coordinate'], true);

      $rs13 = $this->print->GetParamValues('receipt_amount_details');
      $pdf->SetFont('helvetica', $rs13['font_type'], $rs13['font_size']);
      $pdf->MultiCell($rs13['width'], 10, $rsPractice['p_receipt_amount_currency'].' '.number_format($rsPractice['p_receipt_amount'], 2, ',', '.').' ('.$rsPractice['p_receipt_amount_words'].')', '0', 'L', 0, 0, $rs13['x_coordinate'], $rs13['y_coordinate'], true);

      $pdf->Output('Stampa-'.$contractor_name.'.pdf', 'D');
      exit;
		}
	}
?>