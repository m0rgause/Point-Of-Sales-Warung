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
}
