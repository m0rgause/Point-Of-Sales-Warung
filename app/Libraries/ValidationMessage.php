<?php namespace App\Libraries;

class ValidationMessage
{
    public static function setDelimiterMessage(
        string $open_delimiter,
        string $close_delimiter,
        array $array_message
    ): array {
        $new_message = [];
        foreach($array_message as $key => $value) {
            $new_message[$key] = $open_delimiter.$value.$close_delimiter;
        }
        return $new_message;
    }

    public static function setFlashMessage(
        string $flash_message_name,
        string $open_delimiter,
        string $close_delimiter,
        array $array_message
    ): void {
        $session = \Config\Services::session();

        $new_message = static::setDelimiterMessage($open_delimiter, $close_delimiter, $array_message);
        $session->setFlashData($flash_message_name, $new_message);
    }

    public static function generateIndonesianErrorMessage(string ...$rules): array
    {
        $rules_length = count($rules);
        $array_message = [];
        for($i = 0; $i < $rules_length; $i++) {
            if($rules[$i] === 'required') {
                $array_message = array_merge($array_message, [$rules[$i] => '{field} tidak boleh kosong!']);
            }
            if($rules[$i] === 'in_list') {
                $array_message = array_merge($array_message, [$rules[$i] => '{field} harus salah satu dari: {param}!']);
            }
            if($rules[$i] === 'min_length') {
                $array_message = array_merge($array_message, [$rules[$i] => '{field} paling sedikit {param} karakter!']);
            }
            if($rules[$i] === 'max_length') {
                $array_message = array_merge($array_message, [$rules[$i] => '{field} tidak bisa melebihi {param} karakter']);
            }
            if($rules[$i] === 'is_unique') {
                $array_message = array_merge($array_message, [$rules[$i] => '{field} sudah ada']);
            }
            if ($rules[$i] === 'integer') {
                $array_message = array_merge($array_message, [$rules[$i] => '{field} harus berupa angka dan tanpa desimal']);
            }
        }
        return $array_message;
    }
}
