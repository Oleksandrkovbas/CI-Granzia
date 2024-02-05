<?php
class Appendix extends User_Controller {

		function __construct()
		{
			parent::__construct();
			$this->load->model('Appendix_model', 'appendix');
			$this->load->model('User_model', 'user');
			$this->load->library('pdf');
			//$this->output->enable_profiler(TRUE);

			$this->title = 'Appendice';
			$this->list_title = 'Appendice List';
			$this->view_title = 'Appendice Details';
			$this->no_records = 'No record found.';
			$this->action_url = 'appendix';
			$this->add_url = 'appendix/insert';
			$this->edit_url = 'appendix/edit';
			$this->manage_view = 'appendix_manage';
			$this->addedit_view = 'appendix_addedit';
			$this->view_view = 'appendix_view';
			$this->redirect_url = 'appendix/index';
			$this->model = 'appendix';
			$this->insert_msg = 'Record inserted successfully.';
			$this->update_msg = 'Record updated successfully.';
			$this->delete_msg = 'Appendice rimossa correttamente.';
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
		function insert()
		{
			$data['title'] = $this->title;
			$data['Action'] = "Add";
			$data['js'] = array("common.js");
			
			/* get system api kye*/
			$this->db->where('config_name', 'editor_api_key');
			$data['api_data'] = $this->db->get('web_config')->row();
			
			if ($this->input->post('submit'))
			{
				$rules = $this->{$this->model}->rules;
				$this->form_validation->set_rules($rules);
				//echo $this->form_validation->run();exit;
				if ($this->form_validation->run() == true) {
					if($result = $this->{$this->model}->Insert())
					{ 
						
						if($this->input->post('submit') == 'Draft')
							$this->session->set_flashdata('success_notification', 'Bozza creata correttamente.');
						else
							$this->session->set_flashdata('success_notification', 'Appendice creata con correttamente.');

						redirect($this->redirect_url);
					}
					else
					{
						$this->session->set_flashdata('error_notification', 'Numero Appendice gia esistente.');
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

						$this->db->where('a_id', $this->input->post('ak_id'));
						$this->db->update('appendixes', $update_data);

						$this->session->set_flashdata('success_notification', 'Modifiche aggiornate correttamente.');
						redirect($this->redirect_url);
					}
					else
					{
						$this->session->set_flashdata('error_notification', 'Numero Appendice gia esistente.');
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

				$this->db->where('a_id', $this->input->post('ak_id'));
				$this->db->update('appendixes', $update_data);

				redirect($this->redirect_url);
			}
			else
			{
				$update_data = array(
					'is_update_mode' 						=>	'1',
					'is_update_mode_user' 			=>	$this->session->userdata('id'),
				);

				$this->db->where('a_id', $this->uri->segment(3));
				$this->db->update('appendixes', $update_data);

				$data['entry'] = $this->{$this->model}->GetInfoById($this->uri->segment(3));
				$data['view'] = $this->addedit_view;
				$this->load->view('main', $data);
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

			$data['entry'] = $this->{$this->model}->GetInfoById($this->uri->segment(3));
			$data['view'] = $this->view_view;
			//echo "<pre>";print_r($data);exit;
			$this->load->view('main', $data);
		}
		function download($aid)
		{
			$rsAppendix = $this->{$this->model}->GetInfoById($aid);
			
			$c_html = $rsAppendix['oda'];
			$rif_codice = $rsAppendix['rif_codice'];
			$adf_no = $rsAppendix['adf_no'];
			
			$pdf = new pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			
			$pdf->SetMargins(0, 32, 0, true);
			//$pdf->SetAutoPageBreak(TRUE, 82);
			$html_count = str_word_count($c_html);
			$pdf->setPrintHeader(true);
			if($html_count > 610){
				$pdf->SetAutoPageBreak(true, 80);
			}
			else{
				$pdf->SetAutoPageBreak(false, 0);
			}
			$pdf->SetFont('helvetica', '', 8);
			
			// Add a page
			$currentPage = $pdf->getPage();
			$currentX    = $pdf->GetX();
			$currentY    = $pdf->GetY();
			
			$pdf->AddPage('P','A4');
			
			$x     = $pdf->GetX();
			$start = $pdf->GetY();
			
			$static_text = "Con la presente appendice, facente parte integrante, sostanziale ed inscindibile del suindicato atto di fidejussione, ad integrazione di quanto riportato nell'atto di fidejussione suindicato, si conviene quanto segue:";
			
			$pdf->SetFont('helvetica', '', 8);
			$pdf->setCellHeightRatio(1.5);
			
			$pdf->writeHTMLCell(151, 210, '28', '35', "<strong>COD. RIF:".$rif_codice."</strong>", 0, 0, 0, true, '', true);
			$pdf->writeHTMLCell(151, 210, '70', '40', "<strong>APPENDICE ALL'ATTO DI FIDEJUSSIONE N. ".strtoupper($adf_no)."</strong>", 0, 0, 0, true, '', true);
			$pdf->writeHTMLCell(151, 210, '28', '47', $static_text, 0, 0, 0, true, '', true);
			
			$pdf->writeHTMLCell(151, 210, '85', '63', "<strong>OGGETTO DELL'APPENDICE:</strong>", 0, 0, 0, true, '', true);
			$pdf->writeHTMLCell(151, 210, '28', '70', $c_html, 0, 0, 0, true, '', true);
					
			$height = $pdf->GetY() - $start;
    
			if($currentPage==0){
				//$pdf->deletePage($pdf->getPage()+1);
			}
			// Output the PDF
			$time = time();
			$pdf->Output('Bozza_Appendice-'.$rif_codice.'.pdf', 'D');
			exit;
		}
		function print($aid)
		{
			$this->load->model('Print_model', 'print');
			
			$rsAppendix = $this->{$this->model}->GetInfoById($aid);
			
			$c_html = $rsAppendix['oda'];
			$rif_codice = $rsAppendix['rif_codice'];
			$adf_no = $rsAppendix['adf_no'];
			
			$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
			$pdf->setPrintHeader(false);
			  
			$pdf->startPageGroup();
			$pdf->setPrintFooter(false);
		
			$pdf->SetFontSize(8);
			
			$pdf->SetMargins(0, 12, 0, true);
			//$pdf->SetMargins(0, 0, 0, true);
			//$pdf->SetAutoPageBreak(false, 0);
			$pdf->SetAutoPageBreak(TRUE, 12);
			$pdf->AddPage('P', 'A4');
			
			$static_text = "Con la presente appendice, facente parte integrante, sostanziale ed inscindibile del suindicato atto di fidejussione, ad integrazione di quanto riportato nell'atto di fidejussione suindicato, si conviene quanto segue:";
			
			$pdf->SetFont('helvetica', '', 8);
			$pdf->setCellHeightRatio(1.5);
			
			$pdf->writeHTMLCell(151, 210, '12', '25', "<strong>COD. RIF:".$rif_codice."</strong>", 0, 0, 0, true, '', true);
			$pdf->writeHTMLCell(151, 210, '70', '28', "<strong>APPENDICE ALL'ATTO DI FIDEJUSSIONE N. ".strtoupper($adf_no)."</strong>", 0, 0, 0, true, '', true);
			$pdf->writeHTMLCell(180, 210, '18', '35', $static_text, 0, 0, 0, true, '', true);
			
			$pdf->writeHTMLCell(151, 210, '85', '48', "<strong>OGGETTO DELL'APPENDICE:</strong>", 0, 0, 0, true, '', true);
			$pdf->writeHTMLCell(180, 210, '18', '56', $c_html, 0, 0, 0, true, '', true);
			
			// Output the PDF
			$time = time();
  		    $pdf->Output('Stampa_Appendice-'.$rif_codice.'.pdf', 'D');
		    exit;
		}
		function duplicate()
		{
			if($result = $this->{$this->model}->Duplicate($this->uri->segment(3)))
			{
				$this->session->set_flashdata('success_notification', "Appendice duplicata correttamente.");
				redirect($this->redirect_url);
			}
			else
			{
				$this->session->set_flashdata('error_notification', "Record could not be copied.");
				redirect($this->redirect_url);
			}
		}
}