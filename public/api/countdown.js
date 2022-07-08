"use strict";

function countdown() {
    try {
        $.ajax({
            method: "GET",
            url: "/api/research/countdown",
            beforeSend: function () {
                const countdownHtml = $("#countdown");
                const h1 = document.createElement("h1");
                h1.innerHTML = `กรุณารอสักครู่`;
                countdownHtml.html(h1);
            },
            success: function (res) {
                const countdownHtml = $("#countdown");
                const h1 = document.createElement("h1");

                h1.classList.add("text-center");
                const end_research = new Date(res.end_research).getTime();
                const interval = setInterval(() => {
                    const now = new Date().getTime();
                    const distance = end_research - now;

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor(
                        (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
                    );
                    const minutes = Math.floor(
                        (distance % (1000 * 60 * 60)) / (1000 * 60)
                    );
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    if (res) {
                        h1.innerHTML = `
                        ปิดรับบทความในอีก<br/>
                        <hr/>
                        <div class="d-flex flex-wrap gap-4 justify-content-center">
                            <div class="d-flex">
                                <div class="box-countdown">
                                    <div>${days}</div>
                                    <div>วัน</div> 
                                </div>  
                            </div>
                            <div class="d-flex">
                                <div class="box-countdown">
                                    <div>${hours}</div>
                                    <div>ชั่วโมง</div> 
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="box-countdown">
                                    <div>${minutes}</div>
                                    <div>นาที</div> 
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="box-countdown">
                                    <div>${seconds}</div>
                                    <div>วินาที</div> 
                                </div>
                            </div>
                        </div>`;
                    } else {
                        clearInterval(interval);
                        h1.classList.add("text-red");
                        h1.innerHTML = `ยังไม่เปิดรับบทความ`;
                    }
                    if (days < 0) {
                        clearInterval(interval);
                        h1.classList.add("text-red");
                        h1.innerHTML = `สิ้นสุดเวลาการส่งบทความ`;
                    }
                    countdownHtml.html(h1);
                }, 1000);
            },
            error: function (err) {
                const countdownHtml = $("#countdown");
                const h1 = document.createElement("h1");

                h1.classList.add("text-center");
                //err.responseJSON.message
                h1.classList.add("text-red");
                h1.innerHTML = err.statusText;
                countdownHtml.html(h1);
            },
        });
    } catch (error) {}
}

document.addEventListener("load", countdown());
