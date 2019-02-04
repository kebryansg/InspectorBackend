<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 03 Feb 2019 23:13:16 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Rol
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property string $Observacion
 * @property string $Estado
 *
 * @package App\Models
 */
class Rol extends Eloquent
{
	protected $table = 'rol';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $fillable = [
		'Descripcion',
		'Observacion',
		'Estado'
	];

//	public function modulos(){
//        $idsModulo = RolModulo::where('IDRol', $this->ID)->get()->pluck('IDModulo');
//
//    }
}
