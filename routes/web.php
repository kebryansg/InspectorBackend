<?php

//date_default_timezone_set('America/Guayaquil');

use Morrislaptop\Firestore\Factory;
use Kreait\Firebase\ServiceAccount;


$serviceAccount = ServiceAccount::fromJsonFile(dirname(__DIR__) . '/app/secret/inspector-7933a.json');
$firestore = (new Factory)
    ->withServiceAccount($serviceAccount)
    ->createFirestore();


$router->get('/', function () use ($router) {
    return response()->json($router->app->version(), 200);
});

$router->group(['middleware' => ['auth', 'valid']], function () use ($router) {

    $router->get('/users', function (\Illuminate\Http\Request $request) {
        return $request->user();
    });

    #region Institucion

    $router->get('institucion', ["uses" => "InstitucionController@index"]);
    $router->put('institucion/{id}', ['uses' => 'InstitucionController@update']);

    $router->get('compania', ["uses" => "CompaniaController@index"]);
    $router->get('compania/{id}', ['uses' => 'CompaniaController@show']);
    $router->put('compania/{id}', ['uses' => 'CompaniaController@update']);
    $router->delete('compania/{id}', ['uses' => 'CompaniaController@destroy']);
    $router->post('compania', ['uses' => 'CompaniaController@store']);
    $router->get('compania_combo', ['uses' => 'CompaniaController@combo']);

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
    #endregion

    #region Empresa
    $router->get('empresa', ["uses" => "EmpresaController@index"]);
    $router->get('empresa/{id}', ['uses' => 'EmpresaController@show']);
    $router->post('empresa', ['uses' => 'EmpresaController@store']);
    $router->put('empresa/{id}', ['uses' => 'EmpresaController@update']);
    $router->delete('empresa/{id}', ['uses' => 'EmpresaController@destroy']);

    $router->get('entidad', ["uses" => "EntidadController@index"]);
    $router->get('entidad_combo', ["uses" => "EntidadController@combo"]);
    $router->get('entidad/{id}', ['uses' => 'EntidadController@show']);
    $router->post('entidad', ['uses' => 'EntidadController@store']);
    $router->put('entidad/{id}', ['uses' => 'EntidadController@update']);
    $router->delete('entidad/{id}', ['uses' => 'EntidadController@destroy']);
    #endregion

    #region Nomina

    $router->get('colaborador', ["uses" => "ColaboradorController@index"]);
    $router->get('colaborador/{id}/', ['uses' => 'ColaboradorController@show']);
    $router->get('colaborador_inspector/', ['uses' => 'ColaboradorController@inspectores']);
    $router->post('colaborador', ['uses' => 'ColaboradorController@store']);
    $router->get('colaborador/{id}/async', ['uses' => 'ColaboradorController@upload']);
    $router->put('colaborador/{id}/', ['uses' => 'ColaboradorController@update']);
    $router->delete('colaborador/{id}/', ['uses' => 'ColaboradorController@destroy']);

    $router->get('cargo', ["uses" => "CargoController@index"]);
    $router->get('cargo_combo', ["uses" => "CargoController@combo"]);
    $router->get('cargo/{id}', ['uses' => 'CargoController@show']);
    $router->post('cargo', ['uses' => 'CargoController@store']);
    $router->put('cargo/{id}', ['uses' => 'CargoController@update']);
    $router->delete('cargo/{id}', ['uses' => 'CargoController@destroy']);

    #endregion

    #region ActividadEconómica
    $router->get('tipoact', ["uses" => "TipoActEconomicaController@index"]);
    $router->get('tipoact_combo', ["uses" => "TipoActEconomicaController@combo"]);
    $router->get('tipoact/{id}', ['uses' => 'TipoActEconomicaController@show']);
    $router->post('tipoact', ['uses' => 'TipoActEconomicaController@store']);
    $router->put('tipoact/{id}', ['uses' => 'TipoActEconomicaController@update']);
    $router->delete('tipoact/{id}', ['uses' => 'TipoActEconomicaController@destroy']);

    $router->get('clasificacion', ["uses" => "ClasificacionController@index"]);
    $router->get('clasificacion_combo', ["uses" => "ClasificacionController@combo"]);
    $router->get('clasificacion_ls_asign', ["uses" => "ClasificacionController@listAsignFormulario"]);
    $router->post('clasificacion_ls_asign/{form}/', ["uses" => "ClasificacionController@store_listAsignFormulario"]);
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
    #endregion

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
    $router->get('inspeccion/{id}/', ['uses' => 'InspeccionController@show']);
    $router->get('inspeccion/{id}/async', ['uses' => 'InspeccionController@upload']);
    $router->post('inspeccion', ['uses' => 'InspeccionController@store']);
    $router->put('inspeccion/{id}/', ['uses' => 'InspeccionController@update']);
    $router->delete('inspeccion/{id}/', ['uses' => 'InspeccionController@destroy']);
    $router->put('inspeccion/{id}/coladorador/{colaborador}/', ['uses' => 'InspeccionController@inspeccion_colaborador']);
    #endregion

    #region Formulario
    $router->get('formulario', ["uses" => "FormularioController@index"]);
    $router->get('formulario_combo', ["uses" => "FormularioController@combo"]);
//    $router->get('formulario_async', ["uses" => "FormularioController@syncFormulario"]);
    $router->get('formulario/{id}/', ['uses' => 'FormularioController@show']);
    $router->post('formulario', ['uses' => 'FormularioController@store']);
    $router->put('formulario/{id}', ['uses' => 'FormularioController@update']);
    $router->delete('formulario/{id}', ['uses' => 'FormularioController@destroy']);
    #endregion

    ##region Seccion
    $router->get('seccion', ["uses" => "SeccionController@index"]);
    $router->get('seccion_combo', ["uses" => "SeccionController@combo"]);
    $router->get('seccion/{id}', ['uses' => 'SeccionController@show']);
    $router->post('seccion', ['uses' => 'SeccionController@store']);
    $router->put('seccion/{id}', ['uses' => 'SeccionController@update']);
    $router->delete('seccion/{id}', ['uses' => 'SeccionController@destroy']);
    #endregion

    ##region Componente
    $router->get('componente', ["uses" => "ComponenteController@index"]);
    $router->get('componente/{id}', ['uses' => 'ComponenteController@show']);
    $router->post('componente', ['uses' => 'ComponenteController@store']);
    $router->put('componente/{id}', ['uses' => 'ComponenteController@update']);
    $router->delete('componente/{id}', ['uses' => 'ComponenteController@destroy']);
    #endregion

    #region Seccion-Componente
    $router->get('components/seccion/', ["uses" => "ComponenteController@componente_secion"]);
    $router->get('seccions/components/', ["uses" => "ComponenteController@componente_secioncomponent"]);
    $router->post('components/seccion/{id}', ["uses" => "ComponenteController@componente_secion_store"]);
    #endregion

    #region Formulario-Seccion
//    $router->get('formulario/{form}/seccion/full/', ["uses" => "FormularioController@seccion_formulario_full"]);
    $router->get('formulario/{form}/seccion/config/', ["uses" => "FormularioController@seccion_formulario_config"]);
    $router->post('formulario/{form}/seccion/config/', ["uses" => "FormularioController@seccion_formulario_store"]);


//    $router->get('formularios/{form}/seccion', ["uses" => "FormularioController@seccion_formulario"]);
//    $router->get('formularios/{form}/component', ["uses" => "FormularioController@component_formulario"]);
//    $router->post('formularios/{id}/seccion', ["uses" => "FormularioController@seccion_store"]);
    #endregion

    #region TipoComponente
    $router->get('tipocomp', ["uses" => "TipoComponenteController@index"]);
    $router->get('tipocomp_combo', ["uses" => "TipoComponenteController@combo"]);
    #endregion

    #region Device
    $router->get('device', ["uses" => "DeviceController@index"]);
    $router->get('device/{id}/', ['uses' => 'DeviceController@show']);
    $router->put('device/{id}/', ['uses' => 'DeviceController@aprobarDevice']);
    #endregion
});

