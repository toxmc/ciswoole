<?php

class Httpindex
{
	static public  $httpdefined;
	private function __construct(){
		define('ENVIRONMENT', 'development');
		if (defined('ENVIRONMENT'))
		{
			switch (ENVIRONMENT)
			{
				case 'development':
					error_reporting(E_ALL);
					break;
		
				case 'testing':
				case 'production':
					error_reporting(0);
					break;
		
				default:
					exit('The application environment is not set correctly.');
			}
		}
		/*
		 *---------------------------------------------------------------
		* SYSTEM FOLDER NAME
		*---------------------------------------------------------------
		*/
		$system_path = 'system';
		/*
		 *---------------------------------------------------------------
		* APPLICATION FOLDER NAME
		*---------------------------------------------------------------
		*/
		$application_folder = 'application';
		/*
		 * ---------------------------------------------------------------
		*  Resolve the system path for increased reliability
		* ---------------------------------------------------------------
		*/
		// Set the current directory correctly for CLI requests
		if (defined('STDIN')) {
			chdir(dirname(__FILE__));
		}
		if (realpath($system_path) !== FALSE) {
			$system_path = realpath($system_path).'/';
		}
		// ensure there's a trailing slash
		$system_path = rtrim($system_path, '/').'/';
		// Is the system path correct?
		if ( ! is_dir($system_path)) {
			exit("Your system folder path does not appear to be set correctly. Please open the following file and correct this: ".pathinfo(__FILE__, PATHINFO_BASENAME));
		}
		/*
		 * -------------------------------------------------------------------
		*  Now that we know the path, set the main path constants
		* -------------------------------------------------------------------
		*/
		define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
		define('EXT', '.php');
		define('BASEPATH', str_replace("\\", "/", $system_path));
		define('FCPATH', str_replace(SELF, '', __FILE__));
		define('SYSDIR', trim(strrchr(trim(BASEPATH, '/'), '/'), '/'));
		
		if (is_dir($application_folder)) {
			define('APPPATH', $application_folder.'/');
		} else {
			if (!is_dir(BASEPATH.$application_folder.'/')) {
				exit("Your application folder path does not appear to be set correctly. Please open the following file and correct this: ".SELF);
			}
			define('APPPATH', BASEPATH.$application_folder.'/');
		}
	}
	
	public static function getInstance(){
		if (!self::$httpdefined) {
			$httpdefined = new self();
			self::$httpdefined = $httpdefined;
			/*
			 * --------------------------------------------------------------------
			* LOAD THE BOOTSTRAP FILE
			* --------------------------------------------------------------------
			* And away we go...
			*/
		}
		include BASEPATH.'core/CodeIgniter.php';
	}
	
	public function __destruct(){
		self::$httpdefined=false;
	}
}
/* End of file index.php */
/* Location: ./index.php */