<?php

/**
 * Extend core Controller classes example
 * @author xmc
 */

class Myct extends MY_Controller {
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function index()
	{
		$version = array('app'=>'ciswoole','version'=>'1.0');
		$this->format($version);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */