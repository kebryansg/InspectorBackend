<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 15 Dec 2018 04:36:22 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Empresa
 *
 * @property int $ID
 * @property int $IDEntidad
 * @property int $IDSector
 * @property int $IDExterno
 * @property string $RUC
 * @property string $RazonSocial
 * @property string $NombreComercial
 * @property string $TipoContribuyente
 * @property bool $ObligContabilidad
 * @property bool $ContEspecial
 * @property string $Direccion
 * @property string $Telefono
 * @property string $Celular
 * @property string $Email
 * @property string $Estado
 * @property string $Referencia
 * @property string $Latitud
 * @property string $Longitud
 * @property string $EstadoAplicacion
 * @property int $IDActEconomica
 * @property int $IDTarifaGrupo
 * @property int $IDTarifaActividad
 * @property int $IDTarifaCategoria
 * @property int $IDTipoEmpresa
 *
 * @property \App\Models\Categorium $categorium
 * @property \App\Models\Acteconomica $acteconomica
 * @property \App\Models\Tipoempresa $tipoempresa
 * @property \App\Models\Entidad $entidad
 * @property \App\Models\Sector $sector
 * @property \App\Models\Grupo $grupo
 * @property \App\Models\Acttarifario $acttarifario
 * @property \Illuminate\Database\Eloquent\Collection $inspeccions
 *
 * @package App\Models
 */
class Empresa extends Eloquent
{
    protected $table = 'empresa';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $casts = [
        'IDEntidad' => 'int',
        'IDSector' => 'int',
        'IDExterno' => 'int',
        'ObligContabilidad' => 'bool',
        'ContEspecial' => 'bool',
        'IDActEconomica' => 'int',
        'IDTarifaGrupo' => 'int',
        'IDTarifaActividad' => 'int',
        'IDTarifaCategoria' => 'int',
        'IDTipoEmpresa' => 'int'
    ];

    protected $fillable = [
        'IDEntidad',
        'IDSector',
        'IDExterno',
        'RUC',
        'RazonSocial',
        'NombreComercial',
        'TipoContribuyente',
        'ObligContabilidad',
        'ContEspecial',
        'Direccion',
        'Telefono',
        'Celular',
        'Email',
        'Estado',
        'Referencia',
        'Latitud',
        'Longitud',
        'EstadoAplicacion',
        'IDActEconomica',
        'IDTarifaGrupo',
        'IDTarifaActividad',
        'IDTarifaCategoria',
        'IDTipoEmpresa'
    ];

    public function categorium()
    {
        return $this->belongsTo(\App\Models\Categorium::class, 'IDTarifaCategoria');
    }

    public function acteconomica()
    {
        return $this->belongsTo(\App\Models\Acteconomica::class, 'IDActEconomica');
    }

    public function tipoempresa()
    {
        return $this->belongsTo(\App\Models\Tipoempresa::class, 'IDTipoEmpresa');
    }

    public function entidad()
    {
        return $this->belongsTo(\App\Models\Entidad::class, 'IDEntidad');
    }

    public function sector()
    {
        return $this->belongsTo(\App\Models\Sector::class, 'IDSector');
    }

    public function grupo()
    {
        return $this->belongsTo(\App\Models\Grupo::class, 'IDTarifaGrupo');
    }

    public function acttarifario()
    {
        return $this->belongsTo(\App\Models\Acttarifario::class, 'IDTarifaActividad');
    }

    public function inspeccions()
    {
        return $this->hasMany(\App\Models\Inspeccion::class, 'IDEmpresa');
    }
}
