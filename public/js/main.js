"use strict";

window.addEventListener("load", function () {
    try {
        autosize();
    } catch (error) {
        throw error;
    }
});

function copyText(e, text) {
    navigator.clipboard.writeText(text);
    e.innerHTML = '<i class="fas fa-check"></i> คัดลอกสำเร็จ'
    setTimeout(() => {
        e.innerHTML = '<i class="fas fa-copy"></i> คัดลอกลิงค์'
    },3000)
}

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
        const date = document.querySelectorAll(
            "input[type='datetime-local']:not(#start):not(#final):not(#end_research_edit_two)"
        );

        $(e).attr("disabled", true);
        for (let i = 0; i < date.length; i++) {
            if (date[i].value > document.getElementById("final").value) {
                $(e).removeAttr("disabled");
                break;
            }
        }
    }, 10);
}
