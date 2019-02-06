<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 17 Dec 2018 23:27:27 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Inspeccion
 *
 * @property int $ID
 * @property \Carbon\Carbon $FechaInspeccion
 * @property \Carbon\Carbon $FechaTentativa
 * @property \Carbon\Carbon $FechaPlazo
 * @property string $Estado
 * @property int $IDFormulario
 * @property int $IDEmpresa
 * @property int $IDColaborador
 * @property string $Observacion
 * @property string $MedioUpdate
 * @property int $UsuarioRegistro
 * @property int $UsuarioUpdate
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $firebase_at
 *
 * @property \App\Models\Empresa $Empresa
 * @property \App\Models\Colaborador $colaborador
 * @property \App\Models\Formulario $formulario
 * @property \Illuminate\Database\Eloquent\Collection $observacions
 * @property \Illuminate\Database\Eloquent\Collection $rseccions
 *
 * @package App\Models
 */
class Inspeccion extends Eloquent
{
    protected $table = 'inspeccion';
    protected $primaryKey = 'ID';

    protected $casts = [
        'IDFormulario' => 'int',
        'IDEmpresa' => 'int',
        'IDColaborador' => 'int',
        'UsuarioRegistro' => 'int',
        'UsuarioUpdate' => 'int'
    ];

    protected $dates = [
        'FechaInspeccion',
        'created_at',
        'updated_at',
        'firebase_at',
        'FechaPlazo',
        'FechaTentativa'
    ];

    protected $fillable = [
        'FechaInspeccion',
        'FechaTentativa',
        'FechaPlazo',
        'Estado',
        'IDFormulario',
        'IDEmpresa',
        'IDColaborador',
        'Observacion',
        'UsuarioRegistro',
        'UsuarioUpdate',
        'MedioUpdate'
    ];

    public function empresa()
    {
        return $this->belongsTo(\App\Models\Empresa::class, 'IDEmpresa');
    }

    public function colaborador()
    {
        return $this->belongsTo(\App\Models\Colaborador::class, 'IDColaborador');
    }

    public function formulario()
    {
        return $this->belongsTo(\App\Models\Formulario::class, 'IDFormulario');
    }

    public function observacions()
    {
        return $this->hasMany(\App\Models\Observacion::class, 'IDInspeccion');
    }

    public function rseccions()
    {
        return $this->hasMany(\App\Models\Rseccion::class, 'IDInspeccion');
    }

    public function getEstado()
    {
        $Estado = '';
        switch ($this->Estado) {
            case 'APR' :
                $Estado = 'Aprobado';
                break;
            case 'PEN' :
                $Estado = 'Pendiente';
                break;
            case 'REP' :
                $Estado = 'Reprobado';
                break;
            case 'BOR' :
                $Estado = 'Borrador';
                break;
        }
        return $Estado;
    }
}
