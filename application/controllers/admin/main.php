<?php

class Main extends CI_Controller {

	public function index()
	{
		echo "<h1>admin:ciswoole</h1>";
		$this->load->view('admin/main');
	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */