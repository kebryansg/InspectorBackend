<?php

namespace App\Http\Controllers;

use App\Models\Acttarifario;
use App\Models\Grupo;
use App\Models\GrupoCategoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Grupo = Grupo::where('Estado', 'ACT')->paginate($request->input('psize'));
        return response($Grupo, 201);
    }

    #region CRUD

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function combo(Request $request)
    {
        $Grupo = Grupo::with([
            'acttarifarios' => function ($query) {
                $query->orderBy('Nombre');
            },
            'categorium'
        ])->where('Estado', 'ACT')->orderBy('Nombre')->get();
        return response($Grupo, 201);
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
        $Grupo = new Grupo();
        $Grupo->fill($request->all());
        $Grupo->save();
        $Grupo->acttarifarios()->createMany($request->input('actividades'));
        $Grupo->grupocategorium()->createMany($request->input('categoria'));

        return response()->json($Grupo, 201);
    }

    public function storeActividad(Request $request)
    {
        $Acttarifario = new Acttarifario();
        $Acttarifario->fill($request->all());
        $Acttarifario->save();

        return response()->json($Acttarifario, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $Grupo = Grupo::with([
            'acttarifarios' => function ($query) {
                $query->orderBy('Nombre');
            },
            'categorium'
        ])->find($id);
        return response($Grupo, 201);
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
        $Grupo = Grupo::find($id);
        $Grupo->fill($request->all());
        $Grupo->save();

        foreach ($request->input('actividades') as $actividades) {
            $Grupo->acttarifarios()->updateOrCreate(["ID" => $actividades["ID"]], $actividades);
        }

        // Eliminar Todos las categorias asignadas al grupo
        $Grupo->grupocategorium()->delete();
        $Grupo->grupocategorium()->createMany($request->input('categoria'));


        return response()->json($Grupo, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $Grupo = Grupo::find($id);
        $Grupo->Estado = 'INA';
        $Grupo->save();
        return response($Grupo, 201);
    }
}
