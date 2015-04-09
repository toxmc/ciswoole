<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct(){
		parent::__construct();
		$this->load->library('My_Session');
		$this->mysession = new My_Session();
		$this->mysession->start();
	}
	public function index()
	{
		show_error('a php error' , 500 , 'An Error Was Encountered');
	}
	public function test_echo()
	{
		echo 'im test echo';
	}
	public function set_session()
	{
		$_SESSION['name'] = 'xmc';
		var_dump($_SESSION);
		$this->mysession->save();
	}
	public function get_session()
	{
// 		$_SESSION['name'] = 'xmc';
		var_dump($_SESSION['name']);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */