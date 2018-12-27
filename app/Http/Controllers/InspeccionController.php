<?php

namespace App\Http\Controllers;

use App\Models\Clasificacion;
use App\Models\Empresa;
use App\Models\Formulario;
use App\Models\Inspeccion;
use App\Models\Parametro;
use Carbon\Carbon;
use Firebase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InspeccionController extends Controller
{
    private $Firebase_URL = '/inspeccion';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Inspeccion = Inspeccion::with('empresa', 'colaborador')
            ->paginate($request->input('psize'));
        return response()->json($Inspeccion, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        // Validación
//        if (Inspeccion::where('IDEmpresa', $data['IDEmpresa'])->where('Estado', 'PEN')->exists()) {
//            return response()->json([
//                'message' => 'Para la Empresa en cuestión ya existe una Inspección pendiente.'
//            ], 409);
//        }
//
//        if (!Formulario::join('Clasificacion', 'Clasificacion.IDFormulario', 'Formulario.ID')
//            ->join('Empresa', 'Empresa.IDClasificacion', 'Clasificacion.ID')
//            ->where('Empresa.ID', $data['IDEmpresa'])->exists()) {
//            return response()->json([
//                'message' => 'No existe un formulario asignado para la Actividad Económica de la Empresa.'
//            ], 409);
//        }

        DB::beginTransaction();
        try {

            $Inspeccion = new Inspeccion();
            $Inspeccion->fill($request->all());
            $Inspeccion->UsuarioRegistro = $request->user()->id;
            $Inspeccion->Estado = 'PEN';
            $Inspeccion->IDFormulario = Clasificacion::join('Empresa', 'Empresa.IDClasificacion', 'Clasificacion.ID')->where('Empresa.ID', $Inspeccion->IDEmpresa)->first()->IDFormulario;
//            return response()->json($Inspeccion, 201);
            $Inspeccion->save();

            if ($Inspeccion->IDColaborador) {
                $DataFirebase = [
                    'FechaTentativa' => Carbon::createFromFormat('Y-m-d\TH:i:s+', $Inspeccion->FechaTentativa)->format('Y-m-d'),
                    'IDFormulario' => $Inspeccion->IDFormulario
                ];
                Firebase::set($this->Firebase_URL . ('/colb_' . $Inspeccion->IDColaborador) . ('/insp_' . $Inspeccion->ID), $DataFirebase);
            }
            DB::commit();
            return response()->json($Inspeccion, 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json($exception->getMessage(), 201);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function inspeccion_colaborador(Request $request, $id, $colaborador)
    {
        $days = Parametro::where('Abr', 'MDINP')->first()->Valor;
        $FechaTentativa = Carbon::now()->addDays($days);
        DB::beginTransaction();
        try{
            $Inspeccion = Inspeccion::find($id);
            $bandera = $Inspeccion->update([
                'IDColaborador' => $colaborador,
                'FechaTentativa' => Carbon::now()->addDays($days),
                'UsuarioUpdate' => $request->user()->id
            ]);

            if ($bandera) {
                $DataFirebase = [
                    'FechaTentativa' => $FechaTentativa->format('Y-m-d'),
                    'IDFormulario' => $Inspeccion->IDFormulario
                ];
                Firebase::set($this->Firebase_URL . ('/colb_' . $colaborador) . ('/insp_' . $Inspeccion->ID), $DataFirebase);
            }

            DB::commit();
            return response()->json($Inspeccion, 201);
        }catch (\Exception $exception){
            DB::rollBack();
            return response()->json($exception->getMessage(), 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $Inspeccion = Inspeccion::find($id)->update([
            'Estado' => 'INA',
            'UsuarioUpdate' => $request->user()->id
        ]);
        return response()->json($Inspeccion, 201);
    }
}
