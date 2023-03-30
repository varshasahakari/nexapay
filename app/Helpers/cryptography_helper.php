<?php

if (!function_exists('crypto_encrypt_data')) {
    function crypto_encrypt_data($raw_data)
    {
        $data = json_decode(json_encode($raw_data), true);
        ksort($data);
        $string_data = '';
        foreach ($data as $key => $value) {
            $string_data = crypto_append_fields($string_data, $key, $value);
        }

        $string_data_salt = $string_data . SALT;

        $hash = hash("sha256", $string_data_salt);
        $string_data_hash = $string_data . "~hash=" . $hash;

        $cipher = "aes-256-cbc";

        $iv_size = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($iv_size);

        $encrypted_data = openssl_encrypt($string_data_hash, $cipher, base64_decode(AES_ENCRYPTION_KEY), 0, base64_decode(AES_IV));
        return $encrypted_data;
    }
}

if (!function_exists('crypto_decrypt_data')) {
    function crypto_decrypt_data($data)
    {
        $aes_decrypt = openssl_decrypt($data, 'AES-256-CBC', base64_decode(AES_ENCRYPTION_KEY), 0, base64_decode(AES_IV));
        $all_fields_data = explode("~", $aes_decrypt);
        $form_data = [];
        $string_data = '';
        $hash = '';
        foreach ($all_fields_data as $index => $field_data) {
            $field = explode("=", $field_data);
            if ($field[0] == 'hash') {
                $hash = $field[1];
                continue;
            }
            $form_data[$field[0]] = $field[1];
            $string_data = crypto_append_fields($string_data, $field[0], $field[1]);
        }

        $string_data_salt = $string_data . SALT;

        $generated_hash = hash("sha256", $string_data_salt);
        if ($hash == $generated_hash) {
            return $form_data;
        }
        return false;
    }
}
if (!function_exists('crypto_append_fields')) {
    function crypto_append_fields($data, $key, $value): string
    {
        if (!empty($data)) {
            $data .= '~';
        }
        $data .= $key . "=" . $value;
        return $data;
    }
}
