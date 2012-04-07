<?php
namespace Routing;

use \Application\Request\Handler\Base;

class Manager extends Base {

	protected $routes;

	protected $matchedRoute;

	public function __construct($routes) {
		if(is_string($routes)) {
			$routes = $this->loadRouteConfig($routes);
		}

		foreach($routes AS $pattern => $config) {
			$route = is_object($config) && get_class($config) == 'Routing\Route' ? $config : null;

			if(!isset($config['type'])) throw new Exception('Route config must have a handler type');

			$handler = array(
				'type'=>$config['type'],
				'args'=>isset($config['args']) ? $config['args'] : array()
			);
			$attributes = isset($config['attributes']) ? $config['attributes'] : array();
			$route = $route ?: new Route($pattern, $handler, $attributes);

			if($route == null) throw new \Exception('Invalid Route information.');
			$this->routes[] = $route;
		}
	}

	public function init() {
		$parts = parse_url($_SERVER['SCRIPT_URI']);
		$this->matchedRoute = $this->getMatch($parts['path']);
		\Application\FrontController::getInstance()->data['route'] = $this->matchedRoute;

		if($this->matchedRoute === null) {
			throw new \Exception('No Route found for: ' . $uri);
		}
	}

	public function execute() {
		$this->matchedRoute->getHandler()->dispatch($this->matchedRoute->getParams());
	}

	protected function getMatch($uri) {
		$match = null;
		foreach($this->routes AS $route) {
			if($route->matches($uri) ? $match = $route : false) break;
		}
		return $match;
	}

	protected function loadRouteConfig($routes) {
		switch(array_pop(explode('.', $routes))) {
			case 'json' :
				$routes = json_decode(file_get_contents($routes), true);
				break;
			case 'php' :
				$routes = include($routes);
				break;
			default :
				throw new Exception('Invalid route configuration file: ' . $routes);
				break;
		}
		return $routes;
	}

}
