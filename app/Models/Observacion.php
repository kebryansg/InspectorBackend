<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 27 Jan 2019 21:44:00 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Observacion
 * 
 * @property int $ID
 * @property string $Observacion
 * @property int $IDInspeccion
 * 
 * @property \App\Models\Inspeccion $inspeccion
 *
 * @package App\Models
 */
class Observacion extends Eloquent
{
	protected $table = 'observacion';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDInspeccion' => 'int'
	];

	protected $fillable = [
		'Observacion',
		'IDInspeccion'
	];

	public function inspeccion()
	{
		return $this->belongsTo(\App\Models\Inspeccion::class, 'IDInspeccion');
	}
}
