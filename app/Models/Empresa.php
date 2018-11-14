<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 09 Nov 2018 17:31:37 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Empresa
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property int $IDTipoEmpresa
 * @property int $IDClasificacion
 * @property int $IDEntidad
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
 * 
 * @property \App\Models\Clasificacion $clasificacion
 * @property \App\Models\Tipoempresa $tipoempresa
 * @property \App\Models\Entidad $entidad
 *
 * @package App\Models
 */
class Empresa extends Eloquent
{
	protected $table = 'empresa';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDTipoEmpresa' => 'int',
		'IDClasificacion' => 'int',
		'IDEntidad' => 'int',
		'ObligContabilidad' => 'bool',
		'ContEspecial' => 'bool'
	];

	protected $fillable = [
		'Descripcion',
		'IDTipoEmpresa',
		'IDClasificacion',
		'IDEntidad',
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

	public function clasificacion()
	{
		return $this->belongsTo(\App\Models\Clasificacion::class, 'IDClasificacion');
	}

	public function tipoempresa()
	{
		return $this->belongsTo(\App\Models\Tipoempresa::class, 'IDTipoEmpresa');
	}

	public function entidad()
	{
		return $this->belongsTo(\App\Models\Entidad::class, 'IDEntidad');
	}
}
