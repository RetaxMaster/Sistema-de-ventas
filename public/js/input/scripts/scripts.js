import events from "../functions/events";
import FJ from "../functions/FamilyJewels";
import swal from 'sweetalert';
import m from "../functions/modal";

export const generalScripts = () => {

    // Ventana modal

    //Cerrar la ventana al hacer click afuera
    document.addEventListener("click", e => {
        let _this = e.target;
        console.log(document.querySelector("#loading").style.display);
        console.log(_this.classList);
        
        
        if ((_this.classList.contains('close-modal') || _this.classList.contains('modal-main')) && document.querySelector("#loading").style.display != "block") m.closeModal();
    });

    // -> Ventana modal

}