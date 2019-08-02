@extends('template/template')

@section('style')
<link rel="stylesheet" href="{{ asset(env("css")."ventas.css") }}">
@endsection

@section("title", "Ventas");

@section('content')    
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
                <span class="price">$20.00 USD</span>
            </div>
            <div class="resumen">
                <h3>Resumen</h3>
                <div class="resumen-container">
                    <div class="product">
                        <span>5 productos</span>
                        <span class="price">$5.00 USD</span>
                    </div>
                    <div class="product">
                        <span>5 productos</span>
                        <span class="price">$5.00 USD</span>
                    </div>
                    <div class="product">
                        <span>5 productos</span>
                        <span class="price">$5.00 USD</span>
                    </div>                      
                </div>
            </div>                              
            <div class="payment-method">
                <h3>Método de pago</h3>
                <div class="radio-container">
                    <input type="radio" name="payment-method" id="Efectivo">
                    <label for="Efectivo">Efectivo</label>
                    <input type="radio" name="payment-method" id="Card">
                    <label for="Card">Tarjetas</label>
                </div>                
            </div>
            <div class="calculator">
                <div class="form-group">
                    <label for="Payed">Cantidad pagada:</label>
                    <input type="text" class="form-control" id="Payed" placeholder="¿Cuánto pagó el cliente?">
                </div>
                <div class="vuelto">
                    <span>Vuelto: </span>
                    <span class="price">$<span id="Vuelto">24.00</span> USD</span>
                </div>
            </div>
            <div class="button-container">
                <button class="btn alternative btn-success">Vender</button>
            </div>
        </section>
    </div>
    <div id="AllProducts">
        <section class="card">
            <article class="product">
                <div class="image-container">
                    <img src="https://lh3.googleusercontent.com/bFbUtXL3sEjlxfrWhTaDEN-CuBONeM5x2YpJ2DCQ64rY-vrEOckeW6v7mJ-XLXFLw7wZDV8=s85" alt="Imagen del producto">
                </div>
                <div class="contenido">
                    <div class="data">
                        <h4>Nombre del producto</h4>
                        <div class="description">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione doloremque temporibus saepe, harum corrupti sapiente qui quisquam adipisci sint, cumque quos, aliquam cum? Temporibus quia nulla nobis fugiat? Repudiandae, laborum! Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro temporibus molestias repellat modi nobis illo! At velit fuga officiis, similique quod nesciunt. Magnam, ab odio minus eaque enim animi. Accusamus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt praesentium consequuntur explicabo, tempora labore quasi et, quam quae quis, animi minus eum fugiat quod corrupti ipsam! Similique eaque suscipit inventore.</p>
                        </div>
                    </div>
                    <div class="actions">
                        <span class="price">$20.00 USD</span>
                        <div class="button-container">
                            <button class="btn btn-success">Agregar al carrito</button>
                        </div>
                    </div>
                </div>
            </article>
        </section>
    </div>
</div>
@endsection