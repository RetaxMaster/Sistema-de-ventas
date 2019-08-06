import events from "../functions/events";
import FJ from "../functions/FamilyJewels";
import f from "../functions/functions";
import swal from 'sweetalert';
import m from "../functions/modal";
import { generalScripts } from "./scripts";
import flatpickr from "flatpickr";

const { eventAll, eventOne, event } = events;

document.addEventListener("DOMContentLoaded", () => {

    generalScripts();

    

    const startDate = flatpickr("#StartDate", {
        dateFormat: "d/m/Y",
        onChange: (selectedDates, dateStr, instance) => {
            endDate.set("minDate", dateStr);
            document.querySelector("#EndDate").disabled = false;
            document.querySelector("#EndDate").value = "";
            search();
        }
    });
    
    const endDate = flatpickr("#EndDate", {
        dateFormat: "d/m/Y",
        onChange: () => {
            search();
        }
    });

    //Inserta un nodo de venta

    const insertSale = (sale) => {
        const newElement = f.createHTMLNode(`
                    <article class="sale" id="s${sale.id}">
                        <div class="sect">
                            <h3>${sale.username} vendió:</h3>
                            <span>${sale.quantity} productos</span>
                        </div>
                        <div class="sect">
                            <h3>Fecha:</h3>
                            <span>${f.getShortDateFromTimestamp(sale.timestamp)} a las ${f.getTimeFromTimestamp(sale.timestamp)}</span>
                        </div>
                        <div class="sect">
                            <h3>Importe:</h3>
                            <span class="price">${f.parseMoney(sale.total)} ARS</span>
                        </div>
                    </article>
                `);

        const allProducts = document.querySelector("#AllProducts .all-products");
        const products = FJ(allProducts).children(".sale").elements.length;

        if (products > 0) {
            allProducts.insertBefore(newElement, allProducts.children[0]);
        }
        else {
            f.remove(allProducts.children[0]);
            allProducts.append(newElement);
        }
    }

    //Busca ventas
    const search = async () => {

        const start = document.querySelector("#StartDate")
        const end = document.querySelector("#EndDate")

        if (start.value != "" && end.value != "") {
            m.loading(true, "Buscando");
            const data = {
                mode: "searchSales",
                start: start.value,
                end: end.value
            }

            const response = await f.ajax(ajaxRequests, "post", data, "json");

            console.log(response);

            f.remove("#AllProducts .all-products article");
            if (response.query.length > 0) {
    
                response.query.forEach(product => {
                    insertSale(product);
                });
            }
            else{
                const noSales = f.createHTMLNode(`
                    <article class="no-products">
                        No se encontraron ventas
                    </article>
                `);

                document.querySelector("#AllProducts .all-products").append(noSales);
            }
            m.loading(false);

        }

    }

    // Abre los detalles de la venta
    
    eventAll("click", document, ".sale", async sale => {

        m.loading(true, "Obteniendo datos");
        const id = sale.id;

        const data = {
            mode: "searchSold",
            id: id
        }

        const response = await f.ajax(ajaxRequests, "post", data, "json");

        m.loading(false);

        document.querySelector("#sold-products .description").textContent = response.description;
        document.querySelector("#edit").href = route("sale", id.slice(1)).url();
        
        f.remove("#sold-products .all-products article");
        
        response.products.forEach(product => {
            insertProduct(product);
        });

        setTimeout(() => {
            m.showModal("sold-products");
        }, 300);

    });
    
    // -> Abre los detalles de la venta

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

        const allProducts = document.querySelector("#sold-products .all-products");
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

    /* const searchProduct = document.querySelector("#Product");
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

    }, true); */

    // -> Busca productos

});