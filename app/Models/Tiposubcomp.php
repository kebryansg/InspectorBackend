<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 03 Dec 2018 20:49:33 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Tiposubcomp
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property string $Valor
 * @property string $Estado
 * 
 * @property \Illuminate\Database\Eloquent\Collection $componentes
 *
 * @package App\Models
 */
class Tiposubcomp extends Eloquent
{
	protected $table = 'tiposubcomp';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $fillable = [
		'Descripcion',
		'Valor',
		'Estado'
	];

	public function componentes()
	{
		return $this->hasMany(\App\Models\Componente::class, 'IDTipoSubComp');
	}
}
