@extends('template/template')

@section('style')
<link rel="stylesheet" href="{{ asset(env("css")."vendidos.css") }}">
@endsection

@section("title", "Vendidos");

@section('content')
<div class="content" id="Vendidos">
    <h1>Productos vendidos</h1>
    <section class="card" id="AllProducts">
        <div class="search">
            <input type="text" id="Product" class="form-control" placeholder="Escribe el producto que deseas buscar">
        </div>
        <div class="all-products">
            <article class="product">
                <div class="image-container">
                    <img src="https://lh3.googleusercontent.com/bFbUtXL3sEjlxfrWhTaDEN-CuBONeM5x2YpJ2DCQ64rY-vrEOckeW6v7mJ-XLXFLw7wZDV8=s85" alt="Imagen del producto">
                </div>
                <div class="contenido">
                    <div class="data">
                        <h4>Nombre del producto</h4>
                        <div class="description">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione doloremque temporibus saepe, harum corrupti sapiente qui quisquam adipisci sint, cumque quos, aliquam cum? Temporibus quia nulla nobis fugiat? Repudiandae, laborum! Lore</p>
                        </div>
                        <div class="payed">
                            <span>Importe pagado: </span>
                            <span class="price">$30.00 USD</span>
                        </div>
                    </div>
                    <div class="actions">
                        <div class="selled-by">
                            <span>Vendido por:</span><br>
                            <span>Nombre de usuario</span>
                        </div>
                        <div class="quantity">
                            <span>Cantidad:</span><br>
                            <span>5</span>
                        </div>
                    </div>
                </div>
            </article>
            <article class="product">
                <div class="image-container">
                    <img src="https://lh3.googleusercontent.com/bFbUtXL3sEjlxfrWhTaDEN-CuBONeM5x2YpJ2DCQ64rY-vrEOckeW6v7mJ-XLXFLw7wZDV8=s85" alt="Imagen del producto">
                </div>
                <div class="contenido">
                    <div class="data">
                        <h4>Nombre del producto</h4>
                        <div class="description">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione doloremque temporibus saepe, harum corrupti sapiente qui quisquam adipisci sint, cumque quos, aliquam cum? Temporibus quia nulla nobis fugiat? Repudiandae, laborum! Lore</p>
                        </div>
                        <div class="payed">
                            <span>Importe pagado: </span>
                            <span class="price">$30.00 USD</span>
                        </div>
                    </div>
                    <div class="actions">
                        <div class="selled-by">
                            <span>Vendido por:</span><br>
                            <span>Nombre de usuario</span>
                        </div>
                        <div class="quantity">
                            <span>Cantidad:</span><br>
                            <span>5</span>
                        </div>
                    </div>
                </div>
            </article>
            <article class="product">
                <div class="image-container">
                    <img src="https://lh3.googleusercontent.com/bFbUtXL3sEjlxfrWhTaDEN-CuBONeM5x2YpJ2DCQ64rY-vrEOckeW6v7mJ-XLXFLw7wZDV8=s85" alt="Imagen del producto">
                </div>
                <div class="contenido">
                    <div class="data">
                        <h4>Nombre del producto</h4>
                        <div class="description">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione doloremque temporibus saepe, harum corrupti sapiente qui quisquam adipisci sint, cumque quos, aliquam cum? Temporibus quia nulla nobis fugiat? Repudiandae, laborum! Lore</p>
                        </div>
                        <div class="payed">
                            <span>Importe pagado: </span>
                            <span class="price">$30.00 USD</span>
                        </div>
                    </div>
                    <div class="actions">
                        <div class="selled-by">
                            <span>Vendido por:</span><br>
                            <span>Nombre de usuario</span>
                        </div>
                        <div class="quantity">
                            <span>Cantidad:</span><br>
                            <span>5</span>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>
    <nav>
        <ul class="pagination">
            <li class="page-item disabled">
                <a class="page-link" href="#">&laquo;</a>
            </li>
            <li class="page-item active">
                <a class="page-link" href="#">1</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">2</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">3</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">4</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">5</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">&raquo;</a>
            </li>
        </ul>
    </nav>
</div>
@endsection