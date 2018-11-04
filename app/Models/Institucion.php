<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 03 Nov 2018 19:01:02 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Institucion
 * 
 * @property int $ID
 * @property string $Nombre
 * @property string $Ruc
 * @property string $Direccion
 * @property string $Telefono
 * @property string $Email
 * @property string $Estado
 * @property string $UsuarioIns
 * @property \Carbon\Carbon $FechaRegistro
 * @property string $UsuarioUpd
 * @property \Carbon\Carbon $FechaModificacion
 * 
 * @property \Illuminate\Database\Eloquent\Collection $compañia
 *
 * @package App\Models
 */
class Institucion extends Eloquent
{
	protected $table = 'institucion';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $dates = [
		'FechaRegistro',
		'FechaModificacion'
	];

	protected $fillable = [
		'Nombre',
		'Ruc',
		'Direccion',
		'Telefono',
		'Email',
		'Estado',
		'UsuarioIns',
		'FechaRegistro',
		'UsuarioUpd',
		'FechaModificacion'
	];

	public function compañia()
	{
		return $this->hasMany(\App\Models\Compañium::class, 'IDInstitucion');
	}
}
