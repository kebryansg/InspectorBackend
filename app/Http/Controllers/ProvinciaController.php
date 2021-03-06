<?php

namespace App\Http\Controllers;

use App\Models\Provincium;
use Illuminate\Http\Request;

class ProvinciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->isJson()) {
            $Provincium = Provincium::paginate($request->input('psize'));
            return response($Provincium, 201);
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
        $Provincium = Provincium::where('Estado', 'ACT')->get();
        return response($Provincium, 201);
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
            $Provincium = new Provincium();
            $Provincium->fill($request->all());
            $Provincium->save();
            return response($Provincium, 201);
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
            $Provincium = Provincium::find($id);
            return response($Provincium, 201);
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
            $Provincium = Provincium::find($id);
            $Provincium->fill($request->all());
            $Provincium->save();
            return response($Provincium, 201);
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
            $Provincium = Provincium::find($id);
            $Provincium->Estado = 'INA';
            $Provincium->save();
            return response($Provincium, 201);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
