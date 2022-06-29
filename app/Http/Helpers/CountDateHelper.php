<?php

function countDate($date, $amount = 0, $type = 'days')
{
    $date_create = date_create($date);
    $date_now = date_create(date("Y-m-d"));
    date_add($date_create, date_interval_create_from_date_string("$amount $type"));
    $date_diff = date_diff($date_now, $date_create);

    if (intval($date_diff->format("%R%a")) < 0) {
        return false;
    } else {
        return true;
    }
}
