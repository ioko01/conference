"use strict";

function toggleKota(e) {
    const kota = document.getElementById("select-kota");
    e.value === "2" ?
        kota.querySelectorAll("input[type=radio]").forEach((item) => {
            item.removeAttribute("disabled");
        }) :
        kota.querySelectorAll("input[type=radio]").forEach((item) => {
            item.setAttribute("disabled", true);
        });
}