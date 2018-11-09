<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/users', function (\Illuminate\Http\Request $request) {
        return $request->user();
    });

    $router->get('institucion', ["uses" => "InstitucionController@index"]);
    $router->put('institucion/{id}', ['uses' => 'InstitucionController@update']);
    //$router->delete('institucion/{id}', ['uses' => 'InstitucionController@destroy']);
    //$router->post('institucion', ['uses' => 'InstitucionController@store']);
//    $router->get('institucion/{id}', ['uses' => 'InstitucionController@show']);
    //$router->get('comboempresa', ['uses' => 'EmpresaController@combo']);


    $router->get('compania', ["uses" => "CompaniaController@index"]);
    $router->get('compania/{id}', ['uses' => 'CompaniaController@show']);
    $router->put('compania/{id}', ['uses' => 'CompaniaController@update']);
    $router->delete('compania/{id}', ['uses' => 'CompaniaController@destroy']);
    $router->post('compania', ['uses' => 'CompaniaController@store']);
//    $router->get('combo_compañia', ['uses' => 'CompaniaController@combo']);

    $router->get('tipoempresa', ["uses" => "TipoEmpresaController@index"]);
    $router->get('tipoempresa/{id}', ['uses' => 'TipoEmpresaController@show']);
    $router->post('tipoempresa', ['uses' => 'TipoEmpresaController@store']);
    $router->put('tipoempresa/{id}', ['uses' => 'TipoEmpresaController@update']);
    $router->delete('tipoempresa/{id}', ['uses' => 'TipoEmpresaController@destroy']);

    $router->get('acteconomica', ["uses" => "ActividadEconomicaController@index"]);
    $router->get('acteconomica/{id}', ['uses' => 'ActividadEconomicaController@show']);
    $router->post('acteconomica', ['uses' => 'ActividadEconomicaController@store']);
    $router->put('acteconomica/{id}', ['uses' => 'ActividadEconomicaController@update']);
    $router->delete('acteconomica/{id}', ['uses' => 'ActividadEconomicaController@destroy']);

    $router->get('entidad', ["uses" => "EntidadController@index"]);
    $router->get('entidad/{id}', ['uses' => 'EntidadController@show']);
    $router->post('entidad', ['uses' => 'EntidadController@store']);
    $router->put('entidad/{id}', ['uses' => 'EntidadController@update']);
    $router->delete('entidad/{id}', ['uses' => 'EntidadController@destroy']);

    $router->get('departamento', ["uses" => "DepartamentoController@index"]);
    $router->get('departamento/{id}', ['uses' => 'DepartamentoController@show']);
    $router->post('departamento', ['uses' => 'DepartamentoController@store']);
    $router->put('departamento/{id}', ['uses' => 'DepartamentoController@update']);
    $router->delete('departamento/{id}', ['uses' => 'DepartamentoController@destroy']);
    $router->get('departamento_combo', ["uses" => "DepartamentoController@combo"]);

    $router->get('area', ["uses" => "AreaController@index"]);
    $router->get('area/{id}', ['uses' => 'AreaController@show']);
    $router->post('area', ['uses' => 'AreaController@store']);
    $router->put('area/{id}', ['uses' => 'AreaController@update']);
    $router->delete('area/{id}', ['uses' => 'AreaController@destroy']);

    $router->get('cargo', ["uses" => "CargoController@index"]);
    $router->get('cargo/{id}', ['uses' => 'CargoController@show']);
    $router->post('cargo', ['uses' => 'CargoController@store']);
    $router->put('cargo/{id}', ['uses' => 'CargoController@update']);
    $router->delete('cargo/{id}', ['uses' => 'CargoController@destroy']);


});



