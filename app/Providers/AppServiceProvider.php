<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('League\Glide\Server', function ($app) {
            $server = ServerFactory::create([
                'response' => new LaravelResponseFactory(),
                'source' => storage_path("app"),                // Source filesystem
                'cache' => storage_path("framework/cache"), // Cache filesystem
                'source_path_prefix' => "",  // Source filesystem path prefix
                'cache_path_prefix' => ""   // Cache filesystem path prefix

            ]);
            return $server;
        });
    }
}
