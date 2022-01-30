"use strict";

function toggle_kota(e) {
    const kota = document.getElementById("select-kota");
    e.value === "3" ?
        kota.querySelectorAll("input[type=radio]").forEach((item) => {
            item.removeAttribute("disabled");
        }) :
        kota.querySelectorAll("input[type=radio]").forEach((item) => {
            item.setAttribute("disabled", true);
        });
}
