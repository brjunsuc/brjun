<?php


namespace W7engine\Core\Bootstrap;


use W7engine\App;

class BootProviders
{
	public function bootstrap(App $app)
	{
		echo '---BootProviders---';
		$app->boot();
	}
}