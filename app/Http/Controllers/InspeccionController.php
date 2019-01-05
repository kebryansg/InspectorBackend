<?php

namespace App\Http\Controllers;

use App\Models\Clasificacion;
use App\Models\Empresa;
use App\Models\Formulario;
use App\Models\Inspeccion;
use App\Models\Parametro;
use Carbon\Carbon;
//use Firebase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Morrislaptop\Firestore\Factory;
use Kreait\Firebase\ServiceAccount;

class InspeccionController extends Controller
{
    private $firestore;

    public function __construct()
    {
        $serviceAccount = ServiceAccount::fromJsonFile(dirname(dirname(__DIR__)) . '/secret/inspector-7933a.json');
        $this->firestore = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->createFirestore();
    }

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
        $Inspeccion = new Inspeccion();

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
            $Inspeccion->fill($request->all());
            $Inspeccion->UsuarioRegistro = $request->user()->id;
            $Inspeccion->Estado = 'PEN';
            $Inspeccion->IDFormulario = Clasificacion::join('Empresa', 'Empresa.IDClasificacion', 'Clasificacion.ID')->where('Empresa.ID', $Inspeccion->IDEmpresa)->first()->IDFormulario;
            $Inspeccion->save();
            DB::commit();
            if (!Utilidad::Online())
                return response()->json($Inspeccion, 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json($exception->getMessage(), 201);
        }
        $this->uploadFirebase($Inspeccion);
        return response()->json($Inspeccion, 201);

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
        DB::beginTransaction();
        try {
            $Inspeccion = Inspeccion::find($id);
            $Inspeccion->update([
                'IDColaborador' => $colaborador,
                'FechaTentativa' => Carbon::now()->addDays($days),
                'UsuarioUpdate' => $request->user()->id
            ]);
            DB::commit();
            if (!Utilidad::Online())
                return response()->json($Inspeccion, 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json($exception->getMessage(), 500);
        }
        $this->uploadFirebase($Inspeccion);
        return response()->json($Inspeccion, 201);

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

    private function uploadFirebase(Inspeccion $Inspeccion)
    {
        $DataFirebase = null;
        if ($Inspeccion->IDColaborador) {
            $DataFirebase = [
                'ID' => $Inspeccion->ID,
                'FechaTentativa' => Carbon::createFromFormat('Y-m-d\TH:i:s+', $Inspeccion->FechaTentativa)->format('Y-m-d'),
                'IDFormulario' => $Inspeccion->IDFormulario,
                'IDColaborador' => $Inspeccion->IDColaborador,
                'Empresa' => Empresa::where('ID', $Inspeccion->IDEmpresa)
                    ->first([
                        'ID',
                        'RUC',
                        'RazonSocial',
                        'NombreComercial',
                        'TipoContribuyente',
                        'Direccion',
                        'Telefono',
                        'Celular',
                        'Email'
                    ])->toArray()
            ];

            $document = $this->firestore->collection('inspeccion')->document('insp_' . $Inspeccion->ID);
            $document->set($DataFirebase);
            $Inspeccion->firebase_at = Carbon::now();
            $Inspeccion->save();
        }
    }

}
