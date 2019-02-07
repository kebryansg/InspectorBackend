<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 18 Jan 2019 20:22:05 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Device
 * 
 * @property int $ID
 * @property string $MAC
 * @property string $Token
 * @property string $TokenFCM
 * @property boolean $Autorizado
 *
 * @package App\Models
 */
class Device extends Eloquent
{
	protected $table = 'device';
	protected $primaryKey = 'ID';

	protected $casts = [
		'Autorizado' => 'boolean'
	];

	protected $fillable = [
		'MAC',
		'Token',
		'TokenFCM',
		'Autorizado'
	];
}
