<?php

namespace App\Utils;

use Carbon\Carbon;
use DateTime;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class Helpers
{
    public static function castDate(string|int|null $date): DateTime|null
    {
        if (is_null($date)) {
            return null;
        }

        if (is_string($date)) {
            return Carbon::make($date);
        }

        return Date::excelToDateTimeObject($date);
    }
}
