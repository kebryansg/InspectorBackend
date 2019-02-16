<?php

namespace App\Providers;

use App\Listeners\ComponenteObserver;
use App\Models\Componente;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function boot()
    {

        Componente::observe(ComponenteObserver::class);

//        DB::listen(function ($query) {
//            Log::info(
//                $query->sql,
//                $query->bindings,
//                $query->time
//            );
//        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
