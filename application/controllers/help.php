<?php

class Help extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('common');
	}
	
	public function index($id) {
		if (checkId($id)) {
			echo 'id='.$id;
		} else {
			echo 'value='.$id.', isn\'t id';
		}
	}
}

/* End of file help.php */
/* Location: ./application/controllers/help.php */