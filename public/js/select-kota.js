"use strict";

function toggleKota(e) {
    const kota = document.getElementById("select-kota");
    e.value === "โควต้าเจ้าภาพร่วม" ?
        kota.querySelectorAll("input[type=radio]").forEach((item) => {
            item.removeAttribute("disabled");
        }) :
        kota.querySelectorAll("input[type=radio]").forEach((item) => {
            item.setAttribute("disabled", true);
        });
}