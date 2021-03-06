<?php

namespace App\Http\Controllers;

use App\Models\Componente;
use App\Models\Formcomp;
use App\Models\Formulario;
use App\Models\Seccion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Morrislaptop\Firestore\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase;

class FormularioController extends Controller
{

    private $firestore;
    private $firebase;

    public function __construct()
    {

        // Descargar Archivo al navegador
        //return response($data, 200, [ 'Content-Type:' =>' application/json', 'Content-Disposition' => 'attachment; filename="result.json"', ]);


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
        $Formulario = Formulario::paginate($request->input('psize'));
        return response($Formulario, 201);
    }

    #region CRUD


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function combo(Request $request)
    {
        $Formulario = Formulario::where('Estado', 'ACT')->get();
        return response($Formulario, 201);
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
//        $Formulario = Formulario::insertGetId($request->all());
        $Formulario = new Formulario;
        $Formulario->fill($request->all());
        $Formulario->IDUsers_created = $request->user()->id;
        $Formulario->save();
        if (!Utilidad::Online())
            return response()->json($Formulario, 201);

        $this->uploadFirebase($Formulario);
        return response()->json($Formulario, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $Formulario = Formulario::find($id);
        return response($Formulario, 200);
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
        $Formulario = Formulario::find($id);
        $Formulario->fill($request->all());
        $Formulario->IDUsers_updated = $request->user()->id;
        $Formulario->save();
        if (!Utilidad::Online())
            return response()->json($Formulario, 201);

        $this->uploadFirebase($Formulario);
        return response()->json($Formulario, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $Formulario = Formulario::find($id);
        $Formulario->IDUsers_updated = $request->user()->id;
        $Formulario->Estado = 'INA';
        $Formulario->save();
        return response($Formulario, 201);
    }
    #endregion

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function seccion_formulario_full(Request $request, $form)
    {
        $Seccions = Seccion::with(['componentes' => function ($query) {
            return $query->where('Estado', 'ACT');
        }])
            ->where('IDFormulario', $form)
            ->where('Estado', 'ACT')
            ->get();
        return response()->json($Seccions, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function seccion_formulario_config(Request $request, $form)
    {
        $Seccions = Seccion::with('componentes.tipocomp')->where('IDFormulario', $form)->get();
        return response()->json($Seccions, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function seccion_formulario_store(Request $request, $form)
    {
        $rows = $request->all();

        DB::beginTransaction();
        try {
            foreach ($rows as $row) {
                if ($row['ID'] == 0) {
                    $seccion = new Seccion();
                    $seccion->IDFormulario = $form;
                    $seccion->fill($row);
                    $seccion->save();

                    $seccion->componentes()->createMany($row['componentes']);
                } else {
                    $seccion = Seccion::find($row['ID']);
                    $seccion->fill($row);
                    $seccion->save();

                    $Updates = collect($row['componentes'])->filter(function ($value, $key) {
                        return $value["ID"] != 0;
                    })->values();

                    foreach ($Updates as $update) {
                        Componente::find($update['ID'])
                            ->update(
                                $update
                            );
                    }

                    $Nuevos = collect($row['componentes'])->filter(function ($value, $key) {
                        return $value["ID"] == 0;
                    })->values();
                    $seccion->componentes()->createMany($Nuevos->toArray());

                }
            }

            Formulario::where('ID', $form)
                ->update([
                    'IDUsers_updated' => $request->user()->id
                ]);
            DB::commit();

            return response()->json([], 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::info($exception->getMessage());
            return response()->json([], 201);
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function seccion_formulario(Request $request, $form)
    {
        $Seccion = Formulario::join('FormComp', 'FormComp.IDFormulario', 'Formulario.ID')
            ->join('SeccionComponente', 'SeccionComponente.ID', 'FormComp.IDSeccionComponente')
            ->join('Seccion', 'Seccion.ID', 'SeccionComponente.IDSeccion')
            ->where('Formulario.ID', $form)
            ->where('Seccion.Estado', 'ACT')
            ->groupby('Seccion.ID')
            ->get(['Seccion.*'])->pluck('ID');
        return response($Seccion, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function component_formulario(Request $request, $form)
    {
        $Component = Formulario::join('FormComp', 'FormComp.IDFormulario', 'Formulario.ID')
            ->join('SeccionComponente', 'SeccionComponente.ID', 'FormComp.IDSeccionComponente')
            ->join('Componente', 'Componente.ID', 'SeccionComponente.IDComponente')
            ->where('Formulario.ID', $form)
            ->get(['SeccionComponente.ID', 'FormComp.Estado']);
        return response($Component, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function seccion_store(Request $request, $id)
    {
        $Formulario = Formulario::with('formcomps')->find($id);
        $rows = $request->all();
        $ids = $Formulario->formcomps->pluck('IDSeccionComponente')->toArray();

        $Formulario->formcomps()->createMany(array_filter($rows, function ($row) use ($ids) {
            return !in_array($row["IDSeccionComponente"], $ids);
        }));

        $update_rows = array_filter($rows, function ($row) use ($ids) {
            in_array($row["IDSeccionComponente"], $ids);
        });

        foreach ($update_rows as $row) {
            Formcomp::where('IDFormulario', $id)
                ->where('IDSeccionComponente', $row["IDSeccionComponente"])
                ->update($row);
        }


//        if (count($Formulario->formcomps) > 0) {
//            foreach ($rows as $row) {
//                if (in_array($row["IDSeccionComponente"], $ids)) {
//                    Formcomp::where('IDSeccionComponente', $row["IDSeccionComponente"])
//                        ->update($row);
//                    $ids = array_diff($ids, [$row["IDSeccionComponente"]]);
//
//                } else {
//                    $Formulario->formcomps()->createMany($row);
//                }
//            }
//            // Eliminar Filas que no se encontraron (Update - Insert)
//            if (count($ids)) {
//                Formcomp::whereIn('IDSeccionComponente', $ids)->detele();
//            }
//        } else
//            $Formulario->formcomps()->createMany($rows);

        $Formulario->IDUsers_updated = $request->user()->id;
        $Formulario->save();

        return response()->json($Formulario, 201);
    }

    private function uploadFirebase(Formulario $Formulario)
    {
        $DataFirebase = [
            'ID' => $Formulario->ID,
            'Descripcion' => $Formulario->Descripcion,
            'Observacion' => $Formulario->Observacion,
            'Estado' => $Formulario->Estado,
            'Created_at' => $Formulario->created_at->getTimestamp(),
            'Updated_at' => $Formulario->updated_at->getTimestamp(),
        ];

        $document = $this->firestore->collection('formulario')->document('form_' . $Formulario->ID);
        $document->set($DataFirebase);
        $Formulario->firebase_at = Carbon::now();
        $Formulario->save();
    }


    #region Sync Firebase - Device

    public function syncFormularioFirebase(Request $request)
    {

        try {
            $query = Formulario::with(
                ['seccions.componentes' => function ($query) {
                    return $query->where('Estado', 'ACT');
                }])
                ->has('seccions.componentes')
                ->where('Formulario.Estado', 'ACT');

            /* Agregar condición para saber si es solo uno  */
            if ($request->input('ID')) {
                $query->where('Formulario.ID', $request->input('ID'));
            }
            $Formularios = $query->get();

            foreach ($Formularios as $formulario) {
                $this->uploadFirebase($formulario);
                $data = $formulario->toArray()["seccions"];
                (new Utilidad())->uploadFile($data,'Formulario/form_' . $formulario["ID"] . '.json');
            }

            return response()->json([
                "status" => true
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                "status" => false,
                "message" => $ex->getMessage()
            ], 200);
        }

    }

    public function syncFormularioDevice(Request $request)
    {

        $query = Formulario::with(
            ['seccions.componentes' => function ($query) {
                return $query->where('Estado', 'ACT');
            }])
            ->has('seccions.componentes')
            ->where('Formulario.Estado', 'ACT');

        /* Agregar condición para saber si es solo uno  */
        if ($request->input('ID')) {
            $query->where('Formulario.ID', $request->input('ID'));
        }
        $Formularios = $query->get();

        return response()->json($Formularios, 200);

    }

    #endregion


}
