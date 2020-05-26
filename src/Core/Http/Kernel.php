<?php


namespace W7engine\Core\Http;

use Illuminate\Contracts\Http\Kernel as KernelContract;
use W7engine\App;

class Kernel implements KernelContract
{
	protected $app;

	protected $bootstrappers = [
		\W7engine\Core\Config\LoadConfig::class,
		\W7engine\Core\Bootstrap\RegisterProviders::class,
		\W7engine\Core\Bootstrap\BootProviders::class,
	];

	public function __construct(App $app)
	{
		$this->app = $app;
	}

	public function bootstrap()
	{
		if (!$this->app->hasBeenBootstrapped()) {
			$this->app->bootstrapWith($this->bootstrappers());
		}
	}

	protected function bootstrappers()
	{
		return $this->bootstrappers;
	}

	public function handle($request)
	{
		$this->bootstrap();
	}

	public function terminate($request, $response)
	{
		// TODO: Implement terminate() method.
	}

	public function getApplication()
	{
		return $this->app;
	}
}