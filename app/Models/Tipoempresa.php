<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 03 Nov 2018 19:01:02 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Tipoempresa
 *
 * @property int $ID
 * @property string $Nombre
 * @property string $Descripcion
 * @property string $Estado
 *
 * @property \Illuminate\Database\Eloquent\Collection $empresas
 *
 * @package App\Models
 */
class Tipoempresa extends Eloquent
{
    protected $table = 'tipoempresa';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'Nombre',
        'Descripcion',
        'Estado'
    ];

    public function empresas()
    {
        return $this->hasMany(\App\Models\Empresa::class, 'IDTipoEmpresa');
    }
}
