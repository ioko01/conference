"use strict";

calendar(function (output) {
    const end_research = !output[0] ? null : new Date(output[0].end_research); //วันปิดรับบทความ Call for paper
    const end_payment = !output[0] ? null : new Date(output[0].end_payment); //วันสิ้นสุดการชำระค่าลงทะเบียน
    const consideration = !output[0] ? null : new Date(output[0].consideration); //วันสิ้นสุดการชำระค่าลงทะเบียน
    const end_research_edit = !output[0]
        ? null
        : new Date(output[0].end_research_edit); //วันสิ้นสุดรับบทความแก้ไข
    const end_attend = !output[0] ? null : new Date(output[0].end_attend); //วันสิ้นสุดการลงทะเบียนเข้าร่วมงาน
    const notice_attend = !output[0] ? null : new Date(output[0].notice_attend); //วันสิ้นสุดการลงทะเบียนเข้าร่วมงาน
    const present = !output[0] ? null : new Date(output[0].present); //วันสิ้นสุดการลงทะเบียนเข้าร่วมงาน
    const proceeding = !output[0] ? null : new Date(output[0].proceeding); //วันสิ้นสุดการลงทะเบียนเข้าร่วมงาน

    let Calendar = FullCalendar.Calendar;
    let calendarEl = document.getElementById("calendar");
    let calendar = new Calendar(calendarEl, {
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,dayGridWeek,listYear",
        },
        buttonText: {
            today: "วันนี้",
            month: "เดือน",
            week: "สัปดาห์",
            day: "วัน",
            list: "ปี",
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
                title: "สิ้นสุดรับบทความ",
                start: end_research,
                backgroundColor: "#17a2b8", //blue sky
                borderColor: "#17a2b8", //blue sky
                allDay: false,
            },
            {
                title: "วันสิ้นสุดการชำระค่าลงทะเบียน",
                start: end_payment,
                backgroundColor: "#f56954", //orange
                borderColor: "#f56954", //orange
                allDay: false,
            },
            {
                title: "ประกาศผลพิจารณา",
                start: consideration,
                backgroundColor: "#24af21", //green
                borderColor: "#24af21", //green
                allDay: false,
            },
            {
                title: "วันสิ้นสุดรับบทความแก้ไข",
                start: end_research_edit,
                backgroundColor: "#a037d8", //violet
                borderColor: "#a037d8", //violet
                allDay: false,
            },
            {
                title: "วันสิ้นสุดลงทะเบียนเข้าร่วมงาน",
                start: end_attend,
                backgroundColor: "#d83737", //red
                borderColor: "#d83737", //red
                allDay: false,
            },
            {
                title: "ประกาศรายชื่อผู้เข้าร่วมงานทั้งหมด",
                start: notice_attend,
                backgroundColor: "#d8d337", //yellow
                borderColor: "#d8d337", //yellow
                allDay: false,
            },
            {
                title: "นำเสนอผลงาน",
                start: present,
                backgroundColor: "#00bc8c", //light green
                borderColor: "#00bc8c", //light green
                allDay: false,
            },
            {
                title: "เผยแพร่ Proceeding",
                start: proceeding,
                backgroundColor: "#dee2e6", //white smoke
                borderColor: "#dee2e6", //white smoke
                allDay: false,
            },
        ],
    });

    calendar.render();
    calendar.setOption("locale", "th");
    // $('#calendar').fullCalendar()
});
