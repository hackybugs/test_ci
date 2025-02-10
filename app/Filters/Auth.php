<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null){
     helper('jwt_helper');
    $authHeader = $request->getHeaderLine('Authorization');
    if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        return service('response')->setJSON(['message' => 'Unauthorized'])->setStatusCode(401);
    }
    $token = $matches[1];
    $user = validateJWT($token);
    if (!$user) {
        return service('response')->setJSON(['message' => 'Invalid Token'])->setStatusCode(401);
    }
    // Check if route requires specific roles
    if ($arguments) {
        $requiredRole = $arguments[0]; // Role required for this route
        if (!isset($user['role']) || $user['role'] !== $requiredRole) {
            return service('response')->setJSON(['message' => 'Access Denied'])->setStatusCode(403);
        }
    }


    return $request;

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
