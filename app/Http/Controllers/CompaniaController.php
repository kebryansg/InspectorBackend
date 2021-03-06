<?php

namespace App\Http\Controllers;

use App\Models\Companium;
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
        if ($request->isJson()) {
            $Companiums = Companium::where('Compania.Estado', 'ACT')
                ->join('Institucion', 'Institucion.ID', '=', 'IDInstitucion')
                ->select('Compania.*', 'Institucion.Nombre as Institucion')
                ->paginate($request->input('psize'));
            return response($Companiums, 201);
        }
        return response()->json(['error' => 'Unauthorized'], 401);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function combo(Request $request)
    {
        $Companiums = Companium::where('Compania.Estado', 'ACT')->get();
        return response($Companiums, 201);

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
        if ($request->isJson()) {
            $Companium = new Companium();
            $Companium->fill($request->all());
            $Companium->IDInstitucion = Institucion::first()->ID;
            $Companium->save();
            return response($Companium, 201);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if ($request->isJson()) {
            $Companium = Companium::find($id);
            return response($Companium, 201);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
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
        if ($request->isJson()) {
            $Companium = Companium::find($id);
            $Companium->fill($request->all());
            $Companium->save();
            return response($Companium, 201);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->isJson()) {
            $Companium = Companium::find($id);
            $Companium->Estado = 'INA';
            $Companium->save();
            return response($Companium, 201);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
