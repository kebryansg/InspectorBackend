<?php

namespace App\Http\Controllers;

use App\Models\Componente;
use App\Models\Seccion;
use App\Models\SeccionComponente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComponenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Componente = Componente::join('Tipocomp', 'Tipocomp.ID', 'IDTipoComp')
            ->select(['Componente.*', 'Tipocomp.Descripcion as Tipocomp'])
            ->paginate($request->input('psize'));
        return response($Componente, 201);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function combo(Request $request)
    {
        $Componente = Componente::where('Estado', 'ACT')->get();
        return response($Componente, 201);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function componente_secioncomponent(Request $request)
    {
//        return response()->json(explode(',', $request->input('Seccion')), 201);
        $Componente = Componente::join('SeccionComponente', 'SeccionComponente.IDComponente', 'Componente.ID')
            ->join('Seccion', 'Seccion.ID', 'SeccionComponente.IDSeccion')
            ->where('Componente.Estado', 'ACT')
            ->whereIn('Seccion.ID', explode(',', $request->input('Seccion')))
            ->get(['SeccionComponente.ID', 'Componente.Descripcion', 'SeccionComponente.IDSeccion']);
        return response($Componente, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function componente_secion(Request $request)
    {
        $Componente = Componente::leftJoin('SeccionComponente', 'SeccionComponente.IDComponente', 'Componente.ID')
            ->where('Componente.Estado', 'ACT')
            ->get(['Componente.*', 'SeccionComponente.IDSeccion', 'SeccionComponente.Estado as SEstado']);
        return response($Componente, 201);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function componente_secion_store(Request $request, $id)
    {
        $Seccion = Seccion::with('seccioncomponentes')->find($id);
        $rows = $request->all();
        $ids = $Seccion->seccioncomponentes->pluck('IDComponente')->toArray();

        $idsNew = array_diff($rows, $ids);
        $Seccion->seccioncomponentes()->createMany(array_map(function ($item) {
            return [
                'IDComponente' => $item
            ];
        }, $idsNew));


        // Update Anteriores

        $idsIntersect = array_intersect($rows, $ids);
        SeccionComponente::where('IDSeccion', $id)
            ->whereIn('IDComponente', $idsIntersect)
            ->update([ 'Estado' => 'ACT' ]);

        // Eliminar ids que no se encontraron
        $idsDelete = array_values(array_diff($ids, $rows));
        if (count($idsDelete)) {
            SeccionComponente::where('IDSeccion', $id)
                ->whereIn('IDComponente', $idsDelete)
                ->update([ 'Estado' => 'INA' ]);
        }

        return response([
            "nuevos" =>  $idsNew,
            "intersect" => $idsIntersect,
            "delete" => $idsDelete
        ], 201);
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
        $Componente = Componente::insertGetId($request->all());
        return response($Componente, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $Componente = Componente::find($id);
        return response($Componente, 201);
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
        $Componente = Componente::find($id);
        $Componente->fill($request->all());
        $Componente->save();
        return response($Componente, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $Componente = Componente::find($id);
        $Componente->Estado = 'INA';
        $Componente->save();
        return response($Componente, 201);
    }
}
