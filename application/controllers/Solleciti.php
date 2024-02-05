<?php

class Solleciti extends User_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Solleciti_model', 'solleciti');
		$this->load->model('Practice_model', 'practice');
		$this->load->model('User_model', 'user');

		$this->load->library('pdfsol');
		$this->load->library('session');

		$this->output->enable_profiler(TRUE);

		$this->model = 'solleciti';
	}

	function index()
	{
		//p_surety_no => p_surety_no
		//p_release_date => p_from_date and p_to_date
		//p_broker => broker
		$data['title'] = "Solleciti";

		if ($this->input->post('submit') == 'Export') {
			$this->session->set_userdata('p_surety_no', $this->input->post('p_surety_no'));
			$this->session->set_userdata('p_from_date', $this->input->post('p_from_date'));
			$this->session->set_userdata('p_to_date', $this->input->post('p_to_date'));
			$this->session->set_userdata('broker', $this->input->post('broker'));

			$format = "d/m/Y";
			$from_date  = \DateTime::createFromFormat($format, $this->session->userdata('p_from_date'));
			$to_date  = \DateTime::createFromFormat($format, $this->session->userdata('p_to_date'));			
			
			if ($from_date > $to_date) {
				$this->session->set_flashdata('error_notification', 'Ad oggi dovrebbe essere maggiore di dalla data.');
				redirect('Solleciti/index');
			}
			
			$data['query'] = $this->{$this->model}->export();

			
			$initArray = $data['query'];
			$temp = [];		
			$temp[0] = [
				'p_release_date' => '',
				'pc_contractor_name' => '',
				'pb_beneficiary_name' => '',
				'p_guaranteed_amount' => '',
				'p_receipt_amount' => '',
				'p_from_date' => '',
				'p_to_date' => '',
				'dal' => ''
			];

			foreach($initArray as $key => $item){	
				$dal = '';
				$dal = "Dal ".$item['p_from_date'].' al '.$item['p_to_date'];	
				
				if(
					(($temp[count($temp)-1])['p_release_date'] == $item['p_release_date']) &&
					(($temp[count($temp)-1])['p_guaranteed_amount'] == $item['p_guaranteed_amount']) &&
					(($temp[count($temp)-1])['p_receipt_amount'] == $item['p_receipt_amount'])&&
					($temp[count($temp)-1])['dal'] == $dal
				){			
					if(strpos(($temp[count($temp)-1])['pc_contractor_name'], $item['pc_contractor_name']) === false){
						$new_pc_contractor_name = ($temp[count($temp)-1])['pc_contractor_name']. ', ' . $item['pc_contractor_name'];
						($temp[count($temp)-1])['pc_contractor_name'] = $new_pc_contractor_name;
					}

					if(strpos(($temp[count($temp)-1])['pb_beneficiary_name'], $item['pb_beneficiary_name']) === false){						

						$new_pb_beneficiary_name = ($temp[count($temp)-1])['pb_beneficiary_name']. ', ' . $item['pb_beneficiary_name'];

						($temp[count($temp)-1])['pb_beneficiary_name'] = $new_pb_beneficiary_name;
					}			
										
				}else{
					unset($item["p_from_date"]);
					unset($item["p_to_date"]);
					$item['dal'] = $dal;
					array_push($temp, $item);
					
					
				}						
			}	

			unset($temp[0]);

			function compareByTimeStamp($time1, $time2) 
			{ 
				if (strtotime($time1['p_release_date']) < strtotime($time2['p_release_date'])) 
					return 1; 
				else if (strtotime($time1['p_release_date']) > strtotime($time2['p_release_date']))  
					return -1; 
				else
					return 0; 
			} 

			usort($temp, "compareByTimeStamp"); 
			
			$temp1 = [];
			foreach($temp as $key => $item){
				$str_arr = explode (",", $item['pb_beneficiary_name']);  
				sort($str_arr);
				$newName = implode(',', $str_arr);				
				$item['pb_beneficiary_name'] = $newName;
				array_push($temp1, $item);
			}
			$data['query'] = $temp1;	

			$file = $this->export($data, $this->input->post('broker'));
			$this->download($file);
		} else {
			$this->session->unset_userdata('p_surety_no');
			$this->session->unset_userdata('p_from_date');
			$this->session->unset_userdata('p_to_date');
			$this->session->unset_userdata('broker');
		}


		$data['view'] = "solleciti_view";
		$this->load->view('main', $data);
	}

	function export($data, $broker)
	{

		$pdf = new Pdfsol(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->changeTheDefault(true);
		$pdf->SetMargins(28, 20, 20, true);

		$pdf->SetFont('helvetica', '', 11);


		if (count($data['query']) > 5) {
			$pdf->SetAutoPageBreak(true, 20);
		} else {
			$pdf->SetAutoPageBreak(false, 0);
		}


		// Add a page
		$pdf->AddPage('P', 'A4');

		$static_text = "<p>da controlli amministrativi abbiamo verificato la permanenza in istruttoria delle
		sottoelencate pratica/e non perfezionate:</p><br/><br/>";

		$static_text2 = "<p>Vi invitiamo a contattare il contraente per sapere se a breve verrà/verranno perfezionate oppure per 
		quale motivazione non è avvenuto né avverrà il perfezionamento; <u><strong>in tale ultimo caso è per noi importante 
		conoscerne la motivazione in modo da tenerne conto per future richieste.</strong></u></p><br/>";

		$static_text3 = "<p>Nell’attendere vostra risposta alla presente comunicazione porgiamo,</p><br/>";

		$pdf->setCellHeightRatio(1.5);

		$pdf->writeHTML("<strong>Gentile Professionista,</strong>", true, false, false, false, '');
		$pdf->Ln();
		$pdf->writeHTML($static_text, true, false, false, false, '');


		$tableData = "<style>table {text-align:center; width:95%;} td{vertical-align:center;}</style><table nobr=\"false\" border=\"1\" cellpadding=\"1\" cellspacing=\"0\"><tbody>";
		foreach ($data['query'] as $key => $row) {
			
			$tableData .= "<tr nobr=\"true\">";
			$date = (isset($row['p_release_date'])) ? $row['p_release_date'] : $row['created_at'];

			$tableData .= "<td>" . date('d/m/Y', strtotime($date)) . "</td>";
			$tableData .= "<td>" . $row['pc_contractor_name'] . "</td>";
			$tableData .= "<td>" . $row['pb_beneficiary_name'] . "</td>";
			$tableData .= "<td>" . '&euro; ' . number_format($row['p_guaranteed_amount'], 2, ',', '.') . "</td>";
			$tableData .= "<td>" . '&euro; ' . number_format($row['p_receipt_amount'], 2, ',', '.') . "</td>";

			$tableData .= '</tr>';

			if ($pdf->checkPageBreak()) {
				//die('page break');
				$pdf->Ln();
			}
		}
		$tableData .= '</tbody></table>';

		$pdf->writeHTML($tableData, true, false, false, false, '');

		$pdf->Ln();
		$pdf->writeHTML($static_text2, true, false, false, true);

		$pdf->Ln();
		$pdf->writeHTML($static_text3, true, false, false, true);
		$pdf->writeHTML("<p>Distinti saluti</p>");




		$time = time();
		$broker = str_replace(' ', '-', $broker);
		$new_file = 'Solleciti_' . preg_replace('/[^A-Za-z0-9\-]/', '-', $broker);
		$pdf->Output(FCPATH . 'uploads/temp/' . $new_file . '.pdf', 'F');
		return FCPATH . 'uploads/temp/' . $new_file . '.pdf';
	}

	function  download($file)
	{
		if (file_exists($file)) {
			// Specify the content type as PDF
			header('Content-Type: application/pdf');

			// Set the Content-Disposition header to force download with the original file name
			header('Content-Disposition: attachment; filename="' . basename($file) . '"');
			ob_clean();
			flush();
			// Read and output the PDF file
			readfile($file);
			unlink($file);
			// Exit the script
			exit;
		}
	}
}
