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
    
    event("click", "#add-provider, #add-category", function () {
        
        const provider = FJ(this).parent().parent().children("input", true).get(0);
        const providerName = provider.value;
        const container = this.id == "add-provider" ? "AllProviders" : "AllCategories";
        const allProviders = document.querySelector(`#${container} .scroll-container`);

        provider.value = "";

        //Creo el proveedor o categoría
        const newProvider = f.createHTMLNode(`
            <div class="item" id="i1">
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

    }, true);
    
    // -> Agrega un proveedor o categoría

    // Inserta un nodo de producto
    
    const insertProduct = (name, description, image, id) => {
        const newElement = f.createHTMLNode(`
                    <article class="product" id="p1">
                        <div class="image-container">
                            <img src="https://lh3.googleusercontent.com/bFbUtXL3sEjlxfrWhTaDEN-CuBONeM5x2YpJ2DCQ64rY-vrEOckeW6v7mJ-XLXFLw7wZDV8=s85" alt="Imagen del producto">
                        </div>
                        <div class="data">
                            <h4>${name}</h4>
                            <div class="description">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione doloremque temporibus saepe, harum corrupti sapiente qui quisquam adipisci sint, cumque quos, aliquam cum? Temporibus quia nulla nobis fugiat? Repudiandae, laborum!</p>
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

    // Busca productos
    
    const searchProduct = document.querySelector("#Product");
    eventOne("keyup", searchProduct, function() {
        
        insertProduct(this.value, null, null, null);

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
            FJ(`#${id}`).children("span").get(0).textContent = newName.value;
            m.closeModal();
            newName.classList.remove("is-invalid");
            newName.value = "";
        }
        else {
            newName.classList.add("is-invalid");
        }

    }, true);
    
    // -> Edita un proveedor

    // Edita un proveedor
    
    const editCategory = document.querySelector("#EditCategoryButton");
    eventOne("click", editCategory, function () {
        const newName = document.querySelector("#newCategoryName");

        if (newName.value != "") {
            const id = this.parentNode.parentNode.dataset.id;
            FJ(`#${id}`).children("span").get(0).textContent = newName.value;
            m.closeModal();
            newName.classList.remove("is-invalid");
            newName.value = "";
        }
        else {
            newName.classList.add("is-invalid");
        }

    }, true);
    
    // -> Edita un proveedor

    // Elimina un proveedor o una categoría

    eventAll("click", "#AllCategories .scroll-container, #AllProviders .scroll-container", ".item .delete", element => {

        const isProvider = element.parentNode.parentNode.parentNode.parentNode.id == "AllProviders";
        const text = isProvider ? "proveedores" : "categorías";
        const parent = element.parentNode.parentNode.parentNode;
        f.remove(element.parentNode.parentNode);
        
        if (parent.children.length == 0) {
            const noChilds = f.createHTMLNode(`
                <div class="no-items">
                    <span>No hay ${text}</span>
                </div>
            `);

            parent.append(noChilds);
        }

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
            text: "Esto eliminará todo el stock de este producto",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {

                //Confirmá eliminación

                const id = element.parentNode.parentNode.id;
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

                swal("¡Se eliminaron los productos con éxito!", {
                    icon: "success",
                });
            }
        });

    });

    // -> Elimina un producto

    // Añade un producto
    
    const addProduct = document.querySelector("#add-product");
    eventOne("click", addProduct, function() {
        
        const allFields = document.querySelectorAll(".product-data.required");
        if (f.validateInputs(allFields)) {
            
            //Lo insertamos a la lista de productos
            const name = document.querySelector("#Nombre").value;
            const description = document.querySelector("#Description").value;
            const image = null;
            const id = null;

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

    }, true);
    
    // -> Añade un producto

    // Edita un producto
    
    const editProduct = document.querySelector("#editProduct form");
    eventOne("submit", editProduct, function (e) {

        e.preventDefault();

        const id = this.parentNode.dataset.id;
            
        //Lo insertamos a la lista de productos
        let name = document.querySelector("#editNombre").value;
        let description = document.querySelector("#editDescription").value;
        const image = null;
        const productId = null;

        const product = document.querySelector(`#${id}`);
        
        if(name != "")
            FJ(product).children("h4", true).get(0).textContent = name;
            
        if (description != "")
            FJ(product).children(".description", true).get(0).textContent = description;

        swal("Listo", "Producto editado correctamente", "success");

        //Reseteamos el formulario
        this.reset();
        const preview = this.querySelector(".image-container .image-container");
        FJ(preview).parent().children(".add-picture").get(0).classList.remove("hidden");
        f.remove(preview);

    }, true);
    
    // -> Edita un producto

});