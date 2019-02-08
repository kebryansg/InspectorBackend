<?php

namespace App\Http\Controllers;

use App\Models\Modulo;
use App\Models\Rol;
use App\Models\RolModulo;
use Illuminate\Http\Request;

class RolController extends Controller
{

    public function index(Request $request)
    {
        $Rol = Rol::paginate($request->input('psize'));
        return response($Rol, 201);
    }

    public function store(Request $request)
    {
        $Rol = new Rol();
        $Rol->fill($request->all());
        $Rol->save();
        $this->saveModulos($request->input('modulos'), $Rol->ID);
        return response($Rol, 201);
    }

    public function update(Request $request, $id)
    {
        $Rol = Rol::find($id);
        $Rol->fill($request->all());
        $Rol->save();
        $this->saveModulos($request->input('modulos'), $Rol->ID);
        return response($Rol, 201);
    }

    public function show(Request $request, $id)
    {
        $Rol = Rol::find($id)->toArray();
        $idsModulo = RolModulo::where('IDRol', $Rol["ID"])->get()->pluck('IDModulo');
        $Rol['Modulos'] = Modulo::whereIn('ID', $idsModulo)->get();
        return response($Rol, 201);
    }

    public function destroy(Request $request, $id)
    {
        $Rol = Rol::find($id);
        $Rol->Estado = 'INA';
        $Rol->save();
        return response($Rol, 201);
    }

    public function saveModulos($rows, $IDRol)
    {
        RolModulo::where('IDRol', $IDRol)->delete();
        foreach ($rows as $row) {
            RolModulo::create([
                "IDRol" => $IDRol,
                "IDModulo" => $row
            ]);
        }
    }

    public function rol_modulo($id)
    {
        $idsModulo = RolModulo::where('IDRol', $id)->get()->pluck('IDModulo');
        $Modulos = Modulo::whereIn($idsModulo)->get();
        return response()->json($Modulos, 200);
    }

    public function combo()
    {
        $Rols = Rol::where('Estado', 'ACT')->get([
            "ID",
            "Descripcion"
        ]);
        return response()->json($Rols, 200);
    }

    public function userRol(Request $request)
    {

        if($request->user()->IDRol == 0){
            $Modulos = Modulo::with('modulos')->whereNull('IDPadre')->get();
            return response()->json($Modulos, 200);
        }


        $idModulos = RolModulo::where('IDRol', $request->user()->IDRol)->get()->pluck('IDModulo');
        $Padres = Modulo::whereIn('ID', $idModulos)->get()->pluck('IDPadre');

        $Modulos = Modulo::with([
            'modulos' => function ($query) use ($idModulos) {
                $query->whereIn('ID', $idModulos);
                return $query;
            }
        ])->whereIn('ID', $Padres)->whereNull('IDPadre')->get();
        return response()->json($Modulos, 200);
    }

}
