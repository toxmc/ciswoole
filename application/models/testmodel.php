<?php 
class Testmodel extends CI_Model {

   function __construct()
    {
        parent::__construct();
    }
	
	function get_last_ten()
    {
    	$query = $this->db->query("SELECT * FROM `test` limit 30");
    	return $query->result();
    }
}