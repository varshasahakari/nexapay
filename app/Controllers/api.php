<?php

namespace App\Controllers;

use App\Models\User;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;

class api extends BaseController
{
    use ResponseTrait;

    private User $user_model;

    public function __construct()
    {
        $this->user_model = new User();
        helper('cryptography');
    }

    public function register()
    {
        $request_data = $this->request->getPost();
        $data = $request_data['data'];

        $decrypted_data = crypto_decrypt_data($data);
        if (!$decrypted_data) {
            return $this->respond(crypto_encrypt_data(['error' => 'Invalid Request.']), 401);
        }

        $user_id = $this->user_model->insert($decrypted_data);
        if (!$user_id) {
            $response = [
                'message' => 'Error occured',
                'status' => 500,
                 'error' => implode(", ", $this->user_model->errors())
            ];
            return $this->respond(crypto_encrypt_data($response), 400);
        }
        $response = [
            'message' => 'Succesful',
            'status' => 200,
        ];

        return $this->respond(crypto_encrypt_data($response), 200);
    }

    public function login()
    {
        $request_data = $this->request->getPost();
        $data = $request_data['data'];

        $decrypted_data = crypto_decrypt_data($data);
        if (!$decrypted_data) {
            return $this->respond(crypto_encrypt_data(['message' => 'Invalid Request.']), 401);
        }

        $username = $decrypted_data['username'];
        $password = $decrypted_data['password'];

        $user = $this->user_model->where('username', $username)->first();

        if (is_null($user)) {
            $encrypted_response = crypto_encrypt_data(['message' => 'Invalid username or password.']);
            return $this->respond($encrypted_response, 401);
        }

        $pwd_verify = password_verify($password, $user['password']);

        if (!$pwd_verify) {
            $encrypted_response = crypto_encrypt_data(['message' => 'Invalid username or password.', 'status' => 400]);
            return $this->respond($encrypted_response, 400);
        }

        $key = getenv('JWT_SECRET');
        $iat = time(); // current timestamp value
        $exp = $iat + 3600;

        $payload = array(
            "iss" => "Issuer of the JWT",
            "aud" => "Audience that the JWT",
            "sub" => "Subject of the JWT",
            "iat" => $iat, //Time the JWT issued at
            "exp" => $exp, // Expiration time of token
            "username" => $user['username'],
        );

        $token = JWT::encode($payload, $key, 'HS256');

        $response = [
            'message' => 'Login Succesful',
            'status' => 200,
            'token' => $token
        ];

        $encrypted_response = crypto_encrypt_data($response);

        return $this->respond($encrypted_response, 200);
    }
}
