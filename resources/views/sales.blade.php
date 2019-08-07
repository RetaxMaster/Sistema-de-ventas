@extends('template/template')

@section('style')
<link rel="stylesheet" href="{{ asset(env("css")."sales.css") }}">
<link rel="stylesheet" href="{{ asset(env("css")."queries-sales.css") }}">
@endsection

@section("title", "Ventas")

@section('scripts')
<script src="{{ asset(env("js")."output/sales.bundle.js") }}"></script>    
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
<div class="content" id="Sales">
    <h1>Vendido por {{ $sale->userinfo->username }}</h1>
    <section>
        <div class="card">
            <p class="description">{{ $sale->comment }}</p>
            <div class="price-container">
                <span class="price"><span id="Total">{{ parse_money($sale->total) }}</span> ARS</span>
            </div>
            <div class="info">
                <span class="tag">Pagado con:</span>
                <span>{{ ($sale->payment_method == 1) ? "Efectivo" : "Tarjeta" }}</span>
            </div>
            <div class="info">
                <span class="tag">Fecha de venta:</span>
                <span>{{ get_full_date($sale->created_at) }}</span>
            </div><br>
            <div class="button-container">
                <a href="{{ route("ticket", ["sale" => $sale->id]) }}" target="_blank"><button class="btn btn-success">Descargar ticket</button></a>
            </div>
        </div>
    </section>
    <section class="card products wrapped">
        @foreach ($sale->solds->sortByDesc("id") as $sold)
        <article class="product" id="{{ $sold->id }}">
            <div class="image-container">
                <img src="{{ asset(env("uploaded_images").$sold->productinfo->image) }}" alt="Imagen del producto">
            </div>
            <div class="data">
                <h4>{{ $sold->productinfo->name }}</h4>
                <div class="description">
                    <p>{{ $sold->productinfo->description }}</p>
                </div>
                <div class="payed">
                    <span>Importe pagado: </span>
                    <span class="price">{{ parse_money($sold->payed) }} ARS</span>
                </div>
            </div>
            <div class="actions">
                <div class="quantity">
                    <span>Cantidad:</span><br>
                    <span>{{ $sold->quantity }}</span>
                </div>
            </div>
        </article>
        @endforeach
    </section>
    <section class="card" id="AllProducts">
        <div class="search">
            <input type="text" id="Query" class="form-control" placeholder="Busca un producto">
        </div>
        <div class="products">
            @foreach ($products as $product)
                <article class="product" data-id="p{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->public_price }}" data-stock="{{ $product->stock }}">
                    <div class="image-container">
                        <img src="{{ asset(env("uploaded_images").$product->image) }}" alt="Imagen del producto">
                    </div>
                    <div class="data">
                        <a href="{{ route("product", ["product" => $product->id]) }}">
                        <h4>{{ $product->name }}</h4>
                            <div class="description">
                                <p>{{ $product->description }}</p>
                            </div>
                        </a>
                    </div>
                    <div class="actions">
                        @if ($product->stock > 0)
                        <span class="price">{{ parse_money($product->public_price) }} ARS</span>
                        <input type="number" class="form-control quantity" placeholder="Cantidad" value="1">
                        <div class="button-container">
                            <button class="btn btn-success">Vender</button>
                        </div>
                        @else
                        <div class="out-of-stock">
                            Agotado
                        </div>    
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </section>
    <div class="button-container">
        <button class="btn btn-danger delete-sale" id="{{$sale->id}}">Eliminar venta</button>
    </div>
</div>
@endsection