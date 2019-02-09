<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeviceController extends Controller
{
    public function index(Request $request){
        $Devices = Device::paginate($request->input('psize'));
        return response($Devices, 201);
    }

    public function store(Request $request)
    {
        $MAC = $request->input('MAC');
//        $get_mac_filtered = preg_replace('/^([a-fA-F0-9]{2}:){5}[a-fA-F0-9]{2}$/', '', $MAC);
//        if (!empty($get_mac_filtered)) {
//            return response()->json([
//                "status" => false,
//                "message" => "MAC no es valida."
//            ], 200);
//        }

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

    public function aprobarDevice(Request $request, $id ){
        $Device = Device::find($id);
        $Device->Autorizado = $request->input('permiso');
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

    public function SyncInspeccion(Request $request){
        $Inspeccions = \App\Models\Inspeccion::whereNotNull('IDColaborador')->where('Estado', 'PEN')->where('InspWeb', 0)
            ->get([
                'Inspeccion.ID',
                'Inspeccion.FechaTentativa',
                'IDEmpresa',
                'Inspeccion.IDColaborador',
                'Inspeccion.IDFormulario',
                'Inspeccion.Estado'
            ]);
        $Empresas = \App\Models\Empresa::whereIn('ID', $Inspeccions->pluck('IDEmpresa'))->get();

        foreach ($Inspeccions as $Inspeccion) {
            $Empresa = $Empresas->firstWhere('ID', $Inspeccion['IDEmpresa']);
            $Empresa["IDExterno"] = $Empresa["ID"];
            unset($Empresa["ID"]);
            $Inspeccion["Empresa"] = $Empresa;
//            unset($Inspeccion['IDEmpresa']);
        }

        return response()->json($Inspeccions, 200);
    }

    public function SyncFormulario(Request $request){
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

    public function SyncActEconomica(){
        $Acteconomica = \App\Models\Acteconomica::with(
            ['tipoacteconomicas.clasificacions' => function ($query) {
                return $query->whereNotNull('IDFormulario');
            }])
            ->has('tipoacteconomicas.clasificacions')
            ->get();
        return response()->json($Acteconomica, 200);

    }


    #endregion
}
