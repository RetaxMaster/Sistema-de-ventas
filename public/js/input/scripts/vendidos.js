import events from "../functions/events";
import FJ from "../functions/FamilyJewels";
import f from "../functions/functions";
import swal from 'sweetalert';
import m from "../functions/modal";
import { generalScripts } from "./scripts";

const { eventAll, eventOne, event } = events;

document.addEventListener("DOMContentLoaded", () => {

    generalScripts();

    // Inserta un nodo de producto
    
    const insertProduct = (product) => {
        const newElement = f.createHTMLNode(`
                    <article class="product" id="${product.id}">
                        <div class="image-container">
                            <img src="${uploaded_images}${product.image}" alt="Imagen del producto">
                        </div>
                        <div class="data">
                            <h4>${product.name}</h4>
                            <div class="description">
                                <p>${product.description}</p>
                            </div>
                            <div class="payed">
                                <span>Importe pagado: </span>
                                <span class="price">$${product.price} ARS</span>
                            </div>
                        </div>
                        <div class="actions">
                            <div class="selled-by">
                                <span>Vendido por:</span><br>
                                <span>${product.username}</span>
                            </div>
                            <div class="quantity">
                                <span>Cantidad:</span><br>
                                <span>${product.quantity}</span>
                            </div>
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
    let search = true;
    eventOne("keyup", searchProduct, function () {
        
        if (search) {
            search = false;     
            setTimeout(async () => {
                const data = {
                    mode: "searchSold",
                    query: this.value
                }
        
                const response = await f.ajax(ajaxRequests, "post", data, "json");
                console.log(response);
                
                f.remove("#AllProducts .all-products article");
        
                response.query.forEach(product => {
                    insertProduct(product);
                });

                search = true;
            }, 1500);
        }

    }, true);

    // -> Busca productos

});