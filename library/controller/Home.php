<?php
namespace Controller;

class Home extends Base{

	public function index($params) {
		$this->view->display('home/index.twig');
	}

}
