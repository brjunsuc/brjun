<?php


namespace Brjun\Core\Config;


class Config
{

	private $config = [];

	public function __construct() {
		$this->loadConfig();
	}

	private function loadConfig() {
		if (!empty($this->config)) {
			return $this->config;
		}

		$path = glob(BASE_PATH . '/data/config.php');
		$appConfig = include $path;
		$this->config = $appConfig;
		return $this->config;
	}
}