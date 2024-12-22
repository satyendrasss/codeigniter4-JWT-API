<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\JWTHandler;
use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $jwt;

    public function __construct()
    {
        $this->jwt = new JWTHandler();
    }

    public function login()
    {
        $email = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid credentials']);
        }

        $token = $this->jwt->generateToken(['id' => $user['id'], 'email' => $user['email'], 'role'=> $user['role']]);

        return $this->response->setJSON(['status' => 'success', 'token' => $token]);
    }

    public function register()
    {
        $name = 'Admin';
        $email = 'admin@gmail.com'; 
        $password = 'admin@123'; 
        $role = 'Admin';
        

        if (!$email || !$password) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Username and password are required'])->setStatusCode(400);
        }
        $userModel = new UserModel();

        if ($userModel->where('email', $email)->first()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Username already exists'])->setStatusCode(409);
        }
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        $userModel->insert([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword,
            'role' => $role
        ]);

        return $this->response->setJSON(['status' => 'success', 'message' => 'User registered successfully']);
    }

}
