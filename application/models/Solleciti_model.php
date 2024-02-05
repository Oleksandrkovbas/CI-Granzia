<?php

class Solleciti_model extends CI_Model
{
	public $table = '';

	function __construct()
	{
		parent::__construct();
		$this->table = 'practices';
	}

	function getPracticesForAppendix()
	{
		$this->db->select('practices.p_id, appendixes.created_at, corrispe, p_guaranteed_amount, p_receipt_amount, pc_contractor_name, pb_beneficiary_name');
		//$this->db->select('*');
		$this->db->join('practices', 'practices.p_rif_code = appendixes.rif_codice');
		$this->db->join('practice_contractors', 'practices.p_id = practice_contractors.pc_p_id');
		$this->db->join('practice_beneficiaries', 'practices.p_id = practice_beneficiaries.pb_p_id');

		if ($this->session->userdata('p_surety_no') && strtolower($this->session->userdata('p_surety_no')) == 'bozza') {
			$this->db->where('LOWER(appendixes.status)', strtolower($this->session->userdata('p_surety_no')));
		} else {
			$this->db->where('LOWER(appendixes.status)', strtolower('emessa'));
		}
		if ($this->session->userdata('broker')) {
			$this->db->like('LOWER(practices.p_broker)', strtolower($this->session->userdata('broker')));
		}
		if ($this->session->userdata('p_from_date')) {
			$this->db->where('appendixes.created_at >=', $this->functions->MySqlDate($this->session->userdata('p_from_date')));
		}
		if ($this->session->userdata('p_to_date')) {
			$this->db->where('appendixes.created_at <=', $this->functions->MySqlDate($this->session->userdata('p_to_date')));
		}


		$query1 = $this->db->get('appendixes');



		$arrResult = array();
		if ($query1->num_rows() > 0) {
			$arrResult = $query1->result_array();
		}

		return $arrResult;
	}

	function export()
	{
		// find appendix based contractor first
		$appendic = $this->getPracticesForAppendix();
		if ($this->session->userdata('p_surety_no') && strtolower($this->session->userdata('p_surety_no')) == 'bozza') {
			$this->db->where('p_status', 0);
		} else {
			$this->db->where('p_status', 1);
		}
		if ($this->session->userdata('p_from_date')) {
			$this->db->where('p_release_date >=', $this->functions->MySqlDate($this->session->userdata('p_from_date')));
		}
		if ($this->session->userdata('p_to_date')) {
			$this->db->where('p_release_date <=', $this->functions->MySqlDate($this->session->userdata('p_to_date')));
		}
		if ($this->session->userdata('broker')) {
			$this->db->like('LOWER(p_broker)', strtolower($this->session->userdata('broker')));
		}

		// $this->db->select('*');
		$this->db->select('p_release_date, p_guaranteed_amount, p_receipt_amount, pc_contractor_name, pb_beneficiary_name, p_from_date, p_to_date');
		$this->db->join('practice_contractors', 'practices.p_id = practice_contractors.pc_p_id');
		$this->db->join('practice_beneficiaries', 'practices.p_id = practice_beneficiaries.pb_p_id');

		//$this->db->group_by('pb_p_id');
		$this->db->order_by('updated_at', "desc");

		$query = $this->db->get($this->table);
		$arrResult = array();

		if ($query->num_rows() > 0) {
			$arrResult = $query->result_array();
		}
		return array_merge($arrResult, $appendic);
	}
}
