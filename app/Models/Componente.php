<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 05 Dec 2018 18:38:13 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Componente
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property string $Estado
 * @property int $IDTipoComp
 *
 * @property \App\Models\Tipocomp $tipocomp
 * @property \App\Models\SeccionComponente $seccioncomponentes
 *
 * @package App\Models
 */
class Componente extends Eloquent
{
	protected $table = 'componente';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'ID' => 'int',
		'IDTipoComp' => 'int'
	];

	protected $fillable = [
		'Descripcion',
		'Estado',
		'IDTipoComp'
	];

	public function tipocomp()
	{
		return $this->belongsTo(\App\Models\Tipocomp::class, 'IDTipoComp');
	}

    public function seccioncomponentes()
    {
        return $this->hasMany(\App\Models\SeccionComponente::class, 'IDComponente');
    }
}
