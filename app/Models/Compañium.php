<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 03 Nov 2018 19:01:02 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Compañium
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
class Compañium extends Eloquent
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
