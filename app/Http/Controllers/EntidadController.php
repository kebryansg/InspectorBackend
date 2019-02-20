<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
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
        $query = Entidad::orderBy('Apellidos')->orderBy('Nombres');

        if ($request->input('showAll') == 'false') {
            $query->where('Estado', 'ACT');
        }

        if ($request->input('search'))
            $query->where(function ($query) use ($request) {
                $search = $request->input('search');
                $query->where('Identificacion', 'like', '%' . $search . '%');
                $query->orWhere('Nombres', 'like', '%' . $search . '%');
                $query->orWhere('Apellidos', 'like', '%' . $search . '%');
            });

        $Entidad = $query->paginate($request->input('psize'));
        return response()->json($Entidad, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function combo(Request $request)
    {
        $Entidad = Entidad::where('Estado', 'ACT')->get();
        return response($Entidad, 201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listEmpresa(Request $request, $id)
    {
        $Empresas = Empresa::where('IDEntidad', $id)->where('EstadoAplicacion', 'P')->get();
        return response()->json($Empresas, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Entidad = new Entidad();
        $Entidad->fill($request->all());
        $Entidad->save();
        return response()->json($Entidad, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $Entidad = Entidad::find($id);
        return response()->json($Entidad, 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string $search
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $search = $request->input('search');
        $Entidad = Entidad::with([
            'empresas' => function ($query) {
                $query->where('EstadoAplicacion', 'P');
            }
        ])->where('Identificacion', 'like', "%$search%")->first();
        return response()->json($Entidad, 200);
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
        $Entidad = Entidad::find($id);
        $Entidad->fill($request->all());
        $Entidad->save();
        return response()->json($Entidad, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $Entidad = Entidad::find($id);
        $Entidad->Estado = 'INA';
        $Entidad->save();
        return response()->json($Entidad, 200);
    }
}
