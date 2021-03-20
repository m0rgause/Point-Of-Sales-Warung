<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class BaseController extends Controller
{
    protected function setDelimiterMessage(
        string $open_delimiter,
        string $close_delimiter,
        array $messages,
        array $ignore = null
    ): array {
        // set delimiter
        $count_message = count($messages);
        $new_messages = [];
        for ($i = 0; $i < $count_message; $i++) {
            $key = key($messages);
            // forward position of array pointer to next value
            next($messages);

            // if ignore not null and key exists in ignore array
            if ($ignore !== null && in_array($key, $ignore)) {
                $new_messages[$key] = $messages[$key];
            } else {
                $new_messages[$key] = $open_delimiter.$messages[$key].$close_delimiter;
            }
        }
        return $new_messages;
    }

    protected function generateIndonesianErrorMessage(string ...$rules): array
    {
        $rules_length = count($rules);
        $array_message = [];
        for ($i = 0; $i < $rules_length; $i++) {
            if ($rules[$i] === 'required') {
                $array_message = array_merge($array_message, [$rules[$i] => '{field} tidak boleh kosong!']);
            }
            if ($rules[$i] === 'in_list') {
                $array_message = array_merge($array_message, [$rules[$i] => '{field} harus salah satu dari: {param}!']);
            }
            if ($rules[$i] === 'min_length') {
                $array_message = array_merge($array_message, [$rules[$i] => '{field} paling sedikit {param} karakter!']);
            }
            if ($rules[$i] === 'max_length') {
                $array_message = array_merge($array_message, [$rules[$i] => '{field} tidak bisa melebihi {param} karakter.']);
            }
            if ($rules[$i] === 'is_unique') {
                $array_message = array_merge($array_message, [$rules[$i] => '{field} sudah ada.']);
            }
            if ($rules[$i] === 'integer') {
                $array_message = array_merge($array_message, [$rules[$i] => '{field} harus berupa angka dan tanpa desimal.']);
            }
        }
        return $array_message;
    }

}
