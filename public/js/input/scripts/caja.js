import events from "../functions/events";
import FJ from "../functions/FamilyJewels";
import f from "../functions/functions";
import swal from 'sweetalert';
import m from "../functions/modal";
import { generalScripts } from "./scripts";

const { eventAll, eventOne, event } = events;

document.addEventListener("DOMContentLoaded", () => {

    generalScripts();

    let total = 100;

    // Crea el historial
    
    const createLog = (type) => {

        let text;

        switch (type) {
            case "withdrawal":
                text = "Retiró $20.00 ARS";
                break;

            case "set":
                text = "Estableció el valor de la caja $20.00 ARS";
                break;

            case "close_cash_register":
                text = "Cerró la caja con $20.00 ARS";
                break;

            case "open_cash_register":
                text = "Abrió la caja con $20.00 ARS";
                break;

            case "sell":
                text = "Vendió 5 artículos por $20.00 ARS";
                break;

            case "register":
                text = "Registró 5 artículos por $20.00 ARS cada uno";
                break;

            case "edit":
                text = "Editó artículo - Click para ver detalles";
                break;

            case "add_provider":
                text = 'Agregó el proveedor "Nombre del proveedor"';
                break;

            case "add_category":
                text = 'Agregó la categoría "Nombre de la categoría"';
                break;
        
            default:
                text = "No se especificó acción";
                break;
        }

        const log = f.createHTMLNode(`
            <article class="log">
                <div class="Info">
                    <span class="user">Usuario:</span>
                    <p>${text}</p>
                </div>
                <time datetime="">
                    30/07/2019 <br> 8:00 a.m
                </time>
            </article>
        `);


        const allLogs = document.querySelector("#AllLogs");
        const logsLenght = FJ(allLogs).children(".log").elements.length;

        if (logsLenght > 0) {
            allLogs.insertBefore(log, allLogs.children[0]);
        }
        else {
            f.remove(allLogs.children[0]);
            allLogs.append(log);
        }
    }
    
    // -> Crea el historial

    // Cierra la caja
    
    const closeCashRegister = document.querySelector("#close-cash-register");
    eventOne("click", closeCashRegister, function () {
        document.querySelector("#withdrawals").disabled = true;
        document.querySelector("#setInitial").disabled = true;
        document.querySelector("#Retirar").disabled = true;
        document.querySelector("#Establecer").disabled = true;
        document.querySelector("#open-cash-register").classList.remove("hidden");
        this.classList.add("hidden");
        createLog("close_cash_register");
    }, true);
    
    // -> Cierra la caja

    // Abre la caja

    const openCashRegister = document.querySelector("#open-cash-register");
    eventOne("click", openCashRegister, function () {
        document.querySelector("#withdrawals").disabled = false;
        document.querySelector("#setInitial").disabled = false;
        document.querySelector("#Retirar").disabled = false;
        document.querySelector("#Establecer").disabled = false;
        document.querySelector("#close-cash-register").classList.remove("hidden");
        this.classList.add("hidden");
        createLog("open_cash_register");
    }, true);

    // -> Abre la caja

    // Retira dinero
    
    const withdrawal = document.querySelector("#Retirar");
    eventOne("click", withdrawal, function () {
        
        const totalWithdrawal = document.querySelector("#withdrawals");
        const value = parseFloat(totalWithdrawal.value);

        if (value != "") {
            if (value <= total) {
                total -= value;
                document.querySelector("#Total").textContent = parseFloat(total).toFixed(2);
                totalWithdrawal.value = "";
                createLog("withdrawal");
            }
            else {
                swal("Error", "No hay suficientes fondos en la caja.", "error")
            }
        }
        else {
            totalWithdrawal.classList.add("is-invalid");
        }

    }, true);
    
    // -> Retira dinero

    // Retira dinero
    
    const initial = document.querySelector("#Establecer");
    eventOne("click", initial, function () {
        
        const setInitial = document.querySelector("#setInitial");
        const value = parseFloat(setInitial.value);

        if (value != "") {
            total = value;
            document.querySelector("#Total").textContent = parseFloat(total).toFixed(2);
            setInitial.value = "";
            createLog("set");
        }
        else {
            setInitial.classList.add("is-invalid");
        }

    }, true);
    
    // -> Retira dinero

});