"use strict";

window.addEventListener("load", function () {
    try {
        autosize();
    } catch (error) {
        throw error;
    }
});

function autosize() {
    let text = $(".autosize");

    text.each(function () {
        $(this).attr("rows", 1);
        resize($(this));
    });

    text.on("input", function () {
        resize($(this));
    });

    function resize($text) {
        $text.css("height", "auto");
        $text.css("height", $text[0].scrollHeight + "px");
    }
}

function get_file_name(e) {
    try {
        $(".label-type-file").html(e.files[0].name);
        $("#name_file").val(e.files[0].name);
    } catch (error) {
        $(".label-type-file").html("ไม่ได้เลือกไฟล์ใด");
        $("#name_file").val(null);
    }
}

function thisDisabled(e) {
    setTimeout(() => {
        $(e).attr("disabled", true);
    }, 10);
}
