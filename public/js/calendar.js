"use strict";

calendar(function (output) {
    const date_conference_start = new Date(output[0].start); //วันที่เปิดงานประชุม
    const day_conference_start = date_conference_start.getDate(),
        month_conference_start = date_conference_start.getMonth(),
        year_conference_start = date_conference_start.getFullYear();

    const date_conference_final = new Date(output[0].final); //วันที่ปิดงานประชุม
    const day_conference_final = date_conference_final.getDate() + 1,
        month_conference_final = date_conference_final.getMonth(),
        year_conference_final = date_conference_final.getFullYear();

    const date_conference_end_research = new Date(output[0].end_research); //วันปิดรับบทความ
    const date_conference_end_payment = new Date(output[0].end_payment); //วันสิ้นสุดการชำระเงิน

    const date_conference_end_attend = new Date(output[0].end_attend); //วันสิ้นสุดการลงทะเบียนเข้าร่วมงาน

    const date_conference_end_research_edit = new Date(
        output[0].end_research_edit
    ); //วันสิ้นสุดรับบทความแก้ไข

    var Calendar = FullCalendar.Calendar;
    var calendarEl = document.getElementById("calendar");

    var calendar = new Calendar(calendarEl, {
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek",
        },
        buttonText: {
            today: "วันนี้",
            month: "เดือน",
            week: "สัปดาห์",
            day: "วัน",
            list: "ลิส",
        },
        eventTimeFormat: {
            hour: "2-digit",
            minute: "2-digit",
            meridiem: false,
        },
        allDayText: "ทั้งวัน",
        themeSystem: "bootstrap",
        nextDayThreshold: "24:00:00",
        //events
        events: [
            {
                title: "วันเริ่ม - สิ้นสุดงานประชุมวิชาการ",
                start: new Date(
                    year_conference_start,
                    month_conference_start,
                    day_conference_start
                ),
                end: new Date(
                    year_conference_final,
                    month_conference_final,
                    day_conference_final
                ),
                backgroundColor: "#f39c12", //yellow
                borderColor: "#f39c12", //yellow
                allDay: true,
            },
            {
                title: "สิ้นสุดรับบทความ",
                start: new Date(date_conference_end_research),
                backgroundColor: "#17a2b8", //blue sky
                borderColor: "#17a2b8", //blue sky
                allDay: false,
            },
            {
                title: "วันสิ้นสุดการชำระเงิน",
                start: new Date(date_conference_end_payment),
                backgroundColor: "#f56954", //red
                borderColor: "#f56954", //red
                allDay: false,
            },
            {
                title: "วันสิ้นสุดการลงทะเบียนเข้าร่วมงาน",
                start: new Date(date_conference_end_attend),
                backgroundColor: "#24af21", //green
                borderColor: "#24af21", //green
                allDay: false,
            },
            {
                title: "วันสิ้นสุดรับบทความแก้ไข",
                start: new Date(date_conference_end_research_edit),
                backgroundColor: "#a037d8", //violet
                borderColor: "#a037d8", //violet
                allDay: false,
            },
        ],
    });

    calendar.render();
    calendar.setOption("locale", "th");
    // $('#calendar').fullCalendar()
});
