<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" >
        <link rel="stylesheet" href="assets/css/formulario.css" >
        <title>Formulario</title>
    </head>
    <body>

    @php
        $Estados = [
            "S" => "Si",
            "N" => "No",
            "A" => "No Aplica"
        ];

        $Institucion = \App\Models\Institucion::first();

    @endphp

        <footer>
            <div class="pagenum-container">
                Pág. <span class="pagenum"></span>
            </div>
        </footer>

        <main>
            <!-- Encabezado de la Institución -->
            <div class="row head-institucion">
                <div class="col-xs-12">
                    <table>
                        <tbody>
                        <tr>
                            <td class="text-center" style="vertical-align: center;">
                                <h4 class="text-bold" style="padding: 0; margin: 0">{{ $Institucion->Nombre  }}</h4>
                                <small>{{ $Institucion->Direccion  }}</small>
                            </td>
                            <td class="text-center">
                                <img src="assets/logo/LOGO_BOMBEROS_BUENA_FE_TRANSPARENTE.png" class="img-logo">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Información Básica -->
            <div class="row">
                <div class="col-xs-12">
                    <span class="title-main">Información Básica</span>
                    <table >
                        <tbody>
                            <tr>
                                <td class="text-bold">Fecha Inspección</td>
                                <td>{{ $Inspeccion->FechaInspeccion  }}</td>

                                <td class="text-bold">Estado</td>
                                <td>{{ $Inspeccion->getEstado()  }}</td>
                            </tr>
                            <tr>
                                <td class="text-bold">Fecha Registro</td>
                                <td>{{ $Inspeccion->created_at  }}</td>

                                <td class="text-bold">Formulario</td>
                                <td>{{ $Inspeccion->formulario->Descripcion  }}</td>
                            </tr>
                            <tr>

                                <td class="text-bold">Colaborador</td>
                                <td colspan="3">{{ $Inspeccion->colaborador->ApellidoPaterno . ' ' . $Inspeccion->colaborador->ApellidoMaterno . ' ' . $Inspeccion->colaborador->NombrePrimero  }}</td>

                            </tr>
                            <tr>
                                <td class="text-bold">Fecha Plazo</td>
                                <td colspan="3">{{ $Inspeccion->FechaPlazo }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <!-- Empresa -->
            <div class="row">
                <div class="col-xs-12">
                    <span class="title-main">Empresa</span>
                    <table >
                        <tbody>
                        <tr>
                            <td class="text-bold">Nombre Comercial</td>
                            <td>{{ $Inspeccion->Empresa->NombreComercial }}</td>

                            <td class="text-bold">Razón Social</td>
                            <td>{{ $Inspeccion->Empresa->RazonSocial }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold">RUC</td>
                            <td>{{ $Inspeccion->Empresa->RUC }}</td>

                            <td class="text-bold">Sector</td>
                            <td>{{ $Inspeccion->Empresa->sector->Descripcion }}</td>
                        </tr>
                        <tr>

                            <td class="text-bold">Clasificación</td>
                            <td >{{ $Inspeccion->Empresa->clasificacion->Descripcion }}</td>

                            <td class="text-bold">Teléfono</td>
                            <td >{{ $Inspeccion->Empresa->Telefono }}</td>

                        </tr>
                        <tr>
                            <td class="text-bold">Dirección</td>
                            <td colspan="3">{{ $Inspeccion->Empresa->Direccion }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <!-- Formulario -->
            <div class="row">
                <div class="col-xs-12">
                    <span class="title-main">Formulario - Resultados</span>
                    @foreach ($formulario as $seccion)
                        <table>
                            <thead>
                            <tr>
                                <th colspan="2">{{ $seccion["Descripcion"] }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($seccion["rcomponentes"] as $componentes)
                                    @switch($componentes["IDTipoComp"])
                                        @case('4'):
                                            <tr>
                                                <td class="text-bold">{{ $componentes["Descripcion"] }}</td>
                                                <td>{{ $componentes["Result"]? 'Si':'No'  }}</td>
                                            </tr>
                                        @break;
                                        @case('6'):
                                            <tr>
                                                <td colspan="2" class="text-bold">{{ $componentes["Descripcion"] }}</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table>
                                                        <tbody>
                                                            @foreach($componentes["Result"]["Atributo"] as $Atributo)
                                                                <tr>
                                                                    <td class="text-bold">{{ $Atributo["display"]  }}</td>
                                                                    <td>{{ $Atributo["value"]  }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </td>
                                                <td>
                                                    <table>
                                                        <tbody>
                                                        <tr>
                                                            <td class="text-bold">Cumple</td>
                                                            <td>{{ $Estados[$componentes["Result"]["Cumple"]] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-bold">Operativos</td>
                                                            <td>{{ $componentes["Result"]["Operativos"] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-bold">No Operativos</td>
                                                            <td>{{ $componentes["Result"]["NoOperativos"] }}</td>
                                                        </tr>

                                                        @if($componentes["Result"]["Cumple"] == 'N')
                                                            <tr>
                                                                <td class="text-bold">Disposición</td>
                                                                <td>{{ $componentes["Result"]["Disposicion"] }}</td>
                                                            </tr>
                                                        @endif

                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        @break;
                                        @case('5'):
                                            <tr>
                                                <td class="text-bold">{{ $componentes["Descripcion"] }}</td>
                                                <td>
                                                    <table>
                                                        <tbody>
                                                        <tr>
                                                            <td class="text-bold">Cantidad</td>
                                                            <td>{{ $componentes["Result"]["Cantidad"] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-bold">Cumple</td>
                                                            <td>{{ $Estados[$componentes["Result"]["Cumple"]] }}</td>
                                                        </tr>

                                                        @if($componentes["Result"]["Cumple"] == 'N')
                                                            <tr>
                                                                <td class="text-bold">Adquirir</td>
                                                                <td>{{ $componentes["Result"]["Adquirir"] }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-bold">Disposición</td>
                                                                <td>{{ $componentes["Result"]["Dispocision"] }}</td>
                                                            </tr>
                                                        @endif

                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        @break;
                                        @default:
                                            <tr>
                                                <td class="text-bold">{{ $componentes["Descripcion"] }}</td>
                                                <td>{{ $componentes["Result"]  }}</td>
                                            </tr>
                                        @break;
                                    @endswitch

                            @endforeach
                            </tbody>
                        </table>
                        <br>
                    @endforeach
                </div>
            </div>

            <!-- Observaciones -->
            <div class="row">
                <div class="col-xs-12">

                    @if(count($Inspeccion->observacions) > 0)

                        <span class="title-main">Disposición</span>
                        <ul>
                            @foreach ($Inspeccion->observacions as $observacion)
                                <li>{{ $observacion->Observacion  }}</li>
                            @endforeach
                        </ul>

                    @endif
                </div>
            </div>

            <div class="page-break"></div>

            <!-- Anexos -->
            <div class="row">
                <div class="col-xs-12">
                    <span class="title-main">Anexos</span>
                    <hr>
                    @foreach($Anexos as $Anexo)
                        <img src="Imgs/{{ $Anexo }}" >
                    @endforeach
                </div>
            </div>
        </main>


    </body>
</html>