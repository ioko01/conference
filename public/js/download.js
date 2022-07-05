"use strict";

window.addEventListener("load", function () {
    try {
        const linkOrFile = ["link", "file"];
        const linkOrFileUpload = ["link-upload", "file-upload"];
        linkOrFile.forEach((_, index) => {
            toggleLinkOrFile(linkOrFile[index], linkOrFileUpload[index], false);
        });
    } catch (error) {
        throw error;
    }
});

function toggleLinkOrFile(radioId, inputId) {
    const el = ".label-type-file";

    const styled = {
        "background-color": "#e9ecef",
        cursor: "default",
    };

    $(`#${radioId}`).on("change", function () {
        $("#upload-type :not(input[type='radio'])").attr("disabled", true);

        if (inputId != "file-upload") {
            setStyled(el, styled);
        } else {
            $(el).removeAttr("style");
        }

        $(`#${inputId}`).removeAttr("disabled");
    });
}

function setStyled(el, styled = {}) {
    for (const key in styled) {
        $(el).css(key, styled[key]);
    }
}

function getFileName(e) {
    try {
        $(".label-type-file").html(e.files[0].name);
        $("#name_file").val(e.files[0].name);
    } catch (error) {
        $(".label-type-file").html("ไม่ได้เลือกไฟล์ใด");
        $("#name_file").val(null);
    }
}
