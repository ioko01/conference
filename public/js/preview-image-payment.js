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
        if (file) {
            const imgElm = document.createElement("img");
            e.nextSibling.remove();
            insertAfter(e, imgElm);
            setAttribute(imgElm, { class: "my-3", width: "100%" });
            imgElm.src = URL.createObjectURL(file);
        }
    } catch (error) {
        throw error;
    }
}