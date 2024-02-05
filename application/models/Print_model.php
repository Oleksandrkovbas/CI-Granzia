<?php

	class Print_model extends CI_Model {

		function __construct()
		{
			parent::__construct();
		}

		function GetParamValues($param)
		{
			return $this->db->from("print_config")->where("parameter", $param)->get()->row_array();
		}
	}
?>
