<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        \DB::listen(function ($sql, $bindings, $time) {
            $this->app->make('log')->debug("SQL语句执行: {$sql}  参数：" . json_encode($bindings) . " 耗时：{$time}");
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // 提示
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
