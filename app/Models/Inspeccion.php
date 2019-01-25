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
 *
 * @package App\Models
 */
class Inspeccion extends Eloquent
{
    protected $table = 'inspeccion';
    protected $primaryKey = 'ID';
//    protected $dateFormat = 'Y-m-d\TH:i:s+';

    protected $casts = [
		'IDFormulario' => 'int',
		'IDEmpresa' => 'int',
		'IDColaborador' => 'int',
		'UsuarioRegistro' => 'int',
		'UsuarioUpdate' => 'int'
	];

	protected $dates = [
		'FechaInspeccion' ,
        'created_at',
        'updated_at',
        'firebase_at',
		'FechaTentativa' => 'Y-m-d\TH:i:s+'
	];

	protected $fillable = [
		'FechaInspeccion',
		'FechaTentativa',
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
}
