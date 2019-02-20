<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function users_rol(Request $request){
        return response()->json([], 200);
    }
}
