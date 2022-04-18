"use strict";

function insertAfter(referenceNode, newNode) {
    referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
}

function setAttribute(elment, value) {
    for (let key in value) {
        elment.setAttribute(key, value[key]);
    }
}

function image(e) {
    try {
        const [file] = e.files;
        const imgElm = document.createElement("img");
        if (file && file.type == "image/jpeg") {
            e.nextSibling.remove();
            insertAfter(e, imgElm);
            setAttribute(imgElm, { class: "my-3", width: "100%" });
            imgElm.src = URL.createObjectURL(file);
        } else {
            e.nextSibling.remove();
            insertAfter(e, imgElm);
        }
    } catch (error) {
        throw error;
    }
}
