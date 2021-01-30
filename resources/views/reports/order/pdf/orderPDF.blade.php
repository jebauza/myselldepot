<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $order->order_number }}</title>

    <style>
        @page {
            margin: 1.3rem;
            margin-top: 1.9rem;
            padding: 1rem;
        }

        body {
            margin: 0px;
        }

        * {
            font-family: verdana, arial, sans-serif;
        }

        .cabecera {
            background-color: #FEFEFE;
            color: #000000;
            padding: 2rem;
            padding-top: .2rem;
            padding-bottom: 0px;
        }

        .cabecera .logo {
            margin: 5px;
        }

        .cabecera .table {
            padding: 1px;
            margin-bottom: .2rem;
        }

        .table {
            font-size: x-small
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }
    </style>

</head>

<body>
    <div class="cabecera">

        <table width="100%" cellspacing="0" cellspacing="2" border="1" align="center">
            <tr>
                <td>
                    <table cellspacing="1" align="center">
                        <tr>
                            <td>
                                <img src="{{ $logo }}" alt="Texto altenrantivo al no cargar la imagen" class="logo"
                                    width="210" height="90">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{--  Curso de laravel y vue --}}
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table cellspacing="1" align="center">
                        <tr>
                            <td>#Pedido</td>
                            <td>{{ $order->order_number }}</td>
                        </tr>
                        <tr>
                            <td>Fecha del Pedido</td>
                            <td>{{ $order->created_at }}</td>
                        </tr>
                        <tr>
                            <td>Estado del pedido</td>
                            <td>{{ $order->state }}</td>
                        </tr>
                        <tr>
                            <td>Vendedor</td>
                            <td>{{ $order->seller->fullName }}</td>
                        </tr>

                    </table>
                </td>
            </tr>
        </table>


        <table width="100%" cellspacing="0" cellspacing="2" border="1" align="center">
            <tr>
                <td colspan="2">
                    <h3><strong>Información del cliente</strong></h3>
                </td>
            </tr>
            <tr>
                <td>Cliente</td>
                <td>{{ $order->customer->fullName }}</td>
            </tr>
            <tr>
                <td>Documento</td>
                <td>{{ $order->customer->document }}</td>
            </tr>
            <tr>
                <td>Correo electronico</td>
                <td>{{ $order->customer->email }}</td>
            </tr>
            <tr>
                <td>Telefono</td>
                <td>{{ $order->customer->phone }}</td>
            </tr>
        </table>


        <table width="100%" cellspacing="0" cellspacing="2" border="1" align="center">
            <thead style="background-color: lightgray;">
                <tr align="center" align="middle">
                    <th colspan="5">Detalles del pedido</th>
                </tr>
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>subTotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->products as $index => $product)
                @php
                $pivot = $product->pivot;
                @endphp
                <tr>
                    <th align="center">{{ $loop->iteration }} {{-- {{ ($index + 1) OR $loop->index + 1 }} --}}</th>
                    <th align="center">{{ $product->name }}</th>
                    <th align="center">{{ $pivot->quantity }}</th>
                    <th align="center">€ {{ $pivot->price }}</th>
                    <th align="center">€
                        {{ round(floatval($pivot->price) * intval($pivot->quantity), 2) }}
                    </th>
                </tr>
                @endforeach
            </tbody>
        </table>


        <table width="100%" cellspacing="0" cellspacing="2" border="0" align="center">
            <tr>
                <td align="right">
                    <h3><strong>Total del pedidio</strong></h3>
                </td>
                <td align="center">
                    <h3>€ {{ $order->total }}</h3>
                </td>
            </tr>
        </table>


        <table width="100%" cellspacing="0" cellspacing="2" border="0" align="center">
            <tr>
                <td>
                    <h3><strong>Comentarios Adicionales</strong></h3>
                </td>
                <td>{!! $order->comments !!}</td>
            </tr>
        </table>



    </div>
</body>

</html>
