<?php

	class System {

		function __construct()
		{
			$this->obj =& get_instance();
			$this->get_config();
		}

		function get_config()
		{
			$query = $this->obj->db->get('web_config');

			foreach ($query->result() as $row)
			{
				$var = $row->config_name;
				$this->$var = $row->config_value;
			}
		}
	}
?>
