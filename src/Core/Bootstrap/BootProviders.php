<?php


namespace W7\Engine\Core\Bootstrap;


use W7\Engine\App;

class BootProviders
{
	public function bootstrap(App $app)
	{
		echo '---BootProviders---';
		$app->boot();
	}
}