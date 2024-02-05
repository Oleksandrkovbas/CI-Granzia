<?php

	class Dashboard extends MY_Controller {

		function __construct()
		{
			parent::__construct();
			$this->load->model('Dashboard_model', 'dashboard');
			$this->load->library('XLSXWriter');
			//$this->output->enable_profiler(TRUE);
		}

		function index()
		{
			$data['title'] = "Dashboard Admin";

			$data['view'] = config_item('view_path')."/dashboard";
			$this->load->view(config_item('view_path').'/main', $data);
		}

		function generate($user)
		{
			$rsUser = $this->user->GetInfoById($user);
			
			$filename = $rsUser['user_firstname']."_".$rsUser['user_lastname'].".xlsx";

			header('Content-disposition: attachment; filename="'.$filename).'"';
			header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
			header('Content-Transfer-Encoding: binary');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');

			$header = array(
			    'Numero Pratica'=>'string',
			    'Data Emissione'=>'string',
			    'QUIETANZA'=>'string',
			);

			$rsPractices = $this->dashboard->GetUserPractices($user);

			$data = [];

			foreach($rsPractices as $p)
			{
				$data[] = [$p['p_surety_no'], $this->functions->EntryDate($p['p_release_date']), '€ '.$p['p_receipt_amount']];
			}
			
			$writer = new XLSXWriter();
			$writer->writeSheetHeader('Sheet1', $header);
			
			foreach($data as $row)
				$writer->writeSheetRow('Sheet1', $row);

			$writer->writeToStdOut();
			
			exit(0);
		}
	}
?>
