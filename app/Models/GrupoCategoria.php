<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class GrupoCategoria
 *
 * @property int $IDGrupo
 * @property int $IDCategoria
 *
 *
 * @package App\Models
 */

class GrupoCategoria extends Eloquent
{
    protected $table = 'grupocategoria';
    public $timestamps = false;

    protected $fillable = [
        'IDGrupo',
        'IDCategoria'
    ];
}