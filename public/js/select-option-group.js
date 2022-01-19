"use strict";

function selectGroup(e) {
    try {
        const nextSelector = e.parentElement.nextElementSibling.children[1];
        nextSelector.innerHTML = `<option>---กรุณาเลือก---</option>`;
        if (e.value) {
            researchGroup.forEach(item => {
                const result = Object.keys(item).find((item, index) => item === e.value);
                createOption(nextSelector, item[result]);
            });
            nextSelector.removeAttribute("disabled");
        } else {
            nextSelector.setAttribute("disabled", true);
        }
    } catch (error) {
        throw error
    }

}

function createOption(element, value) {
    try {
        if (value) {
            value.forEach(item => {
                element.innerHTML += `<option value="${item}">${item}</option>`;
            })
        }
    } catch (error) {
        throw error
    }
}
