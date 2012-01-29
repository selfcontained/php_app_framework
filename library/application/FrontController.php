<?php
namespace Application;

class FrontController {

	protected static $instance;

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

	public function dispatch(\Routing\Manager $routeManager, $uri) {
		// $this->enforceTrailingSlash($uri);
		$route = $routeManager->getMatch($uri);
		if($route != null) {
			$route->getHandler()->dispatch($route->getParams());
		}else {
			throw new \Exception('No Route found for: ' . $uri);
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
