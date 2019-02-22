<?php

namespace App\Http\Controllers;

use App\Models\Clasificacion;
use App\Models\Comentario;
use App\Models\Empresa;
use App\Models\Formulario;
use App\Models\Inspeccion;
use App\Models\Institucion;
use App\Models\Observacion;
use App\Models\Parametro;
use App\Models\Rseccion;
use Carbon\Carbon;
use GrahamCampbell\Flysystem\Facades\Flysystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Morrislaptop\Firestore\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase;
use Barryvdh\DomPDF\Facade as PDF;

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

    #region CRUD

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Other = json_decode($request->input('other'), true);
        $search = $request->input('search');
        $query = Inspeccion::with('empresa', 'colaborador');

        if ($Other["Estado"] !== '*')
            if ($Other["Estado"] == 'REI')
                $query->where('Estado', 'REP')->whereNotNull('FechaPlazo');
            else
                $query->where('Estado', $Other["Estado"]);

        if ($Other["Colaborador"] !== '*')
            $query->where('IDColaborador', $Other["Colaborador"]);

        if ($Other["Desde"] !== '*')
            $query->whereBetween('created_at', [$Other["Desde"] . " 00:00:00", $Other["Hasta"] . " 23:59:59"]);

        if ($search) {
            $query->whereHas('empresa', function ($query) use ($search) {
                $query->where('RUC', 'like', "%$search%");
                $query->orWhere('RazonSocial', 'like', "%$search%");
                $query->orWhere('NombreComercial', 'like', "%$search%");
            });
        }
        $query->orderByDesc('created_at');
        $Inspeccion = $query->paginate($request->input('psize'));
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

//        whereYear('created_at', '2016')

