<?php namespace App\Providers;

use App;
use Illuminate\Support\ServiceProvider;

class AclWidgetServiceProvider extends ServiceProvider {

    public function register()
    {
        App::bind('aclwidget', function() {
            return new App\Widgets\Backend\AclWidget;
        });
    }

}
