<?php

namespace App\Http\Controllers;

use App\Models\Clasificacion;
use App\Models\Empresa;
use App\Models\Formulario;
use App\Models\Inspeccion;
use App\Models\Parametro;
use Carbon\Carbon;
//use Firebase;
use GrahamCampbell\Flysystem\Facades\Flysystem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Morrislaptop\Firestore\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase;

class InspeccionController extends Controller
{
    private $firestore;
    private $firebase;

    public function __construct()
    {
        // Firebase
        $serviceAccount = ServiceAccount::fromJsonFile(dirname(dirname(__DIR__)) . '/secret/inspector-7933a.json');
        $this->firestore = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->createFirestore();

        $this->firebase = (new Firebase\Factory())
            ->withServiceAccount($serviceAccount)
            ->create();
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

        $result = [];

        $destination = storage_path('files/form_1.json');
        $storage = $this->firebase->getStorage();
        $bucket = $storage->getBucket();
        $options = ['prefix' => 'Inspeccion/'];
        foreach ($bucket->objects($options) as $object) {
            $result[] = ('Object: ' . $object->name());
        }
        return response()->json($result, 201);


//        $object = $bucket->object('Formulario/form_2.json');
//        $object->downloadToFile($destination);
//
//        return basename($destination);

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

//         Validación
        if (Inspeccion::where('IDEmpresa', $data['IDEmpresa'])->where('Estado', 'PEN')->exists()) {
            return response()->json([
                'message' => 'Para la Empresa en cuestión ya existe una Inspección pendiente.'
            ], 409);
        }

        if (!Formulario::join('Clasificacion', 'Clasificacion.IDFormulario', 'Formulario.ID')
            ->join('Empresa', 'Empresa.IDClasificacion', 'Clasificacion.ID')
            ->where('Empresa.ID', $data['IDEmpresa'])->exists()) {
            return response()->json([
                'message' => 'No existe un formulario asignado para la Actividad Económica de la Empresa.'
            ], 409);
        }

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

    public function upload(Request $request, $id)
    {
        $Inspeccion = Inspeccion::find($id);
//        return response()->json($Inspeccion, 201);
        if (Utilidad::Online()) {
            $this->uploadFirebase($Inspeccion, 'Y-m-d H:i:s');
            return response()->json('Actualizado', 201);
        }
        return response()->json('No Actualizado', 201);
    }

    private function uploadFirebase(Inspeccion $Inspeccion, $format = 'Y-m-d\TH:i:s+')
    {
        $DataFirebase = null;
        if ($Inspeccion->IDColaborador) {
            $DataFirebase = [
                'ID' => $Inspeccion->ID,
                'FechaTentativa' => Carbon::createFromFormat($format, $Inspeccion->FechaTentativa)->format('Y-m-d'),
                'IDFormulario' => $Inspeccion->IDFormulario,
                'IDColaborador' => $Inspeccion->IDColaborador,
                'Estado' => $Inspeccion->Estado,
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


    public function syncInspeccion(Request $request, $id)
    {
        $Inspeccion = Inspeccion::find($id);
        $result = [];

        Utilidad::CrearDirectorioInspeccion($id);

        $storage = $this->firebase->getStorage();
        $bucket = $storage->getBucket();
        $options = ['prefix' => 'Inspeccion/insp_' . $id . '/'];
        foreach ($bucket->objects($options) as $object) {
            $destination = Utilidad::getPathPublic() . ('/Imgs/' . $object->name());
            $object->downloadToFile($destination);
        }

        return response()->json($result, 201);
    }

    public function readAnexos(Request $request, $id)
    {

        $streams = [];
        $contents = Utilidad::ListarDirectorioInspeccion($id);
        foreach ($contents as $content) {
            $streams[] = 'Imgs/' . $content["path"];
        }
        return response()->json($streams, 200);
    }

}
