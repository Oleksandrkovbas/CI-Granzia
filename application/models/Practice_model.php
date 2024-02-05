<?php

	class Practice_model extends CI_Model {

		function __construct()
		{
			parent::__construct();

			$this->table = 'practices';
			$this->table_contractor = 'practice_contractors';
			$this->table_beneficiary = 'practice_beneficiaries';
			
			$this->primary_key = 'p_id';

			$this->rules = array(
				'p_language' => array(
		            'field' => 'p_language',
		            'label' => 'Language',
		            'rules' => 'trim|required|xss_clean',
		        ),
				'p_surety_no' => array(
		            'field' => 'p_surety_no',
		            'label' => 'Surety No',
		            'rules' => 'trim|required|xss_clean',
		        ),
				'p_broker' => array(
		            'field' => 'p_broker',
		            'label' => 'Broker',
		            'rules' => 'trim|required|xss_clean',
		        ),
		        // 'p_contractor_name' => array(
		        //     'field' => 'p_contractor_name',
		        //     'label' => 'Contractor Name',
		        //     'rules' => 'trim|required|xss_clean',
		        // ),
				// 'p_contractor_address' => array(
		        //     'field' => 'p_contractor_address',
		        //     'label' => 'Contractor Address',
		        //     'rules' => 'trim|required|xss_clean',
		        // ),
		        // 'p_contractor_vat_no' => array(
		        //     'field' => 'p_contractor_vat_no',
		        //     'label' => 'Contractor VAT No',
		        //     'rules' => 'trim|required|xss_clean',
		        // ),
				// 'p_surety_object' => array(
		        //     'field' => 'p_surety_object',
		        //     'label' => 'Surety Object',
		        //     'rules' => 'trim|required|xss_clean',
		        // ),
				'p_guaranteed_amount_currency' => array(
		            'field' => 'p_guaranteed_amount_currency',
		            'label' => 'Guaranteed Amount Currency',
		            'rules' => 'trim|required|xss_clean',
		        ),
		        'p_guaranteed_amount' => array(
		            'field' => 'p_guaranteed_amount',
		            'label' => 'Guaranteed Amount',
		            'rules' => 'trim|required|xss_clean',
		        ),
		        'p_guaranteed_amount_words' => array(
		            'field' => 'p_guaranteed_amount_words',
		            'label' => 'Guaranteed Amount Words',
		            'rules' => 'trim|required|xss_clean',
		        ),
		        'p_from_date' => array(
		            'field' => 'p_from_date',
		            'label' => 'From Date',
		            'rules' => 'trim|required|xss_clean',
		        ),
		        'p_to_date' => array(
		            'field' => 'p_to_date',
		            'label' => 'To Date',
		            'rules' => 'trim|required|xss_clean',
		        ),
		        'p_release_date' => array(
		            'field' => 'p_release_date',
		            'label' => 'Release Date',
		            'rules' => 'trim|required|xss_clean',
		        ),
		        'p_receipt_amount_currency' => array(
		            'field' => 'p_receipt_amount_currency',
		            'label' => 'Receipt Amount Currency',
		            'rules' => 'trim|required|xss_clean',
		        ),
		        'p_receipt_amount' => array(
		            'field' => 'p_receipt_amount',
		            'label' => 'Receipt Amount',
		            'rules' => 'trim|required|xss_clean',
		        ),
		        'p_receipt_amount_words' => array(
		            'field' => 'p_receipt_amount_words',
		            'label' => 'Receipt Amount Words',
		            'rules' => 'trim|required|xss_clean',
		        ),
				// 'p_status' => array(
		        //     'field' => 'p_status',
		        //     'label' => 'Status',
		        //     'rules' => 'trim|required|xss_clean',
		        // ),
			);
		}

		function ViewAll()
		{
			$this->db->select('*');
			$this->db->order_by('updated_at', "desc");

			$query = $this->db->get($this->table);

			$arrResult = array();

			if($query->num_rows() > 0)
			{
				$arrResult = $query->result_array();
			}
			return $arrResult;
		}

		function ViewAllSearch()
		{
			if ($this->session->userdata('sel_filter_surety_no'))
		    {
		      	$this->db->where('p_surety_no', $this->session->userdata('sel_filter_surety_no'));
		    }
		    if ($this->session->userdata('sel_filter_contractor_name'))
		    {
		      	$this->db->like('pc_contractor_name', $this->session->userdata('sel_filter_contractor_name'));
		    }
			if ($this->session->userdata('sel_filter_broker'))
		    {
		      	$this->db->like('p_broker', $this->session->userdata('sel_filter_broker'));
		    }
			if ($this->session->userdata('sel_filter_object'))
		    {
		      	$this->db->like('p_surety_object', $this->session->userdata('sel_filter_object'),'both');
		    }
		    if ($this->session->userdata('sel_filter_contractor_vat_no'))
		    {
		      	$this->db->where('pc_contractor_vat_no', $this->session->userdata('sel_filter_contractor_vat_no'));
		    }
		    if ($this->session->userdata('sel_filter_beneficiary_name'))
		    {
		      	$this->db->like('pb_beneficiary_name', $this->session->userdata('sel_filter_beneficiary_name'));
		    }
		    if ($this->session->userdata('sel_filter_beneficiary_vat_no'))
		    {
		      	$this->db->where('pb_beneficiary_vat_no', $this->session->userdata('sel_filter_beneficiary_vat_no'));
		    }
		    if ($this->session->userdata('sel_filter_from_date') && $this->session->userdata('sel_filter_to_date'))
		    {
			    // "DATE_FORMAT(date,'%Y-%m-%d')
		    	$this->db->where('p_from_date >=', $this->functions->MySqlDate($this->session->userdata('sel_filter_from_date')));
		      	$this->db->where('p_from_date <=', $this->functions->MySqlDate($this->session->userdata('sel_filter_to_date')));
		    }
		    else
		    {
			    if ($this->session->userdata('sel_filter_from_date'))
			    {
			      	$this->db->where('p_from_date', $this->functions->MySqlDate($this->session->userdata('sel_filter_from_date')));
			    }
			    if ($this->session->userdata('sel_filter_to_date'))
			    {
			      	$this->db->where('p_to_date', $this->functions->MySqlDate($this->session->userdata('sel_filter_to_date')));
			    }
		    }
		    if ($this->session->userdata('sel_filter_release_date'))
		    {
		      	$this->db->where('p_release_date', $this->functions->MySqlDate($this->session->userdata('sel_filter_release_date')));
		    }
		    if ($this->session->userdata('sel_filter_guaranteed_amount'))
		    {
		      	$this->db->where('p_guaranteed_amount', $this->session->userdata('sel_filter_guaranteed_amount'));
		    }
		    if ($this->session->userdata('sel_filter_receipt_amount'))
		    {
		      	$this->db->where('p_receipt_amount', $this->session->userdata('sel_filter_receipt_amount'));
		    }
			
			if ($this->session->userdata('sel_filter_appenice'))
		    {
				$rif_code = $this->session->userdata('sel_filter_appenice');
				$where = "FIND_IN_SET('".$rif_code."', `p_rif_code`)";
		      	$this->db->where($where);
		    }

			$this->db->select('*');
			$this->db->join('practice_contractors', 'practices.p_id = practice_contractors.pc_p_id');
			$this->db->join('practice_beneficiaries', 'practices.p_id = practice_beneficiaries.pb_p_id');
			$this->db->group_by('pb_p_id');
			$this->db->order_by('updated_at', "desc");

			$query = $this->db->get($this->table);
			//echo $this->db->last_query();
			$arrResult = array();

			if($query->num_rows() > 0)
			{
				$arrResult = $query->result_array();
			}
			return $arrResult;
		}

		function GetInfoById($id)
		{
			$this->db->select('*');
			$this->db->where($this->primary_key, $id);
			$query = $this->db->get($this->table);

			if ($query->num_rows() == 1)
			{
				return $query->row_array();
			}
			else
			{
				return false;
			}
		}

		function GetContractors($p_id)
		{
			$this->db->select('*');
			$this->db->where('pc_p_id', $p_id);			
			$this->db->order_by("pc_id", "asc");
			$query = $this->db->get($this->table_contractor);

			$arrResult = array();

			if($query->num_rows() > 0)
			{
				$arrResult = $query->result_array();
			}
			return $arrResult;
		}

		function GetBeneficiaries($p_id)
		{
			$this->db->select('*');
			$this->db->where('pb_p_id', $p_id);			
			$this->db->order_by("pb_id", "asc");
			$query = $this->db->get($this->table_beneficiary);

			$arrResult = array();

			if($query->num_rows() > 0)
			{
				$arrResult = $query->result_array();
			}
			return $arrResult;
		}

		function GetContractorsForSearch($s)
		{
			$this->db->select('pc_contractor_name, pc_contractor_address, pc_contractor_vat_no');
			$this->db->like('pc_contractor_name', $s);
			$this->db->group_by("pc_contractor_name");
			$this->db->order_by('pc_contractor_name', "asc");

			$query = $this->db->get($this->table_contractor);

			$arrResult = array();

			if($query->num_rows() > 0)
			{
				$arrResult = $query->result_array();
			}
			return $arrResult;
		}

		function GetBeneficiariesForSearch($s)
		{
			$this->db->select('pb_beneficiary_name, pb_beneficiary_address, pb_beneficiary_vat_no');
			$this->db->like('pb_beneficiary_name', $s);
			$this->db->group_by("pb_beneficiary_name");
			$this->db->order_by('pb_beneficiary_name', "asc");

			$query = $this->db->get($this->table_beneficiary);

			$arrResult = array();

			if($query->num_rows() > 0)
			{
				$arrResult = $query->result_array();
			}
			return $arrResult;
		}

		function GetNotifications()
		{
			$reminder_date = date('Y-m-d', strtotime('today + '.$this->system->reminder_days.' days'));

			$this->db->select('*');
			$this->db->where("p_to_date >=", date('Y-m-d'));
			$this->db->where('p_to_date < ', $reminder_date);
			$this->db->where('p_status', '1');
			$this->db->order_by('p_to_date', "asc");
			$this->db->limit(5);

			$query = $this->db->get($this->table);

			$arrResult = array();

			if($query->num_rows() > 0)
			{
				$arrResult = $query->result_array();
			}

			return $arrResult;
		}

		function ViewAllExpiring()
		{
			$reminder_date = date('Y-m-d', strtotime('today + '.$this->system->reminder_days.' days'));

			$this->db->select('*');
			//$this->db->where("p_to_date >=", date('Y-m-d'));
			$this->db->where('p_to_date < ', $reminder_date);
			$this->db->where('p_status', '1');
			$this->db->order_by('p_to_date', "desc");

			$query = $this->db->get($this->table);

			$arrResult = array();

			if($query->num_rows() > 0)
			{
				$arrResult = $query->result_array();
			}

			return $arrResult;
		}

		function Duplicate($p_id)
		{
			$details = $this->GetInfoById($p_id);

			$data = array(
				'p_language' 					=>	$details['p_language'],
				'p_surety_no' 					=>	$details['p_surety_no'],
				'p_broker' 						=>	$details['p_broker'],
				// 'p_contractor_name' 			=>	$details['p_contractor_name'],
				// 'p_contractor_address' 			=>	$details['p_contractor_address'],
				// 'p_contractor_vat_no' 			=>	$details['p_contractor_vat_no'],
				'p_surety_object'				=>	$details['p_surety_object'],
				'p_guaranteed_amount_currency' 	=>	$details['p_guaranteed_amount_currency'],
				'p_guaranteed_amount' 			=>	$details['p_guaranteed_amount'],
				'p_guaranteed_amount_words' 	=>	$details['p_guaranteed_amount_words'],
				'p_from_date' 					=>	$details['p_from_date'],
				'p_to_date' 					=>	$details['p_to_date'],
				'p_release_date' 				=>	$details['p_release_date'],
				'p_receipt_amount_currency' 	=>	$details['p_receipt_amount_currency'],
				'p_receipt_amount' 				=>	$details['p_receipt_amount'],
				'p_receipt_amount_words' 		=>	$details['p_receipt_amount_words'],
				'p_status' 						=>	'0',
				// 'p_contractor_name_font_size' 		=>	$this->input->post('p_contractor_name_font_size'),
				// 'p_contractor_name_y_coordinate' 	=>	$this->input->post('p_contractor_name_y_coordinate'),
				// 'p_contractor_addr_font_size' 		=>	$this->input->post('p_contractor_addr_font_size'),
				// 'p_contractor_addr_y_coordinate' 	=>	$this->input->post('p_contractor_addr_y_coordinate'),
				// 'p_contractor_vat_font_size' 		=>	$this->input->post('p_contractor_vat_font_size'),
				// 'p_contractor_vat_y_coordinate' 	=>	$this->input->post('p_contractor_vat_y_coordinate'),
				// 'p_beneficiary_name_font_size' 		=>	$this->input->post('p_beneficiary_name_font_size'),
				// 'p_beneficiary_name_y_coordinate' 	=>	$this->input->post('p_beneficiary_name_y_coordinate'),
				// 'p_beneficiary_addr_font_size' 		=>	$this->input->post('p_beneficiary_addr_font_size'),
				// 'p_beneficiary_addr_y_coordinate' 	=>	$this->input->post('p_beneficiary_addr_y_coordinate'),
				// 'p_beneficiary_vat_font_size' 		=>	$this->input->post('p_beneficiary_vat_font_size'),
				// 'p_beneficiary_vat_y_coordinate' 	=>	$this->input->post('p_beneficiary_vat_y_coordinate'),
				'created_by' 					=>	$this->session->userdata('id'),
				'created_at' 					=>	date('Y-m-d H:i:s'),
				'updated_by' 					=>	$this->session->userdata('id'),
				'updated_at' 					=>	date('Y-m-d H:i:s'),
			);
			$this->db->insert($this->table, $data);
			$pk_id = $this->db->insert_id();

			# insert contractor details
			$contractors = $this->GetContractors($p_id);

			for($i=0; $i < count($contractors); $i++)
			{
				$data_contractor = array(
					'pc_p_id' 					=>	$pk_id,
					'pc_contractor_name'		=>	$contractors[$i]['pc_contractor_name'],
					'pc_contractor_address' 	=>	$contractors[$i]['pc_contractor_address'],
					'pc_contractor_vat_no' 		=>	$contractors[$i]['pc_contractor_vat_no'],
				);
				
				$this->db->insert($this->table_contractor, $data_contractor);	
			}

			# insert beneficiary details
			$beneficiaries = $this->GetBeneficiaries($p_id);

			for($i=0; $i < count($beneficiaries); $i++)
			{
				$data_beneficiary = array(
					'pb_p_id' 					=>	$pk_id,
					'pb_beneficiary_name'		=>	$beneficiaries[$i]['pb_beneficiary_name'],
					'pb_beneficiary_address' 	=>	$beneficiaries[$i]['pb_beneficiary_address'],
					'pb_beneficiary_vat_no' 	=>	$beneficiaries[$i]['pb_beneficiary_vat_no'],
				);
				
				$this->db->insert($this->table_beneficiary, $data_beneficiary);
			}

			return true;
		}

		function IsDuplicate($col, $val, $pk='')
		{
			$sql = "select * from ".$this->table . " where ".$col." = '".$val."' ";

			if(!empty($pk))
				$sql .= " AND ".$this->primary_key." != '".$pk."' ";

			$sql .= " AND p_status != 0 ";

			$rs = $this->db->query($sql);

			if ($rs->num_rows() > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		function Insert()
		{
			if(!$this->IsDuplicate('p_surety_no', $this->input->post('p_surety_no')))
			{
				if($this->input->post('submit') == 'Draft')
					$status = '0';
				else
					$status = '1';
					
				/* associate appendix with practice */
				if(!empty($_POST['appendix_rif'])){
					$p_rif_code = implode(",",$_POST['appendix_rif']);
				}
				else{
					$p_rif_code = "";
				}

				$data = array(
					'p_language' 					=>	$this->input->post('p_language'),
					'p_surety_no' 					=>	$this->input->post('p_surety_no'),
					'p_broker' 						=>	$this->input->post('p_broker'),
					// 'p_contractor_name' 			=>	($this->input->post('p_contractor_name')),
					// 'p_contractor_address' 			=>	($this->input->post('p_contractor_address')),
					// 'p_contractor_vat_no' 			=>	$this->input->post('p_contractor_vat_no'),
					'p_surety_object'				=>	$this->input->post('p_surety_object'),
					'p_guaranteed_amount_currency' 	=>	$this->input->post('p_guaranteed_amount_currency'),
					'p_guaranteed_amount' 			=>	$this->input->post('p_guaranteed_amount'),
					'p_guaranteed_amount_words' 	=>	$this->input->post('p_guaranteed_amount_words'),
					'p_from_date' 					=>	$this->functions->MySqlDate($this->input->post('p_from_date')),
					'p_to_date' 					=>	$this->functions->MySqlDate($this->input->post('p_to_date')),
					'p_release_date' 				=>	$this->functions->MySqlDate($this->input->post('p_release_date')),
					'p_receipt_amount_currency' 	=>	$this->input->post('p_receipt_amount_currency'),
					'p_receipt_amount' 				=>	$this->input->post('p_receipt_amount'),
					'p_receipt_amount_words' 		=>	$this->input->post('p_receipt_amount_words'),
					'p_status' 						=>	$status,
					'p_rif_code'                    =>  $p_rif_code,
					// 'p_contractor_name_font_size' 		=>	$this->input->post('p_contractor_name_font_size'),
					// 'p_contractor_name_y_coordinate' 	=>	$this->input->post('p_contractor_name_y_coordinate'),
					// 'p_contractor_addr_font_size' 		=>	$this->input->post('p_contractor_addr_font_size'),
					// 'p_contractor_addr_y_coordinate' 	=>	$this->input->post('p_contractor_addr_y_coordinate'),
					// 'p_contractor_vat_font_size' 		=>	$this->input->post('p_contractor_vat_font_size'),
					// 'p_contractor_vat_y_coordinate' 	=>	$this->input->post('p_contractor_vat_y_coordinate'),
					// 'p_beneficiary_name_font_size' 		=>	$this->input->post('p_beneficiary_name_font_size'),
					// 'p_beneficiary_name_y_coordinate' 	=>	$this->input->post('p_beneficiary_name_y_coordinate'),
					// 'p_beneficiary_addr_font_size' 		=>	$this->input->post('p_beneficiary_addr_font_size'),
					// 'p_beneficiary_addr_y_coordinate' 	=>	$this->input->post('p_beneficiary_addr_y_coordinate'),
					// 'p_beneficiary_vat_font_size' 		=>	$this->input->post('p_beneficiary_vat_font_size'),
					// 'p_beneficiary_vat_y_coordinate' 	=>	$this->input->post('p_beneficiary_vat_y_coordinate'),
					'created_by' 					=>	$this->session->userdata('id'),
					'created_at' 					=>	date('Y-m-d H:i:s'),
					'updated_by' 					=>	$this->session->userdata('id'),
					'updated_at' 					=>	date('Y-m-d H:i:s'),
				);
				$this->db->insert($this->table, $data);
				$pk_id = $this->db->insert_id();

				# insert contractor details
				for($i=0; $i < $_POST['contractor_count']; $i++)
				{
					if($_POST['pc_contractor_name'][$i] != '' && $_POST['pc_contractor_address'][$i] != '' && $_POST['pc_contractor_vat_no'][$i] != '')
					{
						$data_contractor = array(
							'pc_p_id' 					=>	$pk_id,
							'pc_contractor_name'		=>	($_POST['pc_contractor_name'][$i]),
							'pc_contractor_address' 	=>	($_POST['pc_contractor_address'][$i]),
							'pc_contractor_vat_no' 	=>	$_POST['pc_contractor_vat_no'][$i],
						);
						
						$this->db->insert($this->table_contractor, $data_contractor);	
					}
				}

				# insert beneficiary details
				for($i=0; $i < $_POST['beneficiary_count']; $i++)
				{
					if($_POST['pb_beneficiary_name'][$i] != '' && $_POST['pb_beneficiary_address'][$i] != '' && $_POST['pb_beneficiary_vat_no'][$i] != '')
					{
						$data_beneficiary = array(
							'pb_p_id' 					=>	$pk_id,
							'pb_beneficiary_name'		=>	($_POST['pb_beneficiary_name'][$i]),
							'pb_beneficiary_address' 	=>	($_POST['pb_beneficiary_address'][$i]),
							'pb_beneficiary_vat_no' 	=>	$_POST['pb_beneficiary_vat_no'][$i],
						);
						
						$this->db->insert($this->table_beneficiary, $data_beneficiary);	
					}
				}

				return $pk_id;
			}
			else
			{
				return false;
			}
		}

		function Update()
		{
			if(!$this->IsDuplicate('p_surety_no', $this->input->post('p_surety_no'), $this->input->post('pk_id')))
			{
				//echo "<pre>";print_r($_POST);
				if($this->input->post('submit') == 'Draft')
					$status = '0';
				else
					$status = '1';
					
				/* associate appendix with practice */
				if(!empty($_POST['appendix_rif'])){
					$p_rif_code = implode(",",$_POST['appendix_rif']);
				}
				else{
					$p_rif_code = "";
				}
				
				$data = array(
					'p_language' 					=>	$this->input->post('p_language'),
					'p_surety_no' 					=>	$this->input->post('p_surety_no'),
					'p_broker' 						=>	$this->input->post('p_broker'),
					// 'p_contractor_name' 			=>	($this->input->post('p_contractor_name')),
					// 'p_contractor_address' 			=>	($this->input->post('p_contractor_address')),
					// 'p_contractor_vat_no' 			=>	$this->input->post('p_contractor_vat_no'),
					'p_surety_object'				=>	$this->input->post('p_surety_object'),
					'p_guaranteed_amount_currency' 	=>	$this->input->post('p_guaranteed_amount_currency'),
					'p_guaranteed_amount' 			=>	$this->input->post('p_guaranteed_amount'),
					'p_guaranteed_amount_words' 	=>	$this->input->post('p_guaranteed_amount_words'),
					'p_from_date' 					=>	$this->functions->MySqlDate($this->input->post('p_from_date')),
					'p_to_date' 					=>	$this->functions->MySqlDate($this->input->post('p_to_date')),
					'p_release_date' 				=>	$this->functions->MySqlDate($this->input->post('p_release_date')),
					'p_receipt_amount_currency' 	=>	$this->input->post('p_receipt_amount_currency'),
					'p_receipt_amount' 				=>	$this->input->post('p_receipt_amount'),
					'p_receipt_amount_words' 		=>	$this->input->post('p_receipt_amount_words'),
					'p_status' 						=>	$status,
					'p_rif_code'                    =>  $p_rif_code,
					// 'p_contractor_name_font_size' 		=>	$this->input->post('p_contractor_name_font_size'),
					// 'p_contractor_name_y_coordinate' 	=>	$this->input->post('p_contractor_name_y_coordinate'),
					// 'p_contractor_addr_font_size' 		=>	$this->input->post('p_contractor_addr_font_size'),
					// 'p_contractor_addr_y_coordinate' 	=>	$this->input->post('p_contractor_addr_y_coordinate'),
					// 'p_contractor_vat_font_size' 		=>	$this->input->post('p_contractor_vat_font_size'),
					// 'p_contractor_vat_y_coordinate' 	=>	$this->input->post('p_contractor_vat_y_coordinate'),
					// 'p_beneficiary_name_font_size' 		=>	$this->input->post('p_beneficiary_name_font_size'),
					// 'p_beneficiary_name_y_coordinate' 	=>	$this->input->post('p_beneficiary_name_y_coordinate'),
					// 'p_beneficiary_addr_font_size' 		=>	$this->input->post('p_beneficiary_addr_font_size'),
					// 'p_beneficiary_addr_y_coordinate' 	=>	$this->input->post('p_beneficiary_addr_y_coordinate'),
					// 'p_beneficiary_vat_font_size' 		=>	$this->input->post('p_beneficiary_vat_font_size'),
					// 'p_beneficiary_vat_y_coordinate' 	=>	$this->input->post('p_beneficiary_vat_y_coordinate'),
					'updated_by' 					=>	$this->session->userdata('id'),
					'updated_at' 					=>	date('Y-m-d H:i:s'),
				);
				
				//echo "<pre>";print_r($data);exit;
				
				$this->db->where($this->primary_key, $this->input->post('pk_id'));
				$this->db->update($this->table, $data);

				# update contractor details
				$this->db->delete($this->table_contractor, array('pc_p_id' => $this->input->post('pk_id')));

				for($i=0; $i < $_POST['contractor_count']; $i++)
				{
					if($_POST['pc_contractor_name'][$i] != '' && $_POST['pc_contractor_address'][$i] != '' && $_POST['pc_contractor_vat_no'][$i] != '')
					{
						$data_contractor = array(
							'pc_p_id' 					=>	$this->input->post('pk_id'),
							'pc_contractor_name'		=>	($_POST['pc_contractor_name'][$i]),
							'pc_contractor_address' 	=>	($_POST['pc_contractor_address'][$i]),
							'pc_contractor_vat_no' 	=>	$_POST['pc_contractor_vat_no'][$i],
						);
						
						$this->db->insert($this->table_contractor, $data_contractor);	
					}
				}

				# update beneficiary details
				$this->db->delete($this->table_beneficiary, array('pb_p_id' => $this->input->post('pk_id')));

				for($i=0; $i < $_POST['beneficiary_count']; $i++)
				{
					if($_POST['pb_beneficiary_name'][$i] != '' && $_POST['pb_beneficiary_address'][$i] != '' && $_POST['pb_beneficiary_vat_no'][$i] != '')
					{
						$data_beneficiary = array(
							'pb_p_id' 					=>	$this->input->post('pk_id'),
							'pb_beneficiary_name'		=>	($_POST['pb_beneficiary_name'][$i]),
							'pb_beneficiary_address' 	=>	($_POST['pb_beneficiary_address'][$i]),
							'pb_beneficiary_vat_no' 	=>	$_POST['pb_beneficiary_vat_no'][$i],
						);
						
						$this->db->insert($this->table_beneficiary, $data_beneficiary);	
					}
				}

				return true;
			}
			else
			{
				return false;
			}
		}

		function Delete()
		{
			if($this->input->post('pk_id'))
			{
				# delete contractors
				$this->db->delete($this->table_contractor, array('pc_p_id' => $this->input->post('pk_id')));

				# delete beneficiaries
				$this->db->delete($this->table_beneficiary, array('pb_p_id' => $this->input->post('pk_id')));

				$this->db->delete($this->table, array($this->primary_key => $this->input->post('pk_id')));
				return true;
			}
			else
				return false;
		}
		function GetInfoByAppxId($rif_code){
			$this->db->select('*');
			$this->db->where('rif_codice', $rif_code);
			$query = $this->db->get("appendixes");

			if ($query->num_rows() == 1)
			{
				return $query->row_array();
			}
			else
			{
				return false;
			}
		}
		
	}
?>