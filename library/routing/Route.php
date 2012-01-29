<?php
namespace Routing;

class Route {

	protected $pattern;

	protected $handler;

	protected $params;

	public function __construct($pattern, Handler\Base $handler) {
		$this->pattern = $pattern;
		$this->handler = $handler;
	}

	public function matches($uri) {
		$match = false;
		if(preg_match($this->pattern, $uri, $matches)){
			foreach($matches AS $key => $value) {
				if(!is_numeric($key)) {
					$this->params[$key] = $value;
				}
			}
			$match = true;
		}
		return $match;
	}

	public function getHandler() {
		return $this->handler;
	}

	public function getParams() {
		return $this->params;
	}

}
