<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 05 Dec 2018 18:38:13 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Tipocomp
 *
 * @property int $ID
 * @property string $Descripcion
 * @property string $Valor
 * @property string $Estado
 * @property bool $Configuracion
 *
 * @property \Illuminate\Database\Eloquent\Collection $componentes
 *
 * @package App\Models
 */
class Tipocomp extends Eloquent
{
    protected $table = 'tipocomp';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $casts = [
        'Configuracion' => 'bool'
    ];

    protected $fillable = [
        'Descripcion',
        'Valor',
        'Estado',
        'Configuracion'
    ];

    public function componentes()
    {
        return $this->hasMany(\App\Models\Componente::class, 'IDTipoComp');
    }
}
