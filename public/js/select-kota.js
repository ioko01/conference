"use strict";

/**
 *
 * @param {HTMLElement} e
 */

function toggle_position(e, route_register, route_expert) {
    const kota = document.getElementById("select-kota");
    const select_attend = document.getElementById("select-attend");
    const attend = document.getElementById("attend");
    const institution = document.getElementById("institution");
    const address = document.getElementById("form_address");
    const receive = document.getElementById("form_receive");
    const form_register = document.getElementById("form_register");
    const form_password = document.getElementById("form_password");
    const person_attend = document.querySelectorAll(
        'input[name="person_attend"]'
    );

    if (e.value === "1" || e.value === "3" || e.value === "4") {
        address.classList.remove("d-block");
        address.classList.add("d-none");
        receive.classList.remove("d-block");
        receive.classList.add("d-none");
    } else if (e.value == "2") {
        if (!attend.checked) {
            address.classList.remove("d-none");
            address.classList.add("d-block");
            receive.classList.remove("d-none");
            receive.classList.add("d-block");
        }
    }
    person_attend.forEach((item) => {
        if (e.value == "4") {
            form_password.classList.remove("d-none");
            form_register.setAttribute("action", route_expert);
        } else {
            if (item.value == "attend" && item.checked) {
                form_password.classList.add("d-none");
            }
            form_register.setAttribute("action", route_register);
        }
    });

    e.value === "4"
        ? select_attend
              .querySelectorAll("input[type=radio]")
              .forEach((item) => {
                  item.setAttribute("disabled", true);
              })
        : select_attend
              .querySelectorAll("input[type=radio]")
              .forEach((item) => {
                  item.removeAttribute("disabled");
              });

    e.value === "2" || e.value === "4"
        ? institution.removeAttribute("disabled")
        : institution.setAttribute("disabled", true);

    e.value === "3"
        ? kota.querySelectorAll("input[type=radio]").forEach((item) => {
              item.removeAttribute("disabled");
          })
        : kota.querySelectorAll("input[type=radio]").forEach((item) => {
              item.setAttribute("disabled", true);
          });
}
