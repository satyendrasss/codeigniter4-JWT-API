<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $users = $this->userModel->where('role','Customer')->findAll();
        return $this->response->setJSON(['status' => 'success', 'data' => $users]);
    }

    public function addUsesr()
    {

        $rules = [
            'name' => 'required|min_length[3]',
            'email' => 'required|min_length[3]|max_length[30]|is_unique[users.email]',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON(['status' => 'failed', 'errors' => $this->validator->getErrors()]);
        }

        $data = $this->request->getJSON();
        $this->userModel->insert($data);
        return $this->response->setJSON(['status' => 'success', 'message' => 'User added successfully.']);
    }

    public function show($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'User not found'])->setStatusCode(404);
        }
        return $this->response->setJSON(['status' => 'success', 'data' => $user]);
    }

    public function update($id)
    {
        $data = $this->request->getJSON();
        $this->userModel->update($id, $data);
        return $this->response->setJSON(['status' => 'success', 'message' => 'User updated']);
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        return $this->response->setJSON(['status' => 'success', 'message' => 'User deleted']);
    }
}
