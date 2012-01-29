<?php
namespace Routing;

class Manager {

	protected $routes;

	public function __construct($routes) {
		foreach($routes AS $key => $value) {
			$route = is_object($value) && get_class($value) == 'Routing\Route' ? $value : null;
			$route = $route ?: new Route($key, $value);

			if($route == null) throw new \Exception('Invalid Route information.');
			$this->routes[] = $route;
		}
	}

	public function getMatch($uri) {
		$match = null;
		foreach($this->routes AS $route) {
			if($route->matches($uri) ? $match = $route : false) break;
		}
		return $match;
	}

}
