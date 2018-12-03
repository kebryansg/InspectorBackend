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
    public function index( Request $request )
    {
        if($request->isJson()){
            $Tipoempresas = Tipoempresa::paginate($request->input('psize'));
            return response($Tipoempresas, 201);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function combo( Request $request )
    {
        if($request->isJson()){
            $Tipoempresas = Tipoempresa::where('Estado', 'ACT')->get();
            return response($Tipoempresas, 201);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->isJson()){
            $Tipoempresa = new Tipoempresa();
            $Tipoempresa->fill( $request->all() );
            $Tipoempresa->save();
            return response($Tipoempresa, 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( Request $request, $id )
    {
        if($request->isJson()){
            $Tipoempresa = Tipoempresa::find($id);
            return response($Tipoempresa, 201);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->isJson()){
            $Tipoempresa = Tipoempresa::find($id);
            $Tipoempresa->fill( $request->all() );
            $Tipoempresa->save();
            return response($Tipoempresa, 201);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if($request->isJson()){
            $Tipoempresa= Tipoempresa::find($id);
            $Tipoempresa->Estado = 'INA';
            $Tipoempresa->save();
            return response($Tipoempresa, 201);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
