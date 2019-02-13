<?php
/**
 * Created by PhpStorm.
 * User: KebryanSG
 * Date: 12/2/2019
 * Time: 22:20
 */

namespace App\Listeners;


use App\Models\Componente;
use App\Models\Tipocomp;
use Illuminate\Support\Facades\Log;

class ComponenteObserver
{
    /**
     * Listen to the Componente creating event.
     *
     * @param  \App\Models\Componente  $componente
     * @return void
     */
    public function creating(Componente $componente)
    {
        $Tipocomp = Tipocomp::find($componente->IDTipoComp);
        $componente->Atributo = $Tipocomp->Valor;
        $componente->Result = $Tipocomp->Format;

    }

    /**
     * Handle the Componente "updated" event.
     *
     * @param  \App\Models\Componente  $componente
     * @return void
     */
    public function updating(Componente $componente)
    {
        $Tipocomp = Tipocomp::find($componente->IDTipoComp);
        $componente->Atributo = $Tipocomp->Valor;
        $componente->Result = $Tipocomp->Format;
    }

}