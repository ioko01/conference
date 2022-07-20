<?php

function thaiDateFormat($date, $time = false, $short = false)
{
    $monthTh = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
    $getYear = date("Y", strtotime($date)) + 543;
    if ($short) {
        $monthTh = ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];
        $getYear = date("y", strtotime($date)) + 43;
    }
    $getMonth = date("n", strtotime($date)) - 1;
    $getTime = date("H:i:s", strtotime($date));
    $day = date('d', strtotime($date));

    if (date('d', strtotime($date)) < 10) {
        $day = str_replace('0', '', date('d', strtotime($date)));
    }

    if ($time) {
        $fullDateTh = $day . " " . $monthTh[$getMonth] . " " . $getYear . " " . $getTime;
    } else {
        $fullDateTh = $day . " " . $monthTh[$getMonth] . " " . $getYear;
    }

    return $fullDateTh;
}
