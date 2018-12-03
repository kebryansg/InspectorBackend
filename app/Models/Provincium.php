<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 03 Dec 2018 20:49:33 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Provincium
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property string $Estado
 * 
 * @property \Illuminate\Database\Eloquent\Collection $cantons
 *
 * @package App\Models
 */
class Provincium extends Eloquent
{
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $fillable = [
		'Descripcion',
		'Estado'
	];

	public function cantons()
	{
		return $this->hasMany(\App\Models\Canton::class, 'IDProvincia');
	}
}
