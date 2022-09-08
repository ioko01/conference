"use strict";

/**
 *
 * @param {HTMLElement} e
 */

function toggle_attend(e) {
    const form_address = document.getElementById("form_address");
    const form_receive = document.getElementById("form_receive");

    if (e.value === "attend") {
        form_address.classList.remove("d-block");
        form_address.classList.add("d-none");

        form_receive.classList.remove("d-block");
        form_receive.classList.add("d-none");
    } else if (e.value === "send") {
        form_address.classList.remove("d-none");
        form_address.classList.add("d-block");

        form_receive.classList.remove("d-none");
        form_receive.classList.add("d-block");
    }
}
