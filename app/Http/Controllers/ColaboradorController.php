<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use App\Models\Parametro;
use Carbon\Carbon;
use Firebase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Morrislaptop\Firestore\Factory;
use Kreait\Firebase\ServiceAccount;

class ColaboradorController extends Controller
{
    private $firestore;

    public function __construct()
    {
        $serviceAccount = ServiceAccount::fromJsonFile(dirname(dirname(__DIR__)) . '/secret/inspector-7933a.json');
        $this->firestore = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->createFirestore();
    }


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
        if ($Colaborador->IDCargo == $Parametro->Valor && Utilidad::Online())
            $this->uploadFirebase($Colaborador);

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
        $Colaborador = Colaborador::where('Colaborador.ID', $id)
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
        if ($Colaborador->IDCargo == $Parametro->Valor && Utilidad::Online())
            $this->uploadFirebase($Colaborador);
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

    private function uploadFirebase(Colaborador $Colaborador)
    {
        $DataFirebase = [
            'ID' => $Colaborador->ID,
            'Cedula' => $Colaborador->Cedula,
            'Email' => $Colaborador->Email,
            'Nombre' => $Colaborador->ApellidoPaterno . ' ' . $Colaborador->ApellidoMaterno . ' ' . $Colaborador->NombrePrimero,
            'Created_at' => $Colaborador->created_at->getTimestamp(),
            'Updated_at' => $Colaborador->updated_at->getTimestamp(),
        ];

        $document = $this->firestore->collection('colaborador')->document('colb_' . $Colaborador->ID);
        $document->set($DataFirebase);
        $Colaborador->firebase_at = Carbon::now();
        $Colaborador->save();
    }
}
