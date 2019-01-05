<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 27 Dec 2018 01:08:15 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Seccion
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property string $Observacion
 * @property string $Estado
 * @property int $IDFormulario
 * 
 * @property \App\Models\Formulario $formulario
 * @property \Illuminate\Database\Eloquent\Collection $componentes
 *
 * @package App\Models
 */
class Seccion extends Eloquent
{
	protected $table = 'seccion';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDFormulario' => 'int'
	];

	protected $fillable = [
		'Descripcion',
		'Observacion',
		'Estado',
		'IDFormulario'
	];

	public function formulario()
	{
		return $this->belongsTo(\App\Models\Formulario::class, 'IDFormulario');
	}

	public function componentes()
	{
		return $this->hasMany(\App\Models\Componente::class, 'IDSeccion');
	}
}
