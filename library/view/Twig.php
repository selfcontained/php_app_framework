<?php
namespace View;

class Twig {

	protected $twig;

	protected $data = array();

	protected static $twigLoaded = false;

	public function __construct($viewScriptPath, $twigOptions=array()) {
		$this->loadTwig($viewScriptPath, $twigOptions);
	}

	protected function loadTwig($viewScriptPath, $twigOptions) {
		if(!self::$twigLoaded) {
			require('Twig/Autoloader.php');
			\Twig_Autoloader::register();
		}
		$loader = new \Twig_Loader_Filesystem($viewScriptPath);
		$this->twig = new \Twig_Environment($loader, $twigOptions);
	}

	public function set($data, $value=null) {
		$value !== null ? $this->data[$data] = $value : $this->data = array_merge($this->data, $data?:array());
		return $this;
	}

	public function get($key=null) {
		return $key !== null ? $this->data[$key] : $this->data;
	}

	public function render($template) {
		return $this->twig->render($template, $this->data);
	}

	public function display($template) {
		echo $this->render($template);
	}

}
