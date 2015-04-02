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
		define('CISWOOLE', TRUE);
		$http = new swoole_http_server("0.0.0.0", 9501);
		$http->set (array(
			'worker_num' => 8,
			'daemonize' => false,
			'max_request' => 10000,
			'dispatch_mode' => 1 
		));
		$http->on('WorkerStart', array($this, 'onWorkerStart'));
		$http->on('request', array($this, 'onRequest'));
		$http->on('start', array($this, 'onStart'));
		$http->start();
	}
	
	public function onStart($serv) {
		echo 'swoole version'.swoole_version().PHP_EOL;
	}
	
	public function onWorkerStart($serv, $worker_id) {
		global $argv;
		if($worker_id >= $serv->setting['worker_num']) {
			swoole_set_process_name("php {$argv[0]}: task");
		} else {
			swoole_set_process_name("php {$argv[0]}: worker");
		}
		echo "WorkerStart: MasterPid={$serv->master_pid}|Manager_pid={$serv->manager_pid}|WorkerId={$serv->worker_id}|WorkerPid={$serv->worker_pid}\n";
		define('APPLICATION_PATH', dirname(__DIR__));
		include APPLICATION_PATH.'/httpindex.php';
	}
	
	public function onRequest($request, $response) {
		$GLOBALS['REQUEST'] = $request;
		$GLOBALS['RESPONSE'] = $response;
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
			$ciswoole = Httpindex::getInstance();
// 			include 'test.php';
		} catch (Exception $e) {
			var_dump($e);
		}
		$result = ob_get_contents();
		ob_end_clean();
// 		var_dump($result);
// 		$response->status(301);
// 		$response->header("Location", "http://www.baidu.com/");
// 		$response->cookie("hello", "world", time() + 3600);
// 		$response->header("Content-Type", "text/html; charset=utf-8");
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