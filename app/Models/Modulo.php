<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 03 Feb 2019 18:01:04 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Modulo
 * 
 * @property int $ID
 * @property string $state
 * @property string $name
 * @property string $short_label
 * @property string $type
 * @property string $icon
 * @property int $IDPadre
 * @property string $Estado
 * 
 * @property \App\Models\Modulo $modulo
 * @property \Illuminate\Database\Eloquent\Collection $modulos
 *
 * @package App\Models
 */
class Modulo extends Eloquent
{
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDPadre' => 'int'
	];

	protected $fillable = [
		'state',
		'name',
		'short_label',
		'type',
		'icon',
		'IDPadre',
		'Estado'
	];

	public function modulo()
	{
		return $this->belongsTo(\App\Models\Modulo::class, 'IDPadre');
	}

	public function modulos()
	{
		return $this->hasMany(\App\Models\Modulo::class, 'IDPadre');
	}
}
