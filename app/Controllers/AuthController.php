<?php
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class AuthController extends ResourceController {

    public function register()
    {
        helper(['form']);
            // Validation rules
            $rules = [
               'first_name' => 'required|min_length[3]|max_length[100]',
                'last_name' => 'required|min_length[3]|max_length[100]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[8]',
                'role' => 'required|in_list[admin,customer]',
            ];

            if (!$this->validate($rules)) {
                return $this->failValidationErrors($this->validator->getErrors());
            }
                $userModel = new UserModel();
                
                // Get file
                $file = $this->request->getFile('profile_picture');                
                $userModel = new UserModel();

                // Upload and store profile picture
                $profilePictureName = null;
                if ($file = $this->request->getFile('profile_picture')) {
                    if ($file->isValid() && !$file->hasMoved()) {
                        $profilePictureName = $file->getRandomName();
                        $file->move('uploads', $profilePictureName);
                    }
                }

            $userData = [
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role' => $this->request->getPost('role'),
                'profile_image' => $profilePictureName
            ];

        $userModel->insert($userData);

        return $this->respondCreated([
            'status' => 'success',
            'message' => 'User registered successfully'
        ]);
    }

    public function login() {
        helper('jwt_helper'); // Load JWT helper

        $userModel = new UserModel();
        $data = $this->request->getPost();
        $user = $userModel->where('email', $data['email'])->first();

        if ($user && password_verify($data['password'], $user['password'])) {
            $token = createJWT($user);
            return $this->respond(['token' => $token]);
        }

        return $this->failUnauthorized('Invalid credentials');
    }
}
