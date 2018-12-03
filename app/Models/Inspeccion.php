<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 21 Nov 2018 02:33:41 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Inspeccion
 * 
 * @property int $ID
 * @property string $Estado
 * @property int $IDFormulario
 * @property int $IDEmpresa
 * @property int $IDColaborador
 * @property \Carbon\Carbon $FechaRegistro
 * @property int $UsuarioRegistro
 * @property \Carbon\Carbon $FechaInspeccion
 * @property string $Observacion
 * 
 * @property \App\Models\Empresa $empresa
 *
 * @package App\Models
 */
class Inspeccion extends Eloquent
{
	protected $table = 'inspeccion';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDFormulario' => 'int',
		'IDEmpresa' => 'int',
		'IDColaborador' => 'int',
		'UsuarioRegistro' => 'int'
	];

	protected $dates = [
		'FechaRegistro',
		'FechaInspeccion'
	];

	protected $fillable = [
		'Estado',
		'IDFormulario',
		'IDEmpresa',
		'IDColaborador',
		'FechaRegistro',
		'UsuarioRegistro',
		'FechaInspeccion',
		'Observacion'
	];

	public function empresa()
	{
		return $this->belongsTo(\App\Models\Empresa::class, 'IDEmpresa');
	}
}
