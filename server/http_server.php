<?php
class HttpServer
{
	public $http;
	public static $instance;
	public static $get;
	public static $post;
	public static $header;
	public static $server;
	
	private function __construct() {
		$http = new swoole_http_server("0.0.0.0", 9501);
		$http->set (array(
				'worker_num' => 2,
				'daemonize' => false,
				'max_request' => 10000,
				'dispatch_mode' => 1 
		));
		$http->on('WorkerStart', array($this,'onWorkerStart'));
		$http->on('request', array($this,'onRequest'));
		$http->start();
	}
	
	public function onWorkerStart() {
		define('APPLICATION_PATH', dirname(__DIR__));
		include APPLICATION_PATH.'/httpindex.php';
	}
	public function onRequest($request, $response) {
			$GLOBALS['RESOUCE'] = $response;
			if (isset($request->server)) {
				HttpServer::$server = $request->server;
				$_SERVER['http_server'] = HttpServer::$server;
// 				var_dump($_SERVER['http_server']);
			}
			if (isset($request->header)) {
				HttpServer::$header = $request->header;
				$_SERVER['server_head'] = HttpServer::$header;
			}
			if (isset($request->get)) {
				HttpServer::$get = $request->get;
				$_GET = HttpServer::$get;
			}
			if (isset($request->post)) {
				HttpServer::$post = $request->post;
				$_POST = HttpServer::$post;
			}

			ob_start();
			try {
				Httpindex::getInstance();
// 				include 'test.php';
			} catch (Exception $e) {
				var_dump($e);
			}
			$result = ob_get_contents();
			ob_end_clean();
// 			var_dump($result);
// 			$response->status(301);
// 		   $response->header("Location", "http://www.baidu.com/");
// 			$response->cookie("hello", "world", time() + 3600);
// 		   $response->header("Content-Type", "text/html; charset=utf-8");
			$result = empty($result) ? '' : $result;
			$response->end($result);
			unset($result);
	}
	
	public static function getInstance() {
		if (!self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
HttpServer::getInstance ();