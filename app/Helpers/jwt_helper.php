<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if (!function_exists('createJWT')) {
    function createJWT($user)
    {
        $key = getenv('JWT_SECRET'); // Get secret key from .env
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600; // Token valid for 1 hour

        $payload = [
            'iss' => base_url(),
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'sub' => $user['id'],
            'role' => $user['role'],
        ];
        return JWT::encode($payload, $key, 'HS256');
    }
}

function validateJWT($token) {
    try {
        $decoded = JWT::decode($token, new Key(getenv('JWT_SECRET'), 'HS256'));
       // Convert object to an array
       $decodedArray = json_decode(json_encode($decoded), true);
       return $decodedArray;
    } catch (Exception $e) {
        return null;
    }

}

