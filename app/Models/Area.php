<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 03 Nov 2018 19:01:02 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Area
 *
 * @property int $ID
 * @property string $Descripcion
 * @property string $Estado
 * @property int $IDDepartamento
 *
 * @property \App\Models\Departamento $departamento
 * @property \Illuminate\Database\Eloquent\Collection $colaboradors
 *
 * @package App\Models
 */
class Area extends Eloquent
{
    protected $table = 'area';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $casts = [
        'IDDepartamento' => 'int'
    ];

    protected $fillable = [
        'Descripcion',
        'Estado',
        'IDDepartamento'
    ];

    public function departamento()
    {
        return $this->belongsTo(\App\Models\Departamento::class, 'IDDepartamento');
    }

    public function colaboradors()
    {
        return $this->hasMany(\App\Models\Colaborador::class, 'IDArea');
    }
}
