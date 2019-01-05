<?php

namespace App\Http\Controllers;

use App\Models\Tipocomp;
use Illuminate\Http\Request;

class TipoComponenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        $TipoComponente = Tipocomp::all();
        return response()->json($TipoComponente, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function combo( Request $request )
    {
        $TipoComponente = Tipocomp::all();
        return response()->json($TipoComponente, 200);
    }
}
