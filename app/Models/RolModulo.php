<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class RolModulo
 *
 * @property int $IDRol
 * @property int $IDModulo
 *
 *
 * @package App\Models
 */
class RolModulo extends Eloquent
{
    protected $table = 'rolmodulo';
    public $timestamps = false;

    protected $fillable = [
        'IDRol',
        'IDModulo'
    ];

}