//      Validación
        if (Inspeccion::where('IDEmpresa', $data['IDEmpresa'])->where('Estado', 'PEN')->whereYear('created_at', Carbon::now()->year)->exists()) {
            return response()->json([
                'message' => 'Para la Empresa en cuestión ya existe una Inspección pendiente.'
            ], 409);
        }

        DB::beginTransaction();
        try {
            $Inspeccion->fill($request->all());
            $Inspeccion->UsuarioRegistro = $request->user()->id;
            $Inspeccion->Estado = 'PEN';
            $Inspeccion->IDFormulario = Parametro::where('Abr', 'FORMD')->first()->Valor;
            $Inspeccion->save();
            DB::commit();
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
        $Inspeccion = Inspeccion::with([
            'empresa' => function ($query) {
                $query->with('sector', 'acteconomica');
                return $query;
            },
            'colaborador',
            'formulario',
            'observacions',
            'comentarios'
        ])
            ->where('ID', $id)
            ->first();
        return response()->json($Inspeccion, 200);
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

    #endregion

    public function dashboard()
    {

        $data["TotalesEstado"] = Inspeccion::select('Estado', DB::raw('count(*) as total'))
            ->groupBy('Estado')
            ->pluck('total', 'Estado')->all();

        $data["TotalesMes"] = [
            "Total" => Inspeccion::count(),
            "MesActual" => Inspeccion::whereMonth('created_at', Carbon::now()->month)->count(),
            "MesAnterior" => Inspeccion::whereMonth('created_at', Carbon::now()->month - 1)->count()
        ];

        return response()->json($data, 200);
    }

    public function upload(Request $request, $id)
    {
        $Inspeccion = Inspeccion::find($id);
        if (!Utilidad::Online())
            return response()->json('No Actualizado', 201);

        $this->uploadFirebase($Inspeccion);
        return response()->json('Actualizado', 201);
    }

    private function uploadFirebase(Inspeccion $Inspeccion)
    {
        if (!$Inspeccion->InspWeb)
            // Comprobar Internet
            if (Utilidad::Online()) {
                $DataFirebase = null;
                if ($Inspeccion->IDColaborador) {
                    $DataFirebase = [
                        'ID' => $Inspeccion->ID,
                        'FechaTentativa' => $Inspeccion->FechaTentativa->format('Y-m-d'),
                        'FechaRegistro' => $Inspeccion->created_at->format('Y-m-d'),
                        'IDFormulario' => $Inspeccion->IDFormulario,
                        'IDColaborador' => $Inspeccion->IDColaborador,
                        'Estado' => $Inspeccion->Estado,
                        'IDEmpresa' => $Inspeccion->IDEmpresa,
                        'UlTimaReinsp' => DB::selectOne("Select ultima_reinps(?) as UlTimaReinsp", [$Inspeccion->IDRef])->UlTimaReinsp,
                        'Empresa' => Empresa::where('ID', $Inspeccion->IDEmpresa)
                            ->first([
                                'ID as IDExterno',
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
                            ])->toArray()
                    ];

                    $document = $this->firestore->collection('inspeccion')->document('insp_' . $Inspeccion->ID);
                    $document->set($DataFirebase);
                    $Inspeccion->firebase_at = Carbon::now();
                    $Inspeccion->save();
                }
            }
    }

    #region "Sync Firebase - Device"

    public function syncInspeccionDevice(Request $request, $id)
    {
        $Inspeccion = Inspeccion::find($id);
        if ($Inspeccion->Estado == 'PEN') {
            $Inspeccion->fill($request->all());
            $Inspeccion->MedioUpdate = 'DEV';
            $Inspeccion->save();

            if ($Inspeccion->FechaPlazo)
                $this->InsertReinspeccion($Inspeccion);

            $rows = $request->input('result');
            $this->saveResult($rows, $id);
            $this->saveObservacions($request->input('Observacions'), $Inspeccion);

            // Cambio de Categoria
            $CategoriaOld = Empresa::find($Inspeccion->IDEmpresa)->IDTarifaCategoria;
            if ($CategoriaOld != $request->input('IDTarifaCategoria')) {
                Empresa::where('ID', $Inspeccion->IDEmpresa)
                    ->update(['IDTarifaCategoria' => $request->input('IDTarifaCategoria')]);
            }

            return response()->json([
                "status" => true
            ], 201);
        } else {
            return response()->json([
                "status" => true
            ], 201);
        }

    }

    public function syncInspeccionFirebase(Request $request, $id)
    {

        try {
            // Reinspeccion
            $Inspeccion = Inspeccion::find($id);
            if ($Inspeccion->FechaPlazo)
                $this->InsertReinspeccion($Inspeccion);

            Utilidad::CrearDirectorioInspeccion($id);

            $storage = $this->firebase->getStorage();
            $bucket = $storage->getBucket();
            $options = ['prefix' => 'Inspeccion/insp_' . $id . '/'];
            foreach ($bucket->objects($options) as $object) {
                $destination = Utilidad::getPathPublic() . ('/Imgs/' . $object->name());
                $type = substr($object->name(), strrpos($object->name(), '.') + 1);

                if ($type !== 'json') $object->downloadToFile($destination);
                else {
                    $stream = $object->downloadAsStream();
                    $rows = json_decode($stream->getContents(), true);
                    $this->saveResult($rows, $id);
                }

            }
            return response()->json([
                "status" => true
            ], 201);
        } catch (\Exception $exception) {
            return response()->json([
                "status" => false,
                "message" => $exception->getMessage()
            ], 201);
        }

    }

    public function filesFirebase(Request $request, $id)
    {
        try {
            $storage = $this->firebase->getStorage();
            $bucket = $storage->getBucket();
//            $options = ['prefix' => 'Inspeccion/insp_' . $id . '/'];
            $options = ['prefix' => 'Formulario/'];
            foreach ($bucket->objects($options) as $object) {
                $destination = __DIR__ . ('/Imgs/' . $object->name());
                $type = substr($object->name(), strrpos($object->name(), '.') + 1);

                $object->downloadToFile($destination);

            }
            return response()->json([
                "status" => true,
            ], 201);
        } catch (\Exception $exception) {
            return response()->json([
                "status" => false,
                "message" => $exception->getMessage()
            ], 200);
        }
    }

    private function saveResult($rows, $id)
    {
        foreach ($rows as $row) {
            $Seccion = new Rseccion();
            $Seccion->fill($row);
            $Seccion->IDInspeccion = $id;
            $Seccion->save();
            $Seccion->rcomponentes()->createMany($row['componentes']);
        }
    }

    public function organizarInspeccion($id)
    {
        $collection = $this->firestore->collection('inspeccion');
        $collection->document("insp_$id")->delete();
    }

    private function saveObservacions($Observacions, $Inspeccion)
    {
        Observacion::where('IDInspeccion', $Inspeccion->ID)->delete();
        $rows = [];
        if ($Observacions) {
            foreach ($Observacions as $observacion) {
                $rows[] = ["Observacion" => $observacion];
            }
            if (count($rows) > 0)
                $Inspeccion->observacions()->createMany($rows);
        }

    }

    #endregion

    public function readAnexos(Request $request, $id)
    {
        $streams = [];
        $contents = Utilidad::ListarDirectorioInspeccion($id);
        foreach ($contents as $content) {
            $streams[] = 'Imgs/' . $content["path"];
        }
        return response()->json($streams, 200);
    }

    #region PDF
    private function generatePDF($id)
    {
        $Inspeccion = Inspeccion::with([
            'empresa' => function ($query) {
                $query->with('sector', 'acteconomica');
                return $query;
            },
            'colaborador',
            'formulario',
            'observacions'
        ])->where('ID', $id)->first();

        $data = Rseccion::with('rcomponentes')->where('IDInspeccion', $Inspeccion->ID)->get();

        $contents = Flysystem::listContents('/Inspeccion/insp_' . $Inspeccion->ID . '/Anexos/', true);

        $Anexos = array();
        foreach ($contents as $object) {
            $Anexos[] = $object['path'];
        }
        return PDF::loadView('form_inspeccion', array('formulario' => $data, 'Anexos' => $Anexos, 'Inspeccion' => $Inspeccion))->setPaper('a4');
    }

    public function generateSolicitudPDF($id)
    {
        $Inspeccion = Inspeccion::with([
            'empresa' => function ($query) {
                $query->with('sector.parroquium', 'acteconomica', 'entidad');
                return $query;
            },
            'colaborador',
            'formulario',
            'observacions',
        ])->where('ID', $id)->first();
        return PDF::loadView('solicitud', array('Inspeccion' => $Inspeccion))->setPaper('a4')->stream();
    }

    public function viewPDF(Request $request, $id)
    {
        $pdf = $this->generatePDF($id);
        return $pdf->stream('download.pdf');
    }

    public function downloadPDF(Request $request, $id)
    {
        $pdf = $this->generatePDF($id);
        return $pdf->download("Insp_$id.pdf");
    }

    #endregion

    #region Mail
    public function sendMail(Request $request, $id)
    {
        if (!Utilidad::Online())
            return response()->json([
                "status" => false,
                "message" => "No hay conexión a Internet"
            ], 201);

        $Inspeccion = Inspeccion::with('empresa')->where('ID', $id)->first();

        if ($Inspeccion->Empresa->Email) {
            $pdf = $this->generatePDF($id);
            $email = $Inspeccion->Empresa->Email;
            Mail::send('mail', [], function ($message) use ($pdf, $email) {

                $message->to($email)
                    ->from(env('MAIL_USERNAME'), Institucion::first()->Nombre)
                    ->subject('Informe de Inspección')
                    ->attachData($pdf->output(), 'Formulario.pdf');
                return response()->json([
                    "status" => true
                ], 201);

            });
        } else {
            return response()->json([
                "status" => false,
                "message" => "La empresa no cuenta con un correo registrado."
            ], 201);
        }


    }

    #endregion

    public function InsertReinspeccion(Inspeccion $Inspeccion)
    {
        $InspeccionNew = new Inspeccion();
        $InspeccionNew->IDRef = ($Inspeccion->IDRef) ? $Inspeccion->IDRef : $Inspeccion->ID;
        $InspeccionNew->FechaTentativa = $Inspeccion->FechaTentativa;
        $InspeccionNew->UsuarioRegistro = $Inspeccion->UsuarioRegistro;
        $InspeccionNew->Estado = 'PEN';
        $InspeccionNew->IDEmpresa = $Inspeccion->IDEmpresa;
        $InspeccionNew->IDColaborador = $Inspeccion->IDColaborador;
        $InspeccionNew->IDFormulario = $Inspeccion->IDFormulario;
        $InspeccionNew->InspWeb = $Inspeccion->InspWeb;
        $InspeccionNew->save();
        $this->uploadFirebase($InspeccionNew);
    }

    // Resultado del formulario
    public function resultFormulario(Request $request, $id)
    {
        $data = Rseccion::with('rcomponentes')->where('IDInspeccion', $id)->get();
        return response()->json($data, 200);
    }

    public function getInspeccionSync(Request $request)
    {
        if (!Utilidad::Online())
            return response()->json([
                "status" => false,
                "count" => 0
            ], 200);

        $Inspecccions = Inspeccion::whereNotNull('IDColaborador')->whereNull('firebase_at')->get();

        foreach ($Inspecccions as $Inspecccion) {
            $this->uploadFirebase($Inspecccion);
        }
        return response()->json([
            "status" => true,
            "count" => count($Inspecccions)
        ], 200);
    }

    public function addComentario(Request $request, $id)
    {
        $Comentario = new Comentario();
        $Comentario->fill($request->all());
        $Comentario->IDUsers_created = $request->user()->id;
        $Comentario->IDInspeccion = $id;
        $Comentario->save();
        return response()->json($Comentario, 201);
    }
}
