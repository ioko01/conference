"use strict";

/**
 *
 * @param {HTMLElement} e
 */

function toggle_attend(e, route) {
    const form_address = document.getElementById("form_address");
    const form_receive = document.getElementById("form_receive");
    const form_password = document.getElementById("form_password");
    const form_register = document.getElementById("form_register");
    const position_2 = document.getElementById("position_2");
    console.log(e.value);
    if (e.value === "attend") {
        form_address.classList.remove("d-block");
        form_address.classList.add("d-none");

        form_receive.classList.remove("d-block");
        form_receive.classList.add("d-none");

        form_password.classList.add("d-none");

        form_register.setAttribute("action", route);
    } else if (e.value === "send") {
        if (position_2.checked) {
            form_address.classList.remove("d-none");
            form_address.classList.add("d-block");

            form_receive.classList.remove("d-none");
            form_receive.classList.add("d-block");
        }
        form_password.classList.remove("d-none");

        form_register.setAttribute("action", route);
    }
}
