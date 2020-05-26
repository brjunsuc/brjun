<?php


namespace W7engine\Core\Config;


use W7engine\App;
use W7engine\Core\Config\Repository as RepositoryContract;

class LoadConfig
{
	protected $compatConfigKey = [
		'database' => [
			'default' => 'mysql',
			'connections' => [
				'mysql' => [
					'driver' => 'mysql',
					'host' => '',
					'port' => '',
					'database' => '',
					'username' => '',
					'password' => '',
					'unix_socket' => '',
					'charset' => '',
					'collation' => 'utf8mb4_unicode_ci',
					'prefix' => '',
					'prefix_indexes' => true,
					'strict' => true,
					'engine' => null,
					'options' => []
				],
			],
		],
		'cache' => [],
		'session' => [],
		'setting' => []
	];
	public function bootstrap(App $app)
	{
		$items = [];
		$app->instance('config', $config = new Repository($items));
		$this->loadConfigurationFiles($config);

		date_default_timezone_set($config->get('setting.timezone', 'UTC'));

		mb_internal_encoding('UTF-8');
	}

	protected function loadConfigurationFiles(RepositoryContract $repository)
	{
		$config = [];
		include IA_ROOT . '/data/config.php';

		$this->compatConfigKey['database']['connections']['mysql'] = array_merge($this->compatConfigKey['database']['connections']['mysql'], $config['db']['master']);
		$this->compatConfigKey['database']['connections']['mysql']['prefix'] = $config['db']['master']['tablepre'];
		$repository->set('database', $this->compatConfigKey['database']);

		$this->compatConfigKey['setting'] = array_merge($this->compatConfigKey['setting'], $config['setting']);
		$repository->set('setting', $config['setting']);

		$repository->set('providers', $config['providers']);
	}
}