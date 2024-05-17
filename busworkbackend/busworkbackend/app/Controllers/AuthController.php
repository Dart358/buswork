<?php

// app/Controllers/AuthController.php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Libraries\AuthLibrary;
use App\Models\UserModel;

class AuthController extends ResourceController
{
    protected $authLibrary;

    public function __construct()
    {
        $this->authLibrary = new AuthLibrary();
    }

    public function login()
    {
        $userModel = new UserModel();
        $data = $this->request->getJSON(true);

        log_message('debug', 'Login Request Data: ' . json_encode($data));

        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        log_message('debug', 'Email: ' . $email . ', Password: ' . $password);

        $user = $userModel->where('email', $email)->first();

        log_message('debug', 'User Fetched: ' . json_encode($user));

        if (!$user) {
            log_message('debug', 'User not found');
            return $this->failUnauthorized('Invalid login credentials.');
        }

        if ($password !== $user['password']) {
            log_message('debug', 'Password Verification Failed');
            return $this->failUnauthorized('Invalid login credentials.');
        }

        $token = $this->authLibrary->createToken($user['email'], $user['id']);
        log_message('debug', 'Token Created: ' . $token);
        return $this->respond(['token' => $token, 'user' => $user]);
    }

    public function register()
    {
        $userModel = new UserModel();
        $data = $this->request->getJSON(true);

        log_message('debug', 'Register Request Data: ' . json_encode($data));

        if (!isset($data['password'])) {
            return $this->failValidationErrors(['password' => 'The password field is required.']);
        }

        if (!isset($data['role'])) {
            return $this->failValidationErrors(['role' => 'The role field is required.']);
        }

        // Ensure the role is set and is either 'user' or 'admin'
        $data['role'] = $data['role'];
        if (!in_array($data['role'], ['user', 'admin'])) {
            return $this->failValidationErrors(['role' => 'Invalid role specified.']);
        }

        $data['id'] = uniqid();
        $data['password'] = $data['password']; // Ensure password is plain text for now

        log_message('debug', 'Password set to plaintext: ' . $data['password']);
        log_message('debug', 'Role set to: ' . $data['role']);

        if ($userModel->insert($data)) {
            $storedUser = $userModel->where('email', $data['email'])->first();
            log_message('debug', 'Stored User After Insertion: ' . json_encode($storedUser));
            return $this->respondCreated($data);
        } else {
            return $this->failValidationErrors($userModel->errors());
        }
    }

    public function googleAuthRedirect()
    {
        $code = $this->request->getPost('code');
        $result = $this->authLibrary->googleLoginCallback($code);

        if (!$result) {
            return $this->failUnauthorized('Google authentication failed.');
        }

        return $this->respondCreated($result);
    }

    public function logout()
    {
        $this->response->deleteCookie('jwt');
        return $this->respond(['message' => 'Successfully logged out.']);
    }

    public function me()
    {
        $user = $this->request->user;
        if (!$user) {
            return $this->failUnauthorized('You are not logged in.');
        }

        $currentUser = $this->authLibrary->getCurrentUser($user['id']);
        return $this->respond($currentUser);
    }

    public function updateRole()
    {
        $userModel = new UserModel();
        $data = $this->request->getJSON(true);

        log_message('debug', 'Update Role Request Data: ' . json_encode($data));

        $email = $data['email'] ?? '';
        $role = $data['role'] ?? '';

        if (!$email || !$role) {
            log_message('debug', 'Missing email or role');
            return $this->fail('Email and role are required', 400);
        }

        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            log_message('debug', 'User not found');
            return $this->failNotFound('User not found');
        }

        $user['role'] = $role;

        if ($userModel->save($user)) {
            log_message('debug', 'User Role Updated: ' . json_encode($user));
            return $this->respond(['message' => 'Role updated successfully']);
        } else {
            return $this->failValidationErrors($userModel->errors());
        }
    }
}
