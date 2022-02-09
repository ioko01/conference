"use strict";

function select_faculty(e) {
    try {
        const nextSelector = e.parentElement.nextElementSibling.children[1];
        nextSelector.innerHTML = `<option value="" selected>---กรุณาเลือก---</option>`;
        if (e.value) {
            $.ajax({
                type: "GET",
                url: "/api/branches",
                data: {
                    faculty_id: e.value,
                },
                success: function (data) {
                    data.forEach((item) => {
                        const result = Object.values(item).map(value => value);
                        show_branches(nextSelector, result);
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

function show_branches(element, result) {
    try {
        if (result) {
            element.innerHTML += `<option value="${result[0]}">${result[1]}</option>`;
        }
    } catch (error) {
        throw error;
    }
}
