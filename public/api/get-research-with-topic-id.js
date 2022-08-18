"use strict";

function get_topic_id(value, handleData) {
    $.ajax({
        url: `/get-research/${value}`,
        data: { value },
        method: "GET",
        success: function (res) {
            handleData(res);
        },
        error: function (err) {
            handleData(err);
        },
    });
}
