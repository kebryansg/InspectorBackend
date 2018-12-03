<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Sector = Sector::
            join('Parroquia', 'Parroquia.ID', 'IDParroquia')
            ->join('Canton', 'Canton.ID', 'IDCanton')
            ->join('Provincia', 'Provincia.ID', 'Canton.IDProvincia')
            ->select([ 'Sector.*', 'Provincia.Descripcion as Provincia', 'Canton.Descripcion as Canton', 'Parroquia.Descripcion as Parroquia' ])
            ->paginate($request->input('psize'));
        return response($Sector, 201);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function combo(Request $request)
    {
        $Sector = Sector::where('Estado', 'ACT')->where('IDParroquia', $request->input('Parroquia') )->get();
        return response($Sector, 201);
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
        $Sector = Sector::insertGetId($request->all());
        return response($Sector, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
//        $Sector = Sector::find($id);
        $Sector = Sector::find($id)
            ->join('Parroquia', 'Parroquia.ID', 'IDParroquia')
            ->join('Canton', 'Canton.ID', 'IDCanton')
            ->join('Provincia', 'Provincia.ID', 'Canton.IDProvincia')
            ->first([ 'Parroquia.*', 'Provincia.ID as Provincia', 'Canton.ID as Canton' ]);
        return response($Sector, 201);
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
        $Sector = Sector::find($id);
        $Sector->fill($request->all());
        $Sector->save();
        return response($Sector, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $Sector = Sector::find($id);
        $Sector->Estado = 'INA';
        $Sector->save();
        return response($Sector, 201);
    }
}
