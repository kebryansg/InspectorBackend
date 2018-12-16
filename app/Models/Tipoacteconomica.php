<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 15 Dec 2018 04:36:22 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Tipoacteconomica
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property string $Estado
 * @property int $IDActEconomica
 * 
 * @property \App\Models\Acteconomica $acteconomica
 * @property \Illuminate\Database\Eloquent\Collection $clasificacions
 *
 * @package App\Models
 */
class Tipoacteconomica extends Eloquent
{
	protected $table = 'tipoacteconomica';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDActEconomica' => 'int'
	];

	protected $fillable = [
		'Descripcion',
		'Estado',
		'IDActEconomica'
	];

	public function acteconomica()
	{
		return $this->belongsTo(\App\Models\Acteconomica::class, 'IDActEconomica');
	}

	public function clasificacions()
	{
		return $this->hasMany(\App\Models\Clasificacion::class, 'IDTipoActEcon');
	}
}
