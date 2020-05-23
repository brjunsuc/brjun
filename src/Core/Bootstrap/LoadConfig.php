<?php


namespace W7\Engine\Core\Bootstrap;


use W7\Engine\App;
use W7\Engine\Core\Config\Repository;

class LoadConfig
{

	public function bootstrap(App $app)
	{
		$items = [];
		$app->instance('config', $config = new Repository($items));
//		echo 1221;
//		echo "<pre>";
//		print_r($config);
//		echo "</pre>";
//		exit;
		//date_default_timezone_set($config->get('app.timezone', 'UTC'));

		mb_internal_encoding('UTF-8');
	}
}