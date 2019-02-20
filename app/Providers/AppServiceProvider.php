<?php

namespace App\Providers;

use App\Listeners\ComponenteObserver;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function boot()
    {

        $function = function ($model) {
            $GrupoEco = \App\Models\Grupo::with(
                [
                    'acttarifarios' => function ($query) {
                        $query->orderBy('Nombre');
                    },
                    'categorium'
                ]
            )->has('acttarifarios')->has('categorium')->get();
            $Utilidad = new \App\Http\Controllers\Utilidad();
            $Utilidad->uploadFile($GrupoEco, 'GrupoEconomico/data.json');
        };

        \App\Models\Componente::observe(ComponenteObserver::class);

        \App\Models\Grupo::created($function);
        \App\Models\Acttarifario::created($function);
        \App\Models\Categorium::created($function);


        \App\Models\Grupo::updated($function);
        \App\Models\Acttarifario::updated($function);
        \App\Models\Categorium::updated($function);


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
