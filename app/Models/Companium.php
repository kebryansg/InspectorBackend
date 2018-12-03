<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 14 Nov 2018 16:58:07 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Companium
 * 
 * @property int $ID
 * @property string $Nombre
 * @property string $Direccion
 * @property string $Telefono
 * @property string $Estado
 * @property int $IDInstitucion
 * 
 * @property \App\Models\Institucion $institucion
 * @property \Illuminate\Database\Eloquent\Collection $colaboradors
 *
 * @package App\Models
 */
class Companium extends Eloquent
{
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDInstitucion' => 'int'
	];

	protected $fillable = [
		'Nombre',
		'Direccion',
		'Telefono',
		'Estado',
		'IDInstitucion'
	];

	public function institucion()
	{
		return $this->belongsTo(\App\Models\Institucion::class, 'IDInstitucion');
	}

	public function colaboradors()
	{
		return $this->hasMany(\App\Models\Colaborador::class, 'IDCompania');
	}
}
