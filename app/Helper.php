<?php

use App\Models\Utility;

function idFormat($model,$number)
{
    $settings = Utility::settings();
    return $settings[$model.'_prefix'] . sprintf("%05d", $number);
}