// Registrar Dispositivo sin Autentificar
$router->post('reg_device', ["uses" => "DeviceController@store"]);

// Middleware Dispositivo Registrado
#region DownloadInfo
$router->get('inspeccion_sync', function () {
    $Inspeccions = \App\Models\Inspeccion::whereNotNull('IDColaborador')
        ->get([
            'Inspeccion.ID',
            'Inspeccion.FechaTentativa',
            'IDEmpresa',
            'Inspeccion.IDColaborador',
            'Inspeccion.IDFormulario',
            'Inspeccion.Estado'
        ]);
    $Empresa = \App\Models\Empresa::whereIn('ID', $Inspeccions->pluck('IDEmpresa'))->get();

    foreach ($Inspeccions as $Inspeccion) {
        $Inspeccion["Empresa"] = $Empresa->firstWhere('ID', $Inspeccion['IDEmpresa']);
        unset($Inspeccion['IDEmpresa']);
    }

    return response()->json($Inspeccions, 200);
});

$router->get('colaborador_sync', function () {
    $colaboradors = \App\Models\Colaborador::where('IDCargo', 2)->get();
    $rows = [];
    foreach ($colaboradors as $Colaborador) {
        $rows[] = [
            'ID' => $Colaborador->ID,
            'Cedula' => $Colaborador->Cedula,
            'Email' => $Colaborador->Email,
            'Nombre' => $Colaborador->ApellidoPaterno . ' ' . $Colaborador->ApellidoMaterno . ' ' . $Colaborador->NombrePrimero,
            'Created_at' => $Colaborador->created_at->getTimestamp(),
            'Updated_at' => $Colaborador->updated_at->getTimestamp(),
        ];
    }
    return response()->json($rows, 200);
});
#endregion


