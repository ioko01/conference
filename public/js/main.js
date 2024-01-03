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
    e.innerHTML = '<i class="fas fa-check"></i> คัดลอกสำเร็จ';
    setTimeout(() => {
        e.innerHTML = '<i class="fas fa-copy"></i> คัดลอกลิงค์';
    }, 3000);
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

function open_loading_modal(modalId, modalSize = "sm", textTitle, data) {
    /**
     *  @param {String | String[] | object} data
     */

    let createModal = `
            <div style="overflow: auto;" class="modal fade" id="card_modal" data-bs-backdrop="static"
            data-bs-keyboard="false" tabindex="-1" aria-labelledby="${textTitle}" aria-hidden="true">
                <div class="modal-dialog modal-${modalSize}">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title" id="staticBackdropLabel">${textTitle}</h2>
                        </div>
                        <div class="modal-body text-center py-5" id="modal_body">${data}</div>
                    </div>
                </div>
            </div>`;

    $(modalId).html(createModal);
    $("#card_modal").modal("show");
}
