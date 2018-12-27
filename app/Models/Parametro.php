<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model  as Eloquent;
/**
 * Class Parametro
 *
 * @property int $Valor
 * @property string $Descripcion
 * @property int $Abr
 *
 * @package App\Models
 */
class Parametro extends Eloquent
{
    protected $table = 'parametro';
    public $timestamps = false;
}
