<?php
$CI =& get_instance();
$CI->load->library('session');

function getDefaultRifNumer(){
	$ci =& get_instance();
	$ci->load->database();
	
	$ci->db->select_max("rif_codice");
	$ci->db->from("appendixes");
	$query	=	$ci->db->get();
	
	$sql = "SELECT Max(CAST(rif_codice as SIGNED)) as rif_codice FROM appendixes";
	$query = $ci->db->query($sql);
	//echo $ci->db->last_query();exit;
	//echo $query->num_rows();
	if($query->num_rows()>0){
		return $query->row();
	}
	else{
		return $query->num_rows();
	}
}
function getRIF()
{
	$ci =& get_instance();
	$ci->load->database();
	
	$ci->db->select("rif_codice");
	$ci->db->from("appendixes");
	$query	=	$ci->db->get();
	return $query->result_array();
}
function getPracticeData($rif_code){
	$ci =& get_instance();
	$ci->load->database();
	$sql = "SELECT * FROM `practices` WHERE FIND_IN_SET('".$rif_code."',`p_rif_code`);";
	$query = $ci->db->query($sql);
	return $query->row();
}
function checkRifExistInPractice($rif_code,$p_id){
	$ci =& get_instance();
	$ci->load->database();
	$sql = "SELECT * FROM `practices` WHERE FIND_IN_SET('".$rif_code."',`p_rif_code`) and p_id!=".$p_id;
	$query = $ci->db->query($sql);
	return $query->row();
}
function getPracticeContractor($p_id){
	$ci =& get_instance();
	$ci->load->database();
	$sql = "SELECT * FROM `practice_contractors` WHERE pc_p_id=".$p_id;
	$query = $ci->db->query($sql);
	return $query->row();
}
