<?php
class MY_Controller extends CI_Controller {

	/**
	 * MY_Controller Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function format($msg)
	{
		echo json_encode($msg);
	}

}