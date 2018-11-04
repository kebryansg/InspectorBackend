<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 03 Nov 2018 19:01:02 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Subcomponente
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property string $Estado
 * @property int $IDComponente
 * 
 * @property \App\Models\Componente $componente
 * @property \Illuminate\Database\Eloquent\Collection $atributos
 *
 * @package App\Models
 */
class Subcomponente extends Eloquent
{
	protected $table = 'subcomponente';
	protected $primaryKey = 'ID';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'ID' => 'int',
		'IDComponente' => 'int'
	];

	protected $fillable = [
		'Descripcion',
		'Estado',
		'IDComponente'
	];

	public function componente()
	{
		return $this->belongsTo(\App\Models\Componente::class, 'IDComponente');
	}

	public function atributos()
	{
		return $this->hasMany(\App\Models\Atributo::class, 'IDSubComponente');
	}
}
