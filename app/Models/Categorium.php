<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 12 Feb 2019 17:19:30 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Categorium
 * 
 * @property int $ID
 * @property string $Nombre
 * @property string $Descripcion
 * @property string $Estado
 * 
 * @property \Illuminate\Database\Eloquent\Collection $empresas
 * @property \App\Models\Grupocategorium $grupocategorium
 *
 * @package App\Models
 */
class Categorium extends Eloquent
{
	protected $primaryKey = 'ID';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'ID' => 'int'
	];

	protected $fillable = [
		'Nombre',
		'Descripcion',
		'Estado'
	];

	public function empresas()
	{
		return $this->hasMany(\App\Models\Empresa::class, 'IDTarifaCategoria');
	}

	public function grupocategorium()
	{
		return $this->hasOne(\App\Models\Grupocategorium::class, 'IDCategoria');
	}
}
