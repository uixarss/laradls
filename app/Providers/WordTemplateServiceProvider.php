<?php

namespace App\Providers;

use App\Helpers\WordTemplate;
use Illuminate\Support\ServiceProvider;

class WordTemplateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('word-template', function() {
            return new WordTemplate;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
