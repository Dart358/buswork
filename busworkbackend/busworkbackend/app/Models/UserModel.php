<?php

// app/Models/UserModel.php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'email', 'name', 'picture', 'role', 'password', 'created_at'];
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';

    protected $validationRules = [
        'email'    => 'required|valid_email|is_unique[users.email]',
        'name'     => 'required|string|max_length[255]',
        'password' => 'required|string|min_length[8]',
        'role'     => 'required|string|in_list[user,admin]',
    ];

    protected $validationMessages = [
        'email' => [
            'required' => 'Email is required',
            'valid_email' => 'You must provide a valid email address',
            'is_unique' => 'This email is already registered',
        ],
        'name' => [
            'required' => 'Name is required',
        ],
        'password' => [
            'required' => 'Password is required',
            'min_length' => 'Password must be at least 8 characters long',
        ],
        'role' => [
            'required' => 'Role is required',
            'in_list' => 'Role must be either "user" or "admin"',
        ],
    ];

    // Temporarily disable password hashing for testing
    // protected $beforeInsert = ['hashPassword'];
    // protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (!isset($data['data']['password'])) {
            return $data;
        }
        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        return $data;
    }
}
