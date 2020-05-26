<?php


namespace W7engine;


use Illuminate\Container\Container;
use W7engine\Core\Log\LogServiceProvider;
use Illuminate\Support\Arr;

class App extends Container
{
	protected $hasBeenBootstrapped = false;

	protected $serviceProviders = [];

	protected $booted = false;

	public function __construct()
	{
		$this->registerConstant();
		$this->registerBaseBindings();
		$this->registerBaseServiceProviders();
	}

	protected function registerConstant()
	{
		!defined('IN_IA') && define('IN_IA', true);
		!defined('STARTTIME') && define('STARTTIME', microtime());
		!defined('IA_ROOT') && define('IA_ROOT', str_replace('\\', '/', dirname(dirname(__FILE__))));
		!defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', (function_exists('get_magic_quotes_gpc') && @get_magic_quotes_gpc()) || @ini_get('magic_quotes_sybase'));
		!defined('TIMESTAMP') && define('TIMESTAMP', time());
		!defined('ATTACHMENT_ROOT') && define('ATTACHMENT_ROOT', IA_ROOT . '/attachment/');
	}

	protected function registerBaseBindings()
	{
		static::setInstance($this);
		$this->instance('app', $this);
		$this->instance(Container::class, $this);
	}

	protected function registerBaseServiceProviders()
	{
		$this->register(new LogServiceProvider($this));
	}

	public function bootstrapWith(array $bootstrappers)
	{
		$this->hasBeenBootstrapped = true;
		foreach ($bootstrappers as $bootstrapper) {
			$this->make($bootstrapper)->bootstrap($this);
		}
	}

	public function make($abstract, array $paramters = [])
	{
		return 	parent::make($abstract, $paramters);
	}

	public function hasBeenBootstrapped()
	{
		return $this->hasBeenBootstrapped;
	}

	public function register($provider, $force = false)
	{
		if (($registered = $this->getProvider($provider)) && !$force) {
			return $registered;
		}
		if (is_string($provider)) {
			$provider = $this->resolveProvider($provider);
		}
		$provider->register();

		if (property_exists($provider, 'bindings')) {
			foreach ($provider->bindings as $key => $value) {
				$this->bind($key, $value);
			}
		}

		if (property_exists($provider, 'singletons')) {
			foreach ($provider->singletons as $key => $value) {
				$this->singleton($key, $value);
			}
		}

		$this->markAsRegistered($provider);
	}

	public function registerConfiguredProviders()
	{
		foreach ($this->config['providers'] as $provider) {
			$this->register($provider);
		}
	}

	public function getProvider($provider)
	{
		return array_values($this->getProviders($provider))[0] ?: null;
	}

	public function getProviders($provider)
	{
		$name = is_string($provider) ? $provider : get_class($provider);
		return Arr::where($this->serviceProviders, function ($value) use ($name) {
			return $value instanceof $name;
		});
	}
	public function resolveProvider($provider)
	{
		return new $provider($this);
	}
	protected function markAsRegistered($provider)
	{
		$this->serviceProviders[] = $provider;
	}
	public function isBooted()
	{
		return $this->booted;
	}
	public function boot()
	{
		if ($this->isBooted()) {
			return;
		}

		array_walk($this->serviceProviders, function($provider) {
			if(method_exists($provider, 'boot')) {
				return $this->call([$provider, 'boot']);
			}
		});
	}
}
