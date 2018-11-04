<?php

namespace App\Http\Controllers;

use App\Models\Compañium;
use App\Models\Institucion;
use Illuminate\Http\Request;

class CompaniaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->isJson()){
            $compañiums = Compañium::where('Compañia.Estado', 'ACT')
                ->join('Institucion', 'Institucion.ID', '=', 'IDInstitucion' )
                ->select('Compañia.*', 'Institucion.Nombre as Institucion')
                ->paginate($request->input('psize'));
            return response($compañiums, 201);
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
            $compañium = new Compañium();
            $compañium->fill( $request->all() );
            $compañium->IDInstitucion = Institucion::first()->ID;
            $compañium->save();
            return response($compañium, 201);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if($request->isJson()){
            $compañium = Compañium::find($id);
            return response($compañium, 201);
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
            $compañium = Compañium::find($id);
            $compañium->fill( $request->all() );
            $compañium->save();
            return response($compañium, 201);
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
            $compañium = Compañium::find($id);
            $compañium->Estado = 'INA';
            $compañium->save();
            return response($compañium, 201);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
