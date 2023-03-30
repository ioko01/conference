"use strict";

function setAttributes(el, attrs = [], targets = []) {
    attrs.forEach((attr, index) => {
        $(el).attr(attr, targets[index]);
    });
}

window.addEventListener("load", function () {
    const attrs = ["min", "max"];
    const targets = [$("#start").val(), $("#final").val()];
    const el = "input[type='datetime-local']:not(#start):not(#final):not(#end_research_edit_two)";

    setAttributes(el, attrs, targets);
});

function get_min_date_value(e) {
    $("input[type='datetime-local']:not(#start):not(#final)").attr(
        "min",
        e.value
    );
}

function get_max_date_value(e) {
    $("input[type='datetime-local']:not(#final):not(#start)").attr(
        "max",
        e.value
    );
}
