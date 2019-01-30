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
        $Acteconomica = Acteconomica::where('Estado', 'ACT')->paginate($request->input('psize'));
        return response($Acteconomica, 201);
    }

    #region CRUD

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function combo(Request $request)
    {
        $Acteconomica = Acteconomica::with('tipoacteconomicas.clasificacions')->where('Estado', 'ACT')->get();
        return response($Acteconomica, 201);
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
        $Acteconomica = new Acteconomica();
        $Acteconomica->fill($request->all());
        $Acteconomica->save();
        return response($Acteconomica, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $Acteconomica = Acteconomica::find($id);
        return response($Acteconomica, 201);
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
        $Acteconomica = Acteconomica::find($id);
        $Acteconomica->fill($request->all());
        $Acteconomica->save();
        return response($Acteconomica, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $Acteconomica = Acteconomica::find($id);
        $Acteconomica->Estado = 'INA';
        $Acteconomica->save();
        return response($Acteconomica, 201);
    }

    #endregion

    public function updateFirebase(Request $request)
    {
        $rows = Acteconomica::with(
            ['tipoacteconomicas.clasificacions' => function ($query) {
                return $query->whereNotNull('IDFormulario');
            }])
            ->has('tipoacteconomicas.clasificacions')
            ->get()
            ->toArray();
        $path = 'ActEconomica/data.json';
        (new Utilidad())->uploadFile($rows, $path);
        return response()->json([
            "status" => true
        ], 201);
    }
}
