<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 12 Feb 2019 17:19:30 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Grupo
 * 
 * @property int $ID
 * @property string $Nombre
 * @property string $Descripcion
 * @property string $Estado
 * 
 * @property \Illuminate\Database\Eloquent\Collection $acttarifarios
 * @property \Illuminate\Database\Eloquent\Collection $empresas
 * @property \App\Models\GrupoCategoria $grupocategorium
 * @property \App\Models\Categorium $categorium
 *
 * @package App\Models
 */
class Grupo extends Eloquent
{
	protected $table = 'grupo';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $fillable = [
		'Nombre',
		'Descripcion',
		'Estado'
	];

	public function acttarifarios()
	{
		return $this->hasMany(\App\Models\Acttarifario::class, 'IDGrupo');
	}

	public function empresas()
	{
		return $this->hasMany(\App\Models\Empresa::class, 'IDTarifaGrupo');
	}

	public function grupocategorium()
	{
		return $this->hasMany(\App\Models\GrupoCategoria::class, 'IDGrupo');
	}

	public function categorium()
	{
		return $this->hasManyThrough(
		    'App\Models\Categorium',
            'App\Models\GrupoCategoria',
            'IDGrupo',
            'ID',
            'ID',
            'IDCategoria');
	}
}
