import events from "../functions/events";
import FJ from "../functions/FamilyJewels";
import f from "../functions/functions";
import { generalScripts } from "./scripts";

const { eventAll, eventOne } = events;

document.addEventListener("DOMContentLoaded", () => {

    generalScripts();

    const cart = [];
    let total = 0;
    let disccount = 0;

    //Carrito de compras
    eventAll("click", document, ".product button", element => {
        const productData = element.parentNode.parentNode.parentNode.dataset;
        const id = productData.id;
        const name = productData.name;
        const price = productData.price;

        if (cart[id] != undefined) {
            //El elemento ya está insertado
            cart[id]["quantity"]++;

            const subtotal = price * cart[id]["quantity"];

            cart[id]["price"] = parseFloat(subtotal).toFixed(2);
        }
        else {
            //Hay que crearlo
            cart[id] = [];
            cart[id]["name"] = name;
            cart[id]["price"] = price;
            cart[id]["quantity"] = 1;
        }
        
        total += parseFloat(price);

        //Removemos todos los elementos del resumen
        if(cart.length > 0)
            f.remove("#ShoppingCart .resumen-container > div");

        //Insertamos cada elemento dentro de la lista
        cart.forEach(product => {
            const newProduct = f.createHTMLNode(`
                <div class="product">
                    <span>${product.quantity} ${product.name}</span>
                    <span class="price">$${product.price} ARS</span>
                </div>
            `);

            document.querySelector("#ShoppingCart .resumen-container").append(newProduct);
        });

        //Establecemos el nuevo total
        document.querySelector("#Total").textContent = parseFloat(total).toFixed(2);
        
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

});