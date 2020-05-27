<?php


namespace W7\Engine\Core\Log;


use Illuminate\Support\ServiceProvider;

class LogServiceProvider extends ServiceProvider
{
	public function register()
	{
		echo '---reg-LogServiceProvider---';
		return;
	}

	public function boot()
	{
		echo 'bootLogServiceProvider';
		return;
	}
}