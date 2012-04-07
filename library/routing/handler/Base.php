<?php
namespace Routing\Handler;

abstract class Base {

	abstract public function dispatch($params);

	public function __construct() {

	}

}
