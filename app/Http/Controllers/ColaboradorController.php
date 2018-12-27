<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use App\Models\Parametro;
use Firebase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ColaboradorController extends Controller
{
    private $Firebase_URL = '/colaborador/';

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inspectores(Request $request)
    {
        $Parametro = Parametro::where('Abr', 'CINPS')->first();
        $Clasificacion = Colaborador::join('Cargo', 'Cargo.ID', 'IDCargo')
            ->join('Area', 'Area.ID', 'IDArea')
            ->join('Compania', 'Compania.ID', 'IDCompania')
            ->where('Cargo.ID', $Parametro->Valor)
            ->get(['Colaborador.ID', DB::raw("concat(Colaborador.ApellidoPaterno, ' ', Colaborador.ApellidoMaterno, ' ', Colaborador.NombrePrimero ) as Colaborador")]);
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

        /* Registo de Colaboradores que tienen como cargo Inspector (Definido como paremetro global) */
        $Parametro = Parametro::where('Abr', 'CINPS')->first();
        if ($Colaborador->IDCargo == $Parametro->Valor) {
            $DataFirebase = [
                'ID' => $Colaborador->ID,
                'Cedula' => $Colaborador->Cedula,
                'Nombre' => $Colaborador->ApellidoPaterno . ' ' . $Colaborador->ApellidoMaterno . ' ' . $Colaborador->NombrePrimero,
                'Created_at' => $Colaborador->created_at->getTimestamp(),
                'Updated_at' => $Colaborador->updated_at->getTimestamp(),
            ];
            Firebase::set($this->Firebase_URL . 'colb' . $Colaborador->ID, $DataFirebase);
        }

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
            ->first(['Colaborador.*', 'Departamento.ID as Departamento']);
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
        $Parametro = Parametro::where('Abr', 'CINPS')->first();
        $Colaborador = Colaborador::find($id);
        $Colaborador->fill($request->all());
        $Colaborador->save();

        /* Si el cargo es actualizado como cargo Inspector (Definido como paremetro global) */
        if ($Colaborador->IDCargo == $Parametro->Valor) {
            $DataFirebase = [
                'ID' => $Colaborador->ID,
                'Cedula' => $Colaborador->Cedula,
                'Nombre' => $Colaborador->ApellidoPaterno . ' ' . $Colaborador->ApellidoMaterno . ' ' . $Colaborador->NombrePrimero,
                'Created_at' => $Colaborador->created_at->getTimestamp(),
                'Updated_at' => $Colaborador->updated_at->getTimestamp(),
            ];
            Firebase::set($this->Firebase_URL . 'colb_' . $Colaborador->ID, $DataFirebase);
        }
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
