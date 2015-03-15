<?php namespace App\Providers;

use App;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider {

    public function register()
    {
        App::bind('helper', function() {
            return new App\Component\Helper;
        });
    }

}
