<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 27 Dec 2018 01:08:15 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Componente
 * 
 * @property int $ID
 * @property int $IDTipoComp
 * @property int $IDSeccion
 * @property string $Descripcion
 * @property string $Estado
 * @property string $Atributo
 * @property int $Obligatorio
 * 
 * @property \App\Models\Tipocomp $tipocomp
 * @property \App\Models\Seccion $seccion
 *
 * @package App\Models
 */
class Componente extends Eloquent
{
	protected $table = 'componente';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDTipoComp' => 'int',
		'IDSeccion' => 'int',
		'Obligatorio' => 'int',
        'Atributo' => 'array',

	];

	protected $fillable = [
		'IDTipoComp',
		'IDSeccion',
		'Descripcion',
		'Estado',
		'Atributo',
		'Obligatorio'
	];

	public function tipocomp()
	{
		return $this->belongsTo(\App\Models\Tipocomp::class, 'IDTipoComp');
	}

	public function seccion()
	{
		return $this->belongsTo(\App\Models\Seccion::class, 'IDSeccion');
	}
}
