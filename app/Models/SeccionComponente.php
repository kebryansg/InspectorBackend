<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Class Seccioncomponente
 *
 * @property int $ID
 * @property int $IDComponente
 * @property int $IDSeccion
 * @property string $Estado
 *
 * @property \App\Models\Componente $componente
 * @property \App\Models\Seccion $seccion
 * @property \Illuminate\Database\Eloquent\Collection $formcomps
 *
 * @package App\Models
 */
class SeccionComponente extends Model
{
    protected $table = 'seccioncomponente';
    public $timestamps = false;
    protected $primaryKey = 'ID';


    protected $casts = [
        'ID' => 'int',
        'IDSeccion' => 'int',
        'IDComponente' => 'int'
    ];

    protected $fillable = [
        'IDSeccion',
        'IDComponente',
        'Estado'
    ];

    public function componente()
    {
        return $this->belongsTo(\App\Models\Componente::class, 'IDComponente');
    }

    public function seccion()
    {
        return $this->belongsTo(\App\Models\Seccion::class, 'IDSeccion');
    }

    public function formcomps()
    {
        return $this->hasMany(\App\Models\Formcomp::class, 'IDSeccionComponente');
    }
}
