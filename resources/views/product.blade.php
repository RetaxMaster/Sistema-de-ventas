@extends('template/template')

@section('style')
<link rel="stylesheet" href="{{ asset(env("css")."product.css") }}">
<link rel="stylesheet" href="{{ asset(env("css")."queries-product.css") }}">
@endsection

@section("title", "Producto")

@section('content')
<div class="content" id="Producto">
    <div class="image-container card">
        <img src="https://lh3.googleusercontent.com/bFbUtXL3sEjlxfrWhTaDEN-CuBONeM5x2YpJ2DCQ64rY-vrEOckeW6v7mJ-XLXFLw7wZDV8=s85" alt="Imagen del artículo">
    </div>
    <main class="card">
        <article>
            <div class="description">
                <h1>Nombre del producto</h1>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Suscipit consequuntur nihil, laboriosam eaque natus ratione sapiente quidem architecto? Laudantium adipisci voluptate illo dignissimos ratione quam a, natus praesentium accusamus libero?</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam, rem distinctio mollitia eveniet neque asperiores assumenda, earum illo, tempore tempora delectus ipsum totam. Repudiandae perferendis quam error architecto reprehenderit earum.</p>
            </div>
            <div class="Info">
                <span class="price">$200.00 USD</span>
                <span class="stock">6 <br> disponibles</span>
            </div>
        </article>
    </main>
    <div>
        <h2>Nombre de la categoría</h2>
        <section class="card" id="Especificaciones">
            <h3>Especificaciones</h3>
            <div class="specifications-table">
                <article>
                    <div class="header">
                        <span>Código del producto</span>
                    </div>
                    <div class="value">
                        <span>0010 5719 1384 6871 1265</span>
                    </div>
                </article>
                <article>
                    <div class="header">
                        <span>Marca</span>
                    </div>
                    <div class="value">
                        <span>Ejemplo de una marca</span>
                    </div>
                </article>
                <article>
                    <div class="header">
                        <span>Peso</span>
                    </div>
                    <div class="value">
                        <span>5 Kg</span>
                    </div>
                </article>
                <article>
                    <div class="header">
                        <span>Medidas</span>
                    </div>
                    <div class="value">
                        <span>20cm x 20cm x 30cm</span>
                    </div>
                </article>
            </div>
        </section>
    </div>
</div>
@endsection
