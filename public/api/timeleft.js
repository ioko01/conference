"use strict";

function timeleft() {
    try {
        $.ajax({
            method: "GET",
            url: "/api/research/timeleft",
            beforeSend: function () {
                const timeleftHtml = $("#timeleft");
                const h1 = document.createElement("h1");
                h1.classList.add("text-red");
                h1.classList.add("text-center");
                h1.textContent = `กรุณารอสักครู่`;
                timeleftHtml.html(h1);
            },
            success: function (res) {
                const timeleftHtml = $("#timeleft");
                const h1 = document.createElement("h1");

                h1.classList.add("text-center");
                const end_research = new Date(res.end_research).getTime();
                const interval = setInterval(() => {
                    const now = new Date().getTime();
                    const distance = end_research - now;

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    if (res) {
                        h1.classList.add("text-green");
                        h1.textContent = `ปิดรับบทความในอีก ${days} วัน ${hours} ชั่วโมง ${minutes} นาที ${seconds} วินาที`;
                    } else {
                        clearInterval(interval);
                        h1.classList.add("text-red");
                        h1.textContent = `ยังไม่เปิดรับบทความ`;
                    }
                    if (days < 0) {
                        clearInterval(interval);
                        h1.classList.add("text-red");
                        h1.textContent = `ยังไม่เปิดรับบทความ`;
                    }
                    timeleftHtml.html(h1);
                }, 1000);
            },
            error: function (err) {
                h1.classList.add("text-red");
                h1.textContent = err;
                timeleftHtml.html(h1);
            }
        });
    } catch (error) {}
}

document.addEventListener("load", timeleft());
