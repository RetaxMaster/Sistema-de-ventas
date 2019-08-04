@extends('template/template')

@section('style')
<link rel="stylesheet" href="{{ asset(env("css")."ventas.css") }}">
<link rel="stylesheet" href="{{ asset(env("css")."queries-ventas.css") }}">
@endsection

@section("title", "Ventas")

@section('scripts')
<script src="{{ asset(env("js")."output/ventas.bundle.js") }}"></script>    
@endsection

@section('content')    
<div class="modal" id="modal">
    <div class="modal-main">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-1 close-modal"></div>
            <div class="col-lg-6 col-md-6 col-sm-10 col-xs-12 close-modal">
                <div class="modal-card" id="loading">
                    <div class="preloader"></div>
                    <span class="tag">Cargando...</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-1 close-modal"></div>
        </div>
    </div>
</div>
<div class="content" id="Ventas">
    <div>
        <section class="card" id="Search">
            <h2><i class="fas fa-search"></i> Buscar producto</h2>
            <form action="#">
                <div class="form-group">
                    <input type="text" class="form-control" id="SearchProduct" placeholder="Escribe tu búsqueda">
                </div>
            </form>
        </section>
        <section class="card" id="ShoppingCart">
            <h2><i class="fas fa-shopping-cart"></i> Carrito</h2>
            <div class="total">
                <span>Total:</span>
                <span class="price">$<span id="Total">0.00</span> ARS</span>
            </div>
            <div class="resumen">
                <h3>Resumen</h3>
                <div class="resumen-container">
                    <div class="no-products">
                        <span>Aún no has agregado productos al carrito</span>
                    </div>                   
                </div>
            </div>                              
            <form action="#" method="post" id="sellForm">
                <div class="payment-method">
                    <h3>Método de pago</h3>
                    <div class="radio-container">
                        <input type="radio" name="payment-method" id="Efectivo" value="1">
                        <label for="Efectivo">Efectivo</label>
                        <input type="radio" name="payment-method" id="Card" value="2">
                        <label for="Card">Tarjetas</label>
                    </div>                
                </div>
                <div class="calculator">
                    <div class="form-group">
                        <label for="Payed">Cantidad pagada:</label>
                        <input type="text" class="form-control" id="Payed" placeholder="¿Cuánto pagó el cliente?">
                    </div>
                    <div class="form-group">
                        <label for="Disccount">Descuento:</label>
                        <input type="number" min="1" max="100" class="form-control" id="Disccount" placeholder="Un número del 1 al 100">
                    </div>
                    <div class="vuelto">
                        <span>Vuelto: </span>
                        <span class="price">$<span id="Vuelto">0.00</span> ARS</span>
                    </div>
                </div>
                <div class="button-container">
                    <button class="btn alternative btn-success" id="sell" type="button">Vender</button>
                </div>
            </form>
        </section>
    </div>
    <div id="AllProducts">
        <section class="card">
            @forelse ($products as $product)
                <article class="product" data-id="p{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->public_price }}">
                    <div class="image-container">
                        <img src="{{ $product->image }}" alt="Imagen del producto">
                    </div>
                    <div class="data">
                        <h4>{{ $product->name }}</h4>
                        <div class="description">
                            <p>{{ $product->description }}</p>
                        </div>
                    </div>
                    <div class="actions">
                        @if ($product->stock > 0)
                        <span class="price">{{ parse_money($product->public_price) }} ARS</span>
                        <div class="button-container">
                            <button class="btn btn-success">Agregar al carrito</button>
                        </div>
                        @else
                        <div class="out-of-stock">
                            Agotado
                        </div>    
                        @endif
                    </div>
                </article>
            @empty
            <article class="no-products">
                No se encontraron productos
            </article>
            @endforelse
        </section>
    </div>
</div>
@endsection