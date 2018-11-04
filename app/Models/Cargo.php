<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 03 Nov 2018 19:01:02 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Cargo
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property string $Estado
 * 
 * @property \Illuminate\Database\Eloquent\Collection $colaboradors
 *
 * @package App\Models
 */
class Cargo extends Eloquent
{
	protected $table = 'cargo';
	protected $primaryKey = 'ID';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'ID' => 'int'
	];

	protected $fillable = [
		'Descripcion',
		'Estado'
	];

	public function colaboradors()
	{
		return $this->hasMany(\App\Models\Colaborador::class, 'IDCargo');
	}
}
