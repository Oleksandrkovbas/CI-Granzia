<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . "libraries/tcpdf/PDFMerger.php";

use PDFMerger\PDFMerger;


class Practices extends User_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');

		$this->load->library('upload');
		$this->load->library('session');
		$this->load->library('user_agent');

		$this->load->model('Practice_model', 'practice');
		$this->load->model('User_model', 'user');
		$this->load->library('pdf');
		//$this->output->enable_profiler(TRUE);

		$this->title = 'Pratiche';
		$this->list_title = 'Practice List';
		$this->view_title = 'Practice Details';
		$this->no_records = 'No record found.';
		$this->action_url = 'practices';
		$this->add_url = 'practices/insert';
		$this->edit_url = 'practices/edit';
		$this->manage_view = 'practice_manage';
		$this->addedit_view = 'practice_addedit';
		$this->view_view = 'practice_view';
		$this->redirect_url = 'practices/index';
		$this->model = 'practice';
		$this->insert_msg = 'Record inserted successfully.';
		$this->update_msg = 'Record updated successfully.';
		$this->delete_msg = 'Pratica rimossa correttamente.';
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
		$this->load->view('main', $data);
	}

	function expiring($id = '0')
	{
		$data['title'] = 'Pratiche in Scadenza';
		$data['js'] = array("common.js");

		$data['query'] = $this->{$this->model}->ViewAllExpiring();

		$data['view'] = 'practice_expiring';
		$this->load->view('main', $data);
	}

	function search()
	{
		$data['title'] = 'Cerca Pratiche';
		$data['js'] = array("common.js");

		if ($this->input->post('submit') == 'Search') {
			$data['search'] = true;
			$this->session->set_userdata('sel_filters', 1);
			$this->session->set_userdata('sel_filter_surety_no', $this->input->post('filter_surety_no'));
			$this->session->set_userdata('sel_filter_contractor_name', $this->input->post('filter_contractor_name'));

			$this->session->set_userdata('sel_filter_contractor_vat_no', $this->input->post('filter_contractor_vat_no'));
			$this->session->set_userdata('sel_filter_beneficiary_name', $this->input->post('filter_beneficiary_name'));
			$this->session->set_userdata('sel_filter_beneficiary_vat_no', $this->input->post('filter_beneficiary_vat_no'));
			$this->session->set_userdata('sel_filter_from_date', $this->input->post('filter_from_date'));
			$this->session->set_userdata('sel_filter_to_date', $this->input->post('filter_to_date'));
			$this->session->set_userdata('sel_filter_release_date', $this->input->post('filter_release_date'));
			$this->session->set_userdata('sel_filter_guaranteed_amount', $this->input->post('filter_guaranteed_amount'));
			$this->session->set_userdata('sel_filter_receipt_amount', $this->input->post('filter_receipt_amount'));
			$this->session->set_userdata('sel_filter_broker', $this->input->post('filter_broker'));
			$this->session->set_userdata('sel_filter_object', $this->input->post('filter_object'));
			$this->session->set_userdata('sel_filter_appenice', $this->input->post('filter_appenice'));
		} else {
			$data['search'] = false;
			$this->session->unset_userdata('sel_filters');
			$this->session->unset_userdata('sel_filter_surety_no');
			$this->session->unset_userdata('sel_filter_contractor_name');
			$this->session->unset_userdata('sel_filter_contractor_vat_no');
			$this->session->unset_userdata('sel_filter_beneficiary_name');
			$this->session->unset_userdata('sel_filter_beneficiary_vat_no');
			$this->session->unset_userdata('sel_filter_from_date');
			$this->session->unset_userdata('sel_filter_to_date');
			$this->session->unset_userdata('sel_filter_release_date');
			$this->session->unset_userdata('sel_filter_guaranteed_amount');
			$this->session->unset_userdata('sel_filter_receipt_amount');
			$this->session->unset_userdata('sel_filter_broker');
			$this->session->unset_userdata('sel_filter_object');
			$this->session->unset_userdata('sel_filter_appenice');
		}

		$data['query'] = $this->{$this->model}->ViewAllSearch();
		$data['view'] = 'practice_search';
		$this->load->view('main', $data);
	}

	function insert()
	{
		$data['title'] = $this->title;
		$data['Action'] = "Add";
		$data['js'] = array("common.js");

		/* get system api kye*/
		$this->db->where('config_name', 'editor_api_key');
		$data['api_data'] = $this->db->get('web_config')->row();
		//echo "<pre>";print_r($data);exit;
		//echo $this->db->last_query();exit;
		//$data['user_data'] = $this->user->GetInfoById($this->session->userdata('id'));

		if ($this->input->post('submit')) {
			$rules = $this->{$this->model}->rules;
			$this->form_validation->set_rules($rules);

			if ($this->form_validation->run() == true) {
				if ($result = $this->{$this->model}->Insert()) {
					if ($this->input->post('submit') == 'Draft')
						$this->session->set_flashdata('success_notification', 'Bozza creata correttamente.');
					else
						$this->session->set_flashdata('success_notification', 'Pratica creata con correttamente.');

					redirect($this->redirect_url);
				} else {
					$this->session->set_flashdata('error_notification', 'Numero pratica già esistente.');
					redirect($this->redirect_url);
				}
			} else {
				$this->session->set_flashdata('error_notification', $this->insert_error_msg);
				redirect($this->redirect_url);
			}
		} elseif ($this->input->post('cancel')) {
			redirect($this->redirect_url);
		} else {
			$data['view'] = $this->addedit_view;
			$this->load->view('main', $data);
		}
	}

	function edit()
	{
		$data['title'] = $this->title;
		$data['Action'] = "Edit";
		$data['js'] = array("common.js");

		/* get system api kye*/
		$this->db->where('config_name', 'editor_api_key');
		$data['api_data'] = $this->db->get('web_config')->row();

		$rs = $this->{$this->model}->GetInfoById($this->uri->segment(3));

		if ($rs['is_update_mode'] == 1 && $rs['is_update_mode_user'] != $this->session->userdata('id')) {
			// $rsUpdateUser = $this->user->GetInfoById($rs['is_update_mode_user']);
			// $update_user = $rsUpdateUser['user_firstname'].' '.$rsUpdateUser['user_lastname'];

			// $this->session->set_flashdata('error_notification', "il file selizionato è già utilizzato dall'utente: ".$update_user." e non può essere aperto. Grazie.");
			// redirect($this->redirect_url);
		}

		if ($this->input->post('submit')) {
			$rules = $this->{$this->model}->rules;
			$this->form_validation->set_rules($rules);

			if ($this->form_validation->run() == true) {
				if ($result = $this->{$this->model}->Update()) {
					$update_data = array(
						'is_update_mode' 						=>	'0',
						'is_update_mode_user' 			=>	'0',
					);

					$this->db->where('p_id', $this->input->post('pk_id'));
					$this->db->update('practices', $update_data);

					$this->session->set_flashdata('success_notification', 'Modifiche aggiornate correttamente.');
					redirect($this->redirect_url);
				} else {
					$this->session->set_flashdata('error_notification', 'Numero pratica già esistente.');
					redirect($this->redirect_url);
				}
			} else {
				$this->session->set_flashdata('error_notification', $this->update_error_msg);
				redirect($this->redirect_url);
			}
		} elseif ($this->input->post('cancel')) {
			$update_data = array(
				'is_update_mode' 						=>	'0',
				'is_update_mode_user' 			=>	'0',
			);

			$this->db->where('p_id', $this->input->post('pk_id'));
			$this->db->update('practices', $update_data);

			redirect($this->redirect_url);
		} else {
			$update_data = array(
				'is_update_mode' 						=>	'1',
				'is_update_mode_user' 			=>	$this->session->userdata('id'),
			);

			$this->db->where('p_id', $this->uri->segment(3));
			$this->db->update('practices', $update_data);

			$data['entry'] = $this->{$this->model}->GetInfoById($this->uri->segment(3));
			$data['contractors'] = $this->{$this->model}->GetContractors($this->uri->segment(3));
			$data['beneficiaries'] = $this->{$this->model}->GetBeneficiaries($this->uri->segment(3));
			$data['view'] = $this->addedit_view;
			$this->load->view('main', $data);
		}
	}

	function delete()
	{
		if ($result = $this->{$this->model}->Delete()) {
			$this->session->set_flashdata('success_notification', $this->delete_msg);
			redirect($this->redirect_url);
		} else {
			$this->session->set_flashdata('error_notification', $this->delete_error_msg);
			redirect($this->redirect_url);
		}
	}

	function view()
	{
		$data['title'] = $this->title;
		$data['Action'] = "View";
		$data['js'] = array("common.js");

		$data['entry'] = $this->{$this->model}->GetInfoById($this->uri->segment(3));
		$data['contractors'] = $this->{$this->model}->GetContractors($this->uri->segment(3));
		$data['beneficiaries'] = $this->{$this->model}->GetBeneficiaries($this->uri->segment(3));
		$data['view'] = $this->view_view;
		$this->load->view('main', $data);
	}

	function addbeneficiary($pid)
	{
		$data['rowno'] = $pid;
		echo $this->load->view('add-beneficiary-row', $data, true);
	}

	function addcontractor($pid)
	{
		$data['rowno'] = $pid;
		echo $this->load->view('add-contractor-row', $data, true);
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

	function duplicate()
	{
		if ($result = $this->{$this->model}->Duplicate($this->uri->segment(3))) {
			$this->session->set_flashdata('success_notification', "Bozza duplicata correttamente.");
			redirect($this->redirect_url);
		} else {
			$this->session->set_flashdata('error_notification', "Record could not be copied.");
			redirect($this->redirect_url);
		}
	}

	function generate_practice($pid)
	{
		$rsPractice = $this->{$this->model}->GetInfoById($pid);
		$contractors = $this->{$this->model}->GetContractors($pid);
		$beneficiaries = $this->{$this->model}->GetBeneficiaries($pid);

		$contractor_cnt = count($contractors);

		$m = 0;
		$contractor_name = '';
		$contractor_addr = '';
		$contractor_vat = '';

		foreach ($contractors as $b) {
			if ($m == 0) {
				$contractor_name = $b['pc_contractor_name'];
				$contractor_addr = $b['pc_contractor_address'];
				$contractor_vat  = $b['pc_contractor_vat_no'];
			} else {
				$contractor_name .= ' - ' . $b['pc_contractor_name'];
				$contractor_addr .= ' - ' . $b['pc_contractor_address'];
				$contractor_vat  .= ' - ' . $b['pc_contractor_vat_no'];
			}

			$m++;
		}

		$beneficiary_cnt = count($beneficiaries);

		$m = 0;
		$beneficiary_name = '';
		$beneficiary_addr = '';
		$beneficiary_vat = '';

		foreach ($beneficiaries as $b) {
			if ($m == 0) {
				$beneficiary_name = $b['pb_beneficiary_name'];
				$beneficiary_addr = $b['pb_beneficiary_address'];
				$beneficiary_vat = $b['pb_beneficiary_vat_no'];
			} else {
				$beneficiary_name .= ' - ' . $b['pb_beneficiary_name'];
				$beneficiary_addr .= ' - ' . $b['pb_beneficiary_address'];
				$beneficiary_vat .= ' - ' . $b['pb_beneficiary_vat_no'];
			}

			$m++;
		}

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->changeTheDefault(false);

		$pdf->setPrintHeader(false);
		$pdf->startPageGroup();
		$pdf->setPrintFooter(false);

		$pdf->SetFontSize(9);

		if ($this->system->protect_pdf == 1) {
			$pdf->SetProtection(array('modify', 'copy'), '', null, 0, null);
		}

		$pdf->SetMargins(0, 0, 0, true);
		//  below line comments makes effect
		$pdf->SetAutoPageBreak(false, 0);

		$pdf->AddPage('P', 'A4');

		if ($rsPractice['p_language'] == 'it') {
			$img_file1 = 'https://gestionale.istitutoelveticodigaranzia.ch/uploads/resources/front-it.jpg';
			$img_file2 = 'https://gestionale.istitutoelveticodigaranzia.ch/uploads/resources/back-it.jpg';

			$pdf->Image($img_file1, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);

			$pdf->SetFont('helvetica', 'BI', 12);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->MultiCell(210, 10, ($rsPractice['p_surety_no']), '0', 'L', 0, 0, '129', '25.3', true);

			if (count($contractors) == 1) {
				$pdf->SetFont('helvetica', 'B', 8);
				$pdf->MultiCell(210, 10, $contractor_name, '0', 'C', 0, 0, '0', 42.3, true);

				$pdf->SetFont('helvetica', 'B', 7.5);
				$pdf->MultiCell(110, 10, $contractor_addr, '0', 'L', 0, 0, '28.5', 49.7, true);

				$pdf->SetFont('helvetica', 'B', 8);
				$pdf->MultiCell(105, 10, $contractor_vat, '0', 'C', 0, 0, '100', 49.7, true);
			} elseif (count($contractors) == 2) {
				$pdf->SetFont('helvetica', 'B', 7.4);
				$pdf->MultiCell(210, 10, $contractor_name, '0', 'C', 0, 0, '0', 42.3, true);

				$pdf->SetFont('helvetica', 'B', 6.2);
				$pdf->MultiCell(95, 10, $contractor_addr, '0', 'L', 0, 0, '28.5', 49.7, true);

				$pdf->SetFont('helvetica', 'B', 6.4);
				$pdf->MultiCell(105, 10, $contractor_vat, '0', 'C', 0, 0, '100', 49.7, true);
			} elseif (count($contractors) == 3) {
				$pdf->SetFont('helvetica', 'B', 7);
				$pdf->MultiCell(210, 10, $contractor_name, '0', 'C', 0, 0, '0', 42.3, true);

				$pdf->SetFont('helvetica', 'B', 5.3);
				$pdf->MultiCell(95, 10, $contractor_addr, '0', 'L', 0, 0, '28.5', 49.5, true);

				$pdf->SetFont('helvetica', 'B', 5.5);
				$pdf->MultiCell(105, 10, $contractor_vat, '0', 'C', 0, 0, '97', 49.7, true);
			} else {
				$pdf->SetFont('helvetica', 'B', 5.4);
				$pdf->MultiCell(210, 10, $contractor_name, '0', 'C', 0, 0, '0', 42.8, true);

				$pdf->SetFont('helvetica', 'B', 5.2);
				$pdf->MultiCell(95, 10, $contractor_addr, '0', 'L', 0, 0, '28.5', 49.6, true);

				$pdf->SetFont('helvetica', 'B', 5.2);
				$pdf->MultiCell(105, 10, $contractor_vat, '0', 'C', 0, 0, '97', 50.1, true);
			}

			if (count($beneficiaries) == 1) {
				$pdf->SetFont('helvetica', 'B', 8);
				$pdf->MultiCell(210, 10, $beneficiary_name, '0', 'C', 0, 0, '0', '58', true);

				$pdf->SetFont('helvetica', 'B', 7.5);
				$pdf->MultiCell(110, 10, $beneficiary_addr, '0', 'L', 0, 0, '28.5', '65.3', true);

				$pdf->SetFont('helvetica', 'B', 8);
				$pdf->MultiCell(105, 10, $beneficiary_vat, '0', 'C', 0, 0, '100', '65.3', true);
			} elseif (count($beneficiaries) == 2) {
				$pdf->SetFont('helvetica', 'B', 7.4);
				$pdf->MultiCell(210, 10, $beneficiary_name, '0', 'C', 0, 0, '0', '58', true);

				$pdf->SetFont('helvetica', 'B', 6.2);
				$pdf->MultiCell(95, 10, $beneficiary_addr, '0', 'L', 0, 0, '28.5', '65.6', true);

				$pdf->SetFont('helvetica', 'B', 6.4);
				$pdf->MultiCell(105, 10, $beneficiary_vat, '0', 'C', 0, 0, '100', '65.5', true);
			} elseif (count($beneficiaries) == 3) {
				$pdf->SetFont('helvetica', 'B', 7);
				$pdf->MultiCell(210, 10, $beneficiary_name, '0', 'C', 0, 0, '0', '58', true);

				$pdf->SetFont('helvetica', 'B', 5.2);
				$pdf->MultiCell(90, 10, $beneficiary_addr, '0', 'L', 0, 0, '28.5', '65', true);

				$pdf->SetFont('helvetica', 'B', 5.2);
				$pdf->MultiCell(100, 10, $beneficiary_vat, '0', 'C', 0, 0, '97', '65.5', true);
			} else {
				$pdf->SetFont('helvetica', 'B', 5.4);
				$pdf->MultiCell(210, 10, $beneficiary_name, '0', 'C', 0, 0, '0', 58, true);

				$pdf->SetFont('helvetica', 'B', 5.2);
				$pdf->MultiCell(95, 10, $beneficiary_addr, '0', 'L', 0, 0, '28.5', 64.8, true);

				$pdf->SetFont('helvetica', 'B', 5.2);
				$pdf->MultiCell(48, 10, $beneficiary_vat, '0', 'C', 0, 0, '125', 64.8, true);
			}

			$pdf->SetFont('helvetica', '', 6.7);
			$pdf->writeHTMLCell(151, 210, '28.6', '74.5', $rsPractice['p_surety_object'], '0', '0', 0, true, '', true);

			$pdf->SetFont('helvetica', 'B', 7.5);
			$pdf->MultiCell(210, 10, $rsPractice['p_guaranteed_amount_currency'] . ' ' . number_format($rsPractice['p_guaranteed_amount'], 2, ',', '.') . ' (' . $rsPractice['p_guaranteed_amount_words'] . ')', '0', 'L', 0, 0, '54', '149.2', true);

			setlocale(LC_TIME, 'it_IT');
			$from_date = strftime("%d %B %Y", strtotime($rsPractice['p_from_date']));
			$to_date = strftime("%d %B %Y", strtotime($rsPractice['p_to_date']));
			$release_date = strftime("%d %B %Y", strtotime($rsPractice['p_release_date']));

			$pdf->SetFont('helvetica', 'B', 8);
			$pdf->MultiCell(50, 10, $from_date, '0', 'L', 0, 0, '39', '154.9', true);
			$pdf->MultiCell(50, 10, $to_date, '0', 'L', 0, 0, '77.8', '154.9', true);
			$pdf->MultiCell(50, 10, $release_date, '0', 'L', 0, 0, '146.5', '154.9', true);

			$pdf->SetFont('helvetica', 'B', 5.9);
			$pdf->MultiCell(50, 10, $rsPractice['p_receipt_amount_currency'] . ' ' . number_format($rsPractice['p_receipt_amount'], 2, ',', '.') . ' (' . $rsPractice['p_receipt_amount_words'] . ')', '0', 'L', 0, 0, '28.8', '221.4', true);
		} else {
			$img_file1 = 'https://gestionale.istitutoelveticodigaranzia.ch/uploads/resources/front-en.jpg';
			$img_file2 = 'https://gestionale.istitutoelveticodigaranzia.ch/uploads/resources/back-en.jpg';

			$pdf->Image($img_file1, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);

			$pdf->SetFont('helvetica', 'BI', 12);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->MultiCell(210, 10, ($rsPractice['p_surety_no']), '0', 'L', 0, 0, '129', '25.3', true);


			if (count($contractors) == 1) {
				$pdf->SetFont('helvetica', 'B', 8);
				$pdf->MultiCell(210, 10, $contractor_name, '0', 'C', 0, 0, '0', 42.3, true);

				$pdf->SetFont('helvetica', 'B', 7.5);
				$pdf->MultiCell(95, 10, $contractor_addr, '0', 'L', 0, 0, '28.5', 49.7, true);

				$pdf->SetFont('helvetica', 'B', 8);
				$pdf->MultiCell(105, 10, $contractor_vat, '0', 'C', 0, 0, '100', 49.7, true);
			} elseif (count($contractors) == 2) {
				$pdf->SetFont('helvetica', 'B', 7.4);
				$pdf->MultiCell(210, 10, $contractor_name, '0', 'C', 0, 0, '0', 42.3, true);

				$pdf->SetFont('helvetica', 'B', 6.2);
				$pdf->MultiCell(95, 10, $contractor_addr, '0', 'L', 0, 0, '28.5', 49.7, true);

				$pdf->SetFont('helvetica', 'B', 6.4);
				$pdf->MultiCell(105, 10, $contractor_vat, '0', 'C', 0, 0, '100', 49.7, true);
			} elseif (count($contractors) == 3) {
				$pdf->SetFont('helvetica', 'B', 7);
				$pdf->MultiCell(210, 10, $contractor_name, '0', 'C', 0, 0, '0', 42.3, true);

				$pdf->SetFont('helvetica', 'B', 5.3);
				$pdf->MultiCell(95, 10, $contractor_addr, '0', 'L', 0, 0, '28.5', 49.5, true);

				$pdf->SetFont('helvetica', 'B', 5.5);
				$pdf->MultiCell(105, 10, $contractor_vat, '0', 'C', 0, 0, '97', 49.7, true);
			} else {
				$pdf->SetFont('helvetica', 'B', 5.4);
				$pdf->MultiCell(210, 10, $contractor_name, '0', 'C', 0, 0, '0', 42.8, true);

				$pdf->SetFont('helvetica', 'B', 5.2);
				$pdf->MultiCell(95, 10, $contractor_addr, '0', 'L', 0, 0, '28.5', 49.6, true);

				$pdf->SetFont('helvetica', 'B', 5.2);
				$pdf->MultiCell(105, 10, $contractor_vat, '0', 'C', 0, 0, '97', 50.1, true);
			}

			if (count($beneficiaries) == 1) {
				$pdf->SetFont('helvetica', 'B', 8);
				$pdf->MultiCell(210, 10, $beneficiary_name, '0', 'C', 0, 0, '0', '58', true);

				$pdf->SetFont('helvetica', 'B', 7);
				$pdf->MultiCell(110, 10, $beneficiary_addr, '0', 'L', 0, 0, '28.5', '65.3', true);

				$pdf->SetFont('helvetica', 'B', 8);
				$pdf->MultiCell(105, 10, $beneficiary_vat, '0', 'C', 0, 0, '100', '65.3', true);
			} elseif (count($beneficiaries) == 2) {
				$pdf->SetFont('helvetica', 'B', 7.4);
				$pdf->MultiCell(210, 10, $beneficiary_name, '0', 'C', 0, 0, '0', '58', true);

				$pdf->SetFont('helvetica', 'B', 6);
				$pdf->MultiCell(100, 10, $beneficiary_addr, '0', 'L', 0, 0, '28.5', '65.6', true);

				$pdf->SetFont('helvetica', 'B', 6.4);
				$pdf->MultiCell(105, 10, $beneficiary_vat, '0', 'C', 0, 0, '100', '65.5', true);
			} elseif (count($beneficiaries) == 3) {
				$pdf->SetFont('helvetica', 'B', 7);
				$pdf->MultiCell(210, 10, $beneficiary_name, '0', 'C', 0, 0, '0', '58', true);

				$pdf->SetFont('helvetica', 'B', 5.3);
				$pdf->MultiCell(95, 10, $beneficiary_addr, '0', 'L', 0, 0, '28.5', '65.4', true);

				$pdf->SetFont('helvetica', 'B', 5.5);
				$pdf->MultiCell(105, 10, $beneficiary_vat, '0', 'C', 0, 0, '97', '65.5', true);
			} else {
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
			$pdf->MultiCell(210, 10, $rsPractice['p_guaranteed_amount_currency'] . ' ' . number_format($rsPractice['p_guaranteed_amount'], 2, ',', '.') . ' (' . $rsPractice['p_guaranteed_amount_words'] . ')', '0', 'L', 0, 0, '54.7', '149.2', true);

			setlocale(LC_TIME, 'en_GB');
			$from_date = strftime("%d %B %Y", strtotime($rsPractice['p_from_date']));
			$to_date = strftime("%d %B %Y", strtotime($rsPractice['p_to_date']));
			$release_date = strftime("%d %B %Y", strtotime($rsPractice['p_release_date']));

			$pdf->SetFont('helvetica', 'B', 8);
			$pdf->MultiCell(50, 10, strtolower($from_date), '0', 'L', 0, 0, '42.3', '154.9', true);
			$pdf->MultiCell(50, 10, strtolower($to_date), '0', 'L', 0, 0, '78.3', '154.9', true);
			$pdf->MultiCell(50, 10, strtolower($release_date), '0', 'L', 0, 0, '149.4', '154.9', true);

			$pdf->SetFont('helvetica', 'B', 5.9);
			$pdf->MultiCell(48, 10, $rsPractice['p_receipt_amount_currency'] . ' ' . number_format($rsPractice['p_receipt_amount'], 2, ',', '.') . ' (' . $rsPractice['p_receipt_amount_words'] . ')', '0', 'L', 0, 0, '29.5', '221.4', true);
		}

		$pdf->SetTextColor(0, 0, 0);

		$pdf->setPageMark();

		$pdf->SetMargins(0, 0, 0, true);
		$pdf->SetAutoPageBreak(false, 0);
		$pdf->AddPage('P', 'A4');

		$pdf->Image($img_file2, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);

		$pdf->Output(FCPATH . 'uploads/temp/' . $contractor_name . '.pdf', 'F');

		return $contractor_name;
	}

	function generate_appendice($pid)
	{

		$rsPractice = $this->{$this->model}->GetInfoById($pid);

		$pdf = new pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->changeTheDefault(false);

		$img_file_a = 'https://gestionale.istitutoelveticodigaranzia.ch/uploads/resources/appendix_PDF_Layout.jpg';

		/* get appendix data based on RIF code saved in DB */

		$elements = explode(',', $rsPractice['p_rif_code']);

		foreach ($elements as $key => $val) {

			$rsAppendix = $this->{$this->model}->GetInfoByAppxId($val);

			$c_html = $rsAppendix['oda'];
			$rif_codice = $rsAppendix['rif_codice'];
			$adf_no = $rsAppendix['adf_no'];


			$pdf->SetMargins(0, 32, 0, true);
			$pdf->setPrintHeader(true);

			$html_count = str_word_count($c_html);

			if ($html_count > 310) {
				$pdf->SetAutoPageBreak(true, 0);
			} else {
				$pdf->SetAutoPageBreak(false, 0);
			}
			$pdf->SetFont('helvetica', '', 8);

			// Add a page
			$pdf->AddPage('P', 'A4');

			$static_text = "Con la presente appendice, facente parte integrante, sostanziale ed inscindibile del suindicato atto di fidejussione, ad integrazione di quanto riportato nell'atto di fidejussione suindicato, si conviene quanto segue:";

			$pdf->SetFont('helvetica', '', 8);
			$pdf->setCellHeightRatio(1.5);

			$pdf->writeHTMLCell(151, 210, '28', '35', "<strong>COD. RIF:" . $rif_codice . "</strong>", 0, 0, 0, true, '', true);
			$pdf->writeHTMLCell(151, 210, '70', '40', "<strong>APPENDICE ALL'ATTO DI FIDEJUSSIONE N. " . strtoupper($adf_no) . "</strong>", 0, 0, 0, true, '', true);
			$pdf->writeHTMLCell(151, 210, '28', '47', $static_text, 0, 0, 0, true, '', true);

			$pdf->writeHTMLCell(151, 210, '85', '63', "<strong>OGGETTO DELL'APPENDICE:</strong>", 0, 0, 0, true, '', true);
			$pdf->writeHTMLCell(151, 210, '28', '70', $c_html, 0, 0, 0, true, '', true);
		}
		$time = time();
		$pdf->Output(FCPATH . 'uploads/temp/' . $time . '.pdf', 'F');
		return $time;
	}

	function generate_appendice_new($val)
	{

		$pdf = new pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->changeTheDefault(false);

		$rsAppendix = $this->{$this->model}->GetInfoByAppxId($val);

		$c_html = $rsAppendix['oda'];
		$rif_codice = $rsAppendix['rif_codice'];
		$adf_no = $rsAppendix['adf_no'];


		$pdf->SetMargins(0, 32, 0, true);
		$pdf->setPrintHeader(true);

		$html_count = str_word_count($c_html);

		if ($html_count > 310) {
			$pdf->SetAutoPageBreak(true, 80);
		} else {
			$pdf->SetAutoPageBreak(false, 0);
		}
		$pdf->SetFont('helvetica', '', 8);

		// Add a page
		$pdf->AddPage('P', 'A4');

		$static_text = "Con la presente appendice, facente parte integrante, sostanziale ed inscindibile del suindicato atto di fidejussione, ad integrazione di quanto riportato nell'atto di fidejussione suindicato, si conviene quanto segue:";

		$pdf->SetFont('helvetica', '', 8);
		$pdf->setCellHeightRatio(1.5);

		$pdf->writeHTMLCell(151, 210, '28', '35', "<strong>COD. RIF:" . $rif_codice . "</strong>", 0, 0, 0, true, '', true);
		$pdf->writeHTMLCell(151, 210, '70', '40', "<strong>APPENDICE ALL'ATTO DI FIDEJUSSIONE N. " . strtoupper($adf_no) . "</strong>", 0, 0, 0, true, '', true);
		$pdf->writeHTMLCell(151, 210, '28', '47', $static_text, 0, 0, 0, true, '', true);

		$pdf->writeHTMLCell(151, 210, '85', '63', "<strong>OGGETTO DELL'APPENDICE:</strong>", 0, 0, 0, true, '', true);
		$pdf->writeHTMLCell(151, 210, '28', '70', $c_html, 0, 0, 0, true, '', true);

		$time = time();
		$new_file = $time . "_" . $val;
		$pdf->Output(FCPATH . 'uploads/temp/' . $new_file . '.pdf', 'F');
		return $new_file . '.pdf';
	}

	function download($pid)
	{
		$path       = FCPATH . './uploads/temp/';
		$contractor_name = $this->generate_practice($pid);

		// check appendice exist or not
		$rsPractice = $this->{$this->model}->GetInfoById($pid);

		if (isset($rsPractice['p_rif_code']) && $rsPractice['p_rif_code'] != "") {

			//$appx_pdf = $this->generate_appendice($pid);

			$elements = explode(',', $rsPractice['p_rif_code']);

			foreach ($elements as $key => $val) {
				$appx_pdf[] = $this->generate_appendice_new($val);
			}

			$pdf_files  = array();

			// MERGER FILES
			$pdf = new PDFMerger;

			$p1 = $contractor_name . '.pdf';
			//$p2 = $appx_pdf.'.pdf';
			$c_files = array($p1);

			// Merge both array1 and array2
			$pdf_files = array_merge($c_files, $appx_pdf);

			if ($pdf_files) {
				foreach ($pdf_files as $file) {
					$pdf->addPDF($path . $file, 'all');
				}

				//$new_file = md5(time().rand(1,10)) .'.pdf';
				$new_file = 'Bozza-' . $contractor_name . '.pdf';
				$pdf->merge('file', $path . $new_file);
			} else {
				$new_file = '';
			}

			// REMOVE TEMPORARY FILES
			if ($pdf_files) {
				foreach ($pdf_files as $file) {
					@unlink($path . $file);
				}
			}

			$pdfFilePath =  $path . $new_file;

			if (file_exists($pdfFilePath)) {
				// Specify the content type as PDF
				header('Content-Type: application/pdf');

				// Set the Content-Disposition header to force download with the original file name
				header('Content-Disposition: attachment; filename="' . basename($pdfFilePath) . '"');
				ob_clean();
				flush();
				// Read and output the PDF file
				readfile($pdfFilePath);
				unlink($pdfFilePath);
				// Exit the script
				exit;
			}
		} else {
			$new_file = 'Bozza-' . $contractor_name . '.pdf';
			$pdfFilePath =  $path . $contractor_name . '.pdf';

			if (file_exists($pdfFilePath)) {
				// Specify the content type as PDF
				header('Content-Type: application/pdf');

				// Set the Content-Disposition header to force download with the original file name
				header('Content-Disposition: attachment; filename="' . basename($path . $new_file) . '"');
				ob_clean();
				flush();
				// Read and output the PDF file
				readfile($pdfFilePath);
				unlink($pdfFilePath);
				// Exit the script
				exit;
			}
		}

		//$pdf->Output(FCPATH.'uploads'.'/drafts/Draft - '.$this->input->post('pk_id').'.pdf', 'F');
		//$pdf->Output('Bozza-'.$contractor_name.'.pdf', 'I');
		// exit;
	}

	public function download_p($pid)
	{

		$path       = FCPATH . './uploads/';
		$pdf_files  = array();
		// MERGER FILES
		$pdf = new PDFMerger;

		$p1 = 'p1.pdf';
		$p2 = 'p2.pdf';
		$pdf_files = array($p1, $p2);

		if ($pdf_files) {
			foreach ($pdf_files as $file) {
				$pdf->addPDF($path . $file, 'all');
			}

			$new_file = md5(time() . rand(1, 10)) . '.pdf';
			$pdf->merge('file', $path . $new_file);
		} else {
			$new_file = '';
		}

		// REMOVE TEMPORARY FILES
		if ($pdf_files) {
			foreach ($pdf_files as $file) {
				@unlink($path . $file);
			}
		}
		$pdfFilePath =  $path . $new_file;

		if (file_exists($pdfFilePath)) {
			// Specify the content type as PDF
			header('Content-Type: application/pdf');

			// Set the Content-Disposition header to force download with the original file name
			header('Content-Disposition: attachment; filename="' . basename($pdfFilePath) . '"');
			ob_clean();
			flush();
			// Read and output the PDF file
			readfile($pdfFilePath);

			// Exit the script
			exit;
		}
	}

	function print($pid)
	{
		$this->load->model('Print_model', 'print');

		$rsPractice = $this->{$this->model}->GetInfoById($pid);
		$contractors = $this->{$this->model}->GetContractors($pid);
		$beneficiaries = $this->{$this->model}->GetBeneficiaries($pid);

		$contractor_cnt = count($contractors);

		$m = 0;
		$contractor_name = '';
		$contractor_addr = '';
		$contractor_vat = '';

		foreach ($contractors as $b) {
			if ($m == 0) {
				$contractor_name = $b['pc_contractor_name'];
				$contractor_addr = $b['pc_contractor_address'];
				$contractor_vat = $b['pc_contractor_vat_no'];
			} else {
				$contractor_name .= ' - ' . $b['pc_contractor_name'];
				$contractor_addr .= ' - ' . $b['pc_contractor_address'];
				$contractor_vat .= ' - ' . $b['pc_contractor_vat_no'];
			}

			$m++;
		}

		$beneficiary_cnt = count($beneficiaries);

		$m = 0;
		$beneficiary_name = '';
		$beneficiary_addr = '';
		$beneficiary_vat = '';

		foreach ($beneficiaries as $b) {
			if ($m == 0) {
				$beneficiary_name = $b['pb_beneficiary_name'];
				$beneficiary_addr = $b['pb_beneficiary_address'];
				$beneficiary_vat = $b['pb_beneficiary_vat_no'];
			} else {
				$beneficiary_name .= ' - ' . $b['pb_beneficiary_name'];
				$beneficiary_addr .= ' - ' . $b['pb_beneficiary_address'];
				$beneficiary_vat .= ' - ' . $b['pb_beneficiary_vat_no'];
			}

			$m++;
		}

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->changeTheDefault(false);
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

		if (count($contractors) == 1) {
			$rs2 = $this->print->GetParamValues('contractor_name_1');
			$pdf->SetFont('helvetica', $rs2['font_type'], $rs2['font_size']);
			$pdf->MultiCell($rs2['width'], 10, $contractor_name, '0', 'C', 0, 0, $rs2['x_coordinate'], $rs2['y_coordinate'], true);

			$rs3 = $this->print->GetParamValues('contractor_addr_1');
			$pdf->SetFont('helvetica', $rs3['font_type'], $rs3['font_size']);
			$pdf->MultiCell($rs3['width'], 10, $contractor_addr, '0', 'L', 0, 0, $rs3['x_coordinate'], $rs3['y_coordinate'], true);

			$rs4 = $this->print->GetParamValues('contractor_vat_1');
			$pdf->SetFont('helvetica', $rs4['font_type'], $rs4['font_size']);
			$pdf->MultiCell($rs4['width'], 10, $contractor_vat, '0', 'C', 0, 0, $rs4['x_coordinate'], $rs4['y_coordinate'], true);
		} elseif (count($contractors) == 2) {
			$rs2 = $this->print->GetParamValues('contractor_name_2');
			$pdf->SetFont('helvetica', $rs2['font_type'], $rs2['font_size']);
			$pdf->MultiCell($rs2['width'], 10, $contractor_name, '0', 'C', 0, 0, $rs2['x_coordinate'], $rs2['y_coordinate'], true);

			$rs3 = $this->print->GetParamValues('contractor_addr_2');
			$pdf->SetFont('helvetica', $rs3['font_type'], $rs3['font_size']);
			$pdf->MultiCell($rs3['width'], 10, $contractor_addr, '0', 'L', 0, 0, $rs3['x_coordinate'], $rs3['y_coordinate'], true);

			$rs4 = $this->print->GetParamValues('contractor_vat_2');
			$pdf->SetFont('helvetica', $rs4['font_type'], $rs4['font_size']);
			$pdf->MultiCell($rs4['width'], 10, $contractor_vat, '0', 'C', 0, 0, $rs4['x_coordinate'], $rs4['y_coordinate'], true);
		} elseif (count($contractors) == 3) {
			$rs2 = $this->print->GetParamValues('contractor_name_3');
			$pdf->SetFont('helvetica', $rs2['font_type'], $rs2['font_size']);
			$pdf->MultiCell($rs2['width'], 10, $contractor_name, '0', 'C', 0, 0, $rs2['x_coordinate'], $rs2['y_coordinate'], true);

			$rs3 = $this->print->GetParamValues('contractor_addr_3');
			$pdf->SetFont('helvetica', $rs3['font_type'], $rs3['font_size']);
			$pdf->MultiCell($rs3['width'], 10, $contractor_addr, '0', 'L', 0, 0, $rs3['x_coordinate'], $rs3['y_coordinate'], true);

			$rs4 = $this->print->GetParamValues('contractor_vat_3');
			$pdf->SetFont('helvetica', $rs4['font_type'], $rs4['font_size']);
			$pdf->MultiCell($rs4['width'], 10, $contractor_vat, '0', 'C', 0, 0, $rs4['x_coordinate'], $rs4['y_coordinate'], true);
		} else {
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

		if (count($beneficiaries) == 1) {
			$rs5 = $this->print->GetParamValues('beneficiary_name_1');
			$pdf->SetFont('helvetica', $rs5['font_type'], $rs5['font_size']);
			$pdf->MultiCell($rs5['width'], 10, $beneficiary_name, '0', 'C', 0, 0, $rs5['x_coordinate'], $rs5['y_coordinate'], true);

			$rs6 = $this->print->GetParamValues('beneficiary_addr_1');
			$pdf->SetFont('helvetica', $rs6['font_type'], $rs6['font_size']);
			$pdf->MultiCell($rs6['width'], 10, $beneficiary_addr, '0', 'L', 0, 0, $rs6['x_coordinate'], $rs6['y_coordinate'], true);

			$rs7 = $this->print->GetParamValues('beneficiary_vat_1');
			$pdf->SetFont('helvetica', $rs7['font_type'], $rs7['font_size']);
			$pdf->MultiCell($rs7['width'], 10, $beneficiary_vat, '0', 'C', 0, 0, $rs7['x_coordinate'], $rs7['y_coordinate'], true);
		} elseif (count($beneficiaries) == 2) {
			$rs5 = $this->print->GetParamValues('beneficiary_name_2');
			$pdf->SetFont('helvetica', $rs5['font_type'], $rs5['font_size']);
			$pdf->MultiCell($rs5['width'], 10, $beneficiary_name, '0', 'C', 0, 0, $rs5['x_coordinate'], $rs5['y_coordinate'], true);

			$rs6 = $this->print->GetParamValues('beneficiary_addr_2');
			$pdf->SetFont('helvetica', $rs6['font_type'], $rs6['font_size']);
			$pdf->MultiCell($rs6['width'], 10, $beneficiary_addr, '0', 'L', 0, 0, $rs6['x_coordinate'], $rs6['y_coordinate'], true);

			$rs7 = $this->print->GetParamValues('beneficiary_vat_2');
			$pdf->SetFont('helvetica', $rs7['font_type'], $rs7['font_size']);
			$pdf->MultiCell($rs7['width'], 10, $beneficiary_vat, '0', 'C', 0, 0, $rs7['x_coordinate'], $rs7['y_coordinate'], true);
		} elseif (count($beneficiaries) == 3) {
			$rs5 = $this->print->GetParamValues('beneficiary_name_3');
			$pdf->SetFont('helvetica', $rs5['font_type'], $rs5['font_size']);
			$pdf->MultiCell($rs5['width'], 10, $beneficiary_name, '0', 'C', 0, 0, $rs5['x_coordinate'], $rs5['y_coordinate'], true);

			$rs6 = $this->print->GetParamValues('beneficiary_addr_3');
			$pdf->SetFont('helvetica', $rs6['font_type'], $rs6['font_size']);
			$pdf->MultiCell($rs6['width'], 10, $beneficiary_addr, '0', 'L', 0, 0, $rs6['x_coordinate'], $rs6['y_coordinate'], true);

			$rs7 = $this->print->GetParamValues('beneficiary_vat_3');
			$pdf->SetFont('helvetica', $rs7['font_type'], $rs7['font_size']);
			$pdf->MultiCell($rs7['width'], 10, $beneficiary_vat, '0', 'C', 0, 0, $rs7['x_coordinate'], $rs7['y_coordinate'], true);
		} else {
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
		$pdf->MultiCell($rs9['width'], 10, $rsPractice['p_guaranteed_amount_currency'] . ' ' . number_format($rsPractice['p_guaranteed_amount'], 2, ',', '.') . ' (' . $rsPractice['p_guaranteed_amount_words'] . ')', '0', 'L', 0, 0, $rs9['x_coordinate'], $rs9['y_coordinate'], true);

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
		$pdf->MultiCell($rs13['width'], 10, $rsPractice['p_receipt_amount_currency'] . ' ' . number_format($rsPractice['p_receipt_amount'], 2, ',', '.') . ' (' . $rsPractice['p_receipt_amount_words'] . ')', '0', 'L', 0, 0, $rs13['x_coordinate'], $rs13['y_coordinate'], true);

		$pdf->Output('Stampa-' . $contractor_name . '.pdf', 'D');
		exit;
	}
}
