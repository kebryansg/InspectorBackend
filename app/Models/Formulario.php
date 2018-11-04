<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 03 Nov 2018 19:01:02 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Formulario
 * 
 * @property int $ID
 * @property \Carbon\Carbon $FechaRegistro
 * @property string $Descripcion
 * @property string $Estado
 * 
 * @property \Illuminate\Database\Eloquent\Collection $componentes
 *
 * @package App\Models
 */
class Formulario extends Eloquent
{
	protected $table = 'formulario';
	protected $primaryKey = 'ID';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'ID' => 'int'
	];

	protected $dates = [
		'FechaRegistro'
	];

	protected $fillable = [
		'FechaRegistro',
		'Descripcion',
		'Estado'
	];

	public function componentes()
	{
		return $this->hasMany(\App\Models\Componente::class, 'IDFormulario');
	}
}
