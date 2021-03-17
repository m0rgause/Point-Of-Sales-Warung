<?php

namespace App\Libraries;

use CodeIgniter\I18n\Time;

class IndoTime extends Time
{
    private static function explodeTimestamp(string $timestamp): array
    {
        $arr_timestamp = explode(' ',$timestamp);
        $arr_date = explode('-',$arr_timestamp[0]);
        $arr_time = explode(':',end($arr_timestamp));

        return [
            'year' => (int) $arr_date[0],
            'month' => (int) $arr_date[1],
            'day' => (int) $arr_date[2],
            'hour' => (int) $arr_time[0],
            'minutes' => (int) $arr_time[1],
            'seconds' => (int) $arr_time[2]
        ];
    }

    public static function toIndoLocalizedString(? string $timestamp): ? string
    {
        if($timestamp === null) return null;

        $arr_timestamp = static::explodeTimestamp($timestamp);

        return static::create(
            $arr_timestamp['year'],
            $arr_timestamp['month'],
            $arr_timestamp['day'],
            $arr_timestamp['hour'],
            $arr_timestamp['minutes'],
            $arr_timestamp['seconds'],
            'Asia/Jakarta',
            'id_ID'
        )->toLocalizedString('dd MMMM YYYY, HH:mm:ss');
    }
}
