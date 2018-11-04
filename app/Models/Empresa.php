<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 03 Nov 2018 19:01:02 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Empresa
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property string $Estado
 * @property int $IDTipoEmpresa
 * @property int $IDClasificacion
 * @property int $IDEntidad
 * 
 * @property \App\Models\Tipoempresa $tipoempresa
 * @property \App\Models\Clasificacion $clasificacion
 * @property \App\Models\Entidad $entidad
 *
 * @package App\Models
 */
class Empresa extends Eloquent
{
	protected $table = 'empresa';
	protected $primaryKey = 'ID';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'ID' => 'int',
		'IDTipoEmpresa' => 'int',
		'IDClasificacion' => 'int',
		'IDEntidad' => 'int'
	];

	protected $fillable = [
		'Descripcion',
		'Estado',
		'IDTipoEmpresa',
		'IDClasificacion',
		'IDEntidad'
	];

	public function tipoempresa()
	{
		return $this->belongsTo(\App\Models\Tipoempresa::class, 'IDTipoEmpresa');
	}

	public function clasificacion()
	{
		return $this->belongsTo(\App\Models\Clasificacion::class, 'IDClasificacion');
	}

	public function entidad()
	{
		return $this->belongsTo(\App\Models\Entidad::class, 'IDEntidad');
	}
}
