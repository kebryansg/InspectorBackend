<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 03 Nov 2018 19:01:02 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Atributo
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property string $Estado
 * @property int $IDSubComponente
 * 
 * @property \App\Models\Subcomponente $subcomponente
 *
 * @package App\Models
 */
class Atributo extends Eloquent
{
	protected $table = 'atributo';
	protected $primaryKey = 'ID';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'ID' => 'int',
		'IDSubComponente' => 'int'
	];

	protected $fillable = [
		'Descripcion',
		'Estado',
		'IDSubComponente'
	];

	public function subcomponente()
	{
		return $this->belongsTo(\App\Models\Subcomponente::class, 'IDSubComponente');
	}
}
