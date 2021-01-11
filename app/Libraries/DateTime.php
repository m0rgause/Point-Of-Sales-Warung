<?php namespace App\Libraries;

class DateTime
{
    private const ARRAY_MONTH = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember'
    ];

    private function explodeTimestamp(string $timestamp): array
    {
        $array_timestamp = explode(' ',$timestamp);
        $array_date = explode('-',$array_timestamp[0]);

        $array_data['time'] = end($array_timestamp);
        $array_data['year'] = $array_date[0];
        $array_data['month'] = $array_date[1];
        $array_data['day'] = $array_date[2];

        return $array_data;
    }

    public function convertTimstampToIndonesianDateTime(string $timestamp): string
    {
        $array_timestamp = $this->explodeTimestamp($timestamp);
        return $array_timestamp['day'].' '.static::ARRAY_MONTH[$array_timestamp['month']].' '.$array_timestamp['year'].', '.$array_timestamp['time'];
    }
}
