"use strict";

/**
 *
 * @param {HTMLElement} e
 */

function toggle_attend(e) {
    const form_address = document.getElementById("form_address");
    const form_receive = document.getElementById("form_receive");
    const position_2 = document.getElementById("position_2");
    console.log("object");
    if (e.value === "attend") {
        form_address.classList.remove("d-block");
        form_address.classList.add("d-none");

        form_receive.classList.remove("d-block");
        form_receive.classList.add("d-none");
    } else if (e.value === "send") {
        if (position_2.checked) {
            form_address.classList.remove("d-none");
            form_address.classList.add("d-block");

            form_receive.classList.remove("d-none");
            form_receive.classList.add("d-block");
        }
    }
}
