<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 03 Dec 2018 20:49:33 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Subcomponente
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property string $Estado
 * @property int $IDComponente
 * 
 * @property \App\Models\Componente $componente
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
}
