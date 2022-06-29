"use strict";

function toggle_position(e) {
    const kota = document.getElementById("select-kota");
    const institution = document.getElementById("institution");

    e.value === "2"
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
