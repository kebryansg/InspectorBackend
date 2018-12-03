<?php

namespace App\Http\Controllers;

use App\Models\Canton;
use Illuminate\Http\Request;

class CantonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Canton = Canton::join('Provincia', 'Provincia.ID', 'IDProvincia')
                ->select([ 'Canton.*', 'Provincia.Descripcion as Provincia' ])
                ->paginate($request->input('psize'));
        return response($Canton, 201);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function combo(Request $request)
    {
        $Canton = Canton::where('Estado', 'ACT')->where('IDProvincia', $request->input('Provincia') )->get();
        return response($Canton, 201);
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
        $Canton = Canton::insertGetId($request->all());
        return response($Canton, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $Canton = Canton::find($id);
        return response($Canton, 201);
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
        $Canton = Canton::find($id);
        $Canton->fill($request->all());
        $Canton->save();
        return response($Canton, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $Canton = Canton::find($id);
        $Canton->Estado = 'INA';
        $Canton->save();
        return response($Canton, 201);
    }
}
