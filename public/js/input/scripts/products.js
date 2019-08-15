import events from "../functions/events";
import FJ from "../functions/FamilyJewels";
import f from "../functions/functions";
import swal from 'sweetalert';
import m from "../functions/modal";
import { generalScripts } from "./scripts";

const { eventAll, eventOne, event } = events;

document.addEventListener("DOMContentLoaded", () => {

    generalScripts();

    // Carga la previsualización

    const createPreview = (file, parent) => {
        const imgCodified = URL.createObjectURL(file);

        const img = f.createHTMLNode(`
            <div class="image-container">
                <img src="${imgCodified}" alt="Imagen del producto">
            </div>
        `);

        parent.append(img);
    }
    
    eventAll("change", document, "#new-picture, #edit-picture", _this => {
        
        const imageContainer = _this.parentNode.parentNode;
        console.log(imageContainer);
        
        FJ(imageContainer).children(".add-picture").get(0).classList.add("hidden");
        createPreview(_this.files[0], imageContainer);

    });
    
    // -> Carga la previsualización

    // Elimina la previsualización
    
    eventAll("click", document, ".image-container .image-container", preview => {

        const isEdit = preview.parentNode.parentNode.parentNode.id != "Image";
        const input = isEdit ? "edit-picture" : "new-picture";
        FJ(preview).parent().children(".add-picture").get(0).classList.remove("hidden");
        f.remove(preview);
        document.querySelector(`#${input}`).value = "";

    }, true);
    
    // -> Elimina la previsualización

    // Agrega un proveedor
    
    event("click", "#add-provider, #add-category", async function () {
        
        const provider = FJ(this).parent().parent().children("input", true).get(0);
        const providerName = provider.value;

        if (providerName != "") {
            m.loading(true, "Agregando");
    
            const data = {
                mode: this.id == "add-provider" ? "AddProviders" : "AddCategories",
                name: providerName
            }
    
            const response = await f.ajax(ajaxRequests, "post", data, "post");
    
            m.loading(false);

            if (response.status == "true") {
                const container = this.id == "add-provider" ? "AllProviders" : "AllCategories";
                const allProviders = document.querySelector(`#${container} .scroll-container`);
                const id = this.id == "add-provider" ? `p-${response.id}` : `c-${response.id}`;
        
                provider.value = "";
        
                //Creo el proveedor o categoría
                const newProvider = f.createHTMLNode(`
                    <div class="item" id="${id}">
                        <span>${providerName}</span>
                        <div class="icons">
                            <span class="edit"><i class="fas fa-pencil-alt"></i></span>
                            <span class="delete"><i class="fas fa-times"></i></span>
                        </div>
                    </div>
                `);
        
                const providersLength = FJ(allProviders).children(".item").elements.length;
        
                if (providersLength > 0) {
                    allProviders.insertBefore(newProvider, allProviders.children[0]);
                }
                else {
                    f.remove(allProviders.children[0]);
                    allProviders.append(newProvider);
                }
        
                //Los inserto en los select
        
                const option = f.createHTMLNode(`<option value="1">${providerName}</option>`);
                const edit = f.createHTMLNode(`<option value="1">${providerName}</option>`);;
        
                if (container == "AllProviders") {
                    document.querySelector("#Provider").append(option);
                    document.querySelector("#editProviderField").append(edit);
                }
                else {
                    document.querySelector("#Categoria").append(option);
                    document.querySelector("#editCategoriaField").append(edit);
                }
            }
            else {
                swal("Error", response.message, "error");
            }
    
            
        }
        else {
            provider.classList.add("is-invalid");
        }


    }, true);
    
    // -> Agrega un proveedor o categoría

    // Inserta un nodo de producto
    
    const insertProduct = (name, description, image, id) => {
        const newElement = f.createHTMLNode(`
                    <article class="product" id="pr-${id}">
                        <div class="image-container">
                            <img src="${uploaded_images}${image}" alt="Imagen del producto">
                        </div>
                        <div class="data">
                            <h4>${name}</h4>
                            <div class="description">
                                <p>${description}</p>
                            </div>
                        </div>
                        <div class="actions">
                            <span class="edit"><i class="fas fa-pencil-alt"></i></span>
                            <span class="delete"><i class="fas fa-times"></i></span>
                        </div>
                    </article>
                `);

        const allProducts = document.querySelector("#AllProducts .all-products");
        const products = FJ(allProducts).children(".product").elements.length;

        if (products > 0) {
            allProducts.insertBefore(newElement, allProducts.children[0]);
        }
        else {
            f.remove(allProducts.children[0]);
            allProducts.append(newElement);
        }
    }
    
    // -> Inserta un nodo de producto

    const getProductList = async query => {
        const data = {
            mode: "getProductList",
            query: query
        }

        const response = await f.ajax(ajaxRequests, "post", data, "json");
        //Eliminamos los elementos que estéhn
        f.remove("#AllProducts .all-products > .product");

        //Los insertamos
        response.query.forEach(product => {
            insertProduct(product.name, product.description, product.image, product.id);
        });
    }

    // Busca productos
    
    const searchProduct = document.querySelector("#Product");
    eventOne("keyup", searchProduct, function() {
        
        getProductList(this.value);

    }, true);
    
    // -> Busca productos

    // Abre el modal para editar un proveedor o una categoría
    
    eventAll("click", "#AllCategories .scroll-container, #AllProviders .scroll-container", ".item .edit", element => {
        
        const isProvider = element.parentNode.parentNode.parentNode.parentNode.id == "AllProviders";
        const id = element.parentNode.parentNode.id;
        const modal = isProvider ? "editProvider" : "editCategory";
        m.showModal(modal);
        document.querySelector(`#${modal}`).dataset.id = id;

    });
    
    // -> Abre el modal para editar un proveedor o una categoría

    // Edita un proveedor
    
    const editProvider = document.querySelector("#EditProviderButton");
    eventOne("click", editProvider, function() {
        const newName = document.querySelector("#newProviderName");

        if (newName.value != "") {
            const id = this.parentNode.parentNode.dataset.id;

            m.closeModal();

            setTimeout(async () => {
                
                m.loading(true, "Editando");
    
                const data = {
                    mode: "editProvider",
                    id: id,
                    name: newName.value
                }
    
                const response = await f.ajax(ajaxRequests, "post", data, "json");
    
                m.loading(false);
    
                if (response.status == "true") {
                    FJ(`#${id}`).children("span").get(0).textContent = newName.value;
                    newName.classList.remove("is-invalid");
                    newName.value = "";
                }
                else {
                    swal("Error", response.message, "error");
                }

            }, 300);

        }
        else {
            newName.classList.add("is-invalid");
        }

    }, true);
    
    // -> Edita un proveedor

    // Edita una categoría
    
    const editCategory = document.querySelector("#EditCategoryButton");
    eventOne("click", editCategory, function () {
        const newName = document.querySelector("#newCategoryName");

        if (newName.value != "") {
            const id = this.parentNode.parentNode.dataset.id;

            m.closeModal();

            setTimeout(async () => {
                
                m.loading(true, "Editando");
    
                const data = {
                    mode: "editCategory",
                    id: id,
                    name: newName.value
                }
    
                const response = await f.ajax(ajaxRequests, "post", data, "json");
    
                m.loading(false);
    
                if (response.status == "true") {
                    FJ(`#${id}`).children("span").get(0).textContent = newName.value;
                    newName.classList.remove("is-invalid");
                    newName.value = "";
                }
                else {
                    swal("Error", response.message, "error");
                }

            }, 300);

        }
        else {
            newName.classList.add("is-invalid");
        }

    }, true);
    
    // -> Edita una categoría

    // Elimina un proveedor o una categoría

    eventAll("click", "#AllCategories .scroll-container, #AllProviders .scroll-container", ".item .delete", element => {

        const isProvider = element.parentNode.parentNode.parentNode.parentNode.id == "AllProviders";
        const text = isProvider ? "proveedores" : "categorías";
        const text2 = isProvider ? "este proveedor" : "esta categoría";

        swal({
            title: "¿Estás seguro?",
            text: `También se eliminarán todos los productos y registros de ventas asociados a ${text2}`,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then(async (willDelete) => {
            if (willDelete) {

                m.loading(true, "Eliminando");

                const data = {
                    mode: isProvider ? "deleteProvider" : "deleteCategory",
                    id: element.parentNode.parentNode.id
                }

                const response = await f.ajax(ajaxRequests, "post", data, "json");

                m.loading(false);

                if (response.status == "true") {    
                    const parent = element.parentNode.parentNode.parentNode;
                    f.remove(element.parentNode.parentNode);

                    getProductList("");
                    
                    if (parent.children.length == 0) {
                        const noChilds = f.createHTMLNode(`
                            <div class="no-items">
                                <span>No hay ${text}</span>
                            </div>
                        `);
            
                        parent.append(noChilds);
                    }
                }
                else {
                    swal("Error", response.message, "error");
                }
            }
        });

    });

    // ->Elimina un proveedor o una categoría

    // Abre el modal para editar un producto
    
    eventAll("click", "#AllProducts .all-products", ".product .edit", element => {

        const id = element.parentNode.parentNode.id;
        document.querySelector("#editProduct").dataset.id = id;
        m.showModal("editProduct");

    });
    
    // -> Abre el modal para editar un producto

    // Elimina un producto

    eventAll("click", "#AllProducts .all-products", ".product .delete", element => {

        swal({
            title: "¿Estás seguro?",
            text: "Esto eliminará todo el stock y el registro de las ventas asociadas a este producto",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {

                //Confirmá eliminación

                m.loading(true, "Eliminando");

                const id = element.parentNode.parentNode.id;

                const data = {
                    mode: "deleteProduct",
                    id: id
                }

                const response = f.ajax(ajaxRequests, "post", data, "json");

                m.loading(false);

                if (response.status = "true") {
                    const parent = element.parentNode.parentNode.parentNode;
                    f.remove(element.parentNode.parentNode);
    
                    if (parent.children.length == 0) {
                        const noChilds = f.createHTMLNode(`
                            <article class="no-products">
                                Aún no hay artículos
                            </article>
                        `);
    
                        parent.append(noChilds);
                    }
                }
                else{
                    swal("Error", response.message, "error");
                }

            }
        });

    });

    // -> Elimina un producto

    // Añade un producto
    
    const addProduct = document.querySelector("#add-product");
    eventOne("click", addProduct, async function() {
        
        
        const allFields = document.querySelectorAll(".product-data.required");
        if (f.validateInputs(allFields)) {

            m.loading(true, "Subiendo la información");
            
            //Obtengo y filtro los campos que tienen valor
            let fields = Array.from(document.querySelectorAll(".product-data"));
            fields = fields.filter(node => node.value != "" && node.value != "0");

            //Preparo el formData para enviar los datos
            const formData = new FormData();
            formData.append("mode", "addProduct");
            fields.forEach(input => {
                if (input.type != "file") {
                    formData.append(input.name, input.value);
                }
                else {
                    formData.append(input.name, input.files[0]);
                }
            });

            const response = await f.ajax(ajaxRequests, "post", formData, "json", false, false);

            m.loading(false);

            if (response.status == "true") {
                //Lo insertamos a la lista de productos
                const name = response.name;
                const description = response.description;
                const image = response.image;
                const id = "pr-" + response.id;
    
                insertProduct(name, description, image, id);
    
                swal("Listo", "Producto insertado correctamente", "success");
    
                //Reseteamos el formulario
                document.querySelectorAll(".product-data").forEach(input => {
                    input.value = "";
                    input.selectedIndex = "0";
                });
    
                const preview = document.querySelector("#Image .image-container .image-container");
                FJ(preview).parent().children(".add-picture").get(0).classList.remove("hidden");
                f.remove(preview);
            }
            else {
                swal("Error", response.message, "error");
            }
            
        }

    }, true);
    
    // -> Añade un producto

    // Edita un producto
    
    const editProduct = document.querySelector("#editProduct form");
    eventOne("submit", editProduct, function (e) {

        e.preventDefault();

        const id = this.parentNode.dataset.id;

        //Obtengo y filtro los campos que tienen valor
        let fields = Array.from(this.querySelectorAll("input, textarea, select"));
        fields = fields.filter(node => node.value != "" && node.value != "0");

        if (fields.length > 0) {
            //Preparo el formData para enviar los datos
            const formData = new FormData();
            formData.append("mode", "editProduct");
            formData.append("id", id);
            fields.forEach(input => {
                if (input.type != "file") {
                    formData.append(input.name, input.value);
                } else {
                    formData.append(input.name, input.files[0]);
                }
            });

            m.closeModal();
            setTimeout(async () => {
                m.loading(true, "Guardando cambios");
    
                const response = await f.ajax(ajaxRequests, "post", formData, "json", false, false);

                m.loading(false);
    
                if (response.status == "true") {
                    //Lo insertamos a la lista de productos
            
                    const product = document.querySelector(`#${id}`);
                    
                    if(response.name)
                        FJ(product).children("h4", true).get(0).textContent = response.name;
                        
                    if (response.description)
                        FJ(product).children(".description", true).get(0).textContent = response.description;

                    if (response.image)
                        FJ(product).children("img", true).get(0).src = uploaded_images + response.image;
                    
                    if (response.warning) {
                        swal("Todo bien pero...", response.warning, "warning");                        
                    }
                    else {
                        swal("Listo", "Producto editado correctamente", "success");
                    }
            
                    //Reseteamos el formulario
                    this.reset();
                    const preview = this.querySelector(".image-container .image-container");
                    FJ(preview).parent().children(".add-picture").get(0).classList.remove("hidden");
                    f.remove(preview);
                }
                else {
                    swal("Error", response.message, "error");
                    setTimeout(() => {
                        m.showModal("editProduct");
                    }, 300);
                }
            }, 300);
        }
        else {
            swal("Espera", "No nos has indicado qué debemos editar", "warning");
        }

    }, true);
    
    // -> Edita un producto

});