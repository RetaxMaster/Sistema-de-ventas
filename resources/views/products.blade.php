@extends('template/template')

@section('style')
<link rel="stylesheet" href="{{ asset(env("css")."products.css") }}">
<link rel="stylesheet" href="{{ asset(env("css")."queries-products.css") }}">
@endsection

@section("title", "Productos")


@section('scripts')
<script src="{{ asset(env("js")."output/products.bundle.js") }}"></script>    
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
                <div class="modal-card" id="editProvider" data-id="">
                    <div class="form-group">
                        <label for="newProviderName">Nombre del proveedor:</label>
                        <input type="text" class="form-control" id="newProviderName" placeholder="Nombre del proveedor">
                    </div>
                    <div class="button-container">
                        <button class="btn btn-primary" id="EditProviderButton">Editar</button>
                    </div>
                </div>
                <div class="modal-card" id="editCategory" data-id="">
                    <div class="form-group">
                        <label for="newCategoryName">Nombre de la categoría:</label>
                        <input type="text" class="form-control" id="newCategoryName" placeholder="Nombre de la categoría">
                    </div>
                    <div class="button-container">
                        <button class="btn btn-primary" id="EditCategoryButton">Editar</button>
                    </div>
                </div>
                <div class="modal-card" id="editProduct" data-id="">
                    <h2>Edita el producto:</h2>
                    <form action="#" class="row" enctype="multipart/form-data">
                        <div class="image-container">
                            <div class="add-picture">
                                <label for="edit-picture">+</label>
                                <input type="file" id="edit-picture" name="picture">
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 form-group">
                            <label for="editNombre">Nombre:</label>
                            <input type="text" class="form-control" id="editNombre" name="Nombre" placeholder="Nombre del producto">
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 form-group">
                            <label for="editMarca">Marca:</label>
                            <input type="text" class="form-control" id="editMarca" name="Marca" placeholder="Marca del producto">
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 form-group">
                            <label for="editCategoria">Categoría</label>
                            <select class="form-control" id="editCategoria" name="Categoria">
                                <option value="0" selected>Selecciona una opción:</option>
                            </select>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 form-group">
                            <label for="editPublicPrice">Precio al público:</label>
                            <input type="text" class="form-control" id="editPublicPrice" name="PublicPrice" placeholder="Ej. 200.00">
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 form-group">
                            <label for="editMajorPrice">Precio por mayor:</label>
                            <input type="text" class="form-control" id="editMajorPrice" name="MajorPrice" placeholder="Ej. 200.00">
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 form-group">
                            <label for="editProviderPrice">Precio del proveedor:</label>
                            <input type="text" class="form-control" id="editProviderPrice" name="ProviderPrice" placeholder="Ej. 200.00">
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 form-group">
                            <label for="editCode">Código:</label>
                            <input type="text" class="form-control" id="editCode" name="Code" placeholder="Código del producto">
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 form-group">
                            <label for="editProvider">Proveedor:</label>
                            <select class="form-control" id="editProvider" name="Provider">
                                <option value="0" selected>Sin proveedor:</option>
                            </select>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 form-group">
                            <label for="editSellType">Tipo de venta:</label>
                            <select class="form-control" id="editSellType" name="SellType">
                                <option value="1" selected>Unidad</option>
                                <option value="2">Peso</option>
                                <option value="3">Metro</option>
                            </select>
                        </div>
                        <div class="form-group col-12">
                            <label for="editDescription">Descripción del producto:</label>
                            <textarea class="form-control" id="editDescription" placeholder="Describe el producto" name="Description"></textarea>
                        </div>
                        <div class="stock form-group col-12">
                            <label for="editStock">Stock:</label>
                            <input type="number" id="editStock" class="form-control" name="Stock">
                            </div>
                        <div class="button-container padding-up-down">
                            <button type="submit" class="btn btn-primary">Añadir</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-1 close-modal"></div>
        </div>
    </div>
