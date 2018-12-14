<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 03 Nov 2018 19:01:02 +0000.
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
 * @property int $IDActEconomia
 * 
 * @property \App\Models\Acteconomica $acteconomica
 * @property \Illuminate\Database\Eloquent\Collection $empresas
 *
 * @package App\Models
 */
class Clasificacion extends Eloquent
{
	protected $table = 'clasificacion';
	protected $primaryKey = 'ID';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'ID' => 'int',
        'Precio' => 'float',
		'IDActEconomica' => 'int'
	];

	protected $fillable = [
		'Descripcion',
        'Precio',
		'Estado',
		'IDActEconomica'
	];

	public function acteconomica()
	{
		return $this->belongsTo(\App\Models\Acteconomica::class, 'IDActEconomica');
	}

	public function empresas()
	{
		return $this->hasMany(\App\Models\Empresa::class, 'IDClasificacion');
	}
}
