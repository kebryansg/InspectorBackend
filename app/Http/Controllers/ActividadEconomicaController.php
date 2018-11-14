<?php

namespace App\Http\Controllers;

use App\Models\Acteconomica;
use Illuminate\Http\Request;

class ActividadEconomicaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->isJson()) {
            $Acteconomica = Acteconomica::where('Estado', 'ACT')->paginate($request->input('psize'));
            return response($Acteconomica, 201);
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
        if ($request->isJson()) {
            $Acteconomica = Acteconomica::where('Estado', 'ACT')->get();
            return response($Acteconomica, 201);
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->isJson()) {
            $Acteconomica = new Acteconomica();
            $Acteconomica->fill($request->all());
            $Acteconomica->save();
            return response($Acteconomica, 201);
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
            $Acteconomica = Acteconomica::find($id);
            return response($Acteconomica, 201);
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
            $Acteconomica = Acteconomica::find($id);
            $Acteconomica->fill($request->all());
            $Acteconomica->save();
            return response($Acteconomica, 201);
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
            $Acteconomica = Acteconomica::find($id);
            $Acteconomica->Estado = 'INA';
            $Acteconomica->save();
            return response($Acteconomica, 201);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
