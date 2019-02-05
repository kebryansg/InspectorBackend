<?php

namespace App\Http\Controllers;

use App\Models\Entidad;
use Illuminate\Http\Request;

class EntidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Entidad::where('Estado', 'ACT');

        if ($request->input('search'))
            $query->where(function ($query) use ($request) {
                $query->where('Identificacion', 'like', '%' . $request->input('search') . '%');
                $query->orWhere('Nombres', 'like', '%' . $request->input('search') . '%');
                $query->orWhere('Apellidos', 'like', '%' . $request->input('search') . '%');
            });

        $Entidad = $query->paginate($request->input('psize'));
        return response($Entidad, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function combo(Request $request)
    {
        if ($request->isJson()) {
            $Entidad = Entidad::where('Estado', 'ACT')->get();
            return response($Entidad, 201);
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
            $Entidad = new Entidad();
            $Entidad->fill($request->all());
            $Entidad->save();
            return response($Entidad, 201);
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
            $Entidad = Entidad::find($id);
            return response($Entidad, 201);
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
            $Entidad = Entidad::find($id);
            $Entidad->fill($request->all());
            $Entidad->save();
            return response($Entidad, 201);
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
            $Entidad = Entidad::find($id);
            $Entidad->Estado = 'INA';
            $Entidad->save();
            return response($Entidad, 201);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
