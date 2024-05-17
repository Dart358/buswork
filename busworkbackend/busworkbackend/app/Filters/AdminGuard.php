<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Libraries\AuthLibrary;
use App\Models\UserModel;

class AdminGuard implements FilterInterface
{
    protected $authLibrary;
    protected $userModel;

    public function __construct()
    {
        $this->authLibrary = new AuthLibrary();
        $this->userModel = new UserModel();
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeader('Authorization');
        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader->getValue(), $matches)) {
            $token = $matches[1];
            $user = $this->authLibrary->validateToken($token);
            if ($user) {
                $userData = $this->userModel->find($user['id']);
                if ($userData && $userData['role'] === 'admin') {
                    $request->user = $user;
                    return;
                }
            }
        }

        return service('response')->setJSON(['error' => 'Unauthorized'])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
