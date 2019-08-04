import events from "../functions/events";
import FJ from "../functions/FamilyJewels";
import f from "../functions/functions";
import { generalScripts } from "./scripts";
import swal from "sweetalert";
import m from "../functions/modal";

const { eventAll, eventOne } = events;

document.addEventListener("DOMContentLoaded", () => {

    generalScripts();

    let cart = {};
    let total = 0;
    let disccount = 0;

    // Inserta elementos dentro de la lista del carrito
    
    const updateResumen = () => {
        //Removemos todos los elementos del resumen
        f.remove("#ShoppingCart .resumen-container > div");

        //Insertamos cada elemento dentro de la lista
        for (const key in cart) {
            const product = cart[key];

            const newProduct = f.createHTMLNode(`
                <div class="product" data-id="${key}">
                    <span>${product.quantity} ${product.name}</span>
                    <span class="price">$${parseFloat(product.price).toFixed(2)} ARS</span>
                </div>
            `);

            document.querySelector("#ShoppingCart .resumen-container").append(newProduct);
        }
        //Establecemos el nuevo total
        document.querySelector("#Total").textContent = parseFloat(total).toFixed(2);
    }
    
    // -> Inserta elementos dentro de la lista del carrito

    //Carrito de compras
    eventAll("click", document, ".product button", element => {
        const productData = element.parentNode.parentNode.parentNode.dataset;
        const id = productData.id;
        const name = productData.name;
        const price = parseFloat(productData.price);

        if (cart.hasOwnProperty(id)) {
            //El elemento ya está insertado
            cart[id].quantity++;

            const subtotal = price * cart[id].quantity;

            cart[id].price = parseFloat(subtotal);
        }
        else {
            //Hay que crearlo
            cart[id] = {};
            cart[id].name = name;
            cart[id].price = price;
            cart[id].quantity = 1;
        }
        
        total += parseFloat(price);

        updateResumen();
        
    });

    //Calcula cuanto se le va a devolver
    const vuelto = () => {
        const payed = document.querySelector("#Payed").value;
        if (payed != "") {
            const finalTotal = total -( (disccount * total) / 100);
            document.querySelector("#Vuelto").textContent = parseFloat(payed - finalTotal).toFixed(2);
        }
    }

    const payed = document.querySelector("#Payed");
    eventOne("keyup", payed, function() {
        if (this.value > total) vuelto()
        else document.querySelector("#Vuelto").textContent = "0.00"
    }, true);

    //Establece el descuento
    const disccountQuantity = document.querySelector("#Disccount");
    eventOne("change", disccountQuantity, function(){
        disccount = this.value;
        vuelto();
    }, true);

    // Busca un producto

    const insertProduct = (name, description, image, price, id) => {
        const newElement = f.createHTMLNode(`
            <article class="product" data-id="${id}" data-name="${name}" data-price="${price}">
                <div class="image-container">
                    <img src="${image}" alt="Imagen del producto">
                </div>
                <div class="data">
                    <h4>${name}</h4>
                    <div class="description">
                        <p>${description}</p>
                    </div>
                </div>
               <div class="actions">
                    <span class="price">${f.parseMoney(price)} ARS</span>
                    <div class="button-container">
                        <button class="btn btn-success">Agregar al carrito</button>
                    </div>
                </div>
            </article>
        `);

        const allProducts = document.querySelector("#AllProducts .card");
        const products = FJ(allProducts).children(".product").elements.length;

        if (products > 0) {
            allProducts.insertBefore(newElement, allProducts.children[0]);
        }
        else {
            f.remove(allProducts.children[0]);
            allProducts.append(newElement);
        }
    }
    
    const searchProduct = document.querySelector("#SearchProduct");
    eventOne("keyup", searchProduct, async function () {

        const data = {
            mode: "getProductList",
            query: this.value
        }

        const response = await f.ajax(ajaxRequests, "post", data, "json");
        //Eliminamos los elementos que estéhn
        f.remove("#AllProducts .card > .product");

        //Los insertamos
        response.query.forEach(product => {
            insertProduct(product.name, product.description, product.image, product.id);      
        });

    }, true);
    
    // -> Busca un producto

    // Quita un producto de la lista de productos

    const insertNoProducts = parent => {
        console.log(parent);
        
        if (parent.children.length == 0) {
            const noProducts = f.createHTMLNode(`
                <div class="no-products">
                    <span>Aún no has agregado productos al carrito</span>
                </div>  
            `);

            parent.append(noProducts);
        }
    }
    
    //Quita uno
    eventAll("click", "#ShoppingCart .resumen .resumen-container", ".product", product => {

        const id = product.dataset.id;
        const parent = product.parentNode;
        const price = cart[id].price / cart[id].quantity;
        cart[id].quantity--;
        cart[id].price -= parseFloat(price);
        total -= price;

        if (cart[id].quantity == 0) delete cart[id];

        updateResumen();
        insertNoProducts(parent);

    });

    //Quita todo
    eventAll("contextmenu", "#ShoppingCart .resumen .resumen-container", ".product", (product, e) => {

        e.preventDefault();
        const id = product.dataset.id;
        const parent = product.parentNode;
        const price = cart[id].price;

        total -= price;

        delete cart[id];

        updateResumen();
        insertNoProducts(parent);

    });
    
    // -> Quita un producto de la lista de productos

    // Vender los productos
    
    const sellButton = document.querySelector("#sell");
    eventOne("click", sellButton, async function() {

        const paymentMethod = document.querySelector("input[name='payment-method']:checked");
        
        if (Object.keys(cart).length > 0) {
            if (paymentMethod != null) {
                m.loading(true, "Procesando..");
                //Mandamos los datos
                cart.total = total;
                cart.disccount = disccount;
                cart.payment_method = parseInt(paymentMethod.value);
                cart.mode = "sell";

                const response = await f.ajax(ajaxRequests, "post", cart, "json");

                m.loading(false);

                console.log(response);
                

                if (response.status == "true") {
                    //Reseteamos el carrito
                    cart = {};
                    total = 0;
                    disccount = 0;
                    updateResumen();
                    insertNoProducts(document.querySelector("#ShoppingCart .resumen .resumen-container"));
                    document.querySelector("#Vuelto").textContent = "0.00";
                    document.querySelector("#sellForm").reset();
                    swal("¡Venta realizada!", "La venta ha sido realziada con éxito", "success")
                }
                else {
                    swal("Error", response.message, "error");
                }

            }
            else {
                swal("Un momento", "Elige un método de pago", "warning");                
            }
        }
        else {
            swal("Error", "No hay artículos en el carrito", "error");
        }
        

    }, true)
    
    // -> Vender los productos

});