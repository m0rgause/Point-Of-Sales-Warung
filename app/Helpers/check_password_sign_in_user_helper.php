<?php

function check_password_sign_in_user(? string $password, string $password_db): string
{
    if(empty(trim($password))) {
        return 'Password mu tidak boleh kosong!';
    }

    if(password_verify($password, $password_db)) {
        return 'yes';
    }
    return 'Password mu salah';
}