/* Pruebas Ionic */
$router->get('formulario/{form}/seccion/full/', ["uses" => "FormularioController@seccion_formulario_full"]);


$router->get('formulario_async', ["uses" => "FormularioController@syncFormulario"]);


$router->get('firebase/', function () use ($firestore) {
    $collection = $firestore->collection('colaborador');
    $rows = [];
    foreach ($collection->documents() as $document) {
        $rows[] = $document->data();
    }

    return response()->json($rows, 201);
});
$router->post('firebase/', function () use ($firestore) {
    $colaboradors = \App\Models\Colaborador::where('IDCargo', 2)
        ->get();

    foreach ($colaboradors as $Colaborador) {
//        $key = $colaborador->created_at->getTimestamp();

        $collection = $firestore->collection('colaborador');
        $FireValue = $collection->document('colb_' . $Colaborador->ID);

        $FireValue->set([
            'ID' => $Colaborador->ID,
            'Cedula' => $Colaborador->Cedula,
            'Email' => $Colaborador->Email,
            'Nombre' => $Colaborador->ApellidoPaterno . ' ' . $Colaborador->ApellidoMaterno . ' ' . $Colaborador->NombrePrimero,
            'Created_at' => $Colaborador->created_at->getTimestamp(),
            'Updated_at' => $Colaborador->updated_at->getTimestamp()
        ]);

    }
    return $colaboradors;
});

/* Pruebas Storage */
// $router->get('storage/', [ 'uses' => 'InspeccionController@create' ]);

$router->post('inspeccion/{id}/', ['uses' => 'InspeccionController@syncInspeccion']);
$router->get('inspeccion/{id}/anexos/', ['uses' => 'InspeccionController@readAnexos']);


