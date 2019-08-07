<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset(env("css")."bootstrap.min.css") }}">
    <link rel="stylesheet" href="{{ asset(env("css")."style.css") }}">
    <link rel="stylesheet" href="{{ asset(env("css")."ticket.css") }}">
    <title>Ticket</title>
</head>
<body>
    <header>
        <div class="image-container">
            <img src="{{ asset(env("site_images")."logo.jpg") }}" alt="Logo">
        </div>
        <h1>Recibo de venta</h1>
    </header>
    <section id="StoreInfo">
        <div class="first">
            <span class="info first">Diag 73 Esq 48 N° 2015</span>
            <span class="info second">La Plata, Bs As, Argentina</span>
            <span class="info third"><span class="bold">Fecha:</span> {{ $date }}</span>
        </div>
        <div class="second">
            <span class="info first">221 679-3097</span>
            <span class="info second">info@drfeelgoodgrowshop.com</span>
            <span class="info third">N° Venta: {{ add_left_zeros($sale->id, 8) }}</span>
        </div>
    </section>
    <section id="Resumen">
        <div class="container">
            <table>
                    <tr>
                        <td class="table-header">Código</td>
                        <td class="table-header">Producto</td>
                        <td class="table-header">Valor unitario</td>
                        <td class="table-header">Cantidad</td>
                        <td class="table-header">Valor total</td>
                    </tr>
                    @foreach ($sale->solds as $sold)
                    <tr>
                        <td>{{ $sold->productinfo->code }}</td>
                        <td>{{ $sold->productinfo->name }}</td>
                        <td>{{ parse_money($sold->productinfo->public_price) }} ARS</td>
                        <td>{{ $sold->quantity }}</td>
                        <td>{{ parse_money($sold->payed) }} ARS</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" class="no-border title">Subtotal:</td>
                        <td class="no-border">{{ parse_money($sale->subtotal) }} ARS</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="no-border title">Descuento:</td>
                        <td class="no-border">{{ parse_money($disccount) }} ARS ({{ $sale->disccount }}%)</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="no-border title">Total:</td>
                        <td class="no-border price">{{ parse_money($sale->total) }} ARS</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="no-border title">Método de pago:</td>
                        <td class="no-border">{{ $sale->payment_method == 1 ? "Efectivo" : "Tarjeta" }}</td>
                    </tr>
            </table>
        </div>
        <div id="NoValid">
            <span>Documento no válido como factura</span>
        </div>
    </section>
</body>
</html>