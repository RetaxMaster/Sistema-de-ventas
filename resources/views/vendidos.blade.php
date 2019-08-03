@extends('template/template')

@section('style')
<link rel="stylesheet" href="{{ asset(env("css")."vendidos.css") }}">
<link rel="stylesheet" href="{{ asset(env("css")."queries-vendidos.css") }}">
@endsection

@section("title", "Vendidos")

@section('scripts')
<script src="{{ asset(env("js")."output/vendidos.bundle.js") }}"></script>    
@endsection

@section('content')
<div class="content" id="Vendidos">
    <h1>Productos vendidos</h1>
    <section class="card" id="AllProducts">
        <div class="search">
            <input type="text" id="Product" class="form-control" placeholder="Escribe el producto que deseas buscar">
        </div>
        <div class="all-products">
            @forelse ($solds as $sold)
                <article class="product" id="{{ $sold->id }}">
                    <div class="image-container">
                        <img src="{{ $sold->productinfo->image }}" alt="Imagen del producto">
                    </div>
                    <div class="data">
                        <h4>{{ $sold->productinfo->name }}</h4>
                        <div class="description">
                            <p>{{ $sold->productinfo->description }}</p>
                        </div>
                        <div class="payed">
                            <span>Importe pagado: </span>
                            <span class="price">{{ parse_money($sold->productinfo->public_price * $sold->quantity) }} ARS</span>
                        </div>
                    </div>
                    <div class="actions">
                        <div class="selled-by">
                            <span>Vendido por:</span><br>
                            <span>{{ $sold->userinfo->username }}</span>
                        </div>
                        <div class="quantity">
                            <span>Cantidad:</span><br>
                            <span>{{ $sold->quantity }}</span>
                        </div>
                    </div>
                </article>
            @empty
            <article class="no-products">
                No hay productos vendidos aún
            </article>
            @endforelse
        </div>
    </section>
    <nav>
        <ul class="pagination">
            @if ($prev != null)
            <li class="page-item disabled">
                <a class="page-link" href="#">&laquo;</a>
            </li>
            @endif
            @for ($i = $start_for, $j=0; $i <= $totalPages && $j < 5; $i++, $j++)    
            <li class="page-item {{ ($page == $i) ? "active" : "" }}">
                <a class="page-link" href="{{ route("vendidos", ["page" => $i]) }}">{{ $i }}</a>
            </li>
            @endfor
            @if ($next != null)
            <li class="page-item">
                <a class="page-link" href="#">&raquo;</a>
            </li>
            @endif
        </ul>
    </nav>
</div>
@endsection