<?php

namespace VirtualComplete\Config;

use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Bind it only once so we can reuse in IoC
        $this->app->singleton('VirtualComplete\Config\Repository', function($app, $items)
        {
            $rewrite = new Rewrite();
            return new Repository($items, $rewrite, $app['path.config']);
        });

        // Capture the loaded configuration items
        $config_items = app('config')->all();

        $this->app['config'] = $this->app->share(function($app) use ($config_items)
        {
            return $app->make('VirtualComplete\Config\Repository', $config_items);
        });
    }
}
