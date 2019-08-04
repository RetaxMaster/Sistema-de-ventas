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
                    <form action="#" class="row" method="post" enctype="multipart/form-data">
                        <div class="image-container">
                            <div class="add-picture">
                                <label for="edit-picture">+</label>
                                <input type="file" id="edit-picture" name="Picture">
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
                            <label for="editCategoriaField">Categoría</label>
                            <select class="form-control" id="editCategoriaField" name="Categoria">
                                <option value="0" selected>Selecciona una opción</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
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
                            <label for="editProviderField">Proveedor:</label>
                            <select class="form-control" id="editProviderField" name="Provider">
                                <option value="0" selected>Sin proveedor</option>
                                @foreach ($providers as $provider)
                                <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 form-group">
                            <label for="editSellType">Tipo de venta:</label>
                            <select class="form-control" id="editSellType" name="SellType">
                                <option value="0" selected>No cambiar</option>
                                <option value="1">Unidad</option>
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
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                            <label for="editWeight">Peso:</label>
                            <input type="number" class="form-control" id="editWeight" placeholder="Peso">
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                            <label for="editSize">Tamaño:</label>
                            <input type="text" class="form-control" id="editSize" placeholder="ancho x alto x profundidad">
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
                <input type="file" id="new-picture" name="Picture" class="product-data required" required>
            </div>
        </div>
    </section>
    <section class="card" id="FormSection">
        <form action="#" class="row">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 form-group">
                <label for="Nombre">Nombre:</label>
                <input type="text" class="form-control product-data required" id="Nombre" name="Nombre" placeholder="Nombre del producto" required>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 form-group">
                <label for="Marca">Marca:</label>
                <input type="text" class="form-control product-data" id="Marca" name="Marca" placeholder="Marca del producto">
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 form-group">
                <label for="Categoria">Categoría</label>
                <select class="form-control product-data required" id="Categoria" name="Categoria" required>
                    <option value="0" selected>Selecciona una opción</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 form-group">
                <label for="PublicPrice">Precio al público:</label>
                <input type="text" class="form-control product-data required" required id="PublicPrice" name="PublicPrice" placeholder="Ej. 200.00">
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 form-group">
                <label for="MajorPrice">Precio por mayor:</label>
                <input type="text" class="form-control product-data" id="MajorPrice" name="MajorPrice" placeholder="Ej. 200.00">
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 form-group">
                <label for="ProviderPrice">Precio del proveedor:</label>
                <input type="text" class="form-control product-data" id="ProviderPrice" name="ProviderPrice" placeholder="Ej. 200.00">
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 form-group">
                <label for="Code">Código:</label>
                <input type="text" class="form-control product-data required" required id="Code" name="Code" placeholder="Código del producto">
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 form-group">
                <label for="Provider">Proveedor:</label>
                <select class="form-control product-data" id="Provider" name="Provider">
                    <option value="0" selected>Sin proveedor</option>
                    @foreach ($providers as $provider)
                    <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 form-group">
                <label for="SellType">Tipo de venta:</label>
                <select class="form-control product-data" id="SellType" name="SellType">
                    <option value="1" selected>Unidad</option>
                    <option value="2">Peso</option>
                    <option value="3">Metro</option>
                </select>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                <label for="Weight">Peso:</label>
                <input type="number" class="form-control product-data" id="Weight" placeholder="Peso" name="Weight">
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                <label for="Size">Tamaño:</label>
                <input type="text" class="form-control product-data" id="Size" name="Size" placeholder="ancho x alto x profundidad">
            </div>
        </form>
    </section>
    <section class="card" id="DescriptionSection">
        <div class="form-group">
            <label for="Description">Descripción del producto:</label>
            <textarea class="form-control product-data required" id="Description" name="Description" placeholder="Describe el producto" required></textarea>
        </div>
        <div class="button-container both-sides padding-up-down">
            <div class="stock">
                <label for="Stock">Stock:</label>
                <input type="number" id="Stock" name="Stock" class="form-control product-data required" required>
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
            @forelse ($providers as $provider)
            <div class="item" id="p-{{ $provider->id }}">
                <span>{{ $provider->name }}</span>
                <div class="icons">
                    <span class="edit"><i class="fas fa-pencil-alt"></i></span>
                    <span class="delete"><i class="fas fa-times"></i></span>
                </div>
            </div>
            @empty
            <div class="no-items">
                <span>No hay proveedores</span>
            </div>
            @endforelse
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
            @forelse ($categories as $category)
            <div class="item" id="c-{{ $category->id }}">
                <span>{{ $category->name }}</span>
                <div class="icons">
                    <span class="edit"><i class="fas fa-pencil-alt"></i></span>
                    <span class="delete"><i class="fas fa-times"></i></span>
                </div>
            </div>
            @empty
            <div class="no-items">
                <span>No hay categorías</span>
            </div>
            @endforelse
        </div>
    </section>
    <h2>Busca productos</h2>
    <section class="card" id="AllProducts">
        <div class="search">
            <input type="text" id="Product" class="form-control" placeholder="Escribe el producto que deseas buscar">
        </div>
        <div class="all-products">
            @forelse ($products as $product)
            <article class="product" id="pr-{{ $product->id }}">
                <div class="image-container">
                    <img src="{{ asset(env("uploaded_images").$product->image) }}">
                </div>
                <div class="data">
                    <h4>{{ $product->name }}</h4>
                    <div class="description">
                        <p>{{ $product->description }}</p>
                    </div>
                </div>
                <div class="actions">
                    <span class="edit"><i class="fas fa-pencil-alt"></i></span>
                    <span class="delete"><i class="fas fa-times"></i></span>
                </div>
            </article>
            @empty
            <article class="no-products">
                Aún no hay artículos
            </article>
            @endforelse
        </div>
    </section>
</div>
@endsection