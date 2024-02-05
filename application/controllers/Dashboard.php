<?php

	class Dashboard extends User_Controller {

		function __construct()
		{
			parent::__construct();
			$this->load->model('Dashboard_model', 'dashboard');
			$this->load->model('User_model', 'user');
		}

		function index()
		{
			$data['title'] = "Dashboard";

			$data['total_practices'] = $this->dashboard->GetTotalPractices();
			$data['total_draft_practices'] = $this->dashboard->GetTotalDraftPractices();
			$data['total_issued_practices'] = $this->dashboard->GetTotalIssuedPractices();
			$data['recent_practices'] = $this->dashboard->GetRecentPractices();

			$data['view'] = "dashboard";
			$this->load->view('main', $data);
		}
	}
?>
