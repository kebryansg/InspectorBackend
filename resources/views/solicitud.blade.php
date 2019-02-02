<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/solicitud.css">
        <title>Formulario</title>
    </head>
    <body>

        @php
            $Institucion = \App\Models\Institucion::first();

        @endphp

        <header>
            <table>
                <tbody>
                    <tr>
                        <td>
                            <img src="assets/logo/LOGO_BOMBEROS_BUENA_FE_TRANSPARENTE.png" class="img-logo">
                        </td>
                        <td class="text-center" style="vertical-align: center;">
                            <h4 class="text-bold" style="padding: 0; margin: 0">{{ $Institucion->Nombre  }}</h4>
                            <small>RUC: {{ $Institucion->Ruc  }}</small>
                            <br>
                            <small>BUENA FE - LOS RIOS</small>
                        </td>
                    </tr>
                </tbody>
            </table>
        </header>

        <footer>
            <div class="row">
                {{--Pág. <span class="pagenum"></span>--}}
                <span>Dirección: {{ $Institucion->Direccion }}</span>
                <br>
                <span>Página web: <strong>www.bomberosbnf.gob.es</strong></span>
                <br>
                <span>Email: {{ $Institucion->Email  }}</span>
            </div>
        </footer>

        <main>
            <div class="body-main">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h5 >SOLICITUD DE INSPECCIÓN</h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <span>Solicitud N° 000567</span>
                        <br>
                        <span>Fecha: 03 de noviembre del 2018 </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <span>Señores</span>
                        <br>
                        <span>Departamento de Prevención de Incendios</span>
                        <br>
                        {{--<span class="text-bold text-uppercase">CUERPO DE BOMBEROS MUNICIPAL DE SAN JACINTO DE BUENA FE</span>--}}
                        <span class="text-bold text-uppercase">{{ $Institucion->Nombre }}</span>
                        <br>
                        <span>En su despacho.-</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <span>De mi consideración:</span>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xs-12">
                        <p class="text-justify">
                            Yo, <span class="text-bold">ANGEL SEGUNDO CEDEÑO RISCO</span> con RUC. Número <span class="text-bold">1234567890001</span>
                            solicito a usted se autorice a quien corresponda para que realice la <span class="text-bold">INSPECCION</span> de mi negocio para lo
                            cual detallo la siguiente información:
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <table>
                            <tbody>

                                <tr>
                                    <td>Nombre Comercial: <span class="text-bold text-uppercase"></span></td>
                                </tr>
                                <tr>
                                    <td>Actividad Económica: <span class="text-bold text-uppercase"></span></td>
                                </tr>
                                <tr>
                                    <td>Dirección: <span class="text-bold text-uppercase"></span></td>
                                </tr>
                                <tr>
                                    <td>Parroquia: <span class="text-bold text-uppercase"></span></td>
                                </tr>
                                <tr>
                                    <td>Sector: <span class="text-bold text-uppercase"></span></td>
                                </tr>
                                <tr>
                                    <td>Referencia: <span class="text-bold text-uppercase"></span></td>
                                </tr>
                                <tr>
                                    <td>Teléfono: <span class="text-bold text-uppercase"></span></td>
                                </tr>
                                <tr>
                                    <td>Correo electrónico: <span class="text-bold text-uppercase"></span></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <p>
                            Esperando que mi solicitud tenga la acogida favorable, reitero mis agradecimientos.
                        </p>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xs-12 text-center text-bold">
                        <span>Atentamente</span>
                        <br>
                        <span>Abnegación y Disciplina</span>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xs-12 text-center">
                        <span class="text-bold">ANGEL SEGUNDO CEDEÑO RISCO</span>
                        <br>
                        <span>SOLICITANTE</span>
                        <br>
                        <span>C.I.: <strong>1234567890</strong></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <p> <strong>Nota:</strong>
                            El {{ $Institucion->Nombre  }}, deslinda responsabilidad si los datos proporcionados por el usuario son erróneos.
                        </p>
                    </div>
                </div>


            </div>
        </main>
    </body>
</html>