"use strict";

function countdown() {
    try {
        $.ajax({
            method: "GET",
            url: "/api/research/countdown",
            beforeSend: function () {
                const countdownHtml = $("#countdown");
                const h1 = document.createElement("h1");
                h1.innerHTML = `<div class="lds-ellipsis">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>`;
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
                        <h1 class="fw-bold">ปิดรับบทความในอีก</h1><br/>
                        <hr/>
                        <div class="row m-0">
                            <div class="d-flex col-12 col-sm-6 col-lg-3 mb-3 justify-content-center text-green">
                                <div class="box-countdown fw-bold">
                                    <div>${days}</div>
                                    <div>วัน</div> 
                                </div>  
                            </div>
                            <div class="d-flex col-12 col-sm-6 col-lg-3 mb-3 justify-content-center text-green">
                                <div class="box-countdown fw-bold">
                                    <div>${hours}</div>
                                    <div>ชั่วโมง</div> 
                                </div>
                            </div>
                            <div class="d-flex col-12 col-sm-6 col-lg-3 mb-3 justify-content-center text-green">
                                <div class="box-countdown fw-bold">
                                    <div>${minutes}</div>
                                    <div>นาที</div> 
                                </div>
                            </div>
                            <div class="p-0 d-flex col-12 col-sm-6 col-lg-3 mb-3 justify-content-center text-green">
                                <div class="box-countdown fw-bold">
                                    <div>${seconds}</div>
                                    <div>วินาที</div> 
                                </div>
                            </div>
                        </div>`;
                        // h1.classList.add("text-red");
                        // h1.innerHTML = `<h1 class="fw-bold">สิ้นสุดเวลาการส่งบทความ</h1>`;
                    } else {
                        clearInterval(interval);
                        h1.classList.add("text-red");
                        h1.innerHTML = `<h1 class="fw-bold">ยังไม่เปิดรับบทความ</h1>`;
                    }
                    if (days < 0) {
                        clearInterval(interval);
                        h1.classList.add("text-red");
                        h1.innerHTML = `<h1 class="fw-bold">สิ้นสุดเวลาการส่งบทความ</h1>`;
                    }
                    countdownHtml.html(h1);
                }, 1000);
            },
            error: function (err) {
                const countdownHtml = $("#countdown");
                const h1 = document.createElement("h1");

                h1.classList.add("text-center");
                h1.classList.add("fw-bold");
                //err.responseJSON.message
                h1.classList.add("text-red");
                h1.innerHTML = err.statusText;
                countdownHtml.html(h1);
            },
        });
    } catch (error) {}
}

document.addEventListener("load", countdown());
