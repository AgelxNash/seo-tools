<?php namespace AgelxNash\SEOTools;

use Illuminate\Support\ServiceProvider as BaseProvider;
use AgelxNash\SEOTools\Interfaces\SeoInterface;
use Illuminate\Database\Eloquent\Model;

class ServiceProvider extends BaseProvider
{
	public function register()
	{
		$this->registerEvents();
	}

	public function boot()
	{
		$this->publishes([
			__DIR__.'/../database/migrations/' => database_path('migrations')
		], 'migrations');
	}

	public function registerEvents() {
		$this->app['events']->listen('eloquent.saved*', function (Model $model) {
			if($model instanceof SeoInterface && !$model->seo()->exists()){
				$model->seo()->create($model->getDefaultSeoFields());
			}
		});
		$this->app['events']->listen('eloquent.deleting*', function (Model $model) {
			if($model instanceof SeoInterface && $model->seo()->exists()) {
				$model->seo()->delete();
			}
			return true;
		});
	}

}