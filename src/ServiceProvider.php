<?php namespace AgelxNash\SEOTools;

use Illuminate\Support\ServiceProvider as BaseProvider;
use AgelxNash\SEOTools\Interfaces\SeoInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ServiceProvider
 * @package AgelxNash\SEOTools
 */
class ServiceProvider extends BaseProvider
{
    public function register()
    {
        $this->registerEvents();
    }
    
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations')
        ], 'migrations');
    }
    
    public function registerEvents()
    {
        $this->app['events']->listen('eloquent.saved*', function ($eventName, $payload = null) {
            $model = null;
            if ($eventName instanceof Model) {
                // Laravel < 5.4
                $model = $eventName;
            } else {
                // Laravel >= 5.4
                $model = $payload[0];
            }
            if ($model instanceof SeoInterface && !$model->seo()->exists()) {
                $model->seo()->create($model->getDefaultSeoFields());
            }
        });
        $this->app['events']->listen('eloquent.deleting*', function ($eventName, $payload = null) {
            $model = null;
            if ($eventName instanceof Model) {
                // Laravel < 5.4
                $model = $eventName;
            } else {
                // Laravel >= 5.4
                $model = $payload[0];
            }
            if ($model instanceof SeoInterface && $model->seo()->exists()) {
                $model->seo()->delete();
            }
            return true;
        });
    }

}
