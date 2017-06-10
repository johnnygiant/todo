<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use App\Services\v1\TaskService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    //protected $defer = true;

    public function boot()
    {
        Validator::extend('taskstatus', function($attribute, $value, $parameters, $validator){

          return $value == 1 || $value == 0;
        },'The :attribute field can only be 1 or 0');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
      //  $this->app->bind('App\Services\v1\TaskService', function(){
      //    return new \App\Services\v1\TaskService();
      //});

      // \App::bind('App\Services\Redis',function (){
      //   return new \App\Services\Redis(config('app.name'));
      // });
      //$this->app->singleton(Redis::class,function ($app){
        //return new Redis(config('app.name'));
      //});

          $this->app->bind(TaskService::class, function($app){

          return new TaskService();
      });
    }
}
