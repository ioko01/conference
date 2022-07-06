"use strict";

window.addEventListener("load", function () {
    try {
        const linkOrFile = ["link", "file"];
        const linkOrFileUpload = ["link-upload", "file-upload"];
        linkOrFile.forEach((_, index) => {
            toggle_link_or_file(
                linkOrFile[index],
                linkOrFileUpload[index],
                false
            );
        });
    } catch (error) {
        throw error;
    }
});

function toggle_link_or_file(radioId, inputId) {
    const el = ".label-type-file";

    const styled = {
        "background-color": "#e9ecef",
        cursor: "default",
    };

    $(`#${radioId}`).on("change", function () {
        $("#upload-type :not(input[type='radio'])").attr("disabled", true);

        if (inputId != "file-upload") {
            set_styled(el, styled);
        } else {
            $(el).removeAttr("style");
        }

        $(`#${inputId}`).removeAttr("disabled");
    });
}

function set_styled(el, styled = {}) {
    for (const key in styled) {
        $(el).css(key, styled[key]);
    }
}

function get_fileName(e) {
    try {
        $(".label-type-file").html(e.files[0].name);
        $("#name_file").val(e.files[0].name);
    } catch (error) {
        $(".label-type-file").html("ไม่ได้เลือกไฟล์ใด");
        $("#name_file").val(null);
    }
}
