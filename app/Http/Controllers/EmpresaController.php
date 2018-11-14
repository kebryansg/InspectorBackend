<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        if($request->isJson()){
            $Empresas = Empresa::where('Estado', 'ACT')->paginate($request->input('psize'));
            return response($Empresas, 201);
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
            $Empresa = new Tipoempresa();
            $Empresa->fill( $request->all() );
            $Empresa->save();
            return response($Empresa, 201);
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
            $Empresa = Empresa::find($id);
            return response($Empresa, 201);
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
            $Empresa = Empresa::find($id);
            $Empresa->fill( $request->all() );
            $Empresa->save();
            return response($Empresa, 201);
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
            $Empresa= Empresa::find($id);
            $Empresa->Estado = 'INA';
            $Empresa->save();
            return response($Empresa, 201);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}