import events from "../functions/events";
import FJ from "../functions/FamilyJewels";
import f from "../functions/functions";
import { generalScripts } from "./scripts";

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
        const price = productData.price;

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

    const insertProduct = (name, description, image, id) => {
        const newElement = f.createHTMLNode(`
            <article class="product" data-id="${id}" data-name="Nombre del producto" data-price="20.00">
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
                    <span class="price">$20.00 ARS</span>
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
    
    let asd = 1;
    const searchProduct = document.querySelector("#SearchProduct");
    eventOne("keyup", searchProduct, function () {
        
        insertProduct(this.value, null, null, asd);      
        asd++;  

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
    eventOne("click", sellButton, function() {
        
        //Reseteamos el carrito
        cart = {};
        total = 0;
        disccount = 0;
        updateResumen();
        insertNoProducts(document.querySelector("#ShoppingCart .resumen .resumen-container"));
        document.querySelector("#Vuelto").textContent = "0.00";
        document.querySelector("#sellForm").reset();

    }, true)
    
    // -> Vender los productos

});