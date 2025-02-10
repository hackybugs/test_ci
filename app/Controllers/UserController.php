<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use GuzzleHttp\Client;
use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;

class UserController extends ResourceController
{
    protected $format = 'json';

    public function profile($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return $this->failNotFound('User not found');
        }

        return $this->respond([
            'status' => 'success',
            'data' => $user
        ]);
    }



    // public function login()
    // {
    //     helper(['form']);

    //         $rules = [
    //             'email' => 'required|min_length[6]|max_length[100]|valid_email',
    //             'password' => 'required|min_length[8]|max_length[255]',
    //         ];

    //         if (!$this->validate($rules)) {
    //             return $this->failValidationErrors($this->validator->getErrors());
    //         }
    
    //         $userModel = new UserModel();
    //         $user = $userModel->where('email', $this->request->getPost('email'))->first();        
    //         if (!$user || !password_verify($this->request->getPost('password'), $user['password'])) {
    //             return $this->failUnauthorized('Invalid credentials');
    //         }
    //         return $this->respond([
    //             'status' => 'success',
    //             'message' => 'Login successful',
    //             'data' => [
    //                 'id' => $user['id'],
    //                 'first_name' => $user['first_name'],
    //                 'last_name' => $user['last_name'],
    //                 'email' => $user['email'],
    //                 'role' => $user['role'],
    //                 'last_login' => $user['last_login'],
    //                 'profile_image' => base_url('uploads/' . $user['profile_image'])
    //             ]
    //         ]);
    // }

    // public function dashboard()
    // {
    //     $user = session()->get('user');
    //     if (!$user) {
    //         return redirect()->to('/login');
    //     }
    //     echo view('dashboard', ['user' => $user]);
    // }
    


   
    public function updateProfile($id)
    {
        helper(['form']);
        $rules = [
            'first_name' => 'required|min_length[3]|max_length[100]',
            'last_name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email',
            'profile_picture' => 'permit_empty|uploaded[profile_picture]|is_image[profile_picture]|max_size[profile_picture,4096]',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return $this->failNotFound('User not found');
        }

        $profilePictureName = $user['profile_image']; // Keep the old image
        if ($file = $this->request->getFile('profile_picture')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $profilePictureName = $file->getRandomName();
                $file->move('uploads', $profilePictureName);
            }
        }

        $updatedData = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
            'profile_image' => $profilePictureName
        ];

        if ($this->request->getPost('password')) {
            $updatedData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $userModel->update($id, $updatedData);

        return $this->respondUpdated([
            'status' => 'success',
            'message' => 'Profile updated successfully'
        ]);
    }

    // public function search()
    // {
    //     helper(['form', 'dotenv']);
    //     $data = [];
    //     $pixabayApiKey = getenv('YOUR_PIXABAY_API_KEY');

    //     if ($this->request->getMethod() == 'POST') {
    //         $query = $this->request->getPost('query');

    //         $apiKey = $pixabayApiKey;
    //         $pixabayUrl = 'https://pixabay.com/api/?key=' . $apiKey . '&q=' . urlencode($query);

    //         try {
    //             $client = new Client();
    //             $response = $client->request('GET', $pixabayUrl);

    //             if ($response->getStatusCode() == 200) {
    //                 $results = json_decode($response->getBody(), true)['hits'];
    //                 $data['results'] = $results;
    //             } else {
    //                 // Handle HTTP error responses
    //                 $data['error'] = 'Pixabay API request failed: ' . $response->getStatusCode();
    //             }
    //         } catch (\Exception $e) {
    //             // Handle Guzzle exceptions
    //             $data['error'] = 'Pixabay API request failed: ' . $e->getMessage();
    //         }
    //     }
    //     echo view('search', $data);
    // }
}
