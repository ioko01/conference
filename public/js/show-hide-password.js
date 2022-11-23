"use strict";

window.addEventListener("load", function () {
    $(".toggle-password").html(
        '<button style="text-decoration:none;" class="btn btn-link text-green p-0"><i class="fas fa-eye"></i> แสดงรหัสผ่าน</button>'
    );
});

let isShow = false;
$(".toggle-password").click(() => {
    isShow = !isShow;
    if (isShow) {
        $("#password").attr("type", "text");
        $(".toggle-password").html(
            '<button style="text-decoration:none;" class="btn btn-link text-green p-0"><i class="fas fa-eye-slash"></i> ซ่อนรหัสผ่าน</button>'
        );
    } else {
        $("#password").attr("type", "password");
        $(".toggle-password").html(
            '<button style="text-decoration:none;" class="btn btn-link text-green p-0"><i class="fas fa-eye"></i> แสดงรหัสผ่าน</button>'
        );
    }
});
