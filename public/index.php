<?php
error_reporting(E_ALL);
ini_set('display_errors',true);
set_include_path(get_include_path().PATH_SEPARATOR.'../library/');

require('application/Autoloader.php');
Application\Autoloader::register(parse_ini_file('../config/classmap.ini'));

$routeManager = new Routing\Manager(array(
	'/^\/$/' 					=> new Routing\Handler\Controller('Controller\Home', 'index'),
	'/^\/about-the-author\/$/'	=> new Routing\Handler\View('home/author.twig'),
	'/^\/books\/$/' 			=> new Routing\Handler\View('books/index.twig'),
	'/^\/css\/combined\.(?<bundle>[a-z]+)\.css$/' => new Routing\Handler\Less()
));

Application\FrontController::initialize(__DIR__.'/../')->dispatch($routeManager, $_SERVER['REQUEST_URI']);
