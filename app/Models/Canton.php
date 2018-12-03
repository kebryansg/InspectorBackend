<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 03 Dec 2018 20:49:33 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Canton
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property string $Estado
 * @property int $IDProvincia
 * 
 * @property \App\Models\Provincium $provincium
 * @property \Illuminate\Database\Eloquent\Collection $parroquia
 *
 * @package App\Models
 */
class Canton extends Eloquent
{
	protected $table = 'canton';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDProvincia' => 'int'
	];

	protected $fillable = [
		'Descripcion',
		'Estado',
		'IDProvincia'
	];

	public function provincium()
	{
		return $this->belongsTo(\App\Models\Provincium::class, 'IDProvincia');
	}

	public function parroquia()
	{
		return $this->hasMany(\App\Models\Parroquium::class, 'IDCanton');
	}
}
