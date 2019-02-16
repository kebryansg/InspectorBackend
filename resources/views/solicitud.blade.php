<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/solicitud.css">
        <title>Solicitud N° {{ $Inspeccion->ID }}</title>
    </head>
    <body>

        @php
            $Institucion = \App\Models\Institucion::first();
            $Solicitante = $Inspeccion->empresa->entidad->Apellidos. ' ' . $Inspeccion->empresa->entidad->Nombres;
            $Identificacion = $Inspeccion->empresa->entidad->Identificacion;
        @endphp

        <header>
            <img src="assets/logo/LOGO_BOMBEROS_BUENA_FE_TRANSPARENTE.png" class="img-logo">
            <div class="encabezado">
                <div class="row" >
                    <div class="col-xs-12 text-center">
                        <h4 class="text-bold" style="padding: 0; margin: 0">{{ $Institucion->Nombre  }}</h4>
                        <small>RUC: {{ $Institucion->Ruc  }}</small>
                        <br>
                        <small>BUENA FE - LOS RIOS</small>
                    </div>
                </div>
                <hr class="hr-oficio" >
            </div>

        </header>

        <footer>
            <!-- Nota -->
            <div class="row">
                <div class="col-xs-12">
                    <p> <strong>Nota:</strong>
                        El {{ $Institucion->Nombre  }}, deslinda responsabilidad si los datos proporcionados por el usuario son erróneos.
                    </p>
                </div>
            </div>
            <hr class="hr-oficio">
            <div class="row text-center">
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
                <!-- Titulo -->
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h4 class="text-bold">SOLICITUD DE INSPECCIÓN</h4>
                    </div>
                </div>
                <!-- Información de solicitud -->
                <div class="row">
                    <div class="col-xs-12">
                        <span>Solicitud N° {{ $Inspeccion->ID }}</span>
                        <br>
                        <span>Fecha: {{ $Inspeccion->created_at->toDateTimeString()  }} </span>
                    </div>
                </div>
                <br>
                <!-- Información de solicitud -->
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
                <br>
                <div class="row">
                    <div class="col-xs-12">
                        <span>De mi consideración:</span>
                    </div>
                </div>
                <br>
                <!-- Petición -->
                <div class="row">
                    <div class="col-xs-12">
                        <p class="text-justify">
                            Yo, <span class="text-bold">{{ $Solicitante }}</span> con RUC. Número <span class="text-bold">{{ $Identificacion }}</span>
                            solicito a usted se autorice a quien corresponda para que realice la <span class="text-bold">INSPECCION</span> de mi negocio para lo
                            cual detallo la siguiente información:
                        </p>
                    </div>
                </div>
                <br>
                <!-- Información Local -->
                <div class="row">
                    <div class="col-xs-12">
                        <table>
                            <tbody>

                                <tr>
                                    <td>Nombre Comercial: <span class="text-bold text-uppercase">{{ $Inspeccion->empresa->NombreComercial }}</span></td>
                                </tr>
                                <tr>
                                    <td>Actividad Económica: <span class="text-bold text-uppercase">{{ $Inspeccion->empresa->acteconomica->Descripcion }}</span></td>
                                </tr>
                                <tr>
                                    <td>Dirección: <span class="text-bold text-uppercase">{{ $Inspeccion->empresa->Direccion }}</span></td>
                                </tr>
                                <tr>
                                    <td>Parroquia: <span class="text-bold text-uppercase">{{ $Inspeccion->empresa->sector->parroquium->Descripcion }}</span></td>
                                </tr>
                                <tr>
                                    <td>Sector: <span class="text-bold text-uppercase">{{ $Inspeccion->empresa->sector->Descripcion }}</span></td>
                                </tr>
                                <tr>
                                    <td>Referencia: <span class="text-bold text-uppercase"></span></td>
                                </tr>
                                <tr>
                                    <td>Teléfono de contacto: <span class="text-bold text-uppercase">{{ $Inspeccion->empresa->Telefono }}</span></td>
                                </tr>
                                <tr>
                                    <td>Correo electrónico: <span class="text-bold">{{ $Inspeccion->empresa->Email }}</span></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                <!-- Agradecimiento -->
                <div class="row">
                    <div class="col-xs-12">
                        <p>
                            Esperando que mi solicitud tenga la acogida favorable, reitero mis agradecimientos.
                        </p>
                    </div>
                </div>

                <!-- Firma -->
                <div class="row">
                    <div class="col-xs-12 text-center text-bold">
                        <span>Atentamente</span>
                        <br>
                        <span>Abnegación y Disciplina</span>
                    </div>
                </div>

                <br>
                <br>
                <br>
                <br>

                <div class="row">
                    <div class="col-xs-12 text-center">
                        <span class="text-bold">{{ $Solicitante }}</span>
                        <br>
                        <span>SOLICITANTE</span>
                        <br>
                        <span>C.I.: <strong>{{ $Identificacion }}</strong></span>
                    </div>
                </div>

            </div>
        </main>
    </body>
</html>