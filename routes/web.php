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

$router->group(['middleware' => ['auth', 'valid']], function () use ($router) {
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
    $router->get('compania_combo', ['uses' => 'CompaniaController@combo']);

    $router->get('tipoempresa', ["uses" => "TipoEmpresaController@index"]);
    $router->get('tipoempresa_combo', ["uses" => "TipoEmpresaController@combo"]);
    $router->get('tipoempresa/{id}', ['uses' => 'TipoEmpresaController@show']);
    $router->post('tipoempresa', ['uses' => 'TipoEmpresaController@store']);
    $router->put('tipoempresa/{id}', ['uses' => 'TipoEmpresaController@update']);
    $router->delete('tipoempresa/{id}', ['uses' => 'TipoEmpresaController@destroy']);

    $router->get('empresa', ["uses" => "EmpresaController@index"]);
    $router->get('empresa/{id}', ['uses' => 'EmpresaController@show']);
    $router->post('empresa', ['uses' => 'EmpresaController@store']);
    $router->put('empresa/{id}', ['uses' => 'EmpresaController@update']);
    $router->delete('empresa/{id}', ['uses' => 'EmpresaController@destroy']);

    $router->get('clasificacion', ["uses" => "ClasificacionController@index"]);
    $router->get('clasificacion_combo', ["uses" => "ClasificacionController@combo"]);
    $router->get('clasificacion/{id}', ['uses' => 'ClasificacionController@show']);
    $router->post('clasificacion', ['uses' => 'ClasificacionController@store']);
    $router->put('clasificacion/{id}', ['uses' => 'ClasificacionController@update']);
    $router->delete('clasificacion/{id}', ['uses' => 'ClasificacionController@destroy']);

    $router->get('acteconomica', ["uses" => "ActividadEconomicaController@index"]);
    $router->get('acteconomica/{id}', ['uses' => 'ActividadEconomicaController@show']);
    $router->post('acteconomica', ['uses' => 'ActividadEconomicaController@store']);
    $router->put('acteconomica/{id}', ['uses' => 'ActividadEconomicaController@update']);
    $router->delete('acteconomica/{id}', ['uses' => 'ActividadEconomicaController@destroy']);
    $router->get('acteconomica_combo', ["uses" => "ActividadEconomicaController@combo"]);

    $router->get('entidad', ["uses" => "EntidadController@index"]);
    $router->get('entidad_combo', ["uses" => "EntidadController@combo"]);
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
    $router->get('area_combo', ["uses" => "AreaController@combo"]);
    $router->get('area/{id}', ['uses' => 'AreaController@show']);
    $router->post('area', ['uses' => 'AreaController@store']);
    $router->put('area/{id}', ['uses' => 'AreaController@update']);
    $router->delete('area/{id}', ['uses' => 'AreaController@destroy']);

    $router->get('cargo', ["uses" => "CargoController@index"]);
    $router->get('cargo_combo', ["uses" => "CargoController@combo"]);
    $router->get('cargo/{id}', ['uses' => 'CargoController@show']);
    $router->post('cargo', ['uses' => 'CargoController@store']);
    $router->put('cargo/{id}', ['uses' => 'CargoController@update']);
    $router->delete('cargo/{id}', ['uses' => 'CargoController@destroy']);

    $router->get('colaborador', ["uses" => "ColaboradorController@index"]);
    $router->get('colaborador/{id}', ['uses' => 'ColaboradorController@show']);
    $router->post('colaborador', ['uses' => 'ColaboradorController@store']);
    $router->put('colaborador/{id}', ['uses' => 'ColaboradorController@update']);
    $router->delete('colaborador/{id}', ['uses' => 'ColaboradorController@destroy']);


    #region Localization
    $router->get('location_combo_canton', ["uses" => "LocationController@combo_canton"]);
    $router->get('location_combo_parroquia', ["uses" => "LocationController@combo_parroquia"]);
    $router->get('location_combo_sector', ["uses" => "LocationController@combo_sector"]);


    $router->get('provincia', ["uses" => "ProvinciaController@index"]);
    $router->get('provincia_combo', ["uses" => "ProvinciaController@combo"]);
    $router->get('provincia/{id}', ['uses' => 'ProvinciaController@show']);
    $router->post('provincia', ['uses' => 'ProvinciaController@store']);
    $router->put('provincia/{id}', ['uses' => 'ProvinciaController@update']);
    $router->delete('provincia/{id}', ['uses' => 'ProvinciaController@destroy']);

    $router->get('canton', ["uses" => "CantonController@index"]);
//    $router->get('canton_combo', ["uses" => "CantonController@combo"]);
    $router->get('canton/{id}', ['uses' => 'CantonController@show']);
    $router->post('canton', ['uses' => 'CantonController@store']);
    $router->put('canton/{id}', ['uses' => 'CantonController@update']);
    $router->delete('canton/{id}', ['uses' => 'CantonController@destroy']);

    $router->get('parroquia', ["uses" => "ParroquiaController@index"]);
//    $router->get('parroquia_combo', ["uses" => "ParroquiaController@combo"]);
    $router->get('parroquia/{id}', ['uses' => 'ParroquiaController@show']);
    $router->post('parroquia', ['uses' => 'ParroquiaController@store']);
    $router->put('parroquia/{id}', ['uses' => 'ParroquiaController@update']);
    $router->delete('parroquia/{id}', ['uses' => 'ParroquiaController@destroy']);


    $router->get('sector', ["uses" => "SectorController@index"]);
//    $router->get('sector_combo', ["uses" => "SectorController@combo"]);
    $router->get('sector/{id}', ['uses' => 'SectorController@show']);
    $router->post('sector', ['uses' => 'SectorController@store']);
    $router->put('sector/{id}', ['uses' => 'SectorController@update']);
    $router->delete('sector/{id}', ['uses' => 'SectorController@destroy']);

    #endregion

    #region Inspeccion

    $router->get('inspeccion', ["uses" => "InspeccionController@index"]);
    $router->get('inspeccion/{id}', ['uses' => 'InspeccionController@show']);
    $router->post('inspeccion', ['uses' => 'InspeccionController@store']);
    $router->put('inspeccion/{id}', ['uses' => 'InspeccionController@update']);
    $router->delete('inspeccion/{id}', ['uses' => 'InspeccionController@destroy']);

    #endregion

    #region Componente
    $router->get('componente', ["uses" => "ComponenteController@index"]);
    $router->get('componente/{id}', ['uses' => 'ComponenteController@show']);
    $router->post('componente', ['uses' => 'ComponenteController@store']);
    $router->put('componente/{id}', ['uses' => 'ComponenteController@update']);
    $router->delete('componente/{id}', ['uses' => 'ComponenteController@destroy']);
    #endregion


    #region TipoComponente
    $router->get('tipocomp', ["uses" => "TipoComponenteController@index"]);
    $router->get('tipocomp_combo', ["uses" => "TipoComponenteController@combo"]);
    #endregion
});



