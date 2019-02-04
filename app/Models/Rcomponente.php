<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 23 Jan 2019 19:24:15 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Rcomponente
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property string $Result
 * @property int $Cumple
 * @property int $IDRSeccion
 * @property int $IDTipoComp
 * 
 * @property \App\Models\Rseccion $rseccion
 *
 * @package App\Models
 */
class Rcomponente extends Eloquent
{
	protected $table = 'rcomponente';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'Cumple' => 'int',
		'IDRSeccion' => 'int',
		'IDTipoComp' => 'int'
	];

	protected $fillable = [
		'Descripcion',
		'Result',
		'Cumple',
		'IDRSeccion',
		'IDTipoComp'
	];

	public function rseccion()
	{
		return $this->belongsTo(\App\Models\Rseccion::class, 'IDRSeccion');
	}
}
