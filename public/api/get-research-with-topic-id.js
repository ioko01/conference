"use strict";

function set_topic_id(e) {
    delay(() => {
        const value = e.value;
        if (value) {
            $.ajax({
                url: `/api/get-research/${value}`,
                data: { value },
                method: "GET",
                success: function (res) {
                    if (res) {
                        if (!res.poster_name) {
                            $("#topic").html(
                                `<span class="text-red">บทความนี้ไม่มีโปสเตอร์</span>`
                            );
                            $("#topic_content").html(``);
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
                },
                error: function (err) {
                    $("#topic").html(`<span class="text-red">${err}</span>`);
                },
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
