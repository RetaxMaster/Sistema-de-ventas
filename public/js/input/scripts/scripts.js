import events from "../functions/events";
import FJ from "../functions/FamilyJewels";
import swal from 'sweetalert';
import m from "../functions/modal";

export const generalScripts = () => {

    // Ventana modal

    //Cerrar la ventana al hacer click afuera
    document.addEventListener("click", e => {
        let _this = e.target;
        if (_this.classList.contains('close-modal') || _this.classList.contains('modal-main')) m.closeModal();
    });

    // -> Ventana modal

}