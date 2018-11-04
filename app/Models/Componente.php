<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 03 Nov 2018 19:01:02 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Componente
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property string $Estado
 * @property int $IDFormulario
 * 
 * @property \App\Models\Formulario $formulario
 * @property \Illuminate\Database\Eloquent\Collection $subcomponentes
 *
 * @package App\Models
 */
class Componente extends Eloquent
{
	protected $table = 'componente';
	protected $primaryKey = 'ID';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'ID' => 'int',
		'IDFormulario' => 'int'
	];

	protected $fillable = [
		'Descripcion',
		'Estado',
		'IDFormulario'
	];

	public function formulario()
	{
		return $this->belongsTo(\App\Models\Formulario::class, 'IDFormulario');
	}

	public function subcomponentes()
	{
		return $this->hasMany(\App\Models\Subcomponente::class, 'IDComponente');
	}
}
