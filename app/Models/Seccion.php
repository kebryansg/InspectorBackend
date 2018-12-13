<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 05 Dec 2018 18:38:13 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Seccion
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property string $Observacion
 * @property string $Estado
 * 
 * @property \Illuminate\Database\Eloquent\Collection $seccioncomponentes
 *
 * @package App\Models
 */
class Seccion extends Eloquent
{
	protected $table = 'seccion';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $fillable = [
		'Descripcion',
		'Observacion',
		'Estado'
	];

    public function seccioncomponentes()
    {
        return $this->hasMany(\App\Models\SeccionComponente::class, 'IDSeccion');
    }
}
