<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function componentes()
    {
        return $this->belongsTo(\App\Models\Componente::class, 'IDComponente');
    }

    public function seccions()
    {
        return $this->belongsTo(\App\Models\Seccion::class, 'IDSeccion');
    }
}
