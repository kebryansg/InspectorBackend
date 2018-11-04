<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 03 Nov 2018 19:01:02 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Colaborador
 * 
 * @property int $ID
 * @property string $NombrePrimero
 * @property string $NombreSegundo
 * @property string $ApellidoPaterno
 * @property string $ApellidoMaterno
 * @property string $Cedula
 * @property string $Estado
 * @property int $IDCompania
 * @property int $IDCargo
 * @property int $IDArea
 * 
 * @property \App\Models\Cargo $cargo
 * @property \App\Models\Area $area
 * @property \App\Models\Compañium $compañium
 *
 * @package App\Models
 */
class Colaborador extends Eloquent
{
	protected $table = 'colaborador';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDCompania' => 'int',
		'IDCargo' => 'int',
		'IDArea' => 'int'
	];

	protected $fillable = [
		'NombrePrimero',
		'NombreSegundo',
		'ApellidoPaterno',
		'ApellidoMaterno',
		'Cedula',
		'Estado',
		'IDCompania',
		'IDCargo',
		'IDArea'
	];

	public function cargo()
	{
		return $this->belongsTo(\App\Models\Cargo::class, 'IDCargo');
	}

	public function area()
	{
		return $this->belongsTo(\App\Models\Area::class, 'IDArea');
	}

	public function compañium()
	{
		return $this->belongsTo(\App\Models\Compañium::class, 'IDCompania');
	}
}
