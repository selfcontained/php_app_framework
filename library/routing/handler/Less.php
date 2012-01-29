<?php
namespace Routing\Handler;

class Less extends Base {

	public function dispatch($params) {
		require '../library/external/less/less_minified.inc.php';

		$bundle = $params['bundle'];
		if($bundle == null) die('/**invalid bundle*/');

		$cacheKey = $_SERVER['HTTP_HOST'].':less:'.$bundle;
		$data = apc_fetch($cacheKey);

		$file = './css/'.$bundle.'.less';
		$hash = md5_file($file);

		if($data === false || $hash !== $data['hash']) {
			$less = new \LessMinified($file);
			$data = array(
				'hash' => $hash,
				'contents' => '/**compiled@'.date('m/d/Y H:i:s').'*/'.$less->parse()
			);
			apc_store($cacheKey, $data);
		}


		header('Content-Type: text/css');
		echo $data['contents'];

	}

}
