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
                            <div class="selled-by">
                                <span>Vendido por:</span><br>
                                <span>Nombre de usuario</span>
                            </div>
                            <div class="quantity">
                                <span>Cantidad:</span><br>
                                <span>5</span>
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
    eventOne("keyup", searchProduct, function () {

        insertProduct(this.value, null, null, null);

    }, true);

    // -> Busca productos

});