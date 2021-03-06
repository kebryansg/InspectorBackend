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
    public function index(Request $request)
    {
        $query = Empresa::with('sector', 'acteconomica')
            ->where('Estado', 'ACT');

        if ($request->input('modal'))
            $query->where('EstadoAplicacion', 'P');

        if ($request->input('search'))
            $query->where(function ($query) use ($request) {
                $query->where('RUC', 'like', '%' . $request->input('search') . '%');
                $query->orWhere('RazonSocial', 'like', '%' . $request->input('search') . '%');
                $query->orWhere('NombreComercial', 'like', '%' . $request->input('search') . '%');
            });
        $Empresas = $query->paginate($request->input('psize'));
        return response($Empresas, 200);
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
        $Empresa = new Empresa();
        $Empresa->fill($request->all());
        $Empresa->save();
        return response($Empresa, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

        $Empresa = Empresa::with('entidad', 'sector.parroquium.canton')->find($id);

        return response($Empresa, 201);
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

        $Empresa = Empresa::find($id);
        $Empresa->fill($request->all());
        $Empresa->save();
        return response($Empresa, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $Empresa = Empresa::find($id);
        $Empresa->Estado = 'INA';
        $Empresa->save();
        return response($Empresa, 201);
    }


    public function empresaSearch(Request $request)
    {
        $Empresa = [];

        if ($request->input('search'))
            $Empresa = Empresa::with('sector', 'acteconomica')
                ->where('EstadoAplicacion', 'P')
                ->where(function ($query) use ($request) {
                    $query->where('RUC', 'like', '%' . $request->input('search') . '%');
                    $query->orWhere('RazonSocial', 'like', '%' . $request->input('search') . '%');
                    $query->orWhere('NombreComercial', 'like', '%' . $request->input('search') . '%');
                })->get();
        return response()->json($Empresa, 200);
    }
}