<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Entidad
 *
 * @property int $ID
 * @property string $Nombres
 * @property string $Apellidos
 * @property string $Identificacion
 * @property string $Direccion
 * @property string $Telefono
 * @property string $Celular
 * @property string $Tipo
 * @property string $Email
 * @property string $Estado
 *
 * @property \Illuminate\Database\Eloquent\Collection $empresas
 *
 * @package App\Models
 */
class Entidad extends Eloquent
{
    protected $table = 'entidad';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'Nombres',
        'Apellidos',
        'Identificacion',
        'Direccion',
        'Telefono',
        'Celular',
        'Tipo',
        'Email',
        'Estado'
    ];

    public function empresas()
    {
        return $this->hasMany(\App\Models\Empresa::class, 'IDEntidad');
    }
}
