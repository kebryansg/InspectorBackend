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
    //$router->get('institucion/{id}', ['uses' => 'InstitucionController@show']);
    //$router->get('comboempresa', ['uses' => 'EmpresaController@combo']);


    $router->get('compania', ["uses" => "CompaniaController@index"]);
    $router->get('compania/{id}', ['uses' => 'CompaniaController@show']);
    $router->put('compania/{id}', ['uses' => 'CompaniaController@update']);
    $router->delete('compania/{id}', ['uses' => 'CompaniaController@destroy']);
    $router->post('compania', ['uses' => 'CompaniaController@store']);
//    $router->get('combo_compañia', ['uses' => 'CompaniaController@combo']);


});



