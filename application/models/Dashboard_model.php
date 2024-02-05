<?php

	class Dashboard_model extends CI_Model {

		function __construct()
		{
			parent::__construct();
		}

		function GetTotalPractices()
		{
			return $this->db->where('updated_by', $this->session->userdata('id'))->from("practices")->count_all_results();
		}

		function GetTotalDraftPractices()
		{
			return $this->db->where('p_status', 0)->where('updated_by', $this->session->userdata('id'))->from("practices")->count_all_results();
		}

		function GetTotalIssuedPractices()
		{
			return $this->db->where('p_status', 1)->where('updated_by', $this->session->userdata('id'))->from("practices")->count_all_results();
		}

		function GetRecentPractices()
		{
			//return $this->db->from("practices")->order_by("updated_at", 'desc')->limit(10)->get()->result_array();
			$this->db->select('*');
			$this->db->order_by('updated_at', "desc");

			$query = $this->db->get("practices");

			$arrResult = array();

			if($query->num_rows() > 0)
			{
				$arrResult = $query->result_array();
			}
			//echo $this->db->last_query();exit;
			return $arrResult;
		}

		function GetPracticesForUser($user, $status='all')
		{
			if($status == 'all')
				return $this->db->where('updated_by', $user)->from("practices")->count_all_results();
			else
				return $this->db->where('p_status', $status)->where('updated_by', $user)->from("practices")->count_all_results();
		}

		function GetUserPractices($user)
		{
			return $this->db->from("practices")->where('updated_by', $user)->order_by("updated_by", 'DESC')->limit(10)->get()->result_array();
		}
	}
?>
