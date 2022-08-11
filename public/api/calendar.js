"use strict";
function calendar(handleData) {
    $.ajax({
        method: "GET",
        url: "/api/conference/open",
        success: function (res) {
            handleData(res);
        },
    });
}
