@extends('template/template')

@section('style')
<link rel="stylesheet" href="{{ asset(env("css")."product.css") }}">
<link rel="stylesheet" href="{{ asset(env("css")."queries-product.css") }}">
@endsection

@section("title", "Producto")

@section('content')
<div class="content" id="Producto">
    <div class="image-container card">
        <img src="{{ $product->image }}" alt="Imagen del artículo">
    </div>
    <main class="card">
        <article>
            <div class="description">
                <h1>{{ $product->name }}</h1>
                <p>{{ $product->description }}</p>
            </div>
            <div class="Info">
                <span class="price">${{ $product->public_price }} ARS</span>
                <span class="stock">{{ $product->stock }} <br> disponibles</span>
            </div>
        </article>
    </main>
    <div>
        <h2>{{ $product->categoryinfo->name }}</h2>
        <section class="card" id="Especificaciones">
            <h3>Especificaciones</h3>
            <div class="specifications-table">
                <article>
                    <div class="header">
                        <span>Código del producto</span>
                    </div>
                    <div class="value">
                        <span>{{ $product->code }}</span>
                    </div>
                </article>
                <article>
                    <div class="header">
                        <span>Marca</span>
                    </div>
                    <div class="value">
                        <span>{{ $product->brand }}</span>
                    </div>
                </article>
                <article>
                    <div class="header">
                        <span>Peso</span>
                    </div>
                    <div class="value">
                        <span>{{ $product->weight }} Kg</span>
                    </div>
                </article>
                <article>
                    <div class="header">
                        <span>Medidas</span>
                    </div>
                    <div class="value">
                        <span>{{ $product->size }}</span>
                    </div>
                </article>
            </div>
            <div class="specifications-table">
                <article>
                    <div class="header">
                        <span>Precio al público</span>
                    </div>
                    <div class="value">
                        <span>{{ $product->public_price }}</span>
                    </div>
                </article>
                <article>
                    <div class="header">
                        <span>Precio al por mayor</span>
                    </div>
                    <div class="value">
                        <span>{{ $product->major_price }}</span>
                    </div>
                </article>
                <article>
                    <div class="header">
                        <span>Precio del proveedor</span>
                    </div>
                    <div class="value">
                        <span>{{ $product->provider_price }} Kg</span>
                    </div>
                </article>
                <article>
                    <div class="header">
                        <span>Proveedor</span>
                    </div>
                    <div class="value">
                        @if ($product->provider != null)
                        <span>{{ $product->providerinfo->name }}</span>
                        @else
                        <span>No especificado</span>
                        @endif
                    </div>
                </article>
            </div>
        </section>
    </div>
</div>
@endsection
