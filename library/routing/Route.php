<?php
namespace Routing;

class Route {

	protected $pattern;

	protected $handler;

	protected $params;

	protected $attributes;

	public function __construct($pattern, $handler, $attributes=array()) {
		$this->pattern = $pattern;
		$this->handler = $handler;
		$this->attributes = $attributes;
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
		return is_object($this->handler) ? $this->handler : $this->instantiateHandler();
	}

	public function getParams() {
		return $this->params;
	}

	public function getAttributes() {
		return $this->attributes;
	}

	public function getAttribute($attribute) {
		return isset($this->attributes[$attribute]) ? $this->attributes[$attribute] : null;
	}

	public function getPattern() {
		return $this->pattern;
	}

	protected function instantiateHandler() {
		if(!isset($this->handler['type'])) throw new Exception('"type" must be set for the Handler');

		$ref = new \ReflectionClass('Routing\Handler\\'.$this->handler['type']);
		return $ref->newInstanceArgs( isset($this->handler['args']) ? $this->handler['args'] : array() );
	}

}
