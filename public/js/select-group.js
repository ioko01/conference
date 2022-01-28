"use strict";

function selectGroup(e) {
    try {
        const nextSelector = e.parentElement.nextElementSibling.children[1];
        nextSelector.innerHTML = `<option>---กรุณาเลือก---</option>`;
        if (e.value) {
            $.ajax({
                type: "GET",
                url: "/api/branches",
                data: {
                    faculty_id: e.value,
                },
                success: function(data) {
                    data.forEach((item) => {
                        const result = Object.values(item).map(value => value);
                        createOption(nextSelector, result);
                    });
                },
            });
            nextSelector.removeAttribute("disabled");
        } else {
            nextSelector.setAttribute("disabled", true);
        }
    } catch (error) {
        throw error;
    }
}

function createOption(element, result) {
    try {
        if (result) {
            element.innerHTML += `<option value="${result[0]}">${result[1]}</option>`;
        }
    } catch (error) {
        throw error;
    }
}