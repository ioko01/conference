"use strict";

function present_poster(e) {
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
                        if (!res.video_link) {
                            $("#video_link").html(
                                `<span class="text-red">บทความนี้ไม่มีวิดีโอ</span>`
                            );
                            $("#video_link_content").html(``);
                        } else {
                            $("#video_link").html(`
                            <span class="text-green">${res.video_link}</span>
                           `);
                            $("#video_link_content").html(`
                           <input type="hidden" name="video_link" value="${res.video_link}"/>
                           `);
                        }
                    }
                } else {
                    $("#topic").html(
                        `<span class="text-red">ไม่มีบทความนี้</span>`
                    );
                    $("#topic_content").html(``);
                    $("#video_link").html(`<span class="text-red">-</span>`);
                    $("#video_link_content").html(``);
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

$("#no_video").change((e) => {
    if (e.currentTarget.checked) {
        $("#time_start").removeAttr("disabled");
        $("#time_end").removeAttr("disabled");
        $("#link").attr("disabled", true);
    } else {
        $("#time_start").attr("disabled", true);
        $("#time_end").attr("disabled", true);
        $("#link").removeAttr("disabled");
    }
});
