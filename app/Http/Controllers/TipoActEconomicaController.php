<?php

namespace App\Http\Controllers;

use App\Models\Tipoacteconomica;
use Illuminate\Http\Request;

class TipoActEconomicaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Tipoempresas = Tipoacteconomica::join('Acteconomica', 'Acteconomica.ID', 'IDActEconomica')
            ->select([ 'Tipoacteconomica.*', 'Acteconomica.Descripcion as ActEconomica' ])
            ->paginate($request->input('psize'));
        return response($Tipoempresas, 201);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function combo(Request $request)
    {
        $Tipoempresas = Tipoacteconomica::where('Estado', 'ACT')->get();
        return response($Tipoempresas, 201);
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
        $Tipoempresa = new Tipoacteconomica();
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
        $Tipoempresa = Tipoacteconomica::find($id);
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
        $Tipoempresa = Tipoacteconomica::find($id);
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
        $Tipoempresa = Tipoacteconomica::find($id);
        $Tipoempresa->Estado = 'INA';
        $Tipoempresa->save();
        return response($Tipoempresa, 201);
    }
}
