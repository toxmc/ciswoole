<?php
class HttpServer
{
	public $http;
	public static $instance;
	public static $server;
	
	/**
	 * 初始化
	 */
	private function __construct() {
		define('CISWOOLE', TRUE);
		$http = new swoole_http_server("0.0.0.0", 9501);
		$http->set (array(
			'worker_num' => 8,		//worker进程数量
			'daemonize' => false,	//守护进程设置成true
			'max_request' => 10000,	//最大请求次数，当请求大于它时，将会自动重启该worker
			'dispatch_mode' => 1 
		));
		$http->on('WorkerStart', array($this, 'onWorkerStart'));
		$http->on('request', array($this, 'onRequest'));
		$http->on('start', array($this, 'onStart'));
		$http->start();
	}
	
	/**
	 * server start的时候调用
	 * @param unknown $serv
	 */
	public function onStart($serv) {
		echo 'swoole version'.swoole_version().PHP_EOL;
	}
	/**
	 * worker start时调用
	 * @param unknown $serv
	 * @param int $worker_id
	 */
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
	
	/**
	 * 当request时调用
	 * @param unknown $request
	 * @param unknown $response
	 */
	public function onRequest($request, $response) {
		define('play', TRUE);
		$GLOBALS['REQUEST'] = $request;
		$GLOBALS['RESPONSE'] = $response;
		if (isset($request->header)) {
			$_SERVER['server_head'] = $request->header;
		}
		if (isset($request->get)) {
			$_GET = $request->get;
		}
		if (isset($request->post)) {
			$_POST = $request->post;
		}
		ob_start();
		try {
			$ciswoole = Httpindex::getInstance();
// 			include 'test.php';
			$result = ob_get_contents();
			ob_end_clean();
// 			var_dump($result);
// 			$response->status(301);
// 			$response->header("Location", "http://www.baidu.com/");
// 			$response->cookie("hello", "world", time() + 3600);
// 			$response->header("Content-Type", "text/html; charset=utf-8");
			$result = empty($result) ? '' : $result;
			$response->end($result);
			unset($result);
		} catch (Exception $e) {
			var_dump($e);
		}
	}
	
	public static function getInstance() {
		if (!self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
HttpServer::getInstance ();