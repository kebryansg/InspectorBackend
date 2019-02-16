<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 16 Feb 2019 09:41:37 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Comentario
 *
 * @property int $ID
 * @property int $IDInspeccion
 * @property string $Descripcion
 * @property int $IDUsers_created
 * @property \Carbon\Carbon $created_at
 *
 * @property \App\Models\Inspeccion $inspeccion
 *
 * @package App\Models
 */
class Comentario extends Eloquent
{
    protected $table = 'comentario';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $casts = [
        'IDInspeccion' => 'int',
        'IDUsers_created' => 'int'
    ];

    protected $fillable = [
        'IDInspeccion',
        'Descripcion',
        'IDUsers_created'
    ];

    public function inspeccion()
    {
        return $this->belongsTo(\App\Models\Inspeccion::class, 'IDInspeccion');
    }
}
