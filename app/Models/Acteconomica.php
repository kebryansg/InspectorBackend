<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 03 Nov 2018 19:01:02 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Acteconomica
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property string $Estado
 * 
 * @property \Illuminate\Database\Eloquent\Collection $clasificacions
 *
 * @package App\Models
 */
class Acteconomica extends Eloquent
{
	protected $table = 'acteconomica';
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

	public function clasificacions()
	{
		return $this->hasMany(\App\Models\Clasificacion::class, 'IDActEconomia');
	}
}
