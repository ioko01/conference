"use strict";

function present_oral(e) {
    delay(() => {
        const value = e.value;
        if (value) {
            get_topic_id(value, function (res) {
                if (res) {
                    if (res.statusText == "error") {
                        $("#topic").html(
                            `<span class="text-red">เกิดข้อผิดพลาดบางอย่าง กรุณาลองใหม่อีกครั้ง</span>`
                        );
                    } else {
                        $("#topic").html(`
                            <span class="text-green">${res.topic_th}</span>
                           `);
                        $("#topic_content").html(`
                           <input type="hidden" name="topic_th" value="${res.topic_th}"/>
                           `);
                        $("#faculty_id").val(res.faculty_id).change();
                    }
                } else {
                    $("#topic").html(
                        `<span class="text-red">ไม่มีบทความนี้</span>`
                    );
                    $("#topic_content").html(``);
                }
            });
        } else {
            $("#topic").html(
                `<span class="text-red">กรุณากรอกรหัสบทความ</span>`
            );
            $("#topic_content").html(``);
        }
    }, 400);
}

const delay = (() => {
    let timer = 0;
    return (callback, ms) => {
        clearTimeout(timer);
        timer = setTimeout(callback, ms);
    };
})();
