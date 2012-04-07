<?php
error_reporting(E_ALL);
ini_set('display_errors',true);
set_include_path(get_include_path().PATH_SEPARATOR.'../library/');

require('application/Autoloader.php');
Application\Autoloader::register(parse_ini_file('../config/classmap.ini'));


Application\FrontController::initialize(__DIR__.'/../')
	->handler(new Routing\Manager(__DIR__.'/../config/routes.php'))
	->handler(new Application\Request\Handler\ResponseCache())

	->dispatch();
