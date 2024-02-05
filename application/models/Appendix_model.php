<?php

class Appendix_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();

		$this->table = 'appendixes';

		$this->primary_key = 'a_id';

		$this->rules = array(
			'rif_codice' => array(
				'field' => 'rif_codice',
				'label' => 'RIF. Codice',
				'rules' => 'trim|required|xss_clean',
			),
			'adf_no' => array(
				'field' => 'adf_no',
				'label' => 'Atto di Fidejussione',
				'rules' => 'trim|required|xss_clean',
			),
			'corrispe' => array(
				'field' => 'corrispe',
				'label' => 'Corrispettivo',
				'rules' => 'trim|required|xss_clean',
			),
			'oda' => array(
				'field' => 'oda',
				'label' => 'Oggetto dell Appendice',
				'rules' => 'trim|required',
			),
			'expiration' => array(
				'field' => 'expiration',
				'label' => 'Scadenza',
				'rules' => 'trim|required|xss_clean',
			),
		);
	}

	function ViewAll()
	{
		$this->db->select('*');
		$this->db->order_by('updated_at', "desc");

		$query = $this->db->get($this->table);

		$arrResult = array();

		if ($query->num_rows() > 0) {
			$arrResult = $query->result_array();
		}
		return $arrResult;
	}

	function ViewAllSearch()
	{
		if ($this->session->userdata('sel_filter_surety_no')) {
			$this->db->where('p_surety_no', $this->session->userdata('sel_filter_surety_no'));
		}
		if ($this->session->userdata('sel_filter_contractor_name')) {
			$this->db->like('pc_contractor_name', $this->session->userdata('sel_filter_contractor_name'));
		}
		if ($this->session->userdata('sel_filter_broker')) {
			$this->db->like('p_broker', $this->session->userdata('sel_filter_broker'));
		}
		if ($this->session->userdata('sel_filter_object')) {
			$this->db->like('p_surety_object', $this->session->userdata('sel_filter_object'), 'both');
		}
		if ($this->session->userdata('sel_filter_contractor_vat_no')) {
			$this->db->where('pc_contractor_vat_no', $this->session->userdata('sel_filter_contractor_vat_no'));
		}
		if ($this->session->userdata('sel_filter_beneficiary_name')) {
			$this->db->like('pb_beneficiary_name', $this->session->userdata('sel_filter_beneficiary_name'));
		}
		if ($this->session->userdata('sel_filter_beneficiary_vat_no')) {
			$this->db->where('pb_beneficiary_vat_no', $this->session->userdata('sel_filter_beneficiary_vat_no'));
		}
		if ($this->session->userdata('sel_filter_from_date') && $this->session->userdata('sel_filter_to_date')) {
			// "DATE_FORMAT(date,'%Y-%m-%d')
			$this->db->where('p_from_date >=', $this->functions->MySqlDate($this->session->userdata('sel_filter_from_date')));
			$this->db->where('p_from_date <=', $this->functions->MySqlDate($this->session->userdata('sel_filter_to_date')));
		} else {
			if ($this->session->userdata('sel_filter_from_date')) {
				$this->db->where('p_from_date', $this->functions->MySqlDate($this->session->userdata('sel_filter_from_date')));
			}
			if ($this->session->userdata('sel_filter_to_date')) {
				$this->db->where('p_to_date', $this->functions->MySqlDate($this->session->userdata('sel_filter_to_date')));
			}
		}
		if ($this->session->userdata('sel_filter_release_date')) {
			$this->db->where('p_release_date', $this->functions->MySqlDate($this->session->userdata('sel_filter_release_date')));
		}
		if ($this->session->userdata('sel_filter_guaranteed_amount')) {
			$this->db->where('p_guaranteed_amount', $this->session->userdata('sel_filter_guaranteed_amount'));
		}
		if ($this->session->userdata('sel_filter_receipt_amount')) {
			$this->db->where('p_receipt_amount', $this->session->userdata('sel_filter_receipt_amount'));
		}

		$this->db->select('*');
		$this->db->join('practice_contractors', 'practices.p_id = practice_contractors.pc_p_id');
		$this->db->join('practice_beneficiaries', 'practices.p_id = practice_beneficiaries.pb_p_id');
		$this->db->group_by('pb_p_id');
		$this->db->order_by('updated_at', "desc");

		$query = $this->db->get($this->table);
		//echo $this->db->last_query();
		$arrResult = array();

		if ($query->num_rows() > 0) {
			$arrResult = $query->result_array();
		}
		return $arrResult;
	}

	function GetInfoById($id)
	{
		$this->db->select('*');
		$this->db->where($this->primary_key, $id);
		$query = $this->db->get($this->table);

		if ($query->num_rows() == 1) {
			return $query->row_array();
		} else {
			return false;
		}
	}



	function ViewAllExpiring()
	{
		$reminder_date = date('Y-m-d', strtotime('today + ' . $this->system->reminder_days . ' days'));

		$this->db->select('*');
		//$this->db->where("p_to_date >=", date('Y-m-d'));
		$this->db->where('p_to_date < ', $reminder_date);
		$this->db->where('p_status', '1');
		$this->db->order_by('p_to_date', "desc");

		$query = $this->db->get($this->table);

		$arrResult = array();

		if ($query->num_rows() > 0) {
			$arrResult = $query->result_array();
		}

		return $arrResult;
	}

	function Duplicate($a_id)
	{
		$details = $this->GetInfoById($a_id);

		$rs_order_default = getDefaultRifNumer();


		if ($rs_order_default->rif_codice == "") {
			$default_rif_codice = '01';
		} else {
			$default_rif_codice = ++$rs_order_default->rif_codice;
			// $default_rif_codice = $details['rif_codice'];
		}

		// Remove any currency symbols and whitespace
		$inputValue = preg_replace("/[^\d.,]/", "", $details['corrispe']);

		// Replace the comma with a dot for proper float formatting
		//$formattedValue = str_replace(",", ".", $inputValue);

		$data = array(
			'a_language' 				=>	'it',
			'rif_codice' 				=>	$default_rif_codice,
			'adf_no' 					=>	$details['adf_no'],
			'oda'						=>	$details['oda'],
			'currency_symbol'			=>	$details['currency_symbol'],
			'corrispe'					=>	$inputValue,
			'a_status' 					=>	0,
			'created_by' 				=>	$this->session->userdata('id'),
			'created_at' 				=>	date('Y-m-d H:i:s'),
			'updated_by' 				=>	$this->session->userdata('id'),
			'updated_at' 				=>	date('Y-m-d H:i:s'),
			'status'					=> $details['status'],
			'expiration'				=> $details['expiration']
		);

		$this->db->insert($this->table, $data);
		return true;
	}

	function IsDuplicate($col, $val, $pk = '')
	{
		$sql = "select * from " . $this->table . " where " . $col . " = '" . $val . "' ";

		if (!empty($pk))
			$sql .= " AND " . $this->primary_key . " != '" . $pk . "' ";

		$sql .= " AND a_status != 0 ";

		$rs = $this->db->query($sql);

		if ($rs->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	function Insert()
	{
		if (!$this->IsDuplicate('rif_codice', $this->input->post('rif_codice'))) {
			if ($this->input->post('submit') == 'Draft')
				$status = '0';
			else
				$status = '1';


			$rs_order_default = getDefaultRifNumer();
			//echo "<pre>";print_r($rs_order_default);
			//echo "<pre>";print_r($this->input->post());

			if ($rs_order_default->rif_codice == "") {
				$default_rif_codice = '01';
			} else {
				//$default_rif_codice=++$rs_order_default->rif_codice;
				$default_rif_codice = $this->input->post('rif_codice');
			}

			// Remove any currency symbols and whitespace
			$inputValue = preg_replace("/[^\d.,]/", "", $this->input->post('corrispe'));

			// Replace the comma with a dot for proper float formatting
			//$formattedValue = str_replace(",", ".", $inputValue);

			$data = array(
				'a_language' 				=>	'it',
				'rif_codice' 				=>	$default_rif_codice,
				'adf_no' 					=>	$this->input->post('adf_no'),
				'oda'						=>	$this->input->post('oda'),
				'currency_symbol'			=>	$this->input->post('currency_symbol'),
				'corrispe'					=>	$inputValue,
				'a_status' 					=>	$status,
				'created_by' 				=>	$this->session->userdata('id'),
				'created_at' 				=>	date('Y-m-d H:i:s'),
				'updated_by' 				=>	$this->session->userdata('id'),
				'updated_at' 				=>	date('Y-m-d H:i:s'),
				'status' 					=>	$this->input->post('status'),
				'expiration'				=>  $this->functions->MySqlDate($this->input->post('expiration'))
			);
			$this->db->insert($this->table, $data);
			//echo $this->db->last_query();exit;
			$ak_id = $this->db->insert_id();
			return $ak_id;
		} else {
			return false;
		}
	}

	function Update()
	{
		if (!$this->IsDuplicate('rif_codice', $this->input->post('rif_codice'), $this->input->post('ak_id'))) {
			if ($this->input->post('submit') == 'Draft')
				$status = '0';
			else
				$status = '1';


			// Remove any currency symbols and whitespace
			$inputValue = preg_replace("/[^\d.,]/", "", $this->input->post('corrispe'));

			// Replace the comma with a dot for proper float formatting
			//$formattedValue = str_replace(",", ".", $inputValue);

			$data = array(
				'a_language' 				=>	'it',
				'rif_codice' 				=>	$this->input->post('rif_codice'),
				'adf_no' 					=>	$this->input->post('adf_no'),
				'oda'						=>	$this->input->post('oda'),
				'currency_symbol'			=>	$this->input->post('currency_symbol'),
				'corrispe'					=>	$inputValue,
				'a_status' 					=>	$status,
				'created_by' 				=>	$this->session->userdata('id'),
				'created_at' 				=>	date('Y-m-d H:i:s'),
				'updated_by' 				=>	$this->session->userdata('id'),
				'updated_at' 				=>	date('Y-m-d H:i:s'),
				'status' 					=>	$this->input->post('status'),
				'expiration'				=>  $this->functions->MySqlDate($this->input->post('expiration'))
			);
			//echo "<pre>";print_r($data);

			$this->db->where($this->primary_key, $this->input->post('ak_id'));
			$this->db->update($this->table, $data);
			//echo $this->db->last_query();exit;
			return true;
		} else {
			return false;
		}
	}

	function Delete()
	{
		if ($this->input->post('ak_id')) {
			$this->db->delete($this->table, array($this->primary_key => $this->input->post('ak_id')));
			return true;
		} else
			return false;
	}
}
