<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use App\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $User = User::with('rol')->where('Estado', 'ACT')->paginate($request->input('psize'));
        return response($User, 201);
    }

    public function store(Request $request)
    {

        try {
            $User = new User();
            $User->fill($request->all());
            $Colaborador = Colaborador::find($request->input('IDColaborador'));
            $User->password = password_hash($Colaborador->Cedula, PASSWORD_BCRYPT);
            $User->save();

            $Colaborador->IDUser = $User->id;
            $Colaborador->save();
            return response($User, 201);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), 201);
        }

    }

    public function update(Request $request, $id)
    {
        $User = User::find($id);
        $User->fill($request->all());
        $User->save();
        return response($User, 201);
    }

    public function show(Request $request, $id)
    {
        $User = User::find($id)->toArray();
        $User["IDColaborador"] = Colaborador::where('IDUser', $User["id"])->first()->ID;
        return response($User, 201);
    }

    public function destroy(Request $request, $id)
    {
        $User = User::find($id);
        $User->Estado = 'INA';
        $User->save();
        return response($User, 201);
    }

    public function getUser(Request $request){
        $User = $request->user();
        $data = [];

        if($User->IDRol == 0){
            $data["UserName"] = "Admin Developer";
            return response()->json($data,200);
        }
        $Colaborador = Colaborador::where('IDUser', $User->id)->first();
        $data["UserName"] = $Colaborador->getNameAttribute();
        return response()->json($data,200);
    }


}
