<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 12 Feb 2019 17:19:30 +0000.
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
 * @property \Illuminate\Database\Eloquent\Collection $empresas
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

	public function empresas()
	{
		return $this->hasMany(\App\Models\Empresa::class, 'IDActEconomica');
	}
}
