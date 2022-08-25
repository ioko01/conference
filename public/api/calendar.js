"use strict";
function calendar(handleData) {
    $.ajax({
        method: "GET",
        url: "/conference/open",
        success: function (res) {
            handleData(res);
        },
    });
}
