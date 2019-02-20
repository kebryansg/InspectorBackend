<?php

namespace App\Http\Controllers;

use App\Models\Categorium;
use App\Models\Grupo;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Categorium = Categorium::where('Estado', 'ACT')->paginate($request->input('psize'));
        return response($Categorium, 201);
    }

    #region CRUD

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function combo(Request $request)
    {
        $Categorium = null;
        if($request->input('grupo')){
            $idGrupo = $request->input('grupo');
            $Grupo = Grupo::with('grupocategorium')->where('ID', $idGrupo)->first();
            $idsCategoria = $Grupo->grupocategorium()->pluck('IDCategoria');
            $Categorium = Categorium::whereNotIn('ID', $idsCategoria)->get();
            return response($Categorium, 201);
        }

        $Categorium = Categorium::where('Estado', 'ACT')->get();
        return response($Categorium, 201);
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
        $Categorium = new Categorium();
        $Categorium->fill($request->all());
        $Categorium->save();
        return response($Categorium, 201);
    }


    public function storeGrupo(Request $request, $grupo)
    {
        $Categorium = new Categorium();
        $Categorium->fill($request->all());
        $Categorium->save();
        $Categorium->grupocategorium()->create(["IDGrupo" => $grupo]);
        return response($Categorium, 201);
    }

    public function asignGrupo(Request $request, $grupo){
        $Grupo = Grupo::find($grupo);
        $Grupo->grupocategorium()->createMany( $request->all() );
        return response($Grupo, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $Categorium = Categorium::find($id);
        return response($Categorium, 201);
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
        $Categorium = Categorium::find($id);
        $Categorium->fill($request->all());
        $Categorium->save();
        return response($Categorium, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $Categorium = Categorium::find($id);
        $Categorium->Estado = 'INA';
        $Categorium->save();
        return response($Categorium, 201);
    }
}
