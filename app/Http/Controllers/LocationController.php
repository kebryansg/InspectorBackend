<?php

namespace App\Http\Controllers;

use App\Models\Provincium;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function combo_canton(Request $request)
    {
        $ls = Provincium::with('cantons')->get();
        return response($ls, 201);
    }

    public function combo_parroquia(Request $request)
    {
        $ls = Provincium::with('cantons.parroquia')->get();
        return response($ls, 201);
    }

    public function combo_sector(Request $request)
    {
        $ls = Provincium::with('cantons.parroquia.sectors')->get();
        return response($ls, 201);
    }


}
