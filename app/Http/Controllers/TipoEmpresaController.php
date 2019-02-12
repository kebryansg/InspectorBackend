<?php

namespace App\Http\Controllers;

use App\Models\Tipoempresa;
use Illuminate\Http\Request;

class TipoEmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Tipoempresa = Tipoempresa::where('Estado', 'ACT')->orderBy('Nombre')->paginate($request->input('psize'));
        return response($Tipoempresa, 201);
    }

    #region CRUD

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function combo(Request $request)
    {
        $Tipoempresa = Tipoempresa::where('Estado', 'ACT')->orderBy('Nombre')->get();
        return response($Tipoempresa, 201);
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
        $Tipoempresa = new Tipoempresa();
        $Tipoempresa->fill($request->all());
        $Tipoempresa->save();
        return response($Tipoempresa, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $Tipoempresa = Tipoempresa::find($id);
        return response($Tipoempresa, 201);
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
        $Tipoempresa = Tipoempresa::find($id);
        $Tipoempresa->fill($request->all());
        $Tipoempresa->save();
        return response($Tipoempresa, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $Tipoempresa = Tipoempresa::find($id);
        $Tipoempresa->Estado = 'INA';
        $Tipoempresa->save();
        return response($Tipoempresa, 201);
    }

}
