<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 15 Dec 2018 04:36:22 +0000.
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
 * @property \Illuminate\Database\Eloquent\Collection $tipoacteconomicas
 *
 * @package App\Models
 */
class Acteconomica extends Eloquent
{
	protected $table = 'acteconomica';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $fillable = [
		'Descripcion',
		'Estado'
	];

	public function tipoacteconomicas()
	{
		return $this->hasMany(\App\Models\Tipoacteconomica::class, 'IDActEconomica');
	}
}
