<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 12 Feb 2019 17:19:30 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Acttarifario
 * 
 * @property int $ID
 * @property int $IDGrupo
 * @property string $Nombre
 * @property string $Descripcion
 * @property string $Estado
 * 
 * @property \App\Models\Grupo $grupo
 * @property \Illuminate\Database\Eloquent\Collection $empresas
 *
 * @package App\Models
 */
class Acttarifario extends Eloquent
{
	protected $table = 'acttarifario';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'ID' => 'int',
		'IDGrupo' => 'int'
	];

	protected $fillable = [
		'IDGrupo',
		'Nombre',
		'Descripcion',
		'Estado'
	];

	public function grupo()
	{
		return $this->belongsTo(\App\Models\Grupo::class, 'IDGrupo');
	}

	public function empresas()
	{
		return $this->hasMany(\App\Models\Empresa::class, 'IDTarifaActividad');
	}
}
