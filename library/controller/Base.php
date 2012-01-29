<?php
namespace Controller;

abstract class Base {

	protected $view;

	public function __construct() {
		$this->view = new \View\Twig(
			\Application\FrontController::getInstance()->getApplicationRoot().'/views'
		);
	}

	public function param($name) {
		return isset($_REQUEST[$name]) ? $_REQUEST[$name] : null;
	}

}