</div>
<div class="content" id="Productos">
    <h2>Agrega un producto</h2>
    <section class="card" id="Image">
        <h4>Agrega una imagen</h4>
        <div class="image-container">
            <div class="add-picture">
                <label for="new-picture">+</label>
                <input type="file" id="new-picture" class="product-data required" required>
            </div>
        </div>
    </section>
    <section class="card" id="FormSection">
        <form action="#" class="row">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 form-group">
                <label for="Nombre">Nombre:</label>
                <input type="text" class="form-control product-data required" id="Nombre" placeholder="Nombre del producto" required>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 form-group">
                <label for="Marca">Marca:</label>
                <input type="text" class="form-control product-data" id="Marca" placeholder="Marca del producto">
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 form-group">
                <label for="Categoria">Categoría</label>
                <select class="form-control product-data required" id="Categoria" required>
                    <option value="0" selected>Selecciona una opción:</option>
                </select>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 form-group">
                <label for="PublicPrice">Precio al público:</label>
                <input type="text" class="form-control product-data required" required id="PublicPrice" placeholder="Ej. 200.00">
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 form-group">
                <label for="MajorPrice">Precio por mayor:</label>
                <input type="text" class="form-control product-data required" required id="MajorPrice" placeholder="Ej. 200.00">
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 form-group">
                <label for="ProviderPrice">Precio del proveedor:</label>
                <input type="text" class="form-control product-data required" required id="ProviderPrice" placeholder="Ej. 200.00">
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 form-group">
                <label for="Code">Código:</label>
                <input type="text" class="form-control product-data required" required id="Code" placeholder="Código del producto">
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 form-group">
                <label for="Provider">Proveedor:</label>
                <select class="form-control product-data" id="Provider">
                    <option value="0" selected>Sin proveedor:</option>
                </select>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 form-group">
                <label for="SellType">Tipo de venta:</label>
                <select class="form-control product-data" id="SellType">
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
            <textarea class="form-control product-data required" id="Description" placeholder="Describe el producto" required></textarea>
        </div>
        <div class="button-container both-sides padding-up-down">
            <div class="stock">
                <label for="Stock">Stock:</label>
                <input type="number" id="Stock" class="form-control product-data required" required>
            </div>
            <button class="btn btn-primary" id="add-product">Añadir</button>
        </div>
    </section>
    <section class="card add-register" id="AddProviders">
        <h3><i class="fas fa-user-tie"></i> Agrega proveedores</h3>
        <div class="form-group">
            <label for="ProviderName">Nombre del proveedor:</label>
            <input type="text" class="form-control" id="ProviderName" placeholder="Nombre del proveedor">
        </div>
        <div class="button-container">
            <button class="btn btn-info" id="add-provider">Añadir</button>
        </div>
    </section>
    <section class="card register-container" id="AllProviders">
        <h4>Todos los proveedores</h4>
        <div class="scroll-container">
            <div class="no-items">
                <span>No hay proveedores</span>
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
            <button class="btn btn-info" id="add-category">Añadir</button>
        </div>
    </section>
    <section class="card register-container" id="AllCategories">
        <h4>Todas las categorías</h4>
        <div class="scroll-container">
            <div class="no-items">
                <span>No hay categorías</span>
            </div>
        </div>
    </section>
    <h2>Busca productos</h2>
    <section class="card" id="AllProducts">
        <div class="search">
            <input type="text" id="Product" class="form-control" placeholder="Escribe el producto que deseas buscar">
        </div>
        <div class="all-products">
                <article class="no-products">
                    Aún no hay artículos
                </article>
            @for ($i = 0; $i < 0; $i++)
                <article class="product">
                    <div class="image-container">
                        <img src="https://lh3.googleusercontent.com/bFbUtXL3sEjlxfrWhTaDEN-CuBONeM5x2YpJ2DCQ64rY-vrEOckeW6v7mJ-XLXFLw7wZDV8=s85" alt="Imagen del producto">
                    </div>
                    <div class="data">
                        <h4>Nombre del producto</h4>
                        <div class="description">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione doloremque temporibus saepe, harum corrupti sapiente qui quisquam adipisci sint, cumque quos, aliquam cum? Temporibus quia nulla nobis fugiat? Repudiandae, laborum!</p>
                        </div>
                    </div>
                    <div class="actions">
                        <span class="edit"><i class="fas fa-pencil-alt"></i></span>
                        <span class="delete"><i class="fas fa-times"></i></span>
                    </div>
                </article>
            @endfor
        </div>
    </section>
</div>
@endsection