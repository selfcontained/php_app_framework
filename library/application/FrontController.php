<?php
namespace Application;

class FrontController {

	protected static $instance;

	protected $handlers;

	//TODO: abstract this so it's not just a public property - useage is for handlers to expose data when needed
	public $data;

	protected $applicationRoot;

	public static function initialize($applicationRoot) {
		if(self::$instance != null) throw new Exception('FrontController has already been initialized');
		return self::$instance = new FrontController($applicationRoot);
	}

	protected function __construct($applicationRoot) {
		$this->applicationRoot = $applicationRoot;
	}

	public static function getInstance() {
		if(self::$instance == null) throw new Exception('FrontController not initialized');
		return self::$instance;
	}

	public function handler(Request\Handler\Base $obj) {
		$this->handlers[] = $obj;
		$obj->init();
		return $this;
	}

	public function dispatch() {
		//pre execute
		foreach($this->handlers AS $obj) {
			$obj->preExecute();
		}
		//execute
		foreach($this->handlers AS $obj) {
			$obj->execute();
		}
		//post execute
		foreach($this->handlers AS $obj) {
			$obj->postExecute();
		}
	}

	public function getApplicationRoot() {
		return $this->applicationRoot;
	}

	protected function enforceTrailingSlash($uri) {
		if(substr($uri, -1) != '/') {
			header('Location:'.$uri.'/',true,301);
			die();
		}
	}

}
