<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 23 Jan 2019 19:24:15 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Rseccion
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property int $IDInspeccion
 * 
 * @property \App\Models\Inspeccion $inspeccion
 * @property \Illuminate\Database\Eloquent\Collection $rcomponentes
 *
 * @package App\Models
 */
class Rseccion extends Eloquent
{
	protected $table = 'rseccion';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDInspeccion' => 'int'
	];

	protected $fillable = [
		'Descripcion',
		'IDInspeccion'
	];

	public function inspeccion()
	{
		return $this->belongsTo(\App\Models\Inspeccion::class, 'IDInspeccion');
	}

	public function rcomponentes()
	{
		return $this->hasMany(\App\Models\Rcomponente::class, 'IDRSeccion');
	}
}
