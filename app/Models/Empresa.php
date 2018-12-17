<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 15 Dec 2018 04:36:22 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Empresa
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property int $IDClasificacion
 * @property int $IDEntidad
 * @property int $IDSector
 * @property string $Observacion
 * @property string $RUC
 * @property string $RazonSocial
 * @property string $NombreComercial
 * @property string $TipoContribuyente
 * @property bool $ObligContabilidad
 * @property bool $ContEspecial
 * @property string $Direccion
 * @property string $Telefono
 * @property string $Celular
 * @property string $Email
 * @property string $Estado
 * @property string $Latitud
 * @property string $Longitud
 *
 * @property \App\Models\Entidad $entidad
 * @property \App\Models\Clasificacion $clasificacion
 * @property \App\Models\Sector $sector
 * @property \Illuminate\Database\Eloquent\Collection $inspeccions
 *
 * @package App\Models
 */
class Empresa extends Eloquent
{
	protected $table = 'empresa';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDClasificacion' => 'int',
		'IDEntidad' => 'int',
		'IDSector' => 'int',
		'ObligContabilidad' => 'bool',
		'ContEspecial' => 'bool'
	];

	protected $fillable = [
		'Descripcion',
		'IDClasificacion',
		'IDEntidad',
		'IDSector',
		'Observacion',
		'RUC',
		'RazonSocial',
		'NombreComercial',
		'TipoContribuyente',
		'ObligContabilidad',
		'ContEspecial',
		'Direccion',
		'Telefono',
		'Celular',
		'Email',
		'Estado'
	];

	public function entidad()
	{
		return $this->belongsTo(\App\Models\Entidad::class, 'IDEntidad');
	}

	public function clasificacion()
	{
		return $this->belongsTo(\App\Models\Clasificacion::class, 'IDClasificacion');
	}

	public function sector()
	{
		return $this->belongsTo(\App\Models\Sector::class, 'IDSector');
	}

	public function inspeccions()
	{
		return $this->hasMany(\App\Models\Inspeccion::class, 'IDEmpresa');
	}
}
