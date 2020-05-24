<?php


namespace W7engine\Core\Log;


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
		echo 'bootdb';
		return;
	}
}