<?php

class ThaiDateHelper
{
    public function thaiDateFormat($date, $time = false)
    {
        $monthTh = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
        $getYear = date("Y", strtotime($date)) + 543;
        $getMonth = date("n", strtotime($date));
        $getTime = date("H:i:s", strtotime($date));

        if ($time) {
            $fullDateTh = date('d', strtotime($date)) . " " . $monthTh[$getMonth] . " " . $getYear . " " . $getTime;
        } else {
            $fullDateTh = date('d', strtotime($date)) . " " . $monthTh[$getMonth] . " " . $getYear;
        }

        return $fullDateTh;
    }
}
