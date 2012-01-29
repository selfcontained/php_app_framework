<?php
namespace Routing\Handler;

class Controller extends Base{

	protected $controller;

	protected $action;

	public function __construct($controller, $action) {
		$this->controller = $controller;
		$this->action = $action;
		return $this;
	}

	public function dispatch($params) {
		$controller = new $this->controller();
		call_user_func(array($controller, $this->action), $params);
	}
}
