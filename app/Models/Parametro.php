<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model  as Eloquent;
/**
 * Class Parametro
 *
 * @property int $ID
 * @property string $Descripcion
 * @property string $Valor
 * @property string $Abr
 *
 * @package App\Models
 */
class Parametro extends Eloquent
{
    protected $table = 'parametro';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'Descripcion',
        'Valor',
        'Abr'
    ];
}
