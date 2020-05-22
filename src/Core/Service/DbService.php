<?php


namespace Brjun\Core\Service;


class DbService
{
	public function register()
	{
		echo 123;
		return 'register';
	}

	public function boot()
	{
		echo 'bootdb';
		return 1;
	}
}