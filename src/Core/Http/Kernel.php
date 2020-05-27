<?php


namespace W7\Engine\Core\Http;

use Illuminate\Contracts\Http\Kernel as KernelContract;
use W7\Engine\App;
use W7\Engine\Core\Config\LoadConfig;

class Kernel implements KernelContract
{
	protected $app;

	public function __construct(App $app)
	{
		$this->app = $app;
	}

	public function bootstrap()
	{
		$this->app->make(LoadConfig::class)->bootstrap($this->app);
		$this->app->registerConfiguredProviders();
		$this->app->boot();
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