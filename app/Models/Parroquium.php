<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 03 Dec 2018 20:49:33 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Parroquium
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property string $Estado
 * @property int $IDCanton
 * 
 * @property \App\Models\Canton $canton
 * @property \Illuminate\Database\Eloquent\Collection $sectors
 *
 * @package App\Models
 */
class Parroquium extends Eloquent
{
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDCanton' => 'int'
	];

	protected $fillable = [
		'Descripcion',
		'Estado',
		'IDCanton'
	];

	public function canton()
	{
		return $this->belongsTo(\App\Models\Canton::class, 'IDCanton');
	}

	public function sectors()
	{
		return $this->hasMany(\App\Models\Sector::class, 'IDParroquia');
	}
}
