<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use Illuminate\Http\Request;

class ColaboradorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Clasificacion = Colaborador::join('Cargo', 'Cargo.ID', 'IDCargo')
            ->join('Area', 'Area.ID', 'IDArea')
            ->join('Compania', 'Compania.ID', 'IDCompania')
            ->select(['Colaborador.*', 'Cargo.Descripcion as Cargo', 'Area.Descripcion as Area', 'Compania.Nombre as Compania'])
            ->paginate($request->input('psize'));
        return response($Clasificacion, 201);
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
        $Colaborador = new Colaborador();
        $Colaborador->fill($request->all());
        $Colaborador->save();
        return response($Colaborador, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
//        $Colaborador = Colaborador::find($id);
        $Colaborador = Colaborador::find($id)
            ->join('Area', 'Area.ID', 'IDArea')
            ->join('Departamento', 'Departamento.ID', 'IDDepartamento')
            ->first([ 'Colaborador.*', 'Departamento.ID as Departamento' ]);
        return response($Colaborador, 201);

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
        $Colaborador = Colaborador::find($id);
        $Colaborador->fill($request->all());
        $Colaborador->save();
        return response($Colaborador, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $Colaborador = Colaborador::find($id);
        $Colaborador->Estado = 'INA';
        $Colaborador->save();
        return response($Colaborador, 201);
    }
}
