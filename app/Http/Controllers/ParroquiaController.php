<?php

namespace App\Http\Controllers;

use App\Models\Parroquium;
use Illuminate\Http\Request;

class ParroquiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Parroquium = Parroquium::
            join('Canton', 'Canton.ID', 'IDCanton')
            ->join('Provincia', 'Provincia.ID', 'Canton.IDProvincia')
            ->select([ 'Parroquia.*', 'Provincia.Descripcion as Provincia', 'Canton.Descripcion as Canton' ])
            ->paginate($request->input('psize'));
        return response($Parroquium, 201);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function combo(Request $request)
    {
        $Parroquium = Parroquium::where('Estado', 'ACT')->where('IDCanton', $request->input('Canton') )->get();
        return response($Parroquium, 201);
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
        $Parroquium = Parroquium::insertGetId($request->all());
        return response($Parroquium, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
//        $Parroquium = Parroquium::find($id);
        $Parroquium = Parroquium::find($id)
                ->join('Canton', 'Canton.ID', 'IDCanton')
                ->join('Provincia', 'Provincia.ID', 'Canton.IDProvincia')
                ->first([ 'Parroquia.*', 'Provincia.ID as Provincia' ]);
        return response($Parroquium, 201);
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
        $Parroquium = Parroquium::find($id);
        $Parroquium->fill($request->all());
        $Parroquium->save();
        return response($Parroquium, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $Parroquium = Parroquium::find($id);
        $Parroquium->Estado = 'INA';
        $Parroquium->save();
        return response($Parroquium, 201);
    }
}
