<?php namespace AgelxNash\SEOTools;

use Illuminate\Support\ServiceProvider as BaseProvider;

class ServiceProvider extends BaseProvider
{
	public function register()
	{

	}

	public function boot()
	{
		$this->publishes([
			__DIR__.'/../database/migrations/' => database_path('migrations')
		], 'migrations');
	}

}