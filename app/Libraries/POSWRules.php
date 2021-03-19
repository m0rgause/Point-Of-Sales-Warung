<?php

namespace App\Libraries;

class POSWRules
{
    public function product_price(array $prices, ?array &$errors): bool
    {
        $errors = [];
        $count_price = count($prices);
        for ($i = 0; $i < $count_price; $i++) {
            // if empty price
            if (empty(trim($prices[$i]))) {
                $errors[$i] = "Harga tidak boleh kosong!";
            }
            // if price more than 10 character
            elseif (strlen($prices[$i]) > 10) {
                $errors[$i] = "Harga tidak bisa melebihi 10 karakter.";
            }
            // if price not a number
            elseif (!preg_match('/^\d+$/', $prices[$i])) {
                $errors[$i] = "Harga harus terdiri dari angka!";
            }
        }

        if (count($errors) > 0) {
            return false;
        }
        return true;
    }

    public function product_magnitude(array $magnitudes, ?array &$errors): bool
    {
        $errors = [];
        $count_magnitude = count($magnitudes);
        for ($i = 0; $i < $count_magnitude; $i++) {
            // if empty magnitude
            if (empty(trim($magnitudes[$i]))) {
                $errors[$i] = "Besaran tidak boleh kosong!";
            }
            // if magnitude more than 20 character
            elseif (strlen($magnitudes[$i]) > 20) {
                $errors[$i] = "Besaran tidak bisa melebihi 20 karakter.";
            }
        }

        if (count($errors) > 0) {
            return false;
        }
        return true;
    }

    public function product_photo(?string $str, ?string &$error): bool
    {
        $request = \Config\Services::request();
        $file = $request->getFile('product_photo');

        // if not file was uploaded
        if ($file->getError() === 4) {
            $error = "Tidak ada Foto Produk yang diupload.";
        }
        // if not valid file
        elseif (!$file->isValid()) {
            $error = "Foto Produk yang diupload tidak benar.";
        }
        // if size file exceed 1MB
        elseif ($file->getSizeByUnit('mb') > 1) {
            $error = "Ukuran Foto Produk tidak bisa melebihi 1MB.";
        }
        // if file extension not jpg or jpeg
        elseif (strtolower($file->getExtension()) !== 'jpg' && strtolower($file->getExtension()) !== 'jpeg') {
            $error = "Ekstensi Foto Produk harus .jpg atau .jpeg!";
        }
        // if file is valid
        elseif ($file->isValid()) {
            return true;
        }

        return false;
    }
}
