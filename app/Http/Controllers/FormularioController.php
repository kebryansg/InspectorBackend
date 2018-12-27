<?php

namespace App\Http\Controllers;

use App\Models\Componente;
use App\Models\Formcomp;
use App\Models\Formulario;
use App\Models\Seccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function seccion_formulario_full(Request $request, $form)
    {
        $Seccions = Formulario::join('FormComp', 'FormComp.IDFormulario', 'Formulario.ID')
            ->join('SeccionComponente', 'SeccionComponente.ID', 'FormComp.IDSeccionComponente')
            ->join('Seccion', 'Seccion.ID', 'SeccionComponente.IDSeccion')
            ->where('Formulario.ID', $form)
            ->where('Seccion.Estado', 'ACT')
            ->groupby('Seccion.ID')
            ->get(['Seccion.*']);


//        $components = Componente::join('SeccionComponente', 'SeccionComponente.IDComponente', 'Componente.ID')
//            ->join('FormComp', 'FormComp.IDSeccionComponente', 'SeccionComponente.ID')
//            ->join('TipoComp', 'Componente.IDTipoComp', 'TipoComp.ID')
//            ->where('FormComp.IDFormulario', $form)
//            ->where('TipoComp.Configuracion', true)
//            ->where('FormComp.Estado', 'ACT')
//            ->get(['FormComp.ID', 'Componente.Descripcion', 'Componente.IDTipoComp', 'SeccionComponente.IDSeccion as Seccion', 'FormComp.Atributo', 'FormComp.Obligatorio']);

        $components = FormComp::join('SeccionComponente', 'SeccionComponente.ID', 'FormComp.IDSeccionComponente')
            ->join('Componente', 'SeccionComponente.IDComponente', 'Componente.ID')
            ->join('TipoComp', 'Componente.IDTipoComp', 'TipoComp.ID')
            ->where('FormComp.IDFormulario', $form)
            ->where('TipoComp.Configuracion', true)
            ->where('FormComp.Estado', 'ACT')
            ->get(['FormComp.ID', 'Componente.Descripcion', 'Componente.IDTipoComp', 'SeccionComponente.IDSeccion as Seccion', 'FormComp.Atributo', 'FormComp.Obligatorio']);

//        return $components;

        foreach ($Seccions as $Seccion) {
            $Seccion["componentes"] = array_values($components->filter(function ($value, $key) use ($Seccion) {
                return $value["Seccion"] == $Seccion["ID"];
            })->toArray());
        }

        return response()->json($Seccions, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function seccion_formulario_store(Request $request, $form)
    {
        $Formulario = Formulario::find($form);
        $rows = $request->all();
        foreach ($rows as $row) {
            Formcomp::find($row['ID'])
                ->update([
                    'Obligatorio' => $row['Obligatorio'],
                    'Atributo' => $row['Atributo']
                ]);
        }
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
            ->get(['Seccion.*'])->pluck('ID');
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
            ->get(['SeccionComponente.ID', 'FormComp.Estado']);
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

        $Formulario->formcomps()->createMany(array_filter($rows, function ($row) use ($ids) {
            return !in_array($row["IDSeccionComponente"], $ids);
        }));

        $update_rows = array_filter($rows, function ($row) use ($ids) {
            in_array($row["IDSeccionComponente"], $ids);
        });

        foreach ($update_rows as $row) {
            Formcomp::where('IDFormulario', $id)
                ->where('IDSeccionComponente', $row["IDSeccionComponente"])
                ->update($row);
        }


//        if (count($Formulario->formcomps) > 0) {
//            foreach ($rows as $row) {
//                if (in_array($row["IDSeccionComponente"], $ids)) {
//                    Formcomp::where('IDSeccionComponente', $row["IDSeccionComponente"])
//                        ->update($row);
//                    $ids = array_diff($ids, [$row["IDSeccionComponente"]]);
//
//                } else {
//                    $Formulario->formcomps()->createMany($row);
//                }
//            }
//            // Eliminar Filas que no se encontraron (Update - Insert)
//            if (count($ids)) {
//                Formcomp::whereIn('IDSeccionComponente', $ids)->detele();
//            }
//        } else
//            $Formulario->formcomps()->createMany($rows);

        $Formulario->IDUsers_updated = $request->user()->id;
        $Formulario->save();

        return response()->json($Formulario, 201);
    }
}
