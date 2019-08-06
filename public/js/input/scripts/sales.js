import events from "../functions/events";
import FJ from "../functions/FamilyJewels";
import f from "../functions/functions";
import swal from 'sweetalert';
import m from "../functions/modal";
import { generalScripts } from "./scripts";

const { eventAll, eventOne, event } = events;

document.addEventListener("DOMContentLoaded", () => {

    generalScripts();

    // Elimina un producto
    eventAll("click", ".products.wrapped", ".product", async product => {
        const id = product.id;

        const willDelete = await swal({
            title: "¿Estás seguro?",
            text: "Eliminaremos el registro de la venta de ente producto",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        });

        if (willDelete) {
            m.loading(true, "Eliminando");

            const data = {
                mode: "deleteSold",
                id: id,
                idSale: document.querySelector(".delete-sale").id
            }

            const response = await f.ajax(ajaxRequests, "post", data, "json");
            
            m.loading(false);

            if (response.status == "true") {
                f.remove(product);
                document.querySelector("#Total").textContent = f.parseMoney(response.newTotal);
                swal("Eliminado", "El producto fue eliminado con éxito", "success");
            }
            else {
                swal("Error", response.message, "error");
            }
            
        }

    });

    // Busca un producto
    
    const insertProduct = (name, description, image, price, id, stock) => {
        const actions = stock > 0 ? `   
            <span class="price">${f.parseMoney(price)} ARS</span>
            <input type="number" class="form-control quantity" placeholder="Cantidad" value="1">
            <div class="button-container">
                <button class="btn btn-success">Vender</button>
            </div>
        ` : `
            <div class="out-of-stock">
                Agotado
            </div>  
        `;
        const newElement = f.createHTMLNode(`
            
            <article class="product" data-id="${id}" data-name="${name}" data-price="${price}">
                <div class="image-container">
                    <img src="${uploaded_images}${image}" alt="Imagen del producto">
                </div>
                <div class="data">
                    <a href="${product_route}${id}">
                        <h4>${name}</h4>
                        <div class="description">
                            <p>${description}</p>
                        </div>
                    </a>
                </div>
                <div class="actions">
                    ${actions}
                </div>
            </article>
            
        `);

        const allProducts = document.querySelector("#AllProducts .products");
        const products = FJ(allProducts).children(".product").elements.length;

        if (products > 0) {
            allProducts.insertBefore(newElement, allProducts.children[0]);
        }
        else {
            f.remove(allProducts.children[0]);
            allProducts.append(newElement);
        }
    }
    
    const searchProduct = document.querySelector("#Query");
    eventOne("keyup", searchProduct, async function () {

        const data = {
            mode: "getProductList",
            query: this.value
        }

        const response = await f.ajax(ajaxRequests, "post", data, "json");
        
        //Eliminamos los elementos que estén
        f.remove("#AllProducts .products > article");

        //Los insertamos
        response.query.forEach(product => {
            insertProduct(product.name, product.description, product.image, product.public_price, product.id, product.stock);      
        });

    }, true);

    // Agrega un producto al carrito
    
    eventAll("click", "#AllProducts .products", "article button", async button => {

        const quantity = FJ(button).parent().parent().children(".quantity").get(0).value;
        const parent = button.parentNode.parentNode.parentNode;
        const productId = parent.dataset.id;
        const stock = parseInt(parent.dataset.stock);
        

        if (quantity != "") {
            if (quantity <= stock) {
                m.loading(true, "Añadiendo")
    
                const data = {
                    mode: "addProductSold",
                    productId: productId,
                    quantity: quantity,
                    saleId: document.querySelector(".delete-sale").id
                }
    
                const response = await f.ajax(ajaxRequests, "post", data, "json");
    
                m.loading(false);
    
                if (response.status == "true") {
    
                    const parentSolds = document.querySelector(".products.wrapped");
                    
                    const sold = f.createHTMLNode(`
                        <article class="product" id="p${response.id}">
                            <div class="image-container">
                                <img src="${uploaded_images}${response.image}" alt="Imagen del producto">
                            </div>
                            <div class="data">
                                <h4>${response.name}</h4>
                                <div class="description">
                                    <p>${response.description}</p>
                                </div>
                                <div class="payed">
                                    <span>Importe pagado: </span>
                                    <span class="price">${f.parseMoney(response.payed)} ARS</span>
                                </div>
                            </div>
                            <div class="actions">
                                <div class="quantity">
                                    <span>Cantidad:</span><br>
                                    <span>${response.quantity}</span>
                                </div>
                            </div>
                        </article>
                    `);
    
                    parentSolds.insertBefore(sold, parentSolds.children[0]);

                    const newStock = stock - quantity;
                    parent.dataset.stock = newStock;

                    //Fuera de stock
                    if (newStock == 0) {
                        const actions = button.parentNode.parentNode;
                        const outOfStock = f.createHTMLNode(`
                            <div class="out-of-stock">
                                Agotado
                            </div>  
                        `);

                        f.remove(FJ(actions).children(".price").get(0));
                        f.remove(FJ(actions).children(".quantity").get(0));
                        f.remove(FJ(actions).children(".button-container").get(0));
                        actions.append(outOfStock);
                    }

                    //Actualizo el precio
                    document.querySelector("#Total").textContent = f.parseMoney(response.newTotal);
    
                    swal("Vendido", "El producto ha sido vendido con éxito", "success");
    
                }
                else {
                    swal("Error", response.message, "error");
                }
            }
            else {
                swal("Fuera de stock", `No hay suficientes productos, solo quedan ${stock} disponibles.`, "error");
            }
        }
        else {
            swal("¡Un momento!", "Especifica una cantidad a vender", "warning");
        }

    });
    
    // -> Agrega un producto al carrito

    // Elimina la venta entera
    
    const deleteButton = document.querySelector(".delete-sale");
    eventOne("click", deleteButton, async function() {

        const willDelete = await swal({
            title: "¿Estás seguro?",
            text: "Se eliminará esta venta y el dinero generado con ella será extraido de la caja",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        });

        if (willDelete) {

            const id = this.id;
    
            m.loading(true, "Eliminando");
    
            const data = {
                mode: "deleteSale",
                id: id
            }

            const response = await f.ajax(ajaxRequests, "post", data, "json");
            console.log(response);
            

            if (response.status == "true") {
                document.location.href = route("vendidos", 1).url()
            }
            else {
                swal("Error", response.message, "error");
            }

        }
        


    }, true);
    
    // -> Elimina la venta entera


});