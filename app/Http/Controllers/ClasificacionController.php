<?php

namespace App\Http\Controllers;

use App\Models\Clasificacion;
use Illuminate\Http\Request;

class ClasificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Clasificacion = Clasificacion::join('TipoActEconomica', 'TipoActEconomica.ID', 'IDTipoActEcon')
            ->join('Acteconomica', 'Acteconomica.ID', 'TipoActEconomica.IDActEconomica')
            ->select(['Clasificacion.*', 'TipoActEconomica.Descripcion as TipoActEconomica', 'Acteconomica.Descripcion as ActEconomica'])
            ->paginate($request->input('psize'));
        return response($Clasificacion, 201);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listAsignFormulario(Request $request)
    {
        $query = Clasificacion::join('TipoActEconomica', 'TipoActEconomica.ID', 'IDTipoActEcon')
            ->join('Acteconomica', 'Acteconomica.ID', 'TipoActEconomica.IDActEconomica')
            ->leftJoin('Formulario', 'Formulario.ID', 'Clasificacion.IDFormulario');

        if ($request->input('IDActEconomica')) {
            $query = $query->where('Acteconomica.ID', $request->input('IDActEconomica'));
        }
        if ($request->input('IDTipoActEconomica')) {
            $query = $query->where('TipoActEconomica.ID', $request->input('IDTipoActEconomica'));
        }
        $Clasificacion = $query->get(['Clasificacion.ID', 'Clasificacion.IDTipoActEcon', 'Clasificacion.Descripcion as Clasificacion', 'TipoActEconomica.Descripcion as Categoria', 'Acteconomica.Descripcion as ActEconomica', 'Formulario.Descripcion as Formulario']);
        return response($Clasificacion, 201);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store_listAsignFormulario(Request $request, $form)
    {
        $result = Clasificacion::whereIn('ID', $request->all())
            ->update([
                "IDFormulario" => $form
            ]);
        return response($result, 201);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function combo(Request $request)
    {
        $Clasificacion = Clasificacion::where('Estado', 'ACT')->where('IDActEconomica', $request->input('ActEconomica'))->get();
        return response($Clasificacion, 201);
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
        $Clasificacion = new Clasificacion();
        $Clasificacion->fill($request->all());
        $Clasificacion->save();
        return response($Clasificacion, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $Clasificacion = Clasificacion::join('TipoActEconomica', 'TipoActEconomica.ID', 'IDTipoActEcon')
            ->join('Acteconomica', 'Acteconomica.ID', 'TipoActEconomica.IDActEconomica')
            ->where('Clasificacion.ID', $id)
            ->first(['Clasificacion.*', 'Acteconomica.ID as IDActEconomica']);

        return response($Clasificacion, 201);
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
        $Clasificacion = Clasificacion::find($id);
        $Clasificacion->fill($request->all());
        $Clasificacion->save();
        return response($Clasificacion, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $Clasificacion = Clasificacion::find($id);
        $Clasificacion->Estado = 'INA';
        $Clasificacion->save();
        return response($Clasificacion, 201);
    }
}
