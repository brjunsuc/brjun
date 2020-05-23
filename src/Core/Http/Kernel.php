<?php


namespace W7\Engine\Core\Http;

use Illuminate\Contracts\Http\Kernel as KernelContract;
use W7\Engine\App;

class Kernel implements KernelContract
{
	protected $app;

	protected $bootstrappers = [
		\W7\Engine\Core\Bootstrap\LoadConfig::class,
		\W7\Engine\Core\Bootstrap\RegisterProviders::class,
		\W7\Engine\Core\Bootstrap\BootProviders::class
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