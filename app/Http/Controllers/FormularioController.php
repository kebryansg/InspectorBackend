<?php

namespace App\Http\Controllers;

use App\Models\Formcomp;
use App\Models\Formulario;
use App\Models\Seccion;
use Illuminate\Http\Request;

class FormularioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Formulario = Formulario::paginate($request->input('psize'));
        return response($Formulario, 201);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function combo(Request $request)
    {
        $Formulario = Formulario::where('Estado', 'ACT')->get();
        return response($Formulario, 201);
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
//        $Formulario = Formulario::insertGetId($request->all());
        $Formulario = new Formulario;
        $Formulario->fill($request->all());
        $Formulario->IDUsers_created = $request->user()->id;
        $Formulario->save();
        return response($Formulario, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $Formulario = Formulario::find($id);
        return response($Formulario, 200);
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
        $Formulario = Formulario::find($id);
        $Formulario->fill($request->all());
        $Formulario->IDUsers_updated = $request->user()->id;
        $Formulario->save();
        return response($Formulario, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $Formulario = Formulario::find($id);
        $Formulario->IDUsers_updated = $request->user()->id;
        $Formulario->Estado = 'INA';
        $Formulario->save();
        return response($Formulario, 201);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function seccion_formulario(Request $request, $form)
    {
        $Seccion = Formulario::join('FormComp', 'FormComp.IDFormulario', 'Formulario.ID')
            ->join('SeccionComponente', 'SeccionComponente.ID', 'FormComp.IDSeccionComponente')
            ->join('Seccion', 'Seccion.ID', 'SeccionComponente.IDSeccion')
            ->where('Formulario.ID', $form)
            ->where('Seccion.Estado', 'ACT')
            ->groupby('Seccion.ID')
            ->get([ 'Seccion.*' ])->pluck('ID');
        return response($Seccion, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function component_formulario(Request $request, $form)
    {
        $Component = Formulario::join('FormComp', 'FormComp.IDFormulario', 'Formulario.ID')
            ->join('SeccionComponente', 'SeccionComponente.ID', 'FormComp.IDSeccionComponente')
            ->join('Componente', 'Componente.ID', 'SeccionComponente.IDComponente')
            ->where('Formulario.ID', $form)
            ->get([ 'SeccionComponente.ID', 'FormComp.Estado' ]);
        return response($Component, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function seccion_store(Request $request, $id)
    {
        $Formulario = Formulario::with('formcomps')->find($id);
        $rows = $request->all();
        $ids = $Formulario->formcomps->pluck('IDSeccionComponente')->toArray();

        if (count($Formulario->formcomps) > 0) {
            foreach ($rows as $row) {
                if (in_array($row["IDSeccionComponente"], $ids)){
                    Formcomp::where('IDSeccionComponente', $row["IDSeccionComponente"])
                        ->update($row);
                    $ids = array_diff($ids, [ $row["IDSeccionComponente"] ]);

                }else{
                    Formcomp::create($row);
                }
            }
            // Eliminar Filas que no se encontraron (Update - Insert)
            if( count( $ids ) ){
                Formcomp::whereIn('IDSeccionComponente', $ids)->detele();
            }
        }
        else
            $Formulario->formcomps()->createMany($rows);

        $Formulario->IDUsers_updated = $request->user()->id;
        $Formulario->save();

        return response()->json($Formulario, 201);
    }
}
