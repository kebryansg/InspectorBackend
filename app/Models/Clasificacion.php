<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 15 Dec 2018 04:36:22 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Clasificacion
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property float $Precio
 * @property string $Estado
 * @property int $IDTipoActEcon
 * @property int $IDFormulario
 *
 * @property \App\Models\Tipoacteconomica $tipoacteconomica
 * @property \Illuminate\Database\Eloquent\Collection $empresas
 *
 * @package App\Models
 */
class Clasificacion extends Eloquent
{
	protected $table = 'clasificacion';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'Precio' => 'float',
		'IDTipoActEcon' => 'int',
		'IDFormulario' => 'int'
	];

	protected $fillable = [
		'Descripcion',
		'Precio',
		'Estado',
		'IDTipoActEcon',
		'IDFormulario'
	];

	public function tipoacteconomica()
	{
		return $this->belongsTo(\App\Models\Tipoacteconomica::class, 'IDTipoActEcon');
	}

	public function empresas()
	{
		return $this->hasMany(\App\Models\Empresa::class, 'IDClasificacion');
	}
}
