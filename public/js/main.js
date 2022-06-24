"use strict";

window.addEventListener("load", function () {
    try {
        autosize();
        const linkOrFile = ["link", "file"];
        const linkOrFileUpload = ["link-upload", "file-upload"];
        linkOrFile.forEach((_, index) => {
            toggleLinkOrFile(linkOrFile[index], linkOrFileUpload[index], false);
        });
    } catch (error) {
        throw error;
    }
});

function autosize() {
    var text = $(".autosize");

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

function toggleLinkOrFile(radioId, inputId) {
    $(`#${radioId}`).on("change", function () {
        $("#upload-type :not(input[type='radio'])").attr("disabled", true);
        $(`#${inputId}`).removeAttr("disabled");
    });
}
