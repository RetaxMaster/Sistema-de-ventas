@extends('template/template')

@section('style')
<link rel="stylesheet" href="{{ asset(env("css")."products.css") }}">
@endsection

@section("title", "Productos");

@section('content')
<div class="content" id="Productos">
    <h2>Agrega un producto</h2>
    <section class="card" id="Image">
        <h4>Agrega una imagen</h4>
        <div class="image-container">
            <div class="add-picture">
                <label for="new-picture">+</label>
                <input type="file" id="new-picture">
            </div>
        </div>
    </section>
    <section class="card" id="FormSection">
        <form action="#" class="row">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                <label for="Nombre">Nombre:</label>
                <input type="text" class="form-control" id="Nombre" placeholder="Nombre del producto">
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                <label for="Marca">Marca:</label>
                <input type="text" class="form-control" id="Marca" placeholder="Marca del producto">
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                <label for="Categoria">Categoría</label>
                <select class="form-control" id="Categoria">
                    <option value="0" selected>Selecciona una opción:</option>
                </select>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                <label for="PublicPrice">Precio al público:</label>
                <input type="text" class="form-control" id="PublicPrice" placeholder="Ej. 200.00">
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                <label for="MajorPrice">Precio por mayor:</label>
                <input type="text" class="form-control" id="MajorPrice" placeholder="Ej. 200.00">
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                <label for="ProviderPrice">Precio del proveedor:</label>
                <input type="text" class="form-control" id="ProviderPrice" placeholder="Ej. 200.00">
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                <label for="Code">Código:</label>
                <input type="text" class="form-control" id="Code" placeholder="Código del producto">
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                <label for="Provider">Proveedor:</label>
                <select class="form-control" id="Provider">
                    <option value="0" selected>Selecciona una opción:</option>
                </select>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                <label for="SellType">Tipo de venta:</label>
                <select class="form-control" id="SellType">
                    <option value="1" selected>Unidad</option>
                    <option value="2">Peso</option>
                    <option value="3">Metro</option>
                </select>
            </div>
        </form>
    </section>
    <section class="card" id="DescriptionSection">
        <div class="form-group">
            <label for="Description">Descripción del producto:</label>
            <textarea class="form-control" id="Description" placeholder="Describe el producto"></textarea>
        </div>
        <div class="button-container both-sides padding-up-down">
            <div class="stock">
                <label for="Stock">Stock:</label>
                <input type="number" id="Stock" class="form-control">
            </div>
            <button class="btn btn-primary">Añadir</button>
        </div>
    </section>
    <section class="card add-register" id="AddProviders">
        <h3><i class="fas fa-user-tie"></i> Agrega proveedores</h3>
        <div class="form-group">
            <label for="ProviderName">Nombre del proveedor:</label>
            <input type="text" class="form-control" id="ProviderName" placeholder="Nombre del proveedor">
        </div>
        <div class="button-container">
            <button class="btn btn-info">Añadir</button>
        </div>
    </section>
    <section class="card register-container" id="AllProviders">
        <h4>Todos los proveedores</h4>
        <div class="scroll-container">
            <div class="item">
                <span>Proveedor</span>
                <div class="icons">
                    <i class="fas fa-pencil-alt"></i>
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="item">
                <span>Proveedor</span>
                <div class="icons">
                    <i class="fas fa-pencil-alt"></i>
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="item">
                <span>Proveedor</span>
                <div class="icons">
                    <i class="fas fa-pencil-alt"></i>
                    <i class="fas fa-times"></i>
                </div>
            </div>
        </div>
    </section>
    <section class="card add-register" id="AddCategories">
        <h3><i class="fas fa-list"></i> Agrega categorías</h3>
        <div class="form-group">
            <label for="CategoryName">Nombre de la categoría:</label>
            <input type="text" class="form-control" id="CategoryName" placeholder="Nombre de la categoría">
        </div>
        <div class="button-container">
            <button class="btn btn-info">Añadir</button>
        </div>
    </section>
    <section class="card register-container" id="AllCategories">
        <h4>Todas las categorías</h4>
        <div class="scroll-container">
            <div class="item">
                <span>Categoría</span>
                <div class="icons">
                    <i class="fas fa-pencil-alt"></i>
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="item">
                <span>Categoría</span>
                <div class="icons">
                    <i class="fas fa-pencil-alt"></i>
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="item">
                <span>Categoría</span>
                <div class="icons">
                    <i class="fas fa-pencil-alt"></i>
                    <i class="fas fa-times"></i>
                </div>
            </div>
        </div>
    </section>
    <h2>Busca productos</h2>
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
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione doloremque temporibus saepe, harum corrupti sapiente qui quisquam adipisci sint, cumque quos, aliquam cum? Temporibus quia nulla nobis fugiat? Repudiandae, laborum!</p>
                        </div>
                    </div>
                    <div class="actions">
                        <i class="fas fa-pencil-alt"></i>
                        <i class="fas fa-times"></i>
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
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione doloremque temporibus saepe, harum corrupti sapiente qui quisquam adipisci sint, cumque quos, aliquam cum? Temporibus quia nulla nobis fugiat? Repudiandae, laborum!</p>
                        </div>
                    </div>
                    <div class="actions">
                        <i class="fas fa-pencil-alt"></i>
                        <i class="fas fa-times"></i>
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
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione doloremque temporibus saepe, harum corrupti sapiente qui quisquam adipisci sint, cumque quos, aliquam cum? Temporibus quia nulla nobis fugiat? Repudiandae, laborum!</p>
                        </div>
                    </div>
                    <div class="actions">
                        <i class="fas fa-pencil-alt"></i>
                        <i class="fas fa-times"></i>
                    </div>
                </div>
            </article>
        </div>
    </section>
</div>
@endsection