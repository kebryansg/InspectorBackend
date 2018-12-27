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
        $Empresas = Empresa::with('clasificacion.tipoacteconomica', 'sector')
            ->where('Estado', 'ACT')
            ->where([
                ['RUC', 'like', '%' . $request->input('search') . '%'],
                ['RazonSocial', 'like', '%' . $request->input('search') . '%'],
                ['NombreComercial', 'like', '%' . $request->input('search') . '%'],
            ])
            ->paginate($request->input('psize'));
        return response($Empresas, 201);
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
            $Empresa = new Empresa();
            $Empresa->fill($request->all());
            $Empresa->save();
            return response($Empresa, 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $Empresa = Empresa::find($id)
            ->join('Clasificacion', 'Clasificacion.ID', 'IDClasificacion')
            ->join('TipoActEconomica', 'TipoActEconomica.ID', 'Clasificacion.IDTipoActEcon')
            ->join('ActEconomica', 'ActEconomica.ID', 'TipoActEconomica.IDActEconomica')
            ->join('Sector', 'Sector.ID', 'IDSector')
            ->join('Parroquia', 'Parroquia.ID', 'Sector.IDParroquia')
            ->join('Canton', 'Canton.ID', 'IDCanton')
            ->join('Provincia', 'Provincia.ID', 'Canton.IDProvincia')
            ->first(['Empresa.*', 'IDTipoActEcon', 'IDActEconomica', 'IDProvincia', 'IDCanton', 'IDParroquia']);

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
}