<?php

use Carbon\Carbon;

function formatDate($date, $format = 'd/m/Y')
{
    if (!$date) {
        return null;
    }

    return Carbon::parse($date)->format($format);
}
