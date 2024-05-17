<?php

namespace App\Libraries;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\UserModel;
use CodeIgniter\Log\Logger;

class AuthLibrary
{
    protected $userModel;
    protected $jwtKey;
    protected $logger;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->jwtKey = getenv('JWT_SECRET');
        $this->logger = service('logger');
    }

    public function createToken($email, $id)
    {
        $payload = [
            'email' => $email,
            'id' => $id,
            'iat' => time(),
            'exp' => time() + 60 * 60 * 24 * 30, // 30 days expiration
        ];
        $token = JWT::encode($payload, $this->jwtKey, 'HS256');
        $this->logger->debug('JWT Token Created: ' . $token);
        return $token;
    }

    public function validateToken($token)
    {
        try {
            $decoded = JWT::decode($token, new Key($this->jwtKey, 'HS256'));
            $this->logger->debug('JWT Token Validated: ' . json_encode($decoded));
            return (array) $decoded;
        } catch (\Exception $e) {
            $this->logger->error('JWT Validation Failed: ' . $e->getMessage());
            return null;
        }
    }

    // Other methods...



    public function getGoogleOAuthToken($code)
    {
        $url = 'https://oauth2.googleapis.com/token';
        $values = [
            'code' => $code,
            'client_id' => getenv('GOOGLE_CLIENT_ID'),
            'client_secret' => getenv('GOOGLE_SECRET'),
            'redirect_uri' => getenv('FRONTEND_URL') . '/google',
            'grant_type' => 'authorization_code',
        ];

        $response = \Config\Services::curlrequest()->post($url, [
            'form_params' => $values,
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function googleLoginCallback($code)
    {
        $data = $this->getGoogleOAuthToken($code);
        if (!$data) {
            return null;
        }

        $idToken = $data['id_token'];
        $decodedUser = JWT::decode($idToken, new Key($this->jwtKey, 'HS256'));
        $decodedUser = (array) $decodedUser;

        $token = $this->createToken($decodedUser['email'], $decodedUser['sub']);

        $user = $this->userModel->where('email', $decodedUser['email'])->first();

        if ($user) {
            return ['user' => $user, 'token' => $token];
        }

        $newUser = [
            'id' => $decodedUser['sub'],
            'email' => $decodedUser['email'],
            'name' => $decodedUser['name'],
            'picture' => $decodedUser['picture'],
        ];

        $this->userModel->insert($newUser);

        return ['user' => $newUser, 'token' => $token];
    }

    public function getCurrentUser($userId)
    {
        return $this->userModel->find($userId);
    }
}
