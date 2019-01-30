<!doctype html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" >
        <title>Document</title>
        <style type="text/css">

            table {
                font-size: 0.9rem;
            }

            div.border {
                border: #3c3c3c solid 1px;
                /*margin: 0 1px;*/
            }

            .text-bold{
                font-weight: bold;
            }
            thead td {
                background-color: #9d9d9d;
                border: #0f0f0f solid 1px;
                margin: 2px;
                text-align: center;
            }

            .content-tab {
                width: 100%;
                height: 65px;
                overflow-y: hidden;
            }

            .content-tab ul {
                width: 100%;
                /*padding-left: 0px !important;*/
                list-style: none;
            }

            .content-tab li {
                display: inline-block;
                margin-left: 0;
                margin-right: 2px;
                width: 30%;

            }
            .content-tab table::before {
                background-color: #000;
                content: "";
                display: block;
                height: 1px;
                position: absolute;
                width: 100%;
                top: 35px;
            }
            .content-tab table {
                text-align: center;
                width: 100%;
                margin-top: 35px;
            }


        </style>
    </head>
    <body>
        <div class="row" >
            <div class="col-xs-6 text-center">
                <h4 class="text-bold"> CUERPO DE BOMBEROS MUNICIPAL DEL CANTÓN BUENA FE </h4>
            </div>
            <div class="col-xs-4">
                <h5 class="text-bold">DEPARTAMENTO DE TESORERIA</h5>
                <table style="width: 100%;">
                    <tr>
                        <td class="text-bold">FECHA EMISIÓN</td>
                        <td>2019-01-10 22:23:00</td>
                    </tr>
                    <tr>
                        <td class="text-bold">PERIODO</td>
                        <td>2019</td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- Identificación -->
        <div class="row">
            <div class="col-xs-8 border">
                <table style="width: 100%">
                    <tr>
                        <td class="text-bold" style="width: 25%;">Identificación</td>
                        <td>0992812443001</td>
                    </tr>
                    <tr>
                        <td class="text-bold" style="width: 25%;">Nombre</td>
                        <td>AGROTRINOBIS S.A.</td>
                    </tr>
                </table>
            </div>
            <div class="col-xs-3 border" >
                <table style="width: 100%">
                    <tr>
                        <td class="text-bold">Desde</td>
                        <td>2019-01-25</td>
                    </tr>
                    <tr>
                        <td class="text-bold">Hasta</td>
                        <td>2019-01-25</td>
                    </tr>
                </table>

            </div>
        </div>

        <!-- Establecimiento -->
        <span class="text-bold">ESTABLECIMIENTO</span>
        <div class="row">
            <div class="col-xs-12 border">

                <table style="width: 100%">
                    <tr>
                        <td class="text-bold" style="width: 20%;">RAZÓN SOCIAL</td>
                        <td>EXPORTADORA AGROTRINOBIS S.A</td>
                    </tr>
                    <tr>
                        <td class="text-bold" style="width: 20%;">ACT. ECONÓMICA</td>
                        <td>SECTOR LA Y CALLE AV. 7 DE AGOSTO NUMERO 111 FRENTE A LA ESTACION DE SERVICIOS GENESIS</td>
                    </tr>
                    <tr>
                        <td class="text-bold" style="width: 20%;">DIRECCIÓN</td>
                        <td>VENTA AL POR MAYOR Y MENOR DE GRANOS</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Detalles -->
        <div class="row" style="margin-top: 2px;">
            <div class="col-xs-8 text-center border">
                <span class="text-bold">TASA DE SERVICIO ANUAL</span>
                <table style="width: 100%">
                    <thead>
                        <tr class="text-bold">
                            <td width="80%">RUBRO</td>
                            <td>VALOR</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rows as $row)
                            <tr>
                                <td >{{ $row["Rubro"] }}</td>
                                <td style="text-align: right;">{{ $row["Valor"] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="text-bold" style="text-align: right;">
                            <td>Total</td>
                            <td>0.00</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="col-xs-3 border">
                <table style="width: 100%; font-size: 0.7em;">
                    <tr>
                        <td class="text-bold">ID INTERNO</td>
                        <td>1</td>
                    </tr>
                    <tr>
                        <td class="text-bold">SECUENCIAL SISTEMA</td>
                        <td>0000265</td>
                    </tr>
                    <tr>
                        <td class="text-bold">FECHA DE IMPRESIÓN</td>
                        <td>2019-01-25</td>
                    </tr>
                    <tr>
                        <td class="text-bold">HORA DE IMPRESIÓN</td>
                        <td>18:43</td>
                    </tr>
                </table>
            </div>
        </div>

        <br>
        <!-- Firmas -->
        <div class="content-tab">

            <ul>
                <li>
                    <table >
                        <tr>
                            <td>Kevin Suarez Guzman</td>
                        </tr>
                        <tr>
                            <td class="text-bold">Cargo</td>
                        </tr>
                    </table>
                </li>
                <li>
                    <table >
                        <tr>
                            <td>Kevin Suarez Guzman</td>
                        </tr>
                        <tr>
                            <td class="text-bold">Cargo</td>
                        </tr>
                    </table>
                </li>
                <li>
                    <table >
                        <tr>
                            <td>Kevin Suarez Guzman</td>
                        </tr>
                        <tr>
                            <td class="text-bold">Cargo</td>
                        </tr>
                    </table>
                </li>
            </ul>

            {{--<table >--}}
                {{--<tr>--}}
                    {{--<td>Kevin Suarez Guzman</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<td>Cargo</td>--}}
                {{--</tr>--}}
            {{--</table>--}}

            {{--<table >--}}
                {{--<tr>--}}
                    {{--<td>Kevin Suarez Guzman</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<td>Cargo</td>--}}
                {{--</tr>--}}
            {{--</table>--}}

            {{--<table >--}}
                {{--<tr>--}}
                    {{--<td>Kevin Suarez Guzman</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<td>Cargo</td>--}}
                {{--</tr>--}}
            {{--</table>--}}
        </div>


    </body>
</html>