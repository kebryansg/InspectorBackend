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
 * @property int $IDUsers_created
 * @property int $IDUsers_updated
 * @property string $Descripcion
 * @property string $Observacion
 * @property string $Estado
 * 
 * @property \Illuminate\Database\Eloquent\Collection $formcomps
 *
 * @package App\Models
 */
class Formulario extends Eloquent
{
	protected $table = 'formulario';
	protected $primaryKey = 'ID';

	protected $casts = [
		'ID' => 'int',
		'IDUsers_created' => 'int',
		'IDUsers_updated' => 'int',
	];

	protected $fillable = [
		'Descripcion',
		'Observacion',
		'Estado'
	];

	public function formcomps()
	{
		return $this->hasMany(\App\Models\Formcomp::class, 'IDFormulario');
	}
}
