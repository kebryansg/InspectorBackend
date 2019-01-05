<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 27 Dec 2018 01:08:15 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Formulario
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property string $Observacion
 * @property string $Estado
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $IDUsers_created
 * @property int $IDUsers_updated
 * 
 * @property \Illuminate\Database\Eloquent\Collection $inspeccions
 * @property \Illuminate\Database\Eloquent\Collection $seccions
 *
 * @package App\Models
 */
class Formulario extends Eloquent
{
	protected $table = 'formulario';
	protected $primaryKey = 'ID';

	protected $casts = [
		'IDUsers_created' => 'int',
		'IDUsers_updated' => 'int'
	];

	protected $fillable = [
		'Descripcion',
		'Observacion',
		'Estado',
		'IDUsers_created',
		'IDUsers_updated'
	];

	public function inspeccions()
	{
		return $this->hasMany(\App\Models\Inspeccion::class, 'IDFormulario');
	}

	public function seccions()
	{
		return $this->hasMany(\App\Models\Seccion::class, 'IDFormulario');
	}
}
