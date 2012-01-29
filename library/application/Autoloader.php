<?php
namespace Application;

class Autoloader {

	protected static $classmap;

	public static function register($classmap) {
		self::$classmap = $classmap;
		spl_autoload_register(array('\Application\Autoloader', 'load'));
	}

	protected static function load($classname) {
		if(isset(self::$classmap[$classname])) require(self::$classmap[$classname]);
		return true;
	}

}
