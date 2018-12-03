<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 03 Dec 2018 20:49:33 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Formcomp
 * 
 * @property int $ID
 * @property int $IDFormulario
 * @property int $IDSubComponente
 * @property string $Atributo
 * @property int $Obligatorio
 * @property string $Estado
 * 
 * @property \App\Models\Formulario $formulario
 *
 * @package App\Models
 */
class Formcomp extends Eloquent
{
	protected $table = 'formcomp';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDFormulario' => 'int',
		'IDSubComponente' => 'int',
		'Obligatorio' => 'int'
	];

	protected $fillable = [
		'IDFormulario',
		'IDSubComponente',
		'Atributo',
		'Obligatorio',
		'Estado'
	];

	public function formulario()
	{
		return $this->belongsTo(\App\Models\Formulario::class, 'IDFormulario');
	}
}
