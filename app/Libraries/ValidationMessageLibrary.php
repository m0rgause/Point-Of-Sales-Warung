<?php namespace App\Libraries;

use CodeIgniter\Session\Session;

class ValidationMessageLibrary
{
    public function setDelimiterMessage(
        string $open_delimiter,
        array $array_message,
        string $close_delimiter
    ): array {
        $new_message = [];
        foreach($array_message as $key => $value) {
            $new_message[$key] = $open_delimiter.$value.$close_delimiter;
        }
        return $new_message;
    }

    public function setFlashMessage(
        Session $object_session,
        string $nama_flash_message,
        string $open_delimiter,
        array $array_message,
        string $close_delimiter
    ): void {
        $new_message = $this->setDelimiterMessage($open_delimiter, $array_message, $close_delimiter);
        $object_session->setFlashData($nama_flash_message, $new_message);
    }
}
