<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 03 Dec 2018 20:49:33 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Sector
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property string $Estado
 * @property int $IDParroquia
 * 
 * @property \App\Models\Parroquium $parroquium
 *
 * @package App\Models
 */
class Sector extends Eloquent
{
	protected $table = 'sector';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDParroquia' => 'int'
	];

	protected $fillable = [
		'Descripcion',
		'Estado',
		'IDParroquia'
	];

	public function parroquium()
	{
		return $this->belongsTo(\App\Models\Parroquium::class, 'IDParroquia');
	}
}
