<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Libraries\AuthLibrary;
use CodeIgniter\Log\Logger;

class JwtAuthGuard implements FilterInterface
{
    protected $authLibrary;
    protected $logger;

    public function __construct()
    {
        $this->authLibrary = new AuthLibrary();
        $this->logger = service('logger');
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        $this->logger->debug('JwtAuthGuard: Checking Authorization Header');
        $authHeader = $request->getHeader('Authorization');
        if ($authHeader) {
            $this->logger->debug('JwtAuthGuard: Authorization Header Found: ' . $authHeader->getValue());
            if (preg_match('/Bearer\s(\S+)/', $authHeader->getValue(), $matches)) {
                $token = $matches[1];
                $this->logger->debug('JwtAuthGuard: Token Found: ' . $token);
                $user = $this->authLibrary->validateToken($token);
                if ($user) {
                    $this->logger->debug('JwtAuthGuard: Token Validated, User: ' . json_encode($user));
                    $request->user = $user;
                    return;
                } else {
                    $this->logger->debug('JwtAuthGuard: Token Validation Failed');
                }
            } else {
                $this->logger->debug('JwtAuthGuard: Bearer Token Not Found');
            }
        } else {
            $this->logger->debug('JwtAuthGuard: Authorization Header Not Found');
        }

        $this->logger->debug('JwtAuthGuard: Unauthorized Access');
        return service('response')->setJSON(['error' => 'Unauthorized'])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
