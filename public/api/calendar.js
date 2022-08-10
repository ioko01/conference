"use strict";
function calendar(handleData) {
    $.ajax({
        method: "GET",
        url: "/api/calendar",
        success: function (res) {
            handleData(res);
        },
    });
}
