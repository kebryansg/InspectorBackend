<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeviceController extends Controller
{
    public function index(Request $request)
    {
        $Devices = Device::paginate($request->input('psize'));
        return response($Devices, 201);
    }

    public function listDevice(){
        $Devices = Device::all([
            'MAC',
            'Nombre'
        ]);
        return response()->json($Devices, 200);
    }

    public function store(Request $request)
    {
        $MAC = $request->input('MAC');

        if (Device::where('MAC', $MAC)->exists()) {
            return response()->json([
                "status" => false,
                "message" => "Dispositivo ya está registrado."
            ], 201);
        }

        $Device = new Device();
        $Device->MAC = $MAC;
        $Device->TokenFCM = $request->input('TokenFCM');
        $Device->Token = str_random(64);
        $Device->Autorizado = 0;
        $Device->save();

        return response()->json([
            "status" => true,
            "Token" => $Device->Token
        ], 200);


    }

    public function aprobarDevice(Request $request, $id)
    {
        $Device = Device::find($id);
        $Device->Autorizado = $request->input('permiso');
        $Device->save();

        return response($Device, 201);

    }

    public function asignarNombre(Request $request, $id)
    {
        $Device = Device::find($id);
        $Device->Nombre = $request->input('Nombre');
        $Device->save();
        return response($Device, 201);
    }

    #region DownloadInfo

    public function SyncColaborador(Request $request)
    {
        $colaboradors = \App\Models\Colaborador::where('IDCargo', 2)->get();
        $rows = [];
        foreach ($colaboradors as $Colaborador) {
            $rows[] = [
                'ID' => $Colaborador->ID,
                'Cedula' => $Colaborador->Cedula,
                'Email' => $Colaborador->Email,
                'Nombre' => $Colaborador->ApellidoPaterno . ' ' . $Colaborador->ApellidoMaterno . ' ' . $Colaborador->NombrePrimero,
                'Created_at' => $Colaborador->created_at->getTimestamp(),
                'Updated_at' => $Colaborador->updated_at->getTimestamp(),
            ];
        }
        return response()->json($rows, 200);
    }

    public function SyncInspeccion(Request $request)
    {
        $Inspeccions = \App\Models\Inspeccion::whereNotNull('IDColaborador')->where('Estado', 'PEN')->where('InspWeb', 0)
            ->get([
                'Inspeccion.ID',
                'Inspeccion.FechaTentativa',
                DB::raw("ultima_reinps(IDRef) as UlTimaReinsp"),
                'IDEmpresa',
                'Inspeccion.IDColaborador',
                'Inspeccion.IDFormulario',
                'Inspeccion.Estado',
                'Inspeccion.created_at as FechaRegistro',
            ]);
        $Empresas = \App\Models\Empresa::whereIn('ID', $Inspeccions->pluck('IDEmpresa'))->get([
            'ID',
            'RUC',
            'RazonSocial',
            'NombreComercial',
            'TipoContribuyente',
            'Direccion',
            'Referencia',
            'Telefono',
            'Celular',
            'Email',
            'Latitud',
            'Longitud',
            'IDTarifaGrupo',
            'IDTarifaActividad',
            'IDTarifaCategoria',
        ]);

        foreach ($Inspeccions as $Inspeccion) {
            $Empresa = $Empresas->firstWhere('ID', $Inspeccion['IDEmpresa']);
            $Empresa["IDExterno"] = $Empresa["ID"];

            $Inspeccion["Empresa"] = $Empresa;
            unset($Empresa["ID"]);
        }

        return response()->json($Inspeccions, 200);
    }

    public function SyncFormulario(Request $request)
    {
        $query = \App\Models\Formulario::with(
            ['seccions.componentes' => function ($query) {
                return $query->where('Estado', 'ACT');
            }])
            ->select([
                'ID', 'Descripcion', 'Observacion', 'Estado',
                DB::raw('UNIX_TIMESTAMP(created_at) as Created_at'),
                DB::raw('UNIX_TIMESTAMP(updated_at) as Updated_at')
            ])
            ->has('seccions.componentes')
            ->where('Formulario.Estado', 'ACT');

        /* Agregar condición para saber si es solo uno  */
        if ($request->input('ID')) {
            $query->where('Formulario.ID', $request->input('ID'));
        }
        $Formularios = $query->get();

        return response()->json($Formularios, 200);
    }

    public function SyncActEconomica()
    {
        $Acteconomica = \App\Models\Acteconomica::with(
            ['tipoacteconomicas.clasificacions' => function ($query) {
                return $query->whereNotNull('IDFormulario');
            }])
            ->has('tipoacteconomicas.clasificacions')
            ->get();
        return response()->json($Acteconomica, 200);

    }

    public function SyncGrupoEconomico()
    {
        $GrupoEco = \App\Models\Grupo::with(
            [
                'acttarifarios' => function ($query) {
                    $query->orderBy('Nombre');
                },
                'categorium'
            ]
        )->has('acttarifarios')->has('categorium')->get();
        return response()->json($GrupoEco, 200);

    }


    #endregion
}
