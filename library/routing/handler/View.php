<?php
namespace Routing\Handler;

class View extends Base{

	protected $viewScript;

	public function __construct($viewScript) {
		$this->viewScript = $viewScript;
		return $this;
	}

	public function dispatch($params) {
		$view = new \View\Twig(
			\Application\FrontController::getInstance()->getApplicationRoot().'/views'
		);
		$view->set($params)->display($this->viewScript);
	}

}
