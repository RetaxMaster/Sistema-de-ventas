import events from "../functions/events";
import FJ from "../functions/FamilyJewels";
import f from "../functions/functions";
import swal from 'sweetalert';
import m from "../functions/modal";
import { generalScripts } from "./scripts";

const { eventAll, eventOne, event } = events;

document.addEventListener("DOMContentLoaded", () => {

    generalScripts();

    // Crea el historial
    
    const createLog = (text, datetime, username) => {

        const log = f.createHTMLNode(`
            <article class="log">
                <div class="Info">
                    <span class="user">${username}:</span>
                    <p>${text}</p>
                </div>
                <time datetime="${datetime}">
                    ${f.getShortDateFromTimestamp(datetime)} <br> ${f.getTimeFromTimestamp(datetime)}
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
    eventOne("click", closeCashRegister, async function () {
        m.loading(true, "Cerrando");
        setTimeout(() => {
            m.loading(true, "Creando la copia de seguridad y subiendo archivos a Google Drive, esto puede tomar algunos minutos, por favor espere.");            
        }, 3000);

        const data = {
            mode: "closeCashRegister"    
        }

        const response = await f.ajax(ajaxRequests, "post", data, "json");

        m.loading(false);
        
        if (response.status == "true") {
            document.querySelector("#withdrawals").disabled = true;
            document.querySelector("#setInitial").disabled = true;
            document.querySelector("#Retirar").disabled = true;
            document.querySelector("#Establecer").disabled = true;
            document.querySelector("#open-cash-register").classList.remove("hidden");
            this.classList.add("hidden");
            createLog(response.log.text, response.log.timestamp, response.username);
            swal("Listo", "¡Caja cerrada y copia de seguridad guardada en Google Drive!", "success")
        }
        else {
            if (response.isOpenCloseError == "true") {
                await swal("Un momento", response.message, "warning");
                document.location.href = route("caja").url();
            }
            else {
                swal("Error", response.message, "error")
            }
        }

    }, true);
    
    // -> Cierra la caja

    // Abre la caja

    const openCashRegister = document.querySelector("#open-cash-register");
    eventOne("click", openCashRegister, async function () {

        m.loading(true, "Abriendo");

        const data = {
            mode: "openCashRegister"    
        }

        const response = await f.ajax(ajaxRequests, "post", data, "json");

        m.loading(false);
        
        if (response.status == "true") {
            document.querySelector("#withdrawals").disabled = false;
            document.querySelector("#setInitial").disabled = false;
            document.querySelector("#Retirar").disabled = false;
            document.querySelector("#Establecer").disabled = false;
            document.querySelector("#close-cash-register").classList.remove("hidden");
            this.classList.add("hidden");
            createLog(response.log.text, response.log.timestamp, response.username);
        }
        else {
            if (response.isOpenCloseError == "true") {
                await swal("Un momento", response.message, "warning");
                document.location.href = route("caja").url();
            }
            else {
                swal("Error", response.message, "error")
            }
        }
    }, true);

    // -> Abre la caja

    // Retira dinero
    
    const withdrawal = document.querySelector("#Retirar");
    eventOne("click", withdrawal, async function () {
        
        const totalWithdrawal = document.querySelector("#withdrawals");
        const value = parseFloat(totalWithdrawal.value);

        if (value != "") {
            if (value <= total) {

                m.loading(true, "Retirando");

                const data = {
                    mode: "withdrawal",
                    value: value
                }

                const response = await f.ajax(ajaxRequests, "post", data, "json");
                m.loading(false);

                if (response.status == "true") {
                    total = response.balance;
                    
                    document.querySelector("#Total").textContent = f.parseMoney(total);
                    totalWithdrawal.value = "";
                    createLog(response.log.text, response.log.timestamp, response.username);
                }
                else {
                    await swal("Error", response.message, "error");
                    document.location.href = route("caja").url();
                }
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

    // Establece el dinero
    
    const initial = document.querySelector("#Establecer");
    eventOne("click", initial, async function () {
        
        const setInitial = document.querySelector("#setInitial");
        const value = parseFloat(setInitial.value);

        if (value != "") {

            m.loading(true, "Estableciendo");

            const data = {
                mode: "setBalance",
                value: value
            }

            const response = await f.ajax(ajaxRequests, "post", data, "json");

            m.loading(false);

            if (response.status == "true") {     
                total = response.balance;
                document.querySelector("#Total").textContent = f.parseMoney(total);
                setInitial.value = "";
                createLog(response.log.text, response.log.timestamp, response.username);
            }
            else {
                swal("Error", response.message, "error");
            }

        }
        else {
            setInitial.classList.add("is-invalid");
        }

    }, true);
    
    // -> Establece el dinero

    // Carga los logs
    let logsChargeds = 10;
    
    const seeMore = document.querySelector(".see-more");

    if (seeMore != null) {
        eventOne("click", seeMore, async function() {
            
            const data = {
                mode: "getMoreLogs",
                logsChargeds: logsChargeds
            }
    
            m.loading(true, "Buscando");
    
            const response = await f.ajax(ajaxRequests, "post", data, "json");
            
    
            response.log.forEach(log => {
                
                const logElement = f.createHTMLNode(`
                    <article class="log" id="${log.id}">
                        <div class="Info">
                            <span class="user">${log.username}:</span>
                            <p>${log.action}</p>
                        </div>
                        <time datetime="${log.created_at}">
                            ${f.getShortDateFromTimestamp(log.created_at)} <br> ${f.getTimeFromTimestamp(log.created_at)}
                        </time>
                    </article>
                `);
    
                document.querySelector("#AllLogs").append(logElement);
                
            });
            
            logsChargeds += 10;
            if (logsChargeds >= response.allLogs) f.remove(".see-more");
    
            m.loading(false);
    
        }, true)
    }
    
    
    // -> Carga los logs